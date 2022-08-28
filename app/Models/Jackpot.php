<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jackpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'jp_time',
        'jp_home',
        'jp_away',
        'jp_home_odds',
        'jp_draw_odds',
        'jp_away_odds',
        'jp_market',
        'jp_active'
    ];

    protected $casts = [
        'jp_active' => 'boolean'
    ];
}
