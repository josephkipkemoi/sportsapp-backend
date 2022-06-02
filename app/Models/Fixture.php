<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'fixture_country',
        'fixture_date',
        'fixture_league_name',
        'fixture_logo',
        'home_team',
        'away_team',
    ];
}
