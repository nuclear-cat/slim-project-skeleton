<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

enum Status: string
{
    case Wait = 'wait';
    case Active = 'active';
    case Banned = 'banned';
}
