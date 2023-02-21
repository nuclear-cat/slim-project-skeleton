<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Spiral\RoadRunner\Http\PSR7WorkerInterface;
use Spiral\RoadRunner;
use Nyholm\Psr7;

return [
    PSR7WorkerInterface::class => static function (ContainerInterface $container): PSR7WorkerInterface {
        $worker = RoadRunner\Worker::create();
        $psrFactory = new Psr7\Factory\Psr17Factory();

        return new RoadRunner\Http\PSR7Worker($worker, $psrFactory, $psrFactory, $psrFactory);
    },
];
