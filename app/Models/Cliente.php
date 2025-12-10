<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'direccion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
