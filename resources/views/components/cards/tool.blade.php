<a
    class="
        w-full | block | rounded text-base text-center | px-6 py-4
        @if ($url ?? null)
            link link--primary hover:bg-gray-100
        @else
            hover:cursor-default
        @endif
        {{ $class ?? '' }}
    "
    @if ($url ?? null)
        href="{{ $url }}"
        target="_blank"
        rel="noopener noreferrer"
    @endif
>
    <div
        class="h-24 mb-4 bg-contain bg-no-repeat"
        style="background-position: center center; background-image: url('{{ $imageUrl }}');"
    ></div>
    <div class="
        font-bold text-xl text-center
        @if ($url ?? null)
            text-primary
        @else
            text-secondary
        @endif
        mb-2
    ">
        {{ $name }}
    </div>
</a>
