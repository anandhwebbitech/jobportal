<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class SettingsController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.settings');
    }

    public function updatePassword(Request $request)
    {
         $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
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