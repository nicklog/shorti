<?php
// phpcs:disable
declare(strict_types=1);

namespace App\Domain;

enum Role: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}
