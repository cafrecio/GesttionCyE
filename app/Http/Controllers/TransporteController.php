<?php

namespace App\Http\Controllers;

use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->get('estado', 'todos');
        $query = \App\Models\Transporte::query();

        if ($estado === 'activos') $query->where('activo', true);
        if ($estado === 'inactivos') $query->where('activo', false);

        $transportes = $query->with('sucursales')->orderBy('razon_social')->paginate(20);

        return view('transportes.index', compact('transportes', 'estado'));
    }
    public function create()
    {
        return view('transportes.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'razon_social' => 'required|string|max:255',
        ]);
        $data['activo'] = $request->has('activo'); // chequea si está tildado

        Transporte::create($data);

        return redirect()->route('transportes.index')->with('success', 'Transporte creado correctamente.');
    }
    public function edit(Transporte $transporte)
    {
        $provincias = \App\Models\Provincia::all();
        $zonas = \App\Models\Zona::all();

        // Sucursal "vacía" para el alta rápida (esto depende cómo armes el form)
        $sucursale = null;

        // Determinar provincia seleccionada (si hay sucursales, podés tomar la última o dejar en blanco)
        $provinciaId = old('provincia_id'); // Si hubo error de validación
        if (!$provinciaId && $transporte->sucursales->count() > 0) {
            // Toma la provincia de la última sucursal cargada como valor por defecto (opcional)
            $provinciaId = $transporte->sucursales->last()->provincia_id;
        }
        $localidades = $provinciaId
            ? \App\Models\Localidade::where('provincia_id', $provinciaId)->get()
            : collect();

        return view('transportes.edit', compact(
            'transporte', 'provincias', 'localidades', 'zonas', 'sucursale'
        ));
    }
    public function update(Request $request, Transporte $transporte)
    {
        $data = $request->validate([
            'razon_social' => 'required|string|max:255',
            // No validamos boolean porque puede no venir (si está desmarcado)
        ]);
        $data['activo'] = $request->has('activo');
        $transporte->update($data);

        return redirect()->route('transportes.index')->with('success', 'Transporte actualizado.');
    }
    public function destroy(Transporte $transporte)
    {
        $transporte->delete();
        return redirect()->route('transportes.index')
                         ->with('success', 'Transporte eliminado.');
    }
    public function toggle(Transporte $transporte)
    {
        $transporte->activo = !$transporte->activo;
        $transporte->save();

        return back()->with('success', 'Estado de transporte actualizado.');
    }
}

