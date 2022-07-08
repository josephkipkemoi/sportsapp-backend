<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\CheckoutCart;
use App\Models\CustomFixture;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(User $user)
    {
        $users = $user->get();
 
        return response()
                    ->json([
                        'users' => $users
                    ]);
    }

    public function show(User $user, Request $request, CheckoutCart $checkout_cart)
    {
        $user_profile = $user->where('id', $request->user_id)->latest()->first();
  
        $history_profile = $checkout_cart->where('user_id', $request->user_id)->get();

        $balance = $user->balance;

        return response()
                    ->json([
                        'user_profile' => $user_profile,
                        'history_profile' => $history_profile,
                        'balance' => $balance
                    ]);
    }

    public function update_bethistory(CheckoutCart $checkout_cart, Request $request)
    {
         $checkout_cart
                    ->where('user_id', $request->user_id)
                    ->where('session_id', $request->session_id)
                    ->update([
                        'betslip_status' => $request->input('bet_status')
                        ]);

        return response()
                    ->json([
                        'message' => 'Betslip status updated'
                    ]);
    }

    public function update_balance(Balance $balance, Request $request)
    {
        $balance
            ->where('user_id', $request->user_id)
            ->update([
                'amount' => $request->input('amount')
            ]);

        return response()
                    ->json([
                        'message' => 'Amount updated successfully'
                    ]);
    }

    public function custom_fixture(Request $request, CustomFixture $fixture)
    {
        $cstm_fixture = $fixture->where('fixture_id', $request->input('fixture_id'))->get();

        if($cstm_fixture == null)
        {
            $fixture->create([
                'fixture_id' => $request->input('fixture_id'),
                'fixture_date' => $request->input('fixture_date'),
                'league_name' => $request->input('league_name'),
                'country' => $request->input('country'),
                'home' => $request->input('home_team'),
                'away' => $request->input('away_team'),
                'home_odds' => $request->input('home_odds'),
                'draw_odds' => $request->input('draw_odds'),
                'away_odds' => $request->input('away_odds')
            ]);
        } else {
            $fixture->update([
                'fixture_date' => $request->input('fixture_date'),
                'league_name' => $request->input('league_name'),
                'country' => $request->input('country'),
                'home' => $request->input('home_team'),
                'away' => $request->input('away_team'),
                'home_odds' => $request->input('home_odds'),
                'draw_odds' => $request->input('draw_odds'),
                'away_odds' => $request->input('away_odds')
            ]);
        }
       

        return response()
                    ->json([
                        'message' => 'Fixture added succesfully'
                    ]);
    }
}
