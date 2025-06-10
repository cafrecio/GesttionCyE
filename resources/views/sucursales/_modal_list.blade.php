<div class="modal fade" id="modalSucursales-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="modalSucursalesLabel-{{ $cliente->codigo }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSucursalesLabel-{{ $cliente->codigo }}">
                    Sucursales de {{ $cliente->razon_social }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(session('modal_cliente_codigo') == $cliente->codigo && $errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($cliente->sucursales->count())
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Calle/Número</th>
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
                                    <td>{{ $sucursale->localidad->nombre ?? '-' }}</td>
                                    <td>{{ $sucursale->provincia->nombre ?? '-' }}</td>
                                    <td>{{ $sucursale->zona->nombre ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm abrir-modal-editar-sucursal"
                                            data-cliente="{{ $cliente->codigo }}"
                                            data-sucursal="{{ $sucursale->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('clientes.sucursales.destroy', [$cliente->codigo, $sucursale->id]) }}"
                                              method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar sucursal?')">
                                                <i class="fas fa-trash"></i>
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



