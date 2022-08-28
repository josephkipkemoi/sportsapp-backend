<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JackpotRequest extends FormRequest
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
            'jp_time' => ['required'],
            'jp_home' => ['required'],
            'jp_away' => ['required'],
            'jp_home_odds' => ['required'],
            'jp_draw_odds' => ['required'],
            'jp_away_odds' => ['required'],
            'jp_market' => ['required'],
            'jp_active' => ['boolean']
        ];
    }
}
