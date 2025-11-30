@extends('layouts.admin')

@section('titulo', 'Gestion de Categorias')

@section('nav_bar')
    <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
        <div class="rounded-circle d-flex justify-content-center align-items-center me-2" 
             style="width:35px;height:35px;background-color:#e8defa;color:#4b3c3a;font-weight:600;">
            D'N
        </div>
        <div class="lh-1">
            D'Nokali <br>
            <small class="text-muted" style="font-size: 0.8rem;">Panel Admin</small>
        </div>
    </a>

    <form class="d-flex ms-auto me-3" role="search">
        <input class="form-control rounded-pill me-2" type="search" placeholder="Buscar categoria..." aria-label="Buscar" disabled>
    </form>

    @if(session()->has('usuario_id'))
    <div class="d-flex align-items-center gap-3">

        <div class="text-end">
            <strong>{{ session('nombre') }}</strong><br>
            <small class="text-muted">{{ session('correo') }}</small>
        </div>
    </div>
    @endif

    <x-cerrar_sesion />
@endsection

@section('barra_navegacion')
    <x-nav-admin active="categorias" />
@endsection

@section('contenido')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-semibold text-brown">Gestion de Categorias</h3>
            <p class="text-muted mb-0">Administra las categorias de productos del catalogo</p>
        </div>

        <a href="{{ route('admin.categorias.create') }}"
           class="btn btn-lavanda rounded-pill px-4 d-flex align-items-center shadow-sm text-white"
           style="font-weight:600;">
            <i class="bi bi-plus-circle me-2"></i> Agregar Categoria
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Categorias</h6>
                        <h2 class="fw-semibold mb-0 text-brown">{{ $totales['total'] }}</h2>
                        <p class="text-muted mb-0">Registradas en el sistema</p>
                    </div>
                    <div class="fs-3 text-lavanda">
                        <i class="bi bi-folder"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Con productos</h6>
                        <h2 class="fw-semibold mb-0 text-brown">{{ $totales['con_productos'] }}</h2>
                        <p class="text-muted mb-0">Categorias con al menos un producto</p>
                    </div>
                    <div class="fs-3 text-lavanda">
                        <i class="bi bi-tags"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Productos asociados</h6>
                        <h2 class="fw-semibold mb-0 text-brown">{{ $totales['productos_asociados'] }}</h2>
                        <p class="text-muted mb-0">Productos con categoria asignada</p>
                    </div>
                    <div class="fs-3 text-lavanda">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3 text-brown">Lista de Categorias</h5>
            <p class="text-muted mb-4">Informacion detallada de todas las categorias registradas</p>

            @if ($categorias->isEmpty())
                <div class="text-center py-5 text-muted" style="border: 2px dashed #e5d9f2; border-radius: 15px;">
                    <i class="bi bi-table fs-1 mb-3 d-block"></i>
                    <p>Todavia no hay categorias registradas.</p>
                    <small>Usa el boton "Agregar Categoria" para registrar una nueva.</small>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>Nombre</th>
                                <th class="text-center">Productos asociados</th>
                                <th style="min-width:280px;">Productos</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td class="fw-semibold text-brown">{{ $categoria->nombre }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $categoria->productos_count ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} px-3 py-2 rounded-pill">
                                            {{ $categoria->productos_count }} {{ \Illuminate\Support\Str::plural('producto', $categoria->productos_count) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($categoria->productos_count === 0)
                                            <span class="text-muted small">Sin productos vinculados</span>
                                        @else
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($categoria->productos as $producto)
                                                    <span class="badge rounded-pill" style="background-color:#f2ecff;color:#4b3c3a;">
                                                        <i class="bi bi-cupcake me-1"></i>{{ $producto->nombre }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}" class="btn btn-sm btn-outline-secondary me-2">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.categorias.destroy', $categoria->id_categoria) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Seguro que deseas eliminar esta categoria?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

