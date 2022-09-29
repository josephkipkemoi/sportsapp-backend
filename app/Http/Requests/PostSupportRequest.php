<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSupportRequest extends FormRequest
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
            'name' => ['string'],
            'email' => ['email'],
            'phone_number' => 'required | min:10 | max:10',
            'message' => ['required'],
            'betId' => ['string'],
            // 'file' => ['required', 'mimes:pdf,png,jpg,jpeg', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'phone_number.min' => 'Invalid phone number format.',
            'phone_number.max' => 'Invalid phone number format.',
            'name.string' => 'Fill the form below',
            'phone_number.required' => 'Mobile number required',
            'message.required' => 'Write message on box below',
            'betId.string' => 'Insert BetId or your phone number'
        ];
    }
}
