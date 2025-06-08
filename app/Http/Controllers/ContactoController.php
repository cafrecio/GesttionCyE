<?php

// app/Http/Controllers/ContactoController.php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Crear contacto
    public function store(Request $request, $clienteCodigo)
    {
        $request->validate([
            'tipo_id'  => 'required|exists:tipo_contactos,id',
            'nombre'   => 'required|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'email'    => 'required|email',
            'telefono' => 'required|string|max:50',
        ]);

        Contacto::create([
            'cliente_codigo' => $clienteCodigo,
            'tipo_id'        => $request->input('tipo_id'),
            'nombre'         => $request->input('nombre'),
            'apellido'       => $request->input('apellido'),
            'email'          => $request->input('email'),
            'telefono'       => $request->input('telefono'),
        ]);
        // Store y Update: agregar esto ANTES del return redirect...
        session()->flash('modal_cliente_codigo', $clienteCodigo);
        session()->flash('modal_open', 'create');
        return redirect()->route('clientes.index')
                         ->with('success', 'Contacto creado correctamente.');
    }

    // Actualizar contacto
    public function update(Request $request, $clienteCodigo, Contacto $contacto)
    {
        $request->validate([
            'tipo_id'  => 'required|exists:tipo_contactos,id',
            'nombre'   => 'required|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'email'    => 'required|email',
            'telefono' => 'required|string|max:50',
        ]);

        $contacto->update([
            'tipo_id'  => $request->input('tipo_id'),
            'nombre'   => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'email'    => $request->input('email'),
            'telefono' => $request->input('telefono'),
        ]);
        // Store y Update: agregar esto ANTES del return redirect...
        session()->flash('modal_cliente_codigo', $clienteCodigo);
        session()->flash('modal_open', 'edit');
        session()->flash('contacto_id', $contacto->id);
        return redirect()->route('clientes.index')
                         ->with('success', 'Contacto actualizado correctamente.');
    }

    // Eliminar contacto
    public function destroy($clienteCodigo, Contacto $contacto)
    {
        $contacto->delete();
        return redirect()->route('clientes.index')
                         ->with('success', 'Contacto eliminado.');
    }
}

