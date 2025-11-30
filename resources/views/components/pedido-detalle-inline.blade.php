<div class="pedido-detalle-inline card shadow-sm border-0 p-4 my-3" style="border:1px solid #f2e8ff;">

    <!-- CABECERA -->
    <div class="d-flex justify-content-between align-items-start mb-3">
        <h4 class="fw-semibold text-brown mb-0">
            Pedido #<span id="in-id">—</span>
        </h4>

        <button class="btn btn-light border-0 fs-4 cerrar-panel-inline" style="line-height: 0;">
            &times;
        </button>
    </div>

    <!-- MÉTODO DE PAGO -->
    <div class="p-3 rounded-3 mb-3" style="background:#faf7ff;border:1px solid #f2e8ff;">
        <p class="mb-1">
            <strong>Método de pago:</strong>
            <span id="in-metodo" class="badge estado-pill ms-1">—</span>
        </p>
    </div>

    <!-- INFORMACIÓN DE ENVÍO -->
    <h6 class="fw-semibold text-brown">Información de envío</h6>

    <p class="text-muted small mb-1"><strong>Titular:</strong> <span id="in-nombre">—</span></p>
    <p class="text-muted small mb-1"><strong>Teléfono:</strong> <span id="in-telefono">—</span></p>
    <p class="text-muted small mb-1"><strong>Correo:</strong> <span id="in-correo">—</span></p>
    <p class="text-muted small mb-1"><strong>Dirección:</strong> <span id="in-direccion">—</span></p>
    <p class="text-muted small mb-3"><strong>Ciudad:</strong> <span id="in-ciudad">—</span></p>

    <!-- PRODUCTOS -->
    <h6 class="fw-semibold text-brown mb-2">Productos del pedido</h6>
    <div id="in-productos"></div>

    <!-- TOTALES -->
    <div class="d-flex justify-content-between mt-3">
        <span class="fw-semibold">Subtotal</span>
        <span id="in-subtotal" class="fw-semibold text-brown">S/ 0.00</span>
    </div>

    <div class="d-flex justify-content-between">
        <span class="fw-semibold">Envío</span>
        <span id="in-envio" class="fw-semibold text-brown">S/ 0.00</span>
    </div>

    <div class="d-flex justify-content-between fs-5 fw-bold mt-2 mb-2">
        <span>Total</span>
        <span id="in-total" class="text-brown">S/ 0.00</span>
    </div>

    <!-- Notas -->
    <div id="in-notas-container" class="mt-3 d-none">
        <h6 class="fw-semibold text-brown">Notas</h6>
        <p id="in-notas"></p>
    </div>

</div>
