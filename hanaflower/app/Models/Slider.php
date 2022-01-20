<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    /**ini ngijinin isi table dari database nya */
    protected $fillable = [
        'foto', 'link'
    ];

    /**buat ngijinin nampilin gambar */
    public function getImageAttribute($foto)
    {
        return asset('storage/sliders'.$foto);
    }
}
