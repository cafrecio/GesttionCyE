@extends('layouts.app')
<table class="table table-sm align-middle">
    <thead class="table-dark">
        <tr>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th class="text-end"></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($contactos as $c)
            <tr>
                <td>{{ $c->tipo->nombre }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->apellido }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ $c->telefono }}</td>
                <td class="text-end">
                    <a  href="{{ route('contactos.edit', $c) }}"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('contactos.destroy', $contacto) }}" method="POST" style="display:inline">
                          onsubmit="return confirm('¿Eliminar contacto?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- -------------- Formulario “Agregar contacto” -------------- --}}
<form action="{{ route('clientes.contactos.store', $cliente) }}"
      method="POST" class="row g-2">
    @csrf

    <div class="col-2">
        <select name="tipo_id" class="form-select" required>
            <option value="">Tipo…</option>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-2">
        <input name="nombre" class="form-control" placeholder="Nombre" required>
    </div>

    <div class="col-2">
        <input name="apellido" class="form-control" placeholder="Apellido">
    </div>

    <div class="col-3">
        <input name="email" class="form-control" placeholder="Correo">
    </div>

    <div class="col-2">
        <input name="telefono" class="form-control" placeholder="Teléfono">
    </div>

    <div class="col-1 d-grid">
        <button class="btn btn-success">+</button>
    </div>
</form>

