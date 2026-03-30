<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('details')->find(auth()->id());
        // dd($user);
        return view('frontend.jobseeker.profile', compact('user'));
    }

    public function update(Request $request)
    {
        // Update basic profile
        $user = auth()->user();
        // ✅ Validation
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:15',

            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',

            // optional fields
            'dob'     => 'nullable|date',
            'gender'  => 'nullable|in:male,female,other',
            'bio'     => 'nullable|string',

            'state'    => 'required|string',
            'district' => 'required|string',
            'city'     => 'nullable|string',
        ]);

        // ✅ Update users table
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // ✅ Profile Photo Upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->avatar = $path;
            $user->save();
        }

        // ✅ Update or Create user_details
        $user->userdetails()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'mobile'   => $request->mobile,
                'dob'      => $request->dob,
                'gender'   => $request->gender,
                'bio'      => $request->bio,

                'state'    => $request->state,
                'district' => $request->district,
                'city'     => $request->city,
            ]
        );

        // ✅ AJAX Response
        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully'
        ]);
    }

    public function education(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'education_level' => 'required',
            'institution' => 'required|string|max:255',
            'passing_year' => 'required|digits:4',
            'course' => 'nullable|string',
            'specialization' => 'nullable|string',
            'grade' => 'nullable|string',
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'qualification'     => $request->education_level,
                'institution_name'  => $request->institution,
                'course_degree'     => $request->course,
                'specialization'    => $request->specialization,
                'year_of_passing'   => $request->passing_year,
                'percentage'        => $request->grade,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Education updated successfully'
        ]);
    }

    public function experience(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'experience_level' => 'required|in:fresher,experienced',
            'years_experience' => 'nullable',
            'previous_company' => 'nullable|string|max:255',
            'previous_designation' => 'nullable|string|max:255',
            'current_salary' => 'nullable|string|max:255',
            'experience_description' => 'nullable|string',
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'exp'                   => $request->experience_level,
                'ex_years'              => $request->years_experience,
                'previous_company'      => $request->previous_company,
                'previous_designation'  => $request->previous_designation,
                'last_salary'           => $request->current_salary,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Experience updated successfully'
        ]);
    }

    public function skills(Request $request)
    {
         $request->validate([
            'skills' => 'required|array|min:1',
            'skills.*' => 'string|max:50'
        ]);

        $user = auth()->user();

        $skills = implode(',', $request->skills);

        $user->details()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'skills' => $skills
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Skills updated successfully'
        ]);
    }
}