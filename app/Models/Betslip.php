<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'session_id',
        'betslip_teams',
        'betslip_odds',
        'betslip_market',
        'betslip_picked',
    ];
}
