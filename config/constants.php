<?php

return [
    'environment' => [
        'development' => [
            'dev',
            'local',
            'testing',
        ],
        'testing' => [
            'testing',
        ],
        'production' => [
            'production',
            'prod',
            'live',
        ],
    ],
    'format' => [
        'date'      => 'd-m-Y',
        'time'      => 'H:i',
        'datetime'  => 'd-m-Y H:i',
        'timestamp' => 'YmdHis',

        'date_moment'     => 'DD-MM-YYYY',
        'time_moment'     => 'hh:mm',
        'datetime_moment' => 'DD-MM-YYYY hh:mm',

        'datetime_nova' => 'Y-m-d H:i:s',
    ],
];
