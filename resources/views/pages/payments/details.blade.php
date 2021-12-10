@php
$count = 2;
$price = 2000000;
$ongkir = 15000;
$kode_unik = 67;
@endphp

<x-layout titlePage="Hanaka | Payment">
    <div class="mx-4 md:mx-0">
        {{-- title  --}}
        <div class="w-full md:w-10/12 mx-auto text-center mb-4">
            <h2 class="text-2xl mt-8 mb-4 font-bold">Detail Pesanan</h2>
        </div>
        {{-- header details  --}}
        <div class="shadow-custom1 rounded-lg w-full md:w-10/12 mx-auto mb-8 p-6">
            <p class="text-center">
                Pesanan ini <strong>belum dibayar</strong> dan akan secara otomatis dibatalkan pada <strong>31-12-2021
                    23:59</strong>.
            </p>
            <hr class="my-2">
            <div class="flex justify-around w-full mx-auto text-center">
                <a data-micromodal-trigger="instruksi-pembayaran" class="cursor-pointer rounded-lg p-2 w-5/12 text-white bg-gray-800 hover:bg-gray-900">
                    Instruksi Pembayaran
                </a>
                {{-- ========================================================================
                    TODO ::: UBAH ROUTE INI JADI KE DETAIL TRANSAKSI
                ======================================================================== --}}
                <a data-micromodal-trigger="form-upload-pembayaran" class="cursor-pointer rounded-lg p-2 w-5/12 text-white bg-gray-800 hover:bg-gray-900">
                    Unggah Bukti Transfer
                </a>
            </div>
        </div>
        {{-- body details  --}}
        <div class="shadow-custom1 rounded-lg w-full md:w-10/12 mx-auto mb-8 p-6">
            <div class="md:w-11/12 mx-auto">
                {{-- ========================================================================
                    TODO ::: FETCH INI DARI DATABASE
                ======================================================================== --}}
                <div class="flex justify-between">
                    <p class="font-bold">Nomor Pesanan</p>
                    <p class="font-bold">A001</p>
                </div>
                <hr class="my-2">
                <div class="flex justify-between">
                    <p>Status Pesanan</p>
                    <p>Belum Dibayar</p>
                </div>
                <hr class="my-2">
                <div class="flex justify-between">
                    <p>Metode Pembayaran</p>
                    <p>Transfer Bank</p>
                </div>
                <hr class="my-2">
                <div class="flex justify-between">
                    <p>Waktu Pemesanan</p>
                    <p>29-12-2021 23:59</p>
                </div>
                <hr class="my-2">
                <div class="flex justify-between">
                    <p class="text-lg">Alamat Pengiriman</p>
                </div>
                <hr class="my-2">
                <div class="shadow-custom1 rounded-lg p-4 mb-4">
                    <p>Michael Alexander</p>
                    <p>(+62) 812-3456-7890</p>
                    <p>Jl. Banyuwangi No. 10 Abiansemal, MENGWI, KABUPATEN BADUNG, BALI, 18990</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-lg">Pesanan</p>
                </div>
                <hr class="my-2">
                @for ($i = 0; $i < 2; $i++)
                    <div class="mb-4">
                        <div class="flex content-center items-center space-x-4 rounded-lg shadow-custom1 p-4">
                            <div class="payment-detail-item-image-container rounded-lg"
                                style="background-image: url({{ asset('images/IMG_7800.jpg') }}); background-size: cover; backround-repeat: none">
                            </div>
                            <div class="flex flex-col flex-grow h-full">
                                <div>
                                    <h4 class="font-semibold">Baju baru ni</h4>
                                    <p class="">{{ $count }} x
                                        Rp{{ number_format($price, 2, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-end items-center mt-auto">
                                    <p class="">{{ number_format($count * $price, 2, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="flex justify-between w-full md:w-11/12 mx-auto mt-4 font-bold">
                <p class="font-bold text-lg">Total Pesanan</p>
                <p class="font-bold text-lg">
                    Rp{{ number_format($count * 2 * $price + $ongkir + $kode_unik, 2, ',', '.') }}</p>
            </div>
            <hr class="my-2 w-full md:w-11/12 mx-auto">

            {{-- ======== SUMMARY BELANJA ======== --}}
            <div class="shadow-custom1 rounded-lg w-full md:w-11/12 mx-auto mb-8 p-6">
                <div class="mx-auto">
                    <div class="flex justify-between">
                        <p>Subtotal Produk</p>
                        <p>Rp{{ number_format($count * 2 * $price, 2, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Ongkos Pengiriman</p>
                        <p>Rp{{ number_format($ongkir, 2, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Kode Unik</p>
                        <p>Rp{{ number_format($kode_unik, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-center gap-8 w-full md:w-10/12 mx-auto text-center">
                <a href="{{ route('payment-invoice') }}" class="flex items-center justify-center rounded-lg p-2 w-4/12 text-white bg-gray-800 hover:bg-gray-900">
                    Cetak Invoice
                </a>
                {{-- ========================================================================
                    TODO ::: UBAH ROUTE INI JADI KE DETAIL TRANSAKSI
                ======================================================================== --}}
                <button id="batalkan-btn" class="rounded-lg p-2 w-4/12 text-white bg-red-600 hover:bg-red-700">
                    Batalkan Transaksi
                </button>
            </div>
        </div>
    </div>
    
    {{-- ======== Modal Instruksi Pembayaran ======== --}}
    <div class="modal micromodal-slide" id="instruksi-pembayaran" aria-hidden="true">
        <div class="modal__overlay" data-micromodal-close>
        <div class="modal__container" role="dialog" 
            aria-modal="true" aria-labelledby="edit-barang-title"
            style="width: 55rem; display: flex; 
                    flex-direction: column; justify-content: space-between; margin: 0 1rem;">
            <div>
                <header class="modal__header border-b-2 pb-1">
                    <h2 class="modal__title text-center" id="edit-barang-title" style="font-size: 1.8rem">
                        Pembayaran via ATM BNI
                    </h2>
                </header>
                <main class="modal__content mt-3" id="edit-barang-content">
                    <ol class="list-decimal flex flex-col space-y-3 px-5 font-semibold">
                        <li> 
                            <span>
                                Transfer melalui ATM, teller bank, aplikasi mobile banking, atau internet banking sejumlah tepat Rp975.067 ke nomor rekening berikut:
                            </span>
                            <ul class="list-disc pl-8">
                                <li>Pilih Bahasa.</li>
                                <li>Masukkan PIN ATM Anda.</li>
                                <li>Pilih "Menu Lainnya".</li>
                            </ul>
                        </li>
                        <li>Simpan bukti transaksi, lalu unggah melalui menu ‘Unggah Bukti Transfer’.</li>
                        <li>Isi data sesuai rekening yang Anda gunakan saat melakukan transfer. 
                            Jika Anda melakukan transfer melalui teller bank, isi ‘0000’ pada kolom nomor rekening, dan nama Anda pada kolom nama pemilik rekening.</li>
                    </ol>
                </main>
                <footer class="modal__footer flex justify-end">
                    <button class="bg-gray-700 text-white shadow-md hover:shadow-lg rounded-lg px-4 py-1  edit-submit-btn" data-micromodal-close>Tutup</button>
                </footer>
            </div>
        </div>
        </div>
    </div>
    {{-- ======== Modal Upload Pembayaran ======== --}}
    <div class="modal micromodal-slide" id="form-upload-pembayaran" aria-hidden="true">
        <div class="modal__overlay" data-micromodal-close>
        <div class="modal__container" role="dialog" 
            aria-modal="true" aria-labelledby="edit-barang-title"
            style="width: 55rem; display: flex; 
                    flex-direction: column; justify-content: space-between; margin: 0 1rem;">
            <div>
                <header class="modal__header border-b-2 pb-1">
                    <h2 class="modal__title text-center" id="edit-barang-title" style="font-size: 1.8rem">
                       Unggah Bukti Transfer
                    </h2>
                </header>
                <main class="modal__content mt-3" id="edit-barang-content">
                    <div class="flex justify-between font-bold">
                        <p>Nomor Pesanan</p>
                        <p>A001</p>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-bold">
                        <p>Total Pesanan</p>
                        <p>Rp{{ number_format($count * 2 * $price + $ongkir + $kode_unik, 2, ',', '.') }}</p>
                    </div>
                    <hr class="mt-2 mb-8">
                    {{-- ========================================================================
                        TODO ::: GANTI ROUTE JADI POST TRANSAKSI
                    ======================================================================== --}}
                    <form action="{{ route('admin.barang.edit') }}" method="post" id="formEditBarang" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="flex flex-col space-y-8">
                            <div class="grid grid-cols-12">
                                <label for="nama_pengguna" class="col-span-3">Nama Pemilik Rekening</label>
                                <input type="text"
                                    class="col-span-9 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Michael Alexander" name="nama" id="nama_pengguna" required maxlength="100">
                            </div>
                            <div class="grid grid-cols-12">
                                <label for="harga" class="col-span-3">Nama Bank</label>
                                <div class="flex col-span-9">
                                    <select
                                        class="select2-basic w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        name="va-bank-select" id="va-bank-select">
                                        <option value="bca">🏧 Bank BCA</option>
                                        <option value="bni">🏧 Bank BNI</option>
                                        <option value="mandiri">🏧 Bank Mandiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-12">
                                <label for="no_rekening" class="col-span-3">Nomor Rekening</label>
                                <div class="flex col-span-9">
                                    <input type="number" 
                                        class="w-full  rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="081234567891" name="no_rekening" id="no_rekening" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-12">
                                <p class="col-span-3">Unggah Foto</p>
                                <div class="col-span-9">
                                    <div class="flex flex-col space-y-4">
                                        <div>
                                            <label class="w-32 bg-gray-700 text-regular text-white shadow-md hover:shadow-lg rounded-md px-4 py-1 custom-file-upload cursor-pointer" style="text-align: center;">
                                                Unggah Gambar
                                                <input accept=".png, .jpg, .jpeg" type="file" style="display: none;" multiple name="foto[]" id="foto_edit"/>
                                            </label>
                                        </div>
                                        <span class="text-md">Harus berupa file gambar dengan ekstensi .jpg, .jpeg, atau .png</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex mt-12 space-x-4 justify-end">
                                <button data-micromodal-close class="shadow-custom1 rounded-lg px-4 py-1">
                                    <span class="font-semibold text-center">Batalkan</span>
                                </button>
                                <button type="submit" class="bg-gray-700 text-white shadow-md hover:shadow-lg rounded-lg px-4 py-1  edit-submit-btn">Kirim</button>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#batalkan-btn").click(function() {
                Swal.fire({
                    title: 'Batalkan Transaksi',
                    text: 'Apakah anda yakin akan membatalkan transaksi ini?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Transaksi Berhasil  Dibatalkan',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                });
            })
        })
    </script>
</x-layout>
