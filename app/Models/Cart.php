<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_id',
        'cart',
        'bet_status',
        'bet_amount',
        'possible_payout'
    ];

    protected $casts = [
        'cart' => 'array'
    ];
}
