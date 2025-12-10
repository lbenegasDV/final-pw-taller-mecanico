<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes')->onDelete('cascade');
            $table->foreignId('mecanico_id')->constrained('mecanicos');
            $table->text('descripcion');
            $table->decimal('horas_trabajadas', 5, 2);
            $table->date('fecha');
            $table->timestamps();

            $table->index(['orden_id', 'mecanico_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_trabajos');
    }
};
