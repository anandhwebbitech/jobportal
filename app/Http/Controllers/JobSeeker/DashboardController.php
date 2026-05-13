<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $completion = 0;

        if (auth()->check()) {

            $user = auth()->user();

            $details = $user->details; // relation

            if ($details) {

                $fields = [

                    $user->name,
                    $user->email,
                    $user->profile_image,

                    $details->mobile,
                    $details->dob,
                    $details->gender,
                    $details->bio,
                    $details->state,
                    $details->district,
                    $details->city,
                    $details->experience_years,
                    $details->experience_level,
                    $details->school_name,
                    $details->school_specialization,
                    $details->college_name,
                    $details->college_year,
                    $details->college_percentage,
                    $details->ug_course,
                    $details->pg_course,
                    $details->skills,
                    $details->resume,
                    $details->cover_image,

                ];

                $totalFields = count($fields);

                $filledFields = collect($fields)
                    ->filter(function ($value) {
                        return !empty($value);
                    })
                    ->count();

                $completion = round(($filledFields / $totalFields) * 100);
            }
        }
        return view('frontend.jobseeker.dashboard',compact('completion'));
    }
}