<?php declare(strict_types=1);

use App\Doctrine\FixDefaultSchemaSubscriber;
use App\VideoMeeting;

return [
    'config' => [
        'doctrine' => [
            'dev_mode'    => true,
            'cache_dir'   => null,
            'proxy_dir'   => __DIR__ . '/../../var/cache/' . PHP_SAPI . '/doctrine/proxy',
            'subscribers' => [
                FixDefaultSchemaSubscriber::class,
            ],
        ],
    ],
];
