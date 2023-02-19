<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJackpotGamesRequest extends FormRequest
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
            'home_team' => ['required', 'string'],
            'away_team' => ['required', 'string'],
            'home_odds' => ['required', 'numeric'],
            'draw_odds' => ['required', 'numeric'],
            'away_odds' => ['required', 'numeric'],
            'kick_off_time' => ['required'],
        ];
    }
}
