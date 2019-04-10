<?php

return [
    'user' => [
        'model' => 'App\Models\Users',
    ],
    'broadcast' => [
        'enable' => true,
        'app_name' => 'ecotex',
        'pusher' => [
            'app_id' => '730883',
            'app_key' => 'de78cb5d7124e33189ac',
            'app_secret' => '50a201dcf469ff676812',
            'options' => [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        ],
    ],
];
