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
        $response = $this->post('api/mpesa/hooks', [
            'test' => 123
        ]);
        dd($response);
        $response->assertStatus(200);
    }
}
