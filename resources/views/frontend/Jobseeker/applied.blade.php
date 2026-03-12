{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/applied.blade.php
     Applied Jobs – LinearJobs Job Seeker Dashboard
═══════════════════════════════════════════════════════ --}}
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
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;" id="statusFilterGroup">
  <span class="chip {{ !request('status') ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.dashboard.applied') }}'">
    All ({{ $totalCount ?? 0 }})
  </span>
  @foreach(['applied'=>'Applied','shortlisted'=>'Shortlisted','interview'=>'Interview','hired'=>'Hired','rejected'=>'Rejected'] as $val => $label)
    <span class="chip {{ request('status') == $val ? 'active' : '' }}"
      onclick="window.location='{{ route('jobseeker.dashboard.applied') }}?status={{ $val }}'">
      {{ $label }} ({{ $statusCounts[$val] ?? 0 }})
    </span>
  @endforeach
</div>

<div class="lj-card">
  @if(($applications ?? collect())->count() > 0)
    <div style="overflow-x:auto;">
      <table class="lj-table">
        <thead>
          <tr>
            <th>Job Position</th>
            <th>Applied Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($applications as $app)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:12px;">
                  <div class="lj-table-logo">
                    @if($app->job->company->logo ?? false)
                      <img src="{{ asset('storage/'.$app->job->company->logo) }}" alt="">
                    @else
                      <i class="fa-solid fa-building"></i>
                    @endif
                  </div>
                  <div>
                    <div class="lj-table-title">{{ $app->job->title ?? '—' }}</div>
                    <div class="lj-table-sub">
                      {{ $app->job->company->name ?? $app->job->company_name ?? '—' }}
                      · {{ $app->job->district ?? '' }}
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <span style="font-size:.8rem;">{{ $app->created_at->format('d M Y') }}</span>
                <div style="font-size:.7rem;color:var(--n400);">{{ $app->created_at->diffForHumans() }}</div>
              </td>
              <td>
                <span class="lj-status-badge {{ $app->status }}">
                  {{ ucfirst($app->status) }}
                </span>
                @if($app->status === 'interview' && $app->interview_date)
                  <div style="font-size:.7rem;color:var(--purple);margin-top:4px;display:flex;align-items:center;gap:4px;">
                    <i class="fa-solid fa-calendar"></i>
                    {{ \Carbon\Carbon::parse($app->interview_date)->format('d M, h:i A') }}
                  </div>
                @endif
              </td>
              <td>
                <div style="display:flex;gap:7px;flex-wrap:wrap;">
                  <a href="{{ route('jobs.show', $app->job_id) }}" class="lj-btn lj-btn-outline lj-btn-sm">
                    <i class="fa-solid fa-eye"></i> View Job
                  </a>
                  <a href="{{ route('jobseeker.dashboard.application', $app->id) }}" class="lj-btn lj-btn-ghost lj-btn-sm">
                    <i class="fa-solid fa-file-lines"></i> Application
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($applications->hasPages())
      <div style="padding:16px 20px;border-top:1px solid var(--n100);display:flex;justify-content:center;gap:6px;">
        @if($applications->onFirstPage())
          <button class="lj-btn lj-btn-outline lj-btn-sm" disabled style="opacity:.5;">
            <i class="fa-solid fa-chevron-left"></i> Prev
          </button>
        @else
          <a href="{{ $applications->previousPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
            <i class="fa-solid fa-chevron-left"></i> Prev
          </a>
        @endif
        <span style="font-size:.82rem;color:var(--n500);align-self:center;">
          Page {{ $applications->currentPage() }} of {{ $applications->lastPage() }}
        </span>
        @if($applications->hasMorePages())
          <a href="{{ $applications->nextPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
            Next <i class="fa-solid fa-chevron-right"></i>
          </a>
        @else
          <button class="lj-btn lj-btn-outline lj-btn-sm" disabled style="opacity:.5;">
            Next <i class="fa-solid fa-chevron-right"></i>
          </button>
        @endif
      </div>
    @endif

  @else
    {{-- Empty state (also shown when no real data) --}}
    @if(($applications ?? null) === null)
      {{-- Fallback: show sample data --}}
      <div style="overflow-x:auto;">
        <table class="lj-table">
          <thead>
            <tr>
              <th>Job Position</th>
              <th>Applied Date</th>
              <th>Status</th>
              <th>Actions</th>
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
                  <div style="display:flex;align-items:center;gap:12px;">
                    <div class="lj-table-logo"><i class="fa-solid fa-building"></i></div>
                    <div>
                      <div class="lj-table-title">{{ $s[0] }}</div>
                      <div class="lj-table-sub">{{ $s[1] }} · {{ $s[2] }}</div>
                    </div>
                  </div>
                </td>
                <td><span style="font-size:.8rem;">{{ $s[3] }}</span></td>
                <td><span class="lj-status-badge {{ $s[4] }}">{{ ucfirst($s[4]) }}</span></td>
                <td>
                  <div style="display:flex;gap:7px;">
                    <button class="lj-btn lj-btn-outline lj-btn-sm"><i class="fa-solid fa-eye"></i> View Job</button>
                    <button class="lj-btn lj-btn-ghost lj-btn-sm"><i class="fa-solid fa-file-lines"></i> Application</button>
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
        <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary" style="margin-top:8px;">
          <i class="fa-solid fa-magnifying-glass"></i> Find Jobs
        </a>
      </div>
    @endif
  @endif
</div>

@endsection