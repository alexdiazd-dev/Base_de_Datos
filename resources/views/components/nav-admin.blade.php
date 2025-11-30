@props(['active' => 'productos'])

@php
    $itemClass = fn($current, $active) =>
        $current === $active ? 'admin-link active' : 'admin-link';
@endphp

<div class="admin-sidebar-shell">
    <div class="admin-brand">
        <div class="avatar">D'N</div>
        <div>
            <small class="text-uppercase">Panel</small>
            <div class="fw-semibold text-light">D'Nokali</div>
        </div>
    </div>

    <nav class="admin-nav">
        <p class="text-uppercase small mt-2 mb-2">Gestión</p>
        <a href="{{ route('admin.productos') }}" class="{{ $itemClass('productos', $active) }}">
            <i class="bi bi-box-seam me-2"></i> Productos
        </a>
        <a href="{{ route('admin.personalizados') }}" class="{{ $itemClass('personalizados', $active) }}">
            <i class="bi bi-heart me-2"></i> Personalizados
        </a>
        <a href="{{ route('admin.pedidos') }}" class="{{ $itemClass('pedidos', $active) }}">
            <i class="bi bi-cart3 me-2"></i> Pedidos
        </a>
        <a href="{{ route('admin.proveedores') }}" class="{{ $itemClass('proveedores', $active) }}">
            <i class="bi bi-person-gear me-2"></i> Proveedores
        </a>
        <a href="{{ route('admin.categorias') }}" class="{{ $itemClass('categorias', $active) }}">
            <i class="bi bi-tags me-2"></i> Categorías
        </a>
    </nav>

    <div class="admin-logout mt-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2 rounded-3">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </div>
</div>

@once
    @push('styles')
        <style>
            :root {
                --crema: #fcefe6;
                --lavanda: #a89cf3;
                --marron: #4b3c3a;
                --sidebar-dark: #211a1a;
                --sidebar-darker: #1a1414;
                --text-muted: #d8d2e1;
            }
            body.admin-mode {
                background: #f4f5fb;
            }
            .admin-sidebar-shell {
                color: #f4f3ff;
                font-size: 0.95rem;
            }
            .admin-sidebar {
                background: linear-gradient(180deg, var(--sidebar-dark), var(--sidebar-darker));
                border-right: none;
                min-height: 100vh;
                padding: 24px 18px;
            }
            .admin-brand {
                display: flex;
                align-items: center;
                gap: 0.8rem;
                padding: 0.2rem 0;
                margin-bottom: 1.5rem;
            }
            .admin-brand .avatar {
                width: 48px;
                height: 48px;
                border-radius: 16px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, #fcd9c2, #e3d9ff);
                color: #2d2525;
                font-weight: 800;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            .admin-nav {
                display: flex;
                flex-direction: column;
                gap: 0.45rem;
            }
            .admin-nav p {
                letter-spacing: 0.5px;
                color: var(--text-muted);
                margin-bottom: 0.6rem;
            }
            .admin-link {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                border-radius: 12px;
                color: #f7f6ff;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.2s ease;
                border: 1px solid rgba(255,255,255,0.06);
                background: rgba(255,255,255,0.04);
            }
            .admin-link:hover {
                background: rgba(168, 156, 243, 0.18);
                border-color: rgba(168, 156, 243, 0.35);
                color: #fff;
                transform: translateX(2px);
            }
            .admin-link.active {
                background: linear-gradient(135deg, rgba(168, 156, 243, 0.45), rgba(252, 223, 209, 0.35));
                border-color: rgba(255,255,255,0.26);
                box-shadow: 0 10px 30px rgba(0,0,0,0.18);
                color: #fff;
            }
            .admin-logout .btn {
                border-color: rgba(255,255,255,0.35);
                color: #f4f3ff;
                font-weight: 600;
                padding: 0.65rem 1rem;
            }
            .admin-logout .btn:hover {
                background: rgba(255,255,255,0.12);
                border-color: rgba(255,255,255,0.5);
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.body.classList.add('admin-mode');
            });
        </script>
    @endpush
@endonce
