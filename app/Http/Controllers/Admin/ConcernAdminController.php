<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use App\Models\ConcernStatusHistory;
use Illuminate\Http\Request;

class ConcernAdminController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
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
            'concern_id' => $concern->id,
            'notes' => $request->notes,
            'status' => $nextStatus,
            'auto_message' => "The concern is now transitioning from $currentStatus to $nextStatus.",
        ];

        if ($nextStatus === 'resolved') {
            $request->validate([
                'img_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $filePath = $request->file('img_proof')->store('uploads', 'public');
            $data['img_proof'] = $filePath;
        }

        $concern->update(['status' => $nextStatus]);

        $concernUpdate = ConcernStatusHistory::create($data);

        return response()->json([
            'concern' => $concernUpdate,
        ]);
    }
}
