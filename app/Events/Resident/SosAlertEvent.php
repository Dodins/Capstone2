<?php

namespace App\Events\Resident;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sos;

class SosAlertEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sos;

    public function __construct($sos)
    {
        $this->sos = $sos;
    }

    public function broadcastOn()
    {
        return new Channel('sos-alerts');
    }

    public function broadcastAs()
    {
        return 'sos.alerts';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->sos->id,
            'user_id' => $this->sos->user_id,
            'message' => $this->sos->message,
            'latitude' => $this->sos->latitude,
            'longitude' => $this->sos->longitude,
            'name' => $this->sos->user->name,
            'email' => $this->sos->user->email,
            'phone_number' => $this->sos->user->phone_number,
        ];
    }
}
