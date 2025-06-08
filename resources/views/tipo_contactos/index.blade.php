@extends('layouts.app')

@section('title', 'Tipos de contacto')

@section('content_header')
    <h1>Tipos de contacto</h1>
@stop

@section('content')
    {{-- Formulario para agregar --}}
    <form action="{{ route('tipo_contactos.store') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-auto">
            <input  name="nombre" class="form-control" placeholder="Nuevo tipo…" required>
        </div>
        <div class="col-auto">
            <button class="btn btn-success">Agregar</button>
        </div>
    </form>

    {{-- Tabla existente --}}
    <table class="table table-striped">
        <thead class="table-dark"><tr><th>ID</th><th>Nombre</th><th></th></tr></thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->nombre }}</td>
                    <td class="text-end">
                        <a href="{{ route('tipo_contactos.edit', $tipo) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
