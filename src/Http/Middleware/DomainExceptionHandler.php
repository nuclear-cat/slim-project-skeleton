<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Response\JsonResponse;
use DomainException;
use Share\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DomainExceptionHandler implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (NotFoundException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 404);
        } catch (DomainException $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 409);
        }
    }
}
