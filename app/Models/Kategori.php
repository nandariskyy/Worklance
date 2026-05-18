<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $guarded = [];

    public function jasas()
    {
        return $this->hasMany(Jasa::class, 'id_kategori', 'id_kategori');
    }
}
