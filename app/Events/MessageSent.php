<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class MessageSent implements ShouldBroadcast    
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user, $user_id, $message, $sender;

    public function __construct($user , $user_id, $message, $sender)
    {
        //
        $this->user = $user;
        $this->message = $message;
        $this->user_id = $user_id;
        $this->sender = $sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    public function broadcastWith()
    {
        return [
            'id' => Str::orderedUuid(),
            'user_id' => $this->user_id,
            'user' => $this->user,
            'message' => $this->message,
            'timestamp' => now(),
            'sender' => $this->sender,
        ];
    }

    public function broadcastOn()
    {
        // 'message-channel'.$this->user_id, 
        // return new PrivateChannel('message-channel'.$this->user->id);
        return [    
                    'admin-channel',
                    'message-channel'.$this->user->id
                ];
    }

    public function broadcastAs()
    {
        return 'message.new';  
    }

  
}
