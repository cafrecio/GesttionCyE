@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<h1>Clientes</h1>

{{-- FILTRO Y SINCRONIZAR --}}
<div class="row mb-3 align-items-end">
    <div class="col-md-8">
        <form class="row g-2" method="GET">
            <div class="col-auto">
                <input name="filtro"
                       class="form-control form-control-sm"
                       placeholder="Código, CUIT o razón social…"
                       value="{{ request('filtro') }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm">Buscar</button>
                <a href="{{ route('clientes.index') }}"
                   class="btn btn-outline-secondary btn-sm">Limpiar</a>
            </div>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <form action="{{ route('clientes.sync') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-warning btn-sm"
                    onclick="return confirm('¿Sincronizar clientes ahora?')">
                <i class="fas fa-sync-alt"></i> Sincronizar ERP
            </button>
        </form>
    </div>
</div>

{{-- MENSAJES --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- TABLA DE CLIENTES --}}
<table class="table table-sm table-bordered align-middle">
    <thead>
        <tr>
            <th>Código</th>
            <th>Razón social</th>
            <th>CUIT</th>
            <th>Iniciales vendedor</th>
            <th>Retira</th>
            <th>Contactos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->codigo }}</td>
                <td>{{ $cliente->razon_social }}</td>
                <td>{{ $cliente->cuit }}</td>
                <td>{{ $cliente->iniciales_vendedor }}</td>
                <td>
                    <form action="{{ route('clientes.toggleRetira', $cliente->codigo) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm {{ $cliente->retira ? 'btn-success' : 'btn-outline-secondary' }}">
                            {{ $cliente->retira ? 'Sí' : 'No' }}
                        </button>
                    </form>
                </td>
                <td>
                    <button class="btn btn-link p-0"
                            data-bs-toggle="modal"
                            data-bs-target="#modalContactos-{{ $cliente->codigo }}">
                        {{ $cliente->contactos->count() }} contacto(s)
                    </button>
                </td>
                <td>
                    <button class="btn btn-link p-0"
                            data-bs-toggle="modal"
                            data-bs-target="#modalSucursales-{{ $cliente->codigo }}">
                        {{ $cliente->sucursales->count() }} sucursal(es)
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- PAGINACIÓN --}}
<div>
    {{ $clientes->links() }}
</div>

{{-- MODALES DE CONTACTOS (LISTA) --}}
@foreach ($clientes as $cliente)
    @include('contactos._modal_list', ['cliente' => $cliente])
@endforeach

{{-- MODALES CREAR Y EDITAR --}}
{{-- Se generan todos los modales de crear y editar fuera de los modales-lista --}}
@foreach ($clientes as $cliente)
    @include('contactos._modal_create', ['cliente' => $cliente])
    @foreach ($cliente->contactos as $contacto)
        @include('contactos._modal_edit', ['cliente' => $cliente, 'contacto' => $contacto])
    @endforeach
@endforeach

{{-- MODALES DE SUCURSALES (LISTA) --}}
@foreach ($clientes as $cliente)
    @include('sucursales._modal_list', ['cliente' => $cliente])
@endforeach

{{-- MODALES CREAR Y EDITAR --}}
{{-- Se generan todos los modales de crear y editar fuera de los modales-lista --}}
@foreach ($clientes as $cliente)
    @include('sucursales._modal_create', ['cliente' => $cliente])
    @foreach ($cliente->sucursales as $sucursale)
        @include('sucursales._modal_edit', ['cliente' => $cliente, 'sucursale' => $sucursale])
    @endforeach
