<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotValidateResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_id',
        'user_id',
        'picked_games_count',
        'jackpot_bet_id'
    ];
}
