<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provincias')->insert([
            ['nombre' => 'CABA'],
            ['nombre' => 'Buenos Aires'],
            ['nombre' => 'Córdoba'],
            // Agrega más provincias aquí si lo deseas
        ]);
    }
}
