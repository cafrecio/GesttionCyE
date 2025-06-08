{{-- Modal LISTADO de sucursales --}}
<div class="modal fade"
     id="sucursales-{{ $cliente->codigo }}"
     tabindex="-1"
     aria-labelledby="sucursalesLabel-{{ $cliente->codigo }}"
     aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="sucursalesLabel-{{ $cliente->codigo }}">
          Sucursales de {{ $cliente->razon_social }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        {{-- LISTA --}}
        @if ($cliente->sucursales->count())
          <ul class="list-group mb-3">
            @foreach ($cliente->sucursales as $sc)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                  <strong>{{ $sc->nombre }}</strong>
                  <small class="text-muted">
                    ({{ $sc->localidad->nombre ?? '-' }})
                  </small>
                </span>
                <span>
                  {{-- Toggle activo --}}
                  <form  action="{{ route('sucursales.toggle', $sc) }}"
                         method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm {{ $sc->activo ? 'btn-success' : 'btn-secondary' }}"
                            title="Cambiar estado">
                      <i class="fas fa-toggle-{{ $sc->activo ? 'on' : 'off' }}"></i>
                    </button>
                  </form>

                  {{-- Editar --}}
                  <button class="btn btn-sm btn-primary"
                          data-bs-toggle="modal"
                          data-bs-target="#editSucursal-{{ $sc->id }}"
                          data-bs-dismiss="modal">
                    <i class="fas fa-edit"></i>
                  </button>
                </span>
              </li>

              {{-- EDIT — se inyecta fuera del modal-lista --}}
              @push('modals')
                @include('sucursales._modal_edit', ['sucursale'=>$sc, 'cliente'=>$cliente])
              @endpush
            @endforeach
          </ul>
        @else
          <p class="text-muted">Sin sucursales cargadas.</p>
        @endif

        {{-- NUEVA --}}
        <button  class="btn btn-outline-primary btn-sm"
                 data-bs-toggle="modal"
                 data-bs-target="#addSucursal-{{ $cliente->codigo }}"
                 data-bs-dismiss="modal">
          <i class="fas fa-plus"></i> Nueva sucursal
        </button>

        @push('modals')
          @include('sucursales._modal_create', ['cliente'=>$cliente])
        @endpush

      </div>
    </div>
  </div>
</div>

