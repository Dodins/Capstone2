<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafetyTips;

class SafetyTipsController extends Controller
{
    public function index()
    {
        return response()->json(SafetyTips::all());
    }
}
