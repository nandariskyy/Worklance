<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false;
    protected $guarded = [];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class, 'id_jasa', 'id_jasa');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_layanan', 'id_layanan');
    }

    public function ulasans()
    {
        // Since ulasan is linked to booking, and booking to layanan
        return $this->hasManyThrough(Ulasan::class, Booking::class, 'id_layanan', 'id_booking', 'id_layanan', 'id_booking');
    }
}
