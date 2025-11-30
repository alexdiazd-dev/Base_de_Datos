<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pagos</title>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #F6E7DA; /* crema suave */
            font-family: 'Poppins', sans-serif;
        }

        /* Contenedor principal */
        .pasarela-container {
            max-width: 1400px;
            margin: 2rem auto;
        }

        /* Tarjetas */
        .card-pasarela {
            background: #ffffff;
            border-radius: 18px;
            padding: 2.2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* Encabezado */
        .titulo-principal {
            font-size: 1.8rem;
            font-weight: 600;
            color: #4b3c3a;
        }
        .subtitulo {
            color: #7d6f66;
            font-size: 0.95rem;
        }

        /* PASOS */
        .pasos {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin: 2rem 0 2.5rem 0;
        }
        .paso {
            text-align: center;
            font-size: 0.9rem;
        }
        .paso-num {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            line-height: 38px;
            margin: 0 auto 5px auto;
            font-weight: 600;
        }

        .paso-activo {
            background-color: #C4B5FD; /* lavanda */
            color: white;
        }

        .paso-inactivo {
            background-color: #e8e1ff;
            color: #6c54da;
        }

        /* Sidebar resumen */
        .resumen-box {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.6rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
    </style>

    @stack('styles')
</head>
<body>


{{-- Botón volver --}}
<div class="container mt-4 mb-3">
    <a href="{{ route('cliente.catalogo') }}" class="btn btn-light border">
        <i class="bi bi-arrow-left"></i> Volver al Catálogo
    </a>
</div>


{{-- Título principal --}}
<div class="container pasarela-container">
    <h2 class="titulo-principal">Pasarela de Pagos Segura</h2>
    <p class="subtitulo">Completa tu información de envío y pago para finalizar la compra</p>
</div>


{{-- Pasos dinámicos --}}
<div class="pasos">
    
    {{-- Paso 1 --}}
    <div class="paso">
        <div class="paso-num {{ request()->routeIs('cliente.pasarela.envio') ? 'paso-activo' : 'paso-inactivo' }}">
            1
        </div>
        Envío
    </div>

    {{-- Paso 2 --}}
    <div class="paso">
        <div class="paso-num {{ request()->routeIs('cliente.pasarela.pago') ? 'paso-activo' : 'paso-inactivo' }}">
            2
        </div>
        Pago
    </div>

    {{-- Paso 3 --}}
    <div class="paso">
        <div class="paso-num {{ request()->routeIs('cliente.pasarela.confirmacion') ? 'paso-activo' : 'paso-inactivo' }}">
            3
        </div>
        Confirmación
    </div>

</div>


{{-- Contenido dinámico — Aquí se insertarán envío/pago/confirmación --}}
<div class="container pasarela-container">
    @yield('contenido')
</div>


{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
