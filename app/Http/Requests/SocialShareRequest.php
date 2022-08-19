<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialShareRequest extends FormRequest
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
            'codes' => ['required'],
            'user_id' => ['numeric'],
            'share_code' => ['required', 'unique:social_shares']
        ];
    }
}
