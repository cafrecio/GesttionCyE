<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Zonas</title>

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
                            <h1 class="m-0">Listado de Zonas</h1>
                        </div><div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Zonas</li>
                            </ol>
                        </div></div></div></div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tabla de Zonas</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('zonas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Zona</a>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Entregamos</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($zonas as $zona)
                                                <tr>
                                                    <td>{{ $zona->id }}</td>
                                                    <td>{{ $zona->nombre }}</td>
                                                    <td>{{ $zona->descripcion }}</td>
                                                    <td>
                                                        @if ($zona->entregamos)
                                                            <span class="badge bg-success">Sí</span>
                                                        @else
                                                            <span class="badge bg-danger">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('zonas.edit', $zona->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                                        <form action="{{ route('zonas.destroy', $zona->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="5">No hay zonas registradas.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
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