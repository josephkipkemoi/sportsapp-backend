<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(StoreCartRequest $request, Cart $cart)
    {
        $user_id = $request->validated()['user_id'];
        $stake_amount = $request->validated()['bet_amount'];
        $user = User::find($user_id);
        $user_bonus = $user->balance->bonus;
        $user_balance = $user->balance->amount;

        if($user_balance >= $stake_amount) {
            $checkout_data = $cart->create($request->validated());
            $user->balance()->first()->decrement('amount', $stake_amount);

            return response()->json([
                'data' => $checkout_data
            ]);
        }

        if($user_balance < $stake_amount && $user_bonus >= $stake_amount) {
            $checkout_data = $cart->create($request->validated());
            $user->balance()->first()->decrement('bonus', $stake_amount);

            return response()->json([
                'data' => $checkout_data
            ]);
        }

        return response()->json([
            "message" => "Insufficient balance, please top up to continue."
        ], 400);
    }

    public function index(Cart $cart, Request $request)
    {
        if($request->query('bet_status') == 'All') {
            return $cart->where('user_id', $request->query('user_id'))
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        }

        if($request->query('bet_status') == 'Settled') {
            return $cart->where('user_id', $request->query('user_id'))
            ->whereNot('bet_status', "Active")
            ->whereNot('bet_status', "Pending")
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        }

        if($request->query('bet_status') == 'Unsettled') {
            return $cart->where('user_id', $request->query('user_id'))
            ->whereNot('bet_status', "Lost")
            ->whereNot('bet_status', "Won")
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        }

        $carts = $cart
                    ->where('user_id', $request->query('user_id'))
                    ->where('bet_status', $request->query('bet_status'))
                    ->where('bet_status', $request->query('bet_status'))
                    ->orderBy('created_at', 'DESC')
                    ->paginate(8);
        
        return $carts;
    }

    public function show(Cart $cart, Request $request)
    {
        $carts = $cart
                    ->where('cart_id', $request->query('cart_id'))
                    ->where('bet_status', $request->query('bet_status'))
                    ->firstOrFail();

        return response()
                    ->json([
                        'cart' => $carts
                    ]);
    }

    public function delete(Request $request, Cart $cart)
    {
       return $cart->where('user_id', $request->user_id)
        ->where('cart_id', $request->cart_id)
        ->delete();
    }

    public function update(Cart $cart)
    {
        return $cart->whereIn('bet_status', ['Active', 'Pending'])->update(['bet_status' => 'Lost']);  
    }

}
