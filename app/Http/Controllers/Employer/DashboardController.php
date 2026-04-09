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
use App\Models\JobPlan;
use App\Services\NotificationService;


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
        try {

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
                'skills'              => 'required|string',
                'terms'               => 'accepted',
            ]);

            // responsibilities & benefits (fixed)

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

            $job = Job::create([
                'company_name'     => $company->company_name ?? null,
                'category'         => $request->job_category,
                'industry'         => $request->industry_type,
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
                'expiry_date'      => Carbon::now()->addDays(10),
                'create_user_id'   => auth()->id(),
            ]);
            if($job){
                $message = 'New Application Received';
                $notification = Notification::create([
                    'user_id'   => 3,
                    'job_id'    => $job->id,
                    'title'     => 'New Job Post',
                    'message'   => $message,
                    'type'      => Notification::JOB_POST,
                    'send_from' => auth()->id(), // admin/employer
                    'send_to'   => 3,
                ]);
                event(new UserNotification($notification));
                \Log::info('Notification fired');
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
                'skills'              => 'required|string',
            ]);

            // ✅ responsibilities & benefits (clean)

            // ✅ skills decode
            $skills = json_decode($request->skills, true);
            if (json_last_error() !== JSON_ERROR_NONE || empty($skills)) {
                return back()->withInput()->withErrors([
                    'skills' => 'Invalid skills format'
                ]);
            }

            // ✅ salary split (same as store)
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

            $company = EmployerDetail::where('user_id', auth()->id())->first();
            // ✅ UPDATE
            $job->update([
                'company_name'     => $company->company_name ?? null,
                'category'         => $request->job_category,
                'industry'         => $request->industry_type,
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
            ]);

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
        return view('frontend.employer.billing', compact('jobPlans'));
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

    public function resume()
    {
        // Example: show a list of resumes or redirect to candidates page
        // $resumes = JobApplication::latest()->get();
        $employer_id = auth()->id();

        $jobs = Job::where('create_user_id', $employer_id)
            ->where('admin_status', 1)
            ->pluck('id');

        $applications = JobApplication::with(['user','job'])
            ->whereIn('job_id', $jobs)
            ->latest()
            ->get();

        $resumes = $applications->map(function ($app, $i) {

            $name = $app->user->name ?? 'Unknown';
            // dd($app->job->education);
            // dd($app->job->skills);
            $skills = [];

            if (!empty($app->job->skills)) {

                // if JSON string → decode
                if (is_string($app->job->skills)) {
                    $decoded = json_decode($app->job->skills, true);

                    $skills = is_array($decoded)
                        ? $decoded
                        : explode(',', $app->job->skills);
                }

                // if already array
                elseif (is_array($app->job->skills)) {
                    $skills = $app->job->skills;
                }
            }

            // clean values
            $skills = collect($skills)
                ->map(fn($s) => trim($s, '[]" '))
                ->filter()
                ->values()
                ->toArray();
            return [
                'id' => $app->id,
                'name' => $name,
                'applicant_name' => $name,
                'init' => strtoupper(substr($name, 0, 1)),
                'av' => $i % 6,

                'job' => $app->job->title ?? 'N/A',
                'job_id' => $app->job_id,

                'status' => $statusMap[$app->application_status] ?? 'New',

                'match' => rand(60, 95), // temporary (you can replace with real logic)

                'years_experience' => $app->experience ?? '0 yrs',
                'exp' => $app->job->experience ?? '0 yrs',

                'edu' => $app->job->education ?? 'Not specified',
                'loc' => $app->current_location ?? 'Tamil Nadu',

                'date' => $app->created_at->format('d M Y'),
                'industry' => $app->job->industry ?? '-',
               
               'skills' => !empty($skills) ? $skills : ['Communication','Teamwork'],
            ];
             
        });

        return view('frontend.employer.resume', compact('resumes'));
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
        $app = JobApplication::findOrFail($id);

        if (!$app->resume) {
            abort(404, 'Resume not found');
        }

        $path = storage_path('app/public/' . $app->resume);

        return response()->file($path); // 👁 view in browser
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:job_applications,id',
            'status' => 'required|in:4,5,6', // Reject, Shortlist, Interview
        ]);

        $app = JobApplication::findOrFail($request->id);

        $app->application_status = $request->status;

        $app->save();
        $statusMessages = [
            1 => 'Your job is pending approval',
            2 => 'Your job is waiting for review',
            3 => 'Your job has been approved',
            4 => 'Your job was rejected: ',
            5 => 'Your job has been shortlisted',
            6 => 'Interview scheduled for your job',
        ];

        $message = $statusMessages[$app->application_status] ?? 'Unknown status';
        $notification = Notification::create([
            'user_id' => $app->user_id,
            'title'   => 'Application  Status',
            'message' => $message,
            'type'      => Notification::TYPE_JOB_APPLICATION,
            'send_from' => auth()->id(), // admin/employer
            'send_to'   => $app->user_id,
        ]);
        event(new UserNotification($notification));
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
}   