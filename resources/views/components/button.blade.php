@props([
    'texto' => 'Botón',
    'icono' => null,
    'color' => 'primary',
    'size' => 'md',
    'width' => null,
    'extraClasses' => '',
    'ruta' => null,     {{-- Si existe, el botón será <a>; si no, será <button> --}}
    'type' => 'button', {{-- Para formularios: "submit" --}}
])

@php
    // Asegurar string de clases aunque venga array
    $extraString = is_array($extraClasses) ? implode(' ', $extraClasses) : (string) $extraClasses;
    $classString = trim("btn btn-$size btn-$color rounded-pill fw-semibold {$extraString}");
    $styleString = $width ? "width: {$width};" : null;
@endphp

@if($ruta)
    {{-- MODO ENLACE --}}
    <a 
        href="{{ $ruta }}"
        class="{{ $classString }}"
        @if($styleString) style="{{ $styleString }}" @endif
        {{ $attributes->except('class')->filter(fn($value) => !is_array($value)) }}
    >
        @if($icono)
            <i class="bi bi-{{ $icono }} me-1"></i>
        @endif
        {{ $texto }}
    </a>
@else
    {{-- MODO BOTÓN REAL (submit) --}}
    <button
        type="{{ $type }}"
        class="{{ $classString }}"
        @if($styleString) style="{{ $styleString }}" @endif
        {{ $attributes->except('class')->filter(fn($value) => !is_array($value)) }}
    >
        @if($icono)
            <i class="bi bi-{{ $icono }} me-1"></i>
        @endif
        {{ $texto }}
    </button>
@endif

@once
    @push('styles')
        <style>
            /* Botón Ver Detalle */
            .btn-detalle {
                background-color: #A89CF3;
                color: #fff !important;
            }
            .btn-detalle:hover {
                background-color: #8c7bd8;
                color: #fff !important;
            }

            /* Botón Editar */
            .btn-editar {
                background-color: #f0eaff;
                color: #000 !important;
            }
            .btn-editar:hover {
                background-color: #e2d8ff;
                color: #000 !important;
            }

            /* Botón Eliminar */
            .btn-eliminar {
                background-color: #b7a4f7;
                color: #fff !important;
            }
            .btn-eliminar:hover {
                background-color: #9d8be8;
                color: #fff !important;
            }

            /* Botón Guardar / Actualizar */
            .btn-guardar {
                background-color: #A89CF3;
                color: #fff !important;
            }
            .btn-guardar:hover {
                background-color: #8c7bd8;
                color: #fff !important;
            }

            /* Botón Cancelar */
            .btn-cancelar {
                background-color: #f5f0ff;
                color: #4b3c3a !important;
            }
            .btn-cancelar:hover {
                background-color: #e8ddff;
                color: #4b3c3a !important;
            }

            /* Botón Agregar */
            .btn-agregar {
                background-color: #A89CF3;
                color: #fff !important;
            }
            .btn-agregar:hover {
                background-color: #9f92f0;
                box-shadow: 0 4px 10px rgba(168,156,243,0.4);
                color: #fff !important;
            }
        </style>
    @endpush
@endonce
