<?php

namespace App\Enums;

enum UserRole: string
{
    case Administrator = 'administrator';
    case Supervisor    = 'supervisor';
    case Operator      = 'operator';
    case Client        = 'client';

    public function label(): string
    {
        return match($this) {
            self::Administrator => __('users.roles.administrator'),
            self::Supervisor    => __('users.roles.supervisor'),
            self::Operator      => __('users.roles.operator'),
            self::Client        => __('users.roles.client'),
        };
    }
}
