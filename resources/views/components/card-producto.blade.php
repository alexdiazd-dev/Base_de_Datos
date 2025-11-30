@props([
    'id_producto' => null,
    'imagen' => 'default.jpg',
    'nombre' => 'Nombre del producto',
    'descripcion' => 'Descripción del producto',
    'precio' => 0.00,
    'ver' => '#',
    'editar' => '#',
    'eliminar' => '#'
])

<div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="width: 18rem;">
    <img src="{{ asset('storage/' . $imagen) }}" class="card-img-top" alt="{{ $nombre }}" style="height: 200px; object-fit: cover;">

    <div class="card-body text-center">
        <h5 class="card-title fw-semibold text-truncate">{{ $nombre }}</h5>
        <p class="text-muted small mb-2">{{ $descripcion }}</p>
        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
            S/ {{ number_format($precio, 2) }}
        </span>
    </div>

    <div class="card-footer bg-white border-0 d-flex justify-content-around pb-3">
        <a href="{{ $ver }}" class="btn btn-detalle rounded-pill btn-sm">Ver detalles</a>
        <a href="{{ $editar }}" class="btn btn-editar rounded-pill btn-sm">Editar</a>

        {{-- BOTÓN ELIMINAR → abre modal --}}
        <button 
            class="btn btn-eliminar rounded-pill btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#modalEliminar{{ $id_producto }}">
            Eliminar
        </button>
    </div>
</div>


{{-- =========== MODAL DE CONFIRMACIÓN =========== --}}
<x-modal id="modalEliminar{{ $id_producto }}" title="Confirmar eliminación">
    <p class="text-center mb-3">
        ¿Estás seguro de que deseas eliminar el producto <strong>{{ $nombre }}</strong>?
    </p>

    <div class="d-flex justify-content-center gap-3 mt-4">

        {{-- Botón cancelar --}}
        <button class="btn btn-cancelar rounded-pill" data-bs-dismiss="modal">
            Cancelar
        </button>

        {{-- Formulario DELETE --}}
        <form action="{{ $eliminar }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-eliminar rounded-pill">
                Sí, eliminar
            </button>
        </form>
    </div>
</x-modal>


@once
    @push('styles')
        <style>
            .btn-detalle {
                background-color: #A89CF3;
                color: #fff;
            }
            .btn-detalle:hover {
                background-color: #8c7bd8;
                color: #fff;
            }

            /* Botón Editar */
            .btn-editar {
                background-color: #f0eaff;
                color: #000;
            }
            .btn-editar:hover {
                background-color: #e2d8ff;
                color: #000;
            }

            /* Botón Eliminar */
            .btn-eliminar {
                background-color: #b7a4f7;
                color: #fff;
            }
            .btn-eliminar:hover {
                background-color: #9d8be8;
                color: #fff;
            }
        </style>
    @endpush
@endonce
