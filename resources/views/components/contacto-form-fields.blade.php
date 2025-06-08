@props(['tipos','contacto'=>null])

<div class="mb-2">
  <label>Tipo</label>
  <select name="tipo_id" class="form-control" required>
    <option value="">Seleccione…</option>
    @foreach($tipos as $t)
      <option value="{{ $t->id }}"
        {{ optional($contacto)->tipo_id == $t->id ? 'selected' : '' }}>
        {{ $t->nombre }}
      </option>
    @endforeach
  </select>
</div>
<div class="mb-2"><label>Nombre</label>
  <input name="nombre" class="form-control"
         value="{{ $contacto->nombre ?? old('nombre') }}" required>
</div>
<div class="mb-2"><label>Apellido</label>
  <input name="apellido" class="form-control"
         value="{{ $contacto->apellido ?? old('apellido') }}">
</div>
<div class="mb-2"><label>Email</label>
  <input name="email" class="form-control"
         value="{{ $contacto->email ?? old('email') }}">
</div>
<div class="mb-2"><label>Teléfono</label>
  <input name="telefono" class="form-control"
         value="{{ $contacto->telefono ?? old('telefono') }}">
</div>
