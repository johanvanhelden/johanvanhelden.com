@component('mail::message')
# {{ __('mail.confirm_subscription.subject') }}

Hello {{ $subscriber->name }},

In order for your subscription to be valid, please confirm it.

@component('mail::button', ['url' => $subscriber->confirm_subscription_url])
Confirm your subscription
@endcomponent

@slot('subcopy')
{{ __('notification.trouble_viewing', ['actionText' => 'Confirm your subscription']) }} [{{ $subscriber->confirm_subscription_url }}]({{ $subscriber->confirm_subscription_url }})
@endslot
@endcomponent
