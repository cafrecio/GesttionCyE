<?php

namespace App\Http\Controllers;

use App\Models\{Cliente, Sucursale, Provincia, Localidade, Zona, TransporteSucursale};
use Illuminate\Http\Request;

class SucursaleController extends Controller
{
    // Crear sucursal
    public function store(Request $request, $clienteCodigo)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'calle'      => 'required|string|max:255',
            'numero'     => 'nullable|string|max:20',
            'provincia_id' => 'required|exists:provincias,id',
            'localidade_id' => 'required|exists:localidades,id',
        ]);

        $cliente = Cliente::where('codigo', $clienteCodigo)->firstOrFail();

        // Obtener zona según localidad
        $localidad = Localidade::find($request->input('localidade_id'));
        $zona = $localidad->zona ?? null;

        $data = [
            'cliente_id'    => $clienteCodigo,
            'nombre'        => $request->input('nombre'),
            'calle'         => $request->input('calle'),
            'numero'        => $request->input('numero'),
            'provincia_id'  => $request->input('provincia_id'),
            'localidade_id' => $request->input('localidade_id'),
            'zona_id'       => $zona ? $zona->id : null,
            'activo'        => true,
        ];

        // Si la zona es Z99 y el cliente NO retira, exige transporte y sucursal transporte
        if ($zona && $zona->nombre == 'Z99' && !$cliente->retira) {
            $request->validate([
                'transporte_sucursale_id' => 'required|exists:transporte_sucursales,id',
            ]);
            $data['transporte_sucursale_id'] = $request->input('transporte_sucursale_id');
        }

        Sucursale::create($data);

        return redirect()->route('clientes.index')
                         ->with([
                             'success' => 'Sucursal creada correctamente.',
                             'modal_cliente_codigo' => $clienteCodigo,
                         ]);
    }

    // Editar sucursal
    public function update(Request $request, $clienteCodigo, Sucursale $sucursale)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'calle'      => 'required|string|max:255',
            'numero'     => 'nullable|string|max:20',
            'provincia_id' => 'required|exists:provincias,id',
            'localidade_id' => 'required|exists:localidades,id',
        ]);

        $localidad = Localidade::find($request->input('localidade_id'));
        $zona = $localidad->zona ?? null;

        $data = [
            'nombre'        => $request->input('nombre'),
            'calle'         => $request->input('calle'),
            'numero'        => $request->input('numero'),
            'provincia_id'  => $request->input('provincia_id'),
            'localidade_id' => $request->input('localidade_id'),
            'zona_id'       => $zona ? $zona->id : null,
        ];

        if ($zona && $zona->nombre == 'Z99' && !$sucursale->cliente->retira) {
            $request->validate([
                'transporte_sucursale_id' => 'required|exists:transporte_sucursales,id',
            ]);
            $data['transporte_sucursale_id'] = $request->input('transporte_sucursale_id');
        }

        $sucursale->update($data);

        return redirect()->route('clientes.index')
                         ->with([
                             'success' => 'Sucursal actualizada correctamente.',
                             'modal_cliente_codigo' => $clienteCodigo,
                         ]);
    }

    // Eliminar sucursal
    public function destroy($clienteCodigo, Sucursale $sucursale)
    {
        $sucursale->delete();

        return redirect()->route('clientes.index')
                         ->with([
                             'success' => 'Sucursal eliminada correctamente.',
                             'modal_cliente_codigo' => $clienteCodigo,
                         ]);
    }
}
