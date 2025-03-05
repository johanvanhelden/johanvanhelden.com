<div
    id="header"
    class="
        relative text-lg bg-black bg-cover bg-no-repeat bg-center lg:bg-[center_top]
        @if (!$expandedHeader) h-64 @endif
    "
    style="background-image: url('{{ Vite::asset('resources/img/header-narrow.jpg') }}');"
>
    <div class="max-w-6xl mx-auto text-white py-6">
        <div class="sm:flex text-center px-6">
            <div class="sm:flex-1 text-2xl font-bold text-left">
                <a href="{{ route('page.home') }}">Johan van Helden</a>
            </div>
        </div>

        @if ($expandedHeader)
            <div class="sm:max-w-lg mx-auto text-shadow-lg font-semibold | px-6 my-4 py-4 md:my-20 md:py-20">
                <div class="text-center sm:text-left">
                    <h1 class="md:text-2xl font-bold mb-6">
                        Hey! I'm Johan.
                    </h1>

                    <p class="md:text-xl leading-snug mb-4">
                        Software Engineer at
                        <a
                            href="https://newdays.nl"
                            rel="noopener noreferrer"
                            target="_blank"
                            class="underline decoration-dotted hover:decoration-solid"
                        >newdays.nl</a>, creator of
                        <a
                            href="https://github.com/johanvanhelden/dockerhero"
                            rel="noopener noreferrer"
                            target="_blank"
                            class="underline decoration-dotted hover:decoration-solid"
                        >Dockerhero</a>, Sci-Fi enthousiast.
                    </p>

                    <a
                        href="/#about-me"
                        class="underline decoration-dotted hover:decoration-solid"
                    >Want to know more?</a>
                </div>
            </div>
        @endif
    </div>

    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="absolute z-0 left-0 bottom-0 block w-full h-8 md:h-12 lg:h-24"
        viewBox="0 0 200 100"
        preserveAspectRatio="none"
    >
        <g>
            <polygon fill="#fff" points="100,100 200,0 200,100" />
            <polygon fill="#fff" points="100,100 0,0 0,100" />
        </g>
    </svg>
</div>
