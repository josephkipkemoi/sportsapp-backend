<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'message',
        'phone_number',
        'original_message',
    ];
}
