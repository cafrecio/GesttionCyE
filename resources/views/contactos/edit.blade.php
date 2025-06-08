@extends('layouts.app')

@section('title','Editar contacto')

@section('content')
<form action="{{ route('contactos.update', $contacto) }}" method="POST" class="card card-body">
    @csrf @method('PUT')

    <div class="mb-2">
        <label class="form-label">Tipo</label>
        <select name="tipo_id" class="form-select" required>
            @foreach($tipos as $t)
                <option value="{{ $t->id }}" {{ $t->id==$contacto->tipo_id?'selected':'' }}>
                    {{ $t->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-2"><label class="form-label">Nombre</label>
        <input name="nombre" class="form-control" value="{{ $contacto->nombre }}" required>
    </div>
    <div class="mb-2"><label class="form-label">Apellido</label>
        <input name="apellido" class="form-control" value="{{ $contacto->apellido }}">
    </div>

    <div class="mb-2"><label>Email</label>
        <input name="email" class="form-control" value="{{ $contacto->email }}">
    </div>

    <div class="mb-3"><label>Teléfono</label>
        <input name="telefono" class="form-control" value="{{ $contacto->telefono }}">
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-secondary">Cancelar</a>
</form>
@stop
