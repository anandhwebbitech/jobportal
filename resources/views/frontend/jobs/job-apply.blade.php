{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/jobs/job-apply.blade.php
     Job Application Page – LinearJobs
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Apply for '.$job->title.' – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
/* ── PAGE ─────────────────────────────────────────── */
.lj-apply-page{background:var(--n50);min-height:calc(100vh - 64px);padding:36px 20px 60px;}
.lj-apply-wrap{max-width:860px;margin:0 auto;}

/* ── BREADCRUMB ───────────────────────────────────── */
.lj-breadcrumb{display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--n500);margin-bottom:22px;flex-wrap:wrap;}
.lj-breadcrumb a{color:var(--blue);text-decoration:none;font-weight:500;}
.lj-breadcrumb a:hover{text-decoration:underline;}
.lj-breadcrumb i{font-size:.6rem;color:var(--n300);}

/* ── JOB SUMMARY BANNER ───────────────────────────── */
.lj-apply-banner{background:linear-gradient(90deg,#1a56db 0%,#1e3a8a 100%);border-radius:16px;padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:18px;margin-bottom:24px;position:relative;overflow:hidden;}
.lj-apply-banner::before{content:'';position:absolute;top:-40px;right:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05);}
.lj-apply-banner-left{display:flex;align-items:center;gap:16px;flex:1;position:relative;z-index:1;}
.lj-apply-banner-logo{width:54px;height:54px;border-radius:12px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;flex-shrink:0;border:1.5px solid rgba(255,255,255,.2);overflow:hidden;}
.lj-apply-banner-logo img{width:100%;height:100%;object-fit:cover;}
.lj-apply-banner-title{font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:3px;letter-spacing:-.3px;}
.lj-apply-banner-company{font-size:.84rem;color:rgba(255,255,255,.8);margin-bottom:4px;}
.lj-apply-banner-tags{display:flex;gap:8px;flex-wrap:wrap;}
.lj-apply-banner-tag{display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);border-radius:100px;padding:3px 10px;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.9);}
.lj-apply-banner-right{position:relative;z-index:1;text-align:right;flex-shrink:0;}
.lj-apply-banner-deadline{font-size:.75rem;color:rgba(255,255,255,.7);display:flex;align-items:center;gap:5px;}
.lj-apply-banner-deadline i{color:#fcd34d;}
.lj-view-job-btn{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25);border-radius:8px;padding:7px 14px;font-size:.78rem;font-weight:600;color:#fff;text-decoration:none;transition:all .2s;margin-top:8px;}
.lj-view-job-btn:hover{background:rgba(255,255,255,.25);}

/* ── PROGRESS STEPS ───────────────────────────────── */
.lj-apply-steps{display:flex;align-items:center;justify-content:center;gap:0;margin-bottom:28px;max-width:460px;margin-left:auto;margin-right:auto;}
.lj-apply-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative;}
.lj-apply-step:not(:last-child)::after{content:'';position:absolute;top:13px;left:50%;width:100%;height:2px;background:var(--n100);z-index:0;transition:background .35s;}
.lj-apply-step.done:not(:last-child)::after{background:var(--green);}
.lj-apply-step.active:not(:last-child)::after{background:var(--blue);}
.lj-apply-step-num{width:26px;height:26px;border-radius:50%;background:var(--n100);color:var(--n500);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;position:relative;z-index:1;transition:all .25s;}
.lj-apply-step.active .lj-apply-step-num{background:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(26,86,219,.13);}
.lj-apply-step.done .lj-apply-step-num{background:var(--green);color:#fff;}
.lj-apply-step-lbl{font-size:.62rem;color:var(--n400);margin-top:5px;font-weight:600;text-align:center;white-space:nowrap;}
.lj-apply-step.active .lj-apply-step-lbl{color:var(--blue);}
.lj-apply-step.done .lj-apply-step-lbl{color:var(--green);}

/* ── FORM CARD ────────────────────────────────────── */
.lj-apply-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;overflow:hidden;margin-bottom:20px;}
.lj-apply-card-head{background:linear-gradient(90deg,#1a56db 0%,#1e3a8a 100%);padding:18px 26px;display:flex;align-items:center;gap:12px;}
.lj-apply-card-head i{color:rgba(255,255,255,.9);}
.lj-apply-card-head-title{font-size:.9375rem;font-weight:700;color:#fff;}
.lj-apply-card-head-sub{font-size:.77rem;color:rgba(255,255,255,.7);margin-top:1px;}
.lj-apply-card-body{padding:26px;}

/* ── PROFILE PREFILL ──────────────────────────────── */
.lj-prefill-bar{background:rgba(26,86,219,.05);border:1.5px solid rgba(26,86,219,.14);border-radius:10px;padding:12px 16px;margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.lj-prefill-text{font-size:.82rem;color:var(--n700);display:flex;align-items:center;gap:8px;}
.lj-prefill-text i{color:var(--blue);}
.lj-prefill-btn{background:var(--blue);color:#fff;border:none;border-radius:7px;font-family:var(--f);font-size:.78rem;font-weight:700;padding:7px 14px;cursor:pointer;transition:background .2s;}
.lj-prefill-btn:hover{background:var(--blue-h);}

/* ── FORM ELEMENTS ────────────────────────────────── */
.lj-fgroup{margin-bottom:18px;}
.lj-frow{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.lj-label{display:block;font-size:.8125rem;font-weight:600;color:var(--n700);margin-bottom:6px;}
.lj-label .req{color:#e53e3e;margin-left:2px;}
.lj-opt{font-size:.7rem;font-weight:500;color:var(--n400);margin-left:6px;background:var(--n100);padding:1px 7px;border-radius:100px;}
.lj-iw{position:relative;}
.lj-iw-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;pointer-events:none;z-index:1;}
.lj-iw-ico.ta{top:14px;transform:none;}
.lj-input{width:100%;border:1.5px solid var(--n200);border-radius:8px;padding:10px 14px 10px 38px;font-family:var(--f);font-size:.875rem;color:var(--n900);background:#fff;outline:none;transition:border-color .2s,box-shadow .2s;}
.lj-input.no-ico{padding-left:14px;}
.lj-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
.lj-input::placeholder{color:var(--n400);}
.lj-input.field-error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
select.lj-input{-webkit-appearance:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23a09e9b'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:32px;cursor:pointer;}
textarea.lj-input{padding-top:11px;resize:vertical;min-height:110px;}
.lj-hint{font-size:.73rem;color:var(--n400);margin-top:4px;display:flex;align-items:center;gap:5px;}
.lj-hint i{font-size:.68rem;}
.lj-field-err{font-size:.75rem;color:#dc2626;margin-top:4px;display:none;align-items:center;gap:4px;}
.lj-field-err.show{display:flex;}
.lj-field-err i{font-size:.7rem;}
.lj-step-alert{background:#fef2f2;border:1.5px solid #fecaca;border-radius:8px;padding:11px 14px;margin-bottom:16px;display:none;align-items:flex-start;gap:9px;font-size:.83rem;color:#b91c1c;}
.lj-step-alert.show{display:flex;}

/* ── FILE ZONE ────────────────────────────────────── */
.lj-file-zone{border:1.5px dashed var(--n200);border-radius:10px;padding:22px 16px;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;background:var(--n50);position:relative;}
.lj-file-zone:hover{border-color:var(--blue);background:rgba(26,86,219,.03);}
.lj-file-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;}
.lj-fz-ico{width:44px;height:44px;border-radius:50%;background:#fff;border:1.5px solid var(--n200);display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--n400);margin:0 auto 10px;}
.lj-fz-title{font-size:.875rem;font-weight:600;color:var(--n700);margin-bottom:3px;}
.lj-fz-sub{font-size:.75rem;color:var(--n400);}

/* ── SECTION DIVIDER ──────────────────────────────── */
.lj-fsec{display:flex;align-items:center;gap:10px;margin:20px 0 16px;}
.lj-fsec-line{flex:1;height:1px;background:var(--n100);}
.lj-fsec-lbl{font-size:.68rem;font-weight:800;color:var(--n400);letter-spacing:.09em;text-transform:uppercase;white-space:nowrap;display:flex;align-items:center;gap:6px;}
.lj-fsec-lbl i{font-size:.73rem;color:var(--blue);}

/* ── TAB PANELS ───────────────────────────────────── */
.lj-apply-tab{display:none;}
.lj-apply-tab.active{display:block;animation:fadeIn .25s ease;}
@keyframes fadeIn{from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);}}

/* ── FOOTER NAV ───────────────────────────────────── */
.lj-apply-footer{padding:18px 26px;border-top:1px solid var(--n100);background:var(--n50);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.lj-btn-prev{background:#fff;border:1.5px solid var(--n200);border-radius:8px;font-family:var(--f);font-size:.875rem;font-weight:700;padding:10px 20px;cursor:pointer;display:flex;align-items:center;gap:7px;color:var(--n700);transition:all .2s;}
.lj-btn-prev:hover{border-color:var(--n400);}
.lj-btn-next{background:var(--blue);color:#fff;border:none;border-radius:8px;font-family:var(--f);font-size:.9rem;font-weight:700;padding:10px 22px;cursor:pointer;display:flex;align-items:center;gap:7px;transition:all .2s;}
.lj-btn-next:hover{background:var(--blue-h);transform:translateY(-1px);}
.lj-submit-btn{background:linear-gradient(135deg,#1a56db,#1e3a8a);color:#fff;border:none;border-radius:8px;font-family:var(--f);font-size:.9375rem;font-weight:700;padding:12px 28px;cursor:pointer;display:flex;align-items:center;gap:9px;transition:all .25s;}
.lj-submit-btn:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(26,86,219,.3);}
.lj-submit-btn:disabled{opacity:.7;cursor:not-allowed;transform:none;}

/* ── SUCCESS PAGE ─────────────────────────────────── */
.lj-success-page{text-align:center;padding:60px 30px;}
.lj-success-ico{width:80px;height:80px;border-radius:50%;background:#dcfce7;border:3px solid #86efac;display:flex;align-items:center;justify-content:center;font-size:2rem;color:#16a34a;margin:0 auto 22px;animation:popIn .4s ease;}
@keyframes popIn{from{transform:scale(.5);opacity:0;}to{transform:scale(1);opacity:1;}}
.lj-success-title{font-size:1.5rem;font-weight:900;color:var(--n900);letter-spacing:-.4px;margin-bottom:10px;}
.lj-success-sub{font-size:.9rem;color:var(--n500);line-height:1.7;max-width:420px;margin:0 auto 28px;}
.lj-success-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;}
.lj-success-btn-primary{background:var(--blue);color:#fff;border:none;border-radius:8px;font-family:var(--f);font-size:.9rem;font-weight:700;padding:12px 24px;cursor:pointer;display:flex;align-items:center;gap:8px;text-decoration:none;transition:all .2s;}
.lj-success-btn-primary:hover{background:var(--blue-h);}
.lj-success-btn-outline{background:#fff;color:var(--n700);border:1.5px solid var(--n200);border-radius:8px;font-family:var(--f);font-size:.9rem;font-weight:600;padding:12px 22px;display:flex;align-items:center;gap:8px;text-decoration:none;transition:all .2s;}
.lj-success-btn-outline:hover{border-color:var(--n400);}

@media(max-width:680px){
  .lj-frow{grid-template-columns:1fr;}
  .lj-apply-card-body{padding:18px 16px;}
  .lj-apply-footer{padding:14px 16px;flex-direction:column;align-items:stretch;}
  .lj-btn-prev,.lj-btn-next,.lj-submit-btn{width:100%;justify-content:center;}
  .lj-apply-banner{flex-direction:column;}
  .lj-apply-banner-right{text-align:left;}
}
</style>
@endpush

@section('content')
<div class="lj-apply-page">
  <div class="lj-apply-wrap">

    {{-- Breadcrumb --}}
    <div class="lj-breadcrumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('jobs.index') }}">Find Jobs</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Apply</span>
    </div>

    {{-- Job Banner --}}
    <div class="lj-apply-banner">
      <div class="lj-apply-banner-left">
        <div class="lj-apply-banner-logo">
          @if($job->company->logo ?? false)
            <img src="{{ asset('storage/'.$job->company->logo) }}" alt="{{ $job->company->name }}">
          @else
            <i class="fa-solid fa-building"></i>
          @endif
        </div>
        <div>
          <div class="lj-apply-banner-title">{{ $job->title }}</div>
          <div class="lj-apply-banner-company">{{ $job->company->name ?? $job->company_name }} &middot; {{ $job->city }}, {{ $job->district }}</div>
          <div class="lj-apply-banner-tags">
            @if($job->salary_range)
              <span class="lj-apply-banner-tag"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $job->salary_range }}</span>
            @endif
            @if($job->job_type)
              <span class="lj-apply-banner-tag"><i class="fa-solid fa-clock"></i> {{ $job->job_type }}</span>
            @endif
            @if($job->experience_required)
              <span class="lj-apply-banner-tag"><i class="fa-solid fa-briefcase"></i> {{ $job->experience_required }}</span>
            @endif
          </div>
        </div>
      </div>
      <div class="lj-apply-banner-right">
        @if($job->expires_at)
          <div class="lj-apply-banner-deadline"><i class="fa-solid fa-clock"></i> Closes {{ $job->expires_at->format('d M Y') }}</div>
        @endif
        <a href="{{ route('jobs.show', $job->id) }}" class="lj-view-job-btn">
          <i class="fa-solid fa-arrow-up-right-from-square"></i> View Job Details
        </a>
      </div>
    </div>

    {{-- Progress Steps --}}
    <div class="lj-apply-steps">
      <div class="lj-apply-step active" data-step="1" id="applyStep1">
        <div class="lj-apply-step-num" id="stepNum1"><i class="fa-solid fa-user" style="font-size:.6rem;"></i></div>
        <div class="lj-apply-step-lbl">Your Info</div>
      </div>
      <div class="lj-apply-step" data-step="2" id="applyStep2">
        <div class="lj-apply-step-num" id="stepNum2">2</div>
        <div class="lj-apply-step-lbl">Experience</div>
      </div>
      <div class="lj-apply-step" data-step="3" id="applyStep3">
        <div class="lj-apply-step-num" id="stepNum3">3</div>
        <div class="lj-apply-step-lbl">Documents</div>
      </div>
    </div>

    {{-- Application Form --}}
    <div id="applyFormWrap">
      <form method="POST" action="{{ route('jobs.apply.submit', $job->id) }}" enctype="multipart/form-data" id="applyForm" novalidate>
        @csrf

        {{-- ── TAB 1: Personal Info ── --}}
        <div class="lj-apply-tab active" id="applyTab1">
          <div class="lj-apply-card">
            <div class="lj-apply-card-head">
              <i class="fa-solid fa-user"></i>
              <div>
                <div class="lj-apply-card-head-title">Your Personal Information</div>
                <div class="lj-apply-card-head-sub">Tell the employer who you are</div>
              </div>
            </div>
            <div class="lj-apply-card-body">

              {{-- Prefill from profile --}}
              @auth
                <div class="lj-prefill-bar">
                  <div class="lj-prefill-text"><i class="fa-solid fa-circle-info"></i> We can auto-fill this from your profile</div>
                  <button type="button" class="lj-prefill-btn" onclick="prefillFromProfile()">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Auto-fill
                  </button>
                </div>
              @endauth

              <div class="lj-step-alert" id="alert1">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span id="alert1Msg">Please fill in all required fields.</span>
              </div>

              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="applicant_name">Full Name <span class="req">*</span></label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-user lj-iw-ico"></i>
                    <input type="text" id="applicant_name" name="applicant_name"
                      class="lj-input @error('applicant_name') field-error @enderror"
                      placeholder="Your full name"
                     value="{{ old('applicant_name') }}"
                      required />
                  </div>
                  <div class="lj-field-err @error('applicant_name') show @enderror" id="err-applicant_name">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>@error('applicant_name'){{ $message }}@else Full name is required. @enderror</span>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="applicant_mobile">Mobile Number <span class="req">*</span></label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                    <input type="tel" id="applicant_mobile" name="applicant_mobile"
                      class="lj-input @error('applicant_mobile') field-error @enderror"
                      placeholder="+91 XXXXX XXXXX"
              value="{{ old('applicant_mobile') }}"
                      required maxlength="15" />
                  </div>
                  <div class="lj-field-err @error('applicant_mobile') show @enderror" id="err-applicant_mobile">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>@error('applicant_mobile'){{ $message }}@else Enter a valid 10-digit number. @enderror</span>
                  </div>
                </div>
              </div>

              <div class="lj-fgroup">
                <label class="lj-label" for="applicant_email">Email Address <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-envelope lj-iw-ico"></i>
                  <input type="email" id="applicant_email" name="applicant_email"
                    class="lj-input @error('applicant_email') field-error @enderror"
                    placeholder="you@example.com"
                  value="{{ old('applicant_email') }}"
                    required />
                </div>
                <div class="lj-field-err @error('applicant_email') show @enderror" id="err-applicant_email">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('applicant_email'){{ $message }}@else Enter a valid email address. @enderror</span>
                </div>
              </div>

              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="current_location">Current Location <span class="req">*</span></label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-location-dot lj-iw-ico"></i>
                    <input type="text" id="current_location" name="current_location"
                      class="lj-input @error('current_location') field-error @enderror"
                      placeholder="City, District"
value="{{ old('current_location') }}"                      required />
                  </div>
                  <div class="lj-field-err @error('current_location') show @enderror" id="err-current_location">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>@error('current_location'){{ $message }}@else Location is required. @enderror</span>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="highest_qualification">Highest Qualification <span class="req">*</span></label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-graduation-cap lj-iw-ico"></i>
                    <select id="highest_qualification" name="highest_qualification"
                      class="lj-input @error('highest_qualification') field-error @enderror"
                      required>
                      <option value="" disabled {{ old('highest_qualification') ? '' : 'selected' }}>Select Qualification</option>
                      <option value="none" {{ old('highest_qualification')=='none' ? 'selected' : '' }}>None</option>
                      <option value="10th" {{ old('highest_qualification')=='10th' ? 'selected' : '' }}>10th Pass (SSLC)</option>
                      <option value="12th" {{ old('highest_qualification')=='12th' ? 'selected' : '' }}>12th Pass (HSC)</option>
                      <option value="diploma" {{ old('highest_qualification')=='diploma' ? 'selected' : '' }}>Diploma</option>
                      <option value="bachelor" {{ old('highest_qualification','bachelor')=='bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                      <option value="master" {{ old('highest_qualification')=='master' ? 'selected' : '' }}>Master's Degree</option>
                      <option value="doctorate" {{ old('highest_qualification')=='doctorate' ? 'selected' : '' }}>Doctorate / PhD</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="lj-apply-footer">
              <div style="font-size:.78rem;color:var(--n400);">Step 1 of 3</div>
              <button type="button" class="lj-btn-next" onclick="nextApplyStep(1)">
                Next: Experience <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>

        {{-- ── TAB 2: Experience ── --}}
        <div class="lj-apply-tab" id="applyTab2">
          <div class="lj-apply-card">
            <div class="lj-apply-card-head">
              <i class="fa-solid fa-briefcase"></i>
              <div>
                <div class="lj-apply-card-head-title">Work Experience</div>
                <div class="lj-apply-card-head-sub">Tell us about your background</div>
              </div>
            </div>
            <div class="lj-apply-card-body">

              <div class="lj-step-alert" id="alert2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Please fill in all required fields.</span>
              </div>

              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label">Experience Level <span class="req">*</span></label>
                  <div style="display:flex;gap:10px;">
                    <div style="flex:1;">
                      <input type="radio" id="exp_fresher" name="experience_level" value="fresher"
{{ old('experience_level','fresher')=='fresher' ? 'checked' : '' }}                        onchange="toggleExpFields(false)" style="display:none;">
                      <label for="exp_fresher" style="display:flex;align-items:center;justify-content:center;gap:7px;border:1.5px solid var(--n200);border-radius:8px;padding:10px;font-size:.84rem;font-weight:600;color:var(--n600);cursor:pointer;transition:all .2s;" id="expFresherLabel">
                        <i class="fa-solid fa-seedling"></i> Fresher
                      </label>
                    </div>
                    <div style="flex:1;">
                      <input type="radio" id="exp_experienced" name="experience_level" value="experienced"
{{ old('experience_level')=='experienced' ? 'checked' : '' }}                        onchange="toggleExpFields(true)" style="display:none;">
                      <label for="exp_experienced" style="display:flex;align-items:center;justify-content:center;gap:7px;border:1.5px solid var(--n200);border-radius:8px;padding:10px;font-size:.84rem;font-weight:600;color:var(--n600);cursor:pointer;transition:all .2s;" id="expExpLabel">
                        <i class="fa-solid fa-briefcase"></i> Experienced
                      </label>
                    </div>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="years_experience">Years of Experience</label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-clock lj-iw-ico"></i>
                    <select id="years_experience" name="years_experience" class="lj-input">
                      <option value="">Select (if experienced)</option>
                      <option value="less_1">Less than 1 year</option>
                      @for($y=1;$y<=15;$y++)
                        <option value="{{ $y }}" {{ old('years_experience')==$y ? 'selected' : '' }}>{{ $y }} {{ $y==1?'year':'years' }}</option>
                      @endfor
                      <option value="15+">15+ years</option>
                    </select>
                  </div>
                </div>
              </div>

              <div id="expExtraFields" style="{{ old('experience_level')=='experienced' ? '' : 'display:none;' }}">
                <div class="lj-fsec">
                  <div class="lj-fsec-line"></div>
                  <div class="lj-fsec-lbl"><i class="fa-solid fa-briefcase"></i> Previous Work Details</div>
                  <div class="lj-fsec-line"></div>
                </div>
                <div class="lj-frow">
                  <div class="lj-fgroup">
                    <label class="lj-label" for="previous_company">Previous Company <span class="lj-opt">Optional</span></label>
                    <div class="lj-iw">
                      <i class="fa-solid fa-building lj-iw-ico"></i>
                      <input type="text" id="previous_company" name="previous_company"
                        class="lj-input"
                        placeholder="Company name"
                       value="{{ old('previous_company') }}" />
                    </div>
                  </div>
                  <div class="lj-fgroup">
                    <label class="lj-label" for="previous_designation">Previous Designation <span class="lj-opt">Optional</span></label>
                    <div class="lj-iw">
                      <i class="fa-solid fa-id-badge lj-iw-ico"></i>
                      <input type="text" id="previous_designation" name="previous_designation"
                        class="lj-input"
                        placeholder="e.g. Sales Executive"
                      value="{{ old('previous_designation') }}" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="lj-fgroup">
                <label class="lj-label" for="cover_letter">Cover Letter / Message to Employer <span class="lj-opt">Optional</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-comment lj-iw-ico ta"></i>
                  <textarea id="cover_letter" name="cover_letter"
                    class="lj-input"
                    placeholder="Tell the employer why you're a great fit for this role... (Optional but recommended)"
                    maxlength="1000">{{ old('cover_letter') }}</textarea>
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Max 1000 characters. A personal message increases your chances.</div>
              </div>

              <div class="lj-fgroup">
                <label class="lj-label" for="expected_salary">Expected Salary <span class="lj-opt">Optional</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-indian-rupee-sign lj-iw-ico"></i>
                  <input type="text" id="expected_salary" name="expected_salary"
                    class="lj-input"
                    placeholder="e.g. ₹25,000/month"
                    value="{{ old('expected_salary') }}" />
                </div>
              </div>

              <div class="lj-fgroup">
                <label class="lj-label" for="notice_period">Notice Period / Availability <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-calendar lj-iw-ico"></i>
                  <select id="notice_period" name="notice_period" class="lj-input" required>
                    <option value="" disabled {{ old('notice_period') ? '' : 'selected' }}>Select availability</option>
                    <option value="immediate" {{ old('notice_period')=='immediate' ? 'selected' : '' }}>Immediate / Available Now</option>
                    <option value="1_week" {{ old('notice_period')=='1_week' ? 'selected' : '' }}>Within 1 Week</option>
                    <option value="2_weeks" {{ old('notice_period')=='2_weeks' ? 'selected' : '' }}>Within 2 Weeks</option>
                    <option value="1_month" {{ old('notice_period')=='1_month' ? 'selected' : '' }}>Within 1 Month</option>
                    <option value="2_months" {{ old('notice_period')=='2_months' ? 'selected' : '' }}>Within 2 Months</option>
                    <option value="3_months" {{ old('notice_period')=='3_months' ? 'selected' : '' }}>3+ Months</option>
                  </select>
                </div>
                <div class="lj-field-err" id="err-notice_period">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>Please select your availability.</span>
                </div>
              </div>

            </div>
            <div class="lj-apply-footer">
              <button type="button" class="lj-btn-prev" onclick="prevApplyStep(2)">
                <i class="fa-solid fa-arrow-left"></i> Back
              </button>
              <button type="button" class="lj-btn-next" onclick="nextApplyStep(2)">
                Next: Documents <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>

        {{-- ── TAB 3: Documents ── --}}
        <div class="lj-apply-tab" id="applyTab3">
          <div class="lj-apply-card">
            <div class="lj-apply-card-head">
              <i class="fa-solid fa-file-arrow-up"></i>
              <div>
                <div class="lj-apply-card-head-title">Upload Documents</div>
                <div class="lj-apply-card-head-sub">Resume is required. Profile photo is optional.</div>
              </div>
            </div>
            <div class="lj-apply-card-body">

              <div class="lj-step-alert" id="alert3">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span id="alert3Msg">Please upload your resume to continue.</span>
              </div>

              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label">Resume / CV <span class="req">*</span></label>
                  {{-- @if(auth()->user()->resume ?? false)
                    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:8px;padding:10px 14px;margin-bottom:10px;font-size:.82rem;color:#166534;display:flex;align-items:center;gap:8px;">
                      <i class="fa-solid fa-file-check"></i>
                      Profile resume will be used. You can upload a different one below.
                    </div>
                  @endif --}}
                  <div class="lj-file-zone" id="resumeZone">
                    <input type="file" name="resume" id="resumeInput" accept=".pdf,.doc,.docx"
                      onchange="showFile('resumeZone','resumeLabel',this,5)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-file-pdf" style="color:var(--blue);"></i></div>
                    <div class="lj-fz-title" id="resumeLabel">
                  Click to upload resume
                      {{-- {{ auth()->user()->resume ?? false ? 'Upload different resume (optional)' : 'Click to upload resume' }} --}}
                    </div>
                    <div class="lj-fz-sub">PDF, DOC, DOCX — Max 5 MB</div>
                  </div>
                  <div class="lj-field-err" id="err-resume">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span id="err-resume-msg">Please upload your resume.</span>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label">Profile Photo <span class="lj-opt">Optional</span></label>
                  <div class="lj-file-zone" id="photoZone">
                    <input type="file" name="profile_photo" id="photoInput" accept="image/*"
                      onchange="showFile('photoZone','photoLabel',this,2)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-image" style="color:var(--blue);"></i></div>
                    <div class="lj-fz-title" id="photoLabel">Click to upload photo</div>
                    <div class="lj-fz-sub">JPG, PNG — Max 2 MB</div>
                  </div>
                  <div class="lj-field-err" id="err-photo">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Photo must be under 2 MB.</span>
                  </div>
                </div>
              </div>

              {{-- Review Summary --}}
              <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:10px;padding:16px 18px;margin-top:8px;">
                <div style="font-size:.78rem;font-weight:700;color:var(--n600);margin-bottom:12px;display:flex;align-items:center;gap:7px;">
                  <i class="fa-solid fa-list-check" style="color:var(--blue);"></i> Application Summary
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 20px;font-size:.8rem;color:var(--n600);">
                  <div><span style="color:var(--n400);">Name:</span> <strong id="sumName">—</strong></div>
                  <div><span style="color:var(--n400);">Mobile:</span> <strong id="sumMobile">—</strong></div>
                  <div><span style="color:var(--n400);">Email:</span> <strong id="sumEmail">—</strong></div>
                  <div><span style="color:var(--n400);">Location:</span> <strong id="sumLocation">—</strong></div>
                  <div><span style="color:var(--n400);">Experience:</span> <strong id="sumExp">—</strong></div>
                  <div><span style="color:var(--n400);">Availability:</span> <strong id="sumNotice">—</strong></div>
                </div>
              </div>

            </div>
            <div class="lj-apply-footer">
              <button type="button" class="lj-btn-prev" onclick="prevApplyStep(3)">
                <i class="fa-solid fa-arrow-left"></i> Back
              </button>
              <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div style="font-size:.78rem;color:var(--n400);display:flex;align-items:center;gap:5px;">
                  <i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Your data is safe
                </div>
                <button type="submit" class="lj-submit-btn" id="applySubmitBtn">
                  <i class="fa-solid fa-paper-plane"></i> Submit Application
                </button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>

    {{-- Success Page (shown after submit) --}}
    @if(session('applied'))
      <script>document.getElementById('applyFormWrap').style.display='none';document.getElementById('successWrap').style.display='block';</script>
    @endif
    <div id="successWrap" style="{{ session('applied') ? '' : 'display:none;' }}">
      <div class="lj-apply-card">
        <div class="lj-success-page">
          <div class="lj-success-ico"><i class="fa-solid fa-check"></i></div>
          <div class="lj-success-title">Application Submitted!</div>
          <div class="lj-success-sub">
            Your application for <strong>{{ $job->title }}</strong> at <strong>{{ $job->company->name ?? $job->company_name }}</strong> has been sent successfully.<br><br>
            The employer will review your profile and contact you if shortlisted.
          </div>
          <div class="lj-success-actions">
            <a href="{{ route('jobs.index') }}" class="lj-success-btn-primary">
              <i class="fa-solid fa-magnifying-glass"></i> Find More Jobs
            </a>
            <a href="{{ route('home') }}" class="lj-success-btn-outline">
              <i class="fa-solid fa-gauge"></i> My Applications
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ─────────────────────────────────────────────
     CLEAR FIELD ERRORS
  ───────────────────────────────────────────── */
  document.querySelectorAll('.lj-input').forEach(input => {
    ['input', 'change'].forEach(ev => {
      input.addEventListener(ev, function () {
        this.classList.remove('field-error');
        const err = document.getElementById('err-' + this.id);
        if (err) err.classList.remove('show');
      });
    });
  });

  /* ─────────────────────────────────────────────
     STEP NAVIGATION
  ───────────────────────────────────────────── */
  window.nextApplyStep = function (step) {

    if (!validateStep(step)) return;

    document.getElementById('applyTab' + step).classList.remove('active');
    document.getElementById('applyTab' + (step + 1)).classList.add('active');

    updateStepsUI(step + 1);

    if (step + 1 === 3) updateSummary();

    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  window.prevApplyStep = function (step) {

    document.getElementById('applyTab' + step).classList.remove('active');
    document.getElementById('applyTab' + (step - 1)).classList.add('active');

    updateStepsUI(step - 1);

    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  /* ─────────────────────────────────────────────
     VALIDATION
  ───────────────────────────────────────────── */
  function validateStep(step) {

    let valid = true;
    const tab = document.getElementById('applyTab' + step);

    const requiredFields = tab.querySelectorAll('[required]');

    requiredFields.forEach(field => {

      if (!field.value || !field.value.trim()) {

        valid = false;

        field.classList.add('field-error');

        const err = document.getElementById('err-' + field.id);
        if (err) err.classList.add('show');
      }
    });

    if (!valid) {
      document.getElementById('alert' + step)?.classList.add('show');

      setTimeout(() => {
        document.getElementById('alert' + step)?.classList.remove('show');
      }, 3000);
    }

    return valid;
  }

  /* ─────────────────────────────────────────────
     STEP UI (TOP PROGRESS BAR)
  ───────────────────────────────────────────── */
  function updateStepsUI(activeStep) {

    for (let i = 1; i <= 3; i++) {

      const el = document.getElementById('applyStep' + i);

      el.classList.remove('active', 'done');

      if (i < activeStep) el.classList.add('done');
      else if (i === activeStep) el.classList.add('active');
    }
  }

  /* ─────────────────────────────────────────────
     EXPERIENCE TOGGLE
  ───────────────────────────────────────────── */
  window.toggleExpFields = function (show) {
    document.getElementById('expExtraFields').style.display = show ? 'block' : 'none';
    syncRadioLabels();
  };

  function syncRadioLabels() {

    const fresher = document.getElementById('exp_fresher');
    const experienced = document.getElementById('exp_experienced');

    const fl = document.getElementById('expFresherLabel');
    const el = document.getElementById('expExpLabel');

    if (fresher.checked) {
      fl.style.borderColor = 'var(--blue)';
      fl.style.color = 'var(--blue)';
      fl.style.background = 'rgba(26,86,219,.05)';

      el.style.borderColor = '';
      el.style.color = '';
      el.style.background = '';
    } else if (experienced.checked) {
      el.style.borderColor = 'var(--blue)';
      el.style.color = 'var(--blue)';
      el.style.background = 'rgba(26,86,219,.05)';

      fl.style.borderColor = '';
      fl.style.color = '';
      fl.style.background = '';
    }
  }

  /* ─────────────────────────────────────────────
     FILE UPLOAD HANDLER
  ───────────────────────────────────────────── */
  window.showFile = function (zoneId, labelId, input, maxMB) {

    if (input.files && input.files[0]) {

      const file = input.files[0];
      const errKey = zoneId === 'resumeZone' ? 'err-resume' : 'err-photo';

      if (file.size > maxMB * 1024 * 1024) {

        document.getElementById(errKey).classList.add('show');
        input.value = '';
        return;
      }

      document.getElementById(errKey).classList.remove('show');
      document.getElementById(labelId).textContent = file.name;
    }
  };

  /* ─────────────────────────────────────────────
     SUMMARY
  ───────────────────────────────────────────── */
  function updateSummary() {

    document.getElementById('sumName').textContent =
      document.getElementById('applicant_name').value || '—';

    document.getElementById('sumMobile').textContent =
      document.getElementById('applicant_mobile').value || '—';

    document.getElementById('sumEmail').textContent =
      document.getElementById('applicant_email').value || '—';

    document.getElementById('sumLocation').textContent =
      document.getElementById('current_location').value || '—';

    const exp = document.querySelector('input[name="experience_level"]:checked');
    document.getElementById('sumExp').textContent = exp ? exp.value : '—';

    const notice = document.getElementById('notice_period');
    document.getElementById('sumNotice').textContent =
      notice.options[notice.selectedIndex]?.text || '—';
  }

  /* ─────────────────────────────────────────────
     FORM SUBMIT
  ───────────────────────────────────────────── */
  const form = document.getElementById('applyForm');

  if (form) {

    form.addEventListener('submit', function (e) {

      const resumeInput = document.getElementById('resumeInput');

      if (!resumeInput.files.length) {

        e.preventDefault();

        document.getElementById('err-resume').classList.add('show');
        document.getElementById('alert3').classList.add('show');

        return;
      }

      const btn = document.getElementById('applySubmitBtn');

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
    });
  }

  syncRadioLabels();
});
$(document).ready(function () {

    $('#applyForm').on('submit', function (e) {
        e.preventDefault();

        let form = $('#applyForm')[0];
        let formData = new FormData(form);

        $('#applySubmitBtn').prop('disabled', true).text('Submitting...');

        $.ajax({
            url: "{{ route('jobs.apply.submit', $job->id) }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (response) {

                $('#applySubmitBtn').prop('disabled', false).text('Submit Application');

                if (response.success) {
                    toastr.success(response.message); // ✅ SUCCESS TOAST

                    $('#applyForm')[0].reset();

                    // optional redirect after delay
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 1500);
                    }
                } else {
                    toastr.error(response.message || 'Something went wrong!');
                }
            },

            error: function (xhr) {

                $('#applySubmitBtn').prop('disabled', false).text('Submit Application');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.lj-field-err').removeClass('show');

                    $.each(errors, function (key, value) {
                        $('#err-' + key)
                            .addClass('show')
                            .find('span')
                            .text(value[0]);

                        // 🔴 Show first error as toast
                        toastr.error(value[0]);
                    });

                } else {
                    toastr.error('Server error! Please try again.');
                }
            }
        });
    });

});
</script>
@endpush