@extends('layouts.app')

@section('title', 'Transportes')

@section('content_header')
    <h1>Transportes</h1>
@stop

@section('content')
<div class="mb-3 d-flex align-items-center">
    <form method="GET" class="form-inline me-3">
        <label class="me-2">Mostrar:</label>
        <select name="estado" onchange="this.form.submit()" class="form-control">
            <option value="todos" {{ $estado == 'todos' ? 'selected' : '' }}>Todos</option>
            <option value="activos" {{ $estado == 'activos' ? 'selected' : '' }}>Activos</option>
            <option value="inactivos" {{ $estado == 'inactivos' ? 'selected' : '' }}>Inactivos</option>
        </select>
    </form>
    <a href="{{ route('transportes.create') }}" class="btn btn-primary ms-auto">
        <i class="fas fa-plus"></i> Nuevo Transporte
    </a>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Razón Social</th>
            <th>Estado</th>
            <th>Sucursales</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transportes as $transporte)
            <tr>
                <td>{{ $transporte->razon_social }}</td>
                <td>
                    <form action="{{ route('transportes.toggle', $transporte) }}" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm {{ $transporte->activo ? 'btn-success' : 'btn-secondary' }}">
                            {{ $transporte->activo ? 'Activo' : 'Inactivo' }}
                        </button>
                    </form>
                </td>
                <td>
                    @if($transporte->sucursales->count())
                        <ul class="mb-0">
                            @foreach($transporte->sucursales as $suc)
                                <li>{{ $suc->nombre }} ({{ $suc->localidad->nombre ?? '-' }}, {{ $suc->provincia->nombre ?? '-' }})</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Sin sucursales</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('transportes.edit', $transporte) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    {{-- Si querés permitir borrado, agregá acá el form de delete --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $transportes->links() }}
@stop


