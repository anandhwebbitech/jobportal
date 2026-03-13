{{-- saved.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Saved Jobs')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Saved Jobs</div>
    <div class="lj-page-subtitle">Jobs you've bookmarked. Apply before they expire!</div>
  </div>
  <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary">
    <i class="fa-solid fa-magnifying-glass"></i> Find More Jobs
  </a>
</div>

@php
  $savedJobs  = $savedJobs ?? null;
  $hasSaved   = $savedJobs && $savedJobs->count() > 0;
  $isFallback = !$savedJobs;
  $samples = [
    ['Senior PHP Developer','CoreDev Technologies','Chennai','₹45k–65k/mo','Full-time','3–5 Years','3 days ago'],
    ['Laravel + Vue Developer','PixelCraft Studios','Coimbatore','₹30k–50k/mo','Remote','2+ Years','5 days ago'],
    ['React.js Frontend Developer','Synapse Web','Madurai','₹25k–40k/mo','Full-time','1–2 Years','1 week ago'],
    ['Node.js Backend Developer','CloudSpark','Erode','₹35k–55k/mo','Hybrid','2–4 Years','2 weeks ago'],
    ['UI/UX Designer','Pixelcraft','Coimbatore','₹20k–35k/mo','Full-time','1–3 Years','3 weeks ago'],
  ];
@endphp

@if($hasSaved || $isFallback)
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:16px;">
    @if($hasSaved)
      @foreach($savedJobs as $saved)
        <div class="lj-saved-job-card">
          <div style="display:flex;align-items:flex-start;gap:11px;margin-bottom:10px;">
            <div style="width:40px;height:40px;border-radius:9px;background:var(--n100);border:1px solid var(--n200);display:flex;align-items:center;justify-content:center;color:var(--n500);font-size:.82rem;flex-shrink:0;overflow:hidden;">
              @if($saved->job->company->logo ?? false)
                <img src="{{ asset('storage/'.$saved->job->company->logo) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
              @else
                <i class="fa-solid fa-building"></i>
              @endif
            </div>
            <div style="min-width:0;">
              <div class="lj-sjc-title">{{ $saved->job->title }}</div>
              <div class="lj-sjc-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> {{ $saved->job->company->name ?? $saved->job->company_name }} · {{ $saved->job->district }}</div>
            </div>
          </div>
          <div class="lj-sjc-tags">
            @if($saved->job->salary_range) <span class="lj-rec-tag salary">{{ $saved->job->salary_range }}</span> @endif
            @if($saved->job->job_type)     <span class="lj-rec-tag type">{{ $saved->job->job_type }}</span>   @endif
            @if($saved->job->experience_required) <span class="lj-rec-tag">{{ $saved->job->experience_required }}</span> @endif
          </div>
          @if($saved->job->expiry_date && \Carbon\Carbon::parse($saved->job->expiry_date)->isPast())
            <div style="font-size:.72rem;color:var(--red);margin:7px 0;display:flex;align-items:center;gap:4px;">
              <i class="fa-solid fa-triangle-exclamation"></i> This job has expired
            </div>
          @elseif($saved->job->expiry_date)
            <div style="font-size:.72rem;color:var(--orange);margin:7px 0;display:flex;align-items:center;gap:4px;">
              <i class="fa-solid fa-clock"></i> Closes {{ \Carbon\Carbon::parse($saved->job->expiry_date)->diffForHumans() }}
            </div>
          @endif
          <div class="lj-divider" style="margin:9px 0;"></div>
          <div class="lj-sjc-footer">
            <span style="font-size:.71rem;color:var(--n400);">Saved {{ $saved->created_at->diffForHumans() }}</span>
            <div style="display:flex;gap:6px;">
              <form method="POST" action="{{ route('jobseeker.dashboard.saved.remove', $saved->id) }}" onsubmit="return confirm('Remove from saved?')">
                @csrf @method('DELETE')
                <button type="submit" class="lj-btn lj-btn-danger lj-btn-sm"><i class="fa-solid fa-trash"></i></button>
              </form>
              <a href="{{ route('jobs.apply', $saved->job_id) }}" class="lj-btn lj-btn-primary lj-btn-sm">
                <i class="fa-solid fa-paper-plane"></i> Apply
              </a>
            </div>
          </div>
        </div>
      @endforeach
    @else
      @foreach($samples as $s)
        <div class="lj-saved-job-card">
          <div style="display:flex;align-items:flex-start;gap:11px;margin-bottom:10px;">
            <div style="width:40px;height:40px;border-radius:9px;background:var(--n100);border:1px solid var(--n200);display:flex;align-items:center;justify-content:center;color:var(--n500);font-size:.82rem;flex-shrink:0;">
              <i class="fa-solid fa-building"></i>
            </div>
            <div style="min-width:0;">
              <div class="lj-sjc-title">{{ $s[0] }}</div>
              <div class="lj-sjc-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> {{ $s[1] }} · {{ $s[2] }}</div>
            </div>
          </div>
          <div class="lj-sjc-tags">
            <span class="lj-rec-tag salary">{{ $s[3] }}</span>
            <span class="lj-rec-tag type">{{ $s[4] }}</span>
            <span class="lj-rec-tag">{{ $s[5] }}</span>
          </div>
          <div class="lj-divider" style="margin:9px 0;"></div>
          <div class="lj-sjc-footer">
            <span style="font-size:.71rem;color:var(--n400);">Saved {{ $s[6] }}</span>
            <div style="display:flex;gap:6px;">
              <button class="lj-btn lj-btn-danger lj-btn-sm"><i class="fa-solid fa-trash"></i></button>
              <button class="lj-btn lj-btn-primary lj-btn-sm"><i class="fa-solid fa-paper-plane"></i> Apply</button>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

  @if($hasSaved && $savedJobs->hasPages())
    <div style="margin-top:20px;display:flex;justify-content:center;align-items:center;gap:8px;">
      @if(!$savedJobs->onFirstPage())
        <a href="{{ $savedJobs->previousPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
          <i class="fa-solid fa-chevron-left"></i> Prev
        </a>
      @endif
      <span style="font-size:.8rem;color:var(--n500);">Page {{ $savedJobs->currentPage() }} of {{ $savedJobs->lastPage() }}</span>
      @if($savedJobs->hasMorePages())
        <a href="{{ $savedJobs->nextPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
          Next <i class="fa-solid fa-chevron-right"></i>
        </a>
      @endif
    </div>
  @endif

@else
  <div class="lj-card">
    <div class="lj-empty">
      <i class="fa-solid fa-bookmark"></i>
      <div class="lj-empty-title">No saved jobs yet</div>
      <div class="lj-empty-sub">Browse jobs and click the bookmark icon to save them for later.</div>
      <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary" style="margin-top:10px;">
        <i class="fa-solid fa-magnifying-glass"></i> Browse Jobs
      </a>
    </div>
  </div>
@endif

@endsection