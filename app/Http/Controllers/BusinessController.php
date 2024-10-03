<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\User;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);
        $business = Business::with([
            'permitRequest' => function ($permit) {
                $permit->orderByDesc('created_at');
            }
        ])
            ->where('user_id', $user->id)
            ->get();
        // $business = $user->business;
        // $business = Business::with('')

        return response()->json([
            'business' => $business
        ]);
    }

    public function admin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $admin = User::find($request->user_id);
        if ($admin->role == 'admin') {
            $business = Business::with([
                'permitRequest' => function($permit) use($request) {
                    $permit->orderByDesc('created_at');
                }
            ])
            ->get();
            return response()->json([
                'business' => $business
            ]);
        }
        return response()->json([
            'message' => 'unauthorized'
        ], 400);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'business_name' => 'required',
            'business_address' => 'required',
            'date_established' => 'required',
            'type_of_organization' => 'required',
            'dti_registration_number' => 'nullable',
            'tin' => 'required'
        ]);
        
        $business = Business::create($validated);

        if ($business) {
            return response()->json([
                'message' => 'Business created successfully'
            ]);
        }

        return response()->json(['message' => 'Failed to create business'], 500);
    }

    public function update(Request $request)
    {

    }
}
