{{-- resources/views/cliente/pedidos/_detalle-inline.blade.php --}}

@php
    $envio = $pedido->envio;

    $subtotal = $pedido->total;
    $costoEnvio = $envio?->costo_envio ?? 6.00;
    $totalFinal = $subtotal + $costoEnvio;

    $estadoTone = match($pedido->estado) {
        'Entregado'   => 'status-success',
        'Enviado'     => 'status-primary',
        'Preparación' => 'status-info',
        'Pendiente'   => 'status-warning',
        'Cancelado'   => 'status-danger',
        default       => 'status-secondary',
    };
@endphp

<div class="detalle-pedido-inline bg-white rounded-4 shadow-sm p-4 mb-3 border" 
     style="border-color:#f2e8ff !important;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-3">

        <div>
            <h5 class="fw-semibold text-brown mb-1">
                Pedido #{{ $pedido->codigo() }}
            </h5>
            <small class="text-muted">
                Fecha del pedido: {{ $pedido->fecha_pedido }}
            </small>
        </div>

        <button type="button"
                class="btn-close btn-cerrar-detalle"
                data-id="{{ $pedido->id_pedido }}">
        </button>

    </div>


    {{-- ESTADO + MÉTODO --}}
    <div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
        <span class="badge estado-pill {{ $estadoTone }}">
            {{ $pedido->estado }}
        </span>

        @if($envio?->metodo_pago)
            <span class="badge estado-pill {{ $envio->metodo_pago === 'Contra Entrega' ? 'status-warning' : 'status-success' }}">
                {{ $envio->metodo_pago }}
            </span>
        @endif
    </div>



    {{-- DATOS DE ENVÍO --}}
    <div class="mb-4">
        <h6 class="fw-semibold text-brown mb-2">Datos de envío</h6>

        @if($envio)
            <div class="p-3 rounded-3" style="background:#fdf8ff;">
                <div><strong>Nombre:</strong> {{ $envio?->nombres }} {{ $envio?->apellidos }}</div>
                <div><strong>Teléfono:</strong> {{ $envio?->telefono }}</div>
                <div><strong>Correo:</strong> {{ $envio?->correo }}</div>
                <div><strong>Dirección:</strong> {{ $envio?->direccion }}</div>
                <div><strong>Ciudad:</strong> {{ $envio?->ciudad }}</div>
            </div>
        @else
            <p class="text-muted mb-0">Datos de envío no disponibles.</p>
        @endif
    </div>



    {{-- PRODUCTOS --}}
    <div class="mb-3">
        <h6 class="fw-semibold text-brown mb-2">Productos del pedido</h6>

        @foreach ($pedido->detalles as $item)
            <div class="d-flex justify-content-between align-items-center p-2 mb-2 rounded-3"
                 style="background:#fdf8ff;">

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

    </div>



    {{-- TOTALES --}}
    <div class="border-top pt-2">
        <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>S/ {{ number_format($subtotal, 2) }}</span>
        </div>

        <div class="d-flex justify-content-between">
            <span>Envío</span>
            <span>S/ {{ number_format($costoEnvio, 2) }}</span>
        </div>

        <div class="d-flex justify-content-between fw-bold mt-1">
            <span>Total</span>
            <span class="text-brown">S/ {{ number_format($totalFinal, 2) }}</span>
        </div>
    </div>



    {{-- NOTAS --}}
    @if ($envio?->notas)
        <div class="border-top pt-3 mt-3">
            <h6 class="fw-semibold text-brown mb-1">Notas</h6>
            <p class="text-muted mb-0">{{ $envio->notas }}</p>
        </div>
    @endif

</div>

