<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_repuesto', function (Blueprint $table) {
            $table->id();

            // Mismo tipo que las PK de ordenes y repuestos
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('repuesto_id');

            $table->unsignedInteger('cantidad');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            // Foreign keys explícitas
            $table->foreign('orden_id')
                ->references('id')
                ->on('ordenes')
                ->onDelete('cascade');

            $table->foreign('repuesto_id')
                ->references('id')
                ->on('repuestos');

            // Un repuesto no puede repetirse en la misma orden
            $table->unique(['orden_id', 'repuesto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_repuesto');
    }
};
