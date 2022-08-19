<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\CheckoutCart;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutCartController extends Controller
{
    //
    public function store(CheckoutCart $checkout, StoreCheckoutRequest $request)
    {
        $data = $checkout->create([
            'session_id' => $request->validated()['session_id'],
            'user_id' => $request->validated()['user_id'],
            'stake_amount' => $request->validated()['stake_amount'],
            'total_odds' => $request->validated()['total_odds'],
            'final_payout' => $request->validated()['final_payout'] 
        ]);

        return response()->json([
            'data' => $data
        ]);
    }

    public function show(User $user, Request $request, CheckoutCart $checkout)
    {
       return $checkout
            ->where('user_id', $user->id)
            ->where('session_id', $request->session_id)
            ->paginate(5);
    }
}
