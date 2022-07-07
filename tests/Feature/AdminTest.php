<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_all_registered_users()
    {
        $user = User::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->get('api/admin/users');
 
        $response->assertStatus(200);
    }

    public function test_can_get_user_balance()
    {
        $user = User::factory()->create();

        $response = $this->get("api/admin/users/{$user->id}/profile");

        $response->assertOk();
    }
}
