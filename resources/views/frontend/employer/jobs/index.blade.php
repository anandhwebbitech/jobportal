{{-- ════════════════════════════════════════════════════════
     resources/views/employer/jobs/index.blade.php
     Job Listings — LinearJobs Employer Dashboard
════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title', 'My Job Listings')
@section('page-title', 'Job Listings')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Instrument+Sans:wght@400;500;600;700&display=swap');

:root {
  --ink:       #0c1425;
  --ink2:      #1e293b;
  --ink3:      #475569;
  --ink4:      #94a3b8;
  --ink5:      #cbd5e1;
  --surface:   #f8fafd;
  --white:     #ffffff;
  --blue:      #2563eb;
  --blue-d:    #1d4ed8;
  --blue-deep: #1e3a8a;
  --blue-lt:   #eff6ff;
  --blue-mid:  #bfdbfe;
  --blue-ring: rgba(37,99,235,.14);
  --green:     #059669;
  --green-d:   #047857;
  --green-lt:  #ecfdf5;
  --green-mid: #a7f3d0;
  --red:       #dc2626;
  --red-lt:    #fef2f2;
  --red-mid:   #fecaca;
  --amber:     #d97706;
  --amber-lt:  #fffbeb;
  --amber-mid: #fde68a;
  --border:    #e2e8f0;
  --r:    10px;
  --r-sm: 8px;
  --r-md: 14px;
  --r-lg: 18px;
  --r-xl: 24px;
  --sh-xs: 0 1px 2px rgba(0,0,0,.05);
  --sh-sm: 0 1px 4px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.05);
  --sh-md: 0 4px 20px rgba(0,0,0,.09);
  --sh-lg: 0 8px 40px rgba(0,0,0,.12);
  --sh-xl: 0 20px 60px rgba(0,0,0,.15);
  --ease:   cubic-bezier(.4,0,.2,1);
  --spring: cubic-bezier(.34,1.56,.64,1);
  --fh: 'Plus Jakarta Sans', sans-serif;
  --fb: 'Instrument Sans', sans-serif;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--fb);}

/* ══ WRAP ══ */
.idx-wrap { max-width: 1280px; margin: 0 auto; padding-bottom: 80px; }

