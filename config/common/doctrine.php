<?php

declare(strict_types=1);

use App\Environment;
use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Auth;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container): EntityManagerInterface {
        $settings = $container->get('config')['doctrine'];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache_dir'] ? new FilesystemAdapter('', 0, $settings['cache_dir']) : new ArrayAdapter()
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        $eventManager = new EventManager();

        foreach ($settings['subscribers'] as $name) {
            /** @var EventSubscriber $subscriber */
            $subscriber = $container->get($name);
            $eventManager->addEventSubscriber($subscriber);
        }

        return EntityManager::create(
            $settings['connection'],
            $config,
            $eventManager
        );
    },

    Connection::class => static function (ContainerInterface $container): Connection {
        $em = $container->get(EntityManagerInterface::class);

        return $em->getConnection();
    },

    'config' => [
        'doctrine' => [
            'dev_mode'      => false,
            'subscribers'   => [],
            'cache_dir'     => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir'     => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection'    => [
                'driver'   => 'pdo_pgsql',
                'host'     => Environment::load('DB_HOST'),
                'user'     => Environment::load('DB_USER'),
                'password' => Environment::load('DB_PASSWORD'),
                'dbname'   => Environment::load('DB_NAME'),
                'charset'  => 'utf-8',
            ],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Auth/Entity',
            ],
            'types'         => [
                Auth\DBAL\User\IdType::NAME => Auth\DBAL\User\IdType::class,
            ],
        ],
    ],
];
