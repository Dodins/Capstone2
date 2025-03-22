<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\CrimeLocation;

class MapAdminController extends Controller
{
    public function map()
    {
        $crimeLocation = CrimeLocation::all();
        return Inertia::render('MapMain', [
            'crimeLocation' => $crimeLocation,
        ]);
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Incoming request data:', $request->all());

            $data = $request->validate([
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('crime_images', 'public');
                $data['image'] = $imagePath;
            }

            $marker = CrimeLocation::create($data);

            return response()->json(
                [
                    'message' => 'Marker saved successfully!',
                    'marker' => $marker,
                ],
                201,
            );
        } catch (ValidationException $e) {
            return response()->json(
                [
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            \Log::error('Error saving marker: ' . $e->getMessage());
            return response()->json(
                [
                    'message' => 'An error occurred while saving the marker',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id)
    {
        try {
            $marker = CrimeLocation::find($id);

            if (!$marker) {
                return response()->json(
                    [
                        'message' => 'Marker not found!',
                    ],
                    404,
                );
            }

            if ($marker->image) {
                Storage::disk('public')->delete($marker->image);
            }

            $marker->delete();

            return response()->json(
                [
                    'message' => 'Marker deleted successfully!',
                    'id' => $id,
                ],
                200,
            );
        } catch (\Exception $e) {
            \Log::error('Error deleting marker: ' . $e->getMessage());
            return response()->json(
                [
                    'message' => 'Error deleting marker',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
