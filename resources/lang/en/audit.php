<?php

declare(strict_types=1);

use App\Enums\Audit\Event;

return [
    'singular' => 'Audit',
    'plural'   => 'Audits',

    'attributes' => [
        'auditable'  => 'Entity',
        'event'      => 'Event',
        'ip_address' => 'IP address',
        'user_agent' => 'User agent',
        'old_values' => 'Old values',
        'new_values' => 'New values',
        'tags'       => 'Tags',
        'url'        => 'Url',

        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'event' => [
        Event::LOGGED_IN  => 'Logged in',
        Event::LOGGED_OUT => 'Logged out',

        Event::CREATED  => 'Created',
        Event::UPDATED  => 'Updated',
        Event::DELETED  => 'Deleted',
        Event::RESTORED => 'Restored',
    ],
];
