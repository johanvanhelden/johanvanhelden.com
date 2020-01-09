<?php

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
            'manage-audits',

            'manage-projects',
            'manage-tools',
            'manage-subscribers',
        ],
        'user' => [
            //
        ],
    ],
];
