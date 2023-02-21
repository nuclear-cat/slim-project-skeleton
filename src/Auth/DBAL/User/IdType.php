<?php

declare(strict_types=1);

namespace App\Auth\DBAL\User;

use App\Auth\Entity\User\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class IdType extends Type
{
    public const NAME = 'auth_user_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'uuid';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        if ($value instanceof Id || null === $value) {
            return $value;
        }

        if (!\is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [
                'null',
                'string',
                Id::class,
            ]);
        }

        try {
            return Id::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
