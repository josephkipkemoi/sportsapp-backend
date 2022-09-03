<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request, Session $session)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $session->create([
            'id' => auth()->user()->createToken('apiToken')->plainTextToken,
            'user_id' => auth()->user()->id,
            'payload' => auth()->user()->createToken('apiToken')->plainTextToken,
            'last_activity' => $_SERVER['REQUEST_TIME'],
        ]);

        return response()->json([
            'uu_id' => auth()->user(),
            'session_cookie' =>  auth()->user()->createToken('apiToken')->plainTextToken
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
