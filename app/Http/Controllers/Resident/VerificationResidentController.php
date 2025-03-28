<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class VerificationResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user->resident) {

            return response()->json(['message' => 'Resident profile not found']);
        }

        $info = $user->resident;

        return response()->json($info);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'relationship' => 'required|string|max:255',
            'barangay_id_image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = auth()->user();
        $resident = $user->resident;

        // Check if the user has a resident record
        if ($resident) {
            if ($resident->application_status === 'pending') {
                return response()->json([
                    'message' => 'Request already exists. Please wait for admin approval.'
                ], 400);
            }

            if ($resident->application_status === 'approved') {
                return response()->json([
                    'message' => 'Your request has already been approved. No need to submit again.'
                ], 400);
            }

            if ($resident->application_status === 'rejected') {
                // If rejected, allow resubmission (delete old record and create a new one)
                $resident->delete();
            }
        }

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('barangay_id_image')) {
            $path = $request->file('barangay_id_image')->store('barangay_ids', 'public');
            $imagePath = 'storage/' . $path;
        }

        // Create a new resident record
        $newResident = Resident::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'email' => $user->email,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'relationship' => $request->relationship,
            'barangay_id_image' => $imagePath,
            'application_status' => 'pending', // Set status as pending
        ]);

        return response()->json([
            'message' => 'Request submitted successfully. Please wait for admin review.',
            'resident' => $newResident
        ], 201);
    }








    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
