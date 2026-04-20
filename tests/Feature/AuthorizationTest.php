<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create one admin and one regular user for tests
        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin.test@example.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
        ]);

        $this->regular = User::create([
            'name' => 'Regular User',
            'email' => 'user.test@example.com',
            'password' => Hash::make('secret'),
            'role' => 'user',
        ]);

        // Ensure a superadmin exists for authorization tests
        $this->superadmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperSecret123!'),
                'role' => 'superadmin',
            ]
        );
    }

    public function test_admin_can_access_users_index()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_users_index()
    {
        $response = $this->actingAs($this->regular)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_users_index()
    {
        $response = $this->actingAs($this->superadmin)->get(route('users.index'));
        $response->assertStatus(200);
    }
}
