<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticateUserController extends Controller
{
    //
    public function show(Request $request)
    {
        return $request->user();
    }

    public function index(Request $request, User $user)
    {
        $user_info = $user->where('id', $request->query('auth_id'))->firstOrFail();
        
        return response()
                    ->json([
                        'user' => $user_info
                    ]);
    }
}
