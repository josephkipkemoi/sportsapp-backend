<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocialShareRequest;
use App\Models\CustomFixture;
use App\Models\Fixture;
use App\Models\SocialShare;
use Illuminate\Http\Request;

class SocialShareButtonsController extends Controller
{
    //
    public function index(Request $request)
    {

        $shareComponent = \Share::page(
            "https://www.pinaclebet.com/share/{$request->query('betSession')}",
            'Share Betslip',
        )
        ->facebook()
        ->twitter()
        ->telegram()
        ->whatsapp()
        ->getRawLinks();
       
        return response()->json([
            'links' => $shareComponent
        ]);
    }
    
    public function store(SocialShareRequest $request, SocialShare $social)
    {
        $response = $social->create($request->validated());

        return $response;
    }

    public function show(Request $request, SocialShare $social, CustomFixture $fixture)
    {
        return $social->where('share_code', $request->query('share_code'))->get(['codes', 'betslips'])->firstOrFail();
    }
}
