<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mecanicos', function (Blueprint $table) {
            $table->id();

            // user_id es opcional: solo algunos mecánicos estarán vinculados a un usuario del sistema
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('especialidad')->nullable(); // mecánica, electricidad, etc.
            $table->string('telefono')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mecanicos');
    }
};
