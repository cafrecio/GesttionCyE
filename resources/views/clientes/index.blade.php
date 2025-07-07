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

    {{-- TABLA DE CLIENTES --}}
    <table class="table table-sm table-bordered align-middle">
        <thead>
            <tr>
                <th>Código</th>
                <th>Razón social</th>
                <th>CUIT</th>
                <th>Vendedor</th>
                <th>Retira</th>
                <th>Contactos</th>
                <th>Sucursales</th>
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
    <div>{{ $clientes->links() }}</div>

    {{-- INCLUIMOS TODOS LOS MODALES DE CONTACTOS Y SUCURSALES --}}
    @foreach($clientes as $cliente)
        @include('contactos._modal_list', ['cliente' => $cliente])
        @include('contactos._modal_create', ['cliente' => $cliente])
        @foreach($cliente->contactos as $contacto)
            @include('contactos._modal_edit', ['cliente'=>$cliente,'contacto'=>$contacto])
        @endforeach

        @include('sucursales._modal_list', ['cliente' => $cliente])
        @include('sucursales._modal_create', ['cliente' => $cliente])
        @foreach($cliente->sucursales as $sucursale)
            @include('sucursales._modal_edit', ['cliente'=>$cliente,'sucursale'=>$sucursale])
        @endforeach
    @endforeach
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Abrir modal crear sucursal
    document.querySelectorAll('.abrir-modal-crear-sucursal').forEach(btn => {
        btn.addEventListener('click', () => {
            const codigo = btn.dataset.cliente;
            new bootstrap.Modal(document.getElementById('modalCrearSucursal-' + codigo)).show();
        });
    });
    // Abrir modal editar sucursal
    document.querySelectorAll('.abrir-modal-editar-sucursal').forEach(btn => {
        btn.addEventListener('click', () => {
            const c = btn.dataset.cliente, s = btn.dataset.sucursal;
            new bootstrap.Modal(document.getElementById(`modalEditarSucursal-${c}-${s}`)).show();
        });
    });
    // AJAX localidades por provincia en Sucursales
    document.querySelectorAll('[id^="modalCrearSucursal-"],[id^="modalEditarSucursal-"]').forEach(modal => {
        modal.addEventListener('shown.bs.modal', () => {
            const prov = modal.querySelector('select[name="provincia_id"]');
            const loc  = modal.querySelector('select[name="localidade_id"]');
            if (!prov || !loc) return;
            prov.onchange = () => {
                loc.innerHTML = '<option>Cargando…</option>';
                fetch(`/ajax/localidades/${prov.value}`)
                    .then(r => r.json())
                    .then(list => {
                        loc.innerHTML = '<option value="">Seleccione…</option>';
                        list.forEach(o => loc.add(new Option(o.nombre, o.id)));
                    });
            };
            if (prov.value) prov.onchange();
        });
    });
});
</script>
@endpush









