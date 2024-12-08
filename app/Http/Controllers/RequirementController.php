<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermitRequirement;
use App\Models\BusinessPermitRequest;
use App\Models\User;

class RequirementController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:permit_requirements,id'
        ]);
        $requirement = PermitRequirement::find($request->id);

        return response()->json([
            'requirement' => $requirement
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:permit_requirements,id',
            'column' => 'required|string',
            'value' => 'required',
        ]);
        $image = $request->file('value');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('/public/files/requirements/'.$request->input('column'), $filename);
        $path = 'files/requirements/'.$request->input('column').'/'.$filename;
        $requirement = PermitRequirement::find($request->id);
        $result = $requirement->update([
            $request->input('column') => $path
        ]);
        if (!$result) {
            return response()->json([
                'message' => 'Failed to upload'
            ], 400);
        }
        $permit_request = BusinessPermitRequest::find($requirement->request_id);
        if ($permit_request->request_type == 'renewal') {

        } else {
            if ($requirement->barangay_clearance && $requirement->cedula && $requirement->business_registration
                && $requirement->bir_certificate_of_registration && $requirement->ecc_cnc_denr) {
                    $permit_request->update([
                        'status' => 'pending'
                    ]);
                }
        }
        return response()->json([
            'requirement' => $requirement,
            'path' => $path,
        ]);
    }
}