@endforeach

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Botón NUEVO contacto
    document.querySelectorAll('.abrir-modal-crear').forEach(function(btn) {
        btn.addEventListener('click', function () {
            var clienteCodigo = btn.getAttribute('data-cliente');
            var modalCrear = document.getElementById('modalCrearContacto-' + clienteCodigo);
            var bsModalCrear = new bootstrap.Modal(modalCrear);
            bsModalCrear.show();
        });
    });

    // Botón EDITAR contacto
    document.querySelectorAll('.abrir-modal-editar').forEach(function(btn) {
        btn.addEventListener('click', function () {
            var clienteCodigo = btn.getAttribute('data-cliente');
            var contactoId = btn.getAttribute('data-contacto');
            var modalEditar = document.getElementById('modalEditarContacto-' + clienteCodigo + '-' + contactoId);
            var bsModalEditar = new bootstrap.Modal(modalEditar);
            bsModalEditar.show();
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Modal crear sucursal
    document.querySelectorAll('.abrir-modal-crear-sucursal').forEach(function(btn) {
        btn.addEventListener('click', function () {
            var clienteCodigo = btn.getAttribute('data-cliente');
            var modalCrear = document.getElementById('modalCrearSucursal-' + clienteCodigo);
            var bsModalCrear = new bootstrap.Modal(modalCrear);
            bsModalCrear.show();
        });
    });

    // Modal editar sucursal
    document.querySelectorAll('.abrir-modal-editar-sucursal').forEach(function(btn) {
        btn.addEventListener('click', function () {
            var clienteCodigo = btn.getAttribute('data-cliente');
            var sucursalId = btn.getAttribute('data-sucursal');
            var modalEditar = document.getElementById('modalEditarSucursal-' + clienteCodigo + '-' + sucursalId);
            var bsModalEditar = new bootstrap.Modal(modalEditar);
            bsModalEditar.show();
        });
    });

    // AJAX para localidades por provincia en crear y editar sucursal
    document.querySelectorAll('[id^="modalCrearSucursal-"], [id^="modalEditarSucursal-"]').forEach(function(modal){
        modal.addEventListener('shown.bs.modal', function () {
            let provinciaSelect = modal.querySelector('select[name="provincia_id"]');
            let localidadSelect = modal.querySelector('select[name="localidade_id"]');
            let localidadIdOld = localidadSelect ? localidadSelect.getAttribute('data-old') : null;

            if(provinciaSelect && localidadSelect){
                provinciaSelect.onchange = function(){
                    let provinciaId = this.value;
                    localidadSelect.innerHTML = '<option value="">Cargando...</option>';
                    if(provinciaId){
                        fetch('/ajax/localidades/' + provinciaId)
                            .then(r => r.json())
                            .then(list => {
                                localidadSelect.innerHTML = '<option value="">Seleccione...</option>';
                                list.forEach(loc => {
                                    let option = document.createElement('option');
                                    option.value = loc.id;
                                    option.text = loc.nombre;
                                    if(localidadIdOld && localidadIdOld == loc.id){
                                        option.selected = true;
                                    }
                                    localidadSelect.appendChild(option);
                                });
                            });
                    } else {
                        localidadSelect.innerHTML = '<option value="">Seleccione provincia primero</option>';
                    }
                }
                // Trigger on load (editar)
                if(provinciaSelect.value){
                    localidadSelect.setAttribute('data-old', localidadSelect.value || '');
                    provinciaSelect.onchange();
                }
            }

            // Si hay select de transporte en este modal
            let transporteSelect = modal.querySelector('select[id^="transporte_id_"]');
            let sucursalTransporteSelect = modal.querySelector('select[name="transporte_sucursale_id"]');
            if(transporteSelect && sucursalTransporteSelect){
                transporteSelect.onchange = function() {
                    let transporteId = this.value;
                    sucursalTransporteSelect.innerHTML = '<option value="">Cargando...</option>';
                    if(transporteId){
                        fetch('/ajax/sucursales-transporte/' + transporteId)
                            .then(r => r.json())
                            .then(list => {
                                sucursalTransporteSelect.innerHTML = '<option value="">Seleccione sucursal...</option>';
                                list.forEach(loc => {
                                    let option = document.createElement('option');
                                    option.value = loc.id;
                                    option.text = loc.nombre + ' (' + (loc.localidad_nombre || '-') + ', ' + (loc.provincia_nombre || '-') + ')';
                                    sucursalTransporteSelect.appendChild(option);
                                });
                            });
                    } else {
                        sucursalTransporteSelect.innerHTML = '<option value="">Seleccione transporte primero</option>';
                    }
                }
            }
        });
    });
});
</script>
@endpush








