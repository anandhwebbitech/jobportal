<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\JobAlert;
use App\Models\JobApplication;
use App\Models\Notification;
use App\Models\SaveJob;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {

            $notificationcount                  = 0;
            $jobseeker_applied_job_count        = 0;
            $jobseeker_saved_job_count          = 0;
            $jobseeker_interview_sechudle_count = 0;
            $jobseeker_job_alert_count          = 0;
            $jobseeker_recentApplications       = null;

            $employer_job_post_count            = 0;
            $employer_active_job_count          = 0;
            $employer_expired_job_count         = 0;
            $employer_job_application_count     = 0;
            $employer_job_shortlist_count       = 0;
            $employer_recentApplications        = null;
            $employer_job_posted                = null;
            $employer_notification              = null;
            $dashboardnotification              = null;
            if (Auth::check()) {
                $user = Auth::user();
                $notificationcount = Notification::where('send_to', Auth::id())->where('is_read', 0)->count();
                $dashboardnotification = Notification::where('send_to', Auth::id())->where('is_read', 0)->latest()->take(10)->get();
                if ($user->role === 'user') {

                    $jobseeker_applied_job_count        = JobApplication::where('user_id', $user->id)->count();

                    $jobseeker_saved_job_count          = SaveJob::where('user_id', $user->id)->count();

                    $jobseeker_interview_sechudle_count = JobApplication::where('user_id', $user->id)->count();

                    $jobseeker_job_alert_count          = JobAlert::where('user_id', $user->id)->count();
                    $jobseeker_recentApplications       = JobApplication::with('job')->where('user_id', $user->id)->get();
                }
                if($user->role === 'employer'){
                    $employer_job_post_count        = job::where('create_user_id',$user->id)->count();
                    $employer_job                   = job::where('create_user_id',$user->id)->where('admin_status',1)->pluck('id')->toArray();
                    $employer_active_job_count      = job::where('admin_status',1)->count();
                    $employer_expired_job_count     =  job::where('status',0)->count();
                    $employer_job_application_count = JobApplication::where('status',0)->whereIn('job_id',$employer_job)->count();
                    $employer_job_shortlist_count   = JobApplication::where('status',0)->whereIn('job_id',$employer_job)->count();


                    $employer_recentApplications    = JobApplication::with(['user','job'])->where('status',1)->whereIn('job_id',$employer_job)->latest()->take(10)->get();
                    $employer_job_posted            = job::withCount('jobApplications')->where('status',1)->where('create_user_id',$user->id)->where('admin_status',1)->latest()->take(10)->get();
                    $employer_notification          = Notification::where('send_to', Auth::id())->where('is_read', 0)->latest()->take(10)->get();
                }
            }

            $view->with([
                'notificationcount'                     => $notificationcount,
                'jobseeker_applied_job_count'           => $jobseeker_applied_job_count,
                'jobseeker_saved_job_count'             => $jobseeker_saved_job_count,
                'jobseeker_interview_sechudle_count'    => $jobseeker_interview_sechudle_count,
                'jobseeker_job_alert_count'             => $jobseeker_job_alert_count,
                'jobseeker_recentApplications'          => $jobseeker_recentApplications,
                    // employer
                'employer_job_post_count'               => $employer_job_post_count,
                'employer_active_job_count'             => $employer_active_job_count,
                'employer_expired_job_count'            => $employer_expired_job_count,
                'employer_job_application_count'        => $employer_job_application_count,
                'employer_job_shortlist_count'          => $employer_job_shortlist_count,
                'employer_recentApplications'           => $employer_recentApplications,
                'employer_job_posted'                   => $employer_job_posted,
                'employer_notification'                 => $employer_notification,

                'dashboardnotification'                 => $dashboardnotification

            ]);
        });
    }
}
