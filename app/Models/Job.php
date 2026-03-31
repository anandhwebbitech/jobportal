<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobApplication;

class Job extends Model
{
   
    protected $guarded = [];

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
    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id'); // adjust if needed
    }

    

}