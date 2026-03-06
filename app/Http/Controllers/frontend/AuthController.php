<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class AuthController extends Controller
{

    /* =================================
       JOB SEEKER LOGIN
    ================================= */

    public function jobseekerLogin()
    {
        return view('frontend.auth.jobseeker-login');
    }

    public function jobseekerLoginSubmit(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'jobseeker'
        ])){

            return redirect()->route('home');
        }

        return back()->with('error','Invalid email or password');
    }


    /* =================================
       JOB SEEKER REGISTER
    ================================= */

    public function jobseekerRegister()
    {
        return view('frontend.auth.jobseeker-register');
    }

    public function jobseekerRegisterSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'jobseeker',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }



    /* =================================
       EMPLOYER LOGIN
    ================================= */

    public function employerLogin()
    {
        return view('frontend.auth.employer-login');
    }

    public function employerLoginSubmit(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'employer'
        ])){

            return redirect()->route('home');
        }

        return back()->with('error','Invalid email or password');
    }



    /* =================================
       EMPLOYER REGISTER
    ================================= */

    public function employerRegister()
    {
        return view('frontend.auth.employer-register');
    }

    public function employerRegisterSubmit(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employer',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }



    /* =================================
       LOGOUT
    ================================= */

    public function logout()
    {

        Auth::logout();

        return redirect()->route('home');
    }

}