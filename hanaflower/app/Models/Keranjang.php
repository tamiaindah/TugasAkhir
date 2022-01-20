<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id', 'customer_id', 'qty', 'harga'
    ];

    /**many ke keranjang dari produk */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    /**many ke keranjang dari cust */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
