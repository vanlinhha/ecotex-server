<?php

return [
    'role_structure'       => [

        'administrator' => [
            'users'   => 'c,r,u,d',
            'acl'     => 'c,r,u,d',
            'profile' => 'r,u'
        ],

        'buyer' => [
            'users' => 'c,r,u,d',
            'ou'    => 'c,r,u,d',
        ],

        'enterprise buyer' => [
            'users' => 'c,r,u,d',
            'ou'    => 'c,r,u,d',
        ],

        'supplier' => [
            'users' => 'c,r,u,d',
            'ou'    => 'c,r,u,d',
        ],

        'paid supplier' => [
            'users' => 'c,r,u,d',
            'ou'    => 'c,r,u,d',
        ],

        'manufacture' => [
            'profile' => 'r,u'
        ],

        'paid manufacture' => [
            'profile' => 'r,u'
        ],

        'human resource' => [
            'profile' => 'r,u'
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
