<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPlanSubscription extends Model
{
    //
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(BannerPlan::class, 'banner_plan_id');
    }
}
