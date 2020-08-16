<?php

declare(strict_types=1);

return [
    'enabled' => env('NOCAPTCHA_ENABLED', true),
    'secret'  => env('NOCAPTCHA_SECRET'),
    'sitekey' => env('NOCAPTCHA_SITEKEY'),
    'options' => [
        'timeout' => 30,
    ],
];
