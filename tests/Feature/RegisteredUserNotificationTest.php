<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisteredUserNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_notification_after_registration()
    {
        $user = User::factory()->create();

        $response = $this->get("api/notifications/users?u_id={$user->id}");

        $response->assertStatus(200);
    }
    
    public function test_can_update_notifications_to_read()
    {
        $user = User::factory()->create();

        $response = $this->get("api/notifications/users?u_id={$user->id}&status=markRead");

        $response->assertOk();
    }
}
