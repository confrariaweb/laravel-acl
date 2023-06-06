<?php

return [
    'administrator' => [
        'emails' => ['confrariaweb@gmail.com'],
    ],

    'defaults' => [
        'role' => [
            'administrator' => env('ACL_DEFAULT_ROLE_ADMIN', 1),
            'guest' => env('ACL_DEFAULT_ROLE_GUEST', 2),
        ],
    ],

    'user' => 'App\Models\User',
    'users_table' => 'users',

    'role' => 'ConfrariaWeb\Acl\Models\Role',
    'roles_table' => 'acl_roles',
    'role_user_table' => 'acl_role_user',
    'role_foreign_key' => 'role_id',
    'user_foreign_key' => 'user_id',

    'permission' => 'ConfrariaWeb\Acl\Models\Permission',
    'permissions_table' => 'acl_permissions',
    'permission_role_table' => 'acl_permission_role',
    'permission_foreign_key' => 'permission_id',
];
