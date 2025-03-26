<?php

namespace App\Notifications\Resident;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusTransitionUpdate extends Notification
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
