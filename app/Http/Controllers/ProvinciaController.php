<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provincias = Provincia::all(); // Obtiene todos los registros de la tabla provincias
        return view('provincias.index', compact('provincias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('provincias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Provincia::create($request->all()); // Crea un nuevo registro con los datos del formulario
        return redirect()->route('provincias.index')->with('success', 'Provincia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provincia $provincia)
    {
        return view('provincias.show', compact('provincia')); // Por ahora, no lo usaremos
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provincia $provincia)
    {
        return view('provincias.edit', compact('provincia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provincia $provincia)
    {
        $provincia->update($request->all()); // Actualiza el registro con los datos del formulario
        return redirect()->route('provincias.index')->with('success', 'Provincia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provincia $provincia)
    {
        $provincia->delete(); // Elimina el registro
        return redirect()->route('provincias.index')->with('success', 'Provincia eliminada exitosamente.');
    }
}
