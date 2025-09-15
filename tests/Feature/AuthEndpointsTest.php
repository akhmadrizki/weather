<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AuthEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receives_token(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertCreated()->assertJsonStructure(['token', 'user' => ['id', 'name', 'email']]);
    }

    public function test_login_with_invalid_credentials_fails(): void
    {
        User::factory()->create(['email' => 'foo@example.com']);
        $response = $this->postJson('/api/v1/login', [
            'email' => 'foo@example.com',
            'password' => 'wrong',
        ]);
        $response->assertStatus(422);
    }

    // Removed verification-dependent test after reverting email verification feature.
}
