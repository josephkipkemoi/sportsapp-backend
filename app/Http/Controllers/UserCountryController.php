<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserCountryController extends Controller
{
    //
    static function index()
    {
        // $response = Http::acceptJson()->get('http://ip-api.com/json');

        // return $response->object()->country;
        return "Kenya";
    }
}
