@extends('layouts.app')

@section('title', 'Localidades')

@section('content_header')
    <h1>Localidades
        <small class="text-muted">({{ $localidades->total() }})</small>
    </h1>

    <a href="{{ route('localidades.create') }}" class="btn btn-primary float-sm-right">
        <i class="fas fa-plus"></i> Nueva
    </a>
@stop

@section('content')
<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Provincia</th>
            <th>Zona</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($localidades as $loc)
            <tr>
                <td>{{ $loc->id }}</td>
                <td>{{ $loc->nombre }}</td>
                <td>{{ $loc->provincia->nombre }}</td>
                <td>{{ $loc->zona->nombre }}</td>
                <td class="text-end">
                    <a href="{{ route('localidades.edit', $loc) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('localidades.destroy', $loc) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('¿Eliminar localidad?')">
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

{{-- paginación con plantilla bootstrap-5 para que no salgan flechas gigantes --}}
{{ $localidades->links('pagination::bootstrap-5') }}
@stop
