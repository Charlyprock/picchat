<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UserWriteEv implements ShouldBroadcast , ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $write;
    public $emetteur_id;
    public $recepteur_id;

    public function __construct(bool $write, $emetteur_id, $recepteur_id)
    {
        $this->write = $write;
        $this->emetteur_id = $emetteur_id;
        $this->recepteur_id = $recepteur_id;
    }

    public function broadcastWith()
    {
        return [
            'write' => $this->write,
            'emetteur_id' => $this->emetteur_id
        ];
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('test-channel-' . $this->recepteur_id);
    }
}
