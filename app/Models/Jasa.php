<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    protected $table = 'jasa';
    protected $primaryKey = 'id_jasa';
    public $timestamps = false;
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function layanans()
    {
        return $this->hasMany(Layanan::class, 'id_jasa', 'id_jasa');
    }
}
