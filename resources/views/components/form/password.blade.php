<div class="mb-4">
    <label for="{{ $name }}" class="input-label">
        {{ $label }}
        @if (!empty($required))
            <span class="required" aria-required="true"> * </span>
        @endif
    </label>
    {{ Form::password(
        $name,
        $errors->has($name)
        ? array_merge(['class' => 'input input--error'], $attributes)
        : array_merge(['class' => 'input'], $attributes)
    ) }}
    @if ($errors->has($name))
        <p class="text-red-500 text-xs italic">{{ $errors->first($name) }}</p>
    @endif

    @if (!empty($text))
        <small class="form-text text-muted">
            {{ $text }}
        </small>
    @endif
</div>
