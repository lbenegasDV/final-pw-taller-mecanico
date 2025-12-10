<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('marca')->nullable();
            $table->string('codigo_interno')->unique();
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock'); // stock no negativo
            $table->enum('tipo', ['motor', 'electronica', 'frenos', 'suspension', 'otros']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};
