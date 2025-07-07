{{-- Modal CREAR sucursal --}}
<div class="modal fade modal-sucursal"
     id="modalCrearSucursal-{{ $cliente->codigo }}"
     data-retira="{{ $cliente->retira ? 1 : 0 }}"
     tabindex="-1"
     aria-labelledby="modalCrearSucursalLabel-{{ $cliente->codigo }}"
     aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content"
          action="{{ route('clientes.sucursales.store', $cliente->codigo) }}"
          method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearSucursalLabel-{{ $cliente->codigo }}">
          Nueva sucursal para {{ $cliente->razon_social }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        {{-- campos básicos --}}
        <div class="mb-2">
          <label>Nombre <span class="text-danger">*</span></label>
          <input name="nombre"
                 class="form-control @error('nombre') is-invalid @enderror"
                 value="{{ old('nombre') }}"
                 required>
          @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-2">
          <label>Calle <span class="text-danger">*</span></label>
          <input name="calle"
                 class="form-control @error('calle') is-invalid @enderror"
                 value="{{ old('calle') }}"
                 required>
          @error('calle') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-2">
          <label>Número</label>
          <input name="numero"
                 class="form-control @error('numero') is-invalid @enderror"
                 value="{{ old('numero') }}">
          @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- provincia / localidad --}}
        <div class="mb-2">
          <label>Provincia <span class="text-danger">*</span></label>
          <select name="provincia_id"
                  class="form-control @error('provincia_id') is-invalid @enderror"
                  required>
            <option value="">Seleccione…</option>
            @foreach(\App\Models\Provincia::orderBy('nombre')->get() as $prov)
              <option value="{{ $prov->id }}"
                      {{ old('provincia_id') == $prov->id ? 'selected' : '' }}>
                {{ $prov->nombre }}
              </option>
            @endforeach
          </select>
          @error('provincia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-2">
          <label>Localidad <span class="text-danger">*</span></label>
          <select name="localidade_id"
                  class="form-control @error('localidade_id') is-invalid @enderror"
                  required>
            <option value="">Seleccione provincia primero</option>
          </select>
          @error('localidade_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          <livewire:create-localidad :provinciaId="$sucursal->provincia_id ?? null" />
        </div>
        {{-- zona automática --}}
        <div class="mb-2">
          <label>Zona</label>
          <input type="text" name="zona_nombre" class="form-control" readonly>
          <input type="hidden" name="zona_id" value="">
        </div>
        {{-- transporte sólo si Z99 y no retira --}}
        <div class="mb-2 d-none" id="transporte_group_crear_{{ $cliente->codigo }}">
          <label>Transporte <span class="text-danger">*</span></label>
          <select name="transporte_id" class="form-control">
            <option value="">Seleccione…</option>
            @foreach(\App\Models\Transporte::where('activo', true)->get() as $t)
              <option value="{{ $t->id }}">{{ $t->razon_social }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-2 d-none" id="sucursal_transporte_group_crear_{{ $cliente->codigo }}">
          <label>Sucursal de Transporte <span class="text-danger">*</span></label>
          <select name="transporte_sucursale_id" class="form-control">
            <option value="">Seleccione transporte primero</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>















