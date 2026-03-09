<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;

class JobApiController extends Controller
{
    // ── LIST JOBS ──
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

        $jobs = $query->latest()->get();

        return response()->json($jobs);
    }

    // ── SINGLE JOB PREVIEW ──
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return response()->json($job);
    }

    // ── APPLY TO JOB ──
    public function apply(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'cover_letter' => 'nullable|string',
        ]);

        $job = Job::findOrFail($id);

        // Store resume
        $resumePath = $request->file('resume')->store('resumes');

        JobApplication::create([
            'job_id' => $job->id,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'resume' => $resumePath,
            'cover_letter' => $request->cover_letter,
        ]);

        return response()->json([
            'message' => 'Application submitted successfully',
        ]);
    }
}