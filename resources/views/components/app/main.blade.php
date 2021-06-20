<x-app.wrapper :page-title="$pageTitle ?? null">
    <div class="min-h-screen flex flex-col font-sans text-xl text-gray-700 antialiased border-t-4 border-primary-dark">
        <div class="flex-grow">
            <x-app.header :expanded-header="$expandedHeader ?? false" />

            <main>
                {{ $slot }}
            </main>
        </div>

        <x-app.footer />
    </div>
</x-app.wrapper>
