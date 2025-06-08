<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Sucursal de Transporte</title>
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
                            <h1 class="m-0">Editar Sucursal</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('transportes.index') }}">Transportes</a></li>
                                <li class="breadcrumb-item active">Editar Sucursal</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <form method="POST" action="{{ route('sucursales.update', $sucursale) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $sucursale->nombre }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Calle</label>
                                <input type="text" name="calle" class="form-control" value="{{ $sucursale->calle }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>Número</label>
                                <input type="text" name="numero" class="form-control" value="{{ $sucursale->numero }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>Provincia</label>
                                <select name="provincia_id" id="provincia_id" class="form-control" required>
                                    <option value="">Elija...</option>
                                    @foreach($provincias as $prov)
                                        <option value="{{ $prov->id }}" {{ $sucursale->provincia_id == $prov->id ? 'selected' : '' }}>
                                            {{ $prov->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Localidad</label>
                                <select name="localidad_id" id="localidad_id" class="form-control" required>
                                    @foreach($localidades as $loc)
                                        <option value="{{ $loc->id }}" {{ $sucursale->localidad_id == $loc->id ? 'selected' : '' }}>
                                            {{ $loc->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Zona</label>
                                <select name="zona_id" id="zona_id" class="form-control" required>
                                    <option value="">Seleccione zona</option>
                                    @foreach($zonas as $zona)
                                        <option value="{{ $zona->id }}" {{ $sucursale->zona_id == $zona->id ? 'selected' : '' }}>
                                            {{ $zona->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.partials.footer')
    </div>
    @include('layouts.partials.scripts')
    <script>
    // Actualiza localidades según provincia
    document.getElementById('provincia_id').addEventListener('change', function() {
        var provinciaId = this.value;
        fetch('/api/localidades?provincia_id=' + provinciaId)
            .then(res => res.json())
            .then(localidades => {
                let options = '';
                localidades.forEach(function(loc) {
                    options += `<option value="${loc.id}">${loc.nombre}</option>`;
                });
                document.getElementById('localidad_id').innerHTML = options;
            });
    });

    document.getElementById('localidad_id').addEventListener('change', function() {
        var locId = this.value;
        fetch('/api/localidades/' + locId)
            .then(res => res.json())
            .then(loc => {
                if(loc.zona_id){
                    document.getElementById('zona_id').value = loc.zona_id;
                }
            });
    });
    </script>
</body>
</html>
