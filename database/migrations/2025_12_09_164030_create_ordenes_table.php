<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->foreignId('mecanico_id')->constrained('mecanicos');
            $table->dateTime('fecha_ingreso');
            $table->dateTime('fecha_estimada_entrega');
            $table->dateTime('fecha_salida')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'finalizada', 'cancelada'])->default('pendiente');
            $table->text('descripcion_problema');
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->decimal('costo_final', 10, 2)->nullable();
            $table->timestamps();

            // Opcional: índices útiles
            $table->index(['vehiculo_id', 'estado']);
            $table->index(['mecanico_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
