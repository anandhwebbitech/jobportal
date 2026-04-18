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
    const TYPE_JOB_POST = 4;
    const TYPE_NEW_USER_REGISTER = 5;
    const TYPE_NEW_COMPANY_REGISTER   = 6;

    const TYPE_EMPLOYER_APPROVED   = 7;
    const TYPE_EMPLOYER_REJECT  = 8;
    const TYPE_EMPLOYER_PENDING  = 9;

    const TYPE_JOB_APPROVE  = 10;
    const TYPE_JOB_REJECT  = 11;

    const TYPE_JOB_APPLICATION_SHORTLIST = 12;
    const TYPE_JOB_APPLICATION_REJECT = 13;
    const TYPE_JOB_UPDATE = 14;


    // ✅ Optional: Get type label
    public function getTypeLabelAttribute()
    {
        return self::typeName($this->type);
    }
    public static function typeName(int $type): string
    {
        return match ($type) {
            self::TYPE_JOB => 'Job',
            self::TYPE_JOB_APPLICATION => 'Job Application',
            self::TYPE_JOB_APPLICATION_INTERVIEW => 'Secdule for Interview',
            self::TYPE_JOB_POST => 'New Job Post',
            self::TYPE_NEW_USER_REGISTER => 'New user register',
            self::TYPE_NEW_COMPANY_REGISTER => 'New company register',
            self::TYPE_EMPLOYER_APPROVED => 'Employee has approved',
            self::TYPE_EMPLOYER_REJECT => 'Employee has Reject',
            self::TYPE_EMPLOYER_PENDING => 'Employee has pending for under review ',
            self::TYPE_JOB_APPROVE => 'Job was Approved',
            self::TYPE_JOB_REJECT => 'Job was reject',
            self::TYPE_JOB_APPLICATION_SHORTLIST => 'Application was shortlisted',
            self::TYPE_JOB_APPLICATION_REJECT => 'Application was rejected',
            self::TYPE_JOB_UPDATE => 'Update posted Job',

            default => 'Other',
        };
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'send_from');
    }
}
