<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBalanceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    //
    public function store(User $user, StoreBalanceRequest $request)
    {
        // $user->balance()->create((array) new BalanceDTO(...$request->validated));
        $user->balance()->create([
            'amount' => $request->validated()['amount']
        ]);

        return response()
                    ->json([
                        'message' => 'Amount deposited successfully, you may now place your bet',
                    ]);
    }

    public function index(User $user)
    {
        $balance = $user->balance->amount;

        return response()
                    ->json([
                        'amount' => $balance
                    ]);
    }
}
