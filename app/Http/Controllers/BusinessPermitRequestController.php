<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPermitRequest;
use App\Models\PermitRequirement;
use App\Models\Notification;
use App\Models\User;

class BusinessPermitRequestController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $business_request = BusinessPermitRequest::with([
            'business' => function($business) use($request) {
                $business->where('user_id', $request->user_id);
            },
            'business.owner'
        ])
        ->whereHas('business', function($b) use($request) {
            $b->where('user_id', $request->user_id);
        })
        ->orderByRaw("FIELD(status, 'incomplete', 'pending', 'confirmed', 'rejected', 'recompile')")
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'request' => $business_request,
            'test' => BusinessPermitRequest::with(['business' => function($business) use($request) {
                $business->where('user_id', $request->user_id);
            }, 'business.owner'
            ])->get()
        ]);
    }

    public function admin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $business_request = BusinessPermitRequest::with('business')
        ->orderByRaw("FIELD(status, 'incomplete', 'pending', 'verified')")
        ->orderByDesc('created_at')
        ->get();

        return response()->json([
            'request' => $business_request
        ]);
    }

    public function show($id)
    {
        $permitRequest = BusinessPermitRequest::with('requirements')->findOrFail($id);
        // $permitRequest = $permit->with('requirements')->first();
        return response()->json([
            'message' => 'OK',
            'permit' => $permitRequest
        ], 200);
    }

    public function edit($id)
    {
        $permit = BusinessPermitRequest::with('business')->findOrFail($id);
        return response()->json([
            'message' => 'OK',
            'business' => $permit
        ], 200);
    }

    public function updatePermit(Request $request)
    {
        $validated = $request->validate([
            'permit_id' => 'required|exists:business_permit_requests,id',
            'request_type' => 'required'   
        ]);

        $permit = BusinessPermitRequest::find($validated['permit_id']);
        $permit->update([
            'request_type' => $validated['request_type']
        ]);

        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function update(BusinessPermitRequest $permit, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required'
        ]);

        $result = $permit->update($validated);

        if (!$result) {
            return response()->json([
                'message' => 'Failed to confirm request'
            ], 400);
        }

        $business_request = BusinessPermitRequest::with('business')
        ->orderByRaw("FIELD(status, 'incomplete', 'pending', 'confirmed', 'rejected', 'recompile')")
        ->orderByDesc('created_at')
        ->get();

        $business = $permit->business()->first();
        $content = $business->business_name." request has been ".$validated['status'].".";
        Notification::create([
            'user_id' => $business->user_id,
            'content' => $content
        ]); 
        $admin = User::where('role', 'admin')->first();
        Notification::create([
            'user_id' => $admin->id,
            'content' => $content,
        ]);

        return response()->json([
            'message' => 'OK',
            'request' => $business_request
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'request_type' => 'required',
        ]);

        $business_request = BusinessPermitRequest::create($validated);
        $permit_requirements = PermitRequirement::create([
            'request_id' => $business_request->id,
        ]);

        if ($business_request) {
            return response()->json([
                'message' => 'Request created successfully',
                'id' => $permit_requirements->id,
            ]);
        }

        return response()->json(['message' => 'Failed to create request'], 400);
    }

    public function delete($id)
    {
        $permit = BusinessPermitRequest::findOrFail($id);
        $permit->delete();
        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function restore($id)
    {
        $permit = BusinessPermitRequest::onlyTrashed()->findOrFail($id);
        $permit->restore();
        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function destroy($id)
    {
        $permit = BusinessPermitRequest::onlyTrashed()->findOrFail($id);
        $permit->forceDelete();
        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function archive(Request $request)
    {
        $archive = BusinessPermitRequest::onlyTrashed()
            ->with(['business', 'business.owner'])
            ->get();
        return response()->json([
            'message' => 'OK',
            'archive' => $archive
        ], 200);
    }
}
