<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EmployerDetail;
use App\Models\Job;
use App\Models\Notification;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use App\Events\UserNotification;
use App\Models\Qualification;

class AuthController extends Controller
{

    /* =================================
       JOB SEEKER LOGIN
    ================================= */
    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input data'
                ], 422);
            }

            // ✅ Attempt login
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
            }

            $user = Auth::user();

            // ❌ Check approval
            if ($user->is_active == 0) {
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is pending approval'
                ]);
            }

            if ($user->is_active == 3) {
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Your account was rejected'
                ]);
            }

            // ✅ Role-based redirect
            if ($user->role == 'employer') {
                $redirect = route('employer.dashboard');
            } else {
                $redirect = route('jobseeker.dashboard');
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect' => $redirect
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function jobseekerLogin()
    {
        return view('frontend.auth.login');
    }

    public function jobseekerLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'jobseeker'
        ])) {

            $request->session()->regenerate();

            return redirect()->route('home')->with('success','Login successful');
        }

        return back()->with('error', 'Invalid email or password');
    }


    /* =================================
       JOB SEEKER REGISTER
    ================================= */

    public function jobseekerRegister()
    {
        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();
        return view('frontend.auth.register', compact('skills','qualifications'));
    }

    public function jobseekerRegisterSubmit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|min:2',
                'mobile' => 'required|digits:10',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|same:confirm_password',
                'state' => 'required',
                'district' => 'required',
                'city' => 'required',
                'qualification' => 'required',
                'exp' => 'required',
                'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
                'profile_photo' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // ✅ Create User (basic)
            $user = User::create([
                'name'      => $request->full_name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'is_active' => 0,
                'role'      => 'user',
            ]);

            // ✅ Upload Files
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resume = $request->file('resume');
                $resumeName = time() . '_' . uniqid() . '.' . $resume->extension();
                $resume->move(public_path('uploads/resumes'), $resumeName);
                $resumePath = $resumeName;
            }

            $photoPath = null;
            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $photoName = time() . '_' . uniqid() . '.' . $photo->extension();
                $photo->move(public_path('uploads/photos'), $photoName);
                $photoPath = $photoName;
            }

            // ✅ Skills
            $skills = $request->skills ? json_encode($request->skills) : null;
            if($user){
                UserDetail::create([
                    'user_id' => $user->id,
                    'mobile' => $request->mobile,
                    'state' => $request->state,
                    'district' => $request->district,
                    'city' => $request->city,
                    'qualification' => $request->qualification,
                    'exp' => $request->exp,
                    'ex_years' => $request->ex_years,
                    'previous_company' => $request->previous_company,
                    'previous_designation' => $request->previous_designation,
                    'skills' => $skills,
                    'resume' => $resumePath,
                    'profile_photo' => $photoPath,
                ]);
                $admin = User::where('role','admin')->first();
                $message = Notification::typeName(Notification::TYPE_NEW_USER_REGISTER);
                $notification = Notification::create([
                    'user_id'   =>  $admin->id,
                    'title'     => Notification::typeName(Notification::TYPE_NEW_USER_REGISTER),
                    'message'   => $message,
                    'type'      => Notification::TYPE_NEW_USER_REGISTER,
                    'send_from' => $user->id, // admin/employer
                    'send_to'   => $admin->id,
                ]);
                event(new UserNotification($notification));
                \Log::info('Notification fired');
            }
            // ✅ Create User Details

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Registration successful! Waiting for admin approval.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =================================
       EMPLOYER LOGIN
    ================================= */

    public function employerLogin()
    {
        return view('frontend.auth.login');
    }

    public function employerLoginSubmit(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'employer'
        ])) {

            $request->session()->regenerate();

            return redirect()->route('home')->with('success','Login successful');
        }

        return back()->with('error', 'Invalid email or password');
    }


    /* =================================
       EMPLOYER REGISTER
    ================================= */

    public function employerRegister()
    {
        $skills = Skill::where('status', 1)->get();
        $qualifications = Qualification::where('status',1)->get();

        return view('frontend.auth.register',compact('skills','qualifications'));
    }

    public function employerRegisterSubmit(Request $request)
    {
        // dd(7);
        try {

            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'company_address' => 'required',
                'c_state' => 'required',
                'c_district' => 'required',
                'c_city' => 'required',
                'c_pincode' => 'required|digits:6',

                'c_ownername' => 'required',
                'c_mobile' => 'required|digits:10',

                'c_hr_name' => 'required',
                'c_hr_mobile' => 'required|digits:10',

                'c_email' => 'required|email|unique:users,email',
                'c_password' => 'required|min:8|same:c_confirm_password',

                'c_gst' => 'required|size:15',
                'c_pan' => 'required|size:10',

                'gst_certificate' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
                'pan_document' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
                'msme_certificate' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // ✅ Create User
            $user = User::create([
                'name'      => $request->company_name,
                'email'     => $request->c_email,
                'password'  => Hash::make($request->c_password),
                'role'      => 'employer',
                'is_active' => 0,
            ]);

                
            // ✅ Upload Files
            $uploadPath = public_path('uploads/employer');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $gstFile = null;
            if ($request->hasFile('gst_certificate')) {
                $file = $request->file('gst_certificate');
                $gstFile = time().'_gst.'.$file->extension();
                $file->move($uploadPath, $gstFile);
            }

            $panFile = null;
            if ($request->hasFile('pan_document')) {
                $file = $request->file('pan_document');
                $panFile = time().'_pan.'.$file->extension();
                $file->move($uploadPath, $panFile);
            }

            $msmeFile = null;
            if ($request->hasFile('msme_certificate')) {
                $file = $request->file('msme_certificate');
                $msmeFile = time().'_msme.'.$file->extension();
                $file->move($uploadPath, $msmeFile);
            }
            if($user){

                // ✅ Save Employer Details
                EmployerDetail::create([
                    'user_id' => $user->id,
    
                    'company_name' => $request->company_name,
                    'company_address' => $request->company_address,
                    'state' => $request->c_state,
                    'district' => $request->c_district,
                    'city' => $request->c_city,
                    'pincode' => $request->c_pincode,
    
                    'owner_name' => $request->c_ownername,
                    'owner_mobile' => $request->c_mobile,
    
                    'hr_name' => $request->c_hr_name,
                    'hr_mobile' => $request->c_hr_mobile,
    
                    'email' => $request->c_email,
    
                    'gst_number' => $request->c_gst,
                    'pan_number' => $request->c_pan,
                    'msme_number' => $request->c_msme,
    
                    'gst_certificate' => $gstFile,
                    'pan_document' => $panFile,
                    'msme_certificate' => $msmeFile,
                ]);
                $admin = User::where('role','admin')->first();
                $message = Notification::typeName(Notification::TYPE_NEW_COMPANY_REGISTER);
                $notification = Notification::create([
                    'user_id'   =>  $admin->id,
                    'title'     => Notification::typeName(Notification::TYPE_NEW_COMPANY_REGISTER),
                    'message'   => $message,
                    'type'      => Notification::TYPE_NEW_COMPANY_REGISTER,
                    'send_from' => $user->id, // admin/employer
                    'send_to'   => $admin->id,
                ]);
                event(new UserNotification($notification));
                \Log::info('Notification fired');
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Employer registration successful! Waiting for admin approval.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /* =================================
       FORGOT PASSWORD
    ================================= */

    public function forgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    public function forgotPasswordSubmit(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? back()->with('success', __($status))
                : back()->with('error', __($status));
    }


    /* =================================
       RESET PASSWORD PAGE
    ================================= */

    public function resetPassword($token)
    {
        return view('frontend.auth.reset-password', [
            'token' => $token
        ]);
    }


    /* =================================
       RESET PASSWORD SUBMIT
    ================================= */

    public function resetPasswordSubmit(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success','Password reset successfully')
            : back()->with('error','Unable to reset password');
    }


    /* =================================
       LOGOUT
    ================================= */

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function preview($id)
    {
        $job = Job::findOrFail($id);
        // dd($job);
        // convert JSON fields to array
        // $job->responsibilities = json_decode($job->responsibilities, true);
        // $job->benefits = json_decode($job->benefits, true);
        // $job->skills = json_decode($job->skills, true);

        return response()->json($job);
    }

}