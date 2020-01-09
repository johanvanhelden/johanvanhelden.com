@extends('layouts.auth')

@section('title', __('page-auth.set.page_title'))

@section('card-header', __('page-auth.set.headings.form'))
@section('card-content')
    {!! Form::open([
        'route'  => 'password-set.post',
        'method' => 'post',
    ]) !!}
        {{ Form::hidden('token', $token) }}

        {{ Form::uiEmail('email', $email, __('user.attributes.email'), [], true) }}
        {{ Form::uiPassword('password', __('user.attributes.password'), [], true) }}
        {{ Form::uiPassword('password_confirmation', __('user.attributes.password_confirmation'), [], true) }}

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.set_password') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    {!! Form::close() !!}
@endsection
