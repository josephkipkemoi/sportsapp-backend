<?php

namespace App\Http\Controllers;

use App\Models\CustomFixture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CustomFixtureController extends Controller
{
    //
    public function fixture(CustomFixture $fixture)
    {
        return $fixture->paginate(20);
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
                'fixture_date' => date('Y-m-d h:i:s', strtotime($res->fixture->date)),
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
            'status' => 200,
            'message' => 'Created Successfully'
        ]);
    }

    public function post_odds(CustomFixture $fixture)
    {
        $fixture_ids = $fixture->take(25)->get('fixture_id');
 
        foreach($fixture_ids as $fixture_id)
        {
            $fix_id = $fixture_id->fixture_id; 

            $response = Http::withHeaders([
            // 'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
            // 'X-RapidAPI-Key' =>  'b2c138608fmsh6567bc9b793b465p1a4945jsnb15afccb7248'
            'x-apisports-key' => '9ed9fc9b6c13eab1282b3edd1592ad56'
            ])->get("https://v3.football.api-sports.io/odds?fixture=${fix_id}&bookmaker=8");

            foreach($response->object()->response as $val)
            {
             
                $fixture->where('fixture_id', $val->fixture->id)
                        ->update([
                            'odds' => json_encode($val->bookmakers[0]->bets)
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

    public function fixture_ids(CustomFixture $fixture)
    {
        return $fixture->whereNull('odds')->get('fixture_id');
    }

    public function fixture_odds($fixture_id, CustomFixture $fixture, Request $request)
    {
        return $fixture->where('fixture_id', $fixture_id)->update([
            'odds' => $request->input('odds')
        ]);
    }

    public function status(CustomFixture $fixture)
    {
       $fixture_date = $fixture->get('fixture_date')->count();
       $current_date = Carbon::now('Africa/Nairobi')->toDateTimeString();
        // dd($current_date , $fixture_date);
        // dd($fixture_date->gte( $current_date));
        $fixtures =$fixture->whereDate('fixture_date', '>' ,$current_date )->get('fixture_date')->count();
       
    }
}
