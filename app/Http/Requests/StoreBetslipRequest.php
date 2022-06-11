<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBetslipRequest extends FormRequest
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
            'session_id' => ['required'],
            'betslip_teams' => ['required'],
            'betslip_market' => ['required'],
            'betslip_odds' => ['required'],
            'betslip_picked' => ['required'],
        ];
    }
}
