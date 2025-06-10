<div class="modal fade" id="modalCrearSucursal-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="modalCrearSucursalLabel-{{ $cliente->codigo }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('clientes.sucursales.store', $cliente->codigo) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearSucursalLabel-{{ $cliente->codigo }}">
                    Nueva sucursal para {{ $cliente->razon_social }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Nombre <span class="text-danger">*</span></label>
                    <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Calle <span class="text-danger">*</span></label>
                    <input name="calle" class="form-control @error('calle') is-invalid @enderror"
                           value="{{ old('calle') }}" required>
                    @error('calle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Número</label>
                    <input name="numero" class="form-control @error('numero') is-invalid @enderror"
                           value="{{ old('numero') }}">
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Provincia <span class="text-danger">*</span></label>
                    <select name="provincia_id" class="form-control @error('provincia_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Provincia::orderBy('nombre')->get() as $prov)
                            <option value="{{ $prov->id }}" {{ old('provincia_id') == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('provincias.create') }}" target="_blank">+ Nueva provincia</a>
                    @error('provincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Localidad <span class="text-danger">*</span></label>
                    <select name="localidade_id" class="form-control @error('localidade_id') is-invalid @enderror" required>
                        <option value="">Seleccione provincia primero</option>
                    </select>
                    <a href="{{ route('localidades.create') }}" target="_blank">+ Nueva localidad</a>
                    @error('localidade_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>






