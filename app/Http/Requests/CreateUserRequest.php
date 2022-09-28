<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'country_residence' => 'string',
            'email' => 'email', 
            'phone_number' => 'required | min:12 | max:12',
            'password' => 'required | min:4',
            'password_confirmation' => 'required | min:4',
            'agree_terms' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone_number.min' => 'Invalid mobile number format (e.g. 0700-000-000)',
            'phone_number.max' => 'Invalid mobile number format (e.g. 0700-000-000)',
            'password.min' => 'Password too short',
            'agree_terms.required' => 'You need to agree to terms by checking the box before proceeding.'
        ];
    }
}
