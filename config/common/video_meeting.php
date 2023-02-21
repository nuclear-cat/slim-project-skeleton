<?php declare(strict_types=1);

use App\VideoMeeting\Repository\VideoMeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
//    VideoMeetingRepository::class => static function (ContainerInterface $container): VideoMeetingRepository {
//        $em = $container->get(EntityManagerInterface::class);
//
//        return new VideoMeetingRepository(
//            $em,
//            $repo,
//        );
//    },
];