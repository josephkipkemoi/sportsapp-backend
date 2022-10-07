<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    const CUSTOMERCAREAGENT = 'CustomerCareAgent';
    const USERAGENT = 'UserAgent';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message',
        'file',
        'betId',
        'user_id'
    ];
}
