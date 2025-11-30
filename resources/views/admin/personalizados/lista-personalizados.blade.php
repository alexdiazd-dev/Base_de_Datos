@extends('layouts.admin')

@section('titulo', 'Productos Personalizados')

@section('barra_navegacion')
    <x-nav-admin active="personalizados" />
@endsection

@section('contenido')
<div class="container my-5">
    <div class="mb-4">
        <h3 class="fw-semibold text-brown">Productos Personalizados</h3>
        <p class="text-muted">Gestiona las solicitudes de productos personalizados</p>
    </div>

    <div class="row g-4">

        @forelse($personalizados as $p)
            <div class="col-md-4">
                <x-card-personalizado 
                    :nombre="$p->usuario->nombre . ' ' . $p->usuario->apellido"
                    :estado="$p->estado"
                    :fecha="date('d/m/Y', strtotime($p->fecha_solicitud))"
                    :color="match($p->estado) {
                        'Pendiente' => 'bg-light text-brown border',
                        'En Diseño' => 'bg-warning text-dark',
                        'Aprobado' => 'bg-success text-white',
                        'Entregado' => 'bg-primary text-white',
                        'Rechazado' => 'bg-danger text-white',
                        default => 'bg-secondary text-white'
                    }"
                >
                    <p>{{ $p->descripcion }}</p>

                    @if($p->imagen_referencia)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $p->imagen_referencia) }}"
                                class="img-fluid rounded-4 my-2"
                                style="max-height: 180px; object-fit: cover;">
                        </div>
                    @endif

                    <p><strong>Tamaño:</strong> {{ $p->tamano }}</p>
                    <p><strong>Sabor:</strong> {{ $p->sabor }}</p>
                    
                    <a href="{{ route('admin.personalizados.detalles', $p->id_personalizacion) }}"
                        class="btn btn-lavanda rounded-pill mt-3 w-100 d-flex align-items-center justify-content-center shadow-sm">
                        <i class="bi bi-eye me-2"></i> Ver Detalles
                    </a>
                </x-card-personalizado>
            </div>
        @empty
            <p class="text-muted text-center">No hay solicitudes personalizadas aún.</p>
        @endforelse

    </div>
</div>
@endsection



