<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class IgdbProxyController extends Controller
{
    /**
     * Inoltra la richiesta all'API IGDB aggiungendo le intestazioni di autorizzazione,
     * applicando caching (GET/POST) e rispettando il rate limiter configurato.
     */
    public function handle(Request $request, ?string $path = ''): Response
    {
        $baseUrl = rtrim((string) config('services.igdb.base_url'), '/');
        $clientId = config('services.igdb.client_id');
        $token = config('services.igdb.access_token');
        $cacheTtl = (int) config('services.igdb.cache_ttl', 300);

        if (!$baseUrl || !$clientId || !$token) {
            return response()->json([
                'error' => 'IGDB service not configured',
            ], 500);
        }

        $path = ltrim($path ?? '', '/');
        $url = $baseUrl.($path ? '/'.$path : '');

        $method = strtoupper($request->method());
        $isCacheable = in_array($method, ['GET', 'POST'], true) && $cacheTtl > 0;

        $cacheKey = null;
        if ($isCacheable) {
            $cacheKey = $this->cacheKey($method, $path, $request);
            if (Cache::has($cacheKey)) {
                $cached = Cache::get($cacheKey);
                return $this->buildResponseFromArray($cached, true);
            }
        }

        $headers = [
            'Client-ID' => $clientId,
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ];

        // Copia alcuni header rilevanti dal client
        if ($accept = $request->header('Accept')) {
            $headers['Accept'] = $accept;
        }
        if ($lang = $request->header('Accept-Language')) {
            $headers['Accept-Language'] = $lang;
        }

        $http = Http::withHeaders($headers);

        // Gestione body solo se non GET
        $options = [
            'query' => $request->query(),
        ];

        if ($method !== 'GET') {
            $body = $request->getContent();
            if ($body !== '') {
                $contentType = $request->header('Content-Type', 'text/plain');
                $http = $http->withBody($body, $contentType);
            }
        }

        $response = $http->send($method, $url, $options);

        $raw = [
            'status' => $response->status(),
            'body' => $response->body(),
            'headers' => [
                'Content-Type' => $response->header('Content-Type') ?? 'application/json',
                'Cache-Control' => $response->header('Cache-Control') ?? 'public, max-age='.$cacheTtl,
            ],
        ];

        if ($isCacheable && $response->successful()) {
            Cache::put($cacheKey, $raw, $cacheTtl);
        }

        return $this->buildResponseFromArray($raw, false);
    }

    private function cacheKey(string $method, string $path, Request $request): string
    {
        $parts = [
            'igdb',
            $method,
            $path,
            http_build_query($request->query()),
        ];
        if ($method !== 'GET') {
            $parts[] = $request->getContent();
        }
        return implode(':', array_map(fn ($p) => sha1($p), $parts));
    }

    private function buildResponseFromArray(array $payload, bool $fromCache): Response
    {
        return response($payload['body'], $payload['status'])
            ->withHeaders($payload['headers'] + [
                'X-IGDB-Proxy-Cached' => $fromCache ? '1' : '0',
            ]);
    }
}
