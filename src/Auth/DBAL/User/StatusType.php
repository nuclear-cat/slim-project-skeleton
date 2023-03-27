<?php

declare(strict_types=1);

namespace App\Auth\DBAL\User;

use App\Auth\Entity\User\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class StatusType extends Type
{
    public const NAME = 'auth_user_status';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        if (!$value instanceof Status) {
            throw new \InvalidArgumentException('Invalid user status');
        }

        return $value->value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Status
    {
        return Status::from($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
