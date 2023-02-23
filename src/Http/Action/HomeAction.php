<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Http\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class HomeAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): JsonResponse
    {
        return new JsonResponse([
            'title' => 'Slim Skeleton API',
            'version' => '1.0',
        ], 200);
    }
}
