<form id="{{ $id ?? '' }}" method="POST" action="{{ $action }}" class="{{ $class ?? '' }}">
    <input name="_method" type="hidden" value="{{ $method ?? 'POST' }}">
    @csrf

    {{ $slot }}
</form>
