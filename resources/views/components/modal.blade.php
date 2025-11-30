@props([
    'id',
    'title' => '',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-elegante">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .modal-elegante {
                background-color: #f9ede5; /* tono beige pastel */
                border-radius: 20px;
                border: none;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                color: #4b3c3a;
                font-family: "Poppins", sans-serif;
            }

            .modal-elegante .modal-header {
                background-color: transparent;
                color: #4b3c3a;
            }

            .modal-elegante .modal-body input,
            .modal-elegante .modal-body select,
            .modal-elegante .modal-body textarea {
                border-radius: 10px;
                border: 1px solid #e0d4cc;
                padding: 8px 12px;
                font-size: 0.95rem;
            }

            .modal-elegante .modal-body input:focus,
            .modal-elegante .modal-body select:focus,
            .modal-elegante .modal-body textarea:focus {
                border-color: #cbb4f6;
                box-shadow: 0 0 0 0.2rem rgba(203, 180, 246, 0.25);
            }

            .modal-elegante .btn-close {
                filter: invert(0.5);
            }
        </style>
    @endpush
@endonce
