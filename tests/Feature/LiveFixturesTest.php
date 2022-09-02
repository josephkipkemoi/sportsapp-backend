<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LiveFixturesTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_store_live_fixtures_from_api_football_api()
    {
        $data = json_encode([["fixture" => ["id" => 5]]]);

        $response = $this->post('api/fixtures/live', [
            'live_fixtures' => $data,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_stred_live_fixtures()
    {
        $response = $this->get('api/fixtures/live?fixtures=all');

        $response->assertOk();
    }
}
