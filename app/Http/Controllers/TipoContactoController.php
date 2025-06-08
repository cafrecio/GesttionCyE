<?php

namespace App\Http\Controllers;

use App\Models\TipoContacto;
use Illuminate\Http\Request;

class TipoContactoController extends Controller
{
    /* LISTAR */
    public function index()
    {
        $tipos = TipoContacto::orderBy('id')->get();
        return view('tipo_contactos.index', compact('tipos'));
    }

    /* GUARDAR NUEVO */
    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:tipo_contactos']);
        TipoContacto::create($request->only('nombre'));

        return back()->with('success', 'Tipo creado');
    }

    /* EDITAR (muestra formulario dentro de modal) */
    public function edit(TipoContacto $tipoContacto)
    {
        return view('tipo_contactos.edit', compact('tipoContacto'));
    }

    /* ACTUALIZAR */
    public function update(Request $request, TipoContacto $tipoContacto)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:tipo_contactos,nombre,'.$tipoContacto->id]);
        $tipoContacto->update($request->only('nombre'));

        return redirect()->route('tipo_contactos.index')
                         ->with('success', 'Tipo actualizado');
    }
}

