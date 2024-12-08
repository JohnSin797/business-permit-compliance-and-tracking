<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationCode;
use App\Http\Requests\User\RegisterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('business-permit-tracking')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        if (User::where('email', $credentials['email'])->exists()) {
            return response()->json([
                'error' => 'Password did not match'
            ], 401);
        }

        return response()->json([
            'error' => 'Invalid email'
        ], 401);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('business-permit-tracking')->plainTextToken;
        $verification = VerificationCode::create([
            'user_id' => $user->id,
            'one_time_password' => rand(123456, 999999),
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        $full_name = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name . ' ' . $user->extension;
        Mail::to($user->email)->send(new VerifyEmail($full_name, $verification->one_time_password));

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
