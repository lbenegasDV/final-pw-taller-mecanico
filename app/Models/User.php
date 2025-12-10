<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol', // admin, recepcionista, mecanico
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ========= RELACIONES =========

    public function mecanico()
    {
        // Un usuario (rol mecanico) tiene un registro asociado en la tabla mecanicos
        return $this->hasOne(Mecanico::class);
    }

    // ========= HELPERS DE ROL =========

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esRecepcionista(): bool
    {
        return $this->rol === 'recepcionista';
    }

    public function esMecanico(): bool
    {
        return $this->rol === 'mecanico';
    }
}
