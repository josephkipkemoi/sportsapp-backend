<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJackpotMarketRequest extends FormRequest
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
            'market' => ['required', 'string'],
            'market_id' => ['required', 'numeric'],
            'market_prize' => ['required', 'numeric'],
            'games_count' => ['required', 'numeric'],
            'min_stake' => ['required', 'numeric']
        ];
    }
}
