@extends('layouts.auth')

@section('title', __('page-auth.login.page_title'))

@section('card-header', __('page-auth.login.headings.form'))
@section('card-content')

<x-form action="{{ route('login') }}">
    <x-forms.inputs.input type="email" name="email" label="{{ __('user.attributes.email') }}" />
    <x-forms.inputs.input type="password" name="password" label="{{ __('user.attributes.password') }}" />
    <x-forms.inputs.checkbox name="remember" label="{{ __('page-auth.login.remember') }}" />

    <div class="flex items-center justify-between">
        <button type="submit" class="button button--primary" dusk="login-button">
            {{ __('action.login') }}
        </button>

        <a href="{{ route('password.request') }}" class="link link--primary">
            {{ __('action.forgot_password') }}
        </a>
    </div>
</x-form>
@endsection
