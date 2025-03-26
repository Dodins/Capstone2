<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use Inertia\Inertia;

class ConcernDisplayAdminController extends Controller
{

    public function incomingReports()
    {
        $incomingConcerns = Concern::whereNull('priority')->whereNull('status')->get();
        return Inertia::render('Reports/IncomingReports', ['incomingConcerns' => $incomingConcerns]);
    }

    public function highPriorityReports()
    {
        $allowedPriority = 'high';
        $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed', 'rejected'];

        $status = request()->query('status', 'new');

        if (!in_array($status, $allowedStatuses)) {
            abort(404, 'Invalid status type');
        }

        $concerns = Concern::where('status', $status)
            ->where('priority', $allowedPriority)
            ->with('user')
            ->get();
        return Inertia::render('Reports/HighPriorityReports', ['concerns' => $concerns]);
    }

    public function mediumPriorityReports()
    {
        $allowedPriority = 'medium';
        $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed', 'rejected'];

        $status = request()->query('status', 'new');

        if (!in_array($status, $allowedStatuses)) {
            abort(404, 'Invalid status type');
        }

        $concerns = Concern::where('status', $status)
            ->where('priority', $allowedPriority)
            ->with('user')
            ->get();
        return Inertia::render('Reports/MediumPriorityReports', ['concerns' => $concerns]);
    }

    // public function lowPriorityReports()
    // {
    //     $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed'];

    //     $status = request()->query('status', null);

    //     if (!in_array($status, $allowedStatuses)) {
    //         abort(404, 'Invalid status type');
    //     }

    //     $concerns = Concern::where('status', $status)
    //         ->with('user')
    //         ->get();

    //     return Inertia::render('Reports/LowPriorityReports', ['concerns' => $concerns]);
    // }

    public function lowPriorityReports()
    {
        $allowedPriority = 'low';
        $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed', 'rejected'];

        $status = request()->query('status', 'new');

        if (!in_array($status, $allowedStatuses)) {
            abort(404, 'Invalid status type');
        }

        $concerns = Concern::where('status', $status)
            ->where('priority', $allowedPriority)
            ->with('user')
            ->get();
        return Inertia::render('Reports/LowPriorityReports', ['concerns' => $concerns]);
    }

    public function priorityConcerns($priority)
    {
        $allowedPriorities = ['low', 'medium', 'high'];
        $allowedStatuses = ['new', 'under_review', 'pending_action', 'resolved', 'completed',];

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
