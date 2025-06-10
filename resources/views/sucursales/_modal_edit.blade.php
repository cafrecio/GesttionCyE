<div class="modal fade" id="modalEditarSucursal-{{ $cliente->codigo }}-{{ $sucursale->id }}" tabindex="-1" aria-labelledby="modalEditarSucursalLabel-{{ $cliente->codigo }}-{{ $sucursale->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('clientes.sucursales.update', [$cliente->codigo, $sucursale->id]) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarSucursalLabel-{{ $cliente->codigo }}-{{ $sucursale->id }}">
                    Editar sucursal de {{ $cliente->razon_social }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>Nombre <span class="text-danger">*</span></label>
                    <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $sucursale->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Calle <span class="text-danger">*</span></label>
                    <input name="calle" class="form-control @error('calle') is-invalid @enderror"
                           value="{{ old('calle', $sucursale->calle) }}" required>
                    @error('calle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Número</label>
                    <input name="numero" class="form-control @error('numero') is-invalid @enderror"
                           value="{{ old('numero', $sucursale->numero) }}">
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label>Provincia <span class="text-danger">*</span></label>
                    <select name="provincia_id" class="form-control @error('provincia_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach(\App\Models\Provincia::orderBy('nombre')->get() as $prov)
                            <option value="{{ $prov->id }}" {{ old('provincia_id', $sucursale->provincia_id) == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
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
                {{-- Si la zona es Z99 y el cliente no retira, mostramos transporte y sucursal de transporte --}}
                @php
                    $zonaObj = $sucursale->zona;
                    $mostrarTransporte = $zonaObj && $zonaObj->nombre === 'Z99' && !$cliente->retira;
                @endphp
                @if($mostrarTransporte)
                    <div class="mb-2">
                        <label>Transporte <span class="text-danger">*</span></label>
                        <select id="transporte_id_{{ $sucursale->id }}" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach(\App\Models\Transporte::where('activo', 1)->get() as $t)
                                <option value="{{ $t->id }}">{{ $t->razon_social }}</option>
                            @endforeach
                        </select>
                        <a href="{{ route('transportes.create') }}" target="_blank">+ Nuevo transporte</a>
                    </div>
                    <div class="mb-2">
                        <label>Sucursal de Transporte <span class="text-danger">*</span></label>
                        <select name="transporte_sucursale_id" class="form-control @error('transporte_sucursale_id') is-invalid @enderror" required>
                            <option value="">Seleccione transporte...</option>
                            {{-- Sucursales del transporte se cargan por JS/AJAX según el transporte elegido --}}
                        </select>
                        <a href="{{ route('transportesucursales.create') }}" target="_blank">+ Nueva sucursal de transporte</a>
                        @error('transporte_sucursale_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>




