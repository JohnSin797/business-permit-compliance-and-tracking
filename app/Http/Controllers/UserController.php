<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\VerifyEmail;

class UserController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'verification_code' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);
        $verification_code = $user->verificationCode;

        if ($verification_code->one_time_password === $request->verification_code && Carbon::now()->lessThanOrEqualTo($verification_code->expires_at)) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            return response()->json([
                'message' => 'Email verified successfully',
                'user' => $user,
            ]);
        }
        elseif (Carbon::now()->greaterThan($verification_code->expires_at)) {
            return response()->json(['error' => 'Verification code expired'], 400);
        }
        elseif ($verification_code->one_time_password !== $request->verification_code) {
            return response()->json(['error' => 'Invalid verification code'], 400);
        }
        else {
            return response()->json(['error' => 'Verification failed, please try again'], 500);
        }
    }

    public function resend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);
        $verification_code = $user->verificationCode;
        $verification_code->one_time_password = rand(123456, 999999);
        $verification_code->expires_at = Carbon::now()->addMinutes(10);
        $verification_code->save();

        $full_name = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name . ' ' . $user->extension;
        Mail::to($user->email)->send(new VerifyEmail($full_name, $verification_code->one_time_password));

        return response()->json([
            'message' => 'Verification code sent'
        ]);
    }

    public function updateAccount(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email:rfc,dns',
            'password' => 'nullable',
        ]);

        $user = User::find($validated['user_id']);
        $user->email = $validated['email'];
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'extension' => 'nullable',
        ]);

        $user = User::find($validated['id']);
        $user->update($validated);

        return response()->json([
            'user' => $user
        ]);
    }

    public function changeProfileImage(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'profile_image' => 'required|file',
        ]);

        $profile_image_path = 'public/images';
        $filename = time() . '_' . uniqid() . '.' . $validated['profile_image']->getClientOriginalExtension();
        $validated['profile_image']->storeAs($profile_image_path, $filename);
        $final = '/storage/images/'.$filename;
        $user = User::find($validated['user_id']);
        $user->update([
            'profile_image' => $final
        ]);

        return response()->json([
            'message' => 'OK',
            'profile_image' => $final,
        ], 200);
    }
}
