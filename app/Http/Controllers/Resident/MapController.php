<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrimeLocation;

class MapController extends Controller
{
    public function index()
    {
        return response()->json(CrimeLocation::all());
    }
}
