<div class="mb-4">
    @if($label ?? null)
        <label for="{{ $name }}" class="input-label">
            {{ $label }}
            @if (!empty($required))
                <span class="required" aria-required="true"> * </span>
            @endif
        </label>
    @endif

    <input
        autocomplete="off"
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text'}}"
        value="{{ old($name, $value ?? '') }}"
        class="input @error($name) input--error @enderror"
        placeholder="{{ $placeholder ?? '' }}"
        {{ ($required ?? false) ? 'required' : '' }}
    >

    @include('components.forms.shared.invalid-feedback')

    @include('components.forms.shared.help-text')
</div>
