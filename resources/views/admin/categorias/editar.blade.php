@extends('layouts.admin')

@section('titulo', 'Editar Categoria')

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
    <x-nav-admin active="categorias" />
@endsection

@section('contenido')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-semibold text-brown mb-4">Editar categoria</h3>

                    <form action="{{ route('admin.categorias.update', $categoria->id_categoria) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categorias') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color:#cbb4f6;">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

