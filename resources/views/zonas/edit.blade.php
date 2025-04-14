<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Zona</title>

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
                            <h1 class="m-0">Editar Zona</h1>
                        </div><div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('zonas.index') }}">Zonas</a></li>
                                <li class="breadcrumb-item active">Editar</li>
                            </ol>
                        </div></div></div></div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Formulario de Edición de Zona</h3>
                                </div>
                                <form action="{{ route('zonas.update', $zona->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nombre">Nombre de la Zona</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $zona->nombre }}" placeholder="Ingrese el nombre">
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Describir zona</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese una descripción">{{ $zona->descripcion }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="entregamos" name="entregamos" {{ $zona->entregamos ? 'checked' : '' }}>
                                                <label class="form-check-label" for="entregamos">¿Entregamos en esta zona?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                        <a href="{{ route('zonas.index') }}" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div></div>
            </div>
        @include('layouts.partials.footer')
    </div>
    @include('layouts.partials.scripts')
</body>
</html>