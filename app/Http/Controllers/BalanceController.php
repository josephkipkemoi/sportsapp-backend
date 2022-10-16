<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBalanceRequest;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    //
    public function store(StoreBalanceRequest $request, Balance $balance)
    {
        $balance->where('user_id', $request->validated()['user_id'])->increment('amount', $request->validated()['amount']);

        return response()
                    ->json([
                        'message' => 'Amount deposited successfully, you may now place your bet',
                    ]);
    }

    public function index(Balance $balance, Request $request)
    {
        $balance_amount = $balance
                        ->where('user_id', $request->input('user_id'))
                        ->latest()->first()->amount;

        return response()
                    ->json([
                        'amount' => $balance_amount,
                        'bonus' => 0,
                        'currency' => Balance::KENYASHILLINGCURRENCY
                    ]);
    }

    public function show(User $user)
    {
        $balance = $user->balance()->paginate(5);

        return response()
                    ->json([
                        'balances' => $balance
                    ]);
    }
 
    public function deposits(User $user)
    {
        $balance = $user->balance()->whereNot('amount', 0)->paginate(5);

        return response()
                    ->json([
                        'balances' => $balance
                    ]);
    }

    public function decrement(User $user, StoreBalanceRequest $request)
    {
        $user->balance()->decrement('amount', $request->validated()['amount']);

        return response()
                    ->json([
                        'message' => 'Success'
                    ]);
    }   
}
