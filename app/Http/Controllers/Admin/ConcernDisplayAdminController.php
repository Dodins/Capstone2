<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concern;

class ConcernDisplayAdminController extends Controller
{
    public function priorityConcerns($priority)
    {
        $allowedPriorities = ['low', 'medium', 'high'];
        $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed'];

        // Validate priority
        if (!in_array($priority, $allowedPriorities)) {
            abort(404, 'Invalid priority type');
        }

        // Get status from request, default to 'new' if not provided
        $status = request()->query('status', 'new');

        // Validate status
        if (!in_array($status, $allowedStatuses)) {
            abort(404, 'Invalid status type');
        }

        // Query for the specific priority and status
        $barangayConcerns = Concern::where('priority', $priority)
            ->where('status', $status)
            ->with('user')
            ->get();

        $tabs = $status;

        return response()->json([
            'title' => ucfirst($priority) . ' Priority Reports',
            'priority' => $priority,
            'status' => $status,
            'barangayConcerns' => $barangayConcerns,
            'tabs' => $tabs,
        ]);
    }
}
