{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/auth/employer-register.blade.php
     Multi-Step Employer Registration – LinearJobs
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Register Your Company – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* ── PAGE ─────────────────────────────────────────── */
.lj-reg-page{background:var(--n50);min-height:calc(100vh - 64px);padding:40px 20px 60px;}
.lj-reg-wrap{max-width:860px;margin:0 auto;}
.lj-reg-head{text-align:center;margin-bottom:32px;}
.lj-reg-head-ico{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,rgba(26,86,219,.12),rgba(30,58,138,.18));color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin:0 auto 14px;box-shadow:0 4px 14px rgba(26,86,219,.15);}
.lj-reg-title{font-size:1.75rem;font-weight:800;color:var(--n900);letter-spacing:-.5px;margin-bottom:6px;}
.lj-reg-sub{font-size:.9rem;color:var(--n500);line-height:1.6;}
/* ── STEPS ────────────────────────────────────────── */
.lj-steps{display:flex;align-items:flex-start;justify-content:center;max-width:560px;margin:0 auto 10px;}
.lj-step{display:flex;flex-direction:column;align-items:center;flex:1;position:relative;cursor:default;}
.lj-step:not(:last-child)::after{content:'';position:absolute;top:14px;left:50%;width:100%;height:2px;background:var(--n100);z-index:0;transition:background .4s;}
.lj-step.done:not(:last-child)::after{background:var(--green);}
.lj-step.active:not(:last-child)::after{background:var(--blue);}
.lj-step-num{width:28px;height:28px;border-radius:50%;background:var(--n100);color:var(--n500);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;position:relative;z-index:1;transition:all .3s;}
.lj-step.active .lj-step-num{background:var(--blue);color:#fff;box-shadow:0 0 0 4px rgba(26,86,219,.14);}
.lj-step.done .lj-step-num{background:var(--green);color:#fff;}
.lj-step-lbl{font-size:.62rem;color:var(--n400);margin-top:5px;font-weight:600;text-align:center;white-space:nowrap;}
.lj-step.active .lj-step-lbl{color:var(--blue);}
.lj-step.done .lj-step-lbl{color:var(--green);}
.lj-step.done{cursor:pointer;}
/* Progress label */
.lj-progress-label{text-align:center;font-size:.78rem;color:var(--n400);margin-top:8px;margin-bottom:28px;font-weight:500;}
.lj-progress-label span{color:var(--blue);font-weight:700;}
/* ── CARD ─────────────────────────────────────────── */
.lj-reg-card{background:#fff;border:1.5px solid var(--n200);border-radius:var(--r-lg);box-shadow:var(--sh-md);overflow:hidden;}
.lj-reg-card-head{background:linear-gradient(90deg,#1a56db 0%,#1e3a8a 100%);padding:18px 28px;display:flex;align-items:center;gap:12px;}
.lj-reg-card-head i{color:rgba(255,255,255,.9);font-size:1rem;}
.lj-reg-card-head-title{font-size:.9375rem;font-weight:700;color:#fff;}
.lj-reg-card-head-sub{font-size:.78rem;color:rgba(255,255,255,.7);margin-top:1px;}
.lj-reg-body{padding:28px;}
/* ── TAB PANELS ───────────────────────────────────── */
.lj-tab-panel{display:none;}
.lj-tab-panel.active{display:block;animation:fadeSlideIn .3s ease;}
@keyframes fadeSlideIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
/* ── FORM ELEMENTS ────────────────────────────────── */
.lj-fgroup{margin-bottom:16px;}
.lj-frow{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.lj-frow3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.lj-label{display:block;font-size:.8125rem;font-weight:600;color:var(--n700);margin-bottom:6px;}
.lj-label .req{color:#e53e3e;margin-left:2px;}
.lj-opt-badge{font-size:.68rem;font-weight:500;color:var(--n400);margin-left:6px;background:var(--n100);padding:1px 7px;border-radius:100px;}
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
textarea.lj-input{padding-top:10px;resize:vertical;min-height:90px;}
.lj-hint{font-size:.73rem;color:var(--n400);margin-top:4px;display:flex;align-items:center;gap:5px;}
.lj-hint i{font-size:.68rem;}
/* Field error */
.lj-field-err{font-size:.75rem;color:#dc2626;margin-top:4px;display:none;align-items:center;gap:4px;}
.lj-field-err.show{display:flex;}
.lj-field-err i{font-size:.7rem;flex-shrink:0;}
/* Section divider */
.lj-fsec{display:flex;align-items:center;gap:10px;margin:22px 0 16px;}
.lj-fsec-line{flex:1;height:1px;background:var(--n100);}
.lj-fsec-lbl{font-size:.7rem;font-weight:800;color:var(--n400);letter-spacing:.08em;text-transform:uppercase;white-space:nowrap;display:flex;align-items:center;gap:6px;}
.lj-fsec-lbl i{font-size:.75rem;color:var(--blue);}
/* Step alert */
.lj-step-alert{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:11px 14px;margin-bottom:16px;display:none;align-items:flex-start;gap:9px;font-size:.83rem;color:#b91c1c;animation:shakeX .35s ease;}
.lj-step-alert.show{display:flex;}
@keyframes shakeX{0%,100%{transform:translateX(0)}20%{transform:translateX(-6px)}40%{transform:translateX(6px)}60%{transform:translateX(-4px)}80%{transform:translateX(4px)}}
/* Info box */
.lj-info-box{background:linear-gradient(135deg,rgba(26,86,219,.04),rgba(30,58,138,.06));border:1.5px solid rgba(26,86,219,.12);border-radius:var(--r);padding:13px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:.82rem;color:var(--n700);}
.lj-info-box i{color:var(--blue);flex-shrink:0;margin-top:1px;}
/* File upload */
.lj-file-zone{border:1.5px dashed var(--n200);border-radius:var(--r);padding:20px 16px;text-align:center;cursor:pointer;transition:border-color var(--t),background var(--t);background:var(--n50);position:relative;}
.lj-file-zone:hover{border-color:var(--blue);background:rgba(26,86,219,.03);}
.lj-file-zone input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;}
.lj-fz-ico{width:44px;height:44px;border-radius:50%;background:#fff;border:1.5px solid var(--n200);display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--n400);margin:0 auto 10px;}
.lj-fz-title{font-size:.875rem;font-weight:600;color:var(--n700);margin-bottom:3px;}
.lj-fz-sub{font-size:.75rem;color:var(--n400);}
/* Password strength */
.lj-pwd-strength{height:4px;border-radius:2px;background:var(--n100);margin-top:6px;overflow:hidden;}
.lj-pwd-bar{height:100%;width:0%;border-radius:2px;transition:width .3s,background .3s;}
/* Footer nav */
.lj-reg-footer{padding:20px 28px;border-top:1px solid var(--n100);background:var(--n50);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.lj-btn-nav{border:none;border-radius:var(--r);font-family:var(--f);font-size:.9rem;font-weight:700;padding:11px 24px;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all var(--t);}
.lj-btn-prev{background:#fff;border:1.5px solid var(--n200);color:var(--n700);}
.lj-btn-prev:hover{border-color:var(--n400);background:var(--n50);}
.lj-btn-next{background:var(--blue);color:#fff;}
.lj-btn-next:hover{background:var(--blue-h);transform:translateY(-1px);box-shadow:0 4px 14px rgba(26,86,219,.28);}
.lj-submit{background:linear-gradient(135deg,#1a56db,#1e3a8a);color:#fff;border:none;border-radius:var(--r);font-family:var(--f);font-size:.9375rem;font-weight:700;padding:12px 28px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all var(--t);}
.lj-submit:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(26,86,219,.35);}
.lj-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
.lj-reg-switch{font-size:.875rem;color:var(--n500);}
.lj-reg-switch a{color:var(--blue);font-weight:600;text-decoration:none;}
.lj-reg-switch a:hover{text-decoration:underline;}
/* Server error */
.lj-alert-err{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:12px 14px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:.84rem;color:#b91c1c;}
.lj-alert-err i{color:#ef4444;flex-shrink:0;margin-top:1px;}
/* Summary card */
.lj-summary-card{background:var(--n50);border:1.5px solid var(--n100);border-radius:var(--r);padding:18px;margin-top:20px;}
.lj-summary-title{font-size:.8rem;font-weight:700;color:var(--n700);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
.lj-summary-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px 24px;font-size:.8rem;color:var(--n600);}
.lj-summary-grid div span:first-child{color:var(--n400);}
/* GST verified badge */
.lj-verified{display:inline-flex;align-items:center;gap:5px;font-size:.73rem;color:#15803d;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:100px;padding:2px 9px;margin-top:4px;display:none;}
.lj-verified.show{display:inline-flex;}
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
      <div class="lj-reg-head-ico"><i class="fa-solid fa-building-flag"></i></div>
      <div class="lj-reg-title">Register Your Company</div>
      <div class="lj-reg-sub">Join LinearJobs and connect with skilled professionals across Tamil Nadu. Post jobs in minutes.</div>
    </div>

    {{-- Step Indicator --}}
    <div class="lj-steps" id="stepIndicator">
      <div class="lj-step active" data-step="1" onclick="goToStep(1)">
        <div class="lj-step-num"><i class="fa-solid fa-building" style="font-size:.6rem;"></i></div>
        <div class="lj-step-lbl">Company</div>
      </div>
      <div class="lj-step" data-step="2" onclick="goToStep(2)">
        <div class="lj-step-num">2</div>
        <div class="lj-step-lbl">Contact</div>
      </div>
      <div class="lj-step" data-step="3" onclick="goToStep(3)">
        <div class="lj-step-num">3</div>
        <div class="lj-step-lbl">Account</div>
      </div>
      <div class="lj-step" data-step="4" onclick="goToStep(4)">
        <div class="lj-step-num">4</div>
        <div class="lj-step-lbl">Verification</div>
      </div>
      <div class="lj-step" data-step="5" onclick="goToStep(5)">
        <div class="lj-step-num">5</div>
        <div class="lj-step-lbl">Documents</div>
      </div>
    </div>
    {{-- <div class="lj-progress-label">Step <span id="currentStepLabel">1</span> of 5</div> --}}

    {{-- Server-side errors --}}
    @if ($errors->any())
      <div class="lj-alert-err">
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

    <form method="POST" action="{{ route('employer.register.submit') }}" enctype="multipart/form-data" id="regForm" novalidate>
      @csrf

      {{-- ══════════════════════════════════
           TAB 1: Company Information
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel active" id="tab-1">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-building"></i>
            <div>
              <div class="lj-reg-card-head-title">Company Information</div>
              <div class="lj-reg-card-head-sub">Tell us about your business</div>
            </div>
          </div>
          <div class="lj-reg-body">
            <div class="lj-step-alert" id="alert-1">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-1-msg">Please fill in all required fields correctly.</span>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="company_name">Company Name <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-building lj-iw-ico"></i>
                <input type="text" id="company_name" name="company_name"
                  class="lj-input @error('company_name') field-error @enderror"
                  placeholder="e.g. ABC Industries Pvt Ltd"
                  value="{{ old('company_name') }}"
                  data-required="true" data-min="2" />
              </div>
              <div class="lj-field-err @error('company_name') show @enderror" id="err-company_name">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('company_name'){{ $message }}@else Company name is required. @enderror</span>
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="company_address">Company Address <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-map-pin lj-iw-ico" style="top:18px;transform:none;"></i>
                <textarea id="company_address" name="company_address"
                  class="lj-input @error('company_address') field-error @enderror"
                  placeholder="Full registered address of your company"
                  data-required="true" data-min="10"
                  rows="3">{{ old('company_address') }}</textarea>
              </div>
              <div class="lj-field-err @error('company_address') show @enderror" id="err-company_address">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('company_address'){{ $message }}@else Please enter your company address. @enderror</span>
              </div>
            </div>

            <div class="lj-frow3">
              <div class="lj-fgroup">
                <label class="lj-label" for="state">State <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-map lj-iw-ico"></i>
                  <select id="state" name="state"
                    class="lj-input @error('state') field-error @enderror"
                    data-required="true">
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
                    data-required="true">
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
                    placeholder="City"
                    value="{{ old('city') }}"
                    data-required="true" data-min="2" />
                </div>
                <div class="lj-field-err @error('city') show @enderror" id="err-city">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('city'){{ $message }}@else Please enter the city. @enderror</span>
                </div>
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="pincode">Pincode <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-hashtag lj-iw-ico"></i>
                <input type="text" id="pincode" name="pincode"
                  class="lj-input @error('pincode') field-error @enderror"
                  placeholder="6-digit pincode"
                  value="{{ old('pincode') }}"
                  data-required="true" data-pattern="pincode"
                  maxlength="6" style="max-width:200px;" />
              </div>
              <div class="lj-field-err @error('pincode') show @enderror" id="err-pincode">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('pincode'){{ $message }}@else Enter a valid 6-digit pincode. @enderror</span>
              </div>
            </div>
          </div>
          <div class="lj-reg-footer">
            <div class="lj-reg-switch">Already registered? <a href="{{ route('employer.login') }}">Login here</a></div>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(1)">
              Next: Contact Details <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 2: Contact Details
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-2">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-address-book"></i>
            <div>
              <div class="lj-reg-card-head-title">Contact Details</div>
              <div class="lj-reg-card-head-sub">Owner and HR / Recruiter information</div>
            </div>
          </div>
          <div class="lj-reg-body">
            <div class="lj-step-alert" id="alert-2">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-2-msg">Please fill in all required contact fields.</span>
            </div>

            {{-- Owner --}}
            <div class="lj-fsec" style="margin-top:0;">
              <div class="lj-fsec-lbl"><i class="fa-solid fa-user-tie"></i> Owner / Director</div>
              <div class="lj-fsec-line"></div>
            </div>
            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label" for="owner_name">Owner Name <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-user lj-iw-ico"></i>
                  <input type="text" id="owner_name" name="owner_name"
                    class="lj-input @error('owner_name') field-error @enderror"
                    placeholder="Full name"
                    value="{{ old('owner_name') }}"
                    data-required="true" data-min="2" />
                </div>
                <div class="lj-field-err @error('owner_name') show @enderror" id="err-owner_name">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('owner_name'){{ $message }}@else Owner name is required. @enderror</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="owner_mobile">Owner Mobile Number <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                  <input type="tel" id="owner_mobile" name="owner_mobile"
                    class="lj-input @error('owner_mobile') field-error @enderror"
                    placeholder="+91 XXXXX XXXXX"
                    value="{{ old('owner_mobile') }}"
                    data-required="true" data-pattern="phone"
                    maxlength="15" />
                </div>
                <div class="lj-field-err @error('owner_mobile') show @enderror" id="err-owner_mobile">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('owner_mobile'){{ $message }}@else Enter a valid 10-digit mobile number. @enderror</span>
                </div>
              </div>
            </div>

            {{-- HR --}}
            <div class="lj-fsec">
              <div class="lj-fsec-lbl"><i class="fa-solid fa-user-gear"></i> HR / Recruiter</div>
              <div class="lj-fsec-line"></div>
            </div>
            <div class="lj-info-box">
              <i class="fa-solid fa-circle-info"></i>
              <span>If you don't have a dedicated HR, you can enter the owner's details again below.</span>
            </div>
            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label" for="hr_name">HR / Recruiter Name <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-user lj-iw-ico"></i>
                  <input type="text" id="hr_name" name="hr_name"
                    class="lj-input @error('hr_name') field-error @enderror"
                    placeholder="Full name"
                    value="{{ old('hr_name') }}"
                    data-required="true" data-min="2" />
                </div>
                <div class="lj-field-err @error('hr_name') show @enderror" id="err-hr_name">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('hr_name'){{ $message }}@else HR name is required. @enderror</span>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="hr_mobile">HR Mobile Number <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                  <input type="tel" id="hr_mobile" name="hr_mobile"
                    class="lj-input @error('hr_mobile') field-error @enderror"
                    placeholder="+91 XXXXX XXXXX"
                    value="{{ old('hr_mobile') }}"
                    data-required="true" data-pattern="phone"
                    maxlength="15" />
                </div>
                <div class="lj-field-err @error('hr_mobile') show @enderror" id="err-hr_mobile">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('hr_mobile'){{ $message }}@else Enter a valid 10-digit mobile number. @enderror</span>
                </div>
              </div>
            </div>
          </div>
          <div class="lj-reg-footer">
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(2)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(2)">
              Next: Account Setup <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 3: Account Details
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-3">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-shield-halved"></i>
            <div>
              <div class="lj-reg-card-head-title">Account Details</div>
              <div class="lj-reg-card-head-sub">Set up your login credentials</div>
            </div>
          </div>
          <div class="lj-reg-body">
            <div class="lj-step-alert" id="alert-3">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-3-msg">Please fill in all required account fields.</span>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="email">Official Email Address <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-envelope lj-iw-ico"></i>
                <input type="email" id="email" name="email"
                  class="lj-input @error('email') field-error @enderror"
                  placeholder="company@example.com"
                  value="{{ old('email') }}"
                  data-required="true" data-pattern="email"
                  autocomplete="email" />
              </div>
              <div class="lj-field-err @error('email') show @enderror" id="err-email">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>@error('email'){{ $message }}@else Enter a valid email address. @enderror</span>
              </div>
              <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> This will be your login email</div>
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
                    data-required="true" data-min="8"
                    autocomplete="new-password"
                    oninput="checkStrength(this.value)" />
                  <button type="button" class="lj-iw-ico-r" onclick="togglePwd('password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                </div>
                <div class="lj-pwd-strength"><div class="lj-pwd-bar" id="pwdBar"></div></div>
                <div class="lj-field-err @error('password') show @enderror" id="err-password">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('password'){{ $message }}@else Password must be at least 8 characters. @enderror</span>
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Min 8 characters with letters and numbers</div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="password_confirmation">Confirm Password <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-lock lj-iw-ico"></i>
                  <input type="password" id="password_confirmation" name="password_confirmation"
                    class="lj-input pr"
                    placeholder="Re-enter password"
                    data-required="true" data-match="password"
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
            <button type="button" class="lj-btn-nav lj-btn-prev" onclick="prevStep(3)">
              <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <button type="button" class="lj-btn-nav lj-btn-next" onclick="nextStep(3)">
              Next: Business Verification <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      {{-- ══════════════════════════════════
           TAB 4: Business Verification
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-4">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-file-certificate"></i>
            <div>
              <div class="lj-reg-card-head-title">Business Verification</div>
              <div class="lj-reg-card-head-sub">Provide your business registration numbers</div>
            </div>
          </div>
          <div class="lj-reg-body">
            <div class="lj-step-alert" id="alert-4">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span id="alert-4-msg">Please provide your GST and PAN numbers.</span>
            </div>

            <div class="lj-info-box">
              <i class="fa-solid fa-shield-check"></i>
              <span>Your business details are encrypted and used only for verification. Only verified employers can post jobs on LinearJobs.</span>
            </div>

            <div class="lj-frow">
              <div class="lj-fgroup">
                <label class="lj-label" for="gst_number">GST Number <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-receipt lj-iw-ico"></i>
                  <input type="text" id="gst_number" name="gst_number"
                    class="lj-input @error('gst_number') field-error @enderror"
                    placeholder="e.g. 33AABCU9603R1ZX"
                    value="{{ old('gst_number') }}"
                    data-required="true" data-pattern="gst"
                    maxlength="15"
                    style="text-transform:uppercase;"
                    oninput="this.value=this.value.toUpperCase()" />
                </div>
                <div class="lj-field-err @error('gst_number') show @enderror" id="err-gst_number">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('gst_number'){{ $message }}@else Enter a valid 15-character GST number. @enderror</span>
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> 15-character alphanumeric GST registration number</div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="pan_number">PAN Number <span class="req">*</span></label>
                <div class="lj-iw">
                  <i class="fa-solid fa-id-card lj-iw-ico"></i>
                  <input type="text" id="pan_number" name="pan_number"
                    class="lj-input @error('pan_number') field-error @enderror"
                    placeholder="e.g. AABCU9603R"
                    value="{{ old('pan_number') }}"
                    data-required="true" data-pattern="pan"
                    maxlength="10"
                    style="text-transform:uppercase;"
                    oninput="this.value=this.value.toUpperCase()" />
                </div>
                <div class="lj-field-err @error('pan_number') show @enderror" id="err-pan_number">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span>@error('pan_number'){{ $message }}@else Enter a valid 10-character PAN number. @enderror</span>
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Company / Individual PAN number</div>
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="msme_number">MSME Number <span class="lj-opt-badge">Optional</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-industry lj-iw-ico"></i>
                <input type="text" id="msme_number" name="msme_number"
                  class="lj-input @error('msme_number') field-error @enderror"
                  placeholder="MSME / Udyam Registration Number"
                  value="{{ old('msme_number') }}"
                  style="max-width:380px;" />
              </div>
              <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Udyam number (e.g. UDYAM-TN-01-0000000) — optional but recommended</div>
            </div>
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
           TAB 5: Document Upload + Review
      ══════════════════════════════════ --}}
      <div class="lj-tab-panel" id="tab-5">
        <div class="lj-reg-card">
          <div class="lj-reg-card-head">
            <i class="fa-solid fa-file-arrow-up"></i>
            <div>
              <div class="lj-reg-card-head-title">Document Upload</div>
              <div class="lj-reg-card-head-sub">Upload your verification documents</div>
            </div>
          </div>
          <div class="lj-reg-body">

            <div class="lj-frow">
              {{-- GST Certificate --}}
              <div class="lj-fgroup">
                <label class="lj-label">GST Certificate <span class="req">*</span></label>
                <div class="lj-file-zone" id="gstZone">
                  <input type="file" name="gst_certificate" id="gstInput" accept=".pdf,.jpg,.jpeg,.png"
                    onchange="showFile('gstZone','gstLabel',this,5,'gst')">
                  <div class="lj-fz-ico"><i class="fa-solid fa-file-invoice" style="color:var(--blue);"></i></div>
                  <div class="lj-fz-title" id="gstLabel">Click to upload GST certificate</div>
                  <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                </div>
                <div class="lj-field-err" id="err-gst_certificate">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span id="err-gst-msg">GST certificate is required.</span>
                </div>
              </div>
              {{-- PAN Document --}}
              <div class="lj-fgroup">
                <label class="lj-label">PAN Document <span class="req">*</span></label>
                <div class="lj-file-zone" id="panZone">
                  <input type="file" name="pan_document" id="panInput" accept=".pdf,.jpg,.jpeg,.png"
                    onchange="showFile('panZone','panLabel',this,5,'pan')">
                  <div class="lj-fz-ico"><i class="fa-solid fa-id-card" style="color:var(--blue);"></i></div>
                  <div class="lj-fz-title" id="panLabel">Click to upload PAN document</div>
                  <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                </div>
                <div class="lj-field-err" id="err-pan_document">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  <span id="err-pan-msg">PAN document is required.</span>
                </div>
              </div>
            </div>

            {{-- MSME Certificate Optional --}}
            <div class="lj-fgroup">
              <label class="lj-label">MSME Certificate <span class="lj-opt-badge">Optional</span></label>
              <div class="lj-file-zone" id="msmeZone" style="max-width:380px;">
                <input type="file" name="msme_certificate" id="msmeInput" accept=".pdf,.jpg,.jpeg,.png"
                  onchange="showFile('msmeZone','msmeLabel',this,5,'msme')">
                <div class="lj-fz-ico"><i class="fa-solid fa-industry" style="color:var(--blue);"></i></div>
                <div class="lj-fz-title" id="msmeLabel">Click to upload MSME certificate</div>
                <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
              </div>
            </div>

            {{-- Summary --}}
            <div class="lj-summary-card">
              <div class="lj-summary-title">
                <i class="fa-solid fa-list-check" style="color:var(--blue);"></i> Registration Summary
              </div>
              <div class="lj-summary-grid" id="summaryGrid">
                <div><span>Company:</span> <strong id="sum-company">—</strong></div>
                <div><span>Location:</span> <strong id="sum-location">—</strong></div>
                <div><span>Owner:</span> <strong id="sum-owner">—</strong></div>
                <div><span>HR Contact:</span> <strong id="sum-hr">—</strong></div>
                <div><span>Email:</span> <strong id="sum-email">—</strong></div>
                <div><span>GST:</span> <strong id="sum-gst">—</strong></div>
                <div><span>PAN:</span> <strong id="sum-pan">—</strong></div>
                <div><span>MSME:</span> <strong id="sum-msme">Not provided</strong></div>
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
                <i class="fa-solid fa-building-flag"></i> Register Company
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
   STATE & NAVIGATION
════════════════════════════════════════ */
let currentStep = 1;

function goToStep(target) {
  if (target >= currentStep) return;
  showStep(target);
}

function nextStep(from) {
  if (!validateStep(from)) return;
  markDone(from);
  showStep(from + 1);
  if (from + 1 === 5) buildSummary();
}

function prevStep(from) { showStep(from - 1); }

function showStep(step) {
  document.querySelectorAll('.lj-tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + step).classList.add('active');
  document.querySelectorAll('.lj-step').forEach(s => {
    s.classList.remove('active');
    s.style.cursor = parseInt(s.dataset.step) < step ? 'pointer' : 'default';
  });
  document.querySelector('.lj-step[data-step="' + step + '"]').classList.add('active');
  currentStep = step;
  document.getElementById('currentStepLabel').textContent = step;
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
  panel.querySelectorAll('.lj-field-err').forEach(e => e.classList.remove('show'));
  panel.querySelectorAll('.lj-input').forEach(i => i.classList.remove('field-error'));
  if (alertEl) alertEl.classList.remove('show');

  const rules = {
    1: [
      { id:'company_name', min:2, msg:'Company name is required (min. 2 characters).' },
      { id:'company_address', min:10, msg:'Please enter your company address.' },
      { id:'state', select:true, msg:'Please select a state.' },
      { id:'district', select:true, msg:'Please select a district.' },
      { id:'city', min:2, msg:'Please enter the city.' },
      { id:'pincode', pattern:'pincode', msg:'Enter a valid 6-digit pincode.' },
    ],
    2: [
      { id:'owner_name', min:2, msg:'Owner name is required.' },
      { id:'owner_mobile', pattern:'phone', msg:'Enter a valid 10-digit mobile number.' },
      { id:'hr_name', min:2, msg:'HR name is required.' },
      { id:'hr_mobile', pattern:'phone', msg:'Enter a valid 10-digit mobile number.' },
    ],
    3: [
      { id:'email', pattern:'email', msg:'Enter a valid email address.' },
      { id:'password', min:8, msg:'Password must be at least 8 characters.' },
      { id:'password_confirmation', match:'password', msg:'Passwords do not match.' },
    ],
    4: [
      { id:'gst_number', pattern:'gst', msg:'Enter a valid 15-character GST number.' },
      { id:'pan_number', pattern:'pan', msg:'Enter a valid 10-character PAN number.' },
    ],
  };

  if (rules[step]) {
    rules[step].forEach(rule => {
      const field = document.getElementById(rule.id);
      if (!field) return;
      const val = field.value.trim();
      let err = false;

      if (rule.select && !val) err = true;
      else if (rule.min && val.length < rule.min) err = true;
      else if (rule.match) {
        const matchField = document.getElementById(rule.match);
        if (!val || val !== matchField.value) err = true;
      } else if (rule.pattern === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) err = true;
      else if (rule.pattern === 'phone' && val.replace(/\D/g,'').length < 10) err = true;
      else if (rule.pattern === 'pincode' && !/^\d{6}$/.test(val)) err = true;
      else if (rule.pattern === 'gst' && !/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(val)) err = true;
      else if (rule.pattern === 'pan' && !/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(val)) err = true;

      if (err) {
        valid = false;
        showFieldError(rule.id, rule.msg);
      }
    });
  }

  if (!valid && alertEl) alertEl.classList.add('show');
  return valid;
}

function showFieldError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errEl = document.getElementById('err-' + fieldId);
  if (field) field.classList.add('field-error');
  if (errEl) {
    errEl.classList.add('show');
    const span = errEl.querySelector('span');
    if (span && message) span.textContent = message;
  }
}

/* ════════════════════════════════════════
   LIVE CLEAR ERRORS
════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.lj-input').forEach(function(inp) {
    ['input','change'].forEach(ev => inp.addEventListener(ev, function() {
      this.classList.remove('field-error');
      const errEl = document.getElementById('err-' + this.id);
      if (errEl) errEl.classList.remove('show');
    }));
  });
});

/* ════════════════════════════════════════
   PASSWORD UTILITIES
════════════════════════════════════════ */
function togglePwd(id, btn) {
  const inp = document.getElementById(id);
  const ico = btn.querySelector('i');
  if (inp.type === 'password') { inp.type = 'text'; ico.className = 'fa-solid fa-eye-slash'; }
  else { inp.type = 'password'; ico.className = 'fa-solid fa-eye'; }
}

function checkStrength(val) {
  const bar = document.getElementById('pwdBar');
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  bar.style.width = ['0%','30%','55%','75%','100%'][score];
  bar.style.background = ['','#ef4444','#f97316','#eab308','#22c55e'][score];
}

/* ════════════════════════════════════════
   FILE UPLOAD
════════════════════════════════════════ */
function showFile(zoneId, labelId, input, maxMB, type) {
  const errEl = document.getElementById('err-' + (type==='gst'?'gst_certificate':type==='pan'?'pan_document':'msme_certificate'));
  if (input.files && input.files[0]) {
    const file = input.files[0];
    if (file.size > maxMB * 1024 * 1024) {
      if (errEl) { errEl.classList.add('show'); const sp = errEl.querySelector('span'); if(sp) sp.textContent = 'File must not exceed ' + maxMB + ' MB.'; }
      input.value = '';
      return;
    }
    if (errEl) errEl.classList.remove('show');
    document.getElementById(labelId).textContent = file.name;
  }
}

/* ════════════════════════════════════════
   SUMMARY
════════════════════════════════════════ */
function buildSummary() {
  const v = id => (document.getElementById(id)||{}).value || '—';
  const city = v('city'), dist = v('district'), state = v('state');
  document.getElementById('sum-company').textContent = v('company_name');
  document.getElementById('sum-location').textContent = [city, dist, state].filter(s=>s&&s!=='—').join(', ') || '—';
  document.getElementById('sum-owner').textContent = v('owner_name') + (v('owner_mobile')!=='—' ? ' · ' + v('owner_mobile') : '');
  document.getElementById('sum-hr').textContent = v('hr_name') + (v('hr_mobile')!=='—' ? ' · ' + v('hr_mobile') : '');
  document.getElementById('sum-email').textContent = v('email');
  document.getElementById('sum-gst').textContent = v('gst_number');
  document.getElementById('sum-pan').textContent = v('pan_number');
  const msme = v('msme_number');
  document.getElementById('sum-msme').textContent = msme !== '—' ? msme : 'Not provided';
}

/* ════════════════════════════════════════
   SUBMIT
════════════════════════════════════════ */
document.getElementById('regForm').addEventListener('submit', function(e) {
  // Validate documents
  const gst = document.getElementById('gstInput');
  const pan = document.getElementById('panInput');
  let ok = true;
  if (!gst.files || !gst.files[0]) {
    document.getElementById('err-gst_certificate').classList.add('show');
    document.getElementById('err-gst-msg').textContent = 'GST certificate is required.';
    ok = false;
  }
  if (!pan.files || !pan.files[0]) {
    document.getElementById('err-pan_document').classList.add('show');
    document.getElementById('err-pan-msg').textContent = 'PAN document is required.';
    ok = false;
  }
  if (!ok) { e.preventDefault(); return; }

  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Registering Company...';
});
</script>
@endpush