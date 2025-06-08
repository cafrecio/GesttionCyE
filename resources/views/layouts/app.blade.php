<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Gestión CyE')</title>

    {{-- CSS AdminLTE + FontAwesome --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    @include('layouts.partials.navbar')

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

    {{-- CONTENIDO --}}
    <div class="content-wrapper">
        <section class="content-header p-3">
            @yield('content_header')
        </section>

        <section class="content px-3">
            @yield('content')
        </section>
    </div>

    {{-- FOOTER --}}
    @include('layouts.partials.footer')
</div>

{{-- Scripts --}}
@include('layouts.partials.scripts')
@stack('js')  {{-- para que las vistas inyecten JS extra --}}
@stack('modals')   {{-- <-- aquí se inyectarán todos los modales secundarios --}}
</body>
</html>
