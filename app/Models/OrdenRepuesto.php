<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenRepuesto extends Model
{
    use HasFactory;

    protected $table = 'orden_repuesto';

    protected $fillable = [
        'orden_id',
        'repuesto_id',
        'cantidad',
        'subtotal',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }
}
