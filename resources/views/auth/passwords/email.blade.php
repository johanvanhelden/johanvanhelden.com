@extends('layouts.auth')

@section('title', __('page-auth.forgot.page_title'))

@section('card-header', __('page-auth.forgot.headings.form'))
@section('card-content')
    <x-form action="{{ route('password.email') }}">
        @if (session()->has('flash_notification'))
            <p class="text-blue-800 mb-4">
                {{ session('flash_notification', collect())->first()->message }}
            </p>
        @endif

        <x-forms.inputs.input type="email" name="email" label="{{ __('user.attributes.email') }}" required />

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.send_reset_link') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    </x-form>
@endsection
