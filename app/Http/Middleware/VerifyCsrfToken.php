<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        'https://infinite-coast-08848.herokuapp.com/api/login',
        'https://infinite-coast-08848.herokuapp.com/api/register',
        'http://localhost:3000/api/login',
        'http://localhost:3000/api/register'
    ];
}
