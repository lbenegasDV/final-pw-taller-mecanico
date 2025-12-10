<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanico extends Model
{
    use HasFactory;

    // Aseguramos el nombre de la tabla, por si acaso
    protected $table = 'mecanicos';

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'email',
        'especialidad',
        'telefono',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }

    public function historialTrabajos()
    {
        return $this->hasMany(HistorialTrabajo::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
