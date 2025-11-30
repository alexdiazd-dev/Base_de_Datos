@props([
    'id' => null,      {{-- ID del pedido --}}
    'image' => null,
    'entrega' => null,
    'estado' => null,
    'estadoClass' => 'text-secondary',
    'product' => null,
    'total' => null,
    'ver' => null,   {{-- URL a detalles completos --}}
])

@php
    $statusTone = match(true) {
        str_contains($estadoClass, 'success') => 'status-success',
        str_contains($estadoClass, 'danger') => 'status-danger',
        str_contains($estadoClass, 'warning') => 'status-warning',
        str_contains($estadoClass, 'info') => 'status-info',
        str_contains($estadoClass, 'primary') => 'status-primary',
        default => 'status-secondary',
    };
@endphp

<div class="card bg-white border-0 shadow-sm mb-3 pedido-card">
    <div class="card-body d-flex align-items-center justify-content-between gap-3">
        
        {{-- Imagen + datos --}}
        <div class="d-flex align-items-center gap-3 flex-grow-1">
            <img src="{{ $image }}" 
                 alt="Producto" 
                 class="rounded-4" 
                 style="width:80px;height:80px;object-fit:cover;">
            
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <span class="badge estado-pill {{ $statusTone }}">{{ $estado }}</span>
                    <span class="small text-muted">Fecha del pedido: {{ $entrega }}</span>
                </div>
                <div class="fw-semibold text-brown mt-1">{{ $product }}</div>
                <div class="small text-muted">
                    Total: <strong class="text-brown">S/ {{ number_format($total, 2) }}</strong>
                </div>

                {{-- Slot opcional extra --}}
                @if(trim($slot) !== '')
                    <div class="mt-2 small text-muted">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Acciones --}}
        <div class="text-end">

            {{-- BOTÓN INLINE --}}
            <button 
                type="button"
                class="btn btn-lavanda rounded-3 px-4 shadow-sm btn-ver-detalles mb-2"
                data-id="{{ $id }}"
                data-url="{{ route('cliente.pedidos.detalle.inline', $id) }}">
                Ver detalles
            </button>

            {{-- BOTÓN DETALLE COMPLETO --}}
            <a href="{{ $ver }}" 
               class="btn btn-outline-secondary rounded-3 px-4 shadow-sm">
                Ver página
            </a>

        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .pedido-card { border: 1px solid #f2e8ff; }
            .estado-pill {
                border-radius: 999px;
                padding: 0.35rem 0.75rem;
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
