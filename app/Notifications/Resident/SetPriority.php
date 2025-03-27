<?php

namespace App\Notifications\Resident;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPriority extends Notification
{
    use Queueable;
    protected $concern;

    /**
     * Create a new notification instance.
     */
    public function __construct($concern)
    {
        $this->concern = $concern;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'new' => ['Concern accepted', 'Your concern has been prioritized as ' . $this->concern->priority . '. Our team will review it soon. Stay tuned for updates.'],
            'rejected' => ['Concern rejected', 'Your concern has been rejected. If you have any questions, please contact support.'],
        ];
        $status = $this->concern->status;
        return [
            'id' => Str::uuid(),
            'user_id' => $this->concern->user_id,
            'status' => $status,
            'title' => $messages[$status][0] ?? 'Report Status Update',
            'message' => $messages[$status][1] ?? 'Your report status has been updated.',
            'date' => now(),
        ];
    }
}
