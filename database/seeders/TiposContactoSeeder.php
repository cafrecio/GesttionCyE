<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposContactoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_contactos')->insert([   // ← nombre de tabla correcto
            ['id' => 1, 'nombre' => 'Compras'],
            ['id' => 2, 'nombre' => 'Pagos a proveedores'],
        ]);
    }
}

