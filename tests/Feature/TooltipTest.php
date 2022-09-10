<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TooltipTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_user_tooltip_status()
    {
        $user = User::factory()->create();

        $response = $this->get("api/tooltips/status?user_id={$user->id}");

        $response->assertStatus(200);
    }

    public function test_can_post_user_tooltip_status()
    {
        $user = User::factory()->create();

        $response = $this->post("api/tooltips/users/{$user->id}/status/update", [
            'user_id' => $user->id,
            'tooltip_status' => false
        ]);

        $response->assertCreated();
    }
}
