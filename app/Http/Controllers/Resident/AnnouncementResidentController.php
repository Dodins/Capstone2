<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnouncementResidentController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all()->map(function ($announcement) {
            return [
                'id'          => $announcement->id,
                'title'       => $announcement->title,
                'description' => $announcement->description,
                'created_at'  => Carbon::parse($announcement->created_at)->format('Y-m-d'),
                'updated_at'  => Carbon::parse($announcement->updated_at)->format('Y-m-d'),
            ];
        });

        return response()->json(['announcement' => $announcements], 200);
    }

}
