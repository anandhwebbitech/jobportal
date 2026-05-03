{{-- dashboard.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Dashboard')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">
      Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }},
      {{ auth()->user() ? explode(' ', auth()->user()->name)[0] : 'Guest' }} 👋
    </div>
    <div class="lj-page-subtitle">Here's what's happening with your job search today.</div>
  </div>
  <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary">
    <i class="fa-solid fa-magnifying-glass"></i> Find Jobs
  </a>
</div>

{{-- Profile Completion Card --}}
<div class="lj-progress-card">
    <div class="lj-pc-inner">

        <div class="lj-pc-text">

            <div class="lj-pc-label">
                Profile Strength
            </div>

            <div class="lj-pc-title">
                Complete your profile to get hired faster
            </div>

            <div class="lj-pc-sub">
                Employers are 3× more likely to contact you with a complete profile.
            </div>

            {{-- Progress Bar --}}
            <div class="lj-pc-bar-wrap">
                <div class="lj-pc-bar-track">

                    <div
                        class="lj-pc-bar-fill"
                        id="progressBar"
                        style="width:0%;">
                    </div>

                </div>
            </div>

            {{-- Checklist --}}
            <div class="lj-pc-checklist">

                <span class="lj-pc-check {{ ($completionSteps['basic_info'] ?? false) ? 'done' : '' }}">
                    <i class="fa-solid {{ ($completionSteps['basic_info'] ?? false) ? 'fa-check' : 'fa-circle' }}"></i>
                    Basic Info
                </span>

                <span class="lj-pc-check {{ ($completionSteps['education'] ?? false) ? 'done' : '' }}">
                    <i class="fa-solid {{ ($completionSteps['education'] ?? false) ? 'fa-check' : 'fa-circle' }}"></i>
                    Education
                </span>

                <span class="lj-pc-check {{ ($completionSteps['skills'] ?? false) ? 'done' : '' }}">
                    <i class="fa-solid {{ ($completionSteps['skills'] ?? false) ? 'fa-check' : 'fa-circle' }}"></i>
                    Skills
                </span>

                <span class="lj-pc-check {{ ($completionSteps['resume'] ?? false) ? 'done' : '' }}">
                    <i class="fa-solid {{ ($completionSteps['resume'] ?? false) ? 'fa-check' : 'fa-circle' }}"></i>
                    Resume
                </span>

                <span class="lj-pc-check {{ ($completionSteps['photo'] ?? false) ? 'done' : '' }}">
                    <i class="fa-solid {{ ($completionSteps['photo'] ?? false) ? 'fa-check' : 'fa-circle' }}"></i>
                    Photo
                </span>

            </div>

        </div>

        {{-- Percentage --}}
        <div class="lj-pc-pct" id="progressPct">
            0<small>%</small>
        </div>

    </div>
</div>


{{-- Stat Cards --}}
<div class="lj-stat-grid">
  <div class="lj-stat-card blue">
    <div class="lj-stat-icon blue"><i class="fa-solid fa-paper-plane"></i></div>
    <div class="lj-stat-val">{{ $jobseeker_applied_job_count ?? 0 }}</div>
    <div class="lj-stat-label">Jobs Applied</div>
    <div class="lj-stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i> +{{ $appliedThisWeek ?? 0 }} this week</div>
  </div>
  <div class="lj-stat-card green">
    <div class="lj-stat-icon green"><i class="fa-solid fa-bookmark"></i></div>
    <div class="lj-stat-val">{{ $jobseeker_saved_job_count ?? 0 }}</div>
    <div class="lj-stat-label">Saved Jobs</div>
    <div class="lj-stat-delta neutral"><i class="fa-solid fa-minus"></i> Browse to save more</div>
  </div>
  <div class="lj-stat-card orange">
    <div class="lj-stat-icon orange"><i class="fa-solid fa-calendar-check"></i></div>
    <div class="lj-stat-val">{{ $jobseeker_interview_sechudle_count ?? 0 }}</div>
    <div class="lj-stat-label">Interviews</div>
    <div class="lj-stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i>
      {{ ($jobseeker_interview_sechudle_count ?? 0) > 0 ? '+'.($jobseeker_interview_sechudle_count).' scheduled' : 'None yet' }}
    </div>
  </div>
  <div class="lj-stat-card purple">
    <div class="lj-stat-icon purple"><i class="fa-solid fa-bell"></i></div>
    <div class="lj-stat-val">{{ $jobseeker_job_alert_count ?? 0 }}</div>
    <div class="lj-stat-label">Job Alerts</div>
    <div class="lj-stat-delta up"><i class="fa-solid fa-arrow-trend-up"></i> {{ ($jobseeker_job_alert_count ?? 0) }} new matches</div>
  </div>
</div>

