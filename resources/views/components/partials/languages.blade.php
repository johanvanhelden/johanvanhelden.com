<section class="py-10 {{ $class ?? ''}}">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl text-center text-secondary font-bold mb-6">
            Languages
        </h2>

        <div class="flex flex-wrap items-center justify-center">
            <x-cards.language
                name="Dutch"
                image-url="/images/languages/dutch.png"
                class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
            />
            <x-cards.language
                name="English"
                image-url="/images/languages/english.png"
                class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
            />
            <x-cards.language
                name="PHP"
                image-url="/images/languages/php.png"
                class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
            />
            <x-cards.language
                name="JavaScript"
                image-url="/images/languages/js.png"
                class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
            />
        </div>
    </div>
</section>
