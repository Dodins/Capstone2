<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncomingReport extends Notification
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
        return ['database'];
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
        return [
            'report_id' => $this->concern->id,
            'user_id' => $this->concern->user_id,
            'message' => 'A new report has been submitted.',
            'name' => $this->concern->user->name . ' has submitted a report',
            'is_seen' => $this->concern->is_seen ? 'Seen' : 'Unseen',
            'created_at' => $this->concern->created_at,
        ];
    }
}
