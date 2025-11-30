@props(['active' => 'catalogo'])

@php
    // Función para marcar el botón activo
    $navClass = fn($current, $active) => 
        $current === $active
            ? 'btn btn-lavanda rounded-pill d-flex flex-column align-items-center justify-content-center px-4 py-2'
            : 'btn btn-outline-lavanda rounded-pill d-flex flex-column align-items-center justify-content-center px-4 py-2';

    $rol = session('rol');
@endphp

@if($rol !== 1) 
<div class="row w-100 mx-auto">
    <div class="btn-group rounded-pill mt-4 shadow-sm p-1 d-flex justify-content-center gap-2" 
         style="background: white;" role="group">

        <!-- Siempre visible para cualquier usuario -->
        <a href="{{ route('cliente.catalogo') }}" class="{{ $navClass('catalogo', $active) }}">
            <i class="bi bi-box-seam mb-1"></i>
            <span style="font-weight: {{ 'catalogo' === $active ? '700' : '500' }} !important;">Catálogo</span>
        </a>

        <!-- SOLO CLIENTES LOGEADOS (rol=2) -->
        @if(session()->has('usuario_id') && $rol === 2)
            <a href="{{ route('cliente.personalizados') }}" class="{{ $navClass('personalizados', $active) }}">
                <i class="bi bi-heart mb-1"></i>
                <span style="font-weight: {{ 'personalizados' === $active ? '700' : '500' }} !important;">Personalizado</span>
            </a>

            <a href="{{ route('cliente.pedidos') }}" class="{{ $navClass('pedidos', $active) }}">
                <i class="bi bi-cart3 mb-1"></i>
                <span style="font-weight: {{ 'pedidos' === $active ? '700' : '500' }} !important;">Mis pedidos</span>
            </a>
        @endif

    </div>
</div>
@endif
