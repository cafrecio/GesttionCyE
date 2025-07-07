{{-- Modal LISTADO de sucursales --}}
<div class="modal fade"
     id="modalSucursales-{{ $cliente->codigo }}"
     tabindex="-1"
     aria-labelledby="modalSucursalesLabel-{{ $cliente->codigo }}"
     aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalSucursalesLabel-{{ $cliente->codigo }}">
          Sucursales de {{ $cliente->razon_social }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        @if ($cliente->sucursales->count())
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>Provincia</th>
                <th>Zona</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cliente->sucursales as $sucursale)
                <tr>
                  <td>{{ $sucursale->nombre }}</td>
                  <td>{{ $sucursale->calle }} {{ $sucursale->numero }}</td>
                  <td>{{ optional($sucursale->localidad)->nombre ?? '-' }}</td>
                  <td>{{ optional($sucursale->provincia)->nombre ?? '-' }}</td>
                  <td>{{ optional($sucursale->zona)->nombre ?? '-' }}</td>
                  <td class="text-nowrap">
                    {{-- Editar --}}
                    <button class="btn btn-outline-primary btn-sm abrir-modal-editar-sucursal"
                            data-cliente="{{ $cliente->codigo }}"
                            data-sucursal="{{ $sucursale->id }}">
                      <i class="fas fa-edit"></i>
                    </button>

                    {{-- Toggle activo/inactivo (verde/gris) --}}
                    <form action="{{ route('clientes.sucursales.toggle', [$cliente->codigo, $sucursale->id]) }}"
                          method="POST" class="d-inline">
                      @csrf
                      <button class="btn btn-sm {{ $sucursale->activo ? 'btn-success' : 'btn-outline-secondary' }}">
                        <i class="fas fa-toggle-{{ $sucursale->activo ? 'on' : 'off' }}"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p class="text-muted">Sin sucursales cargadas.</p>
        @endif

        <button class="btn btn-success abrir-modal-crear-sucursal"
                data-cliente="{{ $cliente->codigo }}">
          <i class="fas fa-plus"></i> Nueva sucursal
        </button>
      </div>

    </div>
  </div>
</div>









