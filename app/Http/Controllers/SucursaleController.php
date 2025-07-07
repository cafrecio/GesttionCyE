<?php

namespace App\Http\Controllers;

use App\Models\{Cliente, Sucursale, Localidade, Zona};
use Illuminate\Http\Request;

class SucursaleController extends Controller
{
    // Crear sucursal
    public function store(Request $request, $clienteCodigo)
    {
        $request->validate([
            'nombre'          => 'required|string|max:255',
            'calle'           => 'required|string|max:255',
            'numero'          => 'nullable|string|max:20',
            'provincia_id'    => 'required|exists:provincias,id',
            'localidade_id'   => 'required|exists:localidades,id',
        ]);

        $cliente   = Cliente::where('codigo', $clienteCodigo)->firstOrFail();
        $localidad = Localidade::find($request->localidade_id);
        $zona      = $localidad->zona;

        $data = [
            'cliente_id'    => $clienteCodigo,
            'nombre'        => $request->nombre,
            'calle'         => $request->calle,
            'numero'        => $request->numero,
            'provincia_id'  => $request->provincia_id,
            'localidade_id' => $request->localidade_id,
            'zona_id'       => $zona     ? $zona->id : null,
            'activo'        => true,
        ];

        if ($zona && $zona->nombre === 'Z99' && ! $cliente->retira) {
            $request->validate([
                'transporte_sucursale_id' => 'required|exists:transporte_sucursales,id',
            ]);
            $data['transporte_sucursale_id'] = $request->transporte_sucursale_id;
        }

        Sucursale::create($data);

        return redirect()->route('clientes.index')->with([
            'success'             => 'Sucursal creada correctamente.',
            'modal_cliente_codigo'=> $clienteCodigo,
        ]);
    }

    // Actualizar sucursal
    public function update(Request $request, $clienteCodigo, Sucursale $sucursale)
    {
        $request->validate([
            'nombre'          => 'required|string|max:255',
            'calle'           => 'required|string|max:255',
            'numero'          => 'nullable|string|max:20',
            'provincia_id'    => 'required|exists:provincias,id',
            'localidade_id'   => 'required|exists:localidades,id',
        ]);

        $localidad = Localidade::find($request->localidade_id);
        $zona      = $localidad->zona;

        $data = [
            'nombre'        => $request->nombre,
            'calle'         => $request->calle,
            'numero'        => $request->numero,
            'provincia_id'  => $request->provincia_id,
            'localidade_id' => $request->localidade_id,
            'zona_id'       => $zona     ? $zona->id : null,
        ];

        if ($zona && $zona->nombre === 'Z99' && ! $sucursale->cliente->retira) {
            $request->validate([
                'transporte_sucursale_id' => 'required|exists:transporte_sucursales,id',
            ]);
            $data['transporte_sucursale_id'] = $request->transporte_sucursale_id;
        }

        $sucursale->update($data);

        return redirect()->route('clientes.index')->with([
            'success'              => 'Sucursal actualizada.',
            'modal_cliente_codigo' => $clienteCodigo,
        ]);
    }

    // Eliminar sucursal (no se usa; queda toggle)
    public function destroy($clienteCodigo, Sucursale $sucursale)
    {
        $sucursale->delete();
        return redirect()->route('clientes.index')->with([
            'success'              => 'Sucursal eliminada.',
            'modal_cliente_codigo' => $clienteCodigo,
        ]);
    }

    // Toggle activo/inactivo
    public function toggle($clienteCodigo, Sucursale $sucursale)
    {
        $sucursale->activo = ! $sucursale->activo;
        $sucursale->save();
        return redirect()->route('clientes.index')->with([
            'success'              => 'Estado de sucursal actualizado.',
            'modal_cliente_codigo' => $clienteCodigo,
        ]);
    }
}

