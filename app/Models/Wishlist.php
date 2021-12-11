<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';
    // protected $primaryKey = ['barang_id', 'user_id'];
    protected $fillable = ['barang_id', 'user_id', 'created_at'];
    public $timestamps = ["created_at"]; //only want to used created_at column
    const UPDATED_AT = null; //and updated by default null set

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
