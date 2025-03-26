<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Carbon;

class AnnouncementAdminController extends Controller
{
    public function createAnnouncement(): Response
    {
        return Inertia::render('Announcement/CreateAnnouncement');
    }

    public function editAnnouncement($id): Response
    {
        $announcement = Announcement::findOrFail($id);
        return Inertia::render('Announcement/EditAnnouncement', [
            'announcement' => $announcement,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $announcements = Announcement::all()->map(function ($announcement) {
            return [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'description' => $announcement->description,
                'created_at' => Carbon::parse($announcement->created_at)->format('F j, Y \a\t h:i A'), // "January 1, 2025 at 12:45 PM"
            ];
        });

        return Inertia::render('Announcement/Announcement', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $announcement = Announcement::create($request->all());

        return redirect()->route('announcement');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return response()->json($announcement);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found.'], 404);
        }
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return redirect()->route('announcement');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(
                [
                    'message' => 'Announcement not found.',
                ],
                404,
            );
        }

        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted successfully.',
        ]);
    }
}
