{{-- ════════════════════════════════════════════════════════
     resources/views/employer/jobs/show.blade.php
     View Job Details – LinearJobs Employer Dashboard
════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title', ($job->job_title ?? 'Job Details').' – View')
@section('page-title', 'Job Details')

@push('styles')
<style>
.js-wrap { max-width: 960px; margin: 0 auto; }

/* ── Hero ── */
.js-hero {
  background: linear-gradient(120deg, #1a56db 0%, #1e3a8a 55%, #312e81 100%);
  border-radius: var(--r-xl); padding: 28px 30px 80px;
  position: relative; overflow: hidden; margin-bottom: 0;
}
.js-hero::before { content:''; position:absolute; top:-90px; right:-90px; width:360px; height:360px; border-radius:50%; background:rgba(255,255,255,.04); pointer-events:none; }
.js-hero::after  { content:''; position:absolute; bottom:-60px; left:-50px; width:280px; height:280px; border-radius:50%; background:rgba(255,255,255,.03); pointer-events:none; }
.js-hero-inner   { position:relative; z-index:1; }
.js-hero-top     { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; }
.js-hero-left    { flex:1; min-width:0; }
.js-hero-badge   {
  display:inline-flex; align-items:center; gap:7px;
  background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.22);
  border-radius:100px; padding:4px 14px;
  font-size:.68rem; font-weight:800; color:rgba(255,255,255,.9);
  letter-spacing:.07em; text-transform:uppercase; margin-bottom:12px;
}
.js-hero-title { font-family:var(--f); font-size:clamp(1.2rem,2.5vw,1.75rem); font-weight:900; color:#fff; letter-spacing:-.4px; margin-bottom:6px; }
.js-hero-company { font-size:.85rem; color:rgba(255,255,255,.75); margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.js-hero-chips   { display:flex; flex-wrap:wrap; gap:8px; }
.js-chip {
  display:inline-flex; align-items:center; gap:6px;
  background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.2);
  border-radius:100px; padding:5px 13px;
  font-size:.72rem; font-weight:700; color:rgba(255,255,255,.9);
}
.js-chip i { font-size:.65rem; }
.js-hero-actions { display:flex; gap:10px; flex-wrap:wrap; }
.js-ha-btn {
  display:inline-flex; align-items:center; gap:7px;
  border-radius:10px; padding:10px 18px;
  font-family:var(--f); font-size:.8rem; font-weight:800;
  cursor:pointer; border:none; text-decoration:none; transition:all .2s;
}
.js-ha-edit    { background:rgba(255,255,255,.15); color:#fff; border:1.5px solid rgba(255,255,255,.25); }
.js-ha-edit:hover { background:rgba(255,255,255,.22); }
.js-ha-view    { background:#fff; color:var(--blue); }
.js-ha-view:hover { opacity:.92; }
.js-ha-del     { background:rgba(239,68,68,.2); color:#fca5a5; border:1.5px solid rgba(239,68,68,.3); }
.js-ha-del:hover { background:rgba(239,68,68,.3); }

/* ── Cards grid ── */
.js-grid { display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-top:-44px; position:relative; z-index:10; }
.js-col  { display:flex; flex-direction:column; gap:18px; }

/* ── Card ── */
.js-card {
  background:#fff; border-radius:var(--r-lg);
  border:1.5px solid var(--n200); box-shadow:var(--sh);
  overflow:hidden;
}
.js-card-head {
  background:linear-gradient(90deg, var(--blue) 0%, var(--blue-d) 100%);
  padding:13px 20px; display:flex; align-items:center; gap:11px;
}
.js-card-head-ico { width:32px; height:32px; border-radius:8px; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:.8rem; color:#fff; flex-shrink:0; }
.js-card-head-title { font-family:var(--f); font-size:.85rem; font-weight:800; color:#fff; }
.js-card-head-right { margin-left:auto; }
.js-card-body { padding:20px; }

/* ── Stat row ── */
.js-stat-row { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:18px; }
.js-stat {
  background:var(--n50); border:1.5px solid var(--n200);
  border-radius:12px; padding:14px 12px; text-align:center;
  border-top:3px solid var(--blue);
}
.js-stat.green  { border-top-color:var(--green); }
.js-stat.orange { border-top-color:var(--orange); }
.js-stat.purple { border-top-color:var(--purple); }
.js-stat-val { font-family:var(--f); font-size:1.4rem; font-weight:900; color:var(--n900); margin-bottom:3px; }
.js-stat-lbl { font-size:.68rem; font-weight:700; color:var(--n400); text-transform:uppercase; letter-spacing:.06em; }

/* ── Prose content ── */
.js-prose {
  font-family:var(--f-body); font-size:.875rem; color:var(--n700);
  line-height:1.7; white-space:pre-line;
}
.js-prose ul { margin:8px 0 8px 18px; }
.js-prose li { margin-bottom:4px; }

/* ── Info rows ── */
.js-info-row { display:flex; align-items:flex-start; gap:12px; padding:11px 0; border-bottom:1px solid var(--n100); }
.js-info-row:last-child { border-bottom:none; }
.js-info-ico { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:.8rem; flex-shrink:0; }
.js-info-ico.blue   { background:rgba(26,86,219,.1); color:var(--blue); }
.js-info-ico.green  { background:rgba(5,150,105,.1); color:var(--green); }
.js-info-ico.orange { background:rgba(245,158,11,.1); color:var(--orange); }
.js-info-ico.purple { background:rgba(124,58,237,.1); color:var(--purple); }
.js-info-ico.red    { background:rgba(239,68,68,.1);  color:var(--red); }
.js-info-label { font-family:var(--f); font-size:.65rem; font-weight:800; color:var(--n400); text-transform:uppercase; letter-spacing:.07em; margin-bottom:3px; }
.js-info-value { font-family:var(--f); font-size:.86rem; font-weight:700; color:var(--n800); }

/* ── Skills ── */
.js-skills-wrap { display:flex; flex-wrap:wrap; gap:7px; }
.js-skill-chip {
  display:inline-flex; align-items:center; gap:5px;
  background:rgba(26,86,219,.07); border:1.5px solid rgba(26,86,219,.18);
  border-radius:100px; padding:4px 12px;
  font-family:var(--f); font-size:.74rem; font-weight:700; color:#1e40af;
}
.js-skill-chip i { font-size:.6rem; }

/* ── Status badge ── */
.js-status-badge {
  display:inline-flex; align-items:center; gap:6px;
  border-radius:8px; padding:6px 14px;
  font-family:var(--f); font-size:.75rem; font-weight:800;
}
.js-status-badge .dot { width:7px; height:7px; border-radius:50%; }
.js-status-badge.active  { background:#dcfce7; color:#166534; }
.js-status-badge.active .dot { background:#22c55e; animation:blink 1.4s infinite; }
.js-status-badge.inactive{ background:var(--n100); color:var(--n500); }
.js-status-badge.inactive .dot{ background:var(--n400); }
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}

/* ── Screening ── */
.js-sq-item { border:1.5px solid var(--n200); border-radius:12px; overflow:hidden; margin-bottom:12px; }
.js-sq-item:last-child { margin-bottom:0; }
.js-sq-head { background:var(--n50); padding:11px 16px; display:flex; align-items:center; gap:10px; }
.js-sq-num  { width:24px; height:24px; border-radius:6px; background:var(--blue); color:#fff; display:flex; align-items:center; justify-content:center; font-family:var(--f); font-size:.65rem; font-weight:900; flex-shrink:0; }
.js-sq-q    { font-family:var(--f); font-size:.82rem; font-weight:700; color:var(--n800); flex:1; }
.js-sq-type { font-size:.62rem; font-weight:800; letter-spacing:.06em; text-transform:uppercase; padding:3px 9px; border-radius:5px; flex-shrink:0; }
.js-sq-type.select { background:#ede9fe; color:#6d28d9; }
.js-sq-type.input  { background:var(--green-lt); color:#166534; }
.js-sq-body { padding:12px 16px; }
.js-sq-opt  { display:flex; align-items:center; gap:8px; padding:6px 0; font-size:.82rem; color:var(--n600); }
.js-sq-opt-ltr { width:22px; height:22px; border-radius:5px; background:var(--n100); color:var(--n600); display:flex; align-items:center; justify-content:center; font-family:var(--f); font-size:.64rem; font-weight:800; flex-shrink:0; }
.js-sq-text-note { background:var(--n50); border:1.5px dashed var(--n200); border-radius:8px; padding:10px 14px; font-size:.8rem; color:var(--n400); display:flex; align-items:center; gap:7px; }

/* ── Applicants mini table ── */
.js-apps-table { width:100%; border-collapse:collapse; font-size:.82rem; }
.js-apps-table th { background:var(--n50); padding:9px 12px; font-family:var(--f); font-size:.65rem; font-weight:800; color:var(--n400); text-transform:uppercase; letter-spacing:.06em; text-align:left; border-bottom:1.5px solid var(--n200); }
.js-apps-table td { padding:11px 12px; border-bottom:1px solid var(--n100); color:var(--n700); vertical-align:middle; }
.js-apps-table tr:last-child td { border-bottom:none; }
.js-apps-table tr:hover td { background:var(--n50); }
.js-apps-empty { text-align:center; padding:32px 20px; }
.js-apps-empty i { font-size:1.6rem; color:var(--n300); display:block; margin-bottom:8px; }
.js-apps-empty p { font-size:.82rem; color:var(--n400); }

/* ── Toggle status ── */
.js-toggle-form { display:inline; }
.js-toggle-btn {
  display:inline-flex; align-items:center; gap:7px;
  border-radius:var(--r); padding:8px 16px;
  font-family:var(--f); font-size:.8rem; font-weight:700;
  cursor:pointer; border:1.5px solid; transition:var(--t);
}
.js-toggle-btn.deactivate { background:var(--orange-lt); color:#92400e; border-color:#fcd34d; }
.js-toggle-btn.deactivate:hover { background:#fef3c7; }
.js-toggle-btn.activate   { background:var(--green-lt); color:#065f46; border-color:#6ee7b7; }
.js-toggle-btn.activate:hover   { background:#d1fae5; }

/* ── Delete modal ── */
.js-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:9999; align-items:center; justify-content:center; padding:20px; }
.js-modal.open { display:flex; }
.js-modal-box { background:#fff; border-radius:var(--r-xl); padding:28px; max-width:420px; width:100%; box-shadow:var(--sh-lg); animation:fadeUp .25s ease; }
@keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

/* ── Responsive ── */
@media(max-width:860px){
  .js-grid { grid-template-columns:1fr; }
  .js-stat-row { grid-template-columns:1fr 1fr; }
  .js-hero-top { flex-direction:column; }
  .js-hero-actions { width:100%; }
}
@media(max-width:500px){
  .js-stat-row { grid-template-columns:1fr 1fr; }
  .js-hero { padding:20px 18px 68px; }
}
</style>
@endpush

@section('content')
@php
  $j       = $job ?? null;
  $status  = $j->status ?? 'active';
  $skills  = is_string($j->skills ?? null) ? json_decode($j->skills, true) : ($j->skills ?? []);
  $sq      = is_string($j->screening_questions ?? null) ? json_decode($j->screening_questions, true) : ($j->screening_questions ?? []);
  $salary  = ($j && ($j->salary_min ?? 0) + ($j->salary_max ?? 0) > 0)
             ? '₹'.number_format($j->salary_min ?? 0).' – ₹'.number_format($j->salary_max ?? 0).' /mo'
             : 'Not Disclosed';
  $loc     = collect([$j->city ?? null, $j->district ?? null, $j->state ?? null])->filter()->implode(', ');
  $apps    = $j->applications ?? collect();
  $posted  = $j ? \Carbon\Carbon::parse($j->created_at)->format('d M Y') : '—';
@endphp

<div class="js-wrap">

{{-- ══ HERO ══ --}}
<div class="js-hero">
  <div class="js-hero-inner">
    <div class="js-hero-top">
      <div class="js-hero-left">
        <div class="js-hero-badge"><i class="fa-solid fa-briefcase"></i> Job Listing</div>
        <div class="js-hero-title">{{ $j->job_title ?? 'Job Title' }}</div>
        <div class="js-hero-company">
          <i class="fa-solid fa-building" style="font-size:.78rem;"></i>
          {{ auth()->user()->company->name ?? auth()->user()->name ?? 'Your Company' }}
          &nbsp;&middot;&nbsp;
          <i class="fa-solid fa-location-dot" style="font-size:.72rem;"></i> {{ $loc ?: '—' }}
        </div>
        <div class="js-hero-chips">
          @if($j)
            <span class="js-chip"><i class="fa-solid fa-clock"></i> {{ $j->job_type ?? 'Full Time' }}</span>
            <span class="js-chip"><i class="fa-solid fa-briefcase"></i> {{ $j->experience_required ?? '—' }}</span>
            <span class="js-chip"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $salary }}</span>
            <span class="js-chip"><i class="fa-solid fa-graduation-cap"></i> {{ $j->education ?? '—' }}</span>
            <span class="js-chip"><i class="fa-solid fa-calendar"></i> Posted {{ $posted }}</span>
          @endif
        </div>
      </div>
      <div class="js-hero-actions">
        <a href="{{ route('employer.jobs.edit', $j->id ?? 0) }}" class="js-ha-btn js-ha-edit">
          <i class="fa-solid fa-pen-to-square"></i> Edit Job
        </a>
        <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}" class="js-ha-btn js-ha-view">
          <i class="fa-solid fa-users"></i> View Applicants
        </a>
        <button type="button" class="js-ha-btn js-ha-del" onclick="document.getElementById('deleteModal').classList.add('open')">
          <i class="fa-solid fa-trash"></i> Delete
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ══ MAIN GRID ══ --}}
<div class="js-grid">

  {{-- ── LEFT COLUMN ── --}}
  <div class="js-col">

    {{-- Stats Row --}}
    <div class="js-stat-row" style="margin-bottom:0;">
      <div class="js-stat">
        <div class="js-stat-val">{{ $apps->count() }}</div>
        <div class="js-stat-lbl">Total Applicants</div>
      </div>
      <div class="js-stat green">
        <div class="js-stat-val">{{ $apps->where('status','shortlisted')->count() }}</div>
        <div class="js-stat-lbl">Shortlisted</div>
      </div>
      <div class="js-stat orange">
        <div class="js-stat-val">{{ $apps->where('status','interview')->count() }}</div>
        <div class="js-stat-lbl">Interview</div>
      </div>
      <div class="js-stat purple">
        <div class="js-stat-val">{{ $j->vacancies ?? 1 }}</div>
        <div class="js-stat-lbl">Vacancies</div>
      </div>
    </div>

    {{-- Description --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-file-lines"></i></div>
        <div class="js-card-head-title">Job Description</div>
      </div>
      <div class="js-card-body">
        <div class="js-prose">{{ $j->description ?? 'No description provided.' }}</div>
      </div>
    </div>

    {{-- Responsibilities --}}
    @if($j && $j->responsibilities)
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-list-check"></i></div>
        <div class="js-card-head-title">Responsibilities</div>
      </div>
      <div class="js-card-body">
        <div class="js-prose">{{ $j->responsibilities }}</div>
      </div>
    </div>
    @endif

    {{-- Benefits --}}
    @if($j && $j->benefits)
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-gift"></i></div>
        <div class="js-card-head-title">Benefits</div>
      </div>
      <div class="js-card-body">
        <div class="js-prose">{{ $j->benefits }}</div>
      </div>
    </div>
    @endif

    {{-- Screening Questions --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-clipboard-question"></i></div>
        <div class="js-card-head-title">Screening Questions</div>
        <div class="js-card-head-right">
          <span style="font-size:.7rem;font-weight:800;color:rgba(255,255,255,.7);">{{ count($sq) }} question(s)</span>
        </div>
      </div>
      <div class="js-card-body">
        @if(count($sq) > 0)
          @foreach($sq as $qi => $q)
            <div class="js-sq-item">
              <div class="js-sq-head">
                <div class="js-sq-num">Q{{ $qi+1 }}</div>
                <div class="js-sq-q">{{ $q['question'] ?? 'Question' }}</div>
                <span class="js-sq-type {{ $q['type'] ?? 'select' }}">
                  {{ ($q['type'] ?? 'select') === 'select' ? 'Multiple Choice' : 'Text Input' }}
                </span>
              </div>
              <div class="js-sq-body">
                @if(($q['type'] ?? 'select') === 'select' && !empty($q['options']))
                  @php $letters = ['A','B','C','D','E','F','G','H']; @endphp
                  @foreach($q['options'] as $oi => $opt)
                    <div class="js-sq-opt">
                      <div class="js-sq-opt-ltr">{{ $letters[$oi] ?? ($oi+1) }}</div>
                      {{ $opt }}
                    </div>
                  @endforeach
                @else
                  <div class="js-sq-text-note">
                    <i class="fa-solid fa-keyboard" style="color:var(--n300);"></i>
                    Candidate will type their answer in a text field
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        @else
          <div style="text-align:center;padding:24px;color:var(--n400);">
            <i class="fa-solid fa-clipboard-question" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
            <div style="font-size:.82rem;">No screening questions added for this job.</div>
          </div>
        @endif
      </div>
    </div>

    {{-- Recent Applicants --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-users"></i></div>
        <div class="js-card-head-title">Recent Applicants</div>
        <div class="js-card-head-right">
          <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}"
            style="font-size:.72rem;font-weight:800;color:rgba(255,255,255,.8);text-decoration:none;">
            View All <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
          </a>
        </div>
      </div>
      <div class="js-card-body" style="padding:0;">
        @if($apps && $apps->count() > 0)
          <div style="overflow-x:auto;">
            <table class="js-apps-table">
              <thead>
                <tr>
                  <th>Candidate</th>
                  <th>Applied</th>
                  <th>Experience</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($apps->take(6) as $app)
                  @php
                    $sts = $app->status ?? 'new';
                    $stsBadge = ['new'=>'badge-blue','shortlisted'=>'badge-green','interview'=>'badge-purple','rejected'=>'badge-red'];
                  @endphp
                  <tr>
                    <td>
                      <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,var(--blue),var(--purple));color:#fff;font-family:var(--f);font-size:.74rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                          {{ strtoupper(substr($app->jobseeker->name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                          <div style="font-family:var(--f);font-size:.82rem;font-weight:700;color:var(--n900);">{{ $app->jobseeker->name ?? 'Candidate' }}</div>
                          <div style="font-size:.7rem;color:var(--n400);">{{ $app->jobseeker->email ?? '' }}</div>
                        </div>
                      </div>
                    </td>
                    <td style="font-size:.78rem;color:var(--n500);">{{ \Carbon\Carbon::parse($app->created_at)->diffForHumans() }}</td>
                    <td style="font-size:.8rem;color:var(--n600);">{{ $app->jobseeker->experience ?? '—' }}</td>
                    <td><span class="badge {{ $stsBadge[$sts] ?? 'badge-gray' }}" style="text-transform:capitalize;">{{ $sts }}</span></td>
                    <td>
                      <a href="{{ route('employer.candidates') }}#app-{{ $app->id ?? '' }}"
                        style="font-family:var(--f);font-size:.74rem;font-weight:700;color:var(--blue);text-decoration:none;">
                        View <i class="fa-solid fa-arrow-right" style="font-size:.6rem;"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="js-apps-empty">
            <i class="fa-solid fa-user-plus"></i>
            <p>No applications received yet.<br>Share your job link to attract candidates.</p>
          </div>
        @endif
      </div>
    </div>

  </div>{{-- /left col --}}

  {{-- ── RIGHT COLUMN ── --}}
  <div class="js-col">

    {{-- Status & Actions --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-toggle-on"></i></div>
        <div class="js-card-head-title">Job Status</div>
      </div>
      <div class="js-card-body">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:16px;">
          <div>
            <div style="font-family:var(--f);font-size:.7rem;font-weight:700;color:var(--n400);margin-bottom:5px;">CURRENT STATUS</div>
            <span class="js-status-badge {{ $status }}">
              <span class="dot"></span>
              {{ ucfirst($status) }}
            </span>
          </div>
          <form class="js-toggle-form" method="POST" action="{{ route('employer.jobs.toggle', $j->id ?? 0) }}">
            @csrf @method('PATCH')
            <button type="submit" class="js-toggle-btn {{ $status === 'active' ? 'deactivate' : 'activate' }}">
              @if($status === 'active')
                <i class="fa-solid fa-circle-pause"></i> Deactivate
              @else
                <i class="fa-solid fa-circle-play"></i> Activate
              @endif
            </button>
          </form>
        </div>
        <div style="background:var(--n50);border-radius:10px;padding:12px;font-size:.78rem;color:var(--n500);line-height:1.6;display:flex;align-items:flex-start;gap:8px;">
          <i class="fa-solid fa-circle-info" style="color:var(--blue);font-size:.72rem;margin-top:2px;flex-shrink:0;"></i>
          {{ $status === 'active' ? 'This job is visible to job seekers and accepting applications.' : 'This job is hidden from job seekers and not accepting applications.' }}
        </div>
      </div>
    </div>

    {{-- Job Details --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-circle-info"></i></div>
        <div class="js-card-head-title">Job Details</div>
      </div>
      <div class="js-card-body" style="padding:16px 20px;">
        <div class="js-info-row">
          <div class="js-info-ico blue"><i class="fa-solid fa-layer-group"></i></div>
          <div>
            <div class="js-info-label">Category</div>
            <div class="js-info-value">{{ $j->job_category ?? '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico purple"><i class="fa-solid fa-industry"></i></div>
          <div>
            <div class="js-info-label">Industry</div>
            <div class="js-info-value">{{ $j->industry_type ?? '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico orange"><i class="fa-solid fa-clock"></i></div>
          <div>
            <div class="js-info-label">Job Type</div>
            <div class="js-info-value">{{ $j->job_type ?? '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico green"><i class="fa-solid fa-indian-rupee-sign"></i></div>
          <div>
            <div class="js-info-label">Salary Range</div>
            <div class="js-info-value">{{ $salary }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico blue"><i class="fa-solid fa-briefcase"></i></div>
          <div>
            <div class="js-info-label">Experience Required</div>
            <div class="js-info-value">{{ $j->experience_required ?? '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico purple"><i class="fa-solid fa-graduation-cap"></i></div>
          <div>
            <div class="js-info-label">Education</div>
            <div class="js-info-value">{{ $j->education ?? '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico orange"><i class="fa-solid fa-users"></i></div>
          <div>
            <div class="js-info-label">Vacancies</div>
            <div class="js-info-value">{{ $j->vacancies ?? 1 }} position(s)</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico green"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <div class="js-info-label">Location</div>
            <div class="js-info-value">{{ $loc ?: '—' }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico blue"><i class="fa-solid fa-calendar-plus"></i></div>
          <div>
            <div class="js-info-label">Posted On</div>
            <div class="js-info-value">{{ $posted }}</div>
          </div>
        </div>
        <div class="js-info-row">
          <div class="js-info-ico {{ $status === 'active' ? 'green' : 'red' }}">
            <i class="fa-solid fa-{{ $status === 'active' ? 'circle-check' : 'circle-xmark' }}"></i>
          </div>
          <div>
            <div class="js-info-label">Status</div>
            <div class="js-info-value" style="text-transform:capitalize;">{{ $status }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Skills --}}
    @if(count($skills) > 0)
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-tags"></i></div>
        <div class="js-card-head-title">Required Skills</div>
      </div>
      <div class="js-card-body">
        <div class="js-skills-wrap">
          @foreach($skills as $skill)
            <span class="js-skill-chip"><i class="fa-solid fa-check"></i> {{ $skill }}</span>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="js-card">
      <div class="js-card-head">
        <div class="js-card-head-ico"><i class="fa-solid fa-bolt"></i></div>
        <div class="js-card-head-title">Quick Actions</div>
      </div>
      <div class="js-card-body" style="display:flex;flex-direction:column;gap:9px;">
        <a href="{{ route('employer.jobs.edit', $j->id ?? 0) }}"
          style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:var(--r);background:var(--blue-lt);color:var(--blue);font-family:var(--f);font-size:.82rem;font-weight:700;text-decoration:none;transition:var(--t);">
          <i class="fa-solid fa-pen-to-square" style="font-size:.82rem;width:16px;text-align:center;"></i>
          Edit Job Details
          <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.68rem;"></i>
        </a>
        <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}"
          style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:var(--r);background:var(--green-lt);color:var(--green);font-family:var(--f);font-size:.82rem;font-weight:700;text-decoration:none;transition:var(--t);">
          <i class="fa-solid fa-users" style="font-size:.82rem;width:16px;text-align:center;"></i>
          View All Applicants
          <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.68rem;"></i>
        </a>
        <a href="{{ route('employer.jobs.create') }}"
          style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:var(--r);background:#f5f3ff;color:var(--purple);font-family:var(--f);font-size:.82rem;font-weight:700;text-decoration:none;transition:var(--t);">
          <i class="fa-solid fa-plus-circle" style="font-size:.82rem;width:16px;text-align:center;"></i>
          Post Another Job
          <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.68rem;"></i>
        </a>
        <a href="{{ route('employer.jobs.index') }}"
          style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:var(--r);background:var(--n50);color:var(--n600);font-family:var(--f);font-size:.82rem;font-weight:700;text-decoration:none;transition:var(--t);">
          <i class="fa-solid fa-list" style="font-size:.82rem;width:16px;text-align:center;"></i>
          Back to Manage Jobs
          <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.68rem;"></i>
        </a>
        <button type="button" onclick="document.getElementById('deleteModal').classList.add('open')"
          style="display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:var(--r);background:var(--red-lt);color:var(--red);font-family:var(--f);font-size:.82rem;font-weight:700;cursor:pointer;border:none;width:100%;text-align:left;transition:var(--t);">
          <i class="fa-solid fa-trash" style="font-size:.82rem;width:16px;text-align:center;"></i>
          Delete This Job
          <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.68rem;"></i>
        </button>
      </div>
    </div>

  </div>{{-- /right col --}}

</div>{{-- /grid --}}
</div>{{-- /wrap --}}

{{-- ══ DELETE MODAL ══ --}}
<div class="js-modal" id="deleteModal" onclick="if(event.target===this) this.classList.remove('open')">
  <div class="js-modal-box">
    <div style="text-align:center;margin-bottom:22px;">
      <div style="width:56px;height:56px;border-radius:14px;background:#fef2f2;color:var(--red);font-size:1.4rem;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div style="font-family:var(--f);font-size:1rem;font-weight:900;color:var(--n900);margin-bottom:6px;">Delete This Job?</div>
      <div style="font-size:.82rem;color:var(--n500);line-height:1.6;">
        Deleting <strong>{{ $j->job_title ?? 'this job' }}</strong> will permanently remove the listing and all associated applications. This action cannot be undone.
      </div>
    </div>
    <div style="display:flex;gap:10px;">
      <button onclick="document.getElementById('deleteModal').classList.remove('open')"
        style="flex:1;padding:10px;border-radius:var(--r);background:#fff;border:1.5px solid var(--n300);font-family:var(--f);font-size:.84rem;font-weight:700;color:var(--n600);cursor:pointer;">
        Cancel
      </button>
      <form method="POST" action="{{ route('employer.jobs.destroy', $j->id ?? 0) }}" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit"
          style="width:100%;padding:10px;border-radius:var(--r);background:var(--red);color:#fff;border:none;font-family:var(--f);font-size:.84rem;font-weight:800;cursor:pointer;">
          <i class="fa-solid fa-trash"></i> Yes, Delete
        </button>
      </form>
    </div>
  </div>
</div>

@endsection