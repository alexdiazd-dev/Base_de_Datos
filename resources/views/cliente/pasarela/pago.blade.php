@extends('layouts.cliente')

@section('titulo', 'Finalizar compra')

@section('contenido')
    <x-franja titulo="Completa Tu Pedido" subtitulo="Selecciona la forma de pago que prefieras" />

    <form action="{{ route('cliente.pasarela.pago.guardar') }}" method="POST">
        @csrf

        <div class="container my-4">
            <div class="row g-4">
                <div class="col-lg-7">

                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown mb-3">Datos de contacto</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="nombre" class="form-control rounded-4 border-0 shadow-sm" placeholder="Nombres Completos *" style="background:#fdfaf6;" value="{{ old('nombre', session('nombre')) }}" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="apellidos" class="form-control rounded-4 border-0 shadow-sm" placeholder="Apellidos Completos *" style="background:#fdfaf6;" value="{{ old('apellidos', session('apellido')) }}" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}" title="Solo se permiten letras y espacios">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="telefono" class="form-control rounded-4 border-0 shadow-sm" placeholder="Teléfono *" style="background:#fdfaf6;" pattern="[0-9]{9}" maxlength="9" value="{{ old('telefono', session('telefono')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="correo" class="form-control rounded-4 border-0 shadow-sm" placeholder="Correo electrónico" style="background:#fdfaf6;" value="{{ old('correo', session('correo')) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown mb-3">Dirección de envío</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <input type="text" name="direccion" class="form-control rounded-4 border-0 shadow-sm" placeholder="Dirección" style="background:#fdfaf6;" value="{{ old('direccion') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="ciudad" class="form-control rounded-4 border-0 shadow-sm" placeholder="Ciudad" style="background:#fdfaf6;" value="{{ old('ciudad') }}" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}"
       title="Solo se permiten letras y espacios (2 a 50 caracteres)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown mb-3">Seleccione método de pago</h5>
                            <div class="d-flex flex-column gap-3">
                                <label class="p-3 rounded-4 border d-flex align-items-center gap-3 shadow-sm option-pay" style="background:#fffaf8;">
                                    <input type="radio" name="metodo" value="Yape" class="form-check-input" required>
                                    <div class="icon-box bg-primary-subtle text-primary"><i class="bi bi-phone"></i></div>
                                    <div>
                                        <span class="fw-semibold text-brown">Yape / Plin</span>
                                        <div class="text-muted small">Pago rápido con QR</div>
                                    </div>
                                </label>

                                <label class="p-3 rounded-4 border d-flex align-items-center gap-3 shadow-sm option-pay" style="background:#fffaf8;">
                                    <input type="radio" name="metodo" value="Tarjeta" class="form-check-input" required>
                                    <div class="icon-box bg-lavender text-brown"><i class="bi bi-credit-card"></i></div>
                                    <div>
                                        <span class="fw-semibold text-brown">Tarjeta (Visa/Mastercard)</span>
                                        <div class="text-muted small">Pagos seguros y cifrados</div>
                                    </div>
                                </label>

                                <label class="p-3 rounded-4 border d-flex align-items-center gap-3 shadow-sm option-pay" style="background:#fffaf8;">
                                    <input type="radio" name="metodo" value="Contra Entrega" class="form-check-input" required>
                                    <div class="icon-box bg-warning-subtle text-brown"><i class="bi bi-cash-stack"></i></div>
                                    <div>
                                        <span class="fw-semibold text-brown">Efectivo (Contraentrega)</span>
                                        <div class="text-muted small">Pagas al recibir</div>
                                    </div>
                                </label>
                            </div>

                            <div id="boxYape" class="d-none mt-4 p-4 rounded-4 border shadow-sm" style="background:#FFF9F9;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                    <h5 class="fw-bold text-brown mb-0">Pago con Yape / Plin</h5>
                                    <span class="badge status-success px-3 py-2">Pago instantáneo</span>
                                </div>
                                <p class="text-muted">Escanea este código QR</p>
                                <div class="text-center mb-3">
                                    <img src="{{ asset('imagenes/qr_pago.jpeg') }}" alt="QR de Yape"
                                         width="200">
                                </div>
                                <p class="fw-bold text-brown fs-5 text-center">
                                    Monto a pagar:
                                    <span class="text-primary">S/ {{ number_format($total, 2) }}</span>
                                </p>
                            </div>

                            <div id="boxTarjeta" class="d-none mt-4 p-4 rounded-4 border shadow-sm" style="background:#FFF9F9;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <h5 class="fw-bold text-brown mb-0">Pago con Tarjeta</h5>
                                    <span class="badge status-primary px-3 py-2">Seguro y cifrado</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Número de Tarjeta</label>
                                    <input type="text"
                                           class="form-control"
                                           name="tarjeta_numero"
                                           minlength="16" maxlength="16"
                                           pattern="[0-9]{16}"
                                           placeholder="1234567890123456">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre en la Tarjeta</label>
                                    <input type="text"
                                           class="form-control"
                                           name="tarjeta_nombre"
                                           placeholder="Juan Perez"
                                           pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$" title="Solo se permiten letras y espacios" required>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Fecha Exp.</label>
                                        <input type="text"
                                            class="form-control"
                                            id="tarjeta_fecha"
                                            name="tarjeta_fecha"
                                            maxlength="5"
                                            placeholder="MM/AA"
                                            pattern="^(0[1-9]|1[0-2])\/[0-9]{2}$"
                                            required>

                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="password"
                                               class="form-control"
                                               name="tarjeta_cvv"
                                               pattern="[0-9]{3}"
                                               maxlength="3"
                                               placeholder="123">
                                    </div>
                                </div>
                                <div class="p-3 rounded-3 text-center fw-bold" style="background:#FBECDC;">
                                    Monto a pagar: <span class="text-primary">S/ {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <div id="boxEfectivo" class="d-none mt-4 p-4 rounded-4 border shadow-sm" style="background:#FFF9F9;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <h5 class="fw-bold text-brown mb-0">Pago en Efectivo</h5>
                                    <span class="badge status-warning px-3 py-2">Contraentrega</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Seleccione billetes</label>
                                    <select class="form-select" name="efectivo_billete">
                                        <option value="">Seleccione...</option>
                                        <option>Billetes de S/ 10</option>
                                        <option>Billetes de S/ 20</option>
                                        <option>Billetes de S/ 50</option>
                                        <option>Billetes de S/ 100</option>
                                        <option>Billetes de S/ 200</option>
                                        <option>Monto exacto</option>
                                    </select>

                                </div>
                                <div class="p-3 rounded-3 text-center fw-bold" style="background:#FBECDC;">
                                    Monto a pagar: <span class="text-primary">S/ {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-lg text-white rounded-pill px-4 shadow-sm w-100" style="background-color:#a89cf3;">
                                    Realizar el pedido
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:90px;">
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown mb-3">Su pedido</h5>
                            <div class="d-flex justify-content-between text-muted small fw-semibold mb-2">
                                <span>Producto</span>
                                <span>Total parcial</span>
                            </div>
                            <div class="border-top pt-2">                      
                                @forelse($carrito as $item)                         
                                    @php
                                        if (!empty($item['imagen_url'])) {
                                            $img = $item['imagen_url'];
                                        } elseif (!empty($item['imagen'])) {
                                            $img = asset('storage/' . $item['imagen']);
                                        } else {
                                            $img = asset('images/sin-imagen.png');
                                        }
                                    @endphp
                                    

                                    <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                        <img src="{{ $img }}" alt="{{ $item['nombre'] }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold text-brown">{{ $item['nombre'] }}</div>
                                            <div class="text-muted small">{{ $item['cantidad'] }} x S/ {{ number_format($item['precio'],2) }}</div>
                                        </div>
                                        <div class="fw-semibold text-brown">S/ {{ number_format($item['precio'] * $item['cantidad'],2) }}</div>
                                    </div>
                                @empty
                                    <p class="text-muted">Tu carrito está vacío.</p>
                                @endforelse
                            </div>
                            <div class="pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold text-brown">S/ {{ number_format($subtotal,2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Delivery</span>
                                    <span class="fw-semibold text-brown">S/ 6.00</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2">
                                    <span class="fw-bold text-brown">Total</span>
                                    <span class="fw-bold text-danger">S/ {{ number_format($total,2) }}</span>
                                </div>
                            </div>

                            <div class="mt-3 small text-muted">
                                <div class="fw-semibold text-brown mb-2">Pago web - <span class="text-muted">Tarjeta / Yape / Contra Entrega</span></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<script>
document.querySelectorAll('input[name="metodo"]').forEach(radio => {
    radio.addEventListener('change', e => {

        document.getElementById('boxYape').classList.add('d-none');
        document.getElementById('boxTarjeta').classList.add('d-none');
        document.getElementById('boxEfectivo').classList.add('d-none');

        if (e.target.value === 'Yape') {
            document.getElementById('boxYape').classList.remove('d-none');
        }
        if (e.target.value === 'Tarjeta') {
            document.getElementById('boxTarjeta').classList.remove('d-none');
        }
        if (e.target.value === 'Contra Entrega') {
            document.getElementById('boxEfectivo').classList.remove('d-none');
        }
    });
});


</script>

<script>
document.getElementById('tarjeta_fecha').addEventListener('input', function(e) {
    let v = e.target.value.replace(/[^0-9]/g, ''); // solo números
    if (v.length >= 3) {
        e.target.value = v.slice(0,2) + '/' + v.slice(2,4);
    } else {
        e.target.value = v;
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const radios = document.querySelectorAll('input[name="metodo"]');
    const boxYape = document.getElementById('boxYape');
    const boxTarjeta = document.getElementById('boxTarjeta');
    const boxEfectivo = document.getElementById('boxEfectivo');

    const camposTarjeta = boxTarjeta.querySelectorAll("input");
    const efectivoSelect = document.querySelector('select[name="efectivo_billete"]');

    // Por defecto desactivar tarjeta + efectivo
    camposTarjeta.forEach(c => c.disabled = true);
    efectivoSelect.required = false;

    radios.forEach(r => {
        r.addEventListener("change", () => {

            // Ocultar todos
            boxYape.classList.add('d-none');
            boxTarjeta.classList.add('d-none');
            boxEfectivo.classList.add('d-none');

            // Desactivar campos tarjeta
            camposTarjeta.forEach(c => c.disabled = true);

            // Desactivar obligatoriedad de efectivo
            efectivoSelect.required = false;

            if (r.value === "Yape") {
                boxYape.classList.remove('d-none');
            }

            if (r.value === "Tarjeta") {
                boxTarjeta.classList.remove('d-none');
                camposTarjeta.forEach(c => c.disabled = false);
            }

            if (r.value === "Contra Entrega") {
                boxEfectivo.classList.remove('d-none');
                efectivoSelect.required = true;   // ← AQUÍ SE HACE OBLIGATORIO
            }
        });
    });

});
</script>



@once
    @push('styles')
        <style>
            .checkout-hero {
                background: linear-gradient(90deg, #e1d7ad, #f7f1dc);
                border-bottom: 1px solid #e2e0d8;
            }
            .option-pay:hover {
                border-color: #d5c8ff;
                background: #fff5fb !important;
            }
            .icon-box {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: grid;
                place-items: center;
                font-size: 1.2rem;
                border: 1px solid #efe8ff;
            }
            .bg-lavender { background: #e8defa; }
            .status-success {background: #e8f6ed; color: #1e8f55; border: 1px solid #c8e7d4;}
            .status-primary {background: #ece7ff; color: #4b3c9c; border: 1px solid #d7cffb;}
            .status-warning {background: #fff6e6; color: #c27c00; border: 1px solid #ffe2b7;}
        </style>
    @endpush
@endonce

@endsection
