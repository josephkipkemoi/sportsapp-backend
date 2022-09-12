<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MpesaTransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_mpesa_transaction()
    {
        // $response = $this->post('api/mpesa/hooks', [
        //     'test' => 123
        // ]);

        // $response->assertStatus(200);
    }

    public function test_can_get_transactions()
    {
        // $response = $this->get('api/mpesa');

        // $response->assertOk();
    }

    public function test_can_send_mpesa_push_notification()
    {
        // $response = $this->post('api/mpesa/push', [
        //         'token' => 'ASDasda',
        //         'phone_number' => 254700545727,
        //         'amount' => 1
        //     ]);
        // // dd($response);
        // $response->assertOk();
    }

    public function test_can_get_mpesa_auth_tokens()
    {
        // $response = $this->get('api/mpesa/auth');

        // $response->assertOk();
    }

    public function test_can_post_mpesa_hook()
    {
        $response = $this->post('api/mpesa/hooks');
        dd($response);
        $response->assertOk();
    }
}
