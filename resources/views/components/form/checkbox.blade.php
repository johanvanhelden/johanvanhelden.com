<div class="mb-4">
    <label class="input-checkbox">
        {{ Form::checkbox(
            $name,
            1,
            $value,
            $errors->has($name)
                ? array_merge(['id' => $name, 'class' => 'mr-2 leading-tight'], $attributes)
                : array_merge(['id' => $name, 'class' => 'mr-2 leading-tight'], $attributes)
        ) }}
        <span class="text-sm">
            {{ $label }}
            @if (!empty($required))
                <span class="required" aria-required="true"> * </span>
            @endif
        </span>
    </label>

    @if ($errors->has($name))
    <p class="text-red-500 text-xs italic">{{ $errors->first($name) }}</p>
    @endif

    @if (!empty($text))
    <small class="form-text text-muted">
        {{ $text }}
    </small>
    @endif
</div>
