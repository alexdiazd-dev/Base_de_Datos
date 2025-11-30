@extends('layouts.cliente')

@section('titulo', 'Detalle del Pedido')

@section('contenido')
@php
    $estadoTone = match($pedido->estado) {
        'Entregado' => 'status-success',
        'Enviado' => 'status-primary',
        'Preparación' => 'status-info',
        'Pendiente' => 'status-warning',
        'Cancelado' => 'status-danger',
        default => 'status-secondary',
    };
@endphp
<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
        <div>
            <h3 class="fw-semibold text-brown mb-1">Pedido #{{ $pedido->id_pedido }}</h3>
            <p class="text-muted mb-0">Revisa toda la información de tu pedido</p>
        </div>
        <a href="{{ route('cliente.pedidos') }}" class="btn btn-outline-secondary rounded-pill px-4">
            Volver a mis pedidos
        </a>
    </div>

    {{-- Panel resumen --}}
    <div class="p-4 bg-white rounded-4 shadow-sm mb-4 border" style="border-color:#f2e8ff !important;">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <span class="badge estado-pill {{ $estadoTone }}">{{ $pedido->estado }}</span>
        </div>
        <p class="mb-1"><strong>Método de pago:</strong> 
            <span class="badge {{ $pedido->metodo_pago === 'Contra Entrega' ? 'status-warning' : 'status-success' }} estado-pill">
                {{ $pedido->metodo_pago }}
            </span>
        </p>
    </div>

    {{-- Productos --}}
    <div class="p-4 bg-white rounded-4 shadow-sm mb-4">
        <h5 class="fw-semibold mb-3 text-brown">Productos del pedido</h5>

        @foreach ($pedido->detalles as $item)
            <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-2" style="background:#fdf8ff;">
                <div>
                    <strong>{{ $item->producto->nombre }}</strong><br>
                    <small class="text-muted">
                        {{ $item->cantidad }} x S/ {{ number_format($item->producto->precio, 2) }}
                    </small>
                </div>

                <div class="text-brown fw-semibold">
                    S/ {{ number_format($item->subtotal, 2) }}
                </div>

            </div>
        @endforeach


        <div class="d-flex justify-content-between mt-3 fs-5 fw-bold">
            <span>Total</span>
            <span class="text-brown">S/ {{ $pedido->total }}</span>
        </div>
    </div>

    {{-- Notas --}}
    @if ($pedido->notas)
        <div class="p-4 bg-white rounded-4 shadow-sm mb-4">
            <h5 class="fw-semibold text-brown">Notas</h5>
            <p class="text-muted mb-0">{{ $pedido->notas }}</p>
        </div>
    @endif
</div>

@once
    @push('styles')
        <style>
            .estado-pill {
                border-radius: 999px;
                padding: 0.45rem 0.85rem;
                font-weight: 600;
                letter-spacing: -0.2px;
                border: 1px solid transparent;
            }
            .status-success {background: #e8f6ed; color: #1e8f55; border-color: #c8e7d4;}
            .status-danger {background: #ffe9e8; color: #c0392b; border-color: #ffcbc6;}
            .status-warning {background: #fff6e6; color: #c27c00; border-color: #ffe2b7;}
            .status-info {background: #e9f5ff; color: #1b6ca8; border-color: #c7e6ff;}
            .status-primary {background: #ece7ff; color: #4b3c9c; border-color: #d7cffb;}
            .status-secondary {background: #f2f2f2; color: #5c5c5c; border-color: #e0e0e0;}
        </style>
    @endpush
@endonce
@endsection
