<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            ProvinciasTableSeeder::class, // Descomenta y agrega si creaste el seeder de provincias
            ZonasTableSeeder::class,
            TiposContactoSeeder::class,
            ProvinciasSeederExtra::class,
            LocalidadesSeederMain::class,
        ]);
    }
}
