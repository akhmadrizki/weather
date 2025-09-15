<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read User $resource */
final class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'total_posts' => $user->posts->count(),
            'posts' => $user->posts->map(fn ($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
            ]),
        ];
    }
}
