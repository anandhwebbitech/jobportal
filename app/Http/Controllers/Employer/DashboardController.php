<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;

class DashboardController extends Controller
{

    /* ==============================
       DASHBOARD
    ============================== */

    public function index()
    {
        $totalJobs = Job::count();
        $activeJobs = Job::where('status', 'active')->count();
        $expiredJobs = Job::where('status', 'expired')->count();

        $totalApplications = JobApplication::count();

        $recentJobs = Job::latest()->take(5)->get();
        $recentApplications = JobApplication::latest()->take(5)->get();

        return view('frontend.employer.dashboard', compact(
            'totalJobs',
            'activeJobs',
            'expiredJobs',
            'totalApplications',
            'recentJobs',
            'recentApplications'
        ));
    }


    /* ==============================
       JOBS — LIST
    ============================== */

    public function jobs(Request $request)
    {
        $query = Job::withCount('applications');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('job_title', 'like', '%' . $request->search . '%')
                  ->orWhere('job_category', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('job_category', $request->category);
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        return view('frontend.employer.jobs.index', compact('jobs'));
    }


    /* ==============================
       JOBS — CREATE FORM
    ============================== */

    public function jobsCreate()
    {
        $skills = [
            'PHP Developer', 'Laravel Developer', 'Java Developer', 'Python Developer',
            'React Developer', 'Vue.js Developer', 'Node.js Developer', 'MySQL / Database',
            'WordPress Developer', 'UI/UX Designer', 'Network Engineer', 'Cyber Security',
            'Electrician', 'Plumber', 'Welder', 'Machine Operator', 'CNC Operator',
            'Lathe Operator', 'Mechanic', 'HVAC Technician', 'Quality Inspector',
            'Sales Executive', 'Marketing Executive', 'Field Sales', 'Tele-calling',
            'Data Entry', 'HR Executive', 'Accountant', 'Office Admin', 'Receptionist',
            'Driver', 'Delivery Executive', 'Forklift Operator', 'Warehouse Staff',
            'Customer Support', 'Teacher', 'Nurse', 'Pharmacist', 'Cook', 'Housekeeping',
        ];

        return view('frontend.employer.jobs.create', compact('skills'));
    }


    /* ==============================
       JOBS — STORE
    ============================== */

    public function jobsStore(Request $request)
    {
        $request->validate([
            'job_title'           => 'required|string|min:3|max:150',
            'job_category'        => 'required|string|max:100',
            'industry_type'       => 'required|string|max:100',
            'description'         => 'required|string|min:50|max:3000',
            'responsibilities'    => 'required|string|min:20|max:2000',
            'benefits'            => 'nullable|string|max:500',
            'state'               => 'required|string|max:100',
            'district'            => 'required|string|max:100',
            'city'                => 'required|string|max:100',
            'experience_required' => 'required|string|max:50',
            'vacancies'           => 'required|integer|min:1|max:500',
            'salary_min'          => 'required|numeric|min:0',
            'salary_max'          => 'nullable|numeric|min:0|gte:salary_min',
            'education'           => 'required|string|max:50',
            'job_type'            => 'required|in:Full Time,Part Time,Contract',
            'status'              => 'required|in:active,inactive',
            'skills'              => 'required|string',
            'screening_questions' => 'nullable|string',
            'terms'               => 'accepted',
        ]);

        // Decode skills
        $skills = json_decode($request->skills, true) ?? [];
        if (empty($skills)) {
            return back()->withInput()->withErrors(['skills' => 'Please add at least one skill.']);
        }

        // Decode screening questions
        $screening = json_decode($request->screening_questions ?? '[]', true) ?? [];

        $job = Job::create([
            'employer_id'         => auth()->id(),
            'job_title'           => $request->job_title,
            'job_category'        => $request->job_category,
            'industry_type'       => $request->industry_type,
            'description'         => $request->description,
            'responsibilities'    => $request->responsibilities,
            'benefits'            => $request->benefits,
            'state'               => $request->state,
            'district'            => $request->district,
            'city'                => $request->city,
            'experience_required' => $request->experience_required,
            'vacancies'           => $request->vacancies,
            'salary_min'          => $request->salary_min,
            'salary_max'          => $request->salary_max ?? $request->salary_min,
            'education'           => $request->education,
            'job_type'            => $request->job_type,
            'status'              => $request->status,
            'skills'              => json_encode($skills),
            'screening_questions' => json_encode($screening),
        ]);

        return redirect()
            ->route('employer.jobs.show', $job->id)
            ->with('success', 'Job "' . $job->job_title . '" published successfully!');
    }


    /* ==============================
       JOBS — SHOW
    ============================== */

    public function jobsShow($id)
    {
        $job = Job::with(['applications.jobseeker'])
                  ->withCount('applications')
                  ->findOrFail($id);

        return view('frontend.employer.jobs.show', compact('job'));
    }


    /* ==============================
       JOBS — EDIT FORM
    ============================== */

    public function jobsEdit($id)
    {
        $job = Job::findOrFail($id);

        $skills = [
            'PHP Developer', 'Laravel Developer', 'Java Developer', 'Python Developer',
            'React Developer', 'Vue.js Developer', 'Node.js Developer', 'MySQL / Database',
            'WordPress Developer', 'UI/UX Designer', 'Network Engineer', 'Cyber Security',
            'Electrician', 'Plumber', 'Welder', 'Machine Operator', 'CNC Operator',
            'Lathe Operator', 'Mechanic', 'HVAC Technician', 'Quality Inspector',
            'Sales Executive', 'Marketing Executive', 'Field Sales', 'Tele-calling',
            'Data Entry', 'HR Executive', 'Accountant', 'Office Admin', 'Receptionist',
            'Driver', 'Delivery Executive', 'Forklift Operator', 'Warehouse Staff',
            'Customer Support', 'Teacher', 'Nurse', 'Pharmacist', 'Cook', 'Housekeeping',
        ];

        return view('frontend.employer.jobs.edit', compact('job', 'skills'));
    }


    /* ==============================
       JOBS — UPDATE
    ============================== */

    public function jobsUpdate(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'job_title'           => 'required|string|min:3|max:150',
            'job_category'        => 'required|string|max:100',
            'industry_type'       => 'required|string|max:100',
            'description'         => 'required|string|min:50|max:3000',
            'responsibilities'    => 'required|string|min:20|max:2000',
            'benefits'            => 'nullable|string|max:500',
            'state'               => 'required|string|max:100',
            'district'            => 'required|string|max:100',
            'city'                => 'required|string|max:100',
            'experience_required' => 'required|string|max:50',
            'vacancies'           => 'required|integer|min:1|max:500',
            'salary_min'          => 'required|numeric|min:0',
            'salary_max'          => 'nullable|numeric|min:0|gte:salary_min',
            'education'           => 'required|string|max:50',
            'job_type'            => 'required|in:Full Time,Part Time,Contract',
            'status'              => 'required|in:active,inactive',
            'skills'              => 'required|string',
        ]);

