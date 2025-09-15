<?php

declare(strict_types=1);

namespace App\Services\Weather;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final class WeatherService
{
    private const CACHE_KEY = 'weather.current.perth';

    private const CACHE_TTL = 900; // 15 minutes

    /**
     * Fetch current weather data for Perth from the Weather API.
     *
     * @return array<string, mixed>
     *
     * @throws RuntimeException if the API request fails
     */
    public function getCurrent(): array
    {
        /** @var array<string, mixed> $weatherData */
        $weatherData = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $apiKey = config('services.weather.api_key');
            $url = 'https://api.weatherapi.com/v1/current.json';
            $response = Http::timeout(5)->get($url, [
                'key' => $apiKey,
                'q' => 'Perth',
                'aqi' => 'no',
            ]);

            if ($response->failed()) {
                Log::error('Weather API failed', ['status' => $response->status(), 'body' => $response->body()]);
                throw new RuntimeException('Unable to fetch weather');
            }

            return $response->json();
        });

        return $weatherData;
    }
}
