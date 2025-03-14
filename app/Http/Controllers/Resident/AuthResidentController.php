<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthResidentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'resident',
        ]);

        return response()->json([
            'message' => 'Create account succesfully!'
        ]);
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

            $user = Auth::user();

            if($user->role !== 'resident'){
                Auth::logout();
                return response()->json([
                    'message' => 'Access denied. You must be a resident.'
                ], 403);
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
}
