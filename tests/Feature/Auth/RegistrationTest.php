<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register()
    {
        $response = $this->post('api/register', [
            'phone_number' => '254700545727',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertOk();
    }

    public function test_new_users_cannot_register_with_invalid_number()
    {
        $response = $this->post('api/register', [
            'phone_number' => '25470054572',
            'password' => 'oi',
            'password_confirmation' => 'oi',
        ]);
      
        $response->assertStatus(302);
    }
}
