<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\ResumePlanSubscription;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function index()
    {
        $resume = Resume::where('user_id',auth()->id())->where('is_default',1)->first();
        return view('frontend.jobseeker.resume',compact('resume'));
    }

   public function upload(Request $request)
    {
        $user = auth()->user();

        // ✅ Validation
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'resume_title' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('resume')) {

            $file = $request->file('resume');

            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

             $path = $file->storeAs('resumes', $filename, 'public');
            // dd($filename);
            Resume::create([
                'user_id'     => $user->id,
                'file_path'   => $path,
                'file_name'   => $filename,
                'title'       => $request->resume_title ?? $file->getClientOriginalName(),
                'file_type'   => $file->getClientOriginalExtension(),
                'file_size'   => $file->getSize(),
                'is_default'  => $user->resumes()->count() == 0 ? 1 : 1,
                'uploaded_at' => now(),
            ]);
        }

        // ✅ If AJAX request
        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Resume uploaded successfully'
            ]);
        }

        // ✅ Normal form submit → redirect back
        return back()->with('success', 'Resume uploaded successfully');
    }

    public function delete($id)
    {
        $resume = Resume::where('user_id', auth()->id())->findOrFail($id);

        // delete file
        if (Storage::disk('public')->exists($resume->file_path)) {
            Storage::disk('public')->delete($resume->file_path);
        }

        $resume->delete();

        return response()->json([
            'status' => true,
            'message' => 'Resume deleted successfully'
        ]);
    }
    public function setDefault($id)
    {
        $user = auth()->user();

        // reset all
        Resume::where('user_id', $user->id)->update(['is_default' => 0]);

        // set selected
        Resume::where('id', $id)->update(['is_default' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Default resume updated'
        ]);
    }

    public function visibility(Request $request)
    {
        // public / private
        return back()->with('success','Resume visibility updated');
    }

   public function download($id)
{
    try {

        $user = auth()->user();

        $plan = ResumePlanSubscription::where('user_id', $user->id)
            ->where('status', 1)
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$plan) {
            return response('Please purchase a plan', 403);
        }

        if ($plan->downloads_used >= $plan->download_limit) {
            return response('Download limit exceeded', 403);
        }

        // ✅ FIX: use JobApplication instead of Resume
        $application = JobApplication::findOrFail($id);
        if (!$application->resume) {
            return response('File not found', 404);
        }
        // dd($application->resume );

        $filePath = storage_path('app/public/' . $application->resume);

        if (!file_exists($filePath)) {
            return response('File missing in server', 404);
        }

        // ✅ increment AFTER validation
        $plan->increment('downloads_used');

        return response()->download($filePath);

    } catch (\Exception $e) {
        return response($e->getMessage(), 500);
    }
}
    public function checkDownload($id)
{
    $user = auth()->user();

    $plan = ResumePlanSubscription::where('user_id', $user->id)
        ->where('status', 1)
        ->whereDate('end_date', '>=', now())
        ->first();

    if (!$plan) {
        return response()->json([
            'status' => 'error',
            'message' => 'Please purchase a plan'
        ]);
    }

    if ($plan->downloads_used >= $plan->download_limit) {
        return response()->json([
            'status' => 'error',
            'message' => 'Download limit exceeded'
        ]);
    }

    return response()->json([
        'status' => 'success',
        'download_url' => route('resume.download', $id)
    ]);
}
}