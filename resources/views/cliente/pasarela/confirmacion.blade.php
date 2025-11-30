@extends('layouts.cliente')
@section('contenido')
@php
    $metodo = session('metodo_pago');
@endphp

<div class="container my-5">
    <div class="text-center">
        <div>
            <img src="https://media.tenor.com/BSY1qTH8g-oAAAAM/check.gif" alt="Éxito" class="check-gif">
        </div>
        <h3 class="fw-bold text-brown mb-2">Proceso finalizado</h3>
        <p class="text-muted mb-4">Tu compra ha sido procesada con éxito.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 560px;">
        <div class="card-body text-center py-4">
            {{-- TÍTULO SEGÚN MÉTODO --}}
            @if($metodo === 'Tarjeta')
                <h4 class="fw-bold text-brown mb-2">!Pago realizado con Éxito!</h4>
Pago realizado con Éxito!</h4>
                <p class="text-muted mb-0">Tu pago fue procesado correctamente. Estamos preparando tu pedido.</p>
            @elseif($metodo === 'Yape' || $metodo === 'Plin')
                <h4 class="fw-bold text-brown mb-2">¡Pedido registrado!</h4>
                <p class="text-muted mb-0">Tu pago por Yape/Plin está pendiente de verificación.</p>
            @elseif($metodo === 'Efectivo' || $metodo === 'Contra Entrega')
                <h4 class="fw-bold text-brown mb-2">¡Pedido registrado!</h4>
                <p class="text-muted mb-0">Pagarás en efectivo al recibir tu pedido.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('cliente.catalogo') }}"
                   class="btn btn-lg text-white rounded-pill px-4"
                   style="background-color:#A89CF3;">
                    Volver al Catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gif = document.querySelector('.check-gif');
    if (!gif) return;
    const staticSrc = '{{ asset('imagenes/check.png') }}';
    const swapDelay = 2000; // ms
    setTimeout(() => { gif.src = staticSrc; }, swapDelay);
});
</script>

@once
    @push('styles')
        <style>
            .check-wrapper {
                width: 190px;
                height: 190px;
                border-radius: 32px;
                background: linear-gradient(135deg, #f6f0ff, #dfe6ff);
                display: grid;
                place-items: center;
                box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            }
            .check-gif {
                width: 150px;
                height: 150px;
                object-fit: contain;
            }
        </style>
    @endpush
@endonce
        </a>
    </div>

</div>

@endsection
