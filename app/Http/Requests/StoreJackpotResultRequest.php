<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJackpotResultRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'jackpot_market_id' => ['required', 'numeric'],
            'game_id' => ['required', 'numeric'],
            'picked' => ['required', 'string'],
            'picked_games_count' => ['required', 'numeric'],
            'jackpot_bet_id' => ['required', 'string']
        ];
    }
}
