<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PostEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_posts(): void
    {
        $user = User::factory()->create();
        Post::factory()->for($user)->count(3)->create();

        $response = $this->getJson('/api/v1/posts');
        $response->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_post_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'Test',
            'body' => 'Body',
        ]);
        $response->assertStatus(401);
    }
}
