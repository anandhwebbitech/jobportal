<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;

class SavedJobController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.saved');
    }

    public function save($jobId)
    {
        // save job
        return back()->with('success','Job saved');
    }

    public function remove($id)
    {
        // remove saved job
        return back()->with('success','Job removed');
    }
}