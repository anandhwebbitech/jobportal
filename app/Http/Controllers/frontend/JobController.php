<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Events\UserNotification;

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

            'salary_min' => $request->salary_min ?? 0,
            'salary_max' => $request->salary_max ?? 0,

            'job_type' => $request->job_type,

            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'benefits' => $request->benefits,

            'education' => $request->education,
            'skills' => $request->skills,

            'expiry_date' => $request->expiry_date,
            'status'    => 0,
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
    public function applyJob(Request $request,$id){
         $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email|max:255',
            'applicant_mobile' => 'required|string|max:15',
            'current_location' => 'required|string|max:255',
            'highest_qualification' => 'required|string',
            'experience_level' => 'required|string',
            'notice_period' => 'required|string',

            'resume' => 'required|mimes:pdf,doc,docx|max:5120',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        try {

            // ✅ Upload Resume
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
            }

            // ✅ Upload Photo
            $photoPath = null;
            if ($request->hasFile('profile_photo')) {
                $photoPath = $request->file('profile_photo')->store('photos', 'public');
            }
           
            // ✅ Save to DB
            JobApplication::create([
                'job_id' => $id,
                'user_id' => Auth::id(),

                'applicant_name' => $request->applicant_name,
                'applicant_email' => $request->applicant_email,
                'applicant_mobile' => $request->applicant_mobile,
                'current_location' => $request->current_location,
                'highest_qualification' => $request->highest_qualification,

                'experience_level' => $request->experience_level,
                'years_experience' => $request->years_experience,
                'previous_company' => $request->previous_company,
                'previous_designation' => $request->previous_designation,

                'cover_letter' => $request->cover_letter,
                'expected_salary' => $request->expected_salary,
                'notice_period' => $request->notice_period,

                'resume' => $resumePath,
                'profile_photo' => $photoPath,
            ]);
            $job = Job::findOrFail($id);
            if($job){

                $message = 'New Application Received';
                $notification = Notification::create([
                    'user_id'   => $job->create_user_id,
                    'job_id'    => $id,
                    'title'     => 'Job Application',
                    'message'   => $message,
                    'type'      => Notification::TYPE_JOB_APPLICATION,
                    'send_from' => Auth::id(), // admin/employer
                    'send_to'   => $job->create_user_id,
                ]);
                event(new UserNotification($notification));
                \Log::info('Notification fired');
            }

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!',
                'redirect' => url('/jobs/' . $id)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}