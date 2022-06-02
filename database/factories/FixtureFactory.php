<?php

namespace Database\Factories;

use App\Models\Fixture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fixture>
 */
class FixtureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fixture_id' => [$this->faker()->numberBetween(1000, 5000),$this->faker()->numberBetween(1000, 5000) ],
            'fixture_country' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_date' => [$this->faker()->date('Y-m-d', 'now'),$this->faker()->date('Y-m-d', 'now')],
            'fixture_league_name' => [$this->faker()->word(8),$this->faker()->word(8)],
            'fixture_logo' => [$this->faker()->imageUrl(),$this->faker()->imageUrl()],
            'home_team' => [$this->faker()->word(12),$this->faker()->word(12)],
            'away_team' => [$this->faker()->word(10),$this->faker()->word(10)],
        ];
    }

    protected $model = Fixture::class;
}