/* ══ HERO ══ */
.idx-hero {
  background: linear-gradient(140deg, #0f2460 0%, #1d4ed8 45%, #3b82f6 75%, #60a5fa 100%);
  border-radius: var(--r-xl); padding: 36px 40px;
  position: relative; overflow: hidden; margin-bottom: 28px;
}
.idx-hero-grid {
  position: absolute; inset: 0;
  background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
  background-size: 40px 40px; pointer-events: none;
}
.idx-hero-orb { position:absolute; top:-80px; right:-80px; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(255,255,255,.1) 0%,transparent 70%); pointer-events:none; }
.idx-hero-inner { position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
.idx-hero-left {}
.idx-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
  border-radius: 100px; padding: 5px 14px;
  font-family: var(--fh); font-size: .67rem; font-weight: 800;
  color: rgba(255,255,255,.9); letter-spacing: .1em; text-transform: uppercase; margin-bottom: 14px;
}
.idx-hero-eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; animation: blink 1.8s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }
.idx-hero-title { font-family: var(--fh); font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 900; color: #fff; letter-spacing: -1px; line-height: 1.2; margin-bottom: 8px; }
.idx-hero-title span { color: #93c5fd; }
.idx-hero-sub { font-family: var(--fb); font-size: .88rem; color: rgba(255,255,255,.72); line-height: 1.65; }

/* stat chips */
.idx-stats { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px; }
.idx-stat {
  display: flex; align-items: center; gap: 10px;
  background: rgba(255,255,255,.12); border: 1.5px solid rgba(255,255,255,.18);
  border-radius: 14px; padding: 11px 18px;
}
.idx-stat-icon { width: 34px; height: 34px; border-radius: 10px; background: rgba(255,255,255,.15); color: #fff; display: flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink: 0; }
.idx-stat-val { font-family: var(--fh); font-size: 1.2rem; font-weight: 900; color: #fff; line-height: 1; margin-bottom: 1px; }
.idx-stat-lbl { font-family: var(--fb); font-size: .7rem; color: rgba(255,255,255,.68); }

/* post button */
.btn-post-job {
  display: inline-flex; align-items: center; gap: 9px;
  background: #fff; border: none; border-radius: var(--r-md);
  padding: 13px 24px; cursor: pointer;
  font-family: var(--fh); font-size: .92rem; font-weight: 800;
  color: var(--blue-deep);
  box-shadow: 0 4px 20px rgba(0,0,0,.15);
  transition: all .2s var(--ease); white-space: nowrap; text-decoration: none;
}
.btn-post-job:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.2); }

/* ══ FILTER BAR ══ */
.idx-filters {
  background: var(--white); border: 1.5px solid var(--border); border-radius: var(--r-lg);
  padding: 16px 20px; display: flex; align-items: center; gap: 12px;
  flex-wrap: wrap; box-shadow: var(--sh-sm); margin-bottom: 20px;
}
.idx-search-wrap { position: relative; flex: 1; min-width: 200px; }
.idx-search-ico { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--ink4); font-size: .82rem; pointer-events: none; }
.idx-search {
  width: 100%; border: 1.5px solid var(--border); border-radius: var(--r);
  padding: 10px 14px 10px 38px; font-family: var(--fb); font-size: .88rem; color: var(--ink);
  outline: none; transition: border-color .2s, box-shadow .2s; background: var(--surface);
}
.idx-search:focus { border-color: var(--blue); box-shadow: 0 0 0 4px var(--blue-ring); background: #fff; }
.idx-search::placeholder { color: var(--ink5); }
.idx-select-wrap { position: relative; }
.idx-select-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--ink4); font-size: .78rem; pointer-events: none; }
.idx-select {
  border: 1.5px solid var(--border); border-radius: var(--r); padding: 10px 36px 10px 34px;
  font-family: var(--fb); font-size: .85rem; color: var(--ink2); cursor: pointer;
  background: var(--surface); outline: none; appearance: none; -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 12px center;
  transition: border-color .2s, box-shadow .2s; white-space: nowrap;
}
.idx-select:focus { border-color: var(--blue); box-shadow: 0 0 0 4px var(--blue-ring); background-color: #fff; }
.idx-filter-reset {
  display: flex; align-items: center; gap: 6px;
  background: none; border: 1.5px solid var(--border); border-radius: var(--r);
  padding: 10px 16px; font-family: var(--fh); font-size: .8rem; font-weight: 700;
  color: var(--ink3); cursor: pointer; transition: all .18s; white-space: nowrap;
}
.idx-filter-reset:hover { border-color: var(--red-mid); color: var(--red); }
.idx-result-count { font-family: var(--fb); font-size: .8rem; color: var(--ink3); margin-left: auto; white-space: nowrap; }
.idx-result-count strong { color: var(--blue); font-family: var(--fh); }

/* ══ TABLE CARD ══ */
.idx-table-card {
  background: var(--white); border: 1.5px solid var(--border); border-radius: var(--r-lg);
  box-shadow: var(--sh-sm); overflow: hidden;
}
.idx-table-header {
  padding: 16px 24px; border-bottom: 1.5px solid var(--border);
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
  background: linear-gradient(135deg, var(--surface) 0%, #fff 100%);
}
.idx-table-title { font-family: var(--fh); font-size: .95rem; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 8px; }
.idx-table-title span { background: var(--blue); color: #fff; font-size: .65rem; font-weight: 900; padding: 3px 9px; border-radius: 100px; font-family: var(--fh); }

/* ══ TABLE ══ */
.idx-table { width: 100%; border-collapse: collapse; }
.idx-table thead th {
  padding: 13px 16px; text-align: left;
  font-family: var(--fh); font-size: .68rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;
  color: var(--ink3); background: var(--surface); border-bottom: 1.5px solid var(--border);
  white-space: nowrap;
}
.idx-table thead th:first-child { padding-left: 24px; }
.idx-table thead th:last-child { padding-right: 24px; text-align: right; }

.idx-table tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background .12s var(--ease);
}
.idx-table tbody tr:last-child { border-bottom: none; }
.idx-table tbody tr:hover { background: var(--surface); }
.idx-table td { padding: 16px 16px; vertical-align: middle; }
.idx-table td:first-child { padding-left: 24px; }
.idx-table td:last-child { padding-right: 24px; }

/* job title cell */
.idx-job-cell { display: flex; align-items: flex-start; gap: 13px; }
.idx-job-ico {
  width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
  background: linear-gradient(135deg, var(--blue-lt), var(--blue-mid));
  color: var(--blue); display: flex; align-items: center; justify-content: center; font-size: .9rem;
}
.idx-job-title {
  font-family: var(--fh); font-size: .9rem; font-weight: 800; color: var(--ink);
  margin-bottom: 3px; line-height: 1.3; max-width: 280px;
}
.idx-job-title a { color: inherit; text-decoration: none; transition: color .15s; }
.idx-job-title a:hover { color: var(--blue); }
.idx-job-meta { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 5px; }
.idx-meta-pill {
  display: inline-flex; align-items: center; gap: 4px;
  font-family: var(--fb); font-size: .7rem; color: var(--ink3);
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 6px; padding: 2px 8px;
}
.idx-meta-pill i { font-size: .6rem; color: var(--ink4); }

/* status badge */
.idx-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-family: var(--fh); font-size: .68rem; font-weight: 800;
  letter-spacing: .05em; text-transform: uppercase;
  padding: 4px 12px; border-radius: 100px; white-space: nowrap;
}
.idx-badge.active  { background: var(--green-lt); color: var(--green-d); border: 1.5px solid var(--green-mid); }
.idx-badge.inactive{ background: var(--amber-lt); color: var(--amber); border: 1.5px solid var(--amber-mid); }
.idx-badge.closed  { background: var(--red-lt); color: var(--red); border: 1.5px solid var(--red-mid); }
.idx-badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.active .idx-badge-dot  { background: var(--green); }
.inactive .idx-badge-dot{ background: var(--amber); }
.closed .idx-badge-dot  { background: var(--red); }

/* applicants count */
.idx-app-count {
  display: inline-flex; align-items: center; gap: 7px;
  font-family: var(--fh); font-size: .85rem; font-weight: 800; color: var(--ink2);
}
.idx-app-count .num { color: var(--blue); }
.idx-app-count .new-badge {
  font-size: .6rem; font-weight: 800; background: var(--red); color: #fff;
  padding: 2px 7px; border-radius: 100px;
}

/* date cell */
.idx-date { font-family: var(--fb); font-size: .82rem; color: var(--ink3); }
.idx-date-sub { font-size: .7rem; color: var(--ink4); margin-top: 2px; }

/* actions */
.idx-actions { display: flex; align-items: center; gap: 6px; justify-content: flex-end; flex-wrap: nowrap; }
.idx-btn {
  width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--border);
  background: var(--white); color: var(--ink3); cursor: pointer; font-size: .72rem;
  display: flex; align-items: center; justify-content: center;
  transition: all .15s var(--ease); flex-shrink: 0;
  text-decoration: none;
}
.idx-btn:hover { transform: translateY(-1px); box-shadow: var(--sh-xs); }
.idx-btn.view:hover  { border-color: var(--blue-mid); color: var(--blue); background: var(--blue-lt); }
.idx-btn.edit:hover  { border-color: #fde68a; color: var(--amber); background: var(--amber-lt); }
.idx-btn.apps:hover  { border-color: var(--green-mid); color: var(--green); background: var(--green-lt); }
.idx-btn.tog:hover   { border-color: var(--blue-mid); color: var(--blue); background: var(--blue-lt); }
.idx-btn.del:hover   { border-color: var(--red-mid); color: var(--red); background: var(--red-lt); }

/* empty state */
.idx-empty {
  padding: 80px 24px; text-align: center; color: var(--ink4);
}
.idx-empty-ico { font-size: 3rem; opacity: .2; display: block; margin-bottom: 20px; }
.idx-empty h3 { font-family: var(--fh); font-size: 1.05rem; font-weight: 800; color: var(--ink2); margin-bottom: 8px; }
.idx-empty p { font-family: var(--fb); font-size: .88rem; color: var(--ink3); line-height: 1.6; max-width: 380px; margin: 0 auto 22px; }

/* pagination */
.idx-pagination {
  padding: 16px 24px; border-top: 1.5px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 12px; background: var(--surface);
}
.idx-pag-info { font-family: var(--fb); font-size: .8rem; color: var(--ink3); }
.idx-pag-info strong { color: var(--ink2); font-family: var(--fh); }
.idx-pag-links { display: flex; gap: 6px; }
.idx-pag-btn {
  min-width: 36px; height: 36px; border-radius: var(--r-sm);
  border: 1.5px solid var(--border); background: var(--white);
  font-family: var(--fh); font-size: .8rem; font-weight: 700; color: var(--ink2);
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  padding: 0 10px; transition: all .15s; text-decoration: none;
}
.idx-pag-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
.idx-pag-btn.active { background: var(--blue); border-color: var(--blue); color: #fff; box-shadow: 0 2px 8px rgba(37,99,235,.3); }
.idx-pag-btn.disabled { opacity: .4; cursor: not-allowed; pointer-events: none; }

/* delete modal */
.idx-modal-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.5);
  display: none; align-items: center; justify-content: center; z-index: 200;
  backdrop-filter: blur(3px); animation: fadeIn .18s var(--ease);
}
.idx-modal-overlay.open { display: flex; }
@keyframes fadeIn { from{opacity:0} to{opacity:1} }
.idx-modal {
  background: var(--white); border-radius: var(--r-xl);
  padding: 36px; max-width: 420px; width: 90%; box-shadow: var(--sh-xl);
  animation: modalIn .22s var(--spring);
}
@keyframes modalIn { from{opacity:0;transform:scale(.92)translateY(10px)} to{opacity:1;transform:scale(1)translateY(0)} }
.idx-modal-ico { width: 52px; height: 52px; border-radius: 16px; background: var(--red-lt); color: var(--red); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 16px; }
.idx-modal-title { font-family: var(--fh); font-size: 1.1rem; font-weight: 900; color: var(--ink); margin-bottom: 8px; }
.idx-modal-desc { font-family: var(--fb); font-size: .88rem; color: var(--ink3); line-height: 1.65; margin-bottom: 24px; }
.idx-modal-job { font-family: var(--fh); font-size: .88rem; font-weight: 800; color: var(--red); }
.idx-modal-actions { display: flex; gap: 10px; }
.idx-modal-cancel { flex: 1; background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--r-sm); padding: 11px 20px; font-family: var(--fh); font-size: .9rem; font-weight: 700; color: var(--ink2); cursor: pointer; transition: all .18s; }
.idx-modal-cancel:hover { border-color: var(--ink3); }
.idx-modal-confirm { flex: 1; background: linear-gradient(135deg, var(--red), #b91c1c); color: #fff; border: none; border-radius: var(--r-sm); padding: 11px 20px; font-family: var(--fh); font-size: .9rem; font-weight: 800; cursor: pointer; transition: all .18s; box-shadow: 0 2px 8px rgba(220,38,38,.3); }
.idx-modal-confirm:hover { box-shadow: 0 4px 16px rgba(220,38,38,.4); transform: translateY(-1px); }

/* toast */
.idx-toast {
  position: fixed; bottom: 24px; right: 24px; z-index: 500;
  background: var(--ink); color: #fff; border-radius: var(--r-md);
  padding: 13px 20px; display: flex; align-items: center; gap: 10px;
  font-family: var(--fh); font-size: .88rem; font-weight: 700;
  box-shadow: var(--sh-lg); transform: translateY(80px); opacity: 0;
  transition: all .3s var(--spring); max-width: 340px;
}
.idx-toast.show { transform: translateY(0); opacity: 1; }
.idx-toast.success { background: var(--green-d); }
.idx-toast.error   { background: var(--red); }

/* responsive */
@media(max-width:900px){
  .idx-table thead th:nth-child(n+4):not(:last-child) { display: none; }
  .idx-table td:nth-child(n+4):not(:last-child) { display: none; }
}
@media(max-width:640px){
  .idx-hero { padding: 24px 20px; }
  .idx-stats { gap: 8px; }
  .idx-stat { padding: 9px 12px; }
  .idx-filters { flex-direction: column; }
  .idx-search-wrap, .idx-select-wrap { width: 100%; }
  .idx-select { width: 100%; }
  .idx-result-count { margin-left: 0; }
}
</style>
@endpush
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
<div class="idx-wrap">

  {{-- ════════ HERO ════════ --}}
  <div class="idx-hero">
    <div class="idx-hero-grid"></div>
    <div class="idx-hero-orb"></div>
    <div class="idx-hero-inner">
      <div class="idx-hero-left">
        <div class="idx-hero-eyebrow">
          <span></span> Employer Portal &mdash; Job Listings
        </div>
        <div class="idx-hero-title">
          Manage <span>Your Jobs</span>
        </div>
        <div class="idx-hero-sub">
          Track applicants, edit listings, and monitor performance of all your job postings.
        </div>
        <div class="idx-stats">
          @php
            $totalJobs    = $jobs->total() ?? count($jobs);
            $activeJobs   = isset($jobs) ? (is_object($jobs) && method_exists($jobs,'getCollection') ? $jobs->getCollection() : collect($jobs))->where('status','1')->count() : 0;
            $totalApps    = isset($jobs) ? (is_object($jobs) && method_exists($jobs,'getCollection') ? $jobs->getCollection() : collect($jobs))->sum(fn($j) => $j->applications_count ?? $j->applicants_count ?? 0) : 0;
          @endphp
          <div class="idx-stat">
            <div class="idx-stat-icon"><i class="fa-solid fa-briefcase"></i></div>
            <div>
              <div class="idx-stat-val">{{ $totalJobs }}</div>
              <div class="idx-stat-lbl">Total Jobs</div>
            </div>
          </div>
          <div class="idx-stat">
            <div class="idx-stat-icon" style="background:rgba(74,222,128,.2);"><i class="fa-solid fa-circle-check"></i></div>
            <div>
              <div class="idx-stat-val">{{ $activeJobs }}</div>
              <div class="idx-stat-lbl">Active</div>
            </div>
          </div>
          <div class="idx-stat">
            <div class="idx-stat-icon" style="background:rgba(251,191,36,.2);"><i class="fa-solid fa-users"></i></div>
            <div>
              <div class="idx-stat-val">{{ $totalApps }}</div>
              <div class="idx-stat-lbl">Total Applicants</div>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('employer.jobs.create') }}" class="btn-post-job">
        <i class="fa-solid fa-plus"></i> Post New Job
      </a>
    </div>
  </div>

  {{-- ════════ SESSION ALERTS ════════ --}}
  @if(session('success'))
    <div style="display:flex;align-items:center;gap:12px;background:var(--green-lt);border:1.5px solid var(--green-mid);border-radius:var(--r-sm);padding:14px 20px;font-family:var(--fb);font-size:.88rem;color:#065f46;margin-bottom:16px;">
      <i class="fa-solid fa-circle-check" style="color:var(--green);font-size:1rem;"></i> {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div style="display:flex;align-items:center;gap:12px;background:var(--red-lt);border:1.5px solid var(--red-mid);border-radius:var(--r-sm);padding:14px 20px;font-family:var(--fb);font-size:.88rem;color:#b91c1c;margin-bottom:16px;">
      <i class="fa-solid fa-triangle-exclamation" style="color:var(--red);font-size:1rem;"></i> {{ session('error') }}
    </div>
  @endif

  {{-- ════════ FILTER BAR ════════ --}}
  <div class="idx-filters">
    <div class="idx-search-wrap">
      <i class="fa-solid fa-magnifying-glass idx-search-ico"></i>
      <input type="text" id="jobSearch" class="idx-search" placeholder="Search by job title, location or category..." oninput="filterJobs()">
    </div>
    <div class="idx-select-wrap">
      <i class="fa-solid fa-filter"></i>
      <select id="statusFilter" class="idx-select" onchange="filterJobs()">
        <option value="">All Statuses</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>
    <div class="idx-select-wrap">
      <i class="fa-solid fa-layer-group"></i>
      <select id="categoryFilter" class="idx-select" onchange="filterJobs()">
        <option value="">All Categories</option>
        @foreach(['IT & Software','Technical & Trade','Sales & Marketing','Office & Admin','Driver & Logistics','Manufacturing','Healthcare','Education','Hospitality','Other'] as $cat)
          <option value="{{ $cat }}">{{ $cat }}</option>
        @endforeach
      </select>
    </div>
    <button type="button" class="idx-filter-reset" onclick="resetFilters()">
      <i class="fa-solid fa-rotate-left"></i> Reset
    </button>
    <div class="idx-result-count" id="resultCount">
      Showing <strong id="visibleCount">{{ isset($jobs) ? $jobs->total() : 0 }}</strong> jobs
    </div>
  </div>

  {{-- ════════ TABLE ════════ --}}
  <div class="idx-table-card">
    <div class="idx-table-header">
      <div class="idx-table-title">
        <i class="fa-solid fa-list-ul" style="color:var(--blue);font-size:.85rem;"></i>
        Job Listings
        <span id="jobCountBadge">{{ isset($jobs) ? $jobs->total() : 0 }}</span>
      </div>
      <div style="font-family:var(--fb);font-size:.78rem;color:var(--ink3);display:flex;align-items:center;gap:6px;">
        <i class="fa-solid fa-circle-info" style="color:var(--blue);"></i>
        Click a job title to view details
      </div>
    </div>

    @if(isset($jobs) && $jobs->count() > 0)
    <div style="overflow-x:auto;">
      <table class="idx-table" id="jobsTable">
        <thead>
          <tr>
            <th>Job Title</th>
            <th>Status</th>
            <th>Applicants</th>
            <th>Posted</th>
            <th>Category</th>
            <th>Location</th>
            <th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jobs as $job)
          <tr class="job-row"
            data-title="{{ strtolower($job->title) }}"
            data-status="{{ strtolower($job->status) }}"
            data-category="{{ $job->category ?? '' }}"
            data-location="{{ strtolower(($job->location ?? '').($job->district ?? '')) }}"
          >
            {{-- Job Title --}}
            <td>
              <div class="idx-job-cell">
                <div class="idx-job-ico">
                  @php
                    $catIcons = ['IT & Software'=>'fa-laptop-code','Technical & Trade'=>'fa-wrench','Sales & Marketing'=>'fa-chart-line','Office & Admin'=>'fa-building','Driver & Logistics'=>'fa-truck','Manufacturing'=>'fa-industry','Healthcare'=>'fa-heart-pulse','Education'=>'fa-graduation-cap','Hospitality'=>'fa-concierge-bell','Other'=>'fa-briefcase'];
                    $ico = $catIcons[$job->category ?? ''] ?? 'fa-briefcase';
                  @endphp
                  <i class="fa-solid {{ $ico }}"></i>
                </div>
                <div>
                  <div class="idx-job-title">
                    <a href="{{ route('employer.jobs.show', $job->id) }}" target="_blank">{{ $job->title }}</a>
                  </div>
                  <div class="idx-job-meta">
                    @if($job->job_type ?? false)
                      <span class="idx-meta-pill"><i class="fa-solid fa-clock"></i> {{ $job->job_type }}</span>
                    @endif
                    @if($job->experience_required ?? false)
                      <span class="idx-meta-pill"><i class="fa-solid fa-briefcase"></i> {{ $job->experience_required }}</span>
                    @endif
                    @if($job->salary_range ?? false)
                      <span class="idx-meta-pill"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $job->salary_range }}</span>
                    @endif
                
                </div>
              </div>
            </td>

            {{-- Status --}}
            <td>
              @php $st = strtolower($job->status == 1) ?'active': 'inactive'; @endphp
              <span class="idx-badge {{ $st }}">
                <span class="idx-badge-dot"></span>
                {{ ucfirst($st) }}
              </span>
            </td>

            {{-- Applicants --}}
            <td>
              @php $appCount = $job->applications_count ?? $job->applicants_count ?? 0; @endphp
              <a href="{{ route('employer.candidates', $job->id) }}" class="idx-app-count" style="text-decoration:none;">
                <i class="fa-solid fa-users" style="font-size:.8rem;color:var(--ink4);"></i>
                <span class="num">{{ $appCount }}</span>
                @if($appCount > 0)
                  <span class="new-badge">View</span>
                @endif
              </a>
            </td>

            {{-- Posted Date --}}
            <td>
              <div class="idx-date">{{ $job->created_at->format('d M Y') }}</div>
              <div class="idx-date-sub">{{ $job->created_at->diffForHumans() }}</div>
            </td>

            {{-- Category --}}
            <td>
              <div style="font-family:var(--fh);font-size:.78rem;font-weight:700;color:var(--ink2);">{{ $job->category ?? '—' }}</div>
            </td>

            {{-- Location --}}
            <td>
              <div style="display:flex;align-items:center;gap:5px;font-family:var(--fb);font-size:.82rem;color:var(--ink3);">
                <i class="fa-solid fa-location-dot" style="font-size:.68rem;color:var(--ink4);"></i>
                {{ $job->city ?? '' }}@if($job->district ?? false), {{ $job->district }}@endif
              </div>
            </td>

            {{-- Actions --}}
            <td>
              <div class="idx-actions">
                <a href="{{ route('employer.jobs.show', $job->id) }}" class="idx-btn view" title="View Job" target="_blank">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="idx-btn edit" title="Edit Job">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="{{ route('employer.candidates', $job->id) }}" class="idx-btn apps" title="View Applicants">
                  <i class="fa-solid fa-users"></i>
                </a>
             
                <button 
                    class="idx-btn tog toggleJobBtn" 
                    data-url="{{ route('employer.jobs.toggle', $job->id) }}"
                    data-status="{{ $st }}"
                    title="{{ $st==='1' ? 'Deactivate' : 'Activate' }}"
                >
                    <i class="fa-solid {{ $st==='0' ? 'fa-pause' : 'fa-play' }}"></i>
                </button>
                <button type="button" class="idx-btn del" title="Delete Job"
                  onclick="openDeleteModal('{{ $job->id }}','{{ addslashes($job->job_title) }}')">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- No results row (shown by JS) --}}
    <div id="noResultsRow" style="display:none;padding:60px 24px;text-align:center;color:var(--ink4);">
      <i class="fa-solid fa-magnifying-glass" style="font-size:2rem;opacity:.2;display:block;margin-bottom:14px;"></i>
      <p style="font-family:var(--fb);font-size:.9rem;">No jobs match your search / filter. <button onclick="resetFilters()" style="background:none;border:none;color:var(--blue);cursor:pointer;font-family:var(--fh);font-weight:700;">Reset filters</button></p>
    </div>

    {{-- Pagination --}}
    @if(method_exists($jobs,'links'))
    <div class="idx-pagination">
      <div class="idx-pag-info">
        Showing <strong>{{ $jobs->firstItem() }}–{{ $jobs->lastItem() }}</strong> of <strong>{{ $jobs->total() }}</strong> jobs
      </div>
      <div class="idx-pag-links">
        @if($jobs->onFirstPage())
          <span class="idx-pag-btn disabled"><i class="fa-solid fa-chevron-left"></i></span>
        @else
          <a href="{{ $jobs->previousPageUrl() }}" class="idx-pag-btn"><i class="fa-solid fa-chevron-left"></i></a>
        @endif
        @foreach($jobs->getUrlRange(max(1,$jobs->currentPage()-2), min($jobs->lastPage(),$jobs->currentPage()+2)) as $page => $url)
          <a href="{{ $url }}" class="idx-pag-btn {{ $page===$jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($jobs->hasMorePages())
          <a href="{{ $jobs->nextPageUrl() }}" class="idx-pag-btn"><i class="fa-solid fa-chevron-right"></i></a>
        @else
          <span class="idx-pag-btn disabled"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
      </div>
    </div>
    @endif

    @else
    {{-- EMPTY STATE --}}
    <div class="idx-empty">
      <span class="idx-empty-ico"><i class="fa-solid fa-briefcase"></i></span>
      <h3>No job listings yet</h3>
      <p>You haven't posted any jobs. Create your first listing to start attracting the best talent across Tamil Nadu.</p>
      <a href="{{ route('employer.jobs.create') }}" class="btn-post-job" style="display:inline-flex;margin:0 auto;">
        <i class="fa-solid fa-plus"></i> Post Your First Job
      </a>
    </div>
    @endif
  </div>

