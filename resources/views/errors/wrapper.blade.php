@extends('layouts.wrapper')

<div class="h-screen w-screen">
    <div class="container mx-auto h-full flex justify-center items-center">
        <div class="w-full md:w-1/3">
            <h1 class="text-2xl | text-center mb-4">
                {{ config('app.name') }}
            </h1>

            <hr class="mb-4">

            <h2 class="text-xl | text-center mb-4">
                @yield('code') - @yield('message')
            </h2>

            <p class="text-center | mb-4">
                <a class="link link--primary" href="/">
                    Go back to the homepage
                </a>
            </p>
        </div>
    </div>
</div>
