@extends('layouts.app')

@section('title', 'Editar Localidad')

@section('content_header')
    <h1>Editar Localidad</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('localidades.index') }}">Localidades</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Formulario de Edición</h3></div>

            <form action="{{ route('localidades.update', $localidad) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="nombre">Nombre de la Localidad</label>
                        <input  id="nombre" name="nombre"
                                class="form-control"
                                value="{{ $localidad->nombre }}" required>
                    </div>

                    {{-- Provincia --}}
                    <div class="form-group">
                        <label for="provincia_id">Provincia</label>
                        <select id="provincia_id" name="provincia_id" class="form-control" required>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}"
                                    {{ $localidad->provincia_id==$provincia->id ? 'selected' : '' }}>
                                    {{ $provincia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Zona --}}
                    <div class="form-group">
                        <label for="zona_id">Zona <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control" id="zona_id" name="zona_id" required>
                                <option value="">Seleccione una zona (opcional)</option>
                                @foreach ($zonas as $zona)
                                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('zonas.create') }}" target="_blank" class="btn btn-outline-primary">Nueva Zona</a>
                        </div>
                        <small id="zona_descripcion" class="form-text text-muted"></small>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('localidades.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>

            <form action="{{ route('localidades.destroy', $localidad) }}"
                  method="POST" class="mt-3"
                  onsubmit="return confirm('¿Eliminar localidad?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger float-right">Eliminar Localidad</button>
            </form>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const zonaSelect      = document.getElementById('zona_id');
    const zonaDescripcion = document.getElementById('zona_descripcion');
    const baseUrl         = '{{ url('/') }}';

    function cargarDesc(id) {
        fetch(`${baseUrl}/zonas/${id}`)
            .then(r => r.json())
            .then(d => zonaDescripcion.textContent = d?.descripcion ? `Descripción: ${d.descripcion}` : '')
            .catch(() => zonaDescripcion.textContent = '');
    }

    zonaSelect.addEventListener('change', () => {
        if (zonaSelect.value) cargarDesc(zonaSelect.value);
        else zonaDescripcion.textContent = '';
    });

    // descripción inicial
    if (zonaSelect.value) cargarDesc(zonaSelect.value);
});
</script>
@endpush
