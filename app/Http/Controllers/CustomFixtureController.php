<?php

namespace App\Http\Controllers;

use App\Models\CustomFixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomFixtureController extends Controller
{
    //
    public function fixture(CustomFixture $fixture)
    {
        $response = $fixture->get(['fixture_id', 'fixture_date', 'league_name', 'country', 'home', 'away', 'logo', 'flag', 'odds']);
        $custom_fixture = $fixture->where('fixture_id', 962132022)->latest()->first();
        
        $data = [];

        foreach($response as $fix)
        {
            $fix->unserialized_odds = unserialize(($fix->odds));
            array_push($data, $fix);
        }
  
        return response()->json([
            'fixtures' => $data,
            'custom_fixture' => $custom_fixture
        ]);
    }
 
    public function post_fixture(CustomFixture $fixture)
    {
         $response = Http::withHeaders([
            // 'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
            // 'X-RapidAPI-Key' =>  'b2c138608fmsh6567bc9b793b465p1a4945jsnb15afccb7248',
            'x-apisports-key' => '9ed9fc9b6c13eab1282b3edd1592ad56'
        ])->get('https://v3.football.api-sports.io/fixtures?next=50');

        foreach($response->object()->response as $res)
        {
            $data[] = array(
                'fixture_id' => $res->fixture->id,
                'fixture_date' => $res->fixture->date,
                'league_name' => $res->league->name,
                'country' => $res->league->country,
                'logo' => $res->league->logo,
                'flag' => $res->league->flag,
                'league_round' => $res->league->round,
                'home' => $res->teams->home->name,
                'away' => $res->teams->away->name,
            );
        }

        if($fixture->exists())
        {
            $fixture->update($data);
        } 
        else
        {
            $fixture->insert($data);
        }

        return response()->json([
            'message' => 'Created Successfully'
        ]);
    }

    public function post_odds(CustomFixture $fixture)
    {
        $fixture_ids = $fixture->take(2)->get('fixture_id');

        foreach($fixture_ids as $fixture_id)
        {
            $fix_id = $fixture_id->fixture_id; 

            $response = Http::withHeaders([
            // 'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
            // 'X-RapidAPI-Key' =>  'b2c138608fmsh6567bc9b793b465p1a4945jsnb15afccb7248'
            'x-apisports-key' => '9ed9fc9b6c13eab1282b3edd1592ad56'
            ])->get("https://v3.football.api-sports.io/odds?fixture=${fix_id}&bookmaker=8");
      
            // $data[] = array(
            //     'odds' => $response->object()->response
            // );

            foreach($response->object()->response as $val)
            {
           
                $fixture->where('fixture_id', $val->fixture->id)
                        ->update([
                            'odds' => serialize($val)
                        ]);
            }
        }
      
        return response()
                ->json([
                    'message' => 'Odds posted'
                ]);
    }

    public function show(Request $request, CustomFixture $fixture)
    {
        $response = $fixture->where('fixture_id', $request->fixture_id)->get()->first();

        return response()
                    ->json([
                        'data' => $response
                    ]);
    }
   
    public function search(Request $request, CustomFixture $fixture)
    {     
        $response = $fixture
                        ->where('home', $request->query('q'))
                        ->orWhere('away', $request->query('q'))
                        ->get();

        return response()
                    ->json([
                        'data' => $response
                    ]);
    }
}
