<?php

namespace App\Events\Resident;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SetPriorityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $concern;
    /**
     * Create a new event instance.
     */
    public function __construct($concern)
    {
        $this->concern = $concern;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new Channel('concern' . '.' . $this->concern->user_id)];
    }

    public function broadcastAs()
    {
        return 'concern.event';
    }

    public function broadcastWith()
    {
        $messages = [
            'new' => ['Concern accepted', 'Your concern has been prioritized as ' . $this->concern->priority . '. Our team will review it soon. Stay tuned for updates.'],
            'rejected' => ['Concern rejected', 'Your concern has been rejected. If you have any questions, please contact support.'],
        ];
        $status = $this->concern->status;
        return [
            'user_id' => $this->concern->user_id,
            'status' => $status,
            'title' => $messages[$status][0] ?? 'Report Status Update',
            'message' => $messages[$status][1] ?? 'Your report status has been updated.',
            'date' => now(),
        ];
    }
}
