<div class="modal fade" id="modalDetalleProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4" style="background: #f9ede5;">
            
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-start p-4 pb-2">
                <div>
                    <h5 id="mdp_titulo" class="fw-semibold text-brown m-0">Producto</h5>
                    <small class="text-muted">Detalles completos del producto</small>
                </div>
                <button type="button" class="btn btn-light rounded-circle" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4 pt-2">

                <div class="row g-4">
                    <!-- IMAGEN -->
                    <div class="col-md-5">
                        <img id="mdp_imagen" src="" alt="" class="w-100 rounded-4 shadow-sm"
                             style="object-fit: cover; height: 260px;">
                    </div>

                    <!-- INFORMACIÓN -->
                    <div class="col-md-7">

                        <!-- PRECIO -->
                        <div class="h3 fw-bold text-brown mb-3">
                            S/ <span id="mdp_precio">0.00</span>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <h6 class="fw-semibold text-brown">Descripción</h6>
                        <p id="mdp_descripcion" class="text-muted"></p>

                        <!-- CATEGORÍA -->
                        <h6 class="fw-semibold text-brown mt-3">Categoría</h6>
                        <span id="mdp_categoria"
                              class="badge rounded-pill px-3 py-2"
                              style="background: #d3c3f7; color: #4b3c3a;">
                              categoria
                        </span>

                        <!-- ETIQUETAS -->
                        <h6 class="fw-semibold text-brown mt-3">Etiquetas</h6>
                        <div id="mdp_etiquetas" class="d-flex flex-wrap gap-2">
                            <!-- Etiquetas se insertan por JS -->
                        </div>

                        <!-- BOTÓN AGREGAR -->
                        <div class="mt-4">
                            <button id="mdp_btnAgregar"
                                    class="btn btn-lavanda rounded-pill px-4 py-2 d-flex align-items-center gap-2">
                                <i class="bi bi-cart-plus"></i>
                                Agregar al Carrito
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
