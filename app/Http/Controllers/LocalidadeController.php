<?php

namespace App\Http\Controllers;

use App\Models\Localidade;
use App\Models\Provincia;
use App\Models\Zona;
use Illuminate\Http\Request;

class LocalidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $localidades = Localidade::all();
        return view('localidades.index', compact('localidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provincias = Provincia::all();
        $zonas = Zona::all();
        return view('localidades.create', compact('provincias', 'zonas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
            'zona_id' => 'required|exists:zonas,id', // Aquí hacemos que zona_id sea requerido
            // 'latitud' => 'nullable|numeric', // Si decides volver a incluir estos
            // 'longitud' => 'nullable|numeric',
        ]);
        Localidade::create($request->all());
        return redirect()->route('localidades.index')->with('success', 'Localidad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Localidade $localidad)
    {
        return view('localidades.show', compact('localidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localidade $localidad)
    {
        $provincias = Provincia::all();
        $zonas = Zona::all();
        return view('localidades.edit', compact('localidad', 'provincias', 'zonas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localidade $localidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
            'zona_id' => 'required|exists:zonas,id', // Aquí también hacemos que zona_id sea requerido
            // 'latitud' => 'nullable|numeric',
            // 'longitud' => 'nullable|numeric',
        ]);
        $localidad->update($request->all());
        return redirect()->route('localidades.index')->with('success', 'Localidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidade $localidad)
    {
        $localidad->delete();
        return redirect()->route('localidades.index')->with('success', 'Localidad eliminada exitosamente.');
    }
}