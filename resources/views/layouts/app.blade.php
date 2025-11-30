<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', "D'Nokali - Repostería Premium")</title>
    <!-- CSRF para AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos generales -->
    <style>
        :root {
            --crema: #fcefe6;
            --lavanda: #a89cf3;
            --lavanda-oscuro: #8c7bd8;
            --marron: #4b3c3a;
            --gris-fondo: #f6f7fb;
            --gris-borde: #ececf3;
            --header-light: #f5f5f7;
        }

        html, body {
            height: 100%;
        }

        body {
            background: #ffffff;
            color: #4c4444ff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        /* Modo admin: fondo plano para que el sidebar no deje franjas */
        body.admin-mode {
            background: var(--gris-fondo);
            padding: 0;
            margin: 0;
        }
        /* Ocultar barra superior en admin para que la franja lateral cubra todo */
        body.admin-mode header {
            display: none;
        }

        header.main-header {
            background: linear-gradient(180deg, #f7f7f9, #ededf1);
            border-bottom: 1px solid #e7e7ef;
            box-shadow: 0 18px 40px rgba(0,0,0,0.08);
        }
        .text-brown {
            color: #4b3c3a;
        }

        .navbar-brand {
            font-weight: 600;
            color: #6c5ce7 !important;
        }

        .btn-lavanda {
            background-color: #A89CF3;
            color: #fff !important;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-lavanda:hover {
            background-color: #8f82e4;
            box-shadow: 0 4px 12px rgba(168, 156, 243, 0.4);
            color: #fff !important;
        }

        .pill {
            border-radius: 999px;
        }

        .brand-title {
            color: #6c5ce7;
            font-size: 1.05rem;
        }

        .search-pill {
            border-radius: 999px;
            background: #f1f3f6;
            border: 1px solid #dcdfe6;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.04);
            height: 42px;
        }

        .nav-secondary {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .nav-secondary a {
            color: #2c2c2c;
            text-decoration: none;
            padding: 0.35rem 0.6rem;
        }

        .nav-secondary a:hover {
            color: #6c5ce7;
            text-decoration: none;
        }

        /* --- Layout Admin estilo dashboard --- */
        .admin-shell {
            padding: 0;
            min-height: 100vh;
            background: var(--gris-fondo);
        }
        .admin-wrapper {
            display: grid;
            grid-template-columns: 270px 1fr;
            gap: 0;
            background: #fff;
            min-height: 100vh;
        }
        .admin-sidebar {
            background: linear-gradient(180deg, #2d2525, #231d1d);
            color: #fff;
            padding: 20px 18px;
            min-height: 100vh;
            position: sticky;
            top: 0;
        }
        .admin-content {
            background: #f8f9fd;
            padding: 22px 22px 28px;
        }
        @media (max-width: 992px) {
            .admin-wrapper {
                grid-template-columns: 1fr;
            }
            .admin-sidebar {
                border-right: none;
            }
        }

        footer {
            background-color: #fff;
            color: #5a4b43;
            border-top: 1px solid #eee;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Encabezado -->
    <header class="main-header">
        <div class="container-fluid px-4 py-3">
            @hasSection('nav_bar')
                @yield('nav_bar')
            @else
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a class="brand-title fw-semibold text-decoration-none" href="{{ route('index') }}">Pasteleria D'Nokali</a>

                <form class="d-flex flex-grow-1" role="search">
                    <input class="form-control search-pill w-100" type="search" placeholder="Buscar productos..." aria-label="Buscar">
                </form>

                <div class="d-flex align-items-center gap-3 text-secondary small">
                    @php($currentUrl = request()->fullUrl())
                    <a href="{{ route('login') }}?back={{ urlencode($currentUrl) }}" class="d-flex align-items-center gap-1 text-secondary text-decoration-none">
                        <i class="bi bi-person"></i><span>Cuenta</span>
                    </a>
                    <button type="button" id="btnCarrito" class="btn btn-light border rounded-circle position-relative d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                        <i class="bi bi-cart3 fs-6 text-secondary"></i>
                        <span id="carritoContadorHeader" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem; display:none;">0</span>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-4 mt-3 nav-secondary">
                <a href="{{ route('index') }}">Inicio</a>
                <a href="{{ route('cliente.nosotros') }}">Nosotros</a>
                <a href="{{ route('cliente.catalogo') }}">Catalogo</a>
            </div>
            @endif
        </div>
    </header>

    <!-- Contenido dinámico -->
    @if(request()->is('admin*'))
        <main class="admin-shell">
            <div class="admin-wrapper">
                <aside class="admin-sidebar">
                    @yield('barra_navegacion')
                </aside>
                <section class="admin-content">
                    @yield('contenido')
                </section>
            </div>
        </main>
    @else
        <main class="container my-4 @yield('main_class')">
            @yield('barra_navegacion')
            @yield('contenido')
        </main>
    @endif

    <!-- Footer (oculto en admin) -->
    @if (!request()->is('admin*') && !View::hasSection('no_footer'))
    <footer class="bg-white border-top mt-5 py-5">
    <div class="container">
        <div class="row align-items-start text-center text-md-start">
      
      <!-- Logo y descripción -->
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="d-flex flex-column align-items-center align-items-md-start">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center me-2" 
                        style="width:45px; height:45px; background-color:#d3c3f7 !important;">
                        <span class="fw-bold text-primary">D'N</span>
                    </div>
                <div>
                    <div class="fw-semibold">D'Nokali</div>
                        <small class="text-muted">Repostería Premium</small>
                    </div>
                </div>
          <p class="small text-muted mb-0 mt-2">
            Creando momentos dulces e inolvidables para tus<br>
            eventos especiales desde el corazón.
          </p>
        </div>
      </div>

      <!-- Contacto -->
      <div class="col-md-4 mb-4 mb-md-0">
        <h6 class="fw-semibold mb-3">Contacto</h6>
        <ul class="list-unstyled small text-muted mb-0">
          <li class="mb-1"><i class="bi bi-telephone-fill text-primary me-2"></i> +51 989 989 989</li>
          <li class="mb-1"><i class="bi bi-envelope-fill text-primary me-2"></i> contacto@dnokali.pe</li>
          <li class="mb-1"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Lima, Perú</li>
          <li><i class="bi bi-clock-fill text-primary me-2"></i> Lun - Sáb: 9am - 7pm</li>
        </ul>
      </div>

      <!-- Redes sociales -->
      <div class="col-md-4">
        <h6 class="fw-semibold mb-3">Síguenos</h6>
        <div class="d-flex justify-content-center justify-content-md-start gap-3 mb-2">
          <a href="#" class="text-decoration-none text-secondary fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-decoration-none text-secondary fs-5"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-decoration-none text-secondary fs-5"><i class="bi bi-telegram"></i></a>
        </div>
        <p class="small text-muted mb-0">
          Comparte tu experiencia con nosotros usando <strong>#DNokali</strong>
        </p>
      </div>

    </div>

    <!-- Línea divisoria -->
    <hr class="mt-5 mb-3 text-muted opacity-25">

    <!-- Créditos -->
    <div class="text-center small text-muted">
      © 2025 <span class="fw-semibold">D'Nokali</span> — Todos los derechos reservados.<br>
      Diseñado con 💜 para endulzar tus momentos.
    </div>
  </div>
</footer>

    @endif
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.appConfig = {
            isAuth: {{ session()->has('usuario_id') ? 'true' : 'false' }},
            loginUrl: "{{ route('login') }}"
        };
    </script>

    {{-- Modal Detalle de Producto (reutilizable) --}}
    <div class="modal fade" id="productoDetalleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 id="detalleTitulo" class="fw-semibold text-brown mb-1">Producto</h4>
                            <small id="detalleCategoria" class="badge bg-lavanda text-white pill px-3 py-2">Categoría</small>
                        </div>
                        <button type="button" class="btn btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Cerrar">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <img id="detalleImagen" src="" alt="" class="w-100 rounded-4 shadow-sm" style="object-fit: cover; height: 240px;">
                        </div>
                        <div class="col-md-7 d-flex flex-column">
                            <p id="detalleDescripcion" class="text-muted mb-3"></p>
                            <div class="mb-3">
                                <span class="badge bg-success-subtle text-success pill px-3 py-2">Disponible</span>
                            </div>
                            <div class="h4 text-brown mb-4">S/ <span id="detallePrecio">0.00</span></div>
                            <div class="mt-auto d-flex gap-2">
                                <button type="button" class="btn btn-lavanda rounded-pill px-4" id="detalleAgregar">Agregar al carrito</button>
                                <a href="#" id="detalleVerRuta" class="btn btn-outline-secondary rounded-pill px-4" target="_blank">Ver ficha</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("click", (e) => {
            const btn = e.target.closest(".btn-ver-detalle");
            if (!btn) return;

            const modal = document.getElementById("productoDetalleModal");
            const modalInstance = modal ? new bootstrap.Modal(modal) : null;
            if (!modalInstance) return;

            const titulo = btn.dataset.nombre || "Producto";
            const descripcion = btn.dataset.descripcion || "";
            const precio = Number(btn.dataset.precio || 0).toFixed(2);
            const categoria = btn.dataset.categoria || "General";
            const imagen = btn.dataset.imagen ? (btn.dataset.imagen.includes('http') ? btn.dataset.imagen : btn.dataset.imagen) : '';
            const ruta = btn.dataset.ver || "#";

            document.getElementById("detalleTitulo").textContent = titulo;
            document.getElementById("detalleDescripcion").textContent = descripcion;
            document.getElementById("detallePrecio").textContent = precio;
            document.getElementById("detalleCategoria").textContent = categoria;
            document.getElementById("detalleImagen").src = imagen ? (imagen.startsWith('http') ? imagen : `${window.location.origin}/storage/${imagen}`) : '';
            document.getElementById("detalleVerRuta").href = ruta;

            const agregarBtn = document.getElementById("detalleAgregar");
            if (agregarBtn) {
                agregarBtn.onclick = () => {
                    const trigger = document.querySelector(`.btn-agregar-carrito[data-id="${btn.dataset.id}"]`);
                    if (trigger) trigger.click();
                    modalInstance.hide();
                };
            }

            modalInstance.show();
        });
    </script>

    <x-carrito_compras />

    @stack('scripts')
</body>
</html>
