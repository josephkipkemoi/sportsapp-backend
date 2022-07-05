<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\ConsoleOutput;

class MpesaController extends Controller
{
    //
    public function index(Request $request, MpesaTransaction $transaction)
    {
        $endpointLipaNaMpesaOnline =  'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $c2bPayBill = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v2/simulate';
        // $timestamp = Carbon::now()->toDateTimeString();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 5XH53zBuAK6bdikzT2GG37sokxX9',
            'Content-Type' => 'application/json'
        ])->post($c2bPayBill, [
            'Command ID' => 'CustomerPayBillOnline',
            'Amount' => '5',
            'Msisdn' => '254700545727',
            'BillRefNumber' => '00000',
            'ShortCode' => '600247'         
        ]);
        // $data = $transaction->all();

        // return response()->json([
        //     'data' => $data
        // ]);
        // dd($response);
    }

    public function hook(Request $request, MpesaTransaction $transaction)
    {
        $message = [
            'ResponseCode' => '000000',
            'ResponseDesc' => 'success'
        ];

        $transaction->create([
            'data' => serialize($request->body)
        ]);

        return response()->json([
            'message' => $message
        ]);
    }
}
