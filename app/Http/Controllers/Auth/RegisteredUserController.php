<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(CreateUserRequest $request)
    {
        $country = $request->validated()['country_residence'];
        $email = $request->validated()['email'];
        $phone_number = $request->validated()['phone_number'];
        $password = $request->validated()['password'];
        
        $user = User::create([
            'country_residence' => $country,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => Hash::make($password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
