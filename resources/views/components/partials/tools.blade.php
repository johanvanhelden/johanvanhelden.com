<section class="py-10 {{ $class ?? ''}}">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl text-center text-secondary font-bold mb-6">
            In The Toolbox
        </h2>

        <div class="flex flex-wrap items-center justify-center">
            @foreach ($tools as $tool)
                <x-cards.tool
                    :name="$tool->name"
                    :image-url="$tool->image_url"
                    :url="$tool->url"
                    class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
                />
            @endforeach
        </div>
    </div>
</section>
