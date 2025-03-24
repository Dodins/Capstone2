<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Carbon;

class EventAdminController extends Controller
{
    public function calendar(): Response
    {
        $events = Event::with('schedules')->get();
        return Inertia::render('Calendar/Calendar', ['events' => $events]);
    }

    public function createEvent(): Response
    {
        return Inertia::render('Calendar/CreateEvent');
    }

    public function updateEvent($id): Response
    {
        $events = Event::with('schedules')->findOrFail($id);
        return Inertia::render('Calendar/EditEvent', ['events' => $events]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $event = Event::create([
                'title' => $request->title,
                'date' => $request->date,
                'description' => $request->description,
                'color' => $request->color,
            ]);

            // Save schedules if available
            $schedules = $request->input('schedule', []);
            if (!is_array($schedules)) {
                $schedules = [$schedules];
            }

            foreach ($schedules as $schedule) {
                $event->schedules()->create([
                    'start_time' => $schedule['start_time'] ?? null,
                    'end_time' => $schedule['end_time'] ?? null,
                    'description' => $schedule['description'] ?? null,
                ]);
            }

            return redirect()->route('calendar')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Find the event by its ID
        $event = Event::findOrFail($id);

        // Update the event details
        $event->update([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        $schedules = $request->input('schedule', []);
        if (!is_array($schedules)) {
            $schedules = [$schedules];
        }

        // Get the current schedule IDs to avoid duplication
        $currentScheduleIds = $event->schedules->pluck('id')->toArray();

        // Collect the IDs of the schedules in the request
        $updatedScheduleIds = [];

        // Loop through the incoming schedules
        foreach ($schedules as $schedule) {
            if (isset($schedule['id']) && in_array($schedule['id'], $currentScheduleIds)) {
                // If the schedule has an ID and it exists, update it
                $event
                    ->schedules()
                    ->where('id', $schedule['id'])
                    ->update([
                        'start_time' => $schedule['start_time'] ?? null,
                        'end_time' => $schedule['end_time'] ?? null,
                        'description' => $schedule['description'] ?? null,
                    ]);
                $updatedScheduleIds[] = $schedule['id']; // Add to updated IDs
            } else {
                // If no ID, create a new schedule
                $newSchedule = $event->schedules()->create([
                    'start_time' => $schedule['start_time'] ?? null,
                    'end_time' => $schedule['end_time'] ?? null,
                    'description' => $schedule['description'] ?? null,
                ]);
                $updatedScheduleIds[] = $newSchedule->id; // Add the new schedule's ID
            }
        }

        // Remove any schedules that are no longer in the updated list (deleted by user)
        $event->schedules()->whereNotIn('id', $updatedScheduleIds)->delete();

        return redirect()->route('calendar')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
