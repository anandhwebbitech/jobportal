<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobAlert;
use App\Models\Job;
use Mail;
class SendJobAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job-alerts:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send job alerts to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $alerts = JobAlert::where('is_active', 1)->get();

        foreach ($alerts as $alert) {

            $jobs = Job::query()

                ->when($alert->keyword, function ($q) use ($alert) {
                    $q->where('title', 'like', '%' . $alert->keyword . '%');
                })

                ->when($alert->location, function ($q) use ($alert) {
                    $q->where('location', $alert->location);
                })

                ->when($alert->job_type, function ($q) use ($alert) {
                    $q->where('job_type', $alert->job_type);
                })

                ->when($alert->experience_level, function ($q) use ($alert) {
                    $q->where('experience', $alert->experience_level);
                })

                ->when($alert->salary_min, function ($q) use ($alert) {
                    $q->where('salary_min', '>=', $alert->salary_min);
                })

                ->latest()
                ->take(10)
                ->get();
                \Log::error($jobs->count());
            if ($jobs->count() > 0) {

                try {

                    Mail::send('emails.job_alert', [
                        'jobs'  => $jobs,
                        'alert' => $alert
                    ], function ($message) use ($alert) {

                        $message->to($alert->user->email)
                            ->subject('New Jobs for ' . $alert->keyword);

                    });
   

                    $this->info("Sent alert to " . $alert->user->email);

                } catch (\Throwable $e) {

                    \Log::error('Mail failed: ' . $e->getMessage());
                }
            }
        }
    }
}
