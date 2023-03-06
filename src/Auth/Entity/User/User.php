<?php

declare(strict_types=1);

namespace App\Auth\Entity\User;

use App\Auth\DBAL\User\IdType;
use App\Auth\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
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

    #[ORM\Column(name: 'status', type: 'auth_user_status', nullable: false)]
    private Status $status;

    public function __construct(
        Id                 $id,
        string             $name,
        \DateTimeImmutable $createdAt
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->createdAt = $createdAt;

        $this->status = Status::Wait;
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
