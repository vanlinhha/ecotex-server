<?php

return [
    'role_structure'       => [

        'administrator' => [
            'users'   => 'c,r,u,d',
            'acl'     => 'c,r,u,d',
            'profile' => 'r,u',
        ],

        'personal buyer' => [
            'users'     => 'c,r,u,d',
            'ou'        => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',
        ],

        'buyer' => [
            'users'     => 'c,r,u,d',
            'ou'        => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',

        ],

        'supplier' => [
            'users'     => 'c,r,u,d',
            'ou'        => 'c,r,u,d',
            'showroom'  => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',

        ],

        'paid supplier' => [
            'users'     => 'c,r,u,d',
            'ou'        => 'c,r,u,d',
            'showroom'  => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',

        ],

        'manufacture' => [
            'profile'   => 'r,u',
            'showroom'  => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',

        ],

        'paid manufacture' => [
            'profile'   => 'r,u',
            'showroom'  => 'c,r,u,d',
            'news_feed' => 'r',
            'posting'   => 'c,r,u,d',
            'order'   => 'c,r,u,d',
            'messaging'   => 'c,r,u,d',
            'evaluating'   => 'c,r,u,d',


        ],

        'human resource' => [
            'profile' => 'r,u',
            'apply' => 'c,r,u,d'
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
        'd' => 'delete'
    ]
];
