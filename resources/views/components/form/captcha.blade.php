<div class="mb-4">
    {!! NoCaptcha::display() !!}

    @if ($errors->has('g-recaptcha-response'))
        <div class="invalid-feedback d-block">
            {{ $errors->first('g-recaptcha-response') }}
        </div>
    @endif

    @if (!empty($text))
        <small class="form-text text-muted">
            {{ $text }}
        </small>
    @endif
</div>
