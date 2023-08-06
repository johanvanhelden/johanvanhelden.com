<x-app.main :page-title="$project['name']">
    <section class="py-10 bg-white">
        <div class="max-w-3xl px-6 mx-auto">
            <div class="mb-6">
                <div class="flex items-center">
                    <h1 class="text-4xl text-secondary font-bold leading-1">
                        {{ $project['name'] }}
                    </h1>
                </div>
                <p class="block text-xs uppercase text-gray-600 | mt-2">
                    <span class="block md:inline">Published on {{ $project['publish_at_display'] }}</span>

                    @if ($project['is_updated'])
                        <span
                            class="
                                hidden md:inline
                                @if ($project['is_recently_updated'])
                                    font-semibold text-primary
                                @endif
                            "
                        >&bull;</span>

                        <span
                            class="
                                block md:inline
                                @if ($project['is_recently_updated'])
                                    font-semibold text-primary
                                @endif
                            "
                        >
                            Latest update on {{ $project['updated_at_display'] }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="prose lg:prose-xl mb-6">
                {!! $project['content_display'] !!}
            </div>

            @if ($project['url'])
                <p>
                    <a
                        href="{{ $project['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="font-semibold text-primary hover:underline"
                    >
                        <i class="fas fa-external-link-alt"></i>
                        Visit the project
                    </a>
                </p>
            @endif
        </div>
    </section>

    <x-partials.about-me class="bg-white" />
</x-app.main>
