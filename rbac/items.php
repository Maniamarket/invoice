<?php
return [
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'group',
    ],
    'manager' => [
        'type' => 1,
        'description' => 'Manager',
        'ruleName' => 'group',
        'children' => [
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'group',
        'children' => [
            'manager',
        ],
    ],
    'superadmin' => [
        'type' => 1,
        'description' => 'Superadmin',
        'ruleName' => 'group',
        'children' => [
            'admin',
        ],
    ],
];
