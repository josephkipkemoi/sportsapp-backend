<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotMarketModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "market",
        "market_prize",
        "market_id",
        "market_active",
        "games_count"
    ];

    public function jackpotgames()
    {
        return $this->hasMany(JackpotGame::class, 'jackpot_market_id', 'market_id');
    }
}
