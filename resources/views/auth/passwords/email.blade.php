@extends('layouts.auth')

@section('title', __('page-auth.forgot.page_title'))

@section('card-header', __('page-auth.forgot.headings.form'))
@section('card-content')
    {!! Form::open([
        'route'  => 'password.email',
        'method' => 'post',
    ]) !!}
        @if (session('status'))
            <p class="text-blue-800 mb-4">{{ session('status') }}</p>
        @endif

        {{ Form::uiEmail('email', null, __('user.attributes.email'), [], true) }}

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.send_reset_link') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    {!! Form::close() !!}
@endsection
