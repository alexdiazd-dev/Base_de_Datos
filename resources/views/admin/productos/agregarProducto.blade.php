@extends('layouts.admin')

@section('titulo', 'Agregar Producto')

@section('barra_navegacion')
    <x-nav-admin active="productos" />
@endsection

@section('contenido')
<h3 class="mb-4 text-center text-brown">Agregar nuevo producto</h3>

<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="w-50 mx-auto bg-white p-4 rounded-4 shadow-sm">
    @csrf

    {{-- CATEGORÍA --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Categoría</label>
        <select name="id_categoria" class="form-select" required>
            <option value="" disabled {{ old('id_categoria') ? '' : 'selected' }}>Seleccione una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_categoria')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- NOMBRE --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        @error('nombre')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- DESCRIPCIÓN --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
        @error('descripcion')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- PRECIO --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Precio (S/)</label>
        <input type="number" name="precio" step="0.01" class="form-control" value="{{ old('precio') }}" required>
        @error('precio')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- IMAGEN --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*" required>
        @error('imagen')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- ESTADO --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="Disponible" {{ old('estado', 'Disponible') === 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="Agotado" {{ old('estado') === 'Agotado' ? 'selected' : '' }}>Agotado</option>
        </select>
        @error('estado')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    {{-- BOTONES --}}
    <div class="text-center mt-4">
        <x-button texto="Guardar" color="guardar" size="md" icono="check2-circle" type="submit" />
        <x-button texto="Cancelar" color="cancelar" size="md" icono="x-circle" ruta="{{ route('admin.productos') }}" />
    </div>
</form>
@endsection
