<?php

// TODO: traduzioni inglesi — post-MVP
return [
    'label'        => 'User',
    'plural_label' => 'Users',

    'fields' => [
        'name'                      => 'Name',
        'email'                     => 'Email',
        'password'                  => 'Password',
        'password_confirmation'     => 'Confirm password',
        'role'                      => 'Role',
        'company'                   => 'Company',
        'can_view_company_tickets'  => 'Can view all company tickets',
        'created_at'                => 'Created at',
        'updated_at'                => 'Updated at',
    ],

    'roles' => [
        'administrator' => 'Administrator',
        'supervisor'    => 'Supervisor',
        'operator'      => 'Operator',
        'client'        => 'Client',
    ],

    'actions' => [
        'create' => 'New user',
        'edit'   => 'Edit user',
        'delete' => 'Delete user',
    ],

    'messages' => [
        'created' => 'User created successfully.',
        'updated' => 'User updated successfully.',
        'deleted' => 'User deleted successfully.',
    ],
];
