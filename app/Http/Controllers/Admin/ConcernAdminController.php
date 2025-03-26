<?php

namespace App\Http\Controllers\Admin;

use App\Events\Resident\SetPriorityEvent;
use App\Events\Resident\StatusTransitionUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\Concern;
use App\Models\ConcernStatusHistory;
use App\Models\User;
use App\Notifications\Resident\SetPriority;
use App\Notifications\Resident\StatusTransitionUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ConcernAdminController extends Controller
{
    public function setPriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high',
        ]);

        $concern = Concern::findOrFail($id);
        $concern->update([
            'priority' => $request->priority,
            'status' => 'new',
        ]);

        $getNote = ConcernStatusHistory::create([
            'user_id' => $concern->user_id,
            'concern_id' => $concern->id,
            'notes' => 'Concern accepted and set the priority to ' . $request->priority,
            'status' => 'new',
        ]);

        $authUser = User::find($concern->user_id);
        Notification::send($authUser, new SetPriority($concern));
        event(new SetPriorityEvent($concern));

        return response()->json([
            'message' => $getNote->notes,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $concern = Concern::findorFail($id);
        $currentStatus = $concern->status;

        $eligibleTransition = [
            'new' => 'under_review',
            'under_review' => 'pending_action',
            'pending_action' => 'resolved',
        ];

        $nextStatus = $eligibleTransition[$currentStatus] ?? null;

        if (!$nextStatus) {
            return response()->json([
                'message' => 'Unauthorized Transition'
            ], 403);
        }

        $data = [
            'user_id' => $concern->user_id,
            'concern_id' => $concern->id,
            'notes' => $request->notes,
            'status' => $nextStatus,
        ];

        if ($nextStatus === 'resolved') {
            $request->validate([
                'img_proof' => 'required|file|mimes:jpg,png,jpeg|max:2048',
            ]);
            if ($request->hasFile('img_proof')) {
                $filePath = $request->file('img_proof')->store('uploads', 'public');
                $imagePath = 'storage/' . $filePath;
                $data['img_proof'] = $imagePath;
            }
        }

        $concern->update(['status' => $nextStatus]);

        $concernUpdate = ConcernStatusHistory::create($data);

        Log::info("New concern status history created for concern ID: $id", [
            'data' => $data,
        ]);

        return response()->json([
            'concern' => $concernUpdate,
        ]);
    }

    public function reject($id)
    {
        $concern = Concern::findOrFail($id);

        $concern->update(['status' => 'rejected']);

        ConcernStatusHistory::create([
            'concern_id' => $concern->id,
            'status' => 'rejected',
            'notes' => 'This concern is being rejected due to insufficient information provided.',
        ]);

        return response()->json([
            'message' => 'Concern has been rejected successfully.',
        ]);
    }
}
