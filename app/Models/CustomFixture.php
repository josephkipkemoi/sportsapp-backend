<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'fixture_date',
        'league_name',
        'country',
        'home',
        'away',
        'logo',
        'flag',
        'league_round',
        'home_odds',
        'draw_odds',
        'away_odds',
        'favorite_active'
    ];

    protected $dates = [     
        'fixture_date'
    ];

    protected $casts = [
        'fixture_date' => 'datetime:Y-m-d H:i:s'
    ];
}
