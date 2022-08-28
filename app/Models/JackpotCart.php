<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'jp_picked',
        'user_id',
        'jp_market',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
