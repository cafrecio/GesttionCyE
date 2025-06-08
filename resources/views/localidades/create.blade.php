@extends('layouts.app')

@section('title', 'Crear Localidad')

@section('content_header')
    <h1>Crear Nueva Localidad</h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('localidades.index') }}">Localidades</a></li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulario de Nueva Localidad</h3>
            </div>

            <form action="{{ route('localidades.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="nombre">Nombre de la Localidad</label>
                        <input  id="nombre" name="nombre"
                                class="form-control"
                                placeholder="Ingrese el nombre" required>
                    </div>

                    {{-- Provincia --}}
                    <div class="form-group">
                        <label for="provincia_id">Provincia</label>
                        <select id="provincia_id" name="provincia_id" class="form-control" required>
                            <option value="">Seleccione una provincia</option>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
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
                    <button class="btn btn-primary">Guardar</button>
                    <a href="{{ route('localidades.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('js')   {{--  scripts específicos de esta vista --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const zonaSelect = document.getElementById('zona_id');
    const zonaDescripcion = document.getElementById('zona_descripcion');
    const baseUrl = '{{ url('/') }}';

    zonaSelect.addEventListener('change', () => {
        const id = zonaSelect.value;
        if (!id) return zonaDescripcion.textContent = '';

        fetch(`${baseUrl}/zonas/${id}`)
            .then(r => r.json())
            .then(data => zonaDescripcion.textContent = data?.descripcion ? `Descripción: ${data.descripcion}` : '')
            .catch(() => zonaDescripcion.textContent = '');
    });
});
</script>
@endpush
