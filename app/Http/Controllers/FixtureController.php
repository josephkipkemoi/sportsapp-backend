<?php

namespace App\Http\Controllers;

use App\Custom\FixtureData;
use App\Http\Requests\StoreFixtureRequest;
use App\Models\Fixture;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FixtureController extends Controller
{
    //
    public function store(StoreFixtureRequest $request, Fixture $fixture) 
    {
        $serialized_fixture_id = serialize($request->fixture_id);
        $serialized_fixture_country = serialize($request->fixture_country);
        $serialized_fixture_date = serialize($request->fixture_date);
        $serialized_fixture_league_name = serialize($request->fixture_league_name);
        $serialized_fixture_logo = serialize($request->fixture_logo);
        $serialized_home_team = serialize($request->home_team);
        $serialized_away_team = serialize($request->away_team);
        $serialized_data = serialize($request->data);
        $fixture->create([
            'fixture_id' => $serialized_fixture_id,
            'fixture_country' => $serialized_fixture_country,
            'fixture_date' => $serialized_fixture_date,
            'fixture_league_name' => $serialized_fixture_league_name,
            'fixture_logo' => $serialized_fixture_logo,
            'home_team' => $serialized_home_team,
            'away_team' => $serialized_away_team,
            'data' => $serialized_data,
        ]);
    }

    public function index()
    {
        $response = Fixture::get([
            'fixture_id', 
            'fixture_country', 
            'fixture_date',
            'fixture_league_name',
            'fixture_logo',
            'home_team',
            'away_team',
        ]);

        $unserialized_fixture_id = json_encode(unserialize($response[0]->fixture_id));
        $unserialized_fixture_country = json_encode(unserialize($response[0]->fixture_country));
        $unserialized_fixture_date = json_encode(unserialize($response[0]->fixture_date));
        $unserialized_fixture_league_name = json_encode(unserialize($response[0]->fixture_league_name));
        $unserialized_fixture_logo = json_encode(unserialize($response[0]->fixture_logo));
        $unserialized_home_team = json_encode(unserialize($response[0]->home_team));
        $unserialized_away_team = json_encode(unserialize($response[0]->away_team));

        return response()->json([
            'fixture_id' => $unserialized_fixture_id,
            'fixture_country' => $unserialized_fixture_country,
            'fixture_date' => $unserialized_fixture_date,
            'fixture_league_name' => $unserialized_fixture_league_name,
            'fixture_logo' => $unserialized_fixture_logo,
            'home_team' => $unserialized_home_team,
            'away_team' => $unserialized_away_team,
        ]);
    }
}
