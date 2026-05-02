<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\ResumePlanSubscription;
use Illuminate\Support\Facades\Storage;
use App\Models\ResumeActivityLog;
use Illuminate\Support\Facades\File;
class ResumeController extends Controller
{
    public function index()
    {
        $resume = Resume::where('user_id',auth()->id())->where('is_default',1)->latest()->first();
        return view('frontend.jobseeker.resume',compact('resume'));
    }

    public function upload(Request $request)
{
    $request->validate([
        'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    if ($request->hasFile('resume')) {

        $file = $request->file('resume');

        // BEFORE MOVE
        $fileSize = $file->getSize();
        $fileType = $file->getClientOriginalExtension();

        $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

        $destinationPath = public_path('uploads/resumes');

        // create folder
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // move file
        $file->move($destinationPath, $filename);

        Resume::create([
            'user_id'     => auth()->id(),
            'file_path'   => 'uploads/resumes/' . $filename,
            'file_name'   => $filename,
            'title'       => $request->resume_title ?? $file->getClientOriginalName(),
            'file_type'   => $fileType,
            'file_size'   => $fileSize,
            'is_default'  => 1,
            'uploaded_at' => now(),
        ]);

        return back()->with('success', 'Resume uploaded successfully');
    }

    return back()->with('error', 'File not uploaded');
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

//    public function download($id)
//     {
//         try {

//             $user = auth()->user();

//             $plan = ResumePlanSubscription::where('user_id', $user->id)
//                 ->where('status', 1)
//                 ->whereDate('end_date', '>=', now())
//                 ->first();

//             if (!$plan) {
//                 return response('Please purchase a plan', 403);
//             }

//             if ($plan->downloads_used >= $plan->download_limit) {
//                 return response('Download limit exceeded', 403);
//             }

//             // ✅ FIX: use JobApplication instead of Resume
//             $application = JobApplication::findOrFail($id);
//             if (!$application->resume) {
//                 return response('File not found', 404);
//             }

//             $filePath = storage_path('app/public/' . $application->resume);

//             if (!file_exists($filePath)) {
//                 return response('File missing in server', 404);
//             }

//             // ✅ increment AFTER validation
//             $plan->increment('downloads_used');

//             return response()->download($filePath);

//         } catch (\Exception $e) {
//             return response($e->getMessage(), 500);
//         }
//     }
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

            // already viewed/downloaded check
            $alreadyUsed = ResumeActivityLog::where('employer_id', $user->id)
                ->where('job_application_id', $id)
                ->exists();

            // first time only increment
            if (!$alreadyUsed) {

                if ($plan->downloads_used >= $plan->download_limit) {
                    return response('Download limit exceeded', 403);
                }

                $plan->increment('downloads_used');

                ResumeActivityLog::create([
                    'employer_id' => $user->id,
                    'job_application_id' => $id,
                    'type' => 'download'
                ]);
            }

            $application = JobApplication::findOrFail($id);

            if (!$application->resume) {
                return response('File not found', 404);
            }

            $filePath = storage_path('app/public/' . $application->resume);

            if (!file_exists($filePath)) {
                return response('File missing in server', 404);
            }

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
    public function viewResume($id)
    {
        try {

            $user = auth()->user();

            $plan = ResumePlanSubscription::where('user_id', $user->id)
                ->where('status', 1)
                ->whereDate('end_date', '>=', now())
                ->first();

            if (!$plan) {
                return back()->with('error', 'Please purchase a resume plan');
            }

            // already viewed/downloaded check
            $alreadyUsed = ResumeActivityLog::where('employer_id', $user->id)
                ->where('job_application_id', $id)
                ->exists();

            // first time only increment
            if (!$alreadyUsed) {

                if ($plan->downloads_used >= $plan->download_limit) {
                    return back()->with('error', 'Resume limit exceeded');
                }

                $plan->increment('downloads_used');

                ResumeActivityLog::create([
                    'employer_id' => $user->id,
                    'job_application_id' => $id,
                    'type' => 'view'
                ]);
            }

            $application = JobApplication::findOrFail($id);

            if (!$application->resume) {
                abort(404, 'Resume not found');
            }

            $filePath = storage_path('app/public/' . $application->resume);

            if (!file_exists($filePath)) {
                abort(404, 'File missing');
            }

            // 🔥 OPEN IN BROWSER
            return response()->file($filePath);

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}