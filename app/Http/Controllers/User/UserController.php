<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function index(Request $request): JsonResponse
    {
        $users = User::query()->latest()->paginate($request->integer('per_page', 10));

        return response()->json($users);
    }
}
