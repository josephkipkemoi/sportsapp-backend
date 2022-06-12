<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\CheckoutCart;

class CheckoutCartController extends Controller
{
    //
    public function store(CheckoutCart $checkout, StoreCheckoutRequest $request)
    {
        $checkout->create([
            'session_id' => $request->validated()['session_id'],
            'user_id' => $request->validated()['user_id'],
            'stake_amount' => $request->validated()['stake_amount'],
            'total_odds' => $request->validated()['total_odds'],
            'final_payout' => $request->validated()['final_payout'] 
        ]);
    }
}
