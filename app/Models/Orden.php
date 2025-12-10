<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HistorialTrabajo;


class Orden extends Model
{
    use HasFactory;

    // 👇 ESTA LÍNEA ES LA CLAVE
    protected $table = 'ordenes';

    protected $fillable = [
        'vehiculo_id',
        'mecanico_id',
        'fecha_ingreso',
        'fecha_estimada_entrega',
        'fecha_salida',
        'estado',
        'descripcion_problema',
        'costo_estimado',
        'costo_final',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_estimada_entrega' => 'datetime',
        'fecha_salida' => 'datetime',
        'costo_estimado' => 'decimal:2',
        'costo_final' => 'decimal:2',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function mecanico()
    {
        return $this->belongsTo(Mecanico::class);
    }

    public function repuestos()
{
    return $this->belongsToMany(Repuesto::class, 'orden_repuesto')
        ->withPivot(['id', 'cantidad', 'subtotal'])
        ->withTimestamps();
}


public function historialTrabajos()
{
    return $this->hasMany(HistorialTrabajo::class);
}


public function esActiva(): bool
{
    return in_array($this->estado, ['pendiente', 'en_proceso']);
}

}
