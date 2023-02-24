<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auth\Entity\User;

use App\Auth\Entity\User\Id;
use App\Auth\Entity\User\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Auth\Entity\User\User
 */
final class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new User(
            Id::createNew(),
            'Test User',
            new \DateTimeImmutable(),
        );

        $this->assertEquals('Test User', $user->getName());
        $this->assertInstanceOf(User::class, $user);
    }
}
