<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FixtureDateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_fixtuire_by_date()
    {
        $response = $this->get('api/soccer/fixtures?date=2022-08-07');

        $response->assertStatus(200);
    }
}
