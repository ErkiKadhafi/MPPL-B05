<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = ['user_id', 'status_pembayaran', 'metode', 'bukti', 'tanggal', 'nama_pemilik_rekening', 'nama_bank', 'no_rekening', 'total_pembayaran', 'status_pengiriman', 'no_resi', 'catatan_pengiriman', 'asuransi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}