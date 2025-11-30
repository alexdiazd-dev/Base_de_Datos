<header class="main-header shadow-sm">
    <div class="container-fluid py-3 d-flex align-items-center justify-content-between flex-wrap gap-3">

        <!-- LOGO CENTRADO A LA IZQUIERDA -->
        <a href="{{ route('index') }}" class="brand-title fw-bold text-decoration-none logo-dnokali">
            Pastelería D'Nokali
        </a>

        <!-- BUSCADOR CENTRAL -->
        <div class="flex-grow-1 d-flex justify-content-center">
            <form class="d-flex flex-grow-1"
                action="{{ route('cliente.catalogo') }}"
                method="GET"
                role="search">

                <input
                    class="form-control search-pill w-100"
                    type="search"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar productos..."
                    aria-label="Buscar">
            </form>

        </div>

        <!-- CUENTA + CARRITO -->
        <div class="d-flex align-items-center gap-4">

            {{-- ============================
                 USUARIO LOGEADO
            ============================= --}}
            @if(session('usuario_id') && session('rol') == 2)

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-secondary text-decoration-none dropdown-toggle"
                       data-bs-toggle="dropdown">

                        <i class="bi bi-person-fill fs-5 text-brown"></i>
                        <span class="fw-semibold text-brown">
                            {{ session('nombre') }} {{ session('apellido') }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <button class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Salir
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            @else
                <a href="{{ route('login') }}?back={{ urlencode(request()->fullUrl()) }}"
                   class="d-flex align-items-center gap-2 text-secondary text-decoration-none">
                    <i class="bi bi-person fs-5 text-brown"></i>
                    <span class="fw-semibold text-brown">Cuenta</span>
                </a>
            @endif

            <!-- CARRITO -->
            <div class="position-relative">
                <button id="btnCarrito" class="btn p-0 border-0 d-flex align-items-center justify-content-center" style="background: transparent;">
                    <i class="bi bi-cart3 fs-5 text-brown"></i>
                </button>

                <span id="carritoContadorHeader"
                      class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill"
                      style="font-size:0.65rem; display:none;">0</span>
            </div>
        </div>
    </div>

    <!-- BARRA DE NAVEGACIÓN SECUNDARIA -->
    <nav class="nav-secondary d-flex justify-content-center gap-5 py-2">

        <a href="{{ route('index') }}" class="sec-item {{ request()->routeIs('index') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill me-1"></i> Inicio
        </a>

        <a href="{{ route('cliente.nosotros') }}" class="sec-item {{ request()->routeIs('cliente.nosotros') ? 'active' : '' }}">
            <i class="bi bi-heart-fill me-1"></i> Nosotros
        </a>

        <a href="{{ route('cliente.catalogo') }}" class="sec-item {{ request()->routeIs('cliente.catalogo') ? 'active' : '' }}">
            <i class="bi bi-bag-fill me-1"></i> Catálogo
        </a>

    </nav>
</header>
