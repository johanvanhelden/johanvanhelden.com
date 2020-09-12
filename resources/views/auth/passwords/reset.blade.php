@extends('layouts.auth')

@section('title', __('page-auth.reset.page_title'))

@section('card-header', __('page-auth.reset.headings.form'))
@section('card-content')
    <x-form action="{{ route('password.update') }}">
        <x-forms.inputs.input type="hidden" name="token" value="{{ $token }}" />

        <x-forms.inputs.input type="email" name="email" value="{{ $email }}" label="{{ __('user.attributes.email') }}" required />

        <x-forms.inputs.input type="password" name="password" label="{{ __('user.attributes.password') }}" required />
        <x-forms.inputs.input type="password" name="password_confirmation" label="{{ __('user.attributes.password_confirmation') }}" required />

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.reset_password') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    </x-form>
@endsection
