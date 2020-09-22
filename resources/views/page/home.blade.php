<x-app.main page-title="Home" :expanded-header="true">
    <x-partials.intro class="bg-white" />

    <x-partials.projects :projects="$projects" />

    <x-partials.tools :tools="$tools" class="bg-white" />

    <x-partials.languages />

    <x-partials.about-me class="bg-white" />

    <x-partials.subscribe />
</x-app.main>
