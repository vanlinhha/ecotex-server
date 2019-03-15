<?php

return [
    'role_structure'       => [

        'administrator' => [
            'users'      => 'm',
            'acl'        => 'm',
            'posting'    => 'm',
            'ordering'   => 'm',
            'evaluating' => 'm',
            'profile'    => 'm,r,u',
        ],

        'personal buyer' => [
            'newsfeed'   => 'r',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',
            'profile'    => 'r,u',
        ],

        'buyer' => [
            'newsfeed'   => 'r',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',
            'profile'    => 'r,u',
        ],

        'supplier' => [
            'showroom'   => '',
            'newsfeed'   => 'r',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',
            'profile'    => 'r,u',
        ],

        'paid supplier' => [
            'showroom'   => '',
            'newsfeed'   => 'r',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',
            'profile'    => 'r,u',

        ],

        'manufacture' => [
            'profile'    => 'r,u',
            'showroom'   => '',
            'newsfeed'   => '',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',

        ],

        'paid manufacture' => [
            'profile'    => 'r,u',
            'showroom'   => '',
            'newsfeed'   => '',
            'posting'    => '',
            'ordering'   => '',
            'messaging'  => '',
            'evaluating' => '',
        ],

        'human resource' => [
            'profile' => 'r,u',
            'apply'   => ''
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'profile' => 'c,r,u'
        ],
    ],
    'permissions_map'      => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'm' => 'manage'
    ]
];
