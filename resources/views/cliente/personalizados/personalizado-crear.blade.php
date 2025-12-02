@extends('layouts.cliente')

@section('titulo', "Nueva Solicitud de Producto Personalizado")

@php
    // Recuperar datos del formulario de la sesión si existen
    $formData = session('form_personalizado', []);
@endphp

@section('barra_navegacion')
    <x-nav-cliente active="personalizados" />
@endsection

@section('contenido')
<div class="container my-5">

    <div class="p-4 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(120deg, #f7e8ff, #fdeedf);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-semibold text-brown mb-1">Crear Producto Personalizado</h3>
                <p class="text-muted mb-0">Diseña tu producto perfecto con nuestros expertos pasteleros</p>
            </div>

            <a href="{{ route('cliente.personalizados') }}" 
               class="btn btn-outline-secondary rounded-pill px-4 shadow-sm"
               style="border-color:#cbb4f6;color:#4b3c3a;">
                <i class="bi bi-arrow-left me-2"></i> Volver
            </a>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body px-4 py-5" style="background: #fffaf8;">

                    <h5 class="fw-semibold mb-3 text-brown">Nueva Solicitud de Producto Personalizado</h5>
                    <p class="text-muted mb-4">Describe tu producto ideal y nuestros pasteleros te ayudarán a crearlo</p>

                    <form id="form-personalizado" method="POST" action="{{ route('cliente.personalizados.guardar') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-brown">Descripción del Producto *</label>
                            <textarea
                                name="descripcion"
                                class="form-control rounded-4 border-0 shadow-sm @error('descripcion') is-invalid @enderror"
                                rows="3"
                                required
                                placeholder="Describe detalladamente cómo quieres tu producto personalizado..."
                                style="background-color:#fdf8f4;"
                            >{{ old('descripcion', $formData['descripcion'] ?? '') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-brown">Tamaño *</label>
                                <select
                                    name="tamano"
                                    class="form-select rounded-4 border-0 shadow-sm @error('tamano') is-invalid @enderror"
                                    required
                                    style="background-color:#fdf8f4;"
                                >
                                    <option value="">Selecciona el tamaño</option>
                                    <option value="Pequeño (15cm)" {{ old('tamano', $formData['tamano'] ?? '') == 'Pequeño (15cm)' ? 'selected' : '' }}>Pequeño (15cm)</option>
                                    <option value="Mediano (20cm)" {{ old('tamano', $formData['tamano'] ?? '') == 'Mediano (20cm)' ? 'selected' : '' }}>Mediano (20cm)</option>
                                    <option value="Grande (3 pisos)" {{ old('tamano', $formData['tamano'] ?? '') == 'Grande (3 pisos)' ? 'selected' : '' }}>Grande (3 pisos)</option>
                                </select>
                                @error('tamano')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-brown">Sabor *</label>
                                <select
                                    name="sabor"
                                    class="form-select rounded-4 border-0 shadow-sm @error('sabor') is-invalid @enderror"
                                    required
                                    style="background-color:#fdf8f4;"
                                >
                                    <option value="">Selecciona el sabor</option>
                                    @foreach(['Vainilla','Chocolate','Red Velvet','Fresa','Combinado'] as $sabor)
                                        <option value="{{ $sabor }}" {{ old('sabor', $formData['sabor'] ?? '') == $sabor ? 'selected' : '' }}>{{ $sabor }}</option>
                                    @endforeach
                                </select>
                                @error('sabor')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-4 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-brown">Ocasión</label>
                                <select
                                    name="ocasion"
                                    class="form-select rounded-4 border-0 shadow-sm @error('ocasion') is-invalid @enderror"
                                    style="background-color:#fdf8f4;"
                                >
                                    <option value="">Selecciona la ocasión</option>
                                    @foreach(['Cumpleaños','Boda','Aniversario','Corporativo','Otro'] as $oc)
                                        <option value="{{ $oc }}" {{ old('ocasion', $formData['ocasion'] ?? '') == $oc ? 'selected' : '' }}>{{ $oc }}</option>
                                    @endforeach
                                </select>
                                @error('ocasion')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label fw-semibold text-brown">Imagen de Referencia</label>
                            <div class="input-group rounded-4 shadow-sm" style="background-color:#fdf8f4;">
                                <span class="input-group-text border-0" style="background-color:#fdf8f4;">
                                    <i class="bi bi-upload"></i>
                                </span>
                                <input
                                    type="file"
                                    name="imagen_referencia"
                                    class="form-control border-0 @error('imagen_referencia') is-invalid @enderror"
                                    accept="image/*"
                                >
                            </div>
                            @error('imagen_referencia')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opcional: Sube una imagen para inspirar tu diseño.</small>
                        </div>

                        <div class="mt-4">
                            <label class="form-label fw-semibold text-brown">Notas Adicionales</label>
                            <textarea
                                name="notas_adicionales"
                                class="form-control rounded-4 border-0 shadow-sm @error('notas_adicionales') is-invalid @enderror"
                                rows="3"
                                placeholder="Alergias, preferencias especiales, detalles importantes..."
                                style="background-color:#fdf8f4;"
                            >{{ old('notas_adicionales', $formData['notas_adicionales'] ?? '') }}</textarea>
                            @error('notas_adicionales')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4 gap-3">
                            <button type="button" id="btn-generar-ia" class="btn rounded-pill px-4 py-2 shadow-sm text-white"
                                    style="background: linear-gradient(135deg, #9b7bdb, #c8a5f0);">
                                <i class="bi bi-stars me-2"></i><span id="btn-ia-text">Generar Imagen IA</span>
                            </button>
                            <button type="submit" class="btn btn-lavanda rounded-pill px-4 py-2 text-white">
                                Enviar Solicitud
                            </button>
                            <a href="{{ route('cliente.personalizados') }}" 
                               class="btn rounded-pill px-4 py-2 shadow-sm"
                               style="background-color:#f8e8db;color:#4b3c3a;font-weight:500;">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 b-apartado">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Bloque B - Complemento visual</p>
                            <h5 class="fw-semibold text-brown mb-0">Vista previa dinámica</h5>
                        </div>
                        <span class="badge text-bg-light border">Solo visual</span>
                    </div>

                    <div class="b-preview mb-4">
                        <div class="cake-preview size-medium">
                            <div class="cake-shadow"></div>
                            <div class="cake-tier tier-bottom"></div>
                            <div class="cake-tier tier-middle"></div>
                            <div class="cake-tier tier-top"></div>
                            <div class="cake-plate"></div>
                        </div>
                    </div>

                    <div class="b-resumen card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold text-brown mb-3">Resumen visual</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li class="d-flex justify-content-between mb-2"><span class="text-muted">Sabor</span><span class="fw-semibold" id="resumen-sabor">-</span></li>
                                <li class="d-flex justify-content-between mb-2"><span class="text-muted">Tamaño</span><span class="fw-semibold" id="resumen-tamano">-</span></li>
                                <li class="d-flex justify-content-between mb-2"><span class="text-muted">Ocasión</span><span class="fw-semibold" id="resumen-ocasion">-</span></li>
                                <li class="d-flex justify-content-between mt-2 pt-2 border-top"><span class="text-muted">Precio estimado</span><span class="fw-semibold" id="resumen-precio">S/ 0.00</span></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Contenedor para imagen generada con IA --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-4">
                        <div class="card-body p-4" style="background: linear-gradient(135deg, #f9f5ff, #fff8f5);">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="fw-semibold text-brown mb-1">
                                        <i class="bi bi-stars me-2" style="color: #9b7bdb;"></i>Vista generada con IA
                                    </h6>
                                    <small class="text-muted">Visualización con inteligencia artificial</small>
                                </div>
                                <span class="badge text-bg-light border">Próximamente</span>
                            </div>

                            {{-- Placeholder inicial --}}
                            <div id="ai-placeholder" class="text-center py-4" style="background-color: #ffffff; border-radius: 1rem; border: 2px dashed #e5d9f2;">
                                <img src="{{ asset('imagenes/nokalito.jpeg') }}" alt="Nokalito - Asistente IA" class="img-fluid rounded-4 shadow-sm" style="max-height: 300px; object-fit: cover; opacity: 0.85;">
                                <p class="text-muted mt-3 mb-0">Aún no has generado ninguna imagen.</p>
                                <small class="text-muted">Haz clic en "Generar Imagen IA" para crear una vista previa</small>
                            </div>

                            {{-- Estado de carga --}}
                            <div id="ai-loading" class="d-none text-center py-5" style="background-color: #ffffff; border-radius: 1rem; border: 2px solid #e5d9f2;">
                                <div class="spinner-border text-primary mb-3" role="status" style="color: #9b7bdb !important;">
                                    <span class="visually-hidden">Generando...</span>
                                </div>
                                <p class="text-muted mb-0 fw-semibold">Generando imagen con IA...</p>
                                <small class="text-muted">Esto puede tomar unos segundos</small>
                            </div>

                            {{-- Contenedor para la imagen generada (oculto inicialmente) --}}
                            <div id="ai-image-container" class="d-none">
                                <img id="ai-generated-image" src="" alt="Imagen generada por IA" class="img-fluid rounded-4 shadow-sm" style="max-height: 400px; object-fit: cover;">
                                <p class="text-center text-muted mt-2 mb-0 small">
                                    <i class="bi bi-stars" style="color: #9b7bdb;"></i> Imagen generada con IA (demo)
                                </p>
                            </div>

                            {{-- Mensaje de error --}}
                            <div id="ai-error" class="d-none text-center py-5" style="background-color: #fff5f5; border-radius: 1rem; border: 2px dashed #f8d7da;">
                                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem; opacity: 0.5;"></i>
                                <p class="text-danger mt-3 mb-0 fw-semibold">No se pudo generar la imagen</p>
                                <small class="text-muted">Por favor, intenta nuevamente</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-personalizado');
    const preview = document.querySelector('.cake-preview');
    if (!form || !preview) return;

    const resumen = {
        sabor: document.getElementById('resumen-sabor'),
        tamano: document.getElementById('resumen-tamano'),
        ocasion: document.getElementById('resumen-ocasion'),
        precio: document.getElementById('resumen-precio'),
    };

    const colorMap = {
        'Vainilla': '#f6d6a4',
        'Chocolate': '#8b5a2b',
        'Red Velvet': '#b03030',
        'Fresa': '#f3a1c1',
        'Combinado': 'linear-gradient(135deg, #f6d6a4 0%, #f6d6a4 45%, #f3a1c1 55%, #f3a1c1 100%)',
        'default': '#f7d9d0',
    };

    function setSize(sizeValue) {
        preview.classList.remove('size-small','size-medium','size-large');
        const match = (sizeValue || '').toLowerCase();
        if (match.includes('peque')) {
            preview.classList.add('size-small');
        } else if (match.includes('mediano')) {
            preview.classList.add('size-medium');
        } else if (match.includes('grande')) {
            preview.classList.add('size-large');
        } else {
            preview.classList.add('size-medium');
        }
    }

    function setColor(flavorValue) {
        const flavor = flavorValue || 'default';
        const tono = colorMap[flavor] || colorMap.default;
        preview.style.setProperty('--cake-fill', tono);
        if (flavor === 'Combinado') {
            preview.classList.add('multi');
        } else {
            preview.classList.remove('multi');
        }
    }

    function updateSummary() {
        resumen.sabor.textContent = form.sabor?.value || '—';
        resumen.tamano.textContent = form.tamano?.value || '—';
        resumen.ocasion.textContent = form.ocasion?.value || '—';
    }

    function calcularPrecio() {
        const preciosTamano = {
            'Pequeño (15cm)': 35,
            'Mediano (20cm)': 55,
            'Grande (3 pisos)': 120,
        };
        const preciosSabor = {
            'Vainilla': 0,
            'Chocolate': 5,
            'Red Velvet': 10,
            'Fresa': 5,
            'Combinado': 12,
        };
        const preciosOcasion = {
            'Cumpleaños': 0,
            'Boda': 25,
            'Aniversario': 10,
            'Corporativo': 15,
            'Otro': 5,
        };

        const base = preciosTamano[form.tamano?.value] ?? 0;
        const sabor = preciosSabor[form.sabor?.value] ?? 0;
        const oc = preciosOcasion[form.ocasion?.value] ?? 0;
        return base + sabor + oc;
    }

    function updatePrecio() {
        const total = calcularPrecio();
        resumen.precio.textContent = `S/ ${total.toFixed(2)}`;
    }

    function updatePreview() {
        setSize(form.tamano?.value || '');
        setColor(form.sabor?.value || '');
        updateSummary();
        updatePrecio();
    }

    ['sabor','tamano','ocasion'].forEach(name => {
        const field = form[name];
        if (field) {
            field.addEventListener('input', updatePreview);
            field.addEventListener('change', updatePreview);
        }
    });

    updatePreview();

    // ===================================================
    // FUNCIONALIDAD GENERAR IMAGEN IA
    // ===================================================
    const btnGenerarIA = document.getElementById('btn-generar-ia');
    const btnIAText = document.getElementById('btn-ia-text');
    const aiPlaceholder = document.getElementById('ai-placeholder');
    const aiLoading = document.getElementById('ai-loading');
    const aiImageContainer = document.getElementById('ai-image-container');
    const aiGeneratedImage = document.getElementById('ai-generated-image');
    const aiError = document.getElementById('ai-error');

    if (btnGenerarIA) {
        btnGenerarIA.addEventListener('click', async function() {
            // Validar que los campos requeridos estén llenos
            const descripcion = form.descripcion?.value.trim();
            const tamano = form.tamano?.value;
            const sabor = form.sabor?.value;

            if (!descripcion || !tamano || !sabor) {
                alert('Por favor, completa al menos la descripción, tamaño y sabor antes de generar la imagen.');
                return;
            }

            // Deshabilitar botón y mostrar estado de carga
            btnGenerarIA.disabled = true;
            btnIAText.textContent = 'Generando...';

            // Ocultar todos los estados
            aiPlaceholder?.classList.add('d-none');
            aiImageContainer?.classList.add('d-none');
            aiError?.classList.add('d-none');

            // Mostrar loading
            aiLoading?.classList.remove('d-none');

            try {
                // Preparar datos del formulario
                const formData = new FormData();
                formData.append('descripcion', descripcion);
                formData.append('tamano', tamano);
                formData.append('sabor', sabor);
                formData.append('ocasion', form.ocasion?.value || '');
                formData.append('notas_adicionales', form.notas_adicionales?.value || '');

                // Agregar imagen de referencia si el usuario la subió
                const imagenReferenciaInput = form.querySelector('input[name="imagen_referencia"]');
                if (imagenReferenciaInput && imagenReferenciaInput.files && imagenReferenciaInput.files[0]) {
                    formData.append('imagen_referencia', imagenReferenciaInput.files[0]);
                    console.log('Imagen de referencia incluida:', imagenReferenciaInput.files[0].name);
                } else {
                    console.log('No se seleccionó imagen de referencia');
                }

                // Enviar petición al backend
                // IMPORTANTE: No incluir Content-Type header cuando se usa FormData
                // El navegador lo configura automáticamente como multipart/form-data
                const response = await fetch('{{ route('cliente.personalizado.generarIA') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                        // NO incluir 'Content-Type' - FormData lo maneja automáticamente
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.status === 'ok') {
                    // Ocultar loading
                    aiLoading?.classList.add('d-none');

                    // Mostrar imagen generada por IA
                    if (data.image_url) {
                        aiGeneratedImage.src = data.image_url;
                        aiImageContainer?.classList.remove('d-none');
                        
                        // Actualizar texto del label según si se usó imagen de referencia
                        const aiLabel = aiImageContainer.querySelector('p');
                        if (aiLabel) {
                            const labelTexto = data.uso_imagen_referencia 
                                ? '<i class="bi bi-stars" style="color: #9b7bdb;"></i> Imagen generada con IA + imagen de referencia'
                                : '<i class="bi bi-stars" style="color: #9b7bdb;"></i> Imagen generada con IA';
                            aiLabel.innerHTML = labelTexto;
                        }

                        console.log('Imagen generada exitosamente:', {
                            url: data.image_url,
                            uso_referencia: data.uso_imagen_referencia,
                            prompt: data.prompt_usado
                        });
                    } else {
                        throw new Error('No se recibió URL de imagen');
                    }
                } else {
                    throw new Error(data.message || 'Error en la respuesta del servidor');
                }

            } catch (error) {
                console.error('Error al generar imagen:', error);
                
                // Ocultar loading
                aiLoading?.classList.add('d-none');
                
                // Mostrar error
                aiError?.classList.remove('d-none');
            } finally {
                // Rehabilitar botón
                btnGenerarIA.disabled = false;
                btnIAText.textContent = 'Generar Imagen IA';
            }
        });
    }
});
</script>
@endpush
