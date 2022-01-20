<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    /**ini ngijinin isi table dari database nya */
    protected $fillable = [
        'provinsi_id', 'kota_id', 'nama'
    ];
}
