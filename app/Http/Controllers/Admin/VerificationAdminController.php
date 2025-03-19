<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class VerificationAdminController extends Controller
{
    public function unverifiedResidents()
    {
        $residents = Resident::where('is_verified', false)->where('application_status', 'pending')->paginate(20);

        if($residents->isEmpty()){
            return response()->json(
                ['message' => 'No Pending Verification request',
            ]);
        }
        return response()->json($residents);
    }

    public function accept($id)
    {
        $resident = Resident::findOrFail($id);

        $resident->update([
            'is_verified' => true,
            'application_status' => 'approved',
        ]);

        return response()->json([
            'message' => 'The person is verified'
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
            'message' => 'The person is rejected'
        ]);
    }
}

