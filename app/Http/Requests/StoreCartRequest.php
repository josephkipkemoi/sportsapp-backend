<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'user_id' => ['numeric'],
            'cart_id' => ['numeric', 'required'],
            'cart' => ['required'],
            'possible_payout' => ['required', 'numeric'],
            'bet_amount' => ['required', 'numeric'],
            'bet_status' => ['string']
        ];
    }
}
