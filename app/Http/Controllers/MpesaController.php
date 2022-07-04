<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MpesaController extends Controller
{
    //
    public function store(Request $request)
    {
        $endpoint =  'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        
        $timestamp = Carbon::now()->toDateTimeString();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 5XH53zBuAK6bdikzT2GG37sokxX9',
            'Content-Type' => 'application/json'
        ])->post($endpoint, [
            'BusinessShortCode' => 174379,
            'Password' => 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjIwNzA0MTQwMDQ4',
            'Timestamp' => '20220704140048',
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => 254700545727,
            'PartyB' => 174379,
            'PhoneNumber' => 254700545727,
            'CallBackURL' => 'https://infinite-coast-08848.herokuapp.com/api/mpesa/transaction',
            'AccountReference' => 'BET360',
            'TransactionDesc' => 'Deposit'
        ]);

        
        dd($response);
    }
}
