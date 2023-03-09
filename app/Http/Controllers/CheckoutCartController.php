<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Balance;
use App\Models\CheckoutCart;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutCartController extends Controller
{
    //
    public function store(CheckoutCart $checkout, StoreCheckoutRequest $request)
    {
        $user_id = $request->validated()['user_id'];
        $stake_amount = $request->validated()['stake_amount'];
        $user = User::find($user_id);
        $user_bonus = $user->balance->bonus;
        $user_balance = $user->balance->amount;

        if($user_balance >= $stake_amount) {
            $checkout_data = $checkout->create($request->validated());
            $user->balance()->first()->decrement('amount', $stake_amount);

            return response()->json([
                'data' => $checkout_data
            ]);
        }

        if($user_balance < $stake_amount && $user_bonus >= $stake_amount) {
            $checkout_data = $checkout->create($request->validated());
            $user->balance()->first()->decrement('bonus', $stake_amount);

            return response()->json([
                'data' => $checkout_data
            ]);
        }

        return response()->json([
            "message" => "Insufficient balance, please top up to continue."
        ], 400);
      
    }

    public function show(User $user, Request $request, CheckoutCart $checkout)
    {
       return $checkout
            ->where('user_id', $user->id)
            ->where('session_id', $request->session_id)
            ->paginate(5);
    }
}
