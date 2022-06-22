<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialShareButtonsController extends Controller
{
    //
    public function index()
    {
        $shareComponent = \Share::page(
            'https://www.aribet.co.ke',
            'Share Betslip',
        )
        ->facebook()
        ->twitter()
        ->telegram()
        ->whatsapp();
        
        return $shareComponent;
    }
}
