<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class Id
{
    private string $value;

    public function __construct(UuidInterface $uuid)
    {
        $this->value = $uuid->toString();
    }

    public static function fromString(string $string): self
    {
        return new self(Uuid::fromString($string));
    }

    public static function create(): self
    {
        return new self(Uuid::uuid7());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
