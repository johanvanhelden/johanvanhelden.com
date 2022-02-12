<?php

declare(strict_types=1);

use App\Enums\Activity\Event;

return [
    'singular' => 'Activity',
    'plural'   => 'Activities',

    'attributes' => [
        'causer'      => 'Causer',
        'subject'     => 'Subject',
        'description' => 'Description',
        'properties'  => 'Properties',

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
