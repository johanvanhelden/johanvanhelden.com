<?php

declare(strict_types=1);

// phpcs:disable Generic.Files.LineLength.TooLong

return [
    'error'           => 'Something went wrong. Please try again later.',
    'session_expired' => 'Your session has expired. For safety reasons you have been automatically logged out. '
        . 'Please reload the page and try again.',

    'saved' => 'The changes have been succesfully saved.',

    'cache' => [
        'cleared' => 'The cache has been cleared succesfully.',
    ],

    'subscription' => [
        'confirmation-required' => 'Confirmation required',
        'unconfirmed'           => 'Please confirm your subscription first using the link in the email we have just sent.',
        'requested'             => 'We have succesfully received your subscription request!
            Please check your inbox and click the confirmation link inside.',
        'confirmed' => 'Your subscription has succesfully been confirmed.',
        'deleted'   => 'Your subscription has succesfully been removed.',
    ],
];
