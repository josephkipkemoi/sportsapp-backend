<?php

namespace App\Http\Controllers;

use App\Models\CustomFixture;
use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //
    public function store(Request $request, Favorites $favorites, CustomFixture $custom_fixture)
    {
        $custom_fixture
                    ->where('fixture_id', $request->input("fixture_id"))
                    ->update(['favorite_active' => true]);
                    
        return  $favorites->create([
                    'user_id' => $request->input("user_id"),
                    'fixture_id' => $request->input("fixture_id")
                ]);
    }

    public function show(Request $request, Favorites $favorites, CustomFixture $custom_fixture)
    {
        $response = $favorites->where('user_id', $request->user_id)->get('fixture_id');
    
        return $custom_fixture->whereIn('fixture_id', $response)->get();
    }

    public function remove($user_id, Favorites $favorites, CustomFixture $custom_fixture)
    {
        $fixtures = $favorites->where('user_id', $user_id)->get('fixture_id');

        $custom_fixture->whereIn('fixture_id', $fixtures)->update(['favorite_active' => false]);

        return $favorites->where('user_id', $user_id)->delete();
    }

    public function delete($user_id, $fixture_id, Favorites $favorites, CustomFixture $custom_fixture)
    {
        $custom_fixture->where('fixture_id', $fixture_id)->update(['favorite_active' => false]);

        return $favorites->where('user_id' ,$user_id)->where('fixture_id', $fixture_id )->delete();
    }
}
