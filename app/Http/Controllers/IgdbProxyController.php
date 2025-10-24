<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use MarcReichel\IGDBLaravel\ApiHelper;
use Symfony\Component\HttpFoundation\Response;

class IgdbProxyController extends Controller
{
    public function handle(Request $request, ?string $path = ''): Response
    {
        $cache_lifetime = (int)config('igdb.cache_lifetime');

        if (str_starts_with($path, '/events')) {
            $cache_lifetime = 0;
        }

        $query = $request->getContent();

        $cache_key = config('igdb.cache_prefix', 'igdb_cache').'.'.md5($path.$query);

        if ($cache_lifetime === 0) {
            Cache::forget($cache_key);
        }

        return Cache::remember($cache_key, $cache_lifetime, static function () use ($path, $query) {
            $response = Http::withOptions([
                'base_uri' => ApiHelper::IGDB_BASE_URI,
            ])->withHeaders([
                'Accept' => 'application/json',
                'Client-ID' => config('igdb.credentials.client_id'),
            ])->withHeaders([
                'Authorization' => 'Bearer '.ApiHelper::retrieveAccessToken(),
            ])
                ->withBody($query, 'plain/text')
                ->retry(3, 100)
                ->post($path);

            return new \Illuminate\Http\Response(
                $response->body(),
                $response->status(),
                $response->headers()
            );
        });
    }
}
