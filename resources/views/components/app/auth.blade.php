<x-app.wrapper :page-title="$pageTitle ?? null">
    <div class="h-screen w-screen | auth-background">
        <div class="container mx-auto h-full flex justify-center items-center">
            <div class="w-full md:w-1/3">
                <h1 class="text-xl | text-center mb-4">{{ config('app.name') }}</h1>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    {{ $slot }}
                </div>

                <p class="text-white text-xs text-center">
                    <a href="{{ route('page.home') }}">{{ config('app.name') }}</a> © {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</x-app.wrapper>
