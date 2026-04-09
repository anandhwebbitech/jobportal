<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPlan extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'features' => 'array',
    ];
}
