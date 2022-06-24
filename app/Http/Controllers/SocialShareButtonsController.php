<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialShareButtonsController extends Controller
{
    //
    public function index(Request $request)
    {

        $shareComponent = \Share::page(
            "https://www.bet360.co.ke/?betSession={$request->query('betSession')}",
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
}
