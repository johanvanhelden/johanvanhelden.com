<a
    class="
        rounded overflow-hidden shadow-lg border-primary border-t-4 bg-white text-base | px-6 py-4
        @if ($url ?? null)
            hover:cursor-pointer hover:bg-gray-100
        @endif

        {{ $class ?? '' }}
    "
    @isset ($url)
        href="{{ $url }}"
    @else
        href="#"
    @endisset
>
    <div class="flex items-center mb-2">
        <span
            v-if="title"
            class="font-bold text-xl | mr-2
            @isset ($url)
                font-semibold text-primary hover:underline
            @endisset"
        >
            {{ $title }}
        </span>

        @if ($updated)
            <x-badge text="Updated" class="ml-auto" />
        @endif
    </div>
    <p
        v-if="text"
        class="text-gray-700 text-base"
    >
        {{ $text }}
    </p>
</a>
