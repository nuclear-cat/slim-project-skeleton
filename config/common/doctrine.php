<?php

declare(strict_types=1);

use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Auth;
use function App\env;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container): EntityManagerInterface {

        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     metadata_dirs:string[],
         *     dev_mode:bool,
         *     cache_dir:string,
         *     proxy_dir:string,
         *     types:array<string,class-string<Doctrine\DBAL\Types\Type>>,
         *     subscribers:string[],
         *     connection:array<string, mixed>
         * } $settings
         */
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

        return new EntityManager(
            $container->get(Connection::class),
            $config,
            $eventManager,
        );
    },

    Connection::class => static function (ContainerInterface $container): Connection {

        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     driver:string,
         *     host:string,
         *     user:string,
         *     password:string,
         *     dbname:string,
         *     charset:string,
         * } $params
         */
        $params = $container->get('config')['connection'];

        return DriverManager::getConnection($params);
    },

    'config' => [
        'connection' => [
            'driver'        => 'pdo_pgsql',
            'host'          => env('DB_HOST'),
            'user'          => env('DB_USER'),
            'password'      => env('DB_PASSWORD'),
            'dbname'        => env('DB_NAME'),
            'charset'       => 'utf-8',
            'mapping_types' => [
                Auth\DBAL\User\StatusType::NAME => Types::STRING,
            ],
        ],
        'doctrine'   => [
            'dev_mode'      => false,
            'subscribers'   => [],
            'cache_dir'     => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir'     => __DIR__ . '/../../var/cache/doctrine/proxy',
            'metadata_dirs' => [
                __DIR__ . '/../../src/Auth/Entity',
            ],
            'types'         => [
                Auth\DBAL\User\IdType::NAME     => Auth\DBAL\User\IdType::class,
                Auth\DBAL\User\StatusType::NAME => Auth\DBAL\User\StatusType::class,
            ],
        ],
    ],
];
