<?php

namespace App\Http\Controllers;

use App\Models\Betslip;
use Illuminate\Http\Request;

class BetslipCartController extends Controller
{
    //
    public function odds_total($session_id) 
    {
        $betslips = Betslip::where('session_id', $session_id)->get();

        $odds_total = 1;

        foreach($betslips as $betslip)
        {
            $odds_total *= $betslip->betslip_odds;          
        }
    
        return response()
                    ->json([
                        'odds_total' => $odds_total
                    ]);
    }
}
