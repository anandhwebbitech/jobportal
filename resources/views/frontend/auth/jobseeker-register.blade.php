{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/auth/jobseeker-register.blade.php
     Multi-Step Registration with Tab Navigation & Validation
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Register as Job Seeker – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* ── PAGE ─────────────────────────────────────────── */
.lj-reg-page{background:var(--n50);min-height:calc(100vh - 64px);padding:40px 20px 60px;}
.lj-reg-wrap{max-width:820px;margin:0 auto;}
.lj-reg-head{text-align:center;margin-bottom:32px;}
.lj-reg-head-ico{width:58px;height:58px;border-radius:50%;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin:0 auto 14px;}
.lj-reg-title{font-size:1.7rem;font-weight:800;color:var(--n900);letter-spacing:-.5px;margin-bottom:6px;}
.lj-reg-sub{font-size:.9rem;color:var(--n500);line-height:1.6;}

/* ── STEPS ────────────────────────────────────────── */
.lj-steps{display:flex;align-items:flex-start;justify-content:center;gap:0;margin-bottom:32px;max-width:560px;margin-left:auto;margin-right:auto;}
.lj-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative;cursor:pointer;}
.lj-step:not(:last-child)::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--n100);z-index:0;transition:background .4s;}
.lj-step.done:not(:last-child)::after{background:var(--green);}
.lj-step.active:not(:last-child)::after{background:var(--blue);}
.lj-step-num{width:28px;height:28px;border-radius:50%;background:var(--n100);color:var(--n500);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;position:relative;z-index:1;transition:all .25s;}
.lj-step.active .lj-step-num{background:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(26,86,219,.15);}
.lj-step.done .lj-step-num{background:var(--green);color:#fff;}
.lj-step-lbl{font-size:.65rem;color:var(--n400);margin-top:5px;font-weight:600;text-align:center;white-space:nowrap;}
.lj-step.active .lj-step-lbl{color:var(--blue);}
.lj-step.done .lj-step-lbl{color:var(--green);}

/* ── CARD ─────────────────────────────────────────── */
.lj-reg-card{background:#fff;border:1.5px solid var(--n200);border-radius:var(--r-lg);box-shadow:var(--sh-md);overflow:hidden;margin-bottom:0;}
.lj-reg-card-head{background:linear-gradient(90deg,#1a56db 0%,#1e3a8a 100%);padding:18px 28px;display:flex;align-items:center;gap:12px;}
.lj-reg-card-head i{color:rgba(255,255,255,.9);font-size:1rem;}
.lj-reg-card-head-title{font-size:.9375rem;font-weight:700;color:#fff;}
.lj-reg-card-head-sub{font-size:.78rem;color:rgba(255,255,255,.7);margin-top:1px;}
.lj-reg-body{padding:28px;}

/* ── TAB PANELS ───────────────────────────────────── */
.lj-tab-panel{display:none;}
.lj-tab-panel.active{display:block;}

/* ── FORM ─────────────────────────────────────────── */
.lj-fgroup{margin-bottom:16px;}
.lj-frow{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.lj-frow3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.lj-label{display:block;font-size:.8125rem;font-weight:600;color:var(--n700);margin-bottom:6px;}
.lj-label .req{color:#e53e3e;margin-left:2px;}
.lj-iw{position:relative;}
.lj-iw-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;pointer-events:none;z-index:1;}
.lj-iw-ico-r{position:absolute;right:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;cursor:pointer;z-index:1;background:none;border:none;padding:0;transition:color var(--t);}
.lj-iw-ico-r:hover{color:var(--n700);}
.lj-input{width:100%;border:1.5px solid var(--n200);border-radius:var(--r);padding:10px 14px 10px 38px;font-family:var(--f);font-size:.875rem;color:var(--n900);background:#fff;outline:none;transition:border-color var(--t),box-shadow var(--t);}
.lj-input.no-ico{padding-left:14px;}
.lj-input.pr{padding-right:40px;}
.lj-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
.lj-input::placeholder{color:var(--n400);}
.lj-input.field-error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
select.lj-input{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:34px;cursor:pointer;-webkit-appearance:none;appearance:none;}
.lj-hint{font-size:.73rem;color:var(--n400);margin-top:4px;display:flex;align-items:center;gap:5px;}
.lj-hint i{font-size:.68rem;}

/* ── FIELD ERROR MESSAGE ──────────────────────────── */
.lj-field-err{font-size:.75rem;color:#dc2626;margin-top:4px;display:none;align-items:center;gap:4px;}
.lj-field-err.show{display:flex;}
.lj-field-err i{font-size:.7rem;flex-shrink:0;}

/* ── SECTION HEADER ───────────────────────────────── */
.lj-fsec{display:flex;align-items:center;gap:10px;margin:24px 0 16px;}
.lj-fsec-line{flex:1;height:1px;background:var(--n100);}
.lj-fsec-lbl{font-size:.7rem;font-weight:800;color:var(--n400);letter-spacing:.08em;text-transform:uppercase;white-space:nowrap;display:flex;align-items:center;gap:6px;}
.lj-fsec-lbl i{font-size:.75rem;color:var(--blue);}

/* ── EXPERIENCE TOGGLE ────────────────────────────── */
.lj-exp-row{display:flex;gap:10px;}
.lj-exp-opt{flex:1;}
.lj-exp-opt input[type="radio"]{display:none;}
.lj-exp-opt label{display:flex;align-items:center;justify-content:center;gap:8px;border:1.5px solid var(--n200);border-radius:var(--r);padding:10px 14px;font-size:.875rem;font-weight:600;color:var(--n600);cursor:pointer;transition:all var(--t);}
.lj-exp-opt input:checked + label{background:var(--blue-lt);border-color:var(--blue);color:var(--blue);}

/* ── SKILLS CHIPS ─────────────────────────────────── */
.lj-skill-wrap{display:flex;flex-wrap:wrap;gap:8px;}
.lj-skill-chip input[type="checkbox"]{display:none;}
.lj-skill-chip label{display:inline-flex;align-items:center;gap:6px;border:1.5px solid var(--n200);border-radius:100px;padding:5px 14px;font-size:.8rem;font-weight:500;color:var(--n600);cursor:pointer;transition:all var(--t);}
.lj-skill-chip label:hover{border-color:var(--blue);color:var(--blue);background:var(--blue-lt);}
.lj-skill-chip input:checked + label{background:var(--blue-lt);border-color:var(--blue);color:var(--blue);}

/* ── FILE UPLOAD ──────────────────────────────────── */
.lj-file-zone{border:1.5px dashed var(--n200);border-radius:var(--r);padding:20px 16px;text-align:center;cursor:pointer;transition:border-color var(--t),background var(--t);background:var(--n50);position:relative;}
.lj-file-zone:hover{border-color:var(--blue);background:var(--blue-lt);}
.lj-file-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;}
.lj-fz-ico{width:44px;height:44px;border-radius:50%;background:#fff;border:1.5px solid var(--n200);display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--n400);margin:0 auto 10px;}
.lj-fz-title{font-size:.875rem;font-weight:600;color:var(--n700);margin-bottom:3px;}
.lj-fz-sub{font-size:.75rem;color:var(--n400);}

/* ── FOOTER NAVIGATION ────────────────────────────── */
.lj-reg-footer{padding:20px 28px;border-top:1px solid var(--n100);background:var(--n50);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.lj-btn-nav{border:none;border-radius:var(--r);font-family:var(--f);font-size:.9rem;font-weight:700;padding:11px 24px;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all var(--t);}
.lj-btn-prev{background:#fff;border:1.5px solid var(--n200);color:var(--n700);}
.lj-btn-prev:hover{border-color:var(--n400);background:var(--n50);}
.lj-btn-next{background:var(--blue);color:#fff;}
.lj-btn-next:hover{background:var(--blue-h);transform:translateY(-1px);box-shadow:0 4px 14px rgba(26,86,219,.28);}
.lj-submit{background:linear-gradient(135deg,#1a56db,#1e3a8a);color:#fff;border:none;border-radius:var(--r);font-family:var(--f);font-size:.9375rem;font-weight:700;padding:12px 28px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all var(--t);}
.lj-submit:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(26,86,219,.35);}
.lj-reg-switch{font-size:.875rem;color:var(--n500);}
.lj-reg-switch a{color:var(--blue);font-weight:600;text-decoration:none;}
.lj-reg-switch a:hover{text-decoration:underline;}

/* ── GLOBAL ALERT ─────────────────────────────────── */
.lj-alert-err{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:12px 14px;margin-bottom:18px;display:flex;align-items:flex-start;gap:10px;font-size:.84rem;color:#b91c1c;}
.lj-alert-err i{color:#ef4444;flex-shrink:0;margin-top:1px;}

/* ── STEP VALIDATION BANNER ───────────────────────── */
.lj-step-alert{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:11px 14px;margin-bottom:16px;display:none;align-items:flex-start;gap:9px;font-size:.83rem;color:#b91c1c;animation:shakeX .35s ease;}
.lj-step-alert.show{display:flex;}
.lj-step-alert i{flex-shrink:0;margin-top:1px;}
@keyframes shakeX{0%,100%{transform:translateX(0)}20%{transform:translateX(-6px)}40%{transform:translateX(6px)}60%{transform:translateX(-4px)}80%{transform:translateX(4px)}}

/* ── SKILLS ALERT ─────────────────────────────────── */
.lj-skills-alert{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:10px 14px;margin-top:12px;display:none;align-items:center;gap:8px;font-size:.82rem;color:#b91c1c;}
.lj-skills-alert.show{display:flex;}

/* ── PWD STRENGTH ─────────────────────────────────── */
.lj-pwd-strength{height:4px;border-radius:2px;background:var(--n100);margin-top:6px;overflow:hidden;}
.lj-pwd-bar{height:100%;width:0%;border-radius:2px;transition:width .3s,background .3s;}

/* ── EXPERIENCED EXTRA ────────────────────────────── */
#expFields{display:none;}
#expFields.show{display:block;}

/* ── STEP PROGRESS TEXT ───────────────────────────── */
.lj-progress-label{text-align:center;font-size:.78rem;color:var(--n400);margin-top:-20px;margin-bottom:28px;font-weight:500;}
.lj-progress-label span{color:var(--blue);font-weight:700;}

/* ── ANIMATIONS ───────────────────────────────────── */
.lj-tab-panel.active{animation:fadeSlideIn .3s ease;}
@keyframes fadeSlideIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}

/* ── RESPONSIVE ───────────────────────────────────── */
@media(max-width:680px){
  .lj-frow{grid-template-columns:1fr;}
  .lj-frow3{grid-template-columns:1fr;}
  .lj-reg-body{padding:20px 16px;}
  .lj-reg-footer{padding:16px;flex-direction:column;align-items:stretch;}
  .lj-btn-nav,.lj-submit{width:100%;justify-content:center;}
  .lj-step-lbl{font-size:.58rem;}
}
</style>
@endpush

@section('content')
<div class="lj-reg-page">
  <div class="lj-reg-wrap">

    {{-- Header --}}
    <div class="lj-reg-head">
      <div class="lj-reg-head-ico"><i class="fa-solid fa-user-plus"></i></div>
      <div class="lj-reg-title">Create Your Job Seeker Account</div>
      <div class="lj-reg-sub">Join thousands of professionals finding great jobs across Tamil Nadu. It's 100% free.</div>
    </div>

    {{-- Step Indicator --}}
    <div class="lj-steps" id="stepIndicator">
      <div class="lj-step active" data-step="1" onclick="goToStep(1)">
        <div class="lj-step-num"><i class="fa-solid fa-user" style="font-size:.6rem;"></i></div>
        <div class="lj-step-lbl">Personal</div>
      </div>
      <div class="lj-step" data-step="2" onclick="goToStep(2)">
        <div class="lj-step-num">2</div>
        <div class="lj-step-lbl">Location</div>
      </div>
      <div class="lj-step" data-step="3" onclick="goToStep(3)">
        <div class="lj-step-num">3</div>
        <div class="lj-step-lbl">Education</div>
      </div>
      <div class="lj-step" data-step="4" onclick="goToStep(4)">
        <div class="lj-step-num">4</div>
        <div class="lj-step-lbl">Skills</div>
      </div>
      <div class="lj-step" data-step="5" onclick="goToStep(5)">
        <div class="lj-step-num">5</div>
        <div class="lj-step-lbl">Documents</div>
      </div>
    </div>

    {{-- Progress Label --}}
    {{-- <div class="lj-progress-label">Step <span id="currentStepLabel">1</span> of 5</div> --}}

    {{-- Server-side errors --}}
    @if ($errors->any())
      <div class="lj-alert-err" style="margin-bottom:20px;">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div>
          <strong>Please fix the following errors:</strong>
          <ul style="margin:6px 0 0 14px;padding:0;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('jobseeker.register.submit') }}" enctype="multipart/form-data" id="regForm" novalidate>
      @csrf

      {{-- ══════════════════════════════════
           TAB 1: Personal Information
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel active" id="tab-1">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-user"></i>
            <div>
              <div class="lj-reg-card-head-title">Personal Information</div>
              <div class="lj-reg-card-head-sub">Your basic details</div>
            </div>
          </div>
          <div class="lj-reg-body">

            {{-- Step alert --}}
            <div class="lj-step-alert" id="alert-1">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-1-msg">Please fill in all required fields correctly.</span>
            </div>

            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label" for="full_name">Full Name <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-user lj-iw-ico"></i>
                  <input type="text" id="full_name" name="full_name"
                    class="lj-input @error('full_name') field-error @enderror"
                    placeholder="Your full name"
                    value="{{ old('full_name') }}"
                    data-required="true"
                    data-label="Full Name"
                    data-min="2" />
                </div>
                <div class="lj-field-err @error('full_name') show @enderror" id="err-full_name">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('full_name'){{ $message }}@else Full Name is required (min. 2 characters). @enderror</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="mobile">Mobile Number <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                  <input type="tel" id="mobile" name="mobile"
                    class="lj-input @error('mobile') field-error @enderror"
                    placeholder="+91 XXXXX XXXXX"
                    value="{{ old('mobile') }}"
                    data-required="true"
                    data-label="Mobile Number"
                    data-pattern="phone"
                    maxlength="15" />
                </div>
                <div class="lj-field-err @error('mobile') show @enderror" id="err-mobile">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('mobile'){{ $message }}@else Enter a valid 10-digit mobile number. @enderror</span>
                </div>
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="email">Email Address <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-envelope lj-iw-ico"></i>
                <input type="email" id="email" name="email"
                  class="lj-input @error('email') field-error @enderror"
                  placeholder="you@example.com"
                  value="{{ old('email') }}"
                  data-required="true"
                  data-label="Email Address"
                  data-pattern="email"
                  autocomplete="email" />
              </div>
              <div class="lj-field-err @error('email') show @enderror" id="err-email">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('email'){{ $message }}@else Enter a valid email address. @enderror</span>
              </div>
            </div>

            <div class="lj-fsec">
              <div class="lj-fsec-line"></div>
              <div class="lj-fsec-lbl"><i class="fa-solid fa-lock"></i> Account Security</div>
              <div class="lj-fsec-line"></div>
            </div>

            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label" for="password">Password <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-lock lj-iw-ico"></i>
                  <input type="password" id="password" name="password"
                    class="lj-input pr @error('password') field-error @enderror"
                    placeholder="Min. 8 characters"
                    data-required="true"
                    data-label="Password"
                    data-min="8"
                    autocomplete="new-password"
                    oninput="checkStrength(this.value)" />
                  <button type="button" class="lj-iw-ico-r" onclick="togglePwd('password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                </div>
                <div class="lj-pwd-strength"><div class="lj-pwd-bar" id="pwdBar"></div></div>
                <div class="lj-field-err @error('password') show @enderror" id="err-password">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('password'){{ $message }}@else Password must be at least 8 characters. @enderror</span>
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Minimum 8 characters with letters and numbers</div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="password_confirmation">Confirm Password <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-lock lj-iw-ico"></i>
                  <input type="password" id="password_confirmation" name="password_confirmation"
                    class="lj-input pr"
                    placeholder="Re-enter password"
                    data-required="true"
                    data-label="Confirm Password"
                    data-match="password"
                    autocomplete="new-password" />
                  <button type="button" class="lj-iw-ico-r" onclick="togglePwd('password_confirmation',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                </div>
                <div class="lj-field-err" id="err-password_confirmation">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>Passwords do not match.</span>
                </div>
              </div>
            </div>
          </div>

          <div class="lj-reg-footer">
            <div class="lj-reg-switch">
              Already have an account? <a href="{{ route('jobseeker.login') }}">Login here</a>
            </div>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(1)">
              Next: Location <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 2: Location Information
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-2">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-map-location-dot"></i>
            <div>
              <div class="lj-reg-card-head-title">Location Information</div>
              <div class="lj-reg-card-head-sub">Where are you based?</div>
            </div>
          </div>
          <div class="lj-reg-body">

            <div class="lj-step-alert" id="alert-2">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-2-msg">Please fill in all required location fields.</span>
            </div>

            <div class="lj-frow3">
              <div class="lj-fgroup">
                <label class="lj-label" for="state">State <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-map lj-iw-ico"></i>
                  <select id="state" name="state"
                    class="lj-input @error('state') field-error @enderror"
                    data-required="true"
                    data-label="State">
                    <option value="" disabled {{ old('state') ? '' : 'selected' }}>Select State</option>
                    <option value="Tamil Nadu" {{ old('state')=='Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                    <option value="Kerala" {{ old('state')=='Kerala' ? 'selected' : '' }}>Kerala</option>
                    <option value="Karnataka" {{ old('state')=='Karnataka' ? 'selected' : '' }}>Karnataka</option>
                    <option value="Andhra Pradesh" {{ old('state')=='Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                    <option value="Telangana" {{ old('state')=='Telangana' ? 'selected' : '' }}>Telangana</option>
                    <option value="Other" {{ old('state')=='Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
                <div class="lj-field-err @error('state') show @enderror" id="err-state">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('state'){{ $message }}@else Please select a state. @enderror</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="district">District <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-location-dot lj-iw-ico"></i>
                  <select id="district" name="district"
                    class="lj-input @error('district') field-error @enderror"
                    data-required="true"
                    data-label="District">
                    <option value="" disabled {{ old('district') ? '' : 'selected' }}>Select District</option>
                    @php $districts = ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Sivakasi','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                    @foreach($districts as $d)
                      <option value="{{ $d }}" {{ old('district')==$d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="lj-field-err @error('district') show @enderror" id="err-district">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('district'){{ $message }}@else Please select a district. @enderror</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="city">City / Town <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-city lj-iw-ico"></i>
                  <input type="text" id="city" name="city"
                    class="lj-input @error('city') field-error @enderror"
                    placeholder="Your city"
                    value="{{ old('city') }}"
                    data-required="true"
                    data-label="City / Town"
                    data-min="2" />
                </div>
                <div class="lj-field-err @error('city') show @enderror" id="err-city">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('city'){{ $message }}@else Please enter your city or town. @enderror</span>
                </div>
              </div>
            </div>
          </div>

          <div class="lj-reg-footer">
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(2)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(2)">
              Next: Education <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 3: Education & Experience
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-3">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-graduation-cap"></i>
            <div>
              <div class="lj-reg-card-head-title">Education & Experience</div>
              <div class="lj-reg-card-head-sub">Your qualifications and work history</div>
            </div>
          </div>
          <div class="lj-reg-body">

            <div class="lj-step-alert" id="alert-3">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-3-msg">Please fill in all required education fields.</span>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="qualification">Highest Education Qualification <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-book lj-iw-ico"></i>
                <select id="qualification" name="qualification"
                  class="lj-input @error('qualification') field-error @enderror"
                  data-required="true"
                  data-label="Qualification">
                  <option value="" disabled {{ old('qualification') ? '' : 'selected' }}>Select Qualification</option>
                  <option value="none" {{ old('qualification')=='none' ? 'selected' : '' }}>None</option>
                  <option value="10th" {{ old('qualification')=='10th' ? 'selected' : '' }}>10th Pass (SSLC)</option>
                  <option value="12th" {{ old('qualification')=='12th' ? 'selected' : '' }}>12th Pass (HSC / +2)</option>
                  <option value="diploma" {{ old('qualification')=='diploma' ? 'selected' : '' }}>Diploma</option>
                  <option value="bachelor" {{ old('qualification')=='bachelor' ? 'selected' : '' }}>Bachelor's Degree (UG)</option>
                  <option value="master" {{ old('qualification')=='master' ? 'selected' : '' }}>Master's Degree (PG)</option>
                  <option value="doctorate" {{ old('qualification')=='doctorate' ? 'selected' : '' }}>Doctorate / PhD</option>
                </select>
              </div>
              <div class="lj-field-err @error('qualification') show @enderror" id="err-qualification">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('qualification'){{ $message }}@else Please select your qualification. @enderror</span>
              </div>
            </div>

            <div class="lj-fsec">
              <div class="lj-fsec-line"></div>
              <div class="lj-fsec-lbl"><i class="fa-solid fa-briefcase"></i> Experience Level</div>
              <div class="lj-fsec-line"></div>
            </div>

            <div class="lj-fgroup">
              <div class="lj-exp-row">
                <div class="lj-exp-opt">
                  <input type="radio" id="exp_fresher" name="experience_level" value="fresher"
                    {{ old('experience_level','fresher')=='fresher' ? 'checked' : '' }}
                    onchange="toggleExpFields(false)">
                  <label for="exp_fresher"><i class="fa-solid fa-seedling"></i> Fresher</label>
                </div>
                <div class="lj-exp-opt">
                  <input type="radio" id="exp_experienced" name="experience_level" value="experienced"
                    {{ old('experience_level')=='experienced' ? 'checked' : '' }}
                    onchange="toggleExpFields(true)">
                  <label for="exp_experienced"><i class="fa-solid fa-briefcase"></i> Experienced</label>
                </div>
              </div>
            </div>

            <div id="expFields" class="{{ old('experience_level')=='experienced' ? 'show' : '' }}">
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="years_of_experience">Years of Experience</label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-clock lj-iw-ico"></i>
                    <select id="years_of_experience" name="years_of_experience" class="lj-input">
                      <option value="">Select Years</option>
                      <option value="less_1" {{ old('years_of_experience')=='less_1' ? 'selected':'' }}>Less than 1 year</option>
                      @for($y=1;$y<=15;$y++)
                        <option value="{{ $y }}" {{ old('years_of_experience')==$y ? 'selected':'' }}>{{ $y }} {{ $y==1?'year':'years' }}</option>
                      @endfor
                      <option value="15+" {{ old('years_of_experience')=='15+' ? 'selected':'' }}>15+ years</option>
                    </select>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="previous_company">Previous Company Name</label>
                  <div class="lj-iw">
                    <i class="fa-solid fa-building lj-iw-ico"></i>
                    <input type="text" id="previous_company" name="previous_company" class="lj-input"
                      placeholder="e.g. ABC Pvt Ltd" value="{{ old('previous_company') }}" />
                  </div>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="previous_designation">Previous Job Designation</label>
                <div class="lj-iw">
                  <i class="fa-solid fa-id-badge lj-iw-ico"></i>
                  <input type="text" id="previous_designation" name="previous_designation" class="lj-input"
                    placeholder="e.g. Sales Executive" value="{{ old('previous_designation') }}" />
                </div>
              </div>
            </div>
          </div>

          <div class="lj-reg-footer">
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(3)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(3)">
              Next: Skills <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 4: Skills Selection
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-4">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <div>
              <div class="lj-reg-card-head-title">Skills Selection</div>
              <div class="lj-reg-card-head-sub">Select all skills that apply to you</div>
            </div>
          </div>
          <div class="lj-reg-body">

            <div class="lj-step-alert" id="alert-4">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-4-msg">Please select at least one skill.</span>
            </div>

            @php
            $skills = [
              'IT & Software' => ['PHP Developer','Java Developer','Python Developer','React Developer','Angular Developer','Node.js Developer','MySQL / Database','WordPress Developer','UI/UX Designer','Network Engineer'],
              'Technical & Trade' => ['Electrician','Plumber','Welder','Machine Operator','CNC Operator','Lathe Operator','Mechanic','HVAC Technician','Quality Inspector','Safety Officer'],
              'Sales & Marketing' => ['Sales Executive','Marketing Executive','Field Sales','Tele-calling','Business Development','Digital Marketing','SEO Specialist','Brand Manager'],
              'Office & Admin' => ['Data Entry','HR Executive','Accountant','Office Admin','Receptionist','Customer Support','Back Office','Payroll Executive'],
              'Driver & Logistics' => ['Driver','Delivery Executive','Forklift Operator','Warehouse Staff','Packing & Loading'],
            ];
            $oldSkills = old('skills', []);
            @endphp

            @foreach($skills as $category => $skillList)
              <div class="lj-fsec" style="margin-top:{{ $loop->first ? '0' : '16px' }};">
                <div class="lj-fsec-lbl" style="font-size:.68rem;">{{ $category }}</div>
                <div class="lj-fsec-line"></div>
              </div>
              <div class="lj-skill-wrap">
                @foreach($skillList as $skill)
                  <div class="lj-skill-chip">
                    <input type="checkbox" id="skill_{{ Str::slug($skill) }}" name="skills[]"
                      value="{{ $skill }}" {{ in_array($skill,$oldSkills) ? 'checked' : '' }}>
                    <label for="skill_{{ Str::slug($skill) }}">{{ $skill }}</label>
                  </div>
                @endforeach
              </div>
            @endforeach

          </div>

          <div class="lj-reg-footer">
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(4)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(4)">
              Next: Documents <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 5: Resume & Documents
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-5">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-file-arrow-up"></i>
            <div>
              <div class="lj-reg-card-head-title">Resume & Profile Photo</div>
              <div class="lj-reg-card-head-sub">Upload your documents (optional but recommended)</div>
            </div>
          </div>
          <div class="lj-reg-body">
            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label">Upload Resume</label>
                <div class="lj-file-zone" id="resumeZone">
                  <input type="file" name="resume" id="resumeInput" accept=".pdf,.doc,.docx"
                    onchange="showFile('resumeZone','resumeLabel',this,'resume')">
                  <div class="lj-fz-ico"><i class="fa-solid fa-file-pdf" style="color:var(--blue);"></i></div>
                  <div class="lj-fz-title" id="resumeLabel">Click to upload resume</div>
                  <div class="lj-fz-sub">PDF, DOC, DOCX — Max 5 MB</div>
                </div>
                <div class="lj-field-err" id="err-resume">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span id="err-resume-msg">File size must not exceed 5 MB.</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label">Profile Photo <span style="color:var(--n400);font-weight:400;">(Optional)</span></label>
                <div class="lj-file-zone" id="photoZone">
                  <input type="file" name="profile_photo" id="photoInput" accept="image/*"
                    onchange="showFile('photoZone','photoLabel',this,'photo')">
                  <div class="lj-fz-ico"><i class="fa-solid fa-image" style="color:var(--blue);"></i></div>
                  <div class="lj-fz-title" id="photoLabel">Click to upload photo</div>
                  <div class="lj-fz-sub">JPG, PNG — Max 2 MB</div>
                </div>
                <div class="lj-field-err" id="err-photo">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span id="err-photo-msg">File size must not exceed 2 MB.</span>
                </div>
              </div>
            </div>

            {{-- Summary review --}}
            <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:var(--r);padding:18px;margin-top:20px;">
              <div style="font-size:.8rem;font-weight:700;color:var(--n700);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-list-check" style="color:var(--blue);"></i> Your Registration Summary
              </div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 24px;font-size:.8rem;color:var(--n600);" id="summaryGrid">
                <div><span style="color:var(--n400);">Name:</span> <strong id="sum-name">—</strong></div>
                <div><span style="color:var(--n400);">Mobile:</span> <strong id="sum-mobile">—</strong></div>
                <div><span style="color:var(--n400);">Email:</span> <strong id="sum-email">—</strong></div>
                <div><span style="color:var(--n400);">Location:</span> <strong id="sum-location">—</strong></div>
                <div><span style="color:var(--n400);">Qualification:</span> <strong id="sum-qual">—</strong></div>
                <div><span style="color:var(--n400);">Experience:</span> <strong id="sum-exp">—</strong></div>
                <div style="grid-column:1/-1;"><span style="color:var(--n400);">Skills:</span> <strong id="sum-skills">—</strong></div>
              </div>
            </div>
          </div>

          <div class="lj-reg-footer">
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(5)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
              <div style="font-size:.78rem;color:var(--n400);display:flex;align-items:center;gap:6px;">
                <i class="fa-solid fa-shield-halved" style="color:var(--green);"></i>
                Your data is safe &amp; private
              </div>
              <button type="submit" class="lj-submit" id="submitBtn">
                <i class="fa-solid fa-user-plus"></i> Create Account
              </button>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
/* ════════════════════════════════════════
   STATE
════════════════════════════════════════ */
let currentStep = 1;
const TOTAL_STEPS = 5;

/* ════════════════════════════════════════
   NAVIGATION
════════════════════════════════════════ */
function goToStep(target) {
  // Only allow going back or to completed steps
  if (target >= currentStep) return;
  showStep(target);
}

function nextStep(from) {
  if (!validateStep(from)) return;
  markDone(from);
  showStep(from + 1);
  if (from + 1 === 5) buildSummary();
}

function prevStep(from) {
  showStep(from - 1);
}

function showStep(step) {
  // Hide all panels
  document.querySelectorAll('.lj-tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + step).classList.add('active');

  // Update step indicators
  document.querySelectorAll('.lj-step').forEach(s => {
    const n = parseInt(s.dataset.step);
    s.classList.remove('active');
    if (n === step) s.classList.add('active');
  });

  currentStep = step;
  document.getElementById('currentStepLabel').textContent = step;

  // Allow clicking on completed steps
  document.querySelectorAll('.lj-step').forEach(s => {
    const n = parseInt(s.dataset.step);
    if (n < step) {
      s.style.cursor = 'pointer';
    } else {
      s.style.cursor = 'default';
    }
  });

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function markDone(step) {
  const el = document.querySelector('.lj-step[data-step="' + step + '"]');
  el.classList.remove('active');
  el.classList.add('done');
  el.querySelector('.lj-step-num').innerHTML = '<i class="fa-solid fa-check" style="font-size:.6rem;"></i>';
}

/* ════════════════════════════════════════
   VALIDATION
════════════════════════════════════════ */
function validateStep(step) {
  let valid = true;
  const panel = document.getElementById('tab-' + step);
  const alertEl = document.getElementById('alert-' + step);
  const msgEl = document.getElementById('alert-' + step + '-msg');
  const errors = [];

  // Clear previous errors in this panel
  panel.querySelectorAll('.lj-field-err').forEach(e => e.classList.remove('show'));
  panel.querySelectorAll('.lj-input').forEach(i => i.classList.remove('field-error'));
  if (alertEl) alertEl.classList.remove('show');

  if (step === 1) {
    // Full name
    const name = document.getElementById('full_name');
    if (!name.value.trim() || name.value.trim().length < 2) {
      showFieldError('full_name', 'Full Name is required (minimum 2 characters).');
      valid = false;
    }

    // Mobile
    const mob = document.getElementById('mobile');
    const mobVal = mob.value.replace(/\D/g, '');
    if (!mobVal || mobVal.length < 10) {
      showFieldError('mobile', 'Enter a valid 10-digit mobile number.');
      valid = false;
    }

    // Email
    const em = document.getElementById('email');
    if (!em.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value)) {
      showFieldError('email', 'Enter a valid email address.');
      valid = false;
    }

    // Password
    const pw = document.getElementById('password');
    if (!pw.value || pw.value.length < 8) {
      showFieldError('password', 'Password must be at least 8 characters.');
      valid = false;
    }

    // Confirm password
    const cpw = document.getElementById('password_confirmation');
    if (cpw.value !== pw.value) {
      showFieldError('password_confirmation', 'Passwords do not match.');
      valid = false;
    }
  }

  if (step === 2) {
    const state = document.getElementById('state');
    if (!state.value) {
      showFieldError('state', 'Please select a state.');
      valid = false;
    }

    const district = document.getElementById('district');
    if (!district.value) {
      showFieldError('district', 'Please select a district.');
      valid = false;
    }

    const city = document.getElementById('city');
    if (!city.value.trim() || city.value.trim().length < 2) {
      showFieldError('city', 'Please enter your city or town.');
      valid = false;
    }
  }

  if (step === 3) {
    const qual = document.getElementById('qualification');
    if (!qual.value) {
      showFieldError('qualification', 'Please select your highest qualification.');
      valid = false;
    }
  }

  if (step === 4) {
    const checked = document.querySelectorAll('input[name="skills[]"]:checked');
    if (checked.length === 0) {
      if (alertEl) {
        alertEl.classList.add('show');
        if (msgEl) msgEl.textContent = 'Please select at least one skill that applies to you.';
      }
      valid = false;
    }
  }

  if (!valid && alertEl && step !== 4) {
    alertEl.classList.add('show');
    if (msgEl) msgEl.textContent = 'Please fill in all required fields correctly before continuing.';
  }

  return valid;
}

function showFieldError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errEl = document.getElementById('err-' + fieldId);
  if (field) field.classList.add('field-error');
  if (errEl) {
    errEl.classList.add('show');
    const span = errEl.querySelector('span');
    if (span) span.textContent = message;
  }
}

/* ════════════════════════════════════════
   LIVE VALIDATION (clear on input)
════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
  // Clear field error on interaction
  document.querySelectorAll('.lj-input').forEach(function(inp) {
    inp.addEventListener('input', function() {
      this.classList.remove('field-error');
      const errEl = document.getElementById('err-' + this.id);
      if (errEl) errEl.classList.remove('show');
    });
    inp.addEventListener('change', function() {
      this.classList.remove('field-error');
      const errEl = document.getElementById('err-' + this.id);
      if (errEl) errEl.classList.remove('show');
    });
  });

  // Restore tab on server-side errors
  @if ($errors->any())
    @if ($errors->has('full_name') || $errors->has('mobile') || $errors->has('email') || $errors->has('password'))
      // Already on step 1
    @elseif ($errors->has('state') || $errors->has('district') || $errors->has('city'))
      markDone(1); showStep(2);
    @elseif ($errors->has('qualification'))
      markDone(1); markDone(2); showStep(3);
    @endif
  @endif
});

/* ════════════════════════════════════════
   PASSWORD UTILITIES
════════════════════════════════════════ */
function togglePwd(id, btn) {
  const inp = document.getElementById(id);
  const ico = btn.querySelector('i');
  if (inp.type === 'password') {
    inp.type = 'text';
    ico.className = 'fa-solid fa-eye-slash';
  } else {
    inp.type = 'password';
    ico.className = 'fa-solid fa-eye';
  }
}

function checkStrength(val) {
  const bar = document.getElementById('pwdBar');
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'];
  const widths = ['0%', '30%', '55%', '75%', '100%'];
  bar.style.width = widths[score];
  bar.style.background = colors[score];
}

/* ════════════════════════════════════════
   EXPERIENCE TOGGLE
════════════════════════════════════════ */
function toggleExpFields(show) {
  const el = document.getElementById('expFields');
  if (show) el.classList.add('show');
  else el.classList.remove('show');
}

/* ════════════════════════════════════════
   FILE UPLOAD
════════════════════════════════════════ */
function showFile(zoneId, labelId, input, type) {
  const errResume = document.getElementById('err-resume');
  const errPhoto = document.getElementById('err-photo');

  if (input.files && input.files[0]) {
    const file = input.files[0];
    const maxSize = type === 'resume' ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
    const errEl = type === 'resume' ? errResume : errPhoto;
    const errMsg = type === 'resume' ? 'Resume must not exceed 5 MB.' : 'Photo must not exceed 2 MB.';

    if (file.size > maxSize) {
      if (errEl) { errEl.classList.add('show'); errEl.querySelector('span').textContent = errMsg; }
      input.value = '';
      document.getElementById(labelId).textContent = type === 'resume' ? 'Click to upload resume' : 'Click to upload photo';
      return;
    }

    if (errEl) errEl.classList.remove('show');
    document.getElementById(labelId).textContent = file.name;
  }
}

/* ════════════════════════════════════════
   SUMMARY (Step 5 review)
════════════════════════════════════════ */
function buildSummary() {
  const qMap = {none:'None','10th':'10th Pass','12th':'12th / HSC',diploma:'Diploma',bachelor:"Bachelor's",master:"Master's",doctorate:'Doctorate / PhD'};
  const skills = Array.from(document.querySelectorAll('input[name="skills[]"]:checked')).map(c => c.value);
  const qual = document.getElementById('qualification');
  const exp = document.getElementById('exp_experienced').checked ? 'Experienced' : 'Fresher';
  const state = document.getElementById('state').value;
  const dist = document.getElementById('district').value;
  const city = document.getElementById('city').value;

  document.getElementById('sum-name').textContent = document.getElementById('full_name').value || '—';
  document.getElementById('sum-mobile').textContent = document.getElementById('mobile').value || '—';
  document.getElementById('sum-email').textContent = document.getElementById('email').value || '—';
  document.getElementById('sum-location').textContent = [city, dist, state].filter(Boolean).join(', ') || '—';
  document.getElementById('sum-qual').textContent = qMap[qual.value] || qual.value || '—';
  document.getElementById('sum-exp').textContent = exp;
  document.getElementById('sum-skills').textContent = skills.length ? skills.slice(0, 8).join(', ') + (skills.length > 8 ? ' +' + (skills.length - 8) + ' more' : '') : 'None selected';
}

/* ════════════════════════════════════════
   SUBMIT LOADING STATE
════════════════════════════════════════ */
document.getElementById('regForm').addEventListener('submit', function() {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Account...';
});
</script>
@endpush