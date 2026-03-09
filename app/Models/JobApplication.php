<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'mobile',
        'resume',
        'cover_letter'
    ];

    // Relationship with Job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}