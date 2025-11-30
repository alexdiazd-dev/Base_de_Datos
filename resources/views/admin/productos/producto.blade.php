@extends('layouts.admin')

@section('titulo', 'Catálogo de Productos')

@section('nav_bar')
    <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
        <div class="rounded-circle bg-light border text-center me-2" 
            style="width:35px;height:35px;line-height:35px;">
            D'N
        </div>
        <div class="lh-1">
            D’Nokali <br>
            <small class="text-muted mt-0" style="font-size: 0.8rem;">Panel Admin</small>
        </div>
    </a>

    @if(session()->has('usuario_id'))
    <div class="d-flex align-items-center gap-3">

        <div class="text-end">
            <strong>{{ session('nombre') }}</strong><br>
            <small class="text-muted">{{ session('correo') }}</small>
        </div>
    </div>
    @endif

    <!-- Cerrar sesión -->
    <x-cerrar_sesion />
@endsection

@push('styles')
<style>
    .card:hover {
    transform: translateY(-4px);
    transition: 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .btn-outline-primary:hover {
        background-color: #cbb4f6;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background-color: #e74c3c;
        color: #fff;
    }
</style>
@endpush



@section('barra_navegacion')
    <x-nav-admin active="productos" />
@endsection


@section('contenido')
<div class="container my-5">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-semibold text-brown d-flex align-items-center">
                <i class="bi bi-box-seam me-2"></i> Catálogo de Productos
            </h3>
            <p class="text-muted">{{$productos_totales}} productos disponibles</p>
        </div>
        <div>
            <x-button
                texto="Agregar Producto" 
                icono="plus-lg" 
                color="agregar"
                ruta="{{ route('admin.productos.agregar') }}"
                size="lg"
                extraClasses="px-4 py-2"
            />
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-md-6">
        <form method="GET" action="{{ route('admin.productos') }}">
            @php
                $optsCategorias = ['todas' => 'Todas las categorías'];
                foreach($categorias as $cat) {    
                    $optsCategorias[$cat->id_categoria] = $cat->nombre;
                }
            @endphp
            
            <x-menu-select 
                label="Categoría"
                id="categoria"
                :options="$optsCategorias"
                :selected="$categoria"
                name="categoria"
                onchange="this.form.submit()"
            />
        </div>

        <div class="col-md-6">
            <x-menu-select 
                label="Ordenar por"
                id="orden"
                name="orden"
                :options="[
                    'nombre_asc' => 'Nombre (A-Z)',
                    'precio_asc' => 'Precio (menor a mayor)',
                    'precio_desc' => 'Precio (mayor a menor)'
                ]"
                :selected="$orden"
                onchange="this.form.submit()"
            />
        </div>
        </form>
    </div>


    <!-- Sección de productos (base de datos) -->

    <div class="row g-4">
        @foreach($productos as $producto)
            <div class="col-md-4 d-flex justify-content-center">
                <x-card-producto
                :imagen="$producto->imagen"
                :nombre="$producto->nombre"
                :descripcion="$producto->descripcion"
                :precio="$producto->precio"
                :id_producto="$producto->id_producto"
                :ver="route('admin.productos.detalle', $producto->id_producto)"
                :editar="route('admin.productos.editar', $producto->id_producto)"
                :eliminar="route('admin.productos.eliminar', $producto->id_producto)"
                />
            </div>
        @endforeach
    </div>
    </div>

</div>
@endsection
