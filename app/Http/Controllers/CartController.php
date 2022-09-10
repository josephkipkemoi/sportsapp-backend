<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(StoreCartRequest $request, Cart $cart)
    {
        $cart->create($request->validated());

        return response()->json([
            'message' => 'Betslip posted'
        ]);
    }

    public function index(Cart $cart, Request $request)
    {
        if($request->query('bet_status') == 'All') {
            return $cart->where('user_id', $request->query('user_id'))
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        }

        $carts = $cart
                    ->where('user_id', $request->query('user_id'))
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

}
