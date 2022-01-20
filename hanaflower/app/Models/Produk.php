<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */

    /**ini ngijinin isi table dari database nya */
    protected $fillable = [
        'foto', 'nama', 'slug', 'kategori_id', 'konten', 'berat', 'warna', 'harga', 'diskon'
    ];

    /**buat ngijinin nampilin gambar */
    public function getImageAttribute($foto)
    {
        return asset('storage/produks'.$foto);
    }

    /**relasi many ke produk dari kategori*/
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**one to many PRODUK ke keranjang */
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }
}
