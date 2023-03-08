<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jackpot_market_id',
        'game_id',
        'picked',
        'outcome'
    ];
}
