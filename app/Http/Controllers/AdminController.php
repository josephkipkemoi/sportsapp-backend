<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\JackpotRequest;
use App\Http\Requests\PostAdminMessageRequest;
use App\Models\AdminMessages;
use App\Models\Balance;
use App\Models\Cart;
use App\Models\CheckoutCart;
use App\Models\CustomFixture;
use App\Models\Jackpot;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    //
    public function index(User $user, Cart $checkout_cart)
    {
        $admin_id = $user->where('phone_number', 254700545727)->first()->id;
        $admin2_id = $user->where('phone_number', 254708177599)->first()->id;

        $users = $user->where('phone_number', '!=',25454)
                        ->where('phone_number', '!=',254708177599)
                        ->orderBy('created_at', 'DESC')
                        ->get();

        $carts = $checkout_cart->where('user_id', '!=', $admin_id)->where('user_id', '!=', $admin2_id)->get()->sum('bet_amount');
       
        $usersCount = $users->where('phone_number', '!=',254700545727)
                            ->where('phone_number', '!=',25454)
                            ->where('phone_number', '!=',254708177599)
                            ->count();
        
        $notPlaced = Balance::where('user_id', '!=', $admin_id)->whereNotNull('amount')->sum('amount');

        $totalReceived = $carts + $notPlaced;

        $avg = $totalReceived / $usersCount;
        
        return response()
                    ->json([
                        'users' => $users,
                        'wagers' => $carts,
                        'avg' => $avg,
                        'notPlaced' => $notPlaced,
                        'grandTotal' => $totalReceived,
                    ]);
    }

    public function show(User $user, Request $request, Cart $checkout_cart)
    {
        $user_profile = $user->where('id', $request->user_id)->latest()->first();
  
        $history_profile = $checkout_cart
                            ->where('user_id', $request->user_id)
                            ->orderBy('created_at', 'DESC')
                            ->get();

        $balance = $user->balance;

        $totalDonation = $checkout_cart
                            ->where('user_id', $request->user_id)
                            ->sum('bet_amount');
        return response()
                    ->json([
                        'user_profile' => $user_profile,
                        'history_profile' => $history_profile,
                        'balance' => $balance,
                        'total_donation' => $totalDonation,
                    ]);
    }

    public function update_bethistory(Cart $checkout_cart, Request $request)
    {
         $checkout_cart
                    ->where('user_id', $request->user_id)
                    ->where('cart_id', $request->session_id)
                    ->update([
                        'bet_status' => $request->input('bet_status')
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

    public function update_history_outcome(Cart $cart, Request $request)
    {
        return $cart->where('id', $request->input('id'))->update(['outcome' => $request->input('outcome')]);
    }

    public function update_user(User $user, Request $request)
    {
        return $user->where('id', $request->input('user_id'))->update(['phone_number' => $request->input('phone_number')]);
    }

    public function send_message(AdminMessages $message, PostAdminMessageRequest $request)
    {
        $message->create($request->validated());

        $user = User::where('id', $request->validated()['user_id'])->first();

        event(new MessageSent( $user ,$request->validated()['user_id'] ,$request->validated()['message'], Support::CUSTOMERCAREAGENT));

        return response()
        ->json([
            'message' => 'Event Sent'
        ]);
    }

    public function message_custom(Request $request, AdminMessages $message) 
    {
        return $message->where('phone_number',$request->input('phone_number'))
                        ->orderBy('created_at', 'asc')
                        ->get(['username', 'message', 'original_message', 'id']);
    }

    public function message_index()
    {
        return User::whereIn('id', Support::whereNotNull('user_id')->get('user_id'))->cursorPaginate(20);
    }

    public function message_show(Request $request, Support $message)
    {
        return $message->where('phone_number',$request->input('id'))->get(['message', 'user_id']); 
    }

    public function remove_user(Request $request, User $user)
    {
        return $user->where('id',$request->id)->delete();
    }

}
