<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use MariusGelez\IGDBLaravel\ApiHelper;
use Symfony\Component\HttpFoundation\Response;

class IgdbProxyController extends Controller
{
    public function handle(Request $request, ?string $path = ''): Response
    {
        $cacheLifetime = (int) config('igdb.cache_lifetime');

        if (str_starts_with($path, '/events')) {
            $cacheLifetime = 0;
        }

        $query = $request->getContent();

        $cacheKey = config('igdb.cache_prefix', 'igdb_cache').'.'.md5($path.$query);

        if ($cacheLifetime === 0) {
            Cache::forget($cacheKey);
        }

        $cachedResponse = Cache::remember($cacheKey, $cacheLifetime, static function () use ($path, $query) {
            try {
                $response = Http::withOptions([
                    'base_uri' => ApiHelper::IGDB_BASE_URI,
                ])->withHeaders([
                    'Accept' => 'application/json',
                    'Client-ID' => config('igdb.credentials.client_id'),
                    'Authorization' => 'Bearer '.ApiHelper::retrieveAccessToken(),
                ])
                    ->withBody($query, 'plain/text')
                    ->dontTruncateExceptions()
                    ->retry(3, 100)
                    ->post($path);
            } catch (RequestException $exception) {
                $response = $exception->response;
            }

            return [
                'body' => $response->body(),
                'status' => $response->status(),
                'headers' => $response->headers(),
            ];
        });

        return new \Illuminate\Http\Response(
            $cachedResponse['body'],
            $cachedResponse['status'],
            $cachedResponse['headers']
        );
    }
}
