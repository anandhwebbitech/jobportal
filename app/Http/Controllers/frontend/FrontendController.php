<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class FrontendController extends Controller
{
    // Home Page
    public function home()
    {
        $latestJobs = Job::latest()->take(6)->get();

        return view('frontend.home', compact('latestJobs'));
    }

    // Find Jobs Page
    public function jobs(Request $request)
    {
        $query = Job::query();

        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->location) {
            $query->where('location', $request->location);
        }

        if ($request->job_type) {
            $query->where('job_type', $request->job_type);
        }

        $jobs = $query->latest()->paginate(10);

        return view('frontend.jobs.index', compact('jobs'));
    }

    // Job Details Page
    public function jobDetails($slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();

        return view('frontend.jobs.details', compact('job'));
    }

    // Pricing Page
    public function pricing()
    {
        return view('frontend.pricing');
    }

    // Contact Page
    public function contact()
    {
        return view('frontend.contact');
    }

    // Contact Form Submit
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        return back()->with('success', 'Message sent successfully!');
    }

    // Job Seeker Login
    public function jobseekerLogin()
    {
        return view('frontend.auth.jobseeker-login');
    }

    // Employer Login
    public function employerLogin()
    {
        return view('frontend.auth.employer-login');
    }

    // Job Seeker Register
    public function jobseekerRegister()
    {
        return view('frontend.auth.jobseeker-register');
    }

    // Employer Register
    public function employerRegister()
    {
        return view('frontend.auth.employer-register');
    }

    // Forgot Password
    public function forgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    // Post Job Page
    public function postJob()
    {
        return view('frontend.post-job');
    }

    // Open Job Apply Page
    public function jobApply($slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();

        return view('frontend.jobs.job-apply', compact('job'));
    }

    // Submit Job Application
    public function jobApplySubmit(Request $request, $slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();

        $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email',
            'applicant_mobile' => 'required',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable'
        ]);

        $resumePath = null;

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        // Save application later

        return back()->with('success', 'Application submitted successfully!');
    }

}