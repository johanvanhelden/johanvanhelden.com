<div class="mb-4">
    <label class="input-checkbox">
        <input
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            type="checkbox"
            class="mr-2 leading-tight"
            value="1"
            {{ ($checked ?? false) ? 'checked' : '' }}
        >

        @if ($label ?? null)
            <span class="text-sm">
                {{ $label }}
                @if (!empty($required))
                    <span class="required" aria-required="true"> * </span>
                @endif
            </span>
        @endif
    </label>

    @include('components.forms.shared.invalid-feedback')

    @include('components.forms.shared.help-text')
</div>
