@component('mail::message')
# {{ __('mail.subscription_confirmed.subject') }}

Hello {{ $subscriber->name }},

This is the confirmation email that your subscription has been succesfully registered.

@slot('subcopy')
[Click here if you wish to edit your subscription.]({{ $subscriber->manage_subscription_url }})
@endslot
@endcomponent