</div>{{-- /idx-wrap --}}

{{-- DELETE MODAL --}}
<div class="idx-modal-overlay" id="deleteModal">
  <div class="idx-modal">
    <div class="idx-modal-ico"><i class="fa-solid fa-trash"></i></div>
    <div class="idx-modal-title">Delete Job Listing?</div>
    <div class="idx-modal-desc">
      You're about to permanently delete:<br>
      <span class="idx-modal-job" id="modalJobTitle"></span><br><br>
      This action cannot be undone. All applicant data for this job will also be removed.
    </div>
    <div class="idx-modal-actions">
      <button type="button" class="idx-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
      <form id="deleteForm" method="POST" style="flex:1;">
        @csrf
        @method('DELETE')
        <button type="submit" class="idx-modal-confirm" style="width:100%;">
          <i class="fa-solid fa-trash"></i> Delete Job
        </button>
      </form>
    </div>
  </div>
</div>

{{-- TOAST --}}
<div class="idx-toast" id="toast"></div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "3000"
};
</script>
<script>
// job status change
$(document).on('click', '.toggleJobBtn', function () {
    let btn = $(this);
    let url = btn.data('url');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {

            if (response.status == 1) {
                btn.find('i').removeClass('fa-play').addClass('fa-pause');
            } else {
                btn.find('i').removeClass('fa-pause').addClass('fa-play');
            }

            toastr.success(response.message || 'Updated successfully');
            setTimeout(() => {
              location.reload(); //
            }, 800); 
        },
        error: function () {
            toastr.error('Something went wrong!');
        }
    });
});

