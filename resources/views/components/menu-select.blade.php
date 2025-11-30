@props([
    'label' => null,
    'id' => null,
    'options' => [],
    'selected' => null,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label fw-medium">{{ $label }}</label>
    @endif

    <select id="{{ $id }}"
            name="{{ $attributes->get('name') }}"
            {{ $attributes->merge(['class' => 'form-select rounded-pill menu-select']) }}>
            
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>

@once
    @push('styles')
        <style>
            .menu-select {
                display: block;
                width: 100%;
                padding: .375rem 2.25rem .375rem .75rem;
                font-size: 1rem;
                border-radius: 50px;
                background-color: #fff;
            }
            .menu-select:focus {
                border-color: #fffefe;
                box-shadow: 0 0 0 0.2rem rgba(203, 180, 246, 0.25);
                outline: none;
            }
            .menu-select option {
                background-color: #fffefe;
                color: #000000;
            }
        </style>
    @endpush
@endonce
