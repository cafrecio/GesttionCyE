<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciasSeederExtra extends Seeder
{
    public function run(): void
    {
        DB::table('provincias')->insert([
            ['id'=>4,  'nombre'=>'Catamarca'],
            ['id'=>5,  'nombre'=>'Chaco'],
            ['id'=>6,  'nombre'=>'Chubut'],
            ['id'=>7,  'nombre'=>'Corrientes'],
            ['id'=>8,  'nombre'=>'Entre Ríos'],
            ['id'=>9,  'nombre'=>'Formosa'],
            ['id'=>10, 'nombre'=>'Jujuy'],
            ['id'=>11, 'nombre'=>'La Pampa'],
            ['id'=>12, 'nombre'=>'La Rioja'],
            ['id'=>13, 'nombre'=>'Mendoza'],
            ['id'=>14, 'nombre'=>'Misiones'],
            ['id'=>15, 'nombre'=>'Neuquén'],
            ['id'=>16, 'nombre'=>'Río Negro'],
            ['id'=>17, 'nombre'=>'Salta'],
            ['id'=>18, 'nombre'=>'San Juan'],
            ['id'=>19, 'nombre'=>'San Luis'],
            ['id'=>20, 'nombre'=>'Santa Cruz'],
            ['id'=>21, 'nombre'=>'Santa Fe'],
            ['id'=>22, 'nombre'=>'Santiago del Estero'],
            ['id'=>23, 'nombre'=>'Tierra del Fuego'],
            ['id'=>24, 'nombre'=>'Tucumán'],
        ]);
    }
}
