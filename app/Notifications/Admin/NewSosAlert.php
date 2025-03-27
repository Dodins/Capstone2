<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSosAlert extends Notification
{
    use Queueable;
    public $sos;

    /**
     * Create a new notification instance.
     */
    public function __construct($sos)
    {
        $this->sos = $sos;
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
        return [
            'sos_id' => $this->sos->id,
            'user_id' => $this->sos->user_id,
            'message' => $this->sos->message,
            'created_at' => $this->sos->created_at,
            'name' => $this->sos->user->name. ' needs help urgently!',
            'email' => $this->sos->user->email,
            'phone_number' => $this->sos->user->resident->phone_number,
            'is_seen' => $this->sos->is_seen ? 'Seen' : 'Unseen',
        ];
    }
}
