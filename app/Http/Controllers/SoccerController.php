<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SoccerController extends Controller
{
    //
    public function index(Request $request) 
    {
        $date = $request->query('date');

        $response = Http::withHeaders([
            // 'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
            // 'X-RapidAPI-Key' =>  'b2c138608fmsh6567bc9b793b465p1a4945jsnb15afccb7248',
            'x-apisports-key' => '9ed9fc9b6c13eab1282b3edd1592ad56'
        ])->get('https://v3.football.api-sports.io/fixtures?date=2022-08-07');

        dd($response->object()->response);
    }
}
