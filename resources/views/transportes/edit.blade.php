@extends('layouts.app')

@section('title', 'Editar Transporte')

@section('content_header')
    <h1>Editar Transporte</h1>
@stop

@section('content')
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Editar Transporte</h3></div>
        <form action="{{ route('transportes.update', $transporte) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <label>Razón Social</label>
                <input name="razon_social" class="form-control" value="{{ $transporte->razon_social }}" required>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('transportes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

{{-- Lista y Alta de Sucursales --}}
@if($transporte->exists)
    <div class="col-md-10 mt-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Sucursales / Direcciones de este Transporte</h3>
            </div>
            <div class="card-body p-2">
                {{-- Alta rápida --}}
                <form action="{{ route('transportes.sucursales.store', $transporte) }}" method="POST" class="row g-2 align-items-end" id="form-alta-sucursal">
                    @csrf
                    <input type="hidden" name="transporte_id" value="{{ $transporte->id }}">
                    <div class="col-md-2">
                        <label>Nombre</label>
                        <input name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Calle</label>
                        <input name="calle" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <label>Número</label>
                        <input name="numero" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label>Provincia</label>
                        <select name="provincia_id" class="form-control" required id="provincia_id">
                            <option value="">Elija...</option>
                            @foreach($provincias as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Localidad</label>
                        <select name="localidad_id" class="form-control" required id="localidad_id">
                            <option value="">Elija provincia primero</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Zona</label>
                            <input type="text" class="form-control" id="zona_nombre" value="" readonly>
                            <input type="hidden" name="zona_id" id="zona_id" value="">
                    </div>
                    <div class="col-md-1 d-flex align-items-end pb-2">
                        <button class="btn btn-success btn-sm w-100">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
                {{-- Tabla de sucursales --}}
                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Provincia</th>
                            <th>Localidad</th>
                            <th>Zona</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transporte->sucursales as $suc)
                            <tr>
                                <td>{{ $suc->nombre }}</td>
                                <td>{{ $suc->calle }} {{ $suc->numero }}</td>
                                <td>{{ $suc->provincia->nombre ?? '-' }}</td>
                                <td>{{ $suc->localidad->nombre ?? '-' }}</td>
                                <td>{{ $suc->zona->nombre ?? '-' }}</td>
                                <td>
                                    {{-- Toggle Activo/Inactivo --}}
                                    <form action="{{ route('sucursales.toggle', $suc) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $suc->activo ? 'btn-success' : 'btn-secondary' }}"
                                            title="Cambiar estado">
                                            <i class="fas fa-toggle-{{ $suc->activo ? 'on' : 'off' }}"></i>
                                        </button>
                                    </form>
                                    {{-- Editar --}}
                                    <a href="{{ route('sucursales.edit', $suc) }}" class="btn btn-primary btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- Eliminar --}}
                                    <form action="{{ route('sucursales.destroy', $suc) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar sucursal?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

{{-- JavaScript para combos dependientes --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cambia localidades cuando cambia provincia
    document.getElementById('provincia_id').addEventListener('change', function() {
        const provId = this.value;
        const localidadSelect = document.getElementById('localidad_id');
        localidadSelect.innerHTML = '<option value="">Cargando...</option>';
        fetch('/provincias/' + provId + '/localidades')
            .then(resp => resp.json())
            .then(data => {
                let html = '<option value="">Elija...</option>';
                data.forEach(loc => {
                    html += `<option value="${loc.id}">${loc.nombre}</option>`;
                });
                localidadSelect.innerHTML = html;
                // Limpiar zona
                document.getElementById('zona_nombre').value = '';
                document.getElementById('zona_id').value = '';
            });
    });

    // Cambia zona cuando cambia localidad
    document.getElementById('localidad_id').addEventListener('change', function() {
        const locId = this.value;
        if (!locId) {
            document.getElementById('zona_nombre').value = '';
            document.getElementById('zona_id').value = '';
            return;
        }
        fetch('/localidades/' + locId + '/zona')
            .then(resp => resp.json())
            .then(data => {
                document.getElementById('zona_nombre').value = data ? data.nombre : '';
                document.getElementById('zona_id').value = data ? data.id : '';
            });
    });
});
</script>
@stop




