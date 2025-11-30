@extends('layouts.cliente')

@section('titulo', "Detalle de Personalización")


@section('barra_navegacion')
    <x-nav-cliente active="personalizados" />
@endsection

@section('contenido')

<div class="container my-5">

    <a href="{{ route('cliente.personalizados') }}" class="btn btn-outline-secondary rounded-pill mb-4 px-4">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 1rem; background-color:#fffdfb;">

        <!-- Título -->
        <h3 class="fw-semibold text-brown mb-1">
            Tu solicitud personalizada
        </h3>
        <p class="text-muted">
            Enviada el {{ \Carbon\Carbon::parse($personalizado->fecha_solicitud)->format('d/m/Y H:i') }}
        </p>

        <hr class="my-4">


        <!-- DATOS -->
        <h5 class="fw-bold text-brown mb-3">Detalles del producto</h5>

        <p><strong>Descripción:</strong> {{ $personalizado->descripcion }}</p>
        <p><strong>Tamaño:</strong> {{ $personalizado->tamano }}</p>
        <p><strong>Sabor:</strong> {{ $personalizado->sabor }}</p>
        

        @if($personalizado->ocasion)
            <p><strong>Ocasión:</strong> {{ $personalizado->ocasion }}</p>
        @endif

        @if($personalizado->notas_adicionales)
            <p><strong>Notas adicionales:</strong> {{ $personalizado->notas_adicionales }}</p>
        @endif

        <hr class="my-4">


        <!-- IMAGEN -->
        @if($personalizado->imagen_referencia)
            <div class="text-center my-4">
                <img src="{{ asset('storage/' . $personalizado->imagen_referencia) }}" 
                     class="img-fluid rounded-4 shadow-sm"
                     style="max-height: 350px; object-fit: cover;">
            </div>
        @else
            <p class="text-muted"><em>Sin imagen de referencia</em></p>
        @endif


        <hr class="my-4">


        <!-- ESTADO -->
        @php
            $badgeClass = match($personalizado->estado) {
                'Pendiente'   => 'bg-warning-subtle text-warning-emphasis',
                'En Diseño'   => 'bg-info-subtle text-info-emphasis',
                'Aprobado'    => 'bg-success-subtle text-success-emphasis',
                'Rechazado'   => 'bg-danger-subtle text-danger-emphasis',
                'Entregado'   => 'bg-secondary-subtle text-secondary-emphasis',
                default       => 'bg-light text-brown',
            };
        @endphp

        <div class="mb-3">
            <strong class="d-block">Estado Actual:</strong>
            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 fs-6">
                {{ $personalizado->estado }}
            </span>
        </div>


        <!-- COSTO -->
        <div class="mb-3">
            <strong class="d-block">Costo Estimado:</strong>

            @if($personalizado->costo_estimado)
                <span class="text-success fw-bold fs-5">
                    S/ {{ number_format($personalizado->costo_estimado, 2) }}
                </span>
            @else
                <span class="text-muted">Aún no asignado. Espera la revisión del administrador.</span>
            @endif
        </div>

        <hr class="my-4">

        <!-- ACCIONES (Editar / Eliminar) -->
        <div class="d-flex gap-3 justify-content-center my-4">

        {{-- EDITAR solo si el estado lo permite --}}
        @if(in_array($personalizado->estado, ['Pendiente','En Diseño']))
            <a href="{{ route('cliente.personalizados.editar', $personalizado->id_personalizacion) }}"
                class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-pencil-square me-2"></i> Editar solicitud
            </a>
        @endif

        {{-- ELIMINAR solo si no fue procesado --}}
        @if(in_array($personalizado->estado, ['Pendiente','Rechazado']))
            <form method="POST" action="{{ route('cliente.personalizados.eliminar', $personalizado->id_personalizacion) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-lavanda rounded-pill px-4 text-white"
                    onclick="return confirm('¿Seguro que deseas eliminar esta solicitud?')">
                    <i class="bi bi-trash me-2"></i> Eliminar
                </button>
            </form>
        @endif

    </div>


        <p class="text-center text-muted small">
            Si necesitas modificar esta solicitud, comunícate con nuestro equipo de soporte.
        </p>

        <div class="text-center mt-2">
            <a href="https://wa.me/51971106332?text=Tengo%20una%20consulta%20sobre%20mi%20pedido"
               class="btn btn-outline-success rounded-pill px-4 d-inline-flex align-items-center gap-2"
               target="_blank" rel="noopener noreferrer">
                <i class="bi bi-whatsapp" style="font-size: 1.1rem;"></i>
                Contáctanos
            </a>
        </div>

    </div>
</div>

@endsection
