<div class="modal fade" id="modalCrearContacto-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="modalCrearContactoLabel-{{ $cliente->codigo }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('clientes.contactos.store', $cliente->codigo) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearContactoLabel-{{ $cliente->codigo }}">Nuevo contacto para {{ $cliente->razon_social }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Errores de validación --}}
                @if(session('modal_cliente_codigo') == $cliente->codigo && session('modal_open') == 'create' && $errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-2">
                    <label>Tipo <span class="text-danger">*</span></label>
                    <select name="tipo_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\TipoContacto::all() as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label>Nombre <span class="text-danger">*</span></label>
                    <input name="nombre" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Apellido</label>
                    <input name="apellido" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Email <span class="text-danger">*</span></label>
                    <input name="email" type="email" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Teléfono <span class="text-danger">*</span></label>
                    <input name="telefono" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>


