<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'stake_amount',
        'total_odds',
        'final_payout',
        'betslip_status'
    ];
}
