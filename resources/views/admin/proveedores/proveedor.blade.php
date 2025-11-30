@extends('layouts.admin')

@section('titulo', 'Gestion de Proveedores')

@section('nav_bar')
    <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
        <div class="rounded-circle bg-light border text-center me-2" 
            style="width:35px;height:35px;line-height:35px;">
            D'N
        </div>
        <div class="lh-1">
            D'Nokali <br>
            <small class="text-muted mt-0" style="font-size: 0.8rem;">Panel Admin</small>
        </div>
    </a>
    
    <form class="d-flex ms-auto me-3" role="search">
        <input class="form-control rounded-pill me-2" type="search" placeholder="Buscar proveedor..." aria-label="Buscar">
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
    <x-nav-admin active="proveedores" />
@endsection

@section('contenido')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-semibold text-brown">Gestion de Proveedores</h3>
            <p class="text-muted mb-0">Administra la base de datos de proveedores y su informacion</p>
        </div>

        <a href="{{ route('admin.proveedores.create') }}"
           class="btn btn-lavanda rounded-pill px-4 d-flex align-items-center shadow-sm text-white"
           style="font-weight:600;">
            <i class="bi bi-plus-circle me-2"></i> Agregar Proveedor
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Proveedores</h6>
                    <h2 class="fw-semibold text-brown mb-0">{{ $totales['total'] ?? 0 }}</h2>
                    <p class="text-muted mb-0">Base de datos completa</p>
                </div>
                <i class="bi bi-building text-lavanda fs-3"></i>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Proveedores Activos</h6>
                    <h2 class="fw-semibold text-brown mb-0">{{ $totales['activos'] ?? 0 }}</h2>
                    <p class="text-muted mb-0">Actualmente disponibles</p>
                </div>
                <i class="bi bi-clipboard-check text-lavanda fs-3"></i>
            </div>
        </div>
    </div>

    <div class="rounded-4 shadow-sm bg-white p-4 mb-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center flex-grow-1 me-3">
            <i class="bi bi-search text-muted me-2"></i>
            <input type="text" class="form-control border-0 shadow-none" 
                   placeholder="Buscar por nombre, RUC, email..." 
                   style="background: transparent;">
        </div>

        <select class="form-select rounded-pill w-auto">
            <option selected>Todos</option>
            <option>Activos</option>
            <option>Inactivos</option>
        </select>
    </div>

    <div class="rounded-4 shadow-sm p-4 bg-white">
        <h5 class="fw-semibold text-brown mb-3">Lista de Proveedores</h5>
        <p class="text-muted mb-4">Informacion detallada de todos los proveedores registrados</p>

        @if($proveedores->isEmpty())
            <div class="text-center py-5 text-muted" style="border: 2px dashed #e5d9f2; border-radius: 15px;">
                <i class="bi bi-table fs-1 mb-3 d-block"></i>
                <p>Todavia no hay proveedores registrados.</p>
                <small>Usa el boton "Agregar Proveedor" para registrar uno nuevo.</small>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                            <tr>
                                <td class="fw-semibold text-brown">{{ $proveedor->nombre }}</td>
                                <td>{{ $proveedor->ruc }}</td>
                                <td>{{ $proveedor->correo ?? 'Sin correo' }}</td>
                                <td>{{ $proveedor->telefono ?? 'Sin telefono' }}</td>
                                <td>
                                    <span class="badge {{ $proveedor->estado === 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $proveedor->estado }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.proveedores.destroy', $proveedor->id_proveedor) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Seguro que deseas eliminar este proveedor?');">
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
@endsection

