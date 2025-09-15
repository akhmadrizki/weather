<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserDetailResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $users = User::query()->latest()->paginate($request->integer('per_page', 10));

        return UserResource::collection($users);
    }

    public function show(User $user): JsonResource
    {
        $user->loadMissing('posts');

        return UserDetailResource::make($user);
    }
}
