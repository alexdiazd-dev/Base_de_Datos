@extends('layouts.cliente')

@section('titulo', "Registrase | D'Nokali")

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10 d-flex w-50">
        <!-- Tarjeta Registro -->
        <div class="card p-4 flex-fill">
            <h3 class="mb-4 text-center">Crear cuenta</h3>

            <form action="{{ route('registro.process') }}" method="POST">
@csrf

<div class="row mb-3">
    <div class="col">
        <label class="form-label">Nombre *</label>
        <input type="text"
               name="nombre"
               class="form-control"
               required
               minlength="2"
               maxlength="50"
               pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
               title="Solo letras y espacios"
               value="{{ old('nombre') }}">
    </div>

    <div class="col">
        <label class="form-label">Apellido *</label>
        <input type="text"
               name="apellido"
               class="form-control"
               required
               minlength="2"
               maxlength="50"
               pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
               title="Solo letras y espacios"
               value="{{ old('apellido') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Correo electrónico *</label>
    <input type="email"
           name="correo"
           class="form-control"
           required
           maxlength="100"
           title="Ingresa un correo válido"
           value="{{ old('correo') }}">
</div>

<div class="mb-3">
    <label class="form-label">Número de teléfono *</label>
    <input type="text"
           name="telefono"
           class="form-control"
           required
           minlength="9"
           maxlength="9"
           pattern="[0-9]{9}"
           title="Ingresa un número de 9 dígitos"
           value="{{ old('telefono') }}">
</div>

<div class="mb-3">
    <label class="form-label">Contraseña *</label>
    <input type="password"
           name="contraseña"
           class="form-control"
           required
           minlength="6"
           maxlength="20"
           title="Entre 6 y 20 caracteres">
</div>

<div class="mb-3">
    <label class="form-label">Confirmar contraseña *</label>
    <input type="password"
           name="contraseña_confirmation"
           class="form-control"
           required
           minlength="6"
           maxlength="20"
           title="Debe coincidir con la contraseña">
</div>

<button type="submit" class="btn btn-lavanda w-100 py-2 mt-3">Crear cuenta</button>
</form>




        </div>
      </div>
    </div>
</div>
@endsection

