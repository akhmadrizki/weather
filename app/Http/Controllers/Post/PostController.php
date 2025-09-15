<?php

declare(strict_types=1);

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostDetailResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

final class PostController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $posts = Post::with('user')->latest()->paginate($request->integer('per_page', 10));

        return PostResource::collection($posts);
    }

    public function show(Post $post): JsonResource
    {
        $post->load('user');

        return PostDetailResource::make($post);
    }

    public function store(StorePostRequest $request): JsonResource
    {
        $post = Post::create([
            'title' => $request->string('title'),
            'body' => $request->string('body'),
            'user_id' => $request->user()?->id,
        ]);

        return PostDetailResource::make($post);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        Gate::authorize('update', $post);
        $post->fill($request->validated());
        $post->save();

        return PostDetailResource::make($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return response()->json(status: 204);
    }
}
