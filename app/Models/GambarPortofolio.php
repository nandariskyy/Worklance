<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarPortofolio extends Model
{
    protected $table = 'gambar_portofolio';
    protected $primaryKey = 'id_gambar';
    public $timestamps = false;
    protected $fillable = [
    'id_layanan',
    'file_gambar'
    ];
}
