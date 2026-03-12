<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.resume');
    }

    public function upload(Request $request)
    {
        // resume upload logic
        return back()->with('success','Resume uploaded');
    }

    public function delete()
    {
        // delete resume
        return back()->with('success','Resume deleted');
    }

    public function visibility(Request $request)
    {
        // public / private
        return back()->with('success','Resume visibility updated');
    }
}