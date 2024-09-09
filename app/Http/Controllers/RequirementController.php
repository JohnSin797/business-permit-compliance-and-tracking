<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermitRequirement;
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
        $path = $image->storeAs('/files/requirements/'.$request->input('column'), $filename);
        $requirement = PermitRequirement::find($request->id);
        $requirement->update([
            $request->input('column') => $path
        ]);
        return response()->json([
            'requirement' => $requirement,
            'path' => $path,
        ]);
    }
}
