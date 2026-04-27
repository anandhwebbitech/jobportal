<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\SaveJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedjobs = SaveJob::with('job')->where('user_id',Auth::id())->where('savestatus',1)->get();
        return view('frontend.jobseeker.saved',compact('savedjobs'));
    }

    public function save($jobId)
    {
        // save job
        return back()->with('success','Job saved');
    }

    public function remove($id)
    {
        // remove saved job
        return back()->with('success','Job removed');
    }
    public function toggleSave(Request $request)
    {
        $userId = Auth::id();
        $jobId  = $request->job_id;

        // Find existing save record
        $saveJob = SaveJob::firstOrNew([
            'user_id' => $userId,
            'job_id' => $jobId,
        ]);

        // Toggle savestatus
        if ($saveJob->exists) {
            $saveJob->savestatus = $saveJob->savestatus == 1 ? 0 : 1;
        } else {
            $saveJob->savestatus = 1;
            $saveJob->saved_at = now();
            $saveJob->status = 1;
        }

        $saveJob->save();

        return response()->json([
            'success'    => true,
            'savestatus' => $saveJob->savestatus,
            'message'    => $saveJob->savestatus ? 'Job saved!' : 'Job removed from saved list.'
        ]);
    }
    public function getSavedJobs(){
        $savedJobs = SaveJob::where('user_id', auth()->id())->where('savestatus',1)->pluck('job_id');
        return response()->json(['savedJobs' => $savedJobs]);
    }

    public function destroy($id)
    {
        $saved = SaveJob::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->first();

        if(!$saved) {
            return response()->json(['success' => false, 'message' => 'Saved job not found']);
        }

        $saved->delete();

        return response()->json(['success' => true, 'message' => 'Job removed from saved jobs']);
    }
}