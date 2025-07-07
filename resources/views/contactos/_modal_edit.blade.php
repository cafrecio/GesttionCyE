{{-- Modal EDITAR contacto --}}
<div class="modal fade" id="modalEditarContacto-{{ $cliente->codigo }}-{{ $contacto->id }}" tabindex="-1"
     aria-labelledby="modalEditarContactoLabel-{{ $cliente->codigo }}-{{ $contacto->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content"
          action="{{ route('clientes.contactos.update', [$cliente->codigo, $contacto->id]) }}"
          method="POST">
      @csrf @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarContactoLabel-{{ $cliente->codigo }}-{{ $contacto->id }}">
          Editar contacto
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        {{-- Tipo --}}
        <div class="mb-3">
          <label class="form-label">Tipo <span class="text-danger">*</span></label>
          <select name="tipo_id" class="form-select @error('tipo_id') is-invalid @enderror" required>
            @foreach(\App\Models\TipoContacto::all() as $t)
              <option value="{{ $t->id }}" {{ $contacto->tipo_id==$t->id?'selected':'' }}>
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
                 value="{{ old('nombre',$contacto->nombre) }}" required>
          @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Apellido --}}
        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                 value="{{ old('apellido',$contacto->apellido) }}">
          @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Email --}}
        <div class="mb-3">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email',$contacto->email) }}" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        {{-- Teléfono --}}
        <div class="mb-3">
          <label class="form-label">Teléfono <span class="text-danger">*</span></label>
          <input name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                 value="{{ old('telefono',$contacto->telefono) }}" required>
          @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>













