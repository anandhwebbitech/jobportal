<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $guarded = [];

    const TYPE_JOB = 1;
    const TYPE_JOB_APPLICATION = 2;
    const TYPE_JOB_APPLICATION_INTERVIEW = 3;
    const JOB_POST = 4;

    // ✅ Optional: Get type label
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            self::TYPE_JOB => 'Job',
            self::TYPE_JOB_APPLICATION => 'Job Application',
            self::TYPE_JOB_APPLICATION_INTERVIEW => 'Interview',
            self::JOB_POST => 'New Job Post',
            default => 'Other',
        };
    }
    public static function typeName(int $type): string
    {
        return match ($type) {
            self::TYPE_JOB => 'Job',
            self::TYPE_JOB_APPLICATION => 'Job Application',
            self::TYPE_JOB_APPLICATION_INTERVIEW => 'Interview',
            self::JOB_POST => 'New Job Post',
            default => 'Other',
        };
    }
}
