<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Post $resource */
final class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Post $post */
        $post = $this->resource;

        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'author' => $post->user?->only(['id', 'name', 'email']),
        ];
    }
}
