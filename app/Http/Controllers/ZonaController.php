<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Localidade;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonas = Zona::all();
        return view('zonas.index', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zonas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['entregamos'] = $request->has('entregamos'); // Convierte 'on' a true si está presente, false si no
        Zona::create($data);
        return redirect()->route('zonas.index')->with('success', 'Zona creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zona $zona)
    {
        return response()->json(['descripcion' => $zona->descripcion]);
        //return view('zonas.show', compact('zona')); // Por ahora, no lo usaremos
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zona $zona)
    {
        return view('zonas.edit', compact('zona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zona $zona)
    {
        $data = $request->all();
        $data['entregamos'] = $request->has('entregamos'); // Convierte 'on' a true si está presente, false si no
        $zona->update($data);
        return redirect()->route('zonas.index')->with('success', 'Zona actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zona $zona)
    {
        $zona->delete();
        return redirect()->route('zonas.index')->with('success', 'Zona eliminada exitosamente.');
    }
    public function getByLocalidad($localidadeId)
    {
        $loc = Localidade::with('zona')->findOrFail($localidadeId);
        return response()->json([
        'id'     => $loc->zona->id,
        'nombre' => $loc->zona->nombre,
        ]);
    }

}