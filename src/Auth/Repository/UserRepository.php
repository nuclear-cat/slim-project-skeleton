<?php

declare(strict_types=1);

namespace App\Auth\Repository;

use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Shared\Exception\NotFoundException;

/**
 * @psalm-suppress UnusedClass
 */
final readonly class UserRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function get(Id $id): User
    {
        $user = $this->repository->find($id->getValue());

        if ($user instanceof User) {
            return $user;
        }

        throw new NotFoundException("Auth user #{$id->getValue()} is not found.");
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
    }
}
