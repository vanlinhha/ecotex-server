<?php

return [
    'role_structure' => [

        'administrator' => [
            'account' => 'm',
            'acl' => 'm',
            'posting' => '',
            'profile' => 'm,r,u',
            'showroom' => '',
            'newsfeed' => '',
            'search' => '',
            'bookmark' => '',
            'response' => '',
            'category' => '',
            'reporting' => '',

        ],

        'personal buyer' => [
            'showroom' => '',
            'newsfeed' => '',
            'profile' => 'r,u',
            'search' => '',
        ],

        'buyer' => [
            'newsfeed' => '',
            'posting' => '',
            'messaging' => '',
            'ranking' => '',
            'profile' => 'r,u',
            'showroom' => '',
            'search' => '',
            'bookmark' => '',
            'response' => '',
        ],

        'supplier' => [
            'showroom' => '',
            'newsfeed' => '',
            'profile' => 'r,u',
            'search' => '',
            'bookmark' => '',
        ],

        'paid supplier' => [
            'showroom' => '',
            'newsfeed' => '',
            'posting' => '',
            'messaging' => '',
            'ranking' => '',
            'profile' => 'r,u',
            'search' => '',
            'bookmark' => '',
            'response' => '',

        ],

        'manufacture' => [
            'profile' => 'r,u',
            'showroom' => '',
            'newsfeed' => '',
            'evaluating' => '',
            'search' => '',
            'bookmark' => '',
        ],

        'paid manufacture' => [
            'profile' => 'r,u',
            'showroom' => '',
            'newsfeed' => '',
            'posting' => '',
            'messaging' => '',
            'ranking' => '',
            'search' => '',
            'bookmark' => '',
            'response' => '',
        ],

        'human resource' => [
            'profile' => 'r,u',
            'apply' => '',
            'newsfeed' => '',
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'm' => 'manage'
    ]
];
