<?php declare(strict_types=1);

use App\Environment;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/' . Environment::load('APP_ENV', 'prod') . '/*.php'),
]);

return $aggregator->getMergedConfig();
