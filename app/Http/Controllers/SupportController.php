<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostSupportRequest;
use App\Models\Support;

class SupportController extends Controller
{
    //
    public function store(PostSupportRequest $request, Support $support) 
    {
        $support->create($request->validated());

        return response()->json([
            'message' => 'Message Received. You will be contacted shortly'
        ]);
    }

    public function index(Support $support)
    {
        $messages = $support
                        ->orderBy('created_at', 'DESC')
                        ->get(['name', 'email', 'phone_number', 'message', 'betId']);

        return response()
                ->json([
                'messages' => $messages
                ]);
    }
}
