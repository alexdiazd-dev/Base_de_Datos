<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel Admin - D\'Nokali')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
    <style>
        body { background:#f6f7fb; font-family:'Poppins',sans-serif; }
        .admin-wrapper { display:grid; grid-template-columns:260px 1fr; min-height:100vh; }
        .admin-sidebar { background: linear-gradient(180deg,#2d2525,#231d1d); color:#fff; padding:20px 18px; }
        .admin-content { background:#f8f9fd; padding:22px; }
        @media (max-width:992px){ .admin-wrapper{ grid-template-columns:1fr; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dnokali.css') }}">

</head>
<body>
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        @yield('barra_navegacion')
    </aside>
    <section class="admin-content">
        @yield('contenido')
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
