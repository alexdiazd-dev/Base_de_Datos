@extends('layouts.cliente')

@section('titulo', 'Nosotros — Pastelería D’Nokali')

@section('franja')
    <x-franja titulo="Pasión por lo Dulce" subtitulo="Conoce más sobre D’Nokali" />
@endsection


@section('contenido')

    
<div class="container my-5">

    {{-- FOTO PRINCIPAL --}}
    <div class="text-center mb-5">
        <img src="https://mae-innovation.com/wp-content/uploads/2023/03/pexels-igor-ovsyannykov-205961.jpg"
             class="img-fluid rounded-4 shadow-sm"
             style="max-height: 420px; object-fit: cover;"
             alt="Equipo D'Nokali">
    </div>

    {{-- TEXTO PRINCIPAL --}}
    <div class="text-center mb-5 px-md-5">
        <h4 class="fw-bold text-brown">
            Preparamos nuestros postres con mucho amor, dedicación y cuidado,
            para que los disfrutes con toda tu familia.
        </h4>

        <p class="text-muted mt-3">
            Somos una pastelería peruana comprometida con convertir momentos familiares
            en únicos y especiales. Elaboramos nuestros postres con ingredientes frescos,
            naturales y recetas perfeccionadas con dedicación y cariño, manteniendo el verdadero
            estilo casero que nos caracteriza.
        </p>
    </div>

    {{-- SECCIONES 3 COLUMNAS --}}
    <div class="row g-4">

        {{-- MISIÓN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <img src="https://img.freepik.com/fotos-premium/familia-feliz-disfruta-comiendo-torta-crespon_42667-24.jpg"
                     class="card-img-top"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="fw-bold text-brown">Nuestra Misión</h5>
                    <p class="text-muted small mb-0">
                        Alegrar cada celebración y momento especial con postres inolvidables
                        que unan familias, amigos y experiencias llenas de dulzura.
                    </p>
                </div>
            </div>
        </div>

        {{-- VISIÓN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <img src="https://perusabroso.net/wp-content/uploads/pasteleria-peruana-tradicional-moderna.webp"
                     class="card-img-top"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="fw-bold text-brown">Nuestra Visión</h5>
                    <p class="text-muted small mb-0">
                        Ser reconocidos como una pastelería referente en calidad, creatividad
                        y servicio, inspirando unión, tradición y excelencia en cada uno
                        de nuestros clientes.
                    </p>
                </div>
            </div>
        </div>

        {{-- PROPÓSITO --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1200&q=80"
                     class="card-img-top"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="fw-bold text-brown">Nuestro Propósito</h5>
                    <p class="text-muted small mb-0">
                        Inspirar a nuestro equipo a alcanzar todo su potencial, promoviendo
                        un ambiente de crecimiento, creatividad y compromiso, para brindar
                        experiencias dulces que superen expectativas.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
