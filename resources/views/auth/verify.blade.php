@extends('layouts.auth')

@section('title', __('page-auth.verify.page_title'))

@section('card-header', __('page-auth.verify.headings.page'))
@section('card-content')
    @if (session('resent'))
        <div class="border-solid border-2 text-center text-base | bg-green-200 text-green-800 border-green-800 | py-2 px-4 mb-4" role="alert">
            {{ __('page-auth.verify.info.new_link_sent') }}
        </div>
    @endif

    <p class="mb-4">
        {{ __('page-auth.verify.texts.lead') }}
    </p>

    <x-form action="{{ route('verification.resend') }}">
        <p>
            {{ __('page-auth.verify.texts.not_received') }},
            <button type="submit" class="link link--primary">
                {{ __('page-auth.verify.texts.click_another') }}.
            </button>
        </p>
    </x-form>
@endsection
