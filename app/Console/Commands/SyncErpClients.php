<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Cliente;   // crea el modelo en un minuto

class SyncErpClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncerpclients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sincronización…');
        $url = 'https://sistemaisis.ar:8089/api/Cliente_VW';

        $response = Http::withHeaders([
            'X-API-KEY' => 'Vwzsq/jVTWBfPKu29tzeiw=='
        ])->get($url);

        // 1º chequeo rápido
        if ($response->failed()) {
            $this->error('No pude conectar al ERP');
            return;
        }

        $clientes = $response->json();   // lo convierte en array PHP
        foreach ($clientes as $cli) {

            /* ---------- FILTROS ---------- */

            // 1) Estado ───────────────
            $estado = strtolower($cli['estadoCli'] ?? 'activo');
            if ($estado !== 'activo') {
                continue;                                   // descarta los no activos
            }

            // 2) CUIT válido ──────────
            $rawCuit = $cli['cuitCli'] ?? '';
            $cuit    = preg_replace('/\D/', '', $rawCuit);  // quita guiones

            // Debe tener 11 dígitos exactos Y no ser todos ceros
            if (strlen($cuit) !== 11 || $cuit === '00000000000') {
                continue;                                   // descarta el registro
            }

            /* ---------- MAPEAMOS Y GUARDAMOS ---------- */

            \App\Models\Cliente::updateOrCreate(
                ['codigo' => $cli['codigoCli']],
                [
                    'razon_social_corta' => $cli['razonSocialBusCli'] ?? '',
                    'razon_social'      => $cli['razonSocialCli'] ?? '',
                    'cuit'              => $cuit,
                    'fecha_alta'        => substr($cli['fechaAltaCli'] ?? '', 0, 10) ?: null,
                    'fecha_ult_fact'    => substr($cli['fechaUltimaFacCli'] ?? '', 0, 10) ?: null,
                    'estado'            => 'activo',              // ya lo filtramos antes
                    'moneda'            => $cli['descr_Mda'] ?? null,
                    'nombre_vendedor'   => $cli['nombreVendedor'] ?? null,
                    // retira queda igual
                ]
            );
        }


        $this->info('Clientes sincronizados correctamente.');
    }
}