/* ══ DELETE MODAL ══ */
function openDeleteModal(id, title){
  document.getElementById('modalJobTitle').textContent = title;
  let url = "{{ route('employer.jobs.destroy', ':id') }}";
  url = url.replace(':id', id);
  document.getElementById('deleteForm').action = url;
  document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal(){
  document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', function(e){
  if(e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeDeleteModal(); });

/* ══ LIVE FILTER ══ */
function filterJobs(){
  var q    = (document.getElementById('jobSearch').value||'').toLowerCase();
  var st   = (document.getElementById('statusFilter').value||'').toLowerCase();
  var cat  = (document.getElementById('categoryFilter').value||'');
  var rows = document.querySelectorAll('.job-row');
  var visible = 0;

  rows.forEach(function(row){
    var title    = row.dataset.title||'';
    var status   = row.dataset.status||'';
    var category = row.dataset.category||'';
    var location = row.dataset.location||'';

    var match = true;
    if(q  && !title.includes(q) && !location.includes(q) && !category.toLowerCase().includes(q)) match=false;
    if(st && status!==st) match=false;
    if(cat && category!==cat) match=false;

    row.style.display = match ? '' : 'none';
    if(match) visible++;
  });

  var noRes = document.getElementById('noResultsRow');
  if(noRes) noRes.style.display = (visible===0 && rows.length>0) ? 'block' : 'none';
  var vc = document.getElementById('visibleCount');
  if(vc) vc.textContent = visible;
}

function resetFilters(){
  document.getElementById('jobSearch').value = '';
  document.getElementById('statusFilter').value = '';
  document.getElementById('categoryFilter').value = '';
  filterJobs();
}

/* ══ TOAST ══ */
@if(session('success'))
  showToast('{{ session('success') }}', 'success');
@endif
@if(session('error'))
  showToast('{{ session('error') }}', 'error');
@endif

function showToast(msg, type){
  var t = document.getElementById('toast');
  t.innerHTML = '<i class="fa-solid '+(type==='success'?'fa-circle-check':'fa-circle-exclamation')+'"></i> '+msg;
  t.className = 'idx-toast '+(type||'');
  setTimeout(function(){ t.classList.add('show'); }, 100);
  setTimeout(function(){ t.classList.remove('show'); }, 4000);
}
</script>
@endpush