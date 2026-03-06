<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function jobs()
    {
        return view('frontend.jobs.index');
    }

    public function jobDetails($slug)
    {
        return view('frontend.jobs.details');
    }

    public function pricing()
    {
        return view('frontend.pricing');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function postJob()
    {
        return view('frontend.post-job');
    }

}