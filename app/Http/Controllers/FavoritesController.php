<?php

namespace App\Http\Controllers;

use App\Models\CustomFixture;
use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //
    public function store(Request $request, Favorites $favorites)
    {
        $fixture_ids = $favorites->where('fixture_id', $request->input("fixture_id"))->get();

        if($fixture_ids == null) 
        {
            $favorites->create([
                'user_id' => $request->input("user_id"),
                'fixture_id' => $request->input("fixture_id")
            ]);
        }

        return response()
                    ->json([
                        'message' => 'Favorites added'
                    ]);
    }

    public function show(Request $request, Favorites $favorites, CustomFixture $custom_fixture)
    {
        $response = $favorites->where('user_id', $request->user_id)->get('fixture_id');
    
        $data = [];

        foreach($response as $fixture)
        {
            $custom_fixture->where('fixture_id', $fixture->fixture_id)->get();

            array_push($data, $custom_fixture);
        }
        
        return response()
                    ->json([
                        'favorites' => $data
                    ]);
    }
}
