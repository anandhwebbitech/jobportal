<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\EmployerDetail;
use App\Models\User;

class ProfileController extends Controller
{
    // Show company profile page
    public function index()
    {
        // get first employer record
        $employer = User::with('employerDetails')->where('id',auth()->id())->first();
        return view('frontend.employer.profile', compact('employer'));
    }

    // Update profile
    public function update(Request $request)
    {
        try {

            $user = auth()->user();
            $employer = $user->employerDetails;

            $request->validate([
                'company_name'          => 'required|string|max:255',
                'company_description'   => 'required|string',
                'industry_type'         => 'required|string',
                'company_size'          => 'required',
                'founded_year'          => 'required',
                'company_address'       => 'required',
                'state'                 => 'required',
                'district'              => 'required',
                'city'                  => 'required',
                'pincode'               => 'required|digits:6',
                'owner_name'            => 'required',
                'owner_mobile'          => 'required|digits:10',
                'hr_name'               => 'required',
                'hr_mobile'             => 'required|digits:10',
                'official_email'        => 'required|email'
            ]);

            // ✅ Upload logo
            if ($request->hasFile('company_logo')) {
                $file = $request->file('company_logo');
                $filename = time().'_logo.'.$file->extension();
                $file->move(public_path('uploads/employer'), $filename);

                $employer->company_logo = $filename;
            }

            // ✅ Update Employer Details
            $employer->update([
                'company_name'      => $request->company_name,
                'company_address'   => $request->company_address,
                'state'             => $request->state,
                'district'          => $request->district,
                'city'              => $request->city,
                'pincode'           => $request->pincode,
                'owner_name'        => $request->owner_name,
                'owner_mobile'      => $request->owner_mobile,
                'hr_name'           => $request->hr_name,
                'hr_mobile'         => $request->hr_mobile,
                'email'             => $request->official_email,
            ]);

            // ✅ Update main employer table
            $user->update([
                'name' => $request->company_name,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}