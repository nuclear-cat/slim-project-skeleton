<?php

declare(strict_types=1);

namespace App\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckDbConnectionCommand extends Command
{
    protected static $defaultName = 'app:check-db-connection';

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            if ($this->entityManager->getConnection()->connect()) {
                $output->writeln('Connection successful!');

                return self::SUCCESS;
            }
        } catch (\Exception) {
        }

        $output->writeln('No connection');

        return self::FAILURE;
    }
}
