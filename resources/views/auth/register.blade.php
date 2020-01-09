@extends('layouts.auth')

@section('title', __('page-auth.sign_up.page_title'))

@section('card-header', __('page-auth.sign_up.headings.form'))
@section('card-content')
    {!! Form::open([
        'route'  => 'register',
        'method' => 'post',
    ]) !!}
        <fieldset>
            <legend><h5>{{ __('page-auth.sign_up.headings.account_info') }}</h5></legend>
            {{ Form::uiText('name', null, __('user.attributes.name'), [], true) }}
            {{ Form::uiEmail('email', null, __('user.attributes.email'), [], true) }}
            {{ Form::uiPassword('password', __('user.attributes.password'), [], true) }}
            {{ Form::uiPassword('password_confirmation', __('user.attributes.password_confirmation'), [], true) }}

            {{ Form::uiCaptcha() }}
        </fieldset>

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.sign_up') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    {!! Form::close() !!}
@endsection
