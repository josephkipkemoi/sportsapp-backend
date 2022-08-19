<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function __invoke(CreateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->create($validated);

        return response()->json([
            'message' => 'Registration Successful'
        ]);
    }
}
