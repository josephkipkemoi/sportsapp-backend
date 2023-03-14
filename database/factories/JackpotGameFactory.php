<?php

namespace Database\Factories;

use App\Models\JackpotGame;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=JackpotGame>
 */
class JackpotGameFactory extends Factory
{
    protected $model = JackpotGame::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'jackpot_market_id' => 201,
            'home_team' => $this->faker->word(),
            'away_team' => $this->faker->word(),
            'home_odds' => $this->faker->numberBetween(1,5),
            'draw_odds' => $this->faker->numberBetween(1,5),
            'away_odds' => $this->faker->numberBetween(1,5),
            'kick_off_time' => $this->faker->date()
        ];
    }
}
