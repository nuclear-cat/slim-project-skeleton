<?php

declare(strict_types=1);

namespace App\Tests\Unit\Auth\Entity\User;

use App\Auth\Entity\User\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Auth\Entity\User\Id
 */
final class IdTest extends TestCase
{
    public function testUnique(): void
    {
        $id1 = Id::createNew();
        $id2 = Id::createNew();

        $this->assertNotEquals($id1->getValue(), $id2->getValue());
    }

    public function testCreateFromString(): void
    {
        $id = Id::fromString('00000000-0000-79c0-9cb5-541dc2d1769d');

        $this->assertEquals('00000000-0000-79c0-9cb5-541dc2d1769d', $id->getValue());
    }
}
