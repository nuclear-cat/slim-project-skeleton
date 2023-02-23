<?php

declare(strict_types=1);

use App\Http\Action;
use Slim\App;

return new class {
    public function __invoke(App $app): void
    {
        $app->get('/', Action\HomeAction::class);
    }
};
