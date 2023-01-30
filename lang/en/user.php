<?php

declare(strict_types=1);

// phpcs:disable Generic.Files.LineLength.TooLong

return [
    'singular' => 'User',
    'plural'   => 'Users',

    'attributes' => [
        'name'     => 'Name',
        'email'    => 'Email address',
        'password' => 'Password',

        'current_password'          => 'Current password',
        'password_confirmation'     => 'Password confirmation',
        'new_password'              => 'New password',
        'new_password_confirmation' => 'New password confirmation',

        'email_verified_at' => 'Email verified at',
        'created_at'        => 'Created at',
    ],
];
