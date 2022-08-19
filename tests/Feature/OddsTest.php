<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OddsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_odds()
    {
        $response = $this->post('api/odds', [
            'data' => [$this->faker()->text(),$this->faker()->text()],
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_odds()
    {
        $this->post('api/odds', [
            'data' => [$this->faker()->text(),$this->faker()->text()],
        ]);
        $this->post('api/odds', [
            'data' => [$this->faker()->text(),$this->faker()->text()],
        ]);
        $response = $this->get('api/odds');

        $response->assertOk();
    }
}

