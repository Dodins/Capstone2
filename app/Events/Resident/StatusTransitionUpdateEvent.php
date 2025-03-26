<?php

namespace App\Events\Resident;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusTransitionUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  $concern;
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
        return [
            new Channel('update-status' . '.' . $this->concern->user_id),
            Log::info("StatusTransitionUpdateEvent fired for user: {$concern->user_id}, status: {$concern->status}"),
        ];
    }

    public function broadcastAs()
    {
        return 'update-status.event';
    }

    public function broadcastWith()
    {
        $messages = [
            'under_review' => ['Report Under Review', "We're currently reviewing your report. We will update you once we have more details."],
            'in_progress' => ['Report Investigating', 'Good news! Your report is now being processed. We will notify you once it is resolved.'],
            'resolved' => ['Report Resolved', 'Your report has been successfully resolved. If you need further assistance, feel free to reach out.'],
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
