<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.settings');
    }

    public function updatePassword(Request $request)
    {
        return back()->with('success','Password updated');
    }

    public function updateNotifs(Request $request)
    {
        return back()->with('success','Notification settings updated');
    }

    public function updatePrivacy(Request $request)
    {
        return back()->with('success','Privacy settings updated');
    }

    public function deleteAccount()
    {
        return back()->with('success','Account deleted');
    }
}