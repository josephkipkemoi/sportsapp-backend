<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team',
        'away_team',
        'home_odds',
        'draw_odds',
        'away_odds',
        'kick_off_time',
        'game_started',
        'game_ended'
    ];

    protected $dates = [
        'kick_off_time'
    ];

    public function jackpotmarket() 
    {
        return $this->belongsTo(JackpotMarketModel::class, 'market_id', 'jackpot_market_id');
    }
}
