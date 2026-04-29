<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BannerPlan;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobPlan;
use App\Models\Location;
use App\Models\Qualification;
use App\Models\ResumePlan;
use App\Models\Skill;
use App\Models\BannerPlanSubscription;





class FrontendController extends Controller
{
    // Home Page
    public function home()
    {
        $latestJobs = Job::latest()->take(6)->get();
        $locations = Location::where('status',1)->get();
        // Most repeated job titles
        $trendingJobs = Job::select('title')
            ->selectRaw('COUNT(*) as total')
            ->where('admin_status', 1)
            ->where('status', 1)
            ->groupBy('title')
            ->orderByDesc('total')
            ->take(7)
            ->get();
            // Active banner ads
        $banners = BannerPlanSubscription::where('status', 'active')
            ->where('payment_status', 'paid')
            ->latest()
            ->take(2)
            ->get();

        return view('frontend.home', compact('latestJobs','locations','trendingJobs','banners'));
    }

    // Find Jobs Page
    public function jobs(Request $request)
    {
        $query = Job::query();

        if ($request->title || $request->q) {
            $query->where('title', 'like', '%' . ($request->title ?? $request->q) . '%');
        }

        if ($request->location) {
            $query->where('district', $request->location);
        }

        if ($request->job_type) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->skill) {
            $query->where('skills', 'like', '%' . $request->skill . '%');
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->experience) {
            if ($request->experience != 'Any') {
                $query->where('experience', $request->experience);
            }
        }

        if ($request->salary) {
            if (str_contains($request->salary, '-')) {
                [$min, $max] = explode('-', $request->salary);
                $query->whereBetween('salary_min', [(int)$min, (int)$max]);
            } elseif ($request->salary == '50000+') {
                $query->where('salary_min', '>=', 50000);
            }
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
        $plans = JobPlan::where('is_active', 1)->orderBy('id')->get();
        $resumePlans = ResumePlan::where('is_active', 1)->orderBy('price')->get();
        $bannerPlans = BannerPlan::where('is_active', 1)->get();

        return view('frontend.pricing', compact('plans','resumePlans','bannerPlans'));
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
        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();

        return view('frontend.auth.jobseeker-register',compact('skills','qualifications'));
    }

    // Employer Register
    public function employerRegister()
    {
        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();

        return view('frontend.auth.employer-register',compact('skills','qualifications'));
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
        dd(7);
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
    public function getDistricts($state)
    {
        return Location::where('state', $state)->pluck('district');
    }

    public function searchJobs(Request $request)
    {
        $query = Job::query();

        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->state) {
            $query->where('state', $request->state);
        }

        if ($request->location) {
            $query->where('district', $request->location);
        }

        $jobs = $query->get();

        return view('frontend.jobs.job-list', compact('jobs'));
    }

}