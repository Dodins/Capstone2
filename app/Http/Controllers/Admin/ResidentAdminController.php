<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;

class ResidentAdminController extends Controller
{
    public function index()
    {
        $residents = Resident::where('is_verified', 1)->get();
        return response()->json($residents);
    }
}
