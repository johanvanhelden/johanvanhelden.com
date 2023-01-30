<?php

declare(strict_types=1);

return [
    'users' => [
        [
            'on-production' => true,
            'data'          => [
                'name'     => 'Johan van Helden',
                'email'    => 'johan@johanvanhelden.com',
                'password' => 'Johan',
            ],
            'roles' => [
                'admin',
                'user',
            ],
        ], [
            'on-production' => false,
            'data'          => [
                'name'     => 'Johan User',
                'email'    => 'user@johanvanhelden.com',
                'password' => 'user',
            ],
            'roles' => [
                'user',
            ],
        ],
    ],
    'roles' => [
        'admin' => [
            'access-horizon',
            'access-nova-tools',
            'access-nova',

            'manage-users',
            'manage-roles',
            'manage-permissions',
            'manage-activities',
            'manage-action-events',

            'manage-projects',
            'manage-tools',
            'manage-subscribers',
        ],
        'user' => [
            //
        ],
    ],
];
