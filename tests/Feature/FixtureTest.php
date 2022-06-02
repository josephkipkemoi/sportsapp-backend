<?php

namespace Tests\Feature;

use App\Models\Fixture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FixtureTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_post_fixture()
    {
        $response = $this->post("api/fixtures", [
            'fixture_id' => [$this->faker()->numberBetween(1000, 5000),$this->faker()->numberBetween(1000, 5000) ],
            'fixture_country' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_date' => [$this->faker()->date('Y-m-d', 'now'),$this->faker()->date('Y-m-d', 'now')],
            'fixture_league_name' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_logo' => [$this->faker()->imageUrl(),$this->faker()->imageUrl()],
            'home_team' => [$this->faker()->word(12),$this->faker()->word(12)],
            'away_team' => [$this->faker()->word(10),$this->faker()->word(10)],
        ]);

        $response->assertStatus(200);
    }

    public function test_can_get_fixtures()
    {
        $this->post("api/fixtures", [
            'fixture_id' => [$this->faker()->numberBetween(1000, 5000),$this->faker()->numberBetween(1000, 5000) ],
            'fixture_country' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_date' => [$this->faker()->date('Y-m-d', 'now'),$this->faker()->date('Y-m-d', 'now')],
            'fixture_league_name' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_logo' => [$this->faker()->imageUrl(),$this->faker()->imageUrl()],
            'home_team' => [$this->faker()->word(12),$this->faker()->word(12)],
            'away_team' => [$this->faker()->word(10),$this->faker()->word(10)],
        ]);
        $response = $this->get('api/fixtures');
        dd($response);
        $response->assertOk();
    }
}
