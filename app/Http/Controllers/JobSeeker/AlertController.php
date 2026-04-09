<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobAlert;

class AlertController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.alerts');
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'keyword'   => 'required|string|max:255',
                'frequency' => 'required|in:daily,weekly,instant',
            ]);

            // 🔹 Salary split
            $salaryMin = null;
            $salaryMax = null;

            if ($request->salary) {
                if ($request->salary == '50000+') {
                    $salaryMin = 50000;
                } else {
                    [$salaryMin, $salaryMax] = explode('-', $request->salary);
                }
            }

            $alert = JobAlert::create([
                'user_id'           => auth()->id(),
                'title'             => $request->keyword,
                'keywords'          => $request->keyword,
                'location'          => $request->location,
                'job_type'          => $request->job_type,
                'experience_level'  => $request->experience,
                'salary_min'        => $salaryMin,
                'salary_max'        => $salaryMax,
                'frequency'         => $request->frequency,
                'is_active'         => 1,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Job alert created successfully',
                'data'    => $alert
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {

            \Log::error('Job Alert Error: '.$e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
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
        $alert = JobAlert::where('user_id', auth()->id())
            ->findOrFail($id);

        $alert->is_active = !$alert->is_active;
        $alert->save();

        return response()->json([
            'status' => true,
            'message' => 'Status updated'
        ]);
    }

    public function destroy($id)
    {
        $alert = JobAlert::where('user_id', auth()->id())
            ->findOrFail($id);

        $alert->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }
    public function list()
    {
        $alerts = JobAlert::where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $alerts
        ]);
    }
}