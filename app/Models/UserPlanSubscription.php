<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlanSubscription extends Model
{
    //
    protected $guarded = [];
    public function plan()
    {
        return $this->belongsTo(JobPlan::class, 'job_plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
