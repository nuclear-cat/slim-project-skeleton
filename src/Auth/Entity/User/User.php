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

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Id                 $id,
        \DateTimeImmutable $createdAt
    ) {
        $this->id        = $id;
        $this->createdAt = $createdAt;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
