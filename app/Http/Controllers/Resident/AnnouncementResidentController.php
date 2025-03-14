<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementResidentController extends Controller
{
    public function index()
    {
        $annonucements = Announcement::all();

        return response()->json(['message' => 'Via Resident Response', $annonucements]);
    }

}
