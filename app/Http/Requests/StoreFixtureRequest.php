<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFixtureRequest extends FormRequest
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
            'fixture_id' => ['required'],
            'fixture_country' => ['required'],
            'fixture_date' => ['required'],
            'fixture_league_name' => ['required'],
            'fixture_logo' => ['required'],
            'home_team' => ['required'],
            'away_team' => ['required']
        ];
    }
}
