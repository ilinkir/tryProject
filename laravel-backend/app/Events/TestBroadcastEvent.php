<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestBroadcastEvent implements ShouldBroadcast
{
    use SerializesModels;

    public string $message;

    public string $broadcastQueue = 'ws-notif';

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('test');
    }

//    public function broadcastAs()
//    {
//        return 'test.event'; // in this case need to name chanel on front .test.event; default: class name - App\Events\TestBroadcastEvent;
//    }

//    public function broadcastWith()
//    {
//        return [
//            'message' => $this->message, // default - all public properties
//        ];
//    }
}
