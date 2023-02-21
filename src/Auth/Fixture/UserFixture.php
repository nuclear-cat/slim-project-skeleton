<?php

declare(strict_types=1);

namespace App\Auth\Fixture;

use App\Auth\Entity\User\User;
use App\Auth\Entity\User\Id;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

final class UserFixture extends AbstractFixture
{
    public const TEST_ID = '00000000-7000-0000-0000-a1d6e8076756';

    public function load(ObjectManager $manager): void
    {
        $testMeeting = (new User(
            new Id(Uuid::fromString(self::TEST_ID)),
        ));

        $manager->persist($testMeeting);
        $manager->flush();
    }
}
