<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JackpotMarket>
 */
class JackpotMarketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            "market" => "Mega Jackpot",
            "market_prize" => 1000000,
            "market_id" => 201
        ];
    }
}
