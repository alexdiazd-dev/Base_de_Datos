@extends('layouts.admin')

@section('titulo', 'Detalle de Personalización')

@section('barra_navegacion')
    <x-nav-admin active="personalizados" />
@endsection

@section('contenido')
<div class="container my-5">

    <a href="{{ route('admin.personalizados') }}" class="btn btn-outline-secondary mb-3">
        ← Volver
    </a>

    @if(session('success'))
        <div class="alert alert-success rounded-pill text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-4 shadow-sm p-4 bg-white">

        <h3 class="fw-semibold text-brown">
            Solicitud de: {{ $personalizado->usuario->nombre }} {{ $personalizado->usuario->apellido }}
        </h3>

        <p class="text-muted">Solicitado el {{ date('d/m/Y', strtotime($personalizado->fecha_solicitud)) }}</p>

        <hr>

        <p><strong>Descripción:</strong> {{ $personalizado->descripcion }}</p>
        <p><strong>Tamaño:</strong> {{ $personalizado->tamano }}</p>
        <p><strong>Sabor:</strong> {{ $personalizado->sabor }}</p>

        @if($personalizado->imagen_referencia)
        <div class="text-center my-4">
            <img src="{{ asset('storage/' . $personalizado->imagen_referencia) }}" 
                 class="img-fluid rounded-4 shadow-sm"
                 style="max-height: 300px; object-fit: cover;">
        </div>
        @endif

        <hr class="my-4">

        <form method="POST" action="{{ route('admin.personalizados.estado', $personalizado->id_personalizacion) }}">
            @csrf

            <label class="fw-semibold">Estado:</label>
            <select name="estado" class="form-select rounded-pill w-50 mb-3">
                @foreach(['Pendiente','Aprobado','Rechazado','En Diseño','Entregado'] as $estado)
                    <option value="{{ $estado }}" {{ $personalizado->estado === $estado ? 'selected' : '' }}>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary rounded-pill mt-2 px-4">
                Actualizar Estado
            </button>
        </form>

        <hr class="my-4">

        {{-- =============================
            🔹 FORMULARIO: ACTUALIZAR COSTO
        ============================== --}}
        <form method="POST" action="{{ route('admin.personalizados.costo', $personalizado->id_personalizacion) }}">
            @csrf

            <label class="fw-semibold">Costo estimado (S/):</label>
            <input type="number" step="0.1" name="costo_estimado" 
                   class="form-control w-50 rounded-pill mb-3"
                   value="{{ $personalizado->costo_estimado }}">

            <button class="btn btn-success rounded-pill mt-2 px-4">
                Guardar Costo
            </button>
        </form>

    </div>

</div>
@endsection
