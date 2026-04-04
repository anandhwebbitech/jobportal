<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $guarded = [];

    const TYPE_JOB = 1;
    const TYPE_JOB_APPLICATION = 2;

    // ✅ Optional: Get type label
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            self::TYPE_JOB => 'Job',
            self::TYPE_JOB_APPLICATION => 'Job Application',
            default => 'Other',
        };
    }
}
