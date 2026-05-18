<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'id_pengguna', 'id_pengguna');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_pengguna', 'id_pengguna');
    }
}
