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
    /**public function edit(Localidade $localidad)
    {
        $provincias = Provincia::all();
        $zonas = Zona::all();
        return view('localidades.edit', compact('localidad', 'provincias', 'zonas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit($id) // Cambiamos la inyección de dependencia a un ID y lo nombramos $id para claridad
    {
    $localidad = Localidade::findOrFail($id); // Buscamos la localidad por el ID
    $provincias = Provincia::all();
    $zonas = Zona::all();
    return view('localidades.edit', compact('localidad', 'provincias', 'zonas'));
    }
   
    // 👇 poné exactamente el mismo nombre que usa la ruta {localidade}
    public function update(Request $request, Localidade $localidade)
    {
        // 1) validación
        $data = $request->validate([
            'nombre'        => 'required|string|max:255',
            'provincia_id'  => 'required|exists:provincias,id',
            'zona_id'       => 'required|exists:zonas,id',
        ]);

        // 2) actualización
        $localidade->update($data);

        // 3) redirección
        return redirect()
            ->route('localidades.index')
            ->with('success', 'Localidad actualizada exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidade $localidade)
    {
        $localidade->delete();        // borra
        return redirect()
            ->route('localidades.index')
            ->with('success', 'Localidad eliminada');
    }
}