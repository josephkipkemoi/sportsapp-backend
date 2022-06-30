<?php

namespace App\Http\Controllers;

use App\Models\CheckoutCart;
use App\Models\User;
use Illuminate\Http\Request;

class BetslipHistoryController extends Controller
{
    //
    public function show(CheckoutCart $checkout, User $user)
    {
        $checkout_history = $checkout
                                ->where('user_id', $user->id)
                                ->orderBy('created_at', 'DESC')
                                ->paginate(5);

        return response()->json([
            'data' => $checkout_history
        ]);
    }
          
    public function index(CheckoutCart $checkout, Request $request)
    {
        $bet_status = $request->query('bet_status'); 
        $checkout_history = $checkout
                                ->where('user_id', $request->user_id)
                                ->where('betslip_status', $bet_status)
                                ->orderBy('created_at', 'DESC')
                                ->paginate(5);
      
        return response()
                    ->json([
                        'data' => $checkout_history
                    ]);
    }

    public function update(Request $request, CheckoutCart $checkout)
    {
        $data = $checkout->where('user_id', $request->user_id)
                         ->where('session_id', $request->session_id)
                         ->update([
                            'betslip_status' => 'Lost'
                         ]);
        return response()
                        ->json([
                            'data' => $data
                        ]);
    }

    public function delete(Request $request, CheckoutCart $checkout)
    {
        $data = $checkout->where('user_id', $request->user_id)
                         ->where('session_id', $request->session_id)
                         ->delete();

        return response()
                    ->json([
                        'message' => 'Deleted succesfully',
                        'data' => $data
                    ]);
    }

    public function search_date(Request $request, CheckoutCart $checkout)
    {
        $data = $checkout->where('user_id', $request->user_id)
                        ->where('session_id', $request->session_id )
                        ->orWhereBetween('created_at', [$request->from_date, $request->to_date])
                        ->paginate(5);
                        
        return response()
                    ->json([
                        'data' => $data
                    ]);
    }
}
