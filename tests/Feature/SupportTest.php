<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_send_message_to_customer_care()
    {
        $user = User::factory()->create();

        $response = $this->post('api/support', [
            'phone_number' => 0700545727,
            'message' => $this->faker()->text(),
            'betId' => $this->faker()->text(),
            'user_id' => $user->id,
            // 'file' => $this->faker()->image() 
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_messages_received()
    {
        $user = User::factory()->create();

        $res = $this->post('api/support', [
            'phone_number' => 0700545727,
            'message' => $this->faker()->text(),
            'betId' => $this->faker()->text(),
            'user_id' => $user->id,
            // 'file' => $this->faker()->image() 
        ]);

        $response = $this->get('api/support/messages');
  
        $response->assertOk();
    }
}
