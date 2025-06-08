<div class="modal fade" id="addSucursal-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="addSucursalLabel-{{ $cliente->codigo }}" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('clientes.sucursales.store', $cliente) }}" method="POST" id="form-add-sucursal-{{ $cliente->codigo }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addSucursalLabel-{{ $cliente->codigo }}">Agregar Sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>Nombre</label>
          <input name="nombre" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Calle</label>
          <input name="calle" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Número</label>
          <input name="numero" class="form-control">
        </div>
        <div class="mb-2 d-flex align-items-center">
          <label class="me-2">Provincia</label>
          <select name="provincia_id" class="form-control" required id="provincia_id-{{ $cliente->codigo }}">
            <option value="">Elija...</option>
            @foreach(\App\Models\Provincia::all() as $prov)
              <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-2">
          <label>Localidad</label>
          <select name="localidade_id" class="form-control" required id="localidade_id-{{ $cliente->codigo }}">
            <option value="">Elija provincia primero</option>
            <!-- Botón para abrir el modal de crear localidad -->
          <button type="button" class="btn btn-link btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addLocalidadModal-create-{{ $cliente->codigo }}">+</button>
          </select>
        </div>
        <div class="mb-2">
          <label>Zona</label>
          <input type="text" class="form-control" id="zona_nombre-{{ $cliente->codigo }}" readonly>
          <input type="hidden" name="zona_id" id="zona_id-{{ $cliente->codigo }}">
        </div>
        {{-- Transporte/sucursal solo si zona=Z99 y el cliente NO retira --}}
        <div class="mb-2" id="transporte-group-{{ $cliente->codigo }}" style="display: none;">
          <label>Transporte</label>
          <select name="transporte_id" class="form-control" id="transporte_id-{{ $cliente->codigo }}">
            <option value="">Elija...</option>
            @foreach(\App\Models\Transporte::all() as $transp)
              <option value="{{ $transp->id }}">{{ $transp->razon_social }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-2" id="transporte-suc-group-{{ $cliente->codigo }}" style="display: none;">
          <label>Sucursal de Transporte</label>
          <select name="transporte_sucursale_id" class="form-control" id="transporte_sucursale_id-{{ $cliente->codigo }}">
            <option value="">Elija transporte primero</option>
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
<div class="modal fade" id="addLocalidadModal-create-{{ $cliente->codigo }}" tabindex="-1" aria-labelledby="addLocalidadLabel" aria-hidden="true">
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
  const cod = @json($cliente->codigo);

  // Cambia localidades cuando cambia provincia
  document.getElementById('provincia_id-'+cod).addEventListener('change', function() {
    const provId = this.value;
    const locSelect = document.getElementById('localidade_id-'+cod);
    locSelect.innerHTML = '<option value="">Cargando...</option>';
    fetch('/provincias/' + provId + '/localidades')
      .then(resp => resp.json())
      .then(data => {
        let html = '<option value="">Elija...</option>';
        data.forEach(loc => {
          html += `<option value="${loc.id}">${loc.nombre}</option>`;
        });
        locSelect.innerHTML = html;
        // Limpiar zona
        document.getElementById('zona_nombre-'+cod).value = '';
        document.getElementById('zona_id-'+cod).value = '';
        hideTransportGroup();
      });
  });

  // Cambia zona cuando cambia localidad
  document.getElementById('localidade_id-'+cod).addEventListener('change', function() {
    const locId = this.value;
    if (!locId) {
      document.getElementById('zona_nombre-'+cod).value = '';
      document.getElementById('zona_id-'+cod).value = '';
      hideTransportGroup();
      return;
    }
    fetch('/localidades/' + locId + '/zona')
      .then(resp => resp.json())
      .then(data => {
        document.getElementById('zona_nombre-'+cod).value = data ? data.nombre : '';
        document.getElementById('zona_id-'+cod).value = data ? data.id : '';
        checkTransportGroup(data ? data.nombre : '');
      });
  });

  // Mostrar transporte solo si zona=Z99 y cliente NO retira
  function checkTransportGroup(zona) {
    const retira = {{ $cliente->retira ? 'true' : 'false' }};
    if(zona == 'Z99' && !retira){
      document.getElementById('transporte-group-'+cod).style.display = '';
      document.getElementById('transporte-suc-group-'+cod).style.display = '';
    } else {
      hideTransportGroup();
    }
  }
  function hideTransportGroup(){
    document.getElementById('transporte-group-'+cod).style.display = 'none';
    document.getElementById('transporte-suc-group-'+cod).style.display = 'none';
  }

  // Carga sucursales de transporte cuando se elige un transporte
  document.getElementById('transporte_id-'+cod).addEventListener('change', function() {
    const transpId = this.value;
    const sucSelect = document.getElementById('transporte_sucursale_id-'+cod);
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



