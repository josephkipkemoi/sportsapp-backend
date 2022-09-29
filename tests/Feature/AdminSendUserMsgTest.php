<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminSendUserMsgTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_send_user_message_feedback()
    {
        $user = User::factory()->create();

        $response = $this->post('api/admin/users/message', [
            'phone_number' => $user->phone_number,
            'message' => $this->faker()->text(),
            'original_message' => $this->faker()->text(),
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_get_message_from_admin()
    {
        $user = User::factory()->create();

        $response = $this->get("api/users/messages?phone_number={$user->phone_number}");

        $response->assertOk();
    }
}
