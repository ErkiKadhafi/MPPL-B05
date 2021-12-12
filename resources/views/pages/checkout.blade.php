@php
$data = session()->get('data');
$totalHarga = 0;
@endphp

{{-- ========================================================================
    REDIRECT TO CART IF DATA IS EMPTY
======================================================================== --}}
@if (!isset($data) || !$data->count())
    <script>
        window.location = "/cart";
    </script>
    <?php exit(); ?>
@endif
<x-layout titlePage="Hanaka | Cart">
    {{-- ======== PAGE IMPORTS ======== --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <h2 class="text-3xl font-bold text-gray-900 text-center mt-8">Checkout Pesanan</h2>
    <div class="grid grid-cols-8 gap-x-8 mx-8 mt-4 my-6">
        {{-- form section --}}
        <div class="col-span-8 lg:col-span-5 shadow-custom1 px-5 py-4 rounded-lg">
            <form action="{{ route('post_pembayaran') }}" method="POST" id="form-pembayaran">
                @csrf
                <div class="flex flex-col space-y-3">
                    <div class="flex flex-col space-y-1">
                        <label for="nama" class="col-span-3">Nama Penerima</label>
                        <input type="text"
                            class="col-span-9 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Erki Khadafi Rosyid" name="nama_penerima" id="nama" required maxlength="100">
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="alamat" class="col-span-3">Alamat</label>
                        <input type="text"
                            class="col-span-9 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Jl. Paguyuban II, No.14" name="alamat" id="alamat" required minlength="5"
                            maxlength="200">
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="provinsi">Provinsi</label>
                        <select class="select2-data-array browser-default" id="select2-provinsi"
                            name="provinsi"></select>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="kota_kab">Kota/Kabupaten</label>
                        <select class="select2-basic select2-data-array browser-default" id="select2-kabupaten"
                            name="kota_kab">
                            <option value="">{{ '- Silahkan Pilih Provinsi -' }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="kecamatan">Kecamatan</label>
                        <select class="select2-basic select2-data-array browser-default" id="select2-kecamatan"
                            name="kecamatan">
                            <option value="">{{ '- Silahkan Pilih Provinsi -' }}</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-12 gap-10">
                        <div class="col-span-3 flex flex-col space-y-1">
                            <label for="kode_pos" class="col-span-3">Kode Pos</label>
                            <input type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="17115" name="kode_pos" id="kode_pos" required minlength="5" maxlength="5">
                        </div>
                        <div class="col-span-9 flex flex-col space-y-1">
                            <label for="no_telp" class="col-span-3">Nomor Telepon</label>
                            <div class="flex">
                                <span
                                    class="flex items-center bg-grey-lighter rounded rounded-r-none border border-r-0 border-gray-300 px-3 text-grey-dark text-sm">+62</span>
                                <input type="text"
                                    class="w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="81234567891" name="no_telepon" id="no_telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="metode">Metode Pembayaran</label>
                        <select
                            class="select2-basic w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="metode" id="metode-select" onchange="updatePath()">
                            <option value="va">Transfer Virtual Account</option>
                            <option value="bank">Transfer Bank</option>
                        </select>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="metode">Catatan Pemesanan (opsional)</label>
                        <textarea
                            class="col-span-9 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="catatan_pengiriman" id="catatan_pengiriman" cols="30" rows="5"
                            style="resize: none"></textarea>
                    </div>
                    <div class="flex">
                        <button type="submit" id="bayar-button-bank" style="display: none"
                            class="relative w-full bg-gray-800 hover:bg-opacity-90 rounded-lg p-2 mt-4 font-semibold text-white text-center"
                            id="bayarBtn-bank">
                            Bayar
                        </button>
                        <button type="button" id="bayar-button-va" data-micromodal-trigger="pilih-va"
                            class="relative w-full bg-gray-800 hover:bg-opacity-90 rounded-lg p-2 mt-4 font-semibold text-white text-center">
                            Bayar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        {{-- total price --}}
        <div class="col-span-8 lg:col-span-3 mt-8 lg:mt-0">
            <div class="rounded-lg shadow-custom1 p-4">
                <p class="font-semibold px-4">Detail Pesanan</p>
                <hr class="mt-3 mb-2 px-4 border-gray-800">
                <div class="flex px-4 bg-gray-300 py-1 font-bold">
                    <p class="">Nama Produk</p>
                    <p class="ml-auto">Subtotal</p>
                </div>
                @foreach ($data as $item)
                    @php
                        $totalHarga += $item->barang->harga * $item->jumlah;
                    @endphp
                    <div class="flex px-4">
                        <p class="text-gray-400">{{ $item->barang->nama }}</p>
                        <p class="text-gray-400 ml-auto">
                            Rp{{ number_format($item->barang->harga * $item->jumlah * 1000, 0, ',', '.') }}</p>
                    </div>
                @endforeach
                {{-- @for ($i = 0; $i < 2; $i++)
                @endfor --}}
                <hr class="my-2 border-gray-800">
                <div class="flex font-bold px-4">
                    <p class="">Subtotal Produk</p>
                    <p class="ml-auto">Rp{{ number_format($totalHarga * 1000, 0, ',', '.') }}</p>
                </div>
                <div class="flex font-bold px-4">
                    <p class="">Ongkos Kirim</p>
                    <p class="ml-auto">Rp10.000</p>
                </div>
                <hr class="my-2 border-gray-800">
                <div class="flex font-bold px-4">
                    <p class="">Total</p>
                    <p class="ml-auto" id="total-harga">
                        Rp{{ number_format($totalHarga * 1000 + 10000, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================================
        PILIH VIRTUAL ACCOUNT MODAL
    ======================================================================== --}}
    <div class="modal micromodal-slide" id="pilih-va" aria-hidden="true">
        <div class="modal__overlay" data-micromodal-close>
            <div class="modal__container h-52 w-6/12" role="dialog" aria-modal="true" aria-labelledby="pilih-va-title"
                style="height: 30rem; max-width: 45rem; display: flex; flex-direction: column; justify-content: space-between; margin: 0 1rem;">
                <div>
                    <header class="modal__header border-b-2 pb-1">
                        <h2 class="modal__title text-center text-xl" id="pilih-va-title">
                            Pembayaran via Virtual Account
                        </h2>
                    </header>
                    <main class="modal__content mt-3" id="pilih-va-content">
                        <div class="mx-auto">
                            <div class="flex justify-between">
                                <p class="text-lg">Total Nominal Transfer</p>
                                <p class="text-lg" id="total-transfer">
                                    Rp{{ number_format($totalHarga * 1000 + 10000, 0, ',', '.') }}</p>
                            </div>
                            <hr class="my-2">
                        </div>
                        <div class="mx-auto">
                            <label class="flex flex-col" for="va-bank-select">
                                Pilih Virtual Account
                                <select
                                    class="select2-basic w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="va-bank-select" id="va-bank-select">
                                    <option value="va_bca">🏧 Bank BCA</option>
                                    <option value="va_bni">🏧 Bank BNI</option>
                                    <option value="va_mandiri">🏧 Bank Mandiri</option>
                                </select>
                            </label>
                        </div>
                    </main>
                </div>
                <footer class="flex justify-end">
                    <button type="submit"
                        class="bg-gray-700 text-white shadow-md hover:shadow-lg rounded-full px-4 py-1"
                        id="bayarBtn-va">Bayar</button>
                </footer>
            </div>
        </div>
    </div>

    <script>
        let sites = {!! json_encode($data->toArray(), JSON_HEX_TAG) !!}
        console.log(sites)
        $(document).ready(function() {
            $('.select2-basic').select2({
                minimumResultsForSearch: Infinity
            });
        });

        /* ========================================================================
            BAYAR BUTTON FUNCTIONS
        ======================================================================== */
        const updatePath = () => {
            console.log()
            if ($("#metode-select").val() == "va") {
                $("#bayar-button-bank").hide();
                $("#bayar-button-va").show();
            } else {
                $("#bayar-button-va").hide();
                $("#bayar-button-bank").show();
            }
            MicroModal.init({
                awaitCloseAnimation: true,
                disableFocus: true,
            });
        }

        $('#form-pembayaran').submit(function() {
            $('<input>').attr({
                type: 'hidden',
                name: 'total_pembayaran',
                value: $('#total-harga').html()
            }).appendTo(this);
        });

        $('#bayarBtn-va').click(function(e) {
            $('<input>').attr({
                type: 'hidden',
                name: 'va-bank-select',
                value: $('#va-bank-select').val()
            }).appendTo('#form-pembayaran');
            $('#form-pembayaran').submit();
        });

        $("#bayar-button-va").click(function(e) {
            $('#total-transfer').html($('#total-harga').html());
        });

        $("#bayarBtn-va").click(function(e) {
            $('#form-va').submit();
        });

        /* ========================================================================
            START ::: DATA PROVINSI, KABUPATEN, dan KECAMATAN FETCHING
        ======================================================================== */
        let urlProvinsi = "https://ibnux.github.io/data-indonesia/provinsi.json";
        let urlKabupaten = "https://ibnux.github.io/data-indonesia/kabupaten/";
        let urlKecamatan = "https://ibnux.github.io/data-indonesia/kecamatan/";
        let urlKelurahan = "https://ibnux.github.io/data-indonesia/kelurahan/";

        function clearOptions(id) {
            console.log("on clearOptions");

            //$('#' + id).val(null);
            $('#' + id).empty().trigger('change');
        }

        console.log('Load Provinsi...');
        $.getJSON(urlProvinsi, function(res) {

            res = $.map(res, function(obj) {
                obj.text = obj.nama
                return obj;
            });

            data = [{
                id: "",
                nama: "- Pilih Provinsi -",
                text: "- Pilih Provinsi -"
            }].concat(res);

            $("#select2-provinsi").select2({
                dropdownAutoWidth: true,
                width: '100%',
                data: data
            })
        });

        let selectProv = $('#select2-provinsi');
        $(selectProv).change(function() {
            console.log("on change selectProv");

            let value = $(selectProv).val();
            let text = $('#select2-provinsi :selected').text();
            console.log("value = " + value + " / " + "text = " + text);

            clearOptions('select2-kabupaten');
            console.log('Load Kabupaten di ' + text + '...')
            $.getJSON(urlKabupaten + value + ".json", function(res) {

                res = $.map(res, function(obj) {
                    obj.text = obj.nama
                    return obj;
                });

                data = [{
                    id: "",
                    nama: "- Pilih Kabupaten -",
                    text: "- Pilih Kabupaten -"
                }].concat(res);

                $("#select2-kabupaten").select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    data: data
                })
                $("#select2-kecamatan").select2({
                    data: [{
                        id: "",
                        text: "- Silahkan Pilih Kabupaten -"
                    }]
                });
            })
        });

        let selectKab = $('#select2-kabupaten');
        $(selectKab).change(function() {
            console.log("on change selectKab");

            let value = $(selectKab).val();
            let text = $('#select2-kabupaten :selected').text();
            console.log("value = " + value + " / " + "text = " + text);

            clearOptions('select2-kecamatan');
            console.log('Load Kecamatan di ' + text + '...')
            $.getJSON(urlKecamatan + value + ".json", function(res) {

                res = $.map(res, function(obj) {
                    obj.text = obj.nama
                    return obj;
                });

                data = [{
                    id: "",
                    nama: "- Pilih Kecamatan -",
                    text: "- Pilih Kecamatan -"
                }].concat(res);

                $("#select2-kecamatan").select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    data: data
                })
            })
        });

        let selectKec = $('#select2-kecamatan');
        $(selectKec).change(function() {
            console.log("on change selectKec");

            let value = $(selectKec).val();
            let text = $('#select2-kecamatan :selected').text();
            console.log("value = " + text + " / " + "text = " + text);

            clearOptions('select2-kelurahan');
            console.log('Load Kelurahan di ' + text + '...')
            $.getJSON(urlKelurahan + text + ".json", function(res) {

                res = $.map(res, function(obj) {
                    obj.text = obj.nama
                    return obj;
                });

                data = [{
                    id: "",
                    nama: "- Pilih Kelurahan -",
                    text: "- Pilih Kelurahan -"
                }].concat(res);

                $("#select2-kelurahan").select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    data: data
                })
            })
        });
        /* ========================================================================
            END ::: DATA PROVINSI, KABUPATEN, dan KECAMATAN FETCHING
        ======================================================================== */
    </script>
</x-layout>
