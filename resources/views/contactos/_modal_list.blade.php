{{-- Modal LISTADO de contactos --}}
<div class="modal fade" id="modalContactos-{{ $cliente->codigo }}" tabindex="-1"
     aria-labelledby="modalContactosLabel-{{ $cliente->codigo }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalContactosLabel-{{ $cliente->codigo }}">
          Contactos de {{ $cliente->razon_social }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        @if ($cliente->contactos->count())
          <table class="table table-sm align-middle">
            <thead>
              <tr>
                <th>Tipo</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($cliente->contactos as $contacto)
                <tr>
                  <td>{{ $contacto->tipo->nombre }}</td>
                  <td>{{ $contacto->nombre }} {{ $contacto->apellido }}</td>
                  <td>{{ $contacto->email }}</td>
                  <td>{{ $contacto->telefono }}</td>
                  <td class="text-end">
                    <button
                      class="btn btn-sm btn-outline-primary abrir-modal-editar-contacto"
                      data-cliente="{{ $cliente->codigo }}"
                      data-contacto="{{ $contacto->id }}"
                      data-bs-dismiss="modal">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('clientes.contactos.destroy', [$cliente->codigo, $contacto->id]) }}"
                          method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('¿Eliminar contacto?')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p class="text-muted">Sin contactos cargados.</p>
        @endif

        <hr>
        <div class="text-end">
          <button
            class="btn btn-sm btn-success abrir-modal-crear-contacto"
            data-cliente="{{ $cliente->codigo }}"
            data-bs-dismiss="modal">
            <i class="fas fa-plus"></i> Nuevo contacto
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


