{{-- COMPONENTE: Carrito de Compras (Sidebar) --}}
<style>
    .carrito-sidebar { box-sizing: border-box; }
    .btn-carrito-catalogo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0.55rem 1.1rem;
        background: linear-gradient(135deg, #b4a5ff, #f3c4ff);
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 10px 20px rgba(168,156,243,0.25);
    }
    .btn-carrito-catalogo:hover { color: #fff; filter: brightness(0.95); }
    .cart-qty, .qty-bubble {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f4f0ff;
        border-radius: 999px;
        padding: 6px 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .cart-qty .icon-btn, .qty-bubble .icon-btn {
        width: 30px; height: 30px; border-radius: 50%;
        background: #a89cf3; color: #fff; border: none;
        display: inline-flex; align-items: center; justify-content: center; padding: 0;
    }
    .cart-qty .icon-btn:hover, .qty-bubble .icon-btn:hover { background: #8c7bd8; }
    .cart-qty .btn-carrito-remove, .qty-bubble .btn-card-remove { background: #a89cf3; color: #fff; }
    .cart-qty .btn-carrito-remove:hover, .qty-bubble .btn-card-remove:hover { background: #8c7bd8; }
    .cart-qty .qty-number, .qty-bubble .qty-number { min-width: 18px; text-align: center; font-weight: 600; color: #4b3c3a; }

    /* Responsivo y sticky */
    #carritoSidebar { width: 100%; max-width: 420px; right: -100%; }
    #carritoConProductos { display: none; flex-direction: column; min-height: 0; gap: 0.75rem; }
    .carrito-scroll { max-height: 45vh; overflow-y: auto; overflow-x: hidden; padding-right: 4px; }
    .carrito-item .flex-grow-1 { min-width: 0; }
    .carrito-resumen { background: #fffaf8; border-radius: 12px; padding: 0.75rem 0; }
    .carrito-buttons { position: sticky; bottom: 0; background: #fffaf8; padding-top: 0.75rem; padding-bottom: 0.25rem; }
    @media (max-width: 768px) {
        #carritoSidebar { padding: 1.1rem; }
        .carrito-scroll { max-height: 50vh; }
    }
    @media (max-width: 576px) {
        #carritoSidebar { max-width: 100%; right: -100%; }
        .carrito-item img { width: 60px !important; height: 60px !important; }
        .cart-qty, .qty-bubble { gap: 6px; padding: 6px 8px; }
        .cart-qty .icon-btn, .qty-bubble .icon-btn { width: 28px; height: 28px; }
    }
</style>

<div 
    id="carritoSidebar"
    class="carrito-sidebar shadow-lg"
    style="
        position: fixed;
        top: 0;
        right: -100%; 
        width: 100%;
        max-width: 420px;
        height: 100vh;
        background-color: #fffaf8;
        transition: right 0.35s ease;
        z-index: 9999;
        padding: 1.5rem;
        font-family: 'Poppins', sans-serif;
        display: flex;
        flex-direction: column;
    "
>
    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-brown">Carrito de Compras</h5>

        <button 
            id="cerrarCarritoBtn"
            class="btn rounded-circle"
            style="background-color:#f2e6dc; width:35px; height:35px;"
        >
            <i class="bi bi-x-lg" style="color:#4b3c3a;"></i>
        </button>
    </div>

    <hr>

    {{-- CONTENEDOR PRINCIPAL DEL CARRITO --}}
    <div id="carritoContenido" class="mt-3 d-flex flex-column flex-grow-1">

        {{-- --- ESTADO VACÍO --- --}}
        <div id="carritoVacio" class="text-center text-muted" style="display: block;">
            <img 
                src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png"
                {{-- src="{{ asset('imagenes/denokali.png') }}" --}}
                width="90"
                class="mb-3 opacity-75"
            >
            <h6 class="fw-semibold text-brown">Tu carrito está vacío</h6>
            <p class="text-muted small">Agrega productos desde el catálogo</p>

            <a href="{{ route('cliente.catalogo') }}" class="btn-carrito-catalogo mt-2">
                Ver Catálogo
            </a>
        </div>

        {{-- --- ESTADO CON PRODUCTOS --- --}}
        <div id="carritoConProductos" style="display: none; flex-direction: column; min-height: 0; gap: 0.75rem;">
            
            {{-- LISTA DE PRODUCTOS --}}
            <div id="listaProductosCarrito" class="mb-3 carrito-scroll">
                {{-- Aquí luego se insertarán los productos reales --}}
                <p class="text-muted">Aquí irán los productos del carrito...</p>
            </div>

            {{-- RESUMEN --}}
            <div class="carrito-resumen">
                <div class="d-flex justify-content-between mb-2 gap-2">
                    <span class="text-brown">Subtotal</span>
                    <span id="carritoSubtotal" class="text-brown text-end">S/ 0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2 gap-2">
                    <span class="text-brown">Delivery</span>
                    <span class="text-brown text-end">S/ 6.00</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between mb-1 gap-2">
                    <span class="fw-semibold text-brown">Total</span>
                    <span id="carritoTotal" class="fw-bold text-end" style="color:#4b3c3a;">S/ 0.00</span>
                </div>
            </div>

            {{-- BOTONES FINALES STICKY --}}
            <div class="carrito-buttons">
                <div class="d-flex flex-column gap-2">
                    {{-- Botón Vaciar Carrito --}}
                    <x-button 
                        texto="Vaciar Carrito"
                        color="btn-agregar"
                        size="md"
                        type="button"
                        id="vaciarCarritoBtn"
                    />

                    {{-- Botón Proceder Pago --}}
                    <x-button 
                        texto="Proceder al Pago"
                        color="btn-agregar"
                        size="md"
                        ruta="{{ route('cliente.pasarela.pago') }}"
                        id="btnProcederPago"
                        :data-auth="session()->has('usuario_id') ? 1 : 0"
                    />
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal: producto agregado --}}
<div class="modal fade" id="modalCarritoAgregado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Agregado al carrito</span>
                </div>
                <img id="modalCarritoImagen" src="" alt="Producto" class="rounded-4 mb-3" style="width: 110px; height: 110px; object-fit: cover;">
                <h5 id="modalCarritoNombre" class="fw-semibold text-brown mb-1">Producto</h5>
                <p id="modalCarritoPrecio" class="text-muted mb-3">S/ 0.00</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Seguir comprando</button>
                    <button type="button" id="btnIrCarrito" class="btn btn-lavanda rounded-pill px-3">Ir al carrito</button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- SCRIPT REAL DEL CARRITO --}}
@push('scripts')
<script>

    /* ============================================================
        ABRIR / CERRAR SIDEBAR
    ============================================================ */

    function abrirCarrito() {
        document.getElementById('carritoSidebar').style.right = '0';
    }

    function cerrarCarrito() {
        document.getElementById('carritoSidebar').style.right = '-100%';
    }

    const btnCarrito = document.getElementById('btnCarrito');
    if (btnCarrito) {
        btnCarrito.addEventListener('click', abrirCarrito);
    }
    document.querySelectorAll('.btn-open-carrito').forEach(el => {
        el.addEventListener('click', abrirCarrito);
    });

    const cerrarBtn = document.getElementById('cerrarCarritoBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', cerrarCarrito);
    }


    /* ============================================================
        UTILIDADES PARA FETCH + CSRF
    ============================================================ */

    async function postData(url = "", data = {}) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const res = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        });

        return await res.json();
    }

    async function obtenerCarritoServidor() {
        const res = await fetch("/cliente/carrito/obtener");
        return await res.json();
    }

    const checkoutUrl = "{{ route('cliente.pasarela.pago') }}";
    const loginUrl = "{{ route('login') }}";
    let carritoState = {};

    async function setCantidad(id, cantidad) {
        const data = await postData(`/cliente/carrito/actualizar/${id}`, { cantidad });
        setCarritoState(data.carrito, data.total);
    }

    async function eliminarItem(id) {
        const data = await postData(`/cliente/carrito/eliminar/${id}`);
        setCarritoState(data.carrito, data.total);
    }

    async function agregarItem(id) {
        const data = await postData(`/cliente/carrito/agregar/${id}`);
        setCarritoState(data.carrito, data.total);
    }

    function setCarritoState(carrito, total) {
        carritoState = carrito || {};
        actualizarContadorCarrito(carritoState);
        renderSidebarCarrito(carritoState, total);
        syncCardControls();
    }

    function syncCardControls() {
        document.querySelectorAll('.qty-bubble[data-product-id]').forEach(el => {
            const id = el.dataset.productId;
            const data = carritoState[id];
            const qty = data ? data.cantidad : 0;
            const card = el.closest('.product-card');
            const qtySpan = el.querySelector('.qty-number');
            const addBtn = el.parentElement.querySelector('.btn-agregar-carrito');
            const pill = document.getElementById(`pill-${id}`);
            const hasHover = card && card.matches(':hover');

            const shouldShowControls = qty > 0 && hasHover;

            if (shouldShowControls) {
                el.classList.remove('d-none');
                if (qtySpan) qtySpan.textContent = qty;
                if (addBtn) addBtn.classList.add('d-none');
            } else {
                el.classList.add('d-none');
                if (addBtn) addBtn.classList.remove('d-none');
            }

            if (pill) {
                if (qty > 0 && hasHover) {
                    pill.classList.remove('d-none');
                    pill.textContent = qty;
                } else {
                    pill.classList.add('d-none');
                }
            }
        });
    }



    /* ============================================================
        CONTADOR DEL BOTÓN CARRITO
    ============================================================ */

    function actualizarContadorCarrito(carrito) {
        let total = 0;

        Object.values(carrito).forEach(item => {
            total += item.cantidad;
        });

        const contador = document.getElementById("carritoContador");
        const contadorHeader = document.getElementById("carritoContadorHeader");
        if (contador) {
            contador.innerText = total;
        }
        if (contadorHeader) {
            contadorHeader.innerText = total;
            contadorHeader.style.display = total > 0 ? 'inline-block' : 'none';
        }
    }


    /* ============================================================
        RENDERIZAR CARRITO EN EL SIDEBAR
    ============================================================ */

    function renderSidebarCarrito(carrito, total) {

        const vacio = document.getElementById("carritoVacio");
        const lleno = document.getElementById("carritoConProductos");
        const lista = document.getElementById("listaProductosCarrito");
        const subtotalSpan = document.getElementById("carritoSubtotal");
        const totalSpan = document.getElementById("carritoTotal");
        const deliveryCost = 6.00;

        if (!carrito || Object.keys(carrito).length === 0) {
            vacio.style.display = "block";
            lleno.style.display = "none";
            if (subtotalSpan) subtotalSpan.textContent = "S/ 0.00";
            totalSpan.textContent = "S/ 0.00";
            lista.innerHTML = "";
            return;
        }

        vacio.style.display = "none";
        lleno.style.display = "flex";

        lista.innerHTML = "";

        let subtotal = 0;
        Object.values(carrito).forEach(item => {
            const itemSubtotal = (Number(item.precio) * Number(item.cantidad));
            subtotal += itemSubtotal;
            lista.innerHTML += `
                <div class="d-flex align-items-center gap-3 mb-3 carrito-item" data-id="${item.id}">
                    <img src="${item.imagen ? '/storage/' + item.imagen : ''}" 
                        alt="${item.nombre}" 
                        style="width:68px;height:68px;object-fit:cover;border-radius:14px;">

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div style="min-width:0;">
                                <strong class="d-block text-truncate">${item.nombre}</strong>
                                <small class="text-muted">S/ ${Number(item.precio).toFixed(2)}</small>
                            </div>
                            <button class="btn icon-btn btn-carrito-remove" data-id="${item.id}" aria-label="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <div class="cart-qty" data-id="${item.id}">
                                <button class="btn icon-btn btn-carrito-minus" data-id="${item.id}" aria-label="Reducir">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="qty-number" id="qty-cart-${item.id}">${item.cantidad}</span>
                                <button class="btn icon-btn btn-carrito-plus" data-id="${item.id}" aria-label="Aumentar">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div class="ms-auto text-brown fw-semibold">S/ ${itemSubtotal.toFixed(2)}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        const totalFinal = subtotal + deliveryCost;
        if (subtotalSpan) subtotalSpan.textContent = "S/ " + subtotal.toFixed(2);
        totalSpan.textContent = "S/ " + totalFinal.toFixed(2);
    }




    /* ============================================================
        MODAL PRODUCTO AGREGADO
    ============================================================ */

    // Deshabilitamos el modal de agregado
    function mostrarModalAgregado(item) { return; }


    /* ============================================================
        VALIDACIÓN BOTÓN PROCEDER AL PAGO
    ============================================================ */

    const btnProcederPago = document.getElementById('btnProcederPago');
    if (btnProcederPago) {
        btnProcederPago.addEventListener('click', function(e) {
            const isAuth = {{ session()->has('usuario_id') ? 'true' : 'false' }};
            
            if (!isAuth) {
                e.preventDefault();
                const loginUrlWithBack = "{{ route('login') }}?back=" + encodeURIComponent("{{ route('cliente.pasarela.pago') }}");
                window.location.href = loginUrlWithBack;
            }
        });
    }


    /* ============================================================
        AGREGAR AL CARRITO (delegación)
    ============================================================ */

    document.addEventListener("click", async (e) => {

        const addBtn = e.target.closest(".btn-agregar-carrito");
        if (addBtn) {
            const id = addBtn.dataset.id;
            const data = await postData(`/cliente/carrito/agregar/${id}`);
            setCarritoState(data.carrito, data.total);
            return;
        }

        const plusCard = e.target.closest('.btn-card-plus');
        if (plusCard) {
            const id = plusCard.dataset.id;
            const current = carritoState[id]?.cantidad || 0;
            await setCantidad(id, current + 1);
            return;
        }

        const minusCard = e.target.closest('.btn-card-minus');
        if (minusCard) {
            const id = minusCard.dataset.id;
            const current = carritoState[id]?.cantidad || 0;
            if (current <= 1) {
                await eliminarItem(id);
            } else {
                await setCantidad(id, current - 1);
            }
            return;
        }

        const removeCard = e.target.closest('.btn-card-remove');
        if (removeCard) {
            const id = removeCard.dataset.id;
            await eliminarItem(id);
            return;
        }

        const plusCart = e.target.closest('.btn-carrito-plus');
        if (plusCart) {
            const id = plusCart.dataset.id;
            const current = carritoState[id]?.cantidad || 0;
            await setCantidad(id, current + 1);
            return;
        }

        const minusCart = e.target.closest('.btn-carrito-minus');
        if (minusCart) {
            const id = minusCart.dataset.id;
            const current = carritoState[id]?.cantidad || 0;
            if (current <= 1) {
                await eliminarItem(id);
            } else {
                await setCantidad(id, current - 1);
            }
            return;
        }

        const removeCart = e.target.closest('.btn-carrito-remove');
        if (removeCart) {
            const id = removeCart.dataset.id;
            await eliminarItem(id);
            return;
        }
    });





    /* ============================================================
        VACIAR CARRITO
    ============================================================ */

    const vaciarBtn = document.getElementById("vaciarCarritoBtn");
    if (vaciarBtn) {
        vaciarBtn.addEventListener("click", async () => {
            const data = await postData("/cliente/carrito/vaciar");
            setCarritoState(data.carrito || {}, data.total || 0);
        });
    }


    /* ============================================================
        CARGAR CARRITO AL INICIAR (siempre se ejecuta)
    ============================================================ */

    (async () => {
        const data = await obtenerCarritoServidor();
        setCarritoState(data.carrito, data.total);
        // re-sincronizar en hover inicial para ocultar controles si no hay hover
        syncCardControls();
    })();

</script>
@endpush
