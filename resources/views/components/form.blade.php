<form method="{{ $method ?? 'POST' }}" action="{{ $action }}" class="{{ $class ?? '' }}">
    @csrf

    {{ $slot }}
</form>
