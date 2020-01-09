@extends('layouts.auth')

@section('title', __('page-auth.login.page_title'))

@section('card-header', __('page-auth.login.headings.form'))
@section('card-content')
    {!! Form::open([
        'route'  => 'login',
        'method' => 'post',
    ]) !!}
        {{ Form::uiEmail('email', null, __('user.attributes.email'), [], true) }}
        {{ Form::uiPassword('password', __('user.attributes.password'), [], true) }}
        {{ Form::uiCheckbox('remember', null, __('page-auth.login.remember')) }}

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary" dusk="login-button">
                {{ __('action.login') }}
            </button>

            <a href="{{ route('password.request') }}" class="link link--primary">
                {{ __('action.forgot_password') }}
            </a>
        </div>
    {!! Form::close() !!}
@endsection
