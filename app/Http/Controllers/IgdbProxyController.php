<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use MariusGelez\IGDBLaravel\ApiHelper;
use MariusGelez\IGDBLaravel\Exceptions\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class IgdbProxyController
{
    private const int MAX_QUERY_LENGTH = 16_384;

    public function handle(Request $request, string $path): Response
    {
        abort_unless(in_array($path, config('services.igdb_proxy.allowed_paths'), true), 404);

        $query = $request->getContent();

        abort_if(strlen($query) > self::MAX_QUERY_LENGTH, 413);

        $eventFresh = (int) config('services.igdb_proxy.event_cache_lifetime');
        $eventStale = (int) config('services.igdb_proxy.event_stale_lifetime');

        $cacheLifetime = $path === 'events' ? $eventFresh : (int) config('igdb.cache_lifetime');

        $cacheKey = config('igdb.cache_prefix', 'igdb_cache') . '.' . md5($path . $query);

        try {
            $cachedResponse = match (true) {
                $cacheLifetime === 0 => $this->fetch($path, $query),
                $path === 'events' => Cache::flexible(
                    $cacheKey,
                    [$eventFresh, $eventStale],
                    fn (): array => $this->fetch($path, $query),
                    ['seconds' => $eventStale],
                ),
                default => Cache::remember(
                    $cacheKey,
                    $cacheLifetime,
                    fn (): array => $this->fetch($path, $query),
                ),
            };
        } catch (RequestException $exception) {
            $cachedResponse = $this->serializeResponse($exception->response);
        } catch (AuthenticationException|ConnectionException $exception) {
            report($exception);

            $cachedResponse = [
                'body' => '{"message":"IGDB is temporarily unavailable."}',
                'status' => Response::HTTP_BAD_GATEWAY,
                'headers' => ['Content-Type' => 'application/json'],
            ];
        }

        return new \Illuminate\Http\Response(
            $cachedResponse['body'],
            $cachedResponse['status'],
            $cachedResponse['headers'],
        );
    }

    /**
     * @return array{body: string, status: int, headers: array<string, string>}
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    private function fetch(string $path, string $query): array
    {
        $response = Http::withOptions([
            'base_uri' => ApiHelper::IGDB_BASE_URI,
        ])->withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => config('igdb.credentials.client_id'),
            'Authorization' => 'Bearer ' . ApiHelper::retrieveAccessToken(),
        ])
            ->withBody($query, 'text/plain')
            ->connectTimeout(3)
            ->timeout(10)
            ->dontTruncateExceptions()
            ->retry([100, 500, 1000], 0, static function (Throwable $exception, PendingRequest $_request): bool {
                return $exception instanceof ConnectionException
                    || ($exception instanceof RequestException && $exception->response->serverError());
            })
            ->post($path)
            ->throw();

        return $this->serializeResponse($response);
    }

    /**
     * @return array{body: string, status: int, headers: array<string, string>}
     */
    private function serializeResponse(ClientResponse $response): array
    {
        return [
            'body' => $response->body(),
            'status' => $response->status(),
            'headers' => [
                'Content-Type' => $response->header('Content-Type') ?: 'application/json',
            ],
        ];
    }
}
