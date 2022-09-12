<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\MpesaTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\ConsoleOutput;

class MpesaController extends Controller
{
    //
    public function index(Request $request, MpesaTransaction $transaction)
    {
      
        $data = $transaction->all();

        return response()->json([
            'data' => $data
        ]);

    }

    public function hook(Request $request, User $user, MpesaTransaction $transaction)
    {
        $message = [
            "MerchantRequestID" => "29115-34620561-1",    
            "CheckoutRequestID" => "ws_CO_191220191020363925",    
            "ResponseCode" => "0",    
            "ResponseDescription" => "Success. Request accepted for processing",    
            "CustomerMessage" => "Success. Request accepted for processing"
        ];

        if($request->getContent()) {
            $response = json_decode($request->getContent());

            $transaction->create([
                'data' =>$response
            ]);
        }
   
        // echo $response;

        // $mobile_number = $response->Body->stkCallback->CallbackMetadata->Item[4]->Value;
        // $amount = $response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
        // $receipt_no = $response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
  
    
        // $user
        //     ->where('phone_number', '=' , $mobile_number)
        //     ->balance([
        //         'amount' => $amount,
        //         'receipt_no' => $receipt_no
        //     ]);
        // dd($user);
        return response()->json($message);

    }

    public function push(Request $request)
    {
        $endpoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $short_code = 174379;
        $timestamp = $request->input('timestamp');
      
        $decoded =  $short_code . $passkey . $timestamp;
        
        $encoded = base64_encode($decoded);
        $token =  $request->input('token');

        $data =[
            'BusinessShortCode' => 174379,
            'Password' => 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjIwODAzMTEzNzUw',
            'Timestamp' =>  '20220803113750',
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->input('amount'),
            'PartyA' => $request->input('phone_number'),
            'PartyB' => 174379,
            'PhoneNumber' => $request->input('phone_number'),
            'CallBackURL' => 'https://api.pinaclebet.com/api/mpesa/hooks',
            'AccountReference' => 'Pinaclebet',
            'TransactionDesc' => 'Deposit'
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json'
        ])->post($endpoint, $data);
 
        return $response;
        
  }
 
  public function authMpesa()
  {
    $endpoint = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $reponse = Http::withBasicAuth(
    'Azs2KejU1ARvIL5JdJsARbV2gDrWmpOB',
    'hipGvFJbOxri330c'
    )->get($endpoint);
 
    return $reponse;
 
  }

  public function insert(MpesaTransaction $transaction, User $user, Balance $balance)
  {
    $t = "{\"Body\":{\"stkCallback\":{\"MerchantRequestID\":\"117463-25846902-1\",\"CheckoutRequestID\":\"ws_CO_12092022223804312700545727\",\"ResultCode\":0,\"ResultDesc\":\"The service request is processed successfully.\",\"CallbackMetadata\":{\"Item\":[{\"Name\":\"Amount\",\"Value\":1.00},{\"Name\":\"MpesaReceiptNumber\",\"Value\":\"QIC8V82TN0\"},{\"Name\":\"Balance\"},{\"Name\":\"TransactionDate\",\"Value\":20220912223930},{\"Name\":\"PhoneNumber\",\"Value\":254700545727}]}}}}";
    dd($t);
    // $mpesaTransactions =$transaction->all();

    // foreach($mpesaTransactions as $t)
    // {
    //     $amount = json_decode($t->data)->Body->stkCallback->CallbackMetadata->Item[0]->Value;
    //     $number = json_decode($t->data)->Body->stkCallback->CallbackMetadata->Item[4]->Value;
    //     $user_id = $user->where('phone_number', $number)->first()->id;

    //     $balance->where('user_id', $user_id)->increment('amount', $amount);
    // }  
    
    // return response()
    //             ->json([
    //                 'message' => 'Balance Update'
    //             ]);
  
   }
}
