<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomFixtureTest extends TestCase
{
    use WithFaker;
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_custom_fixture()
    {
        $response = $this->get('api/custom_fixture');
      
        $response->assertStatus(200);
    }


    public function test_can_post_fixture_details()
    {
    //    $response = $this->post('api/custom_fixture/post');

    //    $response->assertOk();
    }

    public function test_can_post_fixture_odds()
    {
        // $response = $this->post('api/custom_fixture/odds');

        // $response->assertOk();
    }

    public function test_can_get_fixture_by_id()
    {
        // $response = $this->get('api/custom_fixture/1');
        
        // $response->assertOk();
    }

    public function test_can_get_fixture_by_search()
    {
        // $response = $this->get('api/fixture/search?q=Arsenal');
        // // dd($response);
        // $response->assertOk();
    }

    public function test_can_get_fixture_ids_without_odds()
    {
        // $response = $this->get('api/fixtures/ids');

        // $response->assertOk();
    }

    public function test_can_post_fixture_odds_where_odds_is_null()
    {
        // $response = $this->patch('api/fixtures/custom_odds/2', [
        //     'odds' => "{}"
        // ]);

        // $response->assertOk();
    }

    public function test_can_de_activate_fixture()
    {
        $response = $this->patch('api/fixtures/status', [
            'fixture_active' => false
        ]);

        $response->assertOk();
    }
}
