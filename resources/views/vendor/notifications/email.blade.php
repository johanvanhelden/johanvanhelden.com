@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# {{ __('notification.error_greeting') }}
@else
# {{ __('notification.greeting') }}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset ($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{ __('notification.regards') }}<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset ($actionText)
@slot('subcopy')
{{ __('notification.trouble_viewing', ['actionText' => $actionText]) }} [{{ $actionUrl }}]({{ $actionUrl }})
@endslot
@endisset
@endcomponent
