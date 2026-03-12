<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.profile');
    }

    public function update(Request $request)
    {
        // Update basic profile
        return back()->with('success','Profile updated');
    }

    public function education(Request $request)
    {
        return back()->with('success','Education updated');
    }

    public function experience(Request $request)
    {
        return back()->with('success','Experience updated');
    }

    public function skills(Request $request)
    {
        return back()->with('success','Skills updated');
    }
}