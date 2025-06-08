<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('zonas')->insert([
            ['id' => 4,  'nombre' => 'Z2', 'descripcion' => 'Norte GBA: Vicente López–San Fernando / Villa Martelli–Don Torcuato', 'entregamos' => 1],
            ['id' => 5,  'nombre' => 'Z3', 'descripcion' => 'Noroeste GBA: San Martín–Derqui / Caseros–Tortuguitas',            'entregamos' => 1],
            ['id' => 6,  'nombre' => 'Z4', 'descripcion' => 'Oeste GBA: Ciudadela–Lomas del Mirador / Hurlingham',              'entregamos' => 1],
            ['id' => 7,  'nombre' => 'Z5', 'descripcion' => 'Sudoeste GBA: La Tablada–Isidro Casanova / Ezeiza',               'entregamos' => 1],
            ['id' => 8,  'nombre' => 'Z6', 'descripcion' => 'Sur GBA: Lanús–Quilmes / Avellaneda–Berazategui',                 'entregamos' => 1],
            ['id' => 9,  'nombre' => 'Z7', 'descripcion' => 'Sur profundo: Florencio Varela–La Plata / Berazategui–Hudson',    'entregamos' => 1],
        ]);
    }
}

