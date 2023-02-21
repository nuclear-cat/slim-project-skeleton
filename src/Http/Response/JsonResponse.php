<?php declare(strict_types=1);

namespace App\Http\Response;

use Nyholm\Psr7\Response;

final class JsonResponse extends Response
{
    /**
     * @throws \JsonException
     */
    public function __construct(
        array|object $data,
        int          $status = 200,
    ) {
        parent::__construct(
            $status,
            ['Content-Type' => 'application/json',],
            json_encode($data, JSON_THROW_ON_ERROR),
        );
    }
}
