@extends('layouts.admin')

@section('titulo', 'Detalles del Pedido')

@section('nav_bar')
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.pedidos') }}">
        <div class="rounded-circle bg-light border text-center me-2"
            style="width:35px;height:35px;line-height:35px;">D'N</div>
        <div class="lh-1">
            D’Nokali <br>
            <small class="text-muted" style="font-size:.8rem;">Panel Admin</small>
        </div>
    </a>

    @if(session()->has('usuario_id'))
        <div class="ms-auto text-end me-3">
            <strong>{{ session('nombre') }}</strong><br>
            <small class="text-muted">{{ session('correo') }}</small>
        </div>
    @endif

    <x-cerrar_sesion />
@endsection

@section('barra_navegacion')
    <x-nav-admin active="pedidos" />
@endsection

@section('contenido')
<div class="container my-5">

    <!-- Título -->
    <div class="mb-4">
        <h3 class="fw-semibold text-brown">
            Pedido ORD-{{ str_pad($pedido->id_pedido,3,'0',STR_PAD_LEFT) }}
        </h3>
        <p class="text-muted">Detalles registrados en el sistema</p>
    </div>

    <!-- Datos del cliente -->
    <div class="rounded-4 shadow-sm p-4 bg-white mb-4">
        <h5 class="fw-semibold text-brown mb-3">Datos del Cliente</h5>

        <p><strong>Nombre:</strong> {{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</p>
        <p><strong>Correo:</strong> {{ $pedido->usuario->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $pedido->usuario->telefono ?? 'No registrado' }}</p>
        <p><strong>Fecha de registro:</strong> {{ $pedido->usuario->fecha_registro }}</p>
    </div>

    <!-- Datos del pedido -->
    <div class="rounded-4 shadow-sm p-4 bg-white mb-4">
        <h5 class="fw-semibold text-brown mb-3">Información del Pedido</h5>

        <p><strong>Fecha del pedido:</strong> {{ $pedido->fecha_pedido }}</p>
        <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
        <p><strong>Total:</strong> S/ {{ number_format($pedido->total,2) }}</p>
    </div>

    <!-- Detalles del pedido -->
    <div class="rounded-4 shadow-sm p-4 bg-white mb-4">
        <h5 class="fw-semibold text-brown mb-3">Productos del Pedido</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pedido->detalles as $det)
                        <tr>
                            <td>{{ $det->producto->nombre }}</td>
                            <td>{{ $det->cantidad }}</td>
                            <td>S/ {{ number_format($det->subtotal,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- Pago -->
    <div class="rounded-4 shadow-sm p-4 bg-white mb-4">
        <h5 class="fw-semibold text-brown mb-3">Información de Pago</h5>

        @if($pedido->pago)
            <p><strong>Método:</strong> {{ $pedido->pago->metodo_pago }}</p>
            <p><strong>Fecha de pago:</strong> {{ $pedido->pago->fecha_pago }}</p>
            <p><strong>Monto:</strong> S/ {{ number_format($pedido->pago->monto,2) }}</p>
        @else
            <p class="text-muted">Sin pago registrado.</p>
        @endif
    </div>

    <!-- Botón volver -->
    <div class="text-end">
        <a href="{{ route('admin.pedidos') }}" class="btn btn-lavanda rounded-pill px-4">
            Volver a la lista
        </a>
    </div>

</div>
@endsection


