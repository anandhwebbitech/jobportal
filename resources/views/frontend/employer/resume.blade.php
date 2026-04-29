{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/resume-database.blade.php
     LinearJobs – Resume Database Module
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Resume Database')
@section('breadcrumb','Resume Database')
@php $activeNav = 'resume-db'; @endphp

@push('styles')
<style>
.resume-layout{display:grid;grid-template-columns:280px 1fr;gap:20px;}
@media(max-width:900px){.resume-layout{grid-template-columns:1fr;}}

/* Plan Meter */
.plan-meter{
  background:var(--gradient);border-radius:14px;padding:18px;
  margin-bottom:16px;
}
.pm-lbl{font-size:.68rem;font-weight:700;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
.pm-val{font-size:1.2rem;font-weight:900;color:#fff;line-height:1;}
.pm-bar-wrap{background:rgba(255,255,255,.2);border-radius:100px;height:6px;margin-top:8px;overflow:hidden;}
.pm-bar{height:100%;border-radius:100px;background:#fff;transition:width .5s;}
.pm-note{font-size:.68rem;color:rgba(255,255,255,.65);margin-top:5px;}

/* Filter sidebar */
.filter-sidebar{background:#fff;border-radius:var(--radius);border:1px solid var(--gray-200);padding:18px;box-shadow:var(--shadow-sm);}
.fs-title{font-size:.78rem;font-weight:800;color:var(--gray-700);text-transform:uppercase;letter-spacing:.06em;margin-bottom:14px;display:flex;align-items:center;gap:6px;}
.fs-group{margin-bottom:16px;}
.fs-label{font-size:.72rem;font-weight:700;color:var(--gray-600);margin-bottom:6px;display:block;}
.fs-input{width:100%;border:1.5px solid var(--gray-200);border-radius:8px;padding:8px 12px;font-size:.82rem;font-family:inherit;outline:none;transition:border-color .2s;}
.fs-input:focus{border-color:var(--blue);}
select.fs-input{-webkit-appearance:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px;cursor:pointer;}

/* Resume card */
.resume-card{background:#fff;border:1.5px solid var(--gray-200);border-radius:12px;padding:16px 18px;display:flex;align-items:flex-start;gap:14px;margin-bottom:10px;transition:all .2s;}
.resume-card:hover{border-color:var(--blue);box-shadow:0 4px 16px rgba(26,86,219,.1);}
.rc-avatar{width:44px;height:44px;border-radius:11px;background:var(--gradient);color:#fff;font-size:.82rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.rc-info{flex:1;min-width:0;}
.rc-name{font-size:.9rem;font-weight:800;color:var(--gray-900);}
.rc-meta{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;}
.rc-meta span{font-size:.73rem;color:var(--gray-500);display:flex;align-items:center;gap:4px;}
.rc-meta i{font-size:.65rem;color:var(--gray-400);}
.rc-skills{display:flex;flex-wrap:wrap;gap:4px;margin-top:8px;}
.rc-actions{display:flex;flex-direction:column;gap:5px;align-items:flex-end;flex-shrink:0;}
</style>
@endpush

@section('content')
<div class="page-hdr">
  <div class="page-hdr-left">
    <div class="page-title">Resume Database</div>
    <div class="page-sub">Search and discover qualified candidates directly</div>
  </div>
</div>

{{-- Plan Usage --}}
@php

    $totalLimit = $resumePlan->download_limit ?? 0;

    $used = $resumePlan->downloads_used ?? 0;

    $remaining = max($totalLimit - $used, 0);

    $usagePercent = $totalLimit > 0
        ? ($used / $totalLimit) * 100
        : 0;

    $daysLeft = $resumePlan
        ? now()->diffInDays($resumePlan->end_date, false)
        : 0;

    $expiryPercent = 100;

@endphp

<div class="plan-meter">

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">

        {{-- Resume Usage --}}
        <div>
            <div class="pm-lbl">Resume Usage</div>

            <div class="pm-val">
                {{ $used }} / {{ $totalLimit }}
            </div>

            <div class="pm-bar-wrap">
                <div class="pm-bar" style="width:{{ $usagePercent }}%;"></div>
            </div>

            <div class="pm-note">
                {{ $remaining }} remaining
            </div>
        </div>

        {{-- Downloads --}}
        <div>
            <div class="pm-lbl">Downloads Used</div>

            <div class="pm-val">
                {{ $used }}
            </div>

            <div class="pm-bar-wrap">
                <div class="pm-bar" style="width:{{ $usagePercent }}%;"></div>
            </div>

            <div class="pm-note">
                Total Limit : {{ $totalLimit }}
            </div>
        </div>

        {{-- Expiry --}}
        <div>
            <div class="pm-lbl">Plan Expiry</div>

            <div class="pm-val">
                {{ $resumePlan ? \Carbon\Carbon::parse($resumePlan->end_date)->format('d M Y') : 'No Plan' }}
            </div>

            <div class="pm-bar-wrap">
                <div class="pm-bar"
                     style="width:{{ $expiryPercent }}%;background:#fcd34d;">
                </div>
            </div>

            <div class="pm-note">
                @if($resumePlan)
                    {{ $daysLeft }} days left
                @else
                    No active plan
                @endif
            </div>
        </div>

    </div>

</div>

<div class="resume-layout">
  {{-- Filter Sidebar --}}
  <div>
    <div class="filter-sidebar">
      <div class="fs-title"><i class="fas fa-sliders" style="color:var(--blue);"></i> Search Filters</div>
      <div class="fs-group">
        <label class="fs-label">Skill</label>
        <input type="text" id="skillFilter" class="fs-input" placeholder="e.g. React, Welding..." />
      </div>
      <div class="fs-group">
        <label class="fs-label">Experience</label>
        <select id="experienceFilter" class="fs-input">
          <option value="">Any Experience</option>
          <option>Fresher</option><option>1-2 Years</option><option>3-5 Years</option><option>5+ Years</option>
        </select>
      </div>
      <div class="fs-group">
        <label class="fs-label">Education</label>
        <select id="educationFilter" class="fs-input">
          <option value="">Any Education</option>
          <option>10th</option><option>12th</option><option>Diploma</option>
          <option>Bachelor</option><option>Master</option>
        </select>
      </div>
      <div class="fs-group">
        <label class="fs-label">Location</label>
        <select id="locationFilter" class="fs-input">
          <option value="">Any Location</option>
          @foreach($locations as $location)

              <option value="{{ $location->district }}"
                  {{ request('location') == $location->district ? 'selected' : '' }}>

                  {{ $location->district }}

              </option>

          @endforeach
        </select>
      </div>
      <div class="fs-group">
        <label class="fs-label">Industry</label>
        <select id="industryFilter" class="fs-input">
          <option value="">Any Industry</option>
          <option>IT / Software</option><option>Manufacturing</option>
          <option>Finance</option><option>Healthcare</option>
        </select>
      </div>
      <button class="btn-primary" style="width:100%;" onclick="applyFilters()"><i class="fas fa-search"></i> Search Resumes</button>
      <button class="btn-outline" style="width:100%;margin-top:8px;" onclick="resetFilters()"><i class="fas fa-rotate-right"></i> Reset</button>
    </div>
  </div>

  {{-- Results --}}
  <div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;gap:15px;flex-wrap:wrap;">

    <div>
        <div style="font-size:.82rem;font-weight:600;color:var(--gray-500);">
            <strong style="color:var(--gray-800);">{{ count($resumes) }}</strong> candidates found
        </div>

        {{-- Active Filters --}}
        <div style="margin-top:6px;display:flex;gap:6px;flex-wrap:wrap;">

            @if(request('skill'))
                <span class="skill-tag">
                    Skill : {{ request('skill') }}
                </span>
            @endif

            @if(request('experience'))
                <span class="skill-tag">
                    Experience : {{ request('experience') }}
                </span>
            @endif

            @if(request('education'))
                <span class="skill-tag">
                    Education : {{ request('education') }}
                </span>
            @endif

            @if(request('location'))
                <span class="skill-tag">
                    Location : {{ request('location') }}
                </span>
            @endif

            @if(request('industry'))
                <span class="skill-tag">
                    Industry : {{ request('industry') }}
                </span>
            @endif

        </div>
    </div>

    {{-- <select class="filter-select" style="font-size:.78rem;">
        <option>Most Recent</option>
        <option>Most Experienced</option>
        <option>Name A-Z</option>
    </select> --}}

</div>


    @foreach($resumes as $r)
    <div class="resume-card">
      <div class="rc-avatar">{{ $r['init'] }}</div>
      <div class="rc-info">
        <div class="rc-name">{{ $r['name'] }}</div>
        <div class="rc-meta">
          <span><i class="fas fa-briefcase"></i> {{ $r['exp'] }}</span>
          <span><i class="fas fa-graduation-cap"></i> {{ $r['edu'] }}</span>
          <span><i class="fas fa-location-dot"></i> {{ $r['loc'] }}</span>
          <span><i class="fas fa-industry"></i> {{ $r['industry'] }}</span>
        </div>
        <div class="rc-skills">
          @foreach($r['skills'] as $sk)
              <span class="skill-tag">{{ $sk }}</span>
          @endforeach
        </div>
      </div>
      <div class="rc-actions">
          <button class="btn-outline btn-sm viewBtn" data-id="{{ $r['id'] }}">
              <i class="fas fa-eye"></i> View
          </button>

          <button class="btn-outline btn-sm downloadBtn" data-id="{{ $r['id'] }}">
              <i class="fas fa-download"></i> Download
          </button>

          <button class="btn-outline btn-sm">
              <i class="fas fa-envelope"></i> Contact
          </button>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function applyFilters() {

    let skill = document.getElementById('skillFilter').value;
    let experience = document.getElementById('experienceFilter').value;
    let education = document.getElementById('educationFilter').value;
    let location = document.getElementById('locationFilter').value;
    let industry = document.getElementById('industryFilter').value;

    let params = new URLSearchParams();

    if (skill) params.append('skill', skill);
    if (experience) params.append('experience', experience);
    if (education) params.append('education', education);
    if (location) params.append('location', location);
    if (industry) params.append('industry', industry);

    window.location.href =
        "{{ route('employer.resume') }}?" + params.toString();
}

function resetFilters() {

    window.location.href =
        "{{ route('employer.resume') }}";
}

const viewBaseUrl = "{{ route('employer.resume.view', ':id') }}";
const downloadBaseUrl = "{{ route('employer.candidateresume.download', ':id') }}";

// VIEW
document.addEventListener('click', function(e) {
    if (e.target.closest('.viewBtn')) {
        let id = e.target.closest('.viewBtn').dataset.id;

        if (!id) {
            alert('No resume found');
            return;
        }

        let url = viewBaseUrl.replace(':id', id);
        window.open(url, '_blank'); // 👁 open
    }
});
let checkDownloadUrl = "{{ url('/check-download') }}/";
let baseDownloadUrl = "{{ url('download') }}/";
document.addEventListener('click', function(e) {

    let btn = e.target.closest('.downloadBtn');
    if (!btn) return;

    if (btn.classList.contains('processing')) return;
    btn.classList.add('processing');

    let id = btn.dataset.id;

    if (!id) {
        Swal.fire('Error', 'No resume found', 'error');
        btn.classList.remove('processing');
        return;
    }

    Swal.fire({
        title: 'Downloading...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(baseDownloadUrl + id)
    .then(async res => {

        // ❌ error response
        if (!res.ok) {
            let text = await res.text();
            throw new Error(text);
        }

        return res.blob();
    })
    .then(blob => {

        let url = window.URL.createObjectURL(blob);

        let a = document.createElement('a');
        a.href = url;
        a.download = 'resume.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();

        Swal.fire({
            icon: 'success',
            title: 'Downloaded',
            timer: 1500,
            showConfirmButton: false
        });

    })
    .catch(err => {
        Swal.fire('Oops!', err.message, 'error');
    })
    .finally(() => {
        btn.classList.remove('processing');
    });

});

</script>
@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "{{ session('error') }}"
});
</script>
@endif
@endpush