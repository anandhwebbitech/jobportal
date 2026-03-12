<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.alerts');
    }

    public function store(Request $request)
    {
        return back()->with('success','Alert created');
    }

    public function edit($id)
    {
        return view('frontend.jobseeker.alerts.edit', compact('id'));
    }

    public function update(Request $request,$id)
    {
        return back()->with('success','Alert updated');
    }

    public function toggle($id)
    {
        return back()->with('success','Alert status changed');
    }

    public function destroy($id)
    {
        return back()->with('success','Alert deleted');
    }
}