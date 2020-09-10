@extends('layouts.auth')

@section('title', __('page-auth.password_confirm.page_title'))

@section('card-header', __('page-auth.password_confirm.headings.form'))
@section('card-content')
    <x-form action="{{ route('password.confirm') }}">
        <x-forms.inputs.input type="password" name="password" label="{{ __('user.attributes.password') }}" required />


        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary" form="confirm">
                {{ __('action.confirm') }}
            </button>
        </div>
    </x-form>
@endsection
