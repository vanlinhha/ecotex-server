<?php

return [
    'user' => [
        'model' => 'App\Models\Users',
    ],
    'broadcast' => [
        'enable' => true,
        'app_name' => 'your-app-name',
        'pusher' => [
            'app_id' => '730885',
            'app_key' => '09a1966d4d5a3c582104',
            'app_secret' => 'f867ced5df6149395154',
            'options' => [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        ],
    ],
];
