<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConcernResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $concerns = Concern::where('user_id', $user->id)->get();

        return $concerns->isEmpty()
            ? response()->json(['message' => 'There are currently no recorded concerns under your account.'], 200)
            : response()->json($concerns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $filePath = $request->file('evidence')->store('uploads', 'public');

        $concern =  Concern::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'location' => $request->location,
            'evidence' => $filePath,
        ]);

        return response()->json($concern);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = Auth::user();
        $concern = Concern::findOrFail($id);

        if ($concern->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($concern);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $concern = Concern::findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($concern->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $filePath = $request->file('evidence')->store('uploads', 'public');


        $concern->update([
            'description' => $request->description,
            'location' => $request->location,
            'evidence' => $filePath,
        ]);

        return response()->json(['message' => 'Concern updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concern = Concern::findOrFail($id);
        $user = Auth::user();

        if ($concern->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $concern->delete();

        return response()->json(['message' => 'Concern deleted successfully!']);
    }
}
