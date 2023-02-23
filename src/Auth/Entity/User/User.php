<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use App\Auth\DBAL\User\IdType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'auth_users')]
final class User
{
    #[ORM\Id]
    #[ORM\Column(type: IdType::NAME, unique: true)]
    private Id $id;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Id                 $id,
        string             $name,
        \DateTimeImmutable $createdAt
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->createdAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
