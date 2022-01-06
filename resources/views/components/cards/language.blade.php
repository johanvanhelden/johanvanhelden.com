<div class="w-full | block | rounded text-base text-center | px-6 py-4 {{ $class ?? '' }}">
    <div
        class="h-24 mb-4 bg-contain bg-no-repeat"
        style="background-position: center center; background-image: url('{{ $imageUrl }}');"
    ></div>

    <div class="
        font-bold text-xl text-center text-secondary mb-2">
        {{ $name }}
    </div>
</div>
