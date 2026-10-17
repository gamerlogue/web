<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * An API error the client branches on through its stable `code` (e.g. `profile_private`).
 *
 * API Platform renders it on its own routes, where DomainErrorNormalizer copies the code from the
 * X-Error-Code header into the error object; render() covers the plain controller routes.
 */
final class ApiDomainException extends HttpException
{
    public function __construct(int $status, string $code, string $detail)
    {
        parent::__construct($status, $detail, headers: ['X-Error-Code' => $code]);
    }

    public static function profilePrivate(): self
    {
        return new self(403, 'profile_private', 'This profile is private.');
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => [[
                'status' => (string) $this->getStatusCode(),
                'code' => $this->getHeaders()['X-Error-Code'],
                'detail' => $this->getMessage(),
            ]],
        ], $this->getStatusCode(), ['Content-Type' => 'application/vnd.api+json']);
    }
}
