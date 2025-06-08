<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadesSeederMain extends Seeder
{
    public function run(): void
    {
        DB::table('localidades')->insert([
            // --- CABA (provincia 1) ---
            ['provincia_id'=>1, 'nombre'=>'CABA',            'zona_id'=>2],   // Z1

            // --- Cordoba ---
            ['provincia_id'=>3, 'nombre'=>'Córdoba', 'zona_id'=>3],
            ['provincia_id'=>3, 'nombre'=>'Río Cuarto', 'zona_id'=>3],
            ['provincia_id'=>3, 'nombre'=>'Villa Maria', 'zona_id'=>3],
            ['provincia_id'=>3, 'nombre'=>'San Francisco', 'zona_id'=>3],

            // --- Catamarca ---
            ['provincia_id'=>4, 'nombre'=>'San Fernando del Valle de Catamarca', 'zona_id'=>3],
            ['provincia_id'=>4, 'nombre'=>'Andalgalá', 'zona_id'=>3],
            ['provincia_id'=>4, 'nombre'=>'Tinogasta', 'zona_id'=>3],

            // --- Chaco ---
            ['provincia_id'=>5, 'nombre'=>'Resistencia',     'zona_id'=>3],
            ['provincia_id'=>5, 'nombre'=>'Roque Sáenz Peña',     'zona_id'=>3],

            // --- Chubut ---
            ['provincia_id'=>6, 'nombre'=>'Comodoro Rivadavia',          'zona_id'=>3],
            ['provincia_id'=>6, 'nombre'=>'Rawson',          'zona_id'=>3],
            ['provincia_id'=>6, 'nombre'=>'Puerto Madryn',          'zona_id'=>3],
            ['provincia_id'=>6, 'nombre'=>'Trelew',          'zona_id'=>3],
            ['provincia_id'=>6, 'nombre'=>'Esquel',          'zona_id'=>3],

            // --- Corrientes ---
            ['provincia_id'=>7, 'nombre'=>'Corrientes',      'zona_id'=>3],

            // --- Entre Ríos ---
            ['provincia_id'=>8, 'nombre'=>'Paraná',          'zona_id'=>3],
            ['provincia_id'=>8, 'nombre'=>'Concordia',          'zona_id'=>3],
            ['provincia_id'=>8, 'nombre'=>'Concepción del Uruguay',          'zona_id'=>3],

            // --- Formosa ---
            ['provincia_id'=>9,  'nombre'=>'Formosa',        'zona_id'=>3],

            // --- Jujuy ---
            ['provincia_id'=>10, 'nombre'=>'San Salvador de Jujuy', 'zona_id'=>3],
            ['provincia_id'=>10,  'nombre'=>'Palpalá',        'zona_id'=>3],

            // --- La Pampa ---
            ['provincia_id'=>11, 'nombre'=>'Santa Rosa',     'zona_id'=>3],
            ['provincia_id'=>11, 'nombre'=>'General Pico',     'zona_id'=>3],

            // --- La Rioja ---
            ['provincia_id'=>12, 'nombre'=>'La Rioja',       'zona_id'=>3],

            // --- Mendoza ---
            ['provincia_id'=>13, 'nombre'=>'Mendoza',        'zona_id'=>3],
            ['provincia_id'=>13, 'nombre'=>'San Rafael',        'zona_id'=>3],
            ['provincia_id'=>13, 'nombre'=>'Luján de Cuyo',        'zona_id'=>3],
            ['provincia_id'=>13, 'nombre'=>'Guaymallen',        'zona_id'=>3],
            ['provincia_id'=>13, 'nombre'=>'Malargüe',        'zona_id'=>3],

            // --- Misiones ---
            ['provincia_id'=>14, 'nombre'=>'Posadas',        'zona_id'=>3],
            ['provincia_id'=>14, 'nombre'=>'Oberá',        'zona_id'=>3],

            // --- Neuquén ---
            ['provincia_id'=>15, 'nombre'=>'Neuquén',        'zona_id'=>3],
            ['provincia_id'=>15, 'nombre'=>'Añelo',        'zona_id'=>3],
            ['provincia_id'=>15, 'nombre'=>'Cutral Co',        'zona_id'=>3],
            ['provincia_id'=>15, 'nombre'=>'Rincón de los Sauce',        'zona_id'=>3],

            // --- Río Negro ---
            ['provincia_id'=>16, 'nombre'=>'Viedma',         'zona_id'=>3],
            ['provincia_id'=>16, 'nombre'=>'Cipolletti',         'zona_id'=>3],
            ['provincia_id'=>16, 'nombre'=>'Gral. Roca',         'zona_id'=>3],

            // --- Salta ---
            ['provincia_id'=>17, 'nombre'=>'Salta',          'zona_id'=>3],
            ['provincia_id'=>17, 'nombre'=>'Tartagal',          'zona_id'=>3],

            // --- San Juan ---
            ['provincia_id'=>18, 'nombre'=>'San Juan',       'zona_id'=>3],
            ['provincia_id'=>18, 'nombre'=>'Jáchal',       'zona_id'=>3],

            // --- San Luis ---
            ['provincia_id'=>19, 'nombre'=>'San Luis',       'zona_id'=>3],
            ['provincia_id'=>19, 'nombre'=>'Villa Mercedes',       'zona_id'=>3],

            // --- Santa Cruz ---
            ['provincia_id'=>20, 'nombre'=>'Río Gallegos',   'zona_id'=>3],
            ['provincia_id'=>20, 'nombre'=>'Caleta Olivia',   'zona_id'=>3],
            ['provincia_id'=>20, 'nombre'=>'Las Heras',   'zona_id'=>3],
            ['provincia_id'=>20, 'nombre'=>'Puerto Deseado',   'zona_id'=>3],

            // --- Santa Fe ---
            ['provincia_id'=>21, 'nombre'=>'Santa Fe',       'zona_id'=>3],
            ['provincia_id'=>21, 'nombre'=>'Rosario',       'zona_id'=>3],
            ['provincia_id'=>21, 'nombre'=>'Rafaela',       'zona_id'=>3],
            ['provincia_id'=>21, 'nombre'=>'Venado Tuerto',       'zona_id'=>3],
            ['provincia_id'=>21, 'nombre'=>'San Lorenzo',       'zona_id'=>3],

            // --- Santiago del Estero ---
            ['provincia_id'=>22, 'nombre'=>'Santiago del Estero', 'zona_id'=>3],

            // --- Tierra del Fuego ---
            ['provincia_id'=>23, 'nombre'=>'Ushuaia',        'zona_id'=>3],
            ['provincia_id'=>23, 'nombre'=>'Río Grande',        'zona_id'=>3],

            // --- Tucumán ---
            ['provincia_id'=>24, 'nombre'=>'San Miguel de Tucumán', 'zona_id'=>3],
        ]);
    }
}
