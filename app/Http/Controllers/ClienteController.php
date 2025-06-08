<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Artisan;

class ClienteController extends Controller
{
    /*-------------------- INDEX --------------------*/
    public function index(Request $request)
    {
        $filtro   = $request->input('filtro');

        $clientes = Cliente::with([
                            'contactos.tipo',
                            'sucursales.localidad',
                            'sucursales.zona',
                        ])
                        ->withCount(['contactos', 'sucursales'])
                        ->when($filtro, function ($q) use ($filtro) {
                            $q->where('codigo', 'like', "%$filtro%")
                              ->orWhere('razon_social', 'like', "%$filtro%")
                              ->orWhere('cuit', 'like', "%$filtro%");
                        })
                        ->orderBy('razon_social')
                        ->paginate(25);

        return view('clientes.index', compact('clientes'));
    }

    /*-------------------- UPDATE “retira” (switch verde/gris) --------------------*/
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->retira = $request->has('retira');
        $cliente->save();

        return back()->with('success', 'Cliente actualizado.');
    }

    /* toggle independiente, se llama con el botón de la tabla */
    public function toggleRetira(Cliente $cliente)
    {
        $cliente->retira = ! $cliente->retira;
        $cliente->save();

        return back()->with('success', 'Estado de retiro actualizado.');
    }

    /*-------------------- SINCRONIZAR ERP --------------------*/
    public function sync()
    {
        Artisan::call('syncerpclients');
        return back()->with('success', 'Sincronización completada.');
    }
}


