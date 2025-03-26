<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthResidentController extends Controller
{
    public function resident()
    {
        $user = Auth::user();
        $resident = Resident::where('user_id', $user->id)->first();

        if (!$resident) {
            return response()->json(['message' => 'Resident not found'], 404);
        }

        return response()->json($resident);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'resident',
        ]);

        Resident::create([
            'user_id' => $user->id,
            'full_name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(
            [
                'message' => 'Create account succesfully!',
            ],
            200,
        );
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(
                [
                    'message' => 'Invalid email or password',
                ],
                401,
            );
        }

        $user = Auth::user();

        if ($user->role !== 'resident') {
            Auth::logout();
            return response()->json(
                [
                    'message' => 'Access denied. You must be a resident.',
                ],
                403,
            );
        }

        $token = $request->user()->createToken($request->email)->plainTextToken;

        return response()->json([
            'message' => 'Login Succesful.',
            'token' => $token,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json('Log out succesfully!');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user = User::where('email', $request->email)->first();
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Your Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent to your email']);
    }

    // Reset password method
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->where('otp', $request->otp)->where('otp_expires_at', '>', now())->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP is invalid or has expired.'],
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }

    public function checkToken(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'message' => 'Token is valid',
                'status' => 'success',
            ]);
        }

        return response()->json(
            [
                'message' => 'Invalid or expired token',
                'status' => 'error',
            ],
            401,
        );
    }
}
