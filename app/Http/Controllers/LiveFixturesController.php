<?php

namespace App\Http\Controllers;

use App\Models\LiveFixtures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LiveFixturesController extends Controller
{
    //
    public function store(LiveFixtures $live_fixture)
    {
        $fixture = $live_fixture->latest()->first();

        $data = Http::withHeaders(['x-apisports-key' => '9ed9fc9b6c13eab1282b3edd1592ad56' ])
                            ->get('https://v3.football.api-sports.io/fixtures?live=all')
                            ->object()->response;

        if($fixture == null) {
            return $live_fixture->create([
                'live_fixtures' => $data
            ]);
        }

        return $fixture->update([
            'live_fixtures' => $data
        ]);

    }

    public function index(LiveFixtures $live_fixture, Request $request)
    {
        if($request->query('fixtures') == 'all') 
        {
            return $live_fixture->latest()->first();
        };
       
    }
}
