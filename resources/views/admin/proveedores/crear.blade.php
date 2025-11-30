@extends('layouts.admin')

@section('titulo', 'Agregar Proveedor')

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

    <x-cerrar_sesion />
@endsection

@section('barra_navegacion')
    <x-nav-admin active="proveedores" />
@endsection

@section('contenido')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-semibold text-brown mb-4">Agregar nuevo proveedor</h3>

                    <form action="{{ route('admin.proveedores.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">RUC</label>
                            <input type="text" name="ruc" class="form-control" value="{{ old('ruc') }}" required>
                            @error('ruc')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo</label>
                            <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
                            @error('correo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Telefono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                            @error('telefono')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Direccion</label>
                            <textarea name="direccion" class="form-control" rows="3">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Estado</label>
                            <select name="estado" class="form-select" required>
                                <option value="Activo" {{ old('estado', 'Activo') === 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.proveedores') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-lavanda rounded-pill px-4 text-white">
                                Guardar proveedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

