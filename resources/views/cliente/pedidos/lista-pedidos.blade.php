@extends('layouts.cliente')

@section('titulo', 'Mis Pedidos')

@section('franja')
    <x-franja titulo="Tus Pedidos y Entregas" subtitulo="Revisa el estado de tus compras" />
@endsection

@section('barra_navegacion')
    <x-nav-cliente active="pedidos" />
@endsection

@section('contenido')
<div class="container my-4">

    <!-- Encabezado -->
    <div class="p-4 rounded-4 mb-4 shadow-sm" 
         style="background: linear-gradient(135deg, #f8edff, #fef6ec);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-semibold text-brown mb-1">Mis Pedidos</h3>
                <p class="text-muted mb-0">Revisa el estado de tus pedidos y pagos de un vistazo</p>
            </div>
        </div>
    </div>

    <!-- Lista de pedidos -->
    <div class="row gy-3">

        @forelse ($pedidos as $pedido)
            <div class="col-12">

                {{-- CARD DE PEDIDO --}}
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3">

                            <img src="{{ $pedido->image_url }}" 
                                 class="rounded" width="75" height="75" 
                                 style="object-fit: cover;">

                            <div>
                                <div class="fw-semibold text-brown">{{ $pedido->producto_nombre }}</div>

                                <div class="small text-muted">
                                    {{ $pedido->cantidad ?? 1 }} unidad(es)
                                </div>

                                <div class="small mt-1">
                                    <span class="{{ $pedido->estado_class }}">
                                        {{ $pedido->estado }}
                                    </span>
                                </div>

                                <div class="small text-muted mt-1">
                                    Fecha: {{ $pedido->fecha_entrega }}
                                </div>
                            </div>

                        </div>

                        <div class="text-end">

                            <div class="fw-bold text-brown fs-5">
                                S/ {{ number_format($pedido->total, 2) }}
                            </div>

                            {{-- Botón para abrir detalles inline --}}
                            <x-button 
                                texto="Ver detalles"
                                icono="chevron-down"
                                color="detalle" 
                                size="sm"
                                extraClasses="btn-ver-detalles mt-2 px-4 py-1"
                                data-id="{{ $pedido->id_pedido }}"
                                data-url="{{ route('cliente.pedidos.detalle.inline', $pedido->id_pedido) }}"
                            />


                            

                        </div>

                    </div>
                </div>

                {{-- CONTENEDOR DEL DETALLE INLINE --}}
                <div id="detalle-inline-{{ $pedido->id_pedido }}"></div>

            </div>
        @empty
            <div class="text-center text-muted py-5">
                Aún no tienes pedidos.
            </div>
        @endforelse

    </div> 
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let openId = null;

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-ver-detalles');
        if (!btn) return;

        const pedidoId = btn.dataset.id;
        const url = btn.dataset.url;
        console.log('CLICK DETALLES', pedidoId, url); // ← LOG

        const contenedor = document.getElementById('detalle-inline-' + pedidoId);

        if (openId === pedidoId) {
            contenedor.innerHTML = '';
            openId = null;
            return;
        }

        if (openId !== null) {
            const anterior = document.getElementById('detalle-inline-' + openId);
            if (anterior) anterior.innerHTML = '';
        }

        fetch(url)
            .then(r => r.text())
            .then(html => {
                console.log('RESPUESTA INLINE:', html.slice(0, 80)); // ← LOG
                contenedor.innerHTML = html;
                openId = pedidoId;

                const btnCerrar = contenedor.querySelector('.btn-cerrar-detalle');
                if (btnCerrar) {
                    btnCerrar.addEventListener('click', () => {
                        contenedor.innerHTML = '';
                        openId = null;
                    });
                }
            })
            .catch(err => console.error('Error cargando detalle:', err));
    });

});
</script>
@endpush