{{-- 2-column: Recommended + Recent Applications --}}
<div class="lj-grid-2">

  <div class="lj-card">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Recommended for You</div>
      <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-ghost lj-btn-sm">View all</a>
    </div>
    @forelse($recommendedJobs ?? [] as $job)
      <div class="lj-rec-job" onclick="window.location='{{ route('jobs.show', $job->id) }}'">
        <div class="lj-rec-job-title">{{ $job->title }}</div>
        <div class="lj-rec-job-co">
          <i class="fa-solid fa-building" style="font-size:.62rem;"></i>
          {{ $job->company->name ?? $job->company_name }} · {{ $job->district }}
        </div>
        <div class="lj-rec-job-tags">
          @if($job->salary_range) <span class="lj-rec-tag salary">{{ $job->salary_range }}</span> @endif
          @if($job->job_type)     <span class="lj-rec-tag type">{{ $job->job_type }}</span>   @endif
          @if($job->experience_required) <span class="lj-rec-tag">{{ $job->experience_required }}</span> @endif
        </div>
        @if(isset($job->match_percent))
          <div class="lj-rec-job-match"><i class="fa-solid fa-circle-check"></i> {{ $job->match_percent }}% Match</div>
        @endif
      </div>
    @empty
      <div class="lj-rec-job" onclick="window.location='{{ route('jobs.index') }}'">
        <div class="lj-rec-job-title">PHP Laravel Developer</div>
        <div class="lj-rec-job-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> TechSoft Solutions · Coimbatore</div>
        <div class="lj-rec-job-tags">
          <span class="lj-rec-tag salary">₹30k–45k/mo</span>
          <span class="lj-rec-tag type">Full-time</span>
          <span class="lj-rec-tag">2–4 Years</span>
        </div>
        <div class="lj-rec-job-match"><i class="fa-solid fa-circle-check"></i> 94% Match</div>
      </div>
      <div class="lj-rec-job" onclick="window.location='{{ route('jobs.index') }}'">
        <div class="lj-rec-job-title">Full Stack Developer</div>
        <div class="lj-rec-job-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> InfoBridge Systems · Coimbatore</div>
        <div class="lj-rec-job-tags">
          <span class="lj-rec-tag salary">₹35k–55k/mo</span>
          <span class="lj-rec-tag type">Remote</span>
          <span class="lj-rec-tag">1–3 Years</span>
        </div>
        <div class="lj-rec-job-match"><i class="fa-solid fa-circle-check"></i> 88% Match</div>
      </div>
      <div class="lj-rec-job" onclick="window.location='{{ route('jobs.index') }}'">
        <div class="lj-rec-job-title">React.js Developer</div>
        <div class="lj-rec-job-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> Nexus Digital · Chennai</div>
        <div class="lj-rec-job-tags">
          <span class="lj-rec-tag salary">₹40k–60k/mo</span>
          <span class="lj-rec-tag type">Hybrid</span>
          <span class="lj-rec-tag">3+ Years</span>
        </div>
        <div class="lj-rec-job-match"><i class="fa-solid fa-circle-check"></i> 82% Match</div>
      </div>
      <div style="padding:12px 16px;">
        <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-outline lj-btn-sm" style="width:100%;justify-content:center;">
          <i class="fa-solid fa-magnifying-glass"></i> Explore All Jobs
        </a>
      </div>
    @endforelse
  </div>

  <div class="lj-card">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-clock-rotate-left"></i> Recent Applications</div>
      <a href="{{ route('jobseeker.applied.index') }}" class="lj-btn lj-btn-ghost lj-btn-sm">View all</a>
    </div>
    <div style="padding:0 20px;">
      @forelse($jobseeker_recentApplications ?? [] as $application)
        <div class="lj-app-row">
          <div class="lj-app-logo">
              <i class="fa-solid fa-building"></i>
          </div>
          <div class="lj-app-info">
            <div class="lj-app-title">{{ $application->job->title ?? '—' }}</div>
            <div class="lj-app-company">{{ $application->job->company->name ?? $application->job->company_name ?? '—' }} · {{ $application->job->district ?? '' }}</div>
            <div class="lj-app-date">Applied {{ $application->created_at->diffForHumans() }}</div>
          </div>
          <span class="lj-status-badge {{ $application->status ? 'Pending':'applied' }}">
            {{ ucfirst($application->status ? 'Pending' : 'Applied') }}
          </span>
        </div>
      @empty
        <div class="lj-app-row">
          <div class="lj-app-logo"><i class="fa-solid fa-building"></i></div>
          <div class="lj-app-info">
            <div class="lj-app-title">PHP Developer</div>
            <div class="lj-app-company">TechSoft Solutions · Coimbatore</div>
            <div class="lj-app-date">Applied 2 days ago</div>
          </div>
          <span class="lj-status-badge interview">Interview</span>
        </div>
        <div class="lj-app-row">
          <div class="lj-app-logo"><i class="fa-solid fa-building"></i></div>
          <div class="lj-app-info">
            <div class="lj-app-title">Web Developer</div>
            <div class="lj-app-company">Digital Hive · Salem</div>
            <div class="lj-app-date">Applied 4 days ago</div>
          </div>
          <span class="lj-status-badge shortlisted">Shortlisted</span>
        </div>
        <div class="lj-app-row">
          <div class="lj-app-logo"><i class="fa-solid fa-building"></i></div>
          <div class="lj-app-info">
            <div class="lj-app-title">Backend Developer</div>
            <div class="lj-app-company">Nexara Tech · Erode</div>
            <div class="lj-app-date">Applied 1 week ago</div>
          </div>
          <span class="lj-status-badge applied">Applied</span>
        </div>
        <div class="lj-app-row">
          <div class="lj-app-logo"><i class="fa-solid fa-building"></i></div>
          <div class="lj-app-info">
            <div class="lj-app-title">Software Engineer</div>
            <div class="lj-app-company">Radiant IT · Tiruppur</div>
            <div class="lj-app-date">Applied 10 days ago</div>
          </div>
          <span class="lj-status-badge rejected">Rejected</span>
        </div>
        <div style="padding:12px 0 4px;">
          <a href="{{ route('jobseeker.applied.index') }}" class="lj-btn lj-btn-outline lj-btn-sm" style="width:100%;justify-content:center;">
            <i class="fa-solid fa-list"></i> View All Applications
          </a>
        </div>
      @endforelse
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const pct = {{ $completion ?? 0 }};

    setTimeout(() => {

        const progressBar = document.getElementById('progressBar');
        const progressPct = document.getElementById('progressPct');

        if (progressBar) {
            progressBar.style.width = pct + '%';
        }

        if (progressPct) {
            progressPct.innerHTML = pct + '<small>%</small>';
        }

    }, 300);

});
</script>
@endpush