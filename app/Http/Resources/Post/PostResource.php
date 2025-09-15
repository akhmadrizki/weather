<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Post $resource */
final class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Post $posts */
        $posts = $this->resource;

        return [
            'id' => $posts->id,
            'title' => $posts->title,
            'body' => $posts->body,
            'author' => [
                'id' => $posts->user?->id,
                'name' => $posts->user?->name,
                'email' => $posts->user?->email,
            ],
        ];
    }
}
