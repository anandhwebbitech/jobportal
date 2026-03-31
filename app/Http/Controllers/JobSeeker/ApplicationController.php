<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        // $applications   = JobApplication::with('job')->where('user_id',Auth::id())->get();
        // return view('frontend.jobseeker.applied', compact('applications'));
         // Map of status labels
        $statusLabels = [
            1 => 'Pending',
            2 => 'Approved',
            3 => 'Rejected',
            4 => 'Waiting',
        ];

        // Get the requested status from query string (optional)
        $statusFilter = request('status'); // numeric: 1,2,3,4

        // Base query
        $query = JobApplication::with('job')
            ->where('user_id', Auth::id());

        // Apply status filter if exists
        if ($statusFilter && in_array($statusFilter, [1,2,3,4])) {
            $query->where('application_status', $statusFilter);
        }

        // Get applications with pagination (optional, or use get())
        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Total applications
        $totalCount = JobApplication::where('user_id', Auth::id())->count();

        // Count by each status
        $statusCounts = JobApplication::where('user_id', Auth::id())
            ->selectRaw('application_status, COUNT(*) as count')
            ->groupBy('application_status')
            ->pluck('count', 'application_status') // returns [1=>10, 2=>5,...]
            ->toArray();

        return view('frontend.jobseeker.applied', compact('applications', 'totalCount', 'statusCounts', 'statusLabels'));
    }

    public function show($id)
    {
        return view('frontend.jobseeker.applied', compact('id'));
    }

    public function detail($id)
    {
        return view('frontend.jobseeker.applied', compact('id'));
    }
    
}