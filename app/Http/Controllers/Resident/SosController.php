<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Sos;
use App\Models\User;
use App\Notifications\Admin\NewSosAlert;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Resident\SosAlertEvent;

class SosController extends Controller
{
    public function sendSOS(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $sos = Sos::create([
            'user_id' => Auth::id(),
            'message' => $request->message ?? 'SOS Alert!',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        event(new SosAlertEvent($sos));

        $admin = User::where('role', 'admin')->first();
        Notification::send($admin, new NewSosAlert($sos));

        return response()->json([
            'success' => true,
            'message' => 'SOS sent successfully!',
            'is_seen' => $request->is_seen,
            'sos' => $sos,
        ]);
    }
}
