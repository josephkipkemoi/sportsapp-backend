<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticatedUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_authenticated_user()
    {
        $user = $this->post('api/register', [
            'country_residence' => 'Kenya',
            'email' => $this->faker()->email(),
            'phone_number' => '0700545727',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        
        $response = $this->get("api/user?us_s={$user->getData()->session_payload}");
 
        $response->assertStatus(200);
    }
}
