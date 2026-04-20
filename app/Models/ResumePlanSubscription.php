<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumePlanSubscription extends Model
{
    //
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(ResumePlan::class, 'plan_id');
    }
}
