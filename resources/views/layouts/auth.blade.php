@extends('layouts.wrapper')

@section('body-class', 'body--auth')

@section('body')
    <div class="h-screen w-screen">
        <div class="container mx-auto h-full flex justify-center items-center">
            <div class="w-full md:w-1/3">
                <h1 class="text-xl | text-center mb-4">
                    {{ config('app.name') }}
                </h1>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h3 class="text-lg | mb-2">@yield('card-header')</h3>

                    <hr class="mb-4">

                    @yield('card-content')

                    @hasSection('card-footer')
                        @yield('card-footer')
                    @endif
                </div>

                <p class="text-white text-xs text-center">
                    <a href="/">Johan van Helden</a> © {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
@endsection
