<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTrabajo extends Model
{
    use HasFactory;

    // Nombre de la tabla (ajustá si tu migración usa otro)
    protected $table = 'historial_trabajos';

    protected $fillable = [
        'orden_id',
        'mecanico_id',
        'descripcion',
        'horas_trabajadas',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
        'horas_trabajadas' => 'decimal:1',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }
}
