<?php

namespace App\Http\Controllers;

use App\Models\CheckoutCart;
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
}
