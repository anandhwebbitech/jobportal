<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\EmployerDetail;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use App\Models\Notification;
use App\Events\UserNotification;
use App\Models\BannerPlan;
use App\Models\JobPlan;
use App\Models\Location;
use App\Models\Qualification;
use App\Models\ResumePlan;
use App\Models\Skill;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Hash;
use App\Models\UserPlanSubscription;
use App\Models\ResumeActivityLog;
use App\Models\ResumePlanSubscription;

class DashboardController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
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

         // ✅ GET ACTIVE PLAN
        $plan = UserPlanSubscription::where('user_id', auth()->id())
            ->where('status', 1)
            ->latest()
            ->first();

        $daysLeft = null;

        if ($plan && $plan->end_date) {
            $daysLeft = (int) floor(Carbon::now()->diffInDays($plan->end_date, false));
        }

        return view('frontend.employer.dashboard', compact(
            'totalJobs',
            'activeJobs',
            'expiredJobs',
            'totalApplications',
            'recentJobs',
            'recentApplications',
            'daysLeft',
            'plan'
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
        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();


        return view('frontend.employer.jobs.create', compact('skills','qualifications'));
    }


    /* ==============================
       JOBS — STORE
    ============================== */

    // public function jobsStore(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'job_title'           => 'required|string|min:3|max:150',
    //             'job_category'        => 'required|string|max:100',
    //             'industry_type'       => 'required|string|max:100',
    //             'description'         => 'required|string|min:50|max:3000',
    //             'responsibilities'    => 'required|string|min:20|max:2000',
    //             'benefits'            => 'nullable|string|max:500',
    //             'state'               => 'required|string|max:100',
    //             'district'            => 'required|string|max:100',
    //             'city'                => 'required|string|max:100',
    //             'experience_required' => 'required|string|max:50',
    //             'vacancies'           => 'required|integer|min:1|max:2000',
    //             'education'           => 'required|string|max:50',
    //             'job_type'            => 'required|in:Full Time,Part Time,Contract',
    //             'status'              => 'required|in:active,inactive',
    //             'skills'              => 'required|string',
    //             'terms'               => 'accepted',
    //         ]);

    //         // responsibilities & benefits (fixed)

    //         // skills decode
    //         $skills = json_decode($request->skills, true);
    //         if (json_last_error() !== JSON_ERROR_NONE || empty($skills)) {
    //             return back()->withInput()->withErrors([
    //                 'skills' => 'Invalid skills format'
    //             ]);
    //         }

    //         // salary split
    //         $salaryMin = 0;
    //         $salaryMax = 0;

    //         if ($request->salary_range) {
    //             $parts = explode('-', $request->salary_range);
    //             $salaryMin = $parts[0] ?? 0;
    //             $salaryMax = $parts[1] ?? 0;
    //         }

    //         $company = EmployerDetail::where('user_id', auth()->id())->first();

    //         $job = Job::create([
    //             'company_name'     => $company->company_name ?? null,
    //             'category'         => $request->job_category,
    //             'industry'         => $request->industry_type,
    //             'title'            => $request->job_title,
    //             'slug'             => Str::slug($request->job_title) . '-' . time(),
    //             'description'      => $request->description,
    //             'responsibilities' => $request->responsibilities,
    //             'benefits'         => $request->benefits,
    //             'state'            => $request->state,
    //             'district'         => $request->district,
    //             'location'         => $request->city,
    //             'experience'       => $request->experience_required,
    //             'salary_min'       => $salaryMin,
    //             'salary_max'       => $salaryMax,
    //             'education'        => $request->education,
    //             'job_type'         => $request->job_type,
    //             'status'           => $request->status === 'active' ? 1 : 0,
    //             'skills'           => json_encode($skills),
    //             'num_vacancies'    => $request->vacancies,
    //             'admin_status'     => 0,
    //             'is_new'           => 1,
    //             'expiry_date'      => Carbon::now()->addDays(10),
    //             'create_user_id'   => auth()->id(),
    //         ]);
    //         if($job){
    //             $message = 'New Job recived for approval';
    //             $notification = Notification::create([
    //                 'user_id'   => 3,
    //                 'job_id'    => $job->id,
    //                 'title'     => Notification::typeName(Notification::TYPE_JOB_POST),
    //                 'message'   => $message,
    //                 'type'      => Notification::TYPE_JOB_POST,
    //                 'send_from' => auth()->id(), // admin/employer
    //                 'send_to'   => 3,
    //             ]);
    //             event(new UserNotification($notification));
    //             \Log::info('Notification fired');
    //         }

    //         return redirect()
    //             ->route('employer.jobs.show', $job->id)
    //             ->with('success', 'Job created successfully!');

    //     } catch (\Exception $e) {
    //         return back()->withInput()->with('error', $e->getMessage());
    //     }
    // }
    public function jobsStore(Request $request)
    {
        try {

            /* ===============================
            🔥 PLAN CHECK START
            =============================== */

            $plan = UserPlanSubscription::where('user_id', auth()->id())
                ->where('status', 1)
                ->whereDate('end_date', '>=', now())
                ->latest()
                ->first();

            // ❌ No active plan
            if (!$plan) {
                return back()->withInput()->with('error', 'Please purchase a job plan first');
            }

            // ❌ Limit reached
            if ($plan->jobs_used >= $plan->job_post_limit) {
                return back()->withInput()->with('error', 'Job post limit reached for your plan');
            }

            /* ===============================
            VALIDATION
            =============================== */

            $request->validate([
                'job_title'           => 'required|string|min:3|max:150',
                'job_category'        => 'required|string|max:100',
                // 'industry_type'       => 'required|string|max:100',
                'description'         => 'required|string|min:50|max:3000',
                'responsibilities'    => 'required|string|min:20|max:2000',
                'benefits'            => 'nullable|string|max:500',
                'state'               => 'required|string|max:100',
                'district'            => 'required|string|max:100',
                'city'                => 'required|string|max:100',
                'experience_required' => 'required|string|max:50',
                'vacancies'           => 'required|integer|min:1|max:2000',
                'education'           => 'required|string|max:50',
                'job_type'            => 'required|in:Full Time,Part Time,Contract',
                'status'              => 'required|in:active,inactive',
                'skills'              => 'required|string',
                'terms'               => 'accepted',
            ]);

            // skills decode
            $skills = json_decode($request->skills, true);
            if (json_last_error() !== JSON_ERROR_NONE || empty($skills)) {
                return back()->withInput()->withErrors([
                    'skills' => 'Invalid skills format'
                ]);
            }

            // salary split
            $salaryMin = 0;
            $salaryMax = 0;

            if ($request->salary_range) {
                $parts = explode('-', $request->salary_range);
                $salaryMin = $parts[0] ?? 0;
                $salaryMax = $parts[1] ?? 0;
            }

            $company = EmployerDetail::where('user_id', auth()->id())->first();

            /* ===============================
            JOB CREATE
            =============================== */

            $job = Job::create([
                'company_name'     => $company->company_name ?? null,
                'category'         => $request->job_category,
                'industry'         => null,
                'title'            => $request->job_title,
                'slug'             => Str::slug($request->job_title) . '-' . time(),
                'description'      => $request->description,
                'responsibilities' => $request->responsibilities,
                'benefits'         => $request->benefits,
                'state'            => $request->state,
                'district'         => $request->district,
                'location'         => $request->city,
                'experience'       => $request->experience_required,
                'salary_min'       => $salaryMin,
                'salary_max'       => $salaryMax,
                'education'        => $request->education,
                'job_type'         => $request->job_type,
                'status'           => $request->status === 'active' ? 1 : 0,
                'skills'           => json_encode($skills),
                'num_vacancies'    => $request->vacancies,
                'admin_status'     => 0,
                'is_new'           => 1,

                // 🔥 IMPORTANT → plan based expiry
                'expiry_date'      => now()->addDays($plan->plan->duration_days),

                'create_user_id'   => auth()->id(),
            ]);

            /* ===============================
            🔥 UPDATE PLAN USAGE
            =============================== */
            $plan->increment('jobs_used');

            /* ===============================
            NOTIFICATION
            =============================== */
            if ($job) {
                $message = 'New Job received for approval';

                $notification = Notification::create([
                    'user_id'   => 3,
                    'job_id'    => $job->id,
                    'title'     => Notification::typeName(Notification::TYPE_JOB_POST),
                    'message'   => $message,
                    'type'      => Notification::TYPE_JOB_POST,
                    'send_from' => auth()->id(),
                    'send_to'   => 3,
                ]);

                event(new UserNotification($notification));
            }

            return redirect()
                ->route('employer.jobs.show', $job->id)
                ->with('success', 'Job created successfully!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
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

        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();

        return view('frontend.employer.jobs.edit', compact('job', 'skills','qualifications'));
    }


    /* ==============================
       JOBS — UPDATE
    ============================== */

    public function jobsUpdate(Request $request, $id)
    {
        try {

            $job = Job::findOrFail($id);

            // ✅ Validation
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
                'vacancies'           => 'required|integer|min:1|max:2000',
                'education'           => 'required|string|max:50',
                'job_type'            => 'required|in:Full Time,Part Time,Contract',
                'status'              => 'required|in:active,inactive',
                'skills'              => 'required|json', // ✅ FIX
            ]);

            // ✅ Decode skills
            $skills = $request->skills;

            if (is_string($skills)) {
                $decoded = json_decode($skills, true);

                // if valid JSON → use it
                if (json_last_error() === JSON_ERROR_NONE) {
                    $skills = $decoded;
                } else {
                    // fallback (comma split)
                    $skills = explode(',', $skills);
                }
            }

            if (json_last_error() !== JSON_ERROR_NONE || empty($skills)) {
                return back()->withInput()->withErrors([
                    'skills' => 'Invalid skills format'
                ]);
            }

            // ✅ Salary logic (same as store)
            $salaryMin = 0;
            $salaryMax = 0;

            if ($request->salary_range) {
                if ($request->salary_range === 'Not Disclosed') {
                    $salaryMin = 0;
                    $salaryMax = 0;
                } elseif (str_contains($request->salary_range, '+')) {
                    $salaryMin = (int) str_replace('+', '', $request->salary_range);
                    $salaryMax = $salaryMin;
                } else {
                    $parts = explode('-', $request->salary_range);
                    $salaryMin = $parts[0] ?? 0;
                    $salaryMax = $parts[1] ?? 0;
                }
            }

            // ✅ Company details
            $company = EmployerDetail::where('user_id', auth()->id())->first();

            // ✅ Slug update only if title changed
            if ($job->title !== $request->job_title) {
                $job->slug = Str::slug($request->job_title) . '-' . time();
            }

            // ✅ Update Job
            $job->update([
                'company_name'     => $company->company_name ?? null,
                'category'         => $request->job_category,
                'industry'         => $request->industry_type,
                'title'            => $request->job_title,
                'description'      => $request->description,
                'responsibilities' => $request->responsibilities,
                'benefits'         => $request->benefits,
                'state'            => $request->state,
                'district'         => $request->district,
                'location'         => $request->city,
                'experience'       => $request->experience_required,
                'salary_min'       => $salaryMin,
                'salary_max'       => $salaryMax,
                'education'        => $request->education,
                'job_type'         => $request->job_type,
                'status'           => $request->status === 'active' ? 1 : 0,
                'skills'           => json_encode($skills),
                'num_vacancies'    => $request->vacancies,
                // 🔥 Optional: re-approval after edit
                'admin_status'     => 0,
            ]);

            // ✅ Notify Admin (dynamic)
            $admin = User::where('role', 'admin')->first();

            if ($admin) {
                $message = 'Job updated and waiting for approval';

                $notification = Notification::create([
                    'user_id'   => $admin->id,
                    'job_id'    => $job->id,
                    'title'     => Notification::typeName(Notification::TYPE_JOB_UPDATE),
                    'message'   => $message,
                    'type'      => Notification::TYPE_JOB_UPDATE,
                    'send_from' => auth()->id(),
                    'send_to'   => $admin->id,
                ]);

                event(new UserNotification($notification));
                \Log::info('Update Notification fired');
            }

            // ✅ Success
            return redirect()
                ->route('employer.jobs.show', $job->id)
                ->with('success', 'Job "' . $job->title . '" updated successfully!');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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
            ->route('employer.jobs.index')
            ->with('success', 'Job "' . $title . '" has been deleted.');
    }


    /* ==============================
       JOBS — TOGGLE STATUS
    ============================== */

    public function jobsToggle($id)
    {
        try {
            $job = Job::findOrFail($id);

            $job->status = ($job->status == '1') ? '0' : '1';
            $job->save();

            $action = $job->status === '1' ? 'activated' : 'deactivated';

            return response()->json([
                'status' => $job->status,
                'message' => 'Job "' . $job->title . '" has been ' . $action . '.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    /* ==============================
       BILLING / PLANS
    ============================== */

    public function billing()
    {
         $jobPlans = JobPlan::where('is_active', 1)
        ->where('status', 1)
        ->orderBy('price')
        ->get();
        $resumeplans = ResumePlan::where('is_active',1)->where('status',1)->orderBy('price')->get();
        $bannerplans = BannerPlan::where('is_active',1)->orderBy('price')->get();
        // dd($resumeplans);
        return view('frontend.employer.billing', compact('jobPlans','resumeplans','bannerplans'));
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
        $employer_id = auth()->id();

        $jobs = Job::where('create_user_id', $employer_id)
            ->where('admin_status', 1)
            ->pluck('id');

        $applications = JobApplication::with(['user','job'])
            ->whereIn('job_id', $jobs)
            ->latest()
            ->get();
        $candidates = $applications->map(function ($app, $i) {

            $name = $app->user->name ?? 'Unknown';
            // dd($app->job->education);
            // dd($app->job->skills);
            $skills = [];
            $candidateSkills = [];

            if (is_array($app->job->skills)) {
                $skills = collect($app->job->skills)
                    ->map(fn($s) => trim($s))
                    ->filter()
                    ->values()
                    ->toArray();
            } elseif (is_string($app->job->skills)) {
                $skills = collect(explode(',', $app->job->skills))
                    ->map(fn($s) => trim($s))
                    ->filter()
                    ->values()
                    ->toArray();
            }
            // Candidate skills (IMPORTANT)
            if (is_array($app->user->userdetails->skills ?? null)) {
                $candidateSkills = collect($app->user->userdetails->skills)->map(fn($s) => strtolower(trim($s)))->toArray();
            } elseif (is_string($app->user->userdetails->skills ?? null)) {
                $candidateSkills = collect(explode(',', $app->user->userdetails->skills))
                    ->map(fn($s) => strtolower(trim($s)))
                    ->filter()
                    ->values()
                    ->toArray();
            }
            
            $matchedSkills = array_intersect($skills, $candidateSkills);
            $totalJobSkills = count($skills);
            $matchPercentage = $totalJobSkills > 0
                ? round((count($matchedSkills) / $totalJobSkills) * 100)
                : 50;
            $statusMap = [
                1 => 'Pending',
                2 => 'Waiting',
                3 => 'Approved',
                4 => 'Rejected',
                5 => 'Shortlisted',
                6 => 'Interview',
            ];
            return [
                'id' => $app->id,
                'name' => $name,
                'applicant_name' => $name,
                'init' => strtoupper(substr($name, 0, 1)),
                'av' => $i % 6,

                'job' => $app->job->title ?? 'N/A',
                'job_id' => $app->job_id,

                'status' => $statusMap[$app->application_status] ?? 'New',

                'match' => $matchPercentage, // temporary (you can replace with real logic)

                'years_experience' => $app->experience ?? '0 yrs',
                'exp' => $app->job->experience ?? '0 yrs',

                'edu' => $app->job->education ?? 'Not specified',
                'loc' => $app->current_location ?? 'Tamil Nadu',

                'date' => $app->created_at->format('d M Y'),
               
               'skills' => !empty($skills) ? $skills : ['Communication','Teamwork'],
            ];
             
        });
        return view('frontend.employer.candidates', compact('candidates'));

    }
    public function candidatesShow($jobId)
    {
        $applications = JobApplication::with(['user','job'])
        ->where('job_id', $jobId) 
        ->latest()
        ->get();

        $candidates = $applications->map(function ($app, $i) {

            $name = $app->user->name ?? 'Unknown';
            // dd($app->job->education);
            // dd($app->job->skills);
            $skills = [];
            $candidateSkills = [];

            if (is_array($app->job->skills)) {
                $skills = collect($app->job->skills)
                    ->map(fn($s) => trim($s))
                    ->filter()
                    ->values()
                    ->toArray();
            } elseif (is_string($app->job->skills)) {
                $skills = collect(explode(',', $app->job->skills))
                    ->map(fn($s) => trim($s))
                    ->filter()
                    ->values()
                    ->toArray();
            }
            // Candidate skills (IMPORTANT)
            if (is_array($app->user->userdetails->skills ?? null)) {
                $candidateSkills = collect($app->user->userdetails->skills)->map(fn($s) => strtolower(trim($s)))->toArray();
            } elseif (is_string($app->user->userdetails->skills ?? null)) {
                $candidateSkills = collect(explode(',', $app->user->userdetails->skills))
                    ->map(fn($s) => strtolower(trim($s)))
                    ->filter()
                    ->values()
                    ->toArray();
            }
            
            $matchedSkills = array_intersect($skills, $candidateSkills);
            $totalJobSkills = count($skills);
            $matchPercentage = $totalJobSkills > 0
                ? round((count($matchedSkills) / $totalJobSkills) * 100)
                : 50;
            $statusMap = [
                1 => 'Pending',
                2 => 'Waiting',
                3 => 'Approved',
                4 => 'Rejected',
                5 => 'Shortlisted',
                6 => 'Interview',
            ];
            return [
                'id' => $app->id,
                'name' => $name,
                'applicant_name' => $name,
                'init' => strtoupper(substr($name, 0, 1)),
                'av' => $i % 6,

                'job' => $app->job->title ?? 'N/A',
                'job_id' => $app->job_id,

                'status' => $statusMap[$app->application_status] ?? 'New',

                'match' => $matchPercentage, // temporary (you can replace with real logic)

                'years_experience' => $app->experience ?? '0 yrs',
                'exp' => $app->job->experience ?? '0 yrs',

                'edu' => $app->job->education ?? 'Not specified',
                'loc' => $app->current_location ?? 'Tamil Nadu',

                'date' => $app->created_at->format('d M Y'),
               
               'skills' => !empty($skills) ? $skills : ['Communication','Teamwork'],
            ];
             
        });
        return view('frontend.employer.candidates', compact('candidates'));
    }

   public function resume(Request $request)
    {
        $employer_id = auth()->id();

        // ✅ Active Resume Plan
        $resumePlan = ResumePlanSubscription::where('user_id', $employer_id)
            ->where('status', 1)
            ->whereDate('end_date', '>=', now())
            ->latest()
            ->first();

        $jobs = Job::where('create_user_id', $employer_id)
            ->where('admin_status', 1)
            ->pluck('id');

        $applications = JobApplication::with(['user','job'])
            ->whereIn('job_id', $jobs);

        // 🔍 Skill Filter
        if ($request->skill) {

            $applications->whereHas('job', function ($q) use ($request) {

                $q->where('skills', 'like', '%' . $request->skill . '%');
            });
        }

        // 🔍 Experience Filter
        if ($request->experience) {

            $applications->whereHas('job', function ($q) use ($request) {

                $q->where('experience', $request->experience);
            });
        }

        // 🔍 Education Filter
        if ($request->education) {

            $applications->whereHas('job', function ($q) use ($request) {

                $q->where('education', $request->education);
            });
        }

        // 🔍 Location Filter
        if ($request->location) {

            $applications->where('current_location', $request->location);
        }

        // 🔍 Industry Filter
        if ($request->industry) {

            $applications->whereHas('job', function ($q) use ($request) {

                $q->where('industry', $request->industry);
            });
        }

        $applications = $applications->latest()->get();

        $resumes = $applications->map(function ($app, $i) {

            $name = $app->user->name ?? 'Unknown';

            $skills = [];

            if (!empty($app->job->skills)) {

                // JSON string
                if (is_string($app->job->skills)) {

                    $decoded = json_decode($app->job->skills, true);

                    $skills = is_array($decoded)
                        ? $decoded
                        : explode(',', $app->job->skills);

                }

                // Already array
                elseif (is_array($app->job->skills)) {

                    $skills = $app->job->skills;
                }
            }

            // clean skills
            $skills = collect($skills)
                ->map(fn($s) => trim($s, '[]" '))
                ->filter()
                ->values()
                ->toArray();

            return [

                'id' => $app->id,

                'name' => $name,

                'init' => strtoupper(substr($name, 0, 1)),

                'job' => $app->job->title ?? 'N/A',

                'exp' => $app->job->experience ?? '0 yrs',

                'edu' => $app->job->education ?? 'Not specified',

                'loc' => $app->current_location ?? 'Tamil Nadu',

                'industry' => $app->job->industry ?? '-',

                'skills' => !empty($skills)
                    ? $skills
                    : ['Communication','Teamwork'],
            ];
        });
        $locations = Location::orderBy('district')->get();

        return view('frontend.employer.resume', compact(
            'resumes',
            'resumePlan',
            'locations'
        ));
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
        $notificationQuery = Notification::where('send_to', auth()->id());
        $all = (clone $notificationQuery)->count();
        $unread = (clone $notificationQuery)->where('is_read', 0)->count();
        $application = (clone $notificationQuery)->where('type', 2)->count();
        $admin = (clone $notificationQuery)->where('is_admin', 1)->count();

        return view('frontend.employer.notifications',compact('all','unread','application','admin'));
    }

    public function settings()
    {
        // Load the settings view
        return view('frontend.employer.settings');
    }
    public function downloadResume($id)
    {
        $app = JobApplication::findOrFail($id);

        if (!$app->resume) {
            return back()->with('error', 'Resume not found');
        }
        $path = public_path('storage/' . $app->resume);
        // dd($app,$path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path);
    }
    public function viewResume($id)
    {
        try {

            $user = auth()->user();

            $plan = ResumePlanSubscription::where('user_id', $user->id)
                ->where('status', 1)
                ->whereDate('end_date', '>=', now())
                ->first();

            if (!$plan) {
                return redirect()->back()->with('error', 'Please purchase a resume plan');
            }

            // resume already viewed/downloaded check
            $alreadyUsed = ResumeActivityLog::where('employer_id', $user->id)
                ->where('job_application_id', $id)
                ->exists();

            // first time only increment
            if (!$alreadyUsed) {

                if ($plan->downloads_used >= $plan->download_limit) {
                    return redirect()->back()->with('error', 'Resume limit exceeded');
                }

                $plan->increment('downloads_used');

                ResumeActivityLog::create([
                    'employer_id' => $user->id,
                    'job_application_id' => $id,
                    'type' => 'view'
                ]);
            }

            $application = JobApplication::findOrFail($id);

            return view('frontend.employer.resume', compact('application'));

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:job_applications,id',
            'status' => 'required|in:4,5,6', // Reject, Shortlist, Interview
            'interview_date' => 'nullable|date',
            'interview_mode' => 'nullable|in:online,offline',
        ]);
        $app = JobApplication::findOrFail($request->id);

        $app->application_status = $request->status;
        if ($request->status == 6) {
            $app->interview_date = $request->interview_date;
            $app->interview_mode = $request->interview_mode;
        }else {
            // clear old interview data if any
            $app->interview_date = null;
            $app->interview_mode = null;
        }

        // dd($request->all(),$app);

        $app->save();
        $statusMessages = [
            1 => 'Your job is pending approval',
            2 => 'Your job is waiting for review',
            3 => 'Your job has been approved',
            4 => 'Your job was rejected: ',
            5 => 'Your job has been shortlisted',
            6 => 'Interview scheduled for your job',
        ];
        $type = Notification::TYPE_JOB_APPLICATION;
         $statusMessages[$app->application_status] ?? 'Unknown status';

        if($request->status == 5 ){
            $type       = Notification::TYPE_JOB_APPLICATION_SHORTLIST;
            $message    = Notification::typeName(Notification::TYPE_JOB_APPLICATION_SHORTLIST);
        }elseif($request->status == 6){
            $type = Notification::TYPE_JOB_APPLICATION_INTERVIEW;
            $message    = Notification::typeName(Notification::TYPE_JOB_APPLICATION_INTERVIEW);
        }elseif($request->status == 4){
            $type = Notification::TYPE_JOB_APPLICATION_REJECT;
            $message    = Notification::typeName(Notification::TYPE_JOB_APPLICATION_REJECT);
        }

        $notification = Notification::create([  
            'user_id' => $app->user_id,
            'title'   => 'Application Status Updated',
            'message' => $message,
            'type'      => $type,
            'send_from' => auth()->id(), // admin/employer
            'send_to'   => $app->user_id,
        ]);
        // event(new UserNotification($notification));
        \Log::info('Notification fired');
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        // Validate input
        $request->validate([
            'password' => 'required',
        ]);

        // Check password
        if(!Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'msg' => 'Incorrect password']);
        }

        // Soft delete user
        $user->update([
            'is_delete' => 1,
            'd_message' => $request->d_message ?? 'Deleted by user'
        ]);

        // Optional: log the user out
        auth()->logout();

        return response()->json(['status' => true, 'msg' => 'Account deleted successfully']);
    }

    public function settingsPassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // check current password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        // update password
        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}   