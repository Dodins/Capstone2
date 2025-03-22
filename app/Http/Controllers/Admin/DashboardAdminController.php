<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\CrimeLocation;
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
        return Inertia::render('Dashboard', [
            'residents' => $residents,
            'residentCount' => $residentCount,
            'crimeLocation' => $crimeLocation,
        ]);
    }
}
