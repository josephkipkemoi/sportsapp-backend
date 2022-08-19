<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'session_id' => ['required'],
            'user_id' => ['required'],
            'stake_amount' => ['required'],
            'total_odds' => ['required'],
            'final_payout' => ['required'],
            'bet_status' => ['string']
        ];
    }
}
