<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Localidad</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Crear Nueva Localidad</h1>
                        </div><div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('localidades.index') }}">Localidades</a></li>
                                <li class="breadcrumb-item active">Crear</li>
                            </ol>
                        </div></div></div></div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Formulario de Nueva Localidad</h3>
                                </div>
                                <form action="{{ route('localidades.store') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nombre">Nombre de la Localidad</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                                        </div>
                                        <div class="form-group">
                                            <label for="provincia_id">Provincia</label>
                                            <select class="form-control" id="provincia_id" name="provincia_id" required>
                                                <option value="">Seleccione una provincia</option>
                                                @foreach ($provincias as $provincia)
                                                    <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="zona_id">Zona <span class="text-danger">*</span></label>
                                            <select class="form-control" id="zona_id" name="zona_id" required>
                                                <option value="">Seleccione una zona (opcional)</option>
                                                @foreach ($zonas as $zona)
                                                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <small id="zona_descripcion" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="{{ route('localidades.index') }}" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div></div>
            </div>
        @include('layouts.partials.footer')
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const zonaSelect = document.getElementById('zona_id');
        const zonaDescripcion = document.getElementById('zona_descripcion');
        const baseUrl = '{{ url('/') }}'; // Obtener la URL base de la aplicación

        zonaSelect.addEventListener('change', function () {
            const zonaId = this.value;

            if (zonaId) {
                fetch(`${baseUrl}/zonas/${zonaId}`) // Hacer una petición GET a la ruta show de zonas
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.descripcion) {
                            zonaDescripcion.textContent = `Descripción: ${data.descripcion}`;
                        } else {
                            zonaDescripcion.textContent = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener la descripción de la zona:', error);
                        zonaDescripcion.textContent = '';
                    });
            } else {
                zonaDescripcion.textContent = '';
            }
        });

        // Cargar la descripción inicial en el formulario de edición (si hay una zona seleccionada)
        @if(isset($localidad) && $localidad->zona_id)
            const initialZonaId = '{{ $localidad->zona_id }}';
            fetch(`${baseUrl}/zonas/${initialZonaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.descripcion) {
                        zonaDescripcion.textContent = `Descripción: ${data.descripcion}`;
                    }
                })
                .catch(error => {
                    console.error('Error al obtener la descripción inicial de la zona:', error);
                });
        @endif
    });
    </script>
    @include('layouts.partials.scripts')
</body>
</html>