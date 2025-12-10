<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'marca',
        'codigo_interno',
        'precio',
        'stock',
        'tipo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'orden_repuesto')
            ->withPivot(['id', 'cantidad', 'subtotal'])
            ->withTimestamps();
    }
}
