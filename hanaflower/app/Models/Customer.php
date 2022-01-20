<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject; // <-- import JWTSubject
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject //buat nambahin function 
{
    use HasFactory;

    /**ini ngijinin smua proses manipulasi data dari isi table dari database nya */
    protected $fillable = [
        'nama', 'email', 'password'
    ];

    /**buat security, di hide biar aman */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**one to many cust ke transaksi */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**one to many cust ke keranjang */
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    /**ambil JWTIdentifier */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**ambil JWT CustomClaims */
    public function getJWTCustomClaims()
    {
        return[];
    }
}