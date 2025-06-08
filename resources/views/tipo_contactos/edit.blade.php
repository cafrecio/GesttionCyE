@extends('layouts.app')

@section('title', 'Editar tipo')

@section('content_header')
    <h1>Editar tipo: {{ $tipoContacto->nombre }}</h1>
@stop

@section('content')
<form action="{{ route('tipo_contactos.update', $tipoContacto) }}" method="POST" class="card card-body">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input class="form-control" name="nombre" value="{{ $tipoContacto->nombre }}" required>
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('tipo_contactos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@stop
