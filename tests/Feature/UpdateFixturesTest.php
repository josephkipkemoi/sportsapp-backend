<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateFixturesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_update_fixtures_automatically()
    {
        $response = $this->post('api/admin/update/fixtures/odds');
     
        $response->assertStatus(200);
    }
}
