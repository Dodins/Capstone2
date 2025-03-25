<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VerificationAdminController extends Controller
{
    public function verification()
    {
        $residents = Resident::where('is_verified', false )->where('application_status', 'pending')->get();
        return Inertia::render('UserVerification', [
            'residents' => $residents,
        ]);
    }

    public function accept($id)
    {
        $resident = Resident::findOrFail($id);

        $resident->update([
            'is_verified' => true,
            'application_status' => 'approved',
        ]);

        return response()->json([
            'message' => 'The person is verified',
        ]);
    }

    public function reject($id)
    {
        $resident = Resident::findOrFail($id);

        $resident->update([
            'is_verified' => false,
            'application_status' => 'rejected',
        ]);

        return response()->json([
            'message' => 'The person is rejected',
        ]);
    }
}
