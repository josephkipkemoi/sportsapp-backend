<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostOddsRequest;
use App\Models\Odd;
use Illuminate\Http\Request;

class OddController extends Controller
{
    //
    public function store(PostOddsRequest $request, Odd $odd)
    {
        $serialized_data = serialize($request->data);

        $odd->create([
            'data' => $serialized_data
        ]);
    }

    public function index()
    {
        $odds = Odd::get('data');

        $unserialized = [];

        foreach($odds as $odd)
        {
            array_push($unserialized, unserialize($odd->data));
        }
   
        return response()->json([
            'data' => $unserialized
        ]);
    }
}
