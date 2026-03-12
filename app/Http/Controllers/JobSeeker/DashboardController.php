<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('frontend.Jobseeker.dashboard');
    }
}