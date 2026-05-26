<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarLayanan extends Model
{
    protected $table = 'gambar_layanan';
    protected $primaryKey = 'id_gambar';
    public $timestamps = false;
    protected $fillable = [
    'id_layanan',
    'file_gambar'
    ];
}
