<?php

declare(strict_types=1);

namespace App\Http\Resources\Weather;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array<string, mixed> $resource */
        $resource = $this->resource;

        return [
            'location' => $resource['location'],
            'current' => $resource['current'],
        ];
    }
}
