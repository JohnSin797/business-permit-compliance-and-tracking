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
