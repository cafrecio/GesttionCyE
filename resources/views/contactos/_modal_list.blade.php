<div class="modal fade" id="modalContactos-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="modalContactosLabel-{{ $cliente->codigo }}" aria-hidden="true">
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
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cliente->contactos as $contacto)
                                <tr>
                                    <td>{{ $contacto->tipo->nombre ?? '-' }}</td>
                                    <td>{{ $contacto->nombre }}</td>
                                    <td>{{ $contacto->apellido }}</td>
                                    <td>{{ $contacto->email }}</td>
                                    <td>{{ $contacto->telefono }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm abrir-modal-editar"
                                            data-cliente="{{ $cliente->codigo }}"
                                            data-contacto="{{ $contacto->id }}">
                                            Editar
                                        </button>

                                        <form action="{{ route('clientes.contactos.destroy', [$cliente->codigo, $contacto->id]) }}"
                                              method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar contacto?')">
                                                Eliminar
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

                <button class="btn btn-success abrir-modal-crear"
                    data-cliente="{{ $cliente->codigo }}">
                    Nuevo contacto
                </button>
            </div>
        </div>
    </div>
</div>

