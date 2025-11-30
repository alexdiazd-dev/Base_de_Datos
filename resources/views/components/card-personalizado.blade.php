@props([
    'estado' => 'Pendiente',
    'color' => 'bg-light text-brown border', 
    'nombre' => 'Usuario',
    'fecha' => '01/01/2025'
])

<div class="card border-0 shadow-sm rounded-4 p-3 h-100 card-personalizado">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <div class="fw-semibold text-brown">{{ $nombre }}</div>
            <small class="text-muted">{{ $fecha }}</small>
        </div>
        <span class="badge {{ $color }} rounded-pill px-3 py-1">{{ $estado }}</span>
    </div>

    <div class="mt-3 mb-3 text-muted lead fs-6">
        {{ $slot }}
    </div>

    <div class="d-flex align-items-center gap-2">
    </div>
</div>

@once
    @push('styles')
        <style>
            .card-personalizado {
                background: linear-gradient(145deg, #fff6ef, #f9f0ff);
                border: 1px solid #f1e6ff;
            }
            .card-personalizado .icono-sello {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                display: grid;
                place-items: center;
                background: #fddedf;
                color: #c75b6a;
                font-size: 1rem;
            }
        </style>
    @endpush
@endonce
