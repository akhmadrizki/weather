<?php

declare(strict_types=1);

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Services\Weather\WeatherService;
use Illuminate\Http\JsonResponse;
use RuntimeException;

final class WeatherController extends Controller
{
    public function __construct(private readonly WeatherService $service) {}

    public function show(): JsonResponse
    {
        try {
            return response()->json($this->service->getCurrent());
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 503);
        }
    }
}
