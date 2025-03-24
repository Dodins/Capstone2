<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use App\Models\ConcernStatusHistory;
use Illuminate\Http\Request;

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

        $getNote =  ConcernStatusHistory::create([
            'concern_id' => $concern->id,
            'notes' => 'Concern accepted and set the priority to ' . $request->priority,
            'status' => 'new',
        ]);

        return response()->json([
            'message' => $getNote->notes,
        ]);
    }

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
