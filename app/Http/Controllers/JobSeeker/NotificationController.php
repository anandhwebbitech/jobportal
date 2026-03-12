<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.notifications');
    }

    public function markRead($id)
    {
        return back();
    }

    public function readAll()
    {
        return back();
    }

    public function clearAll()
    {
        return back();
    }
}