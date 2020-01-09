<?php

return [
    'notify-self' => [
        'enabled' => env('SUBSCRIPTION_NOTIFICATIONS', false),
        'email'   => env('SUBSCRIPTION_NOTIFICATION_EMAIL', null),
    ],
];
