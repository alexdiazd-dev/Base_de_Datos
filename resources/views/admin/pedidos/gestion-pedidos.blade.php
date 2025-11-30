@extends('layouts.admin')

@section('titulo', 'Gestión de Pedidos')

@section('nav_bar')
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.pedidos') }}">
        <div class="rounded-circle bg-light border text-center me-2"
            style="width:35px;height:35px;line-height:35px;">
            D'N
        </div>
        <div class="lh-1">
            D’Nokali <br>
            <small class="text-muted" style="font-size: .8rem;">Panel Admin</small>
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
        <h3 class="fw-semibold text-brown">Gestión de Pedidos</h3>
        <p class="text-muted">Administra los pedidos registrados en el sistema</p>
    </div>

    <!-- Filtros -->
    <div class="rounded-4 shadow-sm p-4 bg-white mb-4">
        <form method="GET" action="{{ route('admin.pedidos') }}">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="fw-semibold text-brown mb-2">Estado</label>
                    <select name="estado" class="form-select rounded-pill">
                        <option value="">Todos</option>
                        @foreach(['Pendiente','Preparación','Enviado','Entregado','Cancelado'] as $est)
                            <option value="{{ $est }}" {{ request('estado')==$est ? 'selected':'' }}>
                                {{ $est }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold text-brown mb-2">Método de Pago</label>
                    <select name="pago" class="form-select rounded-pill">
                        <option value="">Todos</option>
                        @foreach(['Yape','Plin','Tarjeta','Contra Entrega'] as $mp)
                            <option value="{{ $mp }}" {{ request('pago')==$mp ? 'selected':'' }}>
                                {{ $mp }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-lavanda rounded-pill px-4 w-100">
                        Filtrar
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Tabla de pedidos -->
    <div class="rounded-4 shadow-sm p-4 bg-white">
        <h5 class="fw-semibold text-brown mb-3">Lista de Pedidos</h5>

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td>ORD-{{ str_pad($pedido->id_pedido,3,'0',STR_PAD_LEFT) }}</td>

                            <td>{{ $pedido->usuario->nombre }} {{ $pedido->usuario->apellido }}</td>

                            <td>{{ $pedido->fecha_pedido }}</td>

                            <td style="min-width:180px;">
                                <form action="{{ route('admin.pedidos.estado', $pedido->id_pedido) }}" method="POST">
                                    @csrf

                                    <x-menu-select 
                                        id="estado_{{ $pedido->id_pedido }}"
                                        name="estado"
                                        :options="[
                                            'Pendiente' => 'Pendiente',
                                            'Preparación' => 'Preparación',
                                            'Enviado' => 'Enviado',
                                            'Entregado' => 'Entregado',
                                            'Cancelado' => 'Cancelado',
                                        ]"
                                        :selected="$pedido->estado"
                                        class="w-100"
                                        onchange="this.form.submit()"
                                    />

                                </form>

                            </td>


                            <td>S/ {{ number_format($pedido->total,2) }}</td>

                            <td>{{ $pedido->pago->metodo_pago ?? 'Sin pago' }}</td>

                            <td>
                                <a href="{{ route('admin.pedidos.detalles', $pedido->id_pedido) }}"
                                   class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay pedidos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection


