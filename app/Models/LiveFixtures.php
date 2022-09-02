<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveFixtures extends Model
{
    use HasFactory;

    protected $fillable = [
        'live_fixtures',
    ];

    protected $casts = [
        'live_fixtures' => 'array',
    ];
}
