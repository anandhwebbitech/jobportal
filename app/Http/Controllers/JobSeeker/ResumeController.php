<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use Illuminate\Support\Facades\Storage;
class ResumeController extends Controller
{
    public function index()
    {
        return view('frontend.jobseeker.resume');
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

            $path = $file->storeAs('resumes/' . $user->id, $filename, 'public');

            Resume::create([
                'user_id'     => $user->id,
                'file_path'   => $path,
                'file_name'   => $file->getClientOriginalName(),
                'title'       => $request->resume_title ?? $file->getClientOriginalName(),
                'file_type'   => $file->getClientOriginalExtension(),
                'file_size'   => $file->getSize(),
                'is_default'  => $user->resumes()->count() == 0 ? 1 : 0,
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
}