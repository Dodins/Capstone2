<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ConcerUpdateStatusNotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $notifications = $user->notifications()
            ->whereIn('type', [
                'App\Notifications\Resident\StatusTransitionUpdate',
                'App\Notifications\Resident\SetPriority',
            ])
            ->latest()
            ->get();

        $groupedNotifications = [
            'today' => [],
            'yesterday' => [],
            'by_date' => [],
        ];

        foreach ($notifications as $notification) {
            $createdDate = Carbon::parse($notification->created_at);
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();

            if ($createdDate->isToday()) {
                $groupedNotifications['today'][] = $this->formatNotification($notification);
            } elseif ($createdDate->isYesterday()) {
                $groupedNotifications['yesterday'][] = $this->formatNotification($notification);
            } else {
                $dateString = $createdDate->format('F j, Y');
                if (!isset($groupedNotifications['by_date'][$dateString])) {
                    $groupedNotifications['by_date'][$dateString] = [];
                }
                $groupedNotifications['by_date'][$dateString][] = $this->formatNotification($notification);
            }
        }

        return response()->json(['grouped_notifications' => $groupedNotifications]);
    }

    private function formatNotification($notification)
    {
        $data = $notification->data;

        return [
            'id' => $data['id'] ?? 'No id',
            'status' => $data['status'] ?? 'No status',
            'title' => $data['title'] ?? 'No title',
            'message' => $data['message'] ?? 'No message',
            'date' => $notification['created_at'] ?? 'No date',
        ];
    }
}
