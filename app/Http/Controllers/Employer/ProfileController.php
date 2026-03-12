<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;

class ProfileController extends Controller
{
    // Show company profile page
    public function index()
    {
        // get first employer record
        $employer = Employer::first();

        return view('frontend.employer.profile', compact('employer'));
    }

    // Update profile
    public function update(Request $request)
    {
        $employer = Employer::first();

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'industry_type' => 'required|string',
            'company_size' => 'required',
            'founded_year' => 'required',
            'company_address' => 'required',
            'state' => 'required',
            'district' => 'required',
            'city' => 'required',
            'pincode' => 'required|digits:6',
            'owner_name' => 'required',
            'owner_mobile' => 'required',
            'hr_name' => 'required',
            'hr_mobile' => 'required',
            'official_email' => 'required|email'
        ]);

        $employer->update($request->all());

        return redirect()
            ->route('frontend.employer.profile')
            ->with('success', 'Profile updated successfully.');
    }
}