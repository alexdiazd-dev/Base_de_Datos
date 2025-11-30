@props([ 
    'id' => null,
    'imagen' => 'default.jpg',
    'nombre' => 'Nombre del producto',
    'descripcion' => 'Descripción del producto',
    'precio' => 0.00,
    'ver' => '#',
    'categoria' => 'Repostería'
])

<div {{ $attributes->merge(['class' => 'card shadow-sm border-0 rounded-4 overflow-hidden product-card h-100 d-flex flex-column w-100']) }}>

    <div class="position-relative">
        <img 
            src="{{ asset('storage/' . $imagen) }}" 
            class="card-img-top" 
            alt="{{ $nombre }}" 
            style="height: 210px; object-fit: cover;"
        >
    </div>

    <div class="card-body pb-2">

        {{-- NOMBRE + PRECIO EN UNA SOLA LÍNEA --}}
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 class="card-title fw-semibold text-brown mb-0" 
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 70%;">
                {{ $nombre }}
            </h5>

            <span class="badge rounded-pill px-3 py-2"
                  style="background:#f7f1fd; color:#6b4c3b; font-weight:600;">
                S/ {{ number_format($precio, 2) }}
            </span>
        </div>


        
    </div>

    {{-- FOOTER: BOTONES MEJORADOS --}}
    <div class="card-footer bg-white border-0 d-flex align-items-center gap-2 pb-3 px-3 mt-auto">

        {{-- VER DETALLES - BOTÓN SECUNDARIO --}}
        <button 
            type="button"
            class="btn btn-ver-detalle flex-grow-1 fw-semibold text-brown border-0 shadow-sm"
            data-id="{{ $id }}"
            data-nombre="{{ $nombre }}"
            data-descripcion="{{ $descripcion }}"
            data-precio="{{ $precio }}"
            data-imagen="{{ asset('storage/' . $imagen) }}"
            data-categoria="{{ $categoria }}"
            data-ver="{{ $ver }}"
            style="background: #f7f1fd; border-radius: 16px; padding: 10px 16px; font-size: 0.9rem; transition: all 0.3s ease;"
            onmouseover="this.style.boxShadow='0 4px 12px #b794f44d'; this.style.transform='translateY(-1px)';"
            onmouseout="this.style.boxShadow='0 2px 6px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';"
        >
            <i class="bi bi-eye me-1"></i> Ver detalles
        </button>

        <div class="d-flex align-items-center gap-2">

            <div class="qty-bubble d-none" data-product-id="{{ $id }}">
                <button class="btn icon-btn btn-card-remove" data-id="{{ $id }}">
                    <i class="bi bi-trash"></i>
                </button>
                <button class="btn icon-btn btn-card-minus" data-id="{{ $id }}">
                    <i class="bi bi-dash"></i>
                </button>
                <span class="qty-number" id="qty-card-{{ $id }}">1</span>
                <button class="btn icon-btn btn-card-plus" data-id="{{ $id }}">
                    <i class="bi bi-plus"></i>
                </button>
            </div>

            {{-- AGREGAR AL CARRITO - BOTÓN PRINCIPAL --}}
            <button 
                type="button"
                class="btn btn-agregar-carrito fw-semibold text-white border-0 shadow-sm"
                data-id="{{ $id }}"
                data-nombre="{{ $nombre }}"
                data-precio="{{ $precio }}"
                data-imagen="{{ $imagen }}"
                style="background: linear-gradient(135deg, #a89cf3 0%, #a89cf3 100%); border-radius: 16px; padding: 10px 20px; font-size: 0.9rem; transition: all 0.3s ease;"
                onmouseover="this.style.boxShadow='0 6px 16px #8c7bd8'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.boxShadow='0 2px 6px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';"
            >
                <i class="bi bi-bag-heart me-1"></i> Agregar
            </button>
        </div>
    </div>

</div>
