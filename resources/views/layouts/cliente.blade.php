<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', "D'Nokali - Repostería Premium")</title>
    
    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/dnokali.css') }}">

    @stack('styles')
</head>

<body>

    <!-- HEADER MODULAR -->
    <x-header />
    @yield('franja')
    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-4">
        @yield('barra_navegacion')
        @yield('contenido')
    </main>

    <!-- FOOTER (en todas las vistas cliente, excepto donde se desactive) -->
    @if (!View::hasSection('no_footer'))
        <x-footer />
    @endif

    <!-- MODAL DETALLE PRODUCTO -->
    <x-modal-detalle-producto />

    <!-- CARRITO (siempre activo) -->
    <x-carrito_compras />

    <!-- CHATBOT NOKALITO -->
    <x-chatbot-nokalito />

    <!-- Scripts -->
    <script src="{{ asset('js/modal-producto.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    

<style>
    main {
        padding-top: 10px;
    }
</style>

</body>
</html>