        // Decode skills
        $skills = json_decode($request->skills, true) ?? [];
        if (empty($skills)) {
            return back()->withInput()->withErrors(['skills' => 'Please add at least one skill.']);
        }

        $job->update([
            'job_title'           => $request->job_title,
            'job_category'        => $request->job_category,
            'industry_type'       => $request->industry_type,
            'description'         => $request->description,
            'responsibilities'    => $request->responsibilities,
            'benefits'            => $request->benefits,
            'state'               => $request->state,
            'district'            => $request->district,
            'city'                => $request->city,
            'experience_required' => $request->experience_required,
            'vacancies'           => $request->vacancies,
            'salary_min'          => $request->salary_min,
            'salary_max'          => $request->salary_max ?? $request->salary_min,
            'education'           => $request->education,
            'job_type'            => $request->job_type,
            'status'              => $request->status,
            'skills'              => json_encode($skills),
        ]);

        return redirect()
            ->route('employer.jobs.show', $job->id)
            ->with('success', 'Job "' . $job->job_title . '" updated successfully!');
    }


    /* ==============================
       JOBS — DELETE
    ============================== */

    public function jobsDestroy($id)
    {
        $job = Job::findOrFail($id);
        $title = $job->job_title;

        // Delete related applications first
        $job->applications()->delete();
        $job->delete();

        return redirect()
            ->route('frontend.employer.jobs.index')
            ->with('success', 'Job "' . $title . '" has been deleted.');
    }


    /* ==============================
       JOBS — TOGGLE STATUS
    ============================== */

    public function jobsToggle($id)
    {
        $job = Job::findOrFail($id);
        $job->status = ($job->status === 'active') ? 'inactive' : 'active';
        $job->save();

        $action = $job->status === 'active' ? 'activated' : 'deactivated';

        return back()->with('success', 'Job "' . $job->job_title . '" has been ' . $action . '.');
    }


    /* ==============================
       BILLING / PLANS
    ============================== */

    public function billing()
    {
        return view('frontend.employer.billing');
    }

    public function checkout(Request $request)
    {
        $plan = $request->plan;

        // Example logic (you can integrate Razorpay later)
        return redirect()->route('employer.billing')
            ->with('success', 'Plan selected: ' . $plan);
    }


    /* ==============================
       CANDIDATES
    ============================== */

    public function candidates()
    {
        $applications = JobApplication::latest()->get();

        return view('frontend.employer.candidates', compact('applications'));
    }

    public function resume()
{
    // Example: show a list of resumes or redirect to candidates page
    $applications = JobApplication::latest()->get();

    return view('frontend.employer.resume', compact('applications'));
}

    /* ==============================
       ADVERTISEMENTS
    ============================== */

    public function advertisements()
    {
        return view('frontend.employer.ads');
    }

    public function storeAd(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'redirect_url' => 'required|url',
            'ad_position'  => 'required',
        ]);

        // You can save advertisement in database later

        return redirect()
            ->route('frontend.employer.ads')
            ->with('success', 'Advertisement submitted successfully.');
    }


    /* ==============================
       NOTIFICATIONS
    ============================== */

    public function notifications()
    {
        return view('frontend.employer.notifications');
    }

    public function settings()
{
    // Load the settings view
    return view('frontend.employer.settings');
}

}