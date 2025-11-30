@extends('layouts.cliente')

@section('titulo', 'Catálogo de Productos')

@section('franja')
    <x-franja titulo="Explora Nuestros Sabores" subtitulo="Explora todos nuestros productos" />
@endsection

@section('barra_navegacion')
    <x-nav-cliente active="catalogo" />
@endsection

@section('contenido')
<div class="container my-4">
    <div class="catalogo-header mb-4">
        <h3 class="fw-semibold text-brown d-flex align-items-center">
            Catálogo de Productos
        </h3>
        <p class="text-muted">{{$productos_totales}} productos disponibles</p>
    </div>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-6">
            <form method="GET" action="{{ route('cliente.catalogo') }}">
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

        <!-- Cards de productos -->
        <div class="text-center text-muted mt-5">
            <div class="row g-4">
            @foreach($productos as $producto)
                <div class="col-md-4 d-flex justify-content-center">
                    <x-card-producto-cliente
                        :id="$producto->id_producto"
                        :imagen="$producto->imagen"
                        :nombre="$producto->nombre"
                        :descripcion="$producto->descripcion"
                        :precio="$producto->precio"
                        :categoria="$producto->categoria->nombre"
                        :ver="route('cliente.catalogo.detalle', $producto->id_producto)"
                    />

                </div>
            @endforeach
            </div>
        </div>
    </div>

    {{-- Contenedor para notificaciones toast --}}
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

@endsection

@push('scripts')
<script>
    // Sistema de notificaciones toast para catálogo
    function mostrarToast(mensaje, tipo = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        // Crear elemento toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification shadow-sm';
        toast.style.cssText = `
            background: ${tipo === 'success' ? 'linear-gradient(135deg, #f7f1fd, #fffaf5)' : 'linear-gradient(135deg, #ffe9e8, #fff6e6)'};
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 10px;
            border: 1px solid ${tipo === 'success' ? '#e8dcf7' : '#ffcbc6'};
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 250px;
            max-width: 350px;
            animation: slideIn 0.3s ease-out;
        `;

        // Icono
        const icon = document.createElement('i');
        icon.className = tipo === 'success' ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill';
        icon.style.cssText = `
            color: ${tipo === 'success' ? '#8b5cf6' : '#ef4444'};
            font-size: 1.2rem;
        `;

        // Texto
        const text = document.createElement('span');
        text.textContent = mensaje;
        text.style.cssText = `
            color: #4b3c3a;
            font-weight: 600;
            font-size: 0.95rem;
        `;

        toast.appendChild(icon);
        toast.appendChild(text);
        container.appendChild(toast);

        // Animación de entrada
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        if (!document.querySelector('#toast-styles')) {
            style.id = 'toast-styles';
            document.head.appendChild(style);
        }

        // Auto-eliminar después de 3 segundos
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Interceptar eventos de agregar/eliminar del carrito
    document.addEventListener('click', async (e) => {
        const addBtn = e.target.closest('.btn-agregar-carrito');
        if (addBtn) {
            // Esperar un momento para que el carrito se actualice
            setTimeout(() => {
                mostrarToast('Producto agregado', 'success');
            }, 100);
            return;
        }

        const removeBtn = e.target.closest('.btn-card-remove');
        if (removeBtn) {
            setTimeout(() => {
                mostrarToast('Producto eliminado', 'error');
            }, 100);
            return;
        }
    });
</script>
@endpush
