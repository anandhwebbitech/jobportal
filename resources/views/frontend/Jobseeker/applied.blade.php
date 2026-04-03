{{-- applied.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Applied Jobs')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Applied Jobs</div>
    <div class="lj-page-subtitle">Track the status of all your job applications.</div>
  </div>
  <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary">
    <i class="fa-solid fa-magnifying-glass"></i> Find More Jobs
  </a>
</div>

{{-- Status filter chips --}}
<div  class="status-filters" style="display:flex;gap:7px;margin-bottom:18px;flex-wrap:wrap;">
  <span class="chip {{ !request('status') ? 'active' : '' }}"
        onclick="window.location='{{ route('jobseeker.applied.index') }}'">
      All ({{ $totalCount ?? 0 }})
  </span>
  @foreach($statusLabels as $key => $label)
      <span class="chip {{ request('status') == $key ? 'active' : '' }}"
            onclick="window.location='{{ route('jobseeker.applied.index') }}?status={{ $key }}'">
          {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
      </span>
    @endforeach
</div>

<div class="lj-card">
  @if(($applications ?? collect())->count() > 0)
    <div class="lj-table-scroll">
      <table class="lj-table">
        <thead>
          <tr>
            <th style="min-width:240px;">Job Position</th>
            <th style="min-width:110px;">Applied Date</th>
            <th style="min-width:120px;">Status</th>
            <th style="min-width:160px;text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $app)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:11px;">
                  <div class="lj-table-logo">
                    @if($app->job->company->logo ?? false)
                      <img src="{{ asset('storage/'.$app->job->company->logo) }}" alt="">
                    @else
                      <i class="fa-solid fa-building"></i>
                    @endif
                  </div>
                  <div>
                    <div class="lj-table-title">{{ $app->job->title ?? '—' }}</div>
                    <div class="lj-table-sub">{{ $app->job->company_name ?? $app->job->company_name ?? '—' }} · {{ $app->job->district ?? '' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div style="font-size:.82rem;color:var(--n800);font-weight:500;">{{ $app->job->created_at->format('d M Y') }}</div>
                <div style="font-size:.7rem;color:var(--n400);margin-top:2px;">{{ $app->job->created_at->diffForHumans() }}</div>
              </td>
              <td>
                @php
                    $statusLabels = [
                        1 => 'Pending',
                        2 => 'Waiting',
                        3 => 'Approved',
                        4 => 'Rejected',
                        5 => 'Shortlisted',
                        6 => 'Interview',
                    ];
                    $statusClass = [
                      1 => 'Pending',
                      2 => 'Waiting',
                      3 => 'Approved',
                      4 => 'Rejected',
                      5 => 'Shortlisted',
                      6 => 'Interview',
                    ];
                    $currentStatus = $app->application_status;
                @endphp

                <span class="lj-status-badge {{ $statusClass[$currentStatus] ?? 'pending' }}">
                    {{ $statusLabels[$currentStatus] ?? 'Unknown' }}
                </span>

                @if($currentStatus == 4 && $app->interview_date) {{-- Waiting for interview --}}
                    <div style="font-size:.7rem;color:var(--purple);margin-top:4px;display:flex;align-items:center;gap:4px;">
                        <i class="fa-solid fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($app->interview_date)->format('d M, h:i A') }}
                    </div>
                @endif
              </td>
              <td>
                <div style="display:flex;gap:6px;justify-content:flex-end;flex-wrap:wrap;">
                  <a href="{{ route('jobs.show', $app->job_id) }}" class="lj-btn lj-btn-outline lj-btn-sm">
                    <i class="fa-solid fa-eye"></i> View
                  </a>
                  {{-- <a href="{{ route('jobseeker.applied.application', $app->id) }}" class="lj-btn lj-btn-ghost lj-btn-sm">
                    <i class="fa-solid fa-file-lines"></i> Details
                  </a> --}}
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- @if($applications->hasPages())
      <div style="padding:14px 20px;border-top:1px solid var(--n100);display:flex;justify-content:center;align-items:center;gap:8px;">
        @if(!$applications->onFirstPage())
          <a href="{{ $applications->previousPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
            <i class="fa-solid fa-chevron-left"></i> Prev
          </a>
        @else
          <button class="lj-btn lj-btn-outline lj-btn-sm" disabled style="opacity:.4;cursor:not-allowed;">
            <i class="fa-solid fa-chevron-left"></i> Prev
          </button>
        @endif
        <span style="font-size:.8rem;color:var(--n500);">Page {{ $applications->currentPage() }} of {{ $applications->lastPage() }}</span>
        @if($applications->hasMorePages())
          <a href="{{ $applications->nextPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
            Next <i class="fa-solid fa-chevron-right"></i>
          </a>
        @else
          <button class="lj-btn lj-btn-outline lj-btn-sm" disabled style="opacity:.4;cursor:not-allowed;">
            Next <i class="fa-solid fa-chevron-right"></i>
          </button>
        @endif
      </div>
    @endif --}}

  @else
    @if(($applications ?? null) === null)
      {{-- Fallback sample --}}
      <div class="lj-table-scroll">
        <table class="lj-table">
          <thead>
            <tr>
              <th style="min-width:240px;">Job Position</th>
              <th style="min-width:120px;">Applied Date</th>
              <th style="min-width:120px;">Status</th>
              <th style="min-width:160px;text-align:right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @php
              $samples = [
                ['PHP Developer','TechSoft Solutions','Coimbatore','March 10, 2026','interview'],
                ['Web Developer','Digital Hive','Salem','March 8, 2026','shortlisted'],
                ['Backend Developer','Nexara Tech','Erode','March 5, 2026','applied'],
                ['React Developer','Nexus Digital','Chennai','March 4, 2026','interview'],
                ['Software Engineer','Radiant IT','Tiruppur','March 2, 2026','rejected'],
                ['PHP Programmer','BrightEdge IT','Coimbatore','Feb 28, 2026','shortlisted'],
                ['Laravel Dev','Apexspark','Madurai','Feb 25, 2026','hired'],
              ];
            @endphp
            @foreach($samples as $s)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:11px;">
                    <div class="lj-table-logo"><i class="fa-solid fa-building"></i></div>
                    <div>
                      <div class="lj-table-title">{{ $s[0] }}</div>
                      <div class="lj-table-sub">{{ $s[1] }} · {{ $s[2] }}</div>
                    </div>
                  </div>
                </td>
                <td><div style="font-size:.82rem;font-weight:500;color:var(--n800);">{{ $s[3] }}</div></td>
                <td><span class="lj-status-badge {{ $s[4] }}">{{ ucfirst($s[4]) }}</span></td>
                <td>
                  <div style="display:flex;gap:6px;justify-content:flex-end;">
                    <button class="lj-btn lj-btn-outline lj-btn-sm"><i class="fa-solid fa-eye"></i> View</button>
                    <button class="lj-btn lj-btn-ghost lj-btn-sm"><i class="fa-solid fa-file-lines"></i> Details</button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="lj-empty">
        <i class="fa-solid fa-paper-plane"></i>
        <div class="lj-empty-title">No applications yet</div>
        <div class="lj-empty-sub">Start applying to jobs and track your progress here.</div>
        <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary" style="margin-top:10px;">
          <i class="fa-solid fa-magnifying-glass"></i> Find Jobs
        </a>
      </div>
    @endif
  @endif
</div>

@endsection