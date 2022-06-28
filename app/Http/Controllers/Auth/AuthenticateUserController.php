<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticateUserController extends Controller
{
    //
    public function show(Request $request, Session $session, User $user)
    {
        $user_id = $session
                        ->where('payload', $request->query('us_s'))
                        ->firstOrFail()
                        ->user_id;
     
        $user_info = $user->where('id',$user_id)->get(['id', 'country_residence', 'email','phone_number']);
        
        return response()->json([
            'status' => 200,
            'user' => $user_info
        ]);
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
