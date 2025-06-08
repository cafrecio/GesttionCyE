<div class="modal fade" id="editSucursal-{{ $sucursale->id }}" tabindex="-1" aria-labelledby="editSucursalLabel-{{ $sucursale->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('sucursales.update', $sucursale) }}" method="POST" id="form-edit-sucursal-{{ $sucursale->id }}">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="editSucursalLabel-{{ $sucursale->id }}">Editar Sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>Nombre</label>
          <input name="nombre" class="form-control" value="{{ $sucursale->nombre }}" required>
        </div>
        <div class="mb-2">
          <label>Calle</label>
          <input name="calle" class="form-control" value="{{ $sucursale->calle }}" required>
        </div>
        <div class="mb-2">
          <label>Número</label>
          <input name="numero" class="form-control" value="{{ $sucursale->numero }}">
        </div>
        <div class="mb-2 d-flex align-items-center">
          <label class="me-2">Provincia</label>
          <select name="provincia_id" class="form-control" required id="provincia_id-edit-{{ $sucursale->id }}">
            <option value="">Elija...</option>
            @foreach(\App\Models\Provincia::all() as $prov)
              <option value="{{ $prov->id }}" {{ $sucursale->provincia_id == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
            @endforeach
          </select>
          <!-- Botón para abrir el modal de crear localidad -->
          <button type="button" class="btn btn-link btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addLocalidadModal-edit-{{ $sucursale->id }}">+</button>
        </div>
        <div class="mb-2">
          <label>Localidad</label>
          <select name="localidade_id" class="form-control" required id="localidade_id-edit-{{ $sucursale->id }}">
            <option value="">Elija provincia primero</option>
            @foreach(\App\Models\Localidade::where('provincia_id', $sucursale->provincia_id)->get() as $loc)
              <option value="{{ $loc->id }}" {{ $sucursale->localidade_id == $loc->id ? 'selected' : '' }}>{{ $loc->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-2">
          <label>Zona</label>
          <input type="text" class="form-control" id="zona_nombre-edit-{{ $sucursale->id }}" value="{{ $sucursale->zona->nombre ?? '' }}" readonly>
          <input type="hidden" name="zona_id" id="zona_id-edit-{{ $sucursale->id }}" value="{{ $sucursale->zona_id }}">
        </div>
        {{-- Transporte/sucursal solo si zona=Z99 y el cliente NO retira --}}
        @php
            $cliente = $cliente ?? \App\Models\Cliente::where('codigo', $sucursale->cliente_id)->first();
            $mostrarTransporte = ($sucursale->zona->nombre ?? '') === 'Z99' && !($cliente && $cliente->retira);
        @endphp
        <div class="mb-2" id="transporte-group-edit-{{ $sucursale->id }}" style="{{ $mostrarTransporte ? '' : 'display:none' }}">
          <label>Transporte</label>
          <select name="transporte_id" class="form-control" id="transporte_id-edit-{{ $sucursale->id }}">
            <option value="">Elija...</option>
            @foreach(\App\Models\Transporte::all() as $transp)
              <option value="{{ $transp->id }}" {{ optional($sucursale->transporte)->transporte_id == $transp->id ? 'selected' : '' }}>
                {{ $transp->razon_social }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="mb-2" id="transporte-suc-group-edit-{{ $sucursale->id }}" style="{{ $mostrarTransporte ? '' : 'display:none' }}">
          <label>Sucursal de Transporte</label>
          <select name="transporte_sucursale_id" class="form-control" id="transporte_sucursale_id-edit-{{ $sucursale->id }}">
            <option value="">Elija transporte primero</option>
            @if(optional($sucursale->transporte)->transporte_id)
              @foreach(\App\Models\TransporteSucursale::where('transporte_id', optional($sucursale->transporte)->transporte_id)->get() as $sucTransp)
                <option value="{{ $sucTransp->id }}" {{ $sucursale->transporte_sucursale_id == $sucTransp->id ? 'selected' : '' }}>
                  {{ $sucTransp->nombre }}
                </option>
              @endforeach
            @endif
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

{{-- MODAL CREAR LOCALIDAD --}}
<div class="modal fade" id="addLocalidadModal-edit-{{ $sucursale->id }}" tabindex="-1" aria-labelledby="addLocalidadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('localidades.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addLocalidadLabel">Agregar Localidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2"><label>Provincia</label>
          <select name="provincia_id" class="form-control" required>
            @foreach(\App\Models\Provincia::all() as $prov)
              <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-2"><label>Nombre</label><input name="nombre" class="form-control" required></div>
        <div class="mb-2"><label>Zona</label>
          <select name="zona_id" class="form-control" required>
            @foreach(\App\Models\Zona::all() as $zona)
              <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
            @endforeach
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

{{-- JS para combos dependientes y transporte --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  const id = @json($sucursale->id);

  // Cambia localidades cuando cambia provincia
  document.getElementById('provincia_id-edit-'+id).addEventListener('change', function() {
    const provId = this.value;
    const locSelect = document.getElementById('localidade_id-edit-'+id);
    locSelect.innerHTML = '<option value="">Cargando...</option>';
    fetch('/provincias/' + provId + '/localidades')
      .then(resp => resp.json())
      .then(data => {
        let html = '<option value="">Elija...</option>';
        data.forEach(loc => {
          html += `<option value="${loc.id}">${loc.nombre}</option>`;
        });
        locSelect.innerHTML = html;
        // Limpiar zona y transporte
        document.getElementById('zona_nombre-edit-'+id).value = '';
        document.getElementById('zona_id-edit-'+id).value = '';
        hideTransportGroup();
      });
  });

  // Cambia zona cuando cambia localidad
  document.getElementById('localidade_id-edit-'+id).addEventListener('change', function() {
    const locId = this.value;
    if (!locId) {
      document.getElementById('zona_nombre-edit-'+id).value = '';
      document.getElementById('zona_id-edit-'+id).value = '';
      hideTransportGroup();
      return;
    }
    fetch('/localidades/' + locId + '/zona')
      .then(resp => resp.json())
      .then(data => {
        document.getElementById('zona_nombre-edit-'+id).value = data ? data.nombre : '';
        document.getElementById('zona_id-edit-'+id).value = data ? data.id : '';
        checkTransportGroup(data ? data.nombre : '');
      });
  });

  function checkTransportGroup(zona) {
    const retira = {{ $cliente && $cliente->retira ? 'true' : 'false' }};
    if(zona == 'Z99' && !retira){
      document.getElementById('transporte-group-edit-'+id).style.display = '';
      document.getElementById('transporte-suc-group-edit-'+id).style.display = '';
    } else {
      hideTransportGroup();
    }
  }
  function hideTransportGroup(){
    document.getElementById('transporte-group-edit-'+id).style.display = 'none';
    document.getElementById('transporte-suc-group-edit-'+id).style.display = 'none';
  }

  // Carga sucursales de transporte cuando se elige un transporte
  document.getElementById('transporte_id-edit-'+id).addEventListener('change', function() {
    const transpId = this.value;
    const sucSelect = document.getElementById('transporte_sucursale_id-edit-'+id);
    if(!transpId){
      sucSelect.innerHTML = '<option value="">Elija transporte primero</option>';
      return;
    }
    fetch('/transportes/' + transpId + '/sucursales')
      .then(resp => resp.json())
      .then(data => {
        let html = '<option value="">Elija...</option>';
        data.forEach(suc => {
          html += `<option value="${suc.id}">${suc.nombre}</option>`;
        });
        sucSelect.innerHTML = html;
      });
  });
});
</script>

