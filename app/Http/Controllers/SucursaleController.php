<?php

namespace App\Http\Controllers;

use App\Models\{Cliente, Sucursale, Provincia, Localidade, Zona};
use Illuminate\Http\Request;

class SucursaleController extends Controller
{
    /*---------- STORE ----------*/
    public function store(Request $r, $cliente_codigo)
    {
        $data = $r->validate([
            'nombre'   => 'required|string|max:255',
            'calle'    => 'required|string|max:255',
            'numero'   => 'nullable|string|max:10',
            'provincia_id'            => 'required|exists:provincias,id',
            'localidade_id'           => 'required|exists:localidades,id',
            'zona_id'                 => 'required|exists:zonas,id',
            'transporte_sucursale_id' => 'nullable|exists:transporte_sucursales,id',
        ]);

        $cliente = Cliente::where('codigo',$cliente_codigo)->firstOrFail();
        $zona    = Zona::find($data['zona_id']);

        if ($zona && $zona->nombre==='Z99' && !$cliente->retira) {
            $r->validate(['transporte_sucursale_id'=>'required|exists:transporte_sucursales,id']);
        }

        $data['cliente_id'] = $cliente_codigo;
        $data['activo']     = true;
        Sucursale::create($data);

        return redirect()->route('clientes.index')
                         ->with('success','Sucursal creada');
    }

    /*---------- UPDATE ----------*/
    public function update(Request $r, Sucursale $sucursale)
    {
        $data = $r->validate([
            'nombre'   => 'required|string|max:255',
            'calle'    => 'required|string|max:255',
            'numero'   => 'nullable|string|max:10',
            'provincia_id'            => 'required|exists:provincias,id',
            'localidade_id'           => 'required|exists:localidades,id',
            'zona_id'                 => 'required|exists:zonas,id',
            'transporte_sucursale_id' => 'nullable|exists:transporte_sucursales,id',
        ]);

        $cliente = Cliente::where('codigo',$sucursale->cliente_id)->first();
        $zona    = Zona::find($data['zona_id']);

        if ($zona && $zona->nombre==='Z99' && !$cliente->retira) {
            $r->validate(['transporte_sucursale_id'=>'required|exists:transporte_sucursales,id']);
        }

        $sucursale->update($data);

        return redirect()->route('clientes.index')
                         ->with('success','Sucursal actualizada');
    }

    /*---------- TOGGLE ----------*/
    public function toggle(Sucursale $sucursale)
    {
        $sucursale->activo = ! $sucursale->activo;
        $sucursale->save();
        return back()->with('success','Estado actualizado');
    }
}
