@extends('layouts.cliente')

@section('titulo', "Productos Personalizados")

@section('franja')
    <x-franja titulo="Diseña tu Postre Ideal" subtitulo="Creamos tu dulce a medida" />
@endsection

@section('barra_navegacion')
    <x-nav-cliente active="personalizados" />
@endsection

@section('contenido')
<div class="container my-4">

    <!-- Encabezado -->
    <div class="p-4 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(120deg, #f7e8ff, #fdeedf);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-semibold text-brown mb-1">Crear Producto Personalizado</h3>
                <p class="text-muted mb-0">Diseña tu postre perfecto con nuestros expertos pasteleros</p>
            </div>

            <!-- CTA - Redirige al formulario -->
            <a href="{{ route('cliente.personalizados.nueva') }}" 
               class="btn rounded-pill px-4 d-flex align-items-center shadow-sm"
               style="background-color:#cbb4f6;color:#4b3c3a;font-weight:500;text-decoration:none;">
                <i class="bi bi-plus-circle me-2"></i> Nueva Solicitud
            </a>
        </div>
    </div>

    <!-- Beneficios rápidos -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center gap-3">
                <div class="icon-box bg-light text-brown"><i class="bi bi-brush"></i></div>
                <div>
                    <div class="fw-semibold text-brown">Diseño único</div>
                    <div class="small text-muted">Dale tu toque personal a cada detalle.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center gap-3">
                <div class="icon-box bg-light text-brown"><i class="bi bi-cup-straw"></i></div>
                <div>
                    <div class="fw-semibold text-brown">Sabores premium</div>
                    <div class="small text-muted">Combinaciones pensadas para sorprender.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center gap-3">
                <div class="icon-box bg-light text-brown"><i class="bi bi-alarm"></i></div>
                <div>
                    <div class="fw-semibold text-brown">Entrega puntual</div>
                    <div class="small text-muted">Coordinamos la fecha que más te convenga.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards reservados -->
    @if($personalizados->count() > 0)
        <div class="row gy-4">
            @foreach($personalizados as $pers)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: #fffdf9;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-semibold text-brown">
                                        {{ $pers->ocasion ? $pers->ocasion : 'Solicitud personalizada' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $pers->fecha_solicitud ? \Carbon\Carbon::parse($pers->fecha_solicitud)->format('d/m/Y H:i') : 'Sin fecha' }}
                                    </small>
                                </div>

                                @php
                                    $badgeClass = match($pers->estado) {
                                        'Pendiente'   => 'bg-warning-subtle text-warning-emphasis',
                                        'En Diseño'   => 'bg-info-subtle text-info-emphasis',
                                        'Aprobado'    => 'bg-success-subtle text-success-emphasis',
                                        'Rechazado'   => 'bg-danger-subtle text-danger-emphasis',
                                        'Entregado'   => 'bg-secondary-subtle text-secondary-emphasis',
                                        default       => 'bg-light text-brown',
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-1">
                                    {{ $pers->estado }}
                                </span>
                            </div>

                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit($pers->descripcion, 120) }}
                            </p>

                            @if($pers->costo_estimado)
                                <p class="mb-1">
                                    <strong>Costo estimado: </strong>
                                    <span class="text-lavanda">S/ {{ number_format($pers->costo_estimado, 2) }}</span>
                                </p>
                            @else
                                <p class="mb-1 small text-muted">
                                    Costo estimado: <em>En revisión</em>
                                </p>
                            @endif

                            <a href="{{ route('cliente.personalizados.detalles', $pers->id_personalizacion) }}"
                               class="btn btn-lavanda rounded-pill mt-3 w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-eye me-2"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado vacío -->
        <div class="row gy-4">
            <div class="col-12">
                <div class="p-4 text-center bg-white rounded-4 shadow-sm border" style="border-color:#f2e8ff !important;">
                    <i class="bi bi-clipboard-heart text-lavanda fs-1 d-block mb-2"></i>
                    <p class="mb-1 fw-semibold text-brown">Aún no tienes solicitudes personalizadas.</p>
                    <p class="text-muted small">Empieza una nueva y cuéntanos qué pastel imaginaste.</p>
                    <a href="{{ route('cliente.personalizados.nueva') }}" class="btn btn-lavanda rounded-pill px-4 mt-2">
                        Crear solicitud
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection

@once
    @push('styles')
        <style>
            .icon-box {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                border: 1px solid #f0e9ff;
            }
        </style>
    @endpush
@endonce
