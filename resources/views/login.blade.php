@extends('layouts.cliente')

@section('titulo', "Iniciar sesión | D'Nokali")

@push('styles')
    <style>
        .btn-google{
            border-color: #191b1eff;
            color: #2b2f37ff;
        }
        .btn-google:hover{
            background-color: #191b1eff;
            color: #2b2f37ff;
        }
    </style>
@endpush

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10 d-flex justify-content-between gap-4">
        <!-- Tarjeta Iniciar sesión -->
        <div class="card p-4 flex-fill w-50">
          <h3 class="mb-4">Iniciar sesión</h3>
          <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Correo electrónico *</label>
              <input type="email" name="correo" class="form-control" placeholder="Ej. nombre@mail.com" required value="{{ old('correo') }}">
              @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Contraseña *</label>
              <input type="password" name="contraseña" class="form-control" placeholder="Aa12345" required>
              @error('contraseña') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-lavanda w-100 py-2 mt-3">Iniciar sesión</button>
            </form>

            <div class="text-center my-3 text-muted">
              — o continúa con —
            </div>

            <button class="btn btn-google w-100 rounded-pill d-flex align-items-center justify-content-center">
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" width="20" class="me-2">
              Continuar con Google
            </button>
          </form>
        </div>

        <!-- Tarjeta Crear cuenta -->
        <div class="card p-4 flex-fill w-50">
          <h3 class="mb-4">Crear cuenta</h3>

          <div class="p-3 bg-light rounded-3">
            <p class="fw-semibold mb-2">Crea una y aprovecha los beneficios:</p>
            <ul class="small text-muted mb-4">
              <li>🛒 Realiza tus compras de manera más ágil y sin tener que llenar tus datos cada vez.</li>
              <li>📦 Haz seguimiento a tus pedidos y consulta fácilmente tus compras anteriores.</li>
              <li>🎨 Solicita productos personalizados con mayor facilidad, adaptados a tus gustos y ocasiones especiales.</li>
              <li>💬 Disfruta de una atención más cercana y personalizada si surge alguna consulta.</li>
            </ul>
          </div>

          <a class="btn btn-lavanda rounded-pill w-100 mt-4 py-2" href="{{route('registro')}}">Crear cuenta</a>
        </div>
      </div>
    </div>
  </div>
@endsection
