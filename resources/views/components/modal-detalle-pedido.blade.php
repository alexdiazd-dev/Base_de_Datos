<div id="detallePedidoOverlay" class="detalle-overlay d-none">
    <div class="detalle-modal rounded-4 shadow-lg">

        {{-- Botón de cierre --}}
        <button class="close-btn" onclick="cerrarDetallePedido()">✕</button>

        {{-- ENCABEZADO --}}
        <h4 class="fw-semibold text-brown mb-0">
            Pedido #<span id="dp-id"></span>
        </h4>
        <p class="text-muted fs-6 mb-3">Información completa del pedido</p>

        {{-- ESTADO Y MÉTODO DE PAGO --}}
        <div class="p-3 rounded-3 mb-3 bg-white border" style="border-color:#f2e8ff !important;">
            <span id="dp-estado" class="badge estado-pill">Estado</span>

            <p class="mt-2 mb-1">
                <strong>Método de pago:</strong>
                <span id="dp-metodo" class="badge estado-pill ms-1"></span>
            </p>
        </div>

        {{-- DATOS DE ENVÍO --}}
        <div class="p-3 rounded-3 mb-3 bg-white">
            <h6 class="fw-semibold text-brown mb-2">Delivery</h6>

            <p class="text-muted mb-1">
                <strong>Titular: </strong> <span id="dp-nombre"></span>
            </p>

            <p class="text-muted small mb-1">
                Documento: <span id="dp-documento"></span>
            </p>

            <p class="text-muted small mb-1">
                Tel: <span id="dp-telefono"></span>
            </p>

            <p class="text-muted small mb-1">
                Tipo de vivienda: <span id="dp-vivienda"></span>
            </p>

            <p class="text-muted small mb-1" id="dp-direccion"></p>
            <p class="text-muted small mb-1" id="dp-referencia"></p>
            <p class="text-muted small mb-1" id="dp-ubicacion"></p>
        </div>

        {{-- PRODUCTOS --}}
        <div class="p-3 rounded-3 mb-3 bg-white">
            <h6 class="fw-semibold text-brown mb-3">Productos del pedido</h6>

            <div id="dp-productos"></div>

            <div class="d-flex justify-content-between mt-3">
                <span class="fw-semibold">Subtotal</span>
                <span id="dp-subtotal" class="fw-semibold text-brown"></span>
            </div>

            <div class="d-flex justify-content-between">
                <span class="fw-semibold">Envío</span>
                <span id="dp-envio" class="fw-semibold text-brown"></span>
            </div>

            <div class="d-flex justify-content-between fs-5 fw-bold mt-2">
                <span>Total</span>
                <span id="dp-total" class="text-brown"></span>
            </div>
        </div>

        {{-- NOTAS --}}
        <div id="dp-notas-container" class="p-3 rounded-3 bg-white d-none">
            <h6 class="fw-semibold text-brown">Notas</h6>
            <p id="dp-notas" class="text-muted"></p>
        </div>

    </div>
</div>
