<?php declare(strict_types=1);

use App\Http\Middleware\DomainExceptionHandler;
use Slim\App;

return static function (App $app): void {
    $app->add(DomainExceptionHandler::class);
    $app->addErrorMiddleware(true, true, true);
    $app->addBodyParsingMiddleware();
};
