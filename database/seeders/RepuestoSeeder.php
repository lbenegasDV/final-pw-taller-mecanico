<?php

namespace Database\Seeders;

use App\Models\Repuesto;
use Illuminate\Database\Seeder;

class RepuestoSeeder extends Seeder
{
    public function run(): void
    {
        $repuestos = [
            [
                'nombre'         => 'Filtro de aceite 1.6L',
                'marca'          => 'Mann',
                'codigo_interno' => 'RPT-MTR-001',
                'precio'         => 8500.00,
                'stock'          => 25,
                'tipo'           => 'motor',
            ],
            [
                'nombre'         => 'Filtro de aire estándar',
                'marca'          => 'Bosch',
                'codigo_interno' => 'RPT-MTR-002',
                'precio'         => 6200.00,
                'stock'          => 30,
                'tipo'           => 'motor',
            ],
            [
                'nombre'         => 'Bujía iridium',
                'marca'          => 'NGK',
                'codigo_interno' => 'RPT-MTR-003',
                'precio'         => 9500.00,
                'stock'          => 40,
                'tipo'           => 'motor',
            ],
            [
                'nombre'         => 'Pastillas de freno delanteras',
                'marca'          => 'TRW',
                'codigo_interno' => 'RPT-FRN-001',
                'precio'         => 18500.00,
                'stock'          => 18,
                'tipo'           => 'frenos',
            ],
            [
                'nombre'         => 'Disco de freno ventilado',
                'marca'          => 'Brembo',
                'codigo_interno' => 'RPT-FRN-002',
                'precio'         => 32500.00,
                'stock'          => 12,
                'tipo'           => 'frenos',
            ],
            [
                'nombre'         => 'Amortiguador delantero gas',
                'marca'          => 'Monroe',
                'codigo_interno' => 'RPT-SUS-001',
                'precio'         => 41000.00,
                'stock'          => 10,
                'tipo'           => 'suspension',
            ],
            [
                'nombre'         => 'Barra estabilizadora delantera',
                'marca'          => 'TRW',
                'codigo_interno' => 'RPT-SUS-002',
                'precio'         => 28500.00,
                'stock'          => 8,
                'tipo'           => 'suspension',
            ],
            [
                'nombre'         => 'Módulo de encendido electrónico',
                'marca'          => 'Delphi',
                'codigo_interno' => 'RPT-ELC-001',
                'precio'         => 54000.00,
                'stock'          => 6,
                'tipo'           => 'electronica',
            ],
            [
                'nombre'         => 'Sensor de oxígeno (lambda)',
                'marca'          => 'Bosch',
                'codigo_interno' => 'RPT-ELC-002',
                'precio'         => 36500.00,
                'stock'          => 9,
                'tipo'           => 'electronica',
            ],
            [
                'nombre'         => 'Kit de correa de distribución',
                'marca'          => 'Gates',
                'codigo_interno' => 'RPT-OTR-001',
                'precio'         => 78000.00,
                'stock'          => 7,
                'tipo'           => 'otros',
            ],
        ];

        foreach ($repuestos as $data) {
            Repuesto::firstOrCreate(
                ['codigo_interno' => $data['codigo_interno']], // evita duplicados si corrés el seeder de nuevo
                $data
            );
        }
    }
}
