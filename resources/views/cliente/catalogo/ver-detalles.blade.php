@extends('layouts.app')

@section('titulo', 'Detalle de Producto')

@section('contenido')
<h3 class="mb-4 text-center text-brown">Detalle del producto</h3>

<div class="w-50 mx-auto bg-white p-4 rounded-4 shadow-sm">

    {{-- IMAGEN CENTRADA --}}
    @if($producto->imagen)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid rounded" style="max-height:300px; object-fit:cover;">
        </div>
    @else
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/800x450?text=Sin+imagen" alt="Sin imagen" class="img-fluid rounded" style="max-height:300px; object-fit:cover;">
        </div>
    @endif

    {{-- CATEGORÍA (solo lectura) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Categoría</label>
        <div class="form-control-plaintext bg-light rounded-3 p-3">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>
    </div>

    {{-- NOMBRE (solo lectura) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Nombre del producto</label>
        <div class="form-control-plaintext bg-light rounded-3 p-3">{{ $producto->nombre }}</div>
    </div>

    {{-- DESCRIPCIÓN (solo lectura) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Descripción</label>
        <div class="form-control-plaintext bg-light rounded-3 p-3">{{ $producto->descripcion ?? 'Sin descripción' }}</div>
    </div>

    {{-- PRECIO (solo lectura) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Precio (S/)</label>
        <div class="form-control-plaintext bg-light rounded-3 p-3">S/ {{ number_format($producto->precio, 2) }}</div>
    </div>

    {{-- ESTADO (solo lectura) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Estado</label>
        <div class="form-control-plaintext bg-light rounded-3 p-3">
            <span class="badge {{ $producto->estado === 'Agotado' ? 'bg-danger' : 'bg-success' }}">{{ $producto->estado }}</span>
        </div>
    </div>

    {{-- BOTÓN VOLVER --}}
    <div class="text-center mt-4">
        <x-button texto="Volver al Catálogo" color="cancelar" size="md" icono="arrow-left" ruta="{{ route('cliente.catalogo') }}" />
    </div>

</div>

@endsection
