{{-- resources/views/layouts/partials/scripts.blade.php --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

  // — Limpieza de backdrops sobrantes —
  document.querySelectorAll('.modal').forEach(modalEl => {
    modalEl.addEventListener('hidden.bs.modal', () => {
      if (!document.querySelector('.modal.show')) {
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
      }
    });
  });

  // — Delegación para abrir los modales hijos (contactos / sucursales) —
  document.body.addEventListener('click', e => {
    // Crear Contacto
    if (e.target.closest('.abrir-modal-crear-contacto')) {
      let btn     = e.target.closest('.abrir-modal-crear-contacto'),
          cliente = btn.dataset.cliente;
      bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalContactos-' + cliente)
      ).hide();
      new bootstrap.Modal(
        document.getElementById('modalCrearContacto-' + cliente)
      ).show();
    }
    // Editar Contacto
    if (e.target.closest('.abrir-modal-editar-contacto')) {
      let btn      = e.target.closest('.abrir-modal-editar-contacto'),
          cliente  = btn.dataset.cliente,
          contacto = btn.dataset.contacto;
      bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalContactos-' + cliente)
      ).hide();
      new bootstrap.Modal(
        document.getElementById(`modalEditarContacto-${cliente}-${contacto}`)
      ).show();
    }
    // Crear Sucursal de Cliente
    if (e.target.closest('.abrir-modal-crear-sucursal')) {
      let btn     = e.target.closest('.abrir-modal-crear-sucursal'),
          cliente = btn.dataset.cliente;
      bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalSucursales-' + cliente)
      ).hide();
      new bootstrap.Modal(
        document.getElementById('modalCrearSucursal-' + cliente)
      ).show();
    }
    // Editar Sucursal de Cliente
    if (e.target.closest('.abrir-modal-editar-sucursal')) {
      let btn      = e.target.closest('.abrir-modal-editar-sucursal'),
          cliente  = btn.dataset.cliente,
          sucursal = btn.dataset.sucursal;
      bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalSucursales-' + cliente)
      ).hide();
      new bootstrap.Modal(
        document.getElementById(`modalEditarSucursal-${cliente}-${sucursal}`)
      ).show();
    }
  });

  // — AJAX dependientes para sucursales —
  document.querySelectorAll('[id^="modalCrearSucursal-"], [id^="modalEditarSucursal-"]')
    .forEach(modalEl => {
      modalEl.addEventListener('shown.bs.modal', function(){

        const isEdit    = this.id.startsWith('modalEditarSucursal'),
              parts     = this.id.split('-'),
              cliente   = parts[1],
              sucursal  = isEdit ? parts[2] : null,
              suffix    = isEdit 
                ? `editar_${cliente}_${sucursal}` 
                : `crear_${cliente}`;

        // selects y campos ocultos
        const selProv   = this.querySelector('[name="provincia_id"]'),
              selLoc    = this.querySelector('[name="localidade_id"]'),
              zonaTxt   = this.querySelector(`#zona_nombre_${suffix}`),
              zonaId    = this.querySelector(`#zona_id_${suffix}`),
              transpSel = this.querySelector(`#transporte_id_${suffix}`),
              sucTrans  = this.querySelector('[name="transporte_sucursale_id"]');

        // valores previos (para EDIT)
        const oldProvincia = selProv.value,
              oldLocalidad = selLoc.value,
              oldTransp    = transpSel ? transpSel.value : null,
              oldSucTrans  = sucTrans ? sucTrans.value : null;

        // 1) Provincia → Localidades
        selProv.addEventListener('change', function loadLoc(){
          selLoc.innerHTML = '<option>…cargando</option>';
          fetch(`/ajax/localidades/${this.value}`)
            .then(r => r.json())
            .then(list => {
              selLoc.innerHTML = '<option value="">Seleccione…</option>';
              list.forEach(l => {
                let opt = new Option(l.nombre, l.id);
                if (l.id == oldLocalidad) opt.selected = true;
                selLoc.append(opt);
              });
            });
          zonaTxt.value = zonaId.value = '';
        });

        // 2) Localidad → Zona (+ transporte si Z99 y no retira)
        selLoc.addEventListener('change', function(){
          fetch(`/ajax/zona-por-localidad/${this.value}`)
            .then(r => r.json())
            .then(z => {
              zonaTxt.value = z.nombre;
              zonaId.value  = z.id;
              if (z.nombre==='Z99' && this.closest('.modal').dataset.retira==='0') {
                this.closest('.modal').querySelector(`#transporte_group_${suffix}`)
                  .classList.remove('d-none');
                this.closest('.modal').querySelector(`#sucursal_transporte_group_${suffix}`)
                  .classList.remove('d-none');
              }
            });
        });

        // 3) Transporte → Sucursal de transporte
        if (transpSel && sucTrans) {
          transpSel.addEventListener('change', function(){
            sucTrans.innerHTML = '<option>…cargando</option>';
            fetch(`/ajax/transporte-sucursales/${this.value}`)
              .then(r => r.json())
              .then(list => {
                sucTrans.innerHTML = '<option value="">Seleccione…</option>';
                list.forEach(s => {
                  let label = `${s.nombre} (${s.localidad_nombre}, ${s.provincia_nombre})`,
                      opt   = new Option(label, s.id);
                  if (s.id == oldSucTrans) opt.selected = true;
                  sucTrans.append(opt);
                });
              });
          });
        }

        // Disparar cargas automáticas al abrir
        if (oldProvincia) selProv.dispatchEvent(new Event('change'));
        if (oldTransp)    transpSel && transpSel.dispatchEvent(new Event('change'));

      });
  });

});
</script>






