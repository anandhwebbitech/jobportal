<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.applied');
    }

    public function show($id)
    {
        return view('frontend.jobseeker.applied', compact('id'));
    }

    public function detail($id)
    {
        return view('frontend.jobseeker.applied', compact('id'));
    }
}