@extends('layouts.app')

@section('title', 'Crear Sucursal')

@section('content')
<div class="col-md-8">
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Nueva Sucursal para {{ $cliente->razon_social }}</h3></div>
        <form action="{{ route('clientes.sucursales.store', $cliente->codigo) }}" method="POST">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <label>Nombre de la sucursal</label>
                    <input name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Calle</label>
                    <input name="calle" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label>Número</label>
                    <input name="numero" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Provincia</label>
                    <select name="provincia_id" class="form-control" required id="provincia_id">
                        <option value="">Elija...</option>
                        @foreach($provincias as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Localidad</label>
                    <select name="localidade_id" class="form-control" required id="localidade_id">
                        <option value="">Elija provincia primero</option>
                    </select>
                    <a href="#" id="btnNuevaLocalidad" class="btn btn-link btn-sm">Crear nueva localidad</a>
                </div>
                <div class="col-md-2">
                    <label>Zona</label>
                    <input type="text" class="form-control" id="zona_nombre" value="" readonly>
                    <input type="hidden" name="zona_id" id="zona_id" value="">
                </div>
                <div class="col-md-4">
                    <label>Transporte (sólo para Z99 sin retiro)</label>
                    <select name="transporte_sucursale_id" class="form-control">
                        <option value="">Elija...</option>
                        @foreach($transportes as $transp)
                            <option value="{{ $transp->id }}">{{ $transp->nombre ?? $transp->calle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('clientes.edit', $cliente->codigo) }}" class="btn btn-secondary">Cancelar</a>
            </div>
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
