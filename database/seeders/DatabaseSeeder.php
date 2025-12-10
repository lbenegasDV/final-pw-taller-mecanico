<?php

namespace Database\Seeders;

use App\Models\Mecanico;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@taller.test'],
            [
                'name' => 'Admin Taller',
                'password' => Hash::make('password'),
                'rol' => 'admin',
            ]
        );

        // Usuario Recepcionista
        $recepcionista = User::firstOrCreate(
            ['email' => 'recepcion@taller.test'],
            [
                'name' => 'Recepcion Taller',
                'password' => Hash::make('password'),
                'rol' => 'recepcionista',
            ]
        );

        // Usuario Mecánico
        $userMecanico = User::firstOrCreate(
            ['email' => 'mecanico@taller.test'],
            [
                'name' => 'Mecanico Juan',
                'password' => Hash::make('password'),
                'rol' => 'mecanico',
            ]
        );

        // Registro en tabla mecanicos vinculado al user mecánico
        Mecanico::firstOrCreate(
            ['email' => 'mecanico@taller.test'],
            [
                'user_id'      => $userMecanico->id,
                'nombre'       => 'Juan',
                'apellido'     => 'Pérez',
                'especialidad' => 'mecánica general',
                'telefono'     => '1111-2222',
                'activo'       => true,
            ]
        );

        // Repuestos de ejemplo
        $this->call([
            RepuestoSeeder::class,
        ]);
    }
}
