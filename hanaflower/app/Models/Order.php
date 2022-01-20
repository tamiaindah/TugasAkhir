<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id', 'invoice', 'produk_id', 'nama_produk', 'foto', 'qty', 'harga'
    ];

    /**many ke order dari transaksi */
    public function transaksi()
    {
        return $this->belongsTo (Transaksi::class);
    }
}
