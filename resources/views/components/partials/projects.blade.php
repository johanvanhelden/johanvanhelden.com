<section class="py-10 {{ $class ?? ''}}">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl text-center text-secondary font-bold mb-6">
            Projects
        </h2>
        <div class="flex flex-wrap">
            @foreach ($projects as $project)
                <x-cards.project
                    :title="$project['name']"
                    :text="$project['excerpt']"
                    :updated="$project['is_recently_updated']"
                    :url="route('project.show', $project['slug'])"
                    class="mx-2 my-3 px-3 w-full md:flex-grow md:w-1/3 lg:w-1/4"
                />
            @endforeach
        </div>
    </div>
</section>
