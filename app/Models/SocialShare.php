<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'codes',
        'share_code',
        'betslips'
    ];

    protected $casts = [
        'codes' => 'array'
    ];
}
