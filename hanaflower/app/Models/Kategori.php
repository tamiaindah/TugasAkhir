<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'slug', 'foto'
    ];

    public function getImageAttribute($foto)
    {
        return asset('storage/kategoris'.$foto);
    }

    /**one to many kategori ke produk */
    public function produks()
    {
        return $this->hasMany (Produk::class);
    }
}
