@extends('layouts.admin')

@section('titulo', 'Editar Producto')

@section('barra_navegacion')
    <x-nav-admin active="productos" />
@endsection

@section('contenido')
<h3 class="mb-4 text-center text-brown">Editar producto</h3>

<form action="{{ route('admin.productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data" class="w-50 mx-auto bg-white p-4 rounded-4 shadow-sm">
    @csrf
    @method('PUT')

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CATEGORÍA --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Categoría</label>
        <select name="id_categoria" class="form-select" required>
            <option value="" disabled>Seleccione una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}" {{ $producto->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- NOMBRE --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
    </div>

    {{-- DESCRIPCIÓN --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3">{{ $producto->descripcion }}</textarea>
    </div>

    {{-- PRECIO --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Precio (S/)</label>
        <input type="number" name="precio" step="0.01" class="form-control" value="{{ $producto->precio }}" required>
    </div>

    {{-- IMAGEN ACTUAL --}}
    @if($producto->imagen)
        <div class="mb-3">
            <label class="form-label fw-semibold">Imagen actual</label>
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid rounded" style="max-height:200px; object-fit:cover;">
            </div>
        </div>
    @endif

    {{-- IMAGEN (cambiar) --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Cambiar imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
        <small class="text-muted">Deja vacío si no deseas cambiar la imagen</small>
    </div>

    {{-- ESTADO --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="Disponible" {{ $producto->estado === 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="Agotado" {{ $producto->estado === 'Agotado' ? 'selected' : '' }}>Agotado</option>
        </select>
    </div>

    {{-- BOTONES --}}
    <div class="text-center mt-4">
        <x-button texto="Actualizar" color="guardar" size="md" icono="check2-circle" type="submit" />
        <x-button texto="Cancelar" color="cancelar" size="md" icono="x-circle" ruta="{{ route('admin.productos') }}" />
    </div>
</form>
@endsection
