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
            ->increment('amount' , $request->input('amount'));

        return response()
                    ->json([
                        'message' => 'Amount updated successfully'
                    ]);
    }

    public function custom_fixture(Request $request, CustomFixture $fixture)
    {
        $fixture
            ->where('fixture_id', $request->input('fixture_id'))
            ->update([
                'home' => $request->input('home'),
                'away' => $request->input('away'),
                'league_name' => $request->input('league_name'),
                'country' => $request->input('country')
            ]);

        return response()
                    ->json([
                        'message' => 'Fixture updated succesfully'
                    ]);
    }

    public function fixture_ids(CustomFixture $fixture)
    {
        $fixtures = $fixture->whereNotNull('odds')->get('fixture_id');

        return response()
                    ->json([
                        'data' => $fixtures
                    ]);
    }

    public function remove(CustomFixture $fixture)
    {
        $fixture->whereNotNull('fixture_id')->delete();

        return response()
                    ->json([
                        'message' => 'Data deleted succesfully'
                    ]);
    }
}
