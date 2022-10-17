<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    const BITCOINCURRENCY = 'BTC';
    const KENYASHILLINGCURRENCY = 'KES';
    const UGANDASHILLINGCURRENCY = 'UGS';
    const DOLLARCURRENCY = 'USD';

    protected $fillable = [
        'amount',
        'user_id',
        'receipt_no',
        'bonus'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
