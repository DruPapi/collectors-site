<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenEmail_WhenLogin_ThenOk(): void
    {
        $password = fake()->password();
        $user = User::factory()->password($password)->create();

        $response = $this->post('/api/auth/login', [
            'password' => $password,
            'email' => $user->email,
        ]);

        $response->assertOk();
    }

    public function test_GivenUsername_WhenLogin_ThenOk(): void
    {
        $password = fake()->password();
        $user = User::factory()->password($password)->create();

        $response = $this->post('/api/auth/login', [
            'password' => $password,
            'email' => $user->username,
        ]);

        $response->assertOk();
    }

    public function test_GivenInvalidPassword_WhenLogin_ThenFails(): void
    {
        $user = User::factory()
            ->create(['email' => 'exists@example.com', 'username' => 'Exists']);

        $response = $this->post('/api/auth/login', [
            'password' => 'wrong-password',
            'email' => $user->email,
        ]);

        $response->assertStatus(400);
    }

    public function test_GivenDeletedUser_WhenLogin_ThenFails(): void
    {
        $password = fake()->password();
        $user = User::factory()->password($password)->trashed()->create();

        $response = $this->post('/api/auth/login', [
            'password' => $password,
            'email' => $user->email,
        ]);

        $response->assertStatus(400);
    }

    public function test_GivenUnverifiedUser_WhenLogin_ThenFails(): void
    {
        $password = fake()->password();
        $user = User::factory()->password($password)->unverified()->create();

        $response = $this->post('/api/auth/login', [
            'password' => $password,
            'email' => $user->email,
        ]);

        $response->assertStatus(400);
    }

    public function test_GivenLoggedInUser_WhenLogsOut_ThenLoggedOut(): void
    {
        $password = fake()->password();
        $user = User::factory()->password($password)->create();
        Auth::login($user);

        $response = $this->post('/api/auth/logout');

        $response->assertOk();
        $this->assertFalse(Auth::check());
    }
}
