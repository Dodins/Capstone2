<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\CrimeLocation;
use App\Models\Concern;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DashboardAdminController extends Controller
{
    public function dashboard(): Response
    {
        $residents = Resident::where('is_verified', true)->get();
        $residentCount = $residents->count();
        $crimeLocation = CrimeLocation::all();
        $concerns = Concern::whereNotNull('priority')->whereNotNull('status')->get();
        $highConcerns = Concern::where('priority', 'high')->count();
        $mediumConcerns = Concern::where('priority', 'medium')->count();
        $lowConcerns = Concern::where('priority', 'low')->count();

        $newConcerns = Concern::where('status', 'new')->count();
        $investigatingConcerns = Concern::whereIn('status', ['under_review', 'pending_action', 'resolved'])->count();
        $completedConcerns = Concern::where('status', 'completed')->count();
        $rejectedConcerns = Concern::where('status', 'rejected')->count();
        return Inertia::render('Dashboard', [
            'residents' => $residents,
            'residentCount' => $residentCount,
            'crimeLocation' => $crimeLocation,
            'concerns' => $concerns,
            'highConcerns' => $highConcerns,
            'mediumConcerns' => $mediumConcerns,
            'lowConcerns' => $lowConcerns,

            'newConcerns' => $newConcerns,
            'investigatingConcerns' => $investigatingConcerns,
            'completedConcerns' => $completedConcerns,
            'rejectedConcerns' => $rejectedConcerns,
        ]);
    }
}
