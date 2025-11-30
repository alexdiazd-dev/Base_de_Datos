@extends('layouts.cliente')

@section('titulo', "Inicio")

@push('styles')
<style>
    .edge-to-edge {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }
    .home-main {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
</style>
@endpush
@section('main_class', 'home-main')

@section('contenido')
    @php
        $categoriaBodas = $categorias->firstWhere('nombre', 'Bodas');
        $linkBodas = $categoriaBodas ? route('cliente.catalogo', ['categoria' => $categoriaBodas->id_categoria]) : route('cliente.catalogo');
    @endphp
    <div class="edge-to-edge px-0 mb-5">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="http://127.0.0.1:8000/cliente/catalogo?buscar=Torta+de+bodas" class="d-block">
                        <img 
                            src="{{ asset('imagenes/boda-carrusel.png') }}" 
                            alt="Categoria Bodas" 
                            class="w-100" 
                            style="display:block;object-fit:cover;width:100%;height:70vh;" 
                            loading="lazy" 
                            decoding="async">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="{{ route('cliente.catalogo') }}" class="d-block">
                        <img 
                            src="{{ asset('imagenes/catálogo.jpg') }}" 
                            alt="Catálogo" 
                            class="w-100" 
                            style="display:block;object-fit:cover;width:100%;height:70vh;" 
                            loading="lazy" 
                            decoding="async">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="{{ route('cliente.personalizados.nueva') }}" class="d-block">
                        <img 
                            src="{{ asset('imagenes/personalizados_carrusel.jpg') }}" 
                            alt="Personalizados" 
                            class="w-100" 
                            style="display:block;object-fit:cover;width:100%;height:70vh;" 
                            loading="lazy" 
                            decoding="async">
                    </a>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>

    <div class="container my-4">
        <h3 class="fw-semibold text-center mb-4">Explora por ocasión</h3>
        <div class="row g-4">
            @foreach($categorias->take(3) as $cat)
            @php
                $categoryImages = [
                    'Tortas' => 'imagenes/tortas_filtro.jpg',
                    'Cupcakes' => 'imagenes/cupcakes_filtro.jpg',
                    'Galletas' => 'imagenes/galletas_filtro.jpg',
                ];
                $imgSrc = $categoryImages[$cat->nombre] ?? 'imagenes/categorias/default.jpg';
            @endphp
            <div class="col-md-4">
                <a href="{{ route('cliente.catalogo', ['categoria' => $cat->id_categoria]) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset($imgSrc) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $cat->nombre }}">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown mb-1">{{ $cat->nombre }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-5">
            <h3 class="fw-semibold text-center mb-4">Nuestros servicios, a tu medida</h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <img src="https://effimer.com/blog/wp-content/uploads/2022/02/consejos-organizar-catering-exitoso_Mesa-de-trabajo-1-1080x675.jpg" class="w-100 h-100" style="object-fit:cover;" alt="Catering">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown">Catering</h5>
                            <p class="text-muted mb-3">Celebra cada momento con mesas dulces y tortas a medida.</p>
                            <a href="{{ route('cliente.catalogo') }}" class="btn btn-lavanda rounded-pill px-4 text-white">Visualiza nuestro catálogo</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('imagenes/personalizados.jpg') }}" class="w-100 h-100" style="object-fit:cover;" alt="Personalizados">
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold text-brown">Pedidos Personalizados</h5>
                            <p class="text-muted mb-3">Sorprende a tu equipo con detalles personalizados para cada ocasión.</p>
                            <a href="{{ route('cliente.personalizados.nueva') }}" class="btn btn-lavanda rounded-pill px-4 text-white">Coordina tu pedido</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

