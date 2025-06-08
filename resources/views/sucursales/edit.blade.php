@extends('layouts.app')

@section('title', 'Editar Sucursal')

@section('content')
<div class="col-md-8">
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Editar Sucursal de {{ $cliente->razon_social }}</h3></div>
        <form action="{{ route('sucursales.update', $sucursale) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body row">
                <div class="col-md-6">
                    <label>Nombre de la sucursal</label>
                    <input name="nombre" class="form-control" value="{{ $sucursale->nombre }}" required>
                </div>
                <div class="col-md-6">
                    <label>Calle</label>
                    <input name="calle" class="form-control" value="{{ $sucursale->calle }}" required>
                </div>
                <div class="col-md-2">
                    <label>Número</label>
                    <input name="numero" class="form-control" value="{{ $sucursale->numero }}">
                </div>
                <div class="col-md-4">
                    <label>Provincia</label>
                    <select name="provincia_id" class="form-control" required id="provincia_id">
                        <option value="">Elija...</option>
                        @foreach($provincias as $prov)
                            <option value="{{ $prov->id }}" {{ $sucursale->provincia_id == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Localidad</label>
                    <select name="localidade_id" class="form-control" required id="localidade_id">
                        <option value="">Elija provincia primero</option>
                        @foreach($localidades as $loc)
                            <option value="{{ $loc->id }}" {{ $sucursale->localidade_id == $loc->id ? 'selected' : '' }}>{{ $loc->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Zona</label>
                    <input type="text" class="form-control" id="zona_nombre" value="{{ $sucursale->zona->nombre ?? '' }}" readonly>
                    <input type="hidden" name="zona_id" id="zona_id" value="{{ $sucursale->zona_id ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label>Transporte (sólo para Z99 sin retiro)</label>
                    <select name="transporte_sucursale_id" class="form-control">
                        <option value="">Elija...</option>
                        @foreach($transportes as $transp)
                            <option value="{{ $transp->id }}" {{ $sucursale->transporte_sucursale_id == $transp->id ? 'selected' : '' }}>
                                {{ $transp->nombre ?? $transp->calle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Activo</label><br>
                    <input type="checkbox" name="activo" value="1" {{ $sucursale->activo ? 'checked' : '' }}>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('clientes.edit', $cliente->codigo) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
        <form action="{{ route('sucursales.destroy', $sucursale) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger mt-2" onclick="return confirm('¿Eliminar sucursal?')">Eliminar</button>
        </form>
    </div>
</div>

{{-- Scripts para combos dependientes --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('provincia_id').addEventListener('change', function() {
        const provId = this.value;
        const localidadSelect = document.getElementById('localidade_id');
        localidadSelect.innerHTML = '<option value="">Cargando...</option>';
        fetch('/provincias/' + provId + '/localidades')
            .then(resp => resp.json())
            .then(data => {
                let html = '<option value="">Elija...</option>';
                data.forEach(loc => {
                    html += `<option value="${loc.id}">${loc.nombre}</option>`;
                });
                localidadSelect.innerHTML = html;
                document.getElementById('zona_nombre').value = '';
                document.getElementById('zona_id').value = '';
            });
    });

    document.getElementById('localidade_id').addEventListener('change', function() {
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
@endsection
