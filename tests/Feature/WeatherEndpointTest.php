<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class WeatherEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_endpoint_returns_data(): void
    {
        Http::fake([
            'api.weatherapi.com/*' => Http::response([
                'location' => ['name' => 'Perth'],
                'current' => ['temp_c' => 20],
            ], 200),
        ]);

        Cache::flush();
        $response = $this->getJson('/api/v1/weather');
        $response->assertOk()->assertJsonPath('data.location.name', 'Perth');
    }
}
