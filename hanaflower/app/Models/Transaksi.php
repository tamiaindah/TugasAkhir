<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi', 'customer_id', 'kurir', 'service', 'ongkir', 'berat', 'nama', 'no_hp', 'provinsi', 'kota', 'alamat',
        'status', 'total', 'snap_token'
    ];

    /**one to many transaksi ke order */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**many ke transaksi dari cust */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}