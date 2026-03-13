<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{

    /* =================================
       JOB SEEKER LOGIN
    ================================= */

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
        return view('frontend.auth.register');
    }

    public function jobseekerRegisterSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'jobseeker',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success','Account created successfully');
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
        return view('frontend.auth.register');
    }

    public function employerRegisterSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employer',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success','Account created successfully');
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

}