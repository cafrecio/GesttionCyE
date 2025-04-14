<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Provincias</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('provincias.index') }}" class="nav-link">Provincias</a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('provincias.index') }}" class="brand-link">
                <span class="brand-text font-weight-light">GestionCyE</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('provincias.index') }}" class="nav-link active">
                                <i class="nav-icon fas fa-map-marked-alt"></i>
                                <p>Provincias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('zonas.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-vector-square"></i>
                                <p>Zonas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('localidades.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-city"></i>
                                <p>Localidades</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                </div>
            </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Listado de Provincias</h1>
                        </div><div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Provincias</li>
                            </ol>
                        </div></div></div></div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tabla de Provincias</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('provincias.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Provincia</a>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($provincias as $provincia)
                                                <tr>
                                                    <td>{{ $provincia->id }}</td>
                                                    <td>{{ $provincia->nombre }}</td>
                                                    <td>
                                                        <a href="{{ route('provincias.edit', $provincia->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                                        <form action="{{ route('provincias.destroy', $provincia->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3">No hay provincias registradas.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                    </div>
                    </div></div>
            </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                GestionCyE
            </div>
            <strong>Copyright &copy; {{ date('Y') }}</strong>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7U1YUY2tF+WYuT2dprLcyVgD3gupvFI2Pd7kKspVu/aD9uNbTgxoH47ndwy5ZVstC6ZaNH5VvrwYEVj2DQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>