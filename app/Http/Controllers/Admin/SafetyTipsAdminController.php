<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafetyTips;

class SafetyTipsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SafetyTips::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $safetyTips = SafetyTips::create(
            $request->validate([
                'category' => 'required|string',
                'heading' => 'required|string',
                'description' => 'required|string',
            ]),
        );

        return response()->json($safetyTips, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $safetyTips = SafetyTips::find($id);

        if (!$safetyTips) {
            return response()->json(
                [
                    'message' => 'Safety tips not found',
                ],
                404,
            );
        }

        return response()->json($safetyTips);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $safetyTips = SafetyTips::findOrFail($id);
        $safetyTips->update($request->all());

        return response()->json($safetyTips);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SafetyTips::findOrFail($id)->delete();
        return response()->json(['message' => 'Safety Tip deleted']);
    }
}
