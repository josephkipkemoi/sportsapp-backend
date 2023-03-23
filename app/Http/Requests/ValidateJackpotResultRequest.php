<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateJackpotResultRequest extends FormRequest
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
            'picked_games_count' => ['required', 'numeric'],
            'market_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric'],
            'jackpot_bet_id' => ['required', 'string']
        ];
    }
}
