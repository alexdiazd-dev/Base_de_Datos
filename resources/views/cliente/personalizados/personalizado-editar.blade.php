@extends('layouts.cliente')

@section('titulo', "Editar solicitud personalizada")

@section('barra_navegacion')
    <x-nav-cliente active="personalizados" />
@endsection

@section('contenido')
<div class="container my-5">

    <div class="p-4 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(120deg, #f7e8ff, #fdeedf);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-semibold text-brown mb-1">Editar solicitud</h3>
                <p class="text-muted mb-0">Ajusta los detalles de tu pedido personalizado</p>
            </div>

            <a href="{{ route('cliente.personalizados.detalles', $personalizado->id_personalizacion) }}" 
               class="btn btn-outline-secondary rounded-pill px-4 shadow-sm"
               style="border-color:#cbb4f6;color:#4b3c3a;">
                <i class="bi bi-arrow-left me-2"></i> Volver al detalle
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body px-4 py-5" style="background: #fffaf8;">

            <h5 class="fw-semibold mb-3 text-brown">Solicitud #{{ $personalizado->id_personalizacion }}</h5>
            <p class="text-muted mb-4">Estado actual: <strong class="text-brown">{{ $personalizado->estado }}</strong></p>

            <form method="POST" action="{{ route('cliente.personalizados.actualizar', $personalizado->id_personalizacion) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold text-brown">Descripción del Producto *</label>
                    <textarea
                        name="descripcion"
                        class="form-control rounded-4 border-0 shadow-sm @error('descripcion') is-invalid @enderror"
                        rows="3"
                        required
                        placeholder="Describe detalladamente cómo quieres tu producto personalizado..."
                        style="background-color:#fdf8f4;"
                    >{{ old('descripcion', $personalizado->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-brown">Tamaño *</label>
                        <select
                            name="tamano"
                            class="form-select rounded-4 border-0 shadow-sm @error('tamano') is-invalid @enderror"
                            required
                            style="background-color:#fdf8f4;"
                        >
                            <option value="">Selecciona el tamaño</option>
                            <option value="Pequeño (15cm)" {{ old('tamano', $personalizado->tamano) == 'Pequeño (15cm)' ? 'selected' : '' }}>Pequeño (15cm)</option>
                            <option value="Mediano (20cm)" {{ old('tamano', $personalizado->tamano) == 'Mediano (20cm)' ? 'selected' : '' }}>Mediano (20cm)</option>
                            <option value="Grande (3 pisos)" {{ old('tamano', $personalizado->tamano) == 'Grande (3 pisos)' ? 'selected' : '' }}>Grande (3 pisos)</option>
                        </select>
                        @error('tamano')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-brown">Sabor *</label>
                        <select
                            name="sabor"
                            class="form-select rounded-4 border-0 shadow-sm @error('sabor') is-invalid @enderror"
                            required
                            style="background-color:#fdf8f4;"
                        >
                            <option value="">Selecciona el sabor</option>
                            @foreach(['Vainilla','Chocolate','Red Velvet','Fresa','Combinado'] as $sabor)
                                <option value="{{ $sabor }}" {{ old('sabor', $personalizado->sabor) == $sabor ? 'selected' : '' }}>{{ $sabor }}</option>
                            @endforeach
                        </select>
                        @error('sabor')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-brown">Ocasión</label>
                        <select
                            name="ocasion"
                            class="form-select rounded-4 border-0 shadow-sm @error('ocasion') is-invalid @enderror"
                            style="background-color:#fdf8f4;"
                        >
                            <option value="">Selecciona la ocasión</option>
                            @foreach(['Cumpleaños','Boda','Aniversario','Corporativo','Otro'] as $oc)
                                <option value="{{ $oc }}" {{ old('ocasion', $personalizado->ocasion) == $oc ? 'selected' : '' }}>{{ $oc }}</option>
                            @endforeach
                        </select>
                        @error('ocasion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label fw-semibold text-brown d-flex align-items-center justify-content-between">
                        <span>Imagen de referencia</span>
                        @if($personalizado->imagen_referencia)
                            <small class="text-muted">Actual: <a href="{{ asset('storage/'.$personalizado->imagen_referencia) }}" target="_blank">ver</a></small>
                        @endif
                    </label>
                    <div class="input-group rounded-4 shadow-sm" style="background-color:#fdf8f4;">
                        <span class="input-group-text border-0" style="background-color:#fdf8f4;">
                            <i class="bi bi-upload"></i>
                        </span>
                        <input
                            type="file"
                            name="imagen_referencia"
                            class="form-control border-0 @error('imagen_referencia') is-invalid @enderror"
                            accept="image/*"
                        >
                    </div>
                    <small class="text-muted">Puedes subir una nueva imagen aunque ya exista una.</small>
                    @error('imagen_referencia')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="form-label fw-semibold text-brown">Notas adicionales</label>
                    <textarea
                        name="notas_adicionales"
                        class="form-control rounded-4 border-0 shadow-sm @error('notas_adicionales') is-invalid @enderror"
                        rows="3"
                        placeholder="¿Algún detalle extra? Colores, temática, alérgenos, etc."
                        style="background-color:#fdf8f4;"
                    >{{ old('notas_adicionales', $personalizado->notas_adicionales) }}</textarea>
                    @error('notas_adicionales')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-lavanda text-white rounded-pill px-4">
                        <i class="bi bi-save me-2"></i> Guardar cambios
                    </button>
                    <a href="{{ route('cliente.personalizados.detalles', $personalizado->id_personalizacion) }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
