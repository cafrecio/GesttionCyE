<?php

namespace App\Http\Controllers;

use App\Models\TransporteSucursale;
use Illuminate\Http\Request;

class TransporteSucursaleController extends Controller
{
    public function store(Request $request, $transporte_id)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'provincia_id' => 'required|exists:provincias,id',
            'localidad_id' => 'required|exists:localidades,id',
            'zona_id' => 'required|exists:zonas,id',
        ]);
        $data['transporte_id'] = $transporte_id;
        TransporteSucursale::create($data);
        return back()->with('success', 'Sucursal agregada.');
    }

    public function destroy(TransporteSucursale $sucursale)
    {
        $sucursale->delete();
        return back()->with('success', 'Sucursal eliminada.');
    }
    public function edit(TransporteSucursale $sucursale)
    {
        $provincias = \App\Models\Provincia::all();
        $zonas = \App\Models\Zona::all();
        // Localidades de la provincia de la sucursal, para precargar el select
        $localidades = \App\Models\Localidade::where('provincia_id', $sucursale->provincia_id)->get();
        return view('sucursales.edit', compact('sucursale', 'provincias', 'localidades', 'zonas'));
    }

public function update(Request $request, TransporteSucursale $sucursale)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'provincia_id' => 'required|exists:provincias,id',
            'localidad_id' => 'required|exists:localidades,id',
            'zona_id' => 'required|exists:zonas,id',
        ]);
        $sucursale->update($data);
        return redirect()->back()->with('success', 'Sucursal actualizada.');
    }
public function toggle(TransporteSucursale $sucursale)
    {
        $sucursale->activo = !$sucursale->activo;
        $sucursale->save();
        return back()->with('success', 'Sucursal actualizada.');
    }
}


