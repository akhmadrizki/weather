<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read User $resource */
final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $users */
        $users = $this->resource;

        return [
            'id' => $users->id,
            'name' => $users->name,
            'email' => $users->email,
            'total_posts' => $users->count_posts,
        ];
    }
}
