<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_cart_fixture()
    {
        $user = User::factory()->create();

        $response = $this->post('api/users/fixtures/cart', [
            'user_id' => $user->id,
            'cart_id' => 12,  
            'bet_amount' => 50000,
            'possible_payout' => 12000000000.97777,  
            'cart' => "[[
                'abc' => 'abc'
            ], [
                'bcd' => 'bcd'
            ]]"
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_posted_cart_fixtures()
    {
        $user = User::factory()->create();

        $this->post('api/users/fixtures/cart', [
            'user_id' => $user->id,
            'cart_id' => 12,    
            'bet_amount' => 100,
            'possible_payout' => 1200,  
            'cart' => "[[
                'abc' => 'abc'
            ], [
                'bcd' => 'bcd'
            ]]"
        ]);
  
        $response = $this->get("api/users/fixtures/carts?user_id={$user->id}&bet_status=Active");
  
        $response->assertOk();
    }

    public function test_can_get_posted_cart_fixture_by_id()
    {
        $user = User::factory()->create();

        $this->post('api/users/fixtures/cart', [
            'user_id' => $user->id,
            'cart_id' => 12,   
            'bet_amount' => 100,
            'possible_payout' => 1200,   
            'cart' => "[[
                'abc' => 'abc'
            ], [
                'bcd' => 'bcd'
            ]]"
        ]);

        $response = $this->get("api/users/fixtures/carts",[
            'cart_id' => 12
        ]);
 
        $response->assertOk();
    }
}
