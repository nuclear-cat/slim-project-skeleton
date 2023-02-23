<?php

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

final class FixDefaultSchemaSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            ToolEvents::postGenerateSchema => 'postGenerateSchema',
        ];
    }

    /**
     * @throws Exception
     * @throws SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        /**
         * @psalm-suppress RedundantCondition
         */
        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        /**
         * @psalm-suppress InternalMethod
         */
        foreach ($schemaManager->getExistingSchemaSearchPaths() as $namespace) {
            if (!$args->getSchema()->hasNamespace($namespace)) {
                $args->getSchema()->createNamespace($namespace);
            }
        }
    }
}
