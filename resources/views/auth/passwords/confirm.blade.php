@extends('layouts.auth')

@section('title', __('page-auth.password_confirm.page_title'))

@section('card-header', __('page-auth.password_confirm.headings.form'))
@section('card-content')
    {!! Form::open([
        'route'  => 'password.confirm',
        'method' => 'post',
        'id'     => 'confirm'
    ]) !!}
        {{ Form::uiPassword('password', __('user.attributes.password'), [], true) }}

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary" form="confirm">
                {{ __('action.confirm') }}
            </button>
        </div>
    {!! Form::close() !!}
@endsection
