<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\PostSupportRequest;
use App\Models\Support;
use App\Models\User;

class SupportController extends Controller
{
    //
    public function store(PostSupportRequest $request, Support $support) 
    {
        $user = User::where('id', $request->validated()['user_id'])->first();
        
        // $support->create($request->validated());

        event(new MessageSent($user , $request->validated()['user_id'], $request->validated()['message'], Support::USERAGENT));
      
        return response()
                    ->json([
                        'message' => 'Event Sent'
                    ]);
    }

    public function index(Support $support)
    {
        $messages = $support
                        ->orderBy('created_at', 'DESC')
                        ->get(['name', 'email', 'phone_number', 'message', 'betId', 'user_id']);

        return response()
                ->json([
                'messages' => $messages
                ]);
    }
}
