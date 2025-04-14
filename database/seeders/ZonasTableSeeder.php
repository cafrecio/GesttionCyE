<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zonas')->insert([
            [
                'nombre' => 'Z0',
                'descripcion' => 'CyE Ingenieria',
                'entregamos' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Z1',
                'descripcion' => 'CABA',
                'entregamos' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Z99',
                'descripcion' => 'Interior',
                'entregamos' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
