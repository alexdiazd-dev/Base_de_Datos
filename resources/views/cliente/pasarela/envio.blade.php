@extends('layouts.cliente')

@section('contenido')
    <x-franja titulo="Completa Tu Pedido" subtitulo="Ingresa la información de entrega" />

<div class="card-pasarela">

    <h4 class="fw-bold text-brown mb-3">Datos de Envío</h4>
    <p class="text-muted mb-4">Ingresa la información necesaria para procesar tu entrega</p>

    {{-- IMPORTANTE: ahora es POST y apunta a guardarEnvio --}}
    <form action="{{ route('cliente.pasarela.envio.guardar') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Nombres</label>

            <input type="text"
                   name="nombre"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   value="{{ session('nombre') }}"
                   required
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                   title="Solo se permiten letras"
                   placeholder="Ej. Ana">
        </div>

        {{-- Apellido --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Apellidos</label>

            <input type="text"
                   name="apellido"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   value="{{ session('apellido') }}"
                   required
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                   title="Solo se permiten letras"
                   placeholder="Ej. López">
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Email</label>

            <input type="email"
                   name="correo"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   value="{{ session('correo') }}"
                   required
                   placeholder="ejemplo@correo.com">
        </div>

        {{-- Teléfono --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Teléfono</label>

            <input type="text"
                   name="telefono"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   value="{{ session('telefono') }}"
                   required
                   pattern="[0-9]{9}"
                   maxlength="9"
                   title="Debe contener 9 dígitos numéricos"
                   placeholder="Ej. 987654321">
        </div>

        {{-- Dirección --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Dirección</label>

            <input type="text"
                   name="direccion"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   required
                   placeholder="Ej. Av. Siempre Viva 742">
        </div>

        {{-- Ciudad --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Ciudad</label>

            <input type="text"
                   name="ciudad"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   required
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                   title="Solo se permiten letras"
                   placeholder="Ej. Lima">
        </div>

        {{-- Departamento --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Departamento</label>

            <input type="text"
                   name="departamento"
                   class="form-control rounded-4 border-0"
                   style="background-color:#F7ECE4;"
                   required
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                   title="Solo se permiten letras"
                   placeholder="Ej. Lima">
        </div>

        {{-- Notas --}}
        <div class="mb-3">
            <label class="form-label fw-semibold" style="color:#4b2307;">Notas de entrega (Opcional)</label>

            <textarea name="notas"
                      class="form-control rounded-4 border-0"
                      style="background-color:#F7ECE4;"
                      rows="2"
                      placeholder="Ej. Tocar el timbre, dejar con el portero..."></textarea>
        </div>

        {{-- Botón continuar --}}
        <div class="mt-4 text-end">
            <button class="btn btn-lg text-white rounded-pill px-4"
                    style="background-color:#A89CF3;">
                Continuar a método de pago
            </button>
        </div>

    </form>

</div>

@endsection
