{{-- Modal CREAR contacto --}}
<div class="modal fade" id="modalCrearContacto-{{ $cliente->codigo }}" tabindex="-1"
     aria-labelledby="modalCrearContactoLabel-{{ $cliente->codigo }}" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('clientes.contactos.store', $cliente->codigo) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearContactoLabel-{{ $cliente->codigo }}">
          Nuevo contacto de {{ $cliente->razon_social }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        {{-- Tipo --}}
        <div class="mb-3">
          <label class="form-label">Tipo <span class="text-danger">*</span></label>
          <select name="tipo_id" class="form-select @error('tipo_id') is-invalid @enderror" required>
            <option value="">Seleccione…</option>
            @foreach(\App\Models\TipoContacto::all() as $t)
              <option value="{{ $t->id }}" {{ old('tipo_id')==$t->id?'selected':'' }}>
                {{ $t->nombre }}
              </option>
            @endforeach
          </select>
          @error('tipo_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Nombre --}}
        <div class="mb-3">
          <label class="form-label">Nombre <span class="text-danger">*</span></label>
          <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                 value="{{ old('nombre') }}" required>
          @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Apellido --}}
        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                 value="{{ old('apellido') }}">
          @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Email --}}
        <div class="mb-3">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Teléfono --}}
        <div class="mb-3">
          <label class="form-label">Teléfono <span class="text-danger">*</span></label>
          <input name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                 value="{{ old('telefono') }}" required>
          @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>




