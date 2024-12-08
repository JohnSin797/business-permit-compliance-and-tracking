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
            },
            'owner' => function ($owner) use($request) {
                $owner->where('id', $request->user_id);
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
                },
                'owner'
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

    public function show(Business $business)
    {
        return response()->json([
            'message' => 'OK',
            'business' => $business
        ], 200);
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

    public function update(Business $business, Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required',
            'business_address' => 'required',
            'date_established' => 'required',
            'type_of_organization' => 'required',
            'dti_registration_number' => 'nullable',
            'tin' => 'nullable',
        ]);
        $result = $business->update($validated);

        if (!$result) {
            return response()->json([
                'message' => 'Failed to update business'
            ], 400);
        }

        return response()->json([
            'message' => 'OK',
            'business' => $business,
        ], 200);
    }

    public function delete(Business $business)
    {
        $business->delete();
        return response()->json([
            'message' => 'OK',
        ], 200);
    }

    public function archive($id)
    {
        $archive = Business::with([
            'owner' => function ($owner) use($id) {
                $owner->where('id', $id);
            }
        ])
            ->where('user_id', $id)
            ->orderByDesc('deleted_at')
            ->get();
        
        return response()->json([
            'message' => 'OK',
            'archive' => $archive
        ], 200);
    }
}