<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobApplication;

class Job extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'company_name',
        'location',
        'district',
        'state',
        'experience',
        'salary_min',
        'salary_max',
        'job_type',
        'description',
        'responsibilities',
        'benefits',
        'education',
        'skills',
        'expiry_date',
        'status'
    ];

    // Cast expiry_date to Carbon
    protected $casts = [
        'expiry_date' => 'date',
    ];

    // Job → Applications relationship
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    // ── Accessors ──

    // Convert comma-separated skills string to array
    public function getSkillsAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    // Convert newline-separated responsibilities string to array
    public function getResponsibilitiesAttribute($value)
    {
        return $value ? explode("\n", $value) : [];
    }

    // Convert newline-separated benefits string to array
    public function getBenefitsAttribute($value)
    {
        return $value ? explode("\n", $value) : [];
    }
}