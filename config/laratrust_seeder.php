<?php

return [
    'role_structure' => [
//        'superadministrator' => [
//            'users' => 'c,r,u,d',
//            'acl' => 'c,r,u,d',
//            'profile' => 'r,u'
//        ],
'administrator' => [
    'users' => 'c,r,u,d',
    'ou' => 'c,r,u,d',
    'acl' => 'c,r,u,d',

],

'leader' => [
    'users' => 'c,r,u,d',
    'ou' => 'c,r,u,d',
    'acl' => 'c,r,u,d',

],

'user' => [
    'profile' => 'r,u'
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
        'd' => 'delete'
    ]
];
