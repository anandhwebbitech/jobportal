<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Str;

class JobController extends Controller
{

    // JOB LIST PAGE
    public function index(Request $request)
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


    // JOB DETAILS PAGE
    public function show($slug)
    {
        $job = Job::where('id', $slug)->firstOrFail();
        return view('frontend.jobs.details', compact('job'));
    }


    // STORE JOB (INSERT INTO DATABASE)
    public function store(Request $request)
    {
        Job::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'company_name' => $request->company_name,

            'location' => $request->location,
            'district' => $request->district,
            'state' => $request->state,

            'experience' => $request->experience,

            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,

            'job_type' => $request->job_type,

            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'benefits' => $request->benefits,

            'education' => $request->education,
            'skills' => $request->skills,

            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('jobs.index')
            ->with('success', 'Job Posted Successfully');
    }


    // APPLY JOB PAGE
    public function apply($id)
    {
        $job = Job::findOrFail($id);

        return view('frontend.jobs.job-apply', compact('job'));
    }

}