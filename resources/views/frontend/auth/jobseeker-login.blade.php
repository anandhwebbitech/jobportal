{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/auth/jobseeker-login.blade.php
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Job Seeker Login – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.lj-auth-page{min-height:calc(100vh - 64px);display:flex;}
.lj-auth-split{display:grid;grid-template-columns:420px 1fr;width:100%;min-height:calc(100vh - 64px);}

/* ── LEFT PANEL ───────────────────────────────────── */
.lj-auth-left{background:linear-gradient(155deg,#1a56db 0%,#1e3a8a 100%);display:flex;flex-direction:column;justify-content:center;padding:60px 48px;position:relative;overflow:hidden;}
.lj-auth-left::before{content:'';position:absolute;top:-120px;right:-80px;width:400px;height:400px;border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none;}
.lj-auth-left::after{content:'';position:absolute;bottom:-100px;left:-60px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.04);pointer-events:none;}
.lj-al-dots{position:absolute;top:40px;left:40px;display:grid;grid-template-columns:repeat(6,1fr);gap:9px;opacity:.12;}
.lj-al-dots span{width:5px;height:5px;border-radius:50%;background:#fff;display:block;}
.lj-al-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);border-radius:100px;padding:6px 16px;font-size:.75rem;font-weight:700;color:rgba(255,255,255,.9);letter-spacing:.05em;text-transform:uppercase;margin-bottom:28px;width:fit-content;}
.lj-al-badge i{color:#bfdbfe;}
.lj-al-title{font-size:clamp(1.5rem,2.4vw,1.95rem);font-weight:800;color:#fff;line-height:1.22;letter-spacing:-.4px;margin-bottom:14px;}
.lj-al-sub{font-size:.875rem;color:rgba(255,255,255,.72);line-height:1.7;margin-bottom:36px;}
.lj-al-perks{display:flex;flex-direction:column;gap:14px;}
.lj-al-perk{display:flex;align-items:flex-start;gap:12px;}
.lj-al-perk-ico{width:34px;height:34px;flex-shrink:0;border-radius:var(--r-sm);background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;font-size:.8rem;color:#fff;}
.lj-al-perk-text{font-size:.84rem;color:rgba(255,255,255,.78);line-height:1.5;}
.lj-al-perk-text strong{color:#fff;display:block;font-size:.875rem;margin-bottom:1px;}
.lj-al-bottom{margin-top:44px;padding-top:26px;border-top:1px solid rgba(255,255,255,.14);display:flex;gap:32px;}
.lj-al-stat-val{font-size:1.3rem;font-weight:800;color:#fff;line-height:1;}
.lj-al-stat-lbl{font-size:.7rem;color:rgba(255,255,255,.55);margin-top:3px;}

/* ── RIGHT PANEL ──────────────────────────────────── */
.lj-auth-right{background:#fff;display:flex;align-items:center;justify-content:center;padding:52px 40px;}
.lj-auth-form-box{width:100%;max-width:420px;}
.lj-auth-logo{font-size:1.45rem;font-weight:800;color:var(--blue);letter-spacing:-1px;margin-bottom:4px;display:flex;align-items:center;gap:9px;}
.lj-auth-logo-ico{width:36px;height:36px;border-radius:var(--r-sm);background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:.88rem;}
.lj-auth-heading{font-size:1.5rem;font-weight:800;color:var(--n900);letter-spacing:-.4px;margin-bottom:6px;margin-top:22px;}
.lj-auth-sub{font-size:.875rem;color:var(--n500);margin-bottom:28px;line-height:1.6;}

/* ── FORM ELEMENTS ────────────────────────────────── */
.lj-fgroup{margin-bottom:16px;}
.lj-label{display:block;font-size:.8125rem;font-weight:600;color:var(--n700);margin-bottom:6px;}
.lj-label .req{color:#e53e3e;margin-left:2px;}
.lj-iw{position:relative;}
.lj-iw-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;pointer-events:none;z-index:1;}
.lj-iw-ico-r{position:absolute;right:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;cursor:pointer;z-index:1;background:none;border:none;padding:0;transition:color var(--t);}
.lj-iw-ico-r:hover{color:var(--n700);}
.lj-input{width:100%;border:1.5px solid var(--n200);border-radius:var(--r);padding:11px 14px 11px 38px;font-family:var(--f);font-size:.9rem;color:var(--n900);background:#fff;outline:none;transition:border-color var(--t),box-shadow var(--t);}
.lj-input.pr{padding-right:40px;}
.lj-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
.lj-input::placeholder{color:var(--n400);}
.lj-row-check{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
.lj-check{display:flex;align-items:center;gap:8px;font-size:.85rem;color:var(--n600);cursor:pointer;}
.lj-check input{width:15px;height:15px;accent-color:var(--blue);}
.lj-forgot{font-size:.85rem;font-weight:600;color:var(--blue);text-decoration:none;}
.lj-forgot:hover{text-decoration:underline;}
.lj-submit{width:100%;background:var(--blue);color:#fff;border:none;border-radius:var(--r);font-family:var(--f);font-size:.9375rem;font-weight:700;padding:13px 20px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:background var(--t),transform var(--t),box-shadow var(--t);margin-bottom:20px;}
.lj-submit:hover{background:var(--blue-h);transform:translateY(-1px);box-shadow:0 4px 16px rgba(26,86,219,.28);}
.lj-auth-switch{text-align:center;font-size:.875rem;color:var(--n500);}
.lj-auth-switch a{color:var(--blue);font-weight:600;text-decoration:none;}
.lj-auth-switch a:hover{text-decoration:underline;}
.lj-or{display:flex;align-items:center;gap:12px;margin:18px 0;color:var(--n400);font-size:.78rem;}
.lj-or::before,.lj-or::after{content:'';flex:1;height:1px;background:var(--n100);}
.lj-alert-err{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:12px 14px;margin-bottom:18px;display:flex;align-items:flex-start;gap:10px;font-size:.84rem;color:#b91c1c;}
.lj-alert-err i{color:#ef4444;flex-shrink:0;margin-top:1px;}
.lj-alert-success{background:#f0fdf4;border:1.5px solid #86efac;border-radius:var(--r);padding:12px 14px;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:.84rem;color:#166534;}

@media(max-width:900px){
  .lj-auth-split{grid-template-columns:1fr;}
  .lj-auth-left{display:none;}
  .lj-auth-right{padding:40px 24px;}
}
</style>
@endpush

@section('content')
<div class="lj-auth-page">
  <div class="lj-auth-split">

    {{-- ── LEFT PANEL ── --}}
    <div class="lj-auth-left">
      <div class="lj-al-dots">@for($i=0;$i<30;$i++)<span></span>@endfor</div>
      <div class="lj-al-badge"><i class="fa-solid fa-user-tie"></i> Job Seeker Portal</div>
      <div class="lj-al-title">Find Your Next Job in Tamil Nadu</div>
      <div class="lj-al-sub">Connect with thousands of verified MSME employers and take the next step in your career — completely free.</div>
      <div class="lj-al-perks">
        <div class="lj-al-perk">
          <div class="lj-al-perk-ico"><i class="fa-solid fa-briefcase"></i></div>
          <div class="lj-al-perk-text"><strong>10,000+ Job Listings</strong>Browse opportunities across all industries and districts in Tamil Nadu.</div>
        </div>
        <div class="lj-al-perk">
          <div class="lj-al-perk-ico"><i class="fa-solid fa-shield-halved"></i></div>
          <div class="lj-al-perk-text"><strong>Verified Employers</strong>All employers are verified with GST and PAN for your safety.</div>
        </div>
        <div class="lj-al-perk">
          <div class="lj-al-perk-ico"><i class="fa-solid fa-indian-rupee-sign"></i></div>
          <div class="lj-al-perk-text"><strong>100% Free for Job Seekers</strong>No fees, no subscriptions. Apply to unlimited jobs for free.</div>
        </div>
        <div class="lj-al-perk">
          <div class="lj-al-perk-ico"><i class="fa-solid fa-bell"></i></div>
          <div class="lj-al-perk-text"><strong>Instant Job Alerts</strong>Get notified when jobs matching your skills are posted.</div>
        </div>
      </div>
      <div class="lj-al-bottom">
        <div><div class="lj-al-stat-val">50,000+</div><div class="lj-al-stat-lbl">Job Seekers</div></div>
        <div><div class="lj-al-stat-val">1,200+</div><div class="lj-al-stat-lbl">Employers</div></div>
        <div><div class="lj-al-stat-val">100%</div><div class="lj-al-stat-lbl">Free</div></div>
      </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="lj-auth-right">
      <div class="lj-auth-form-box">

        <div class="lj-auth-logo">
          <div class="lj-auth-logo-ico"><i class="fa-solid fa-user-tie"></i></div>
          LinearJobs
        </div>
        <div class="lj-auth-heading">Job Seeker Login</div>
        <div class="lj-auth-sub">Welcome back! Sign in to find your next opportunity.</div>

        @if ($errors->any())
          <div class="lj-alert-err">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
              @foreach ($errors->all() as $e)
                <div>{{ $e }}</div>
              @endforeach
            </div>
          </div>
        @endif

        @if (session('status'))
          <div class="lj-alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('jobseeker.login.submit') }}">
          @csrf

          <div class="lj-fgroup">
            <label class="lj-label" for="email">Email Address <span class="req">*</span></label>
            <div class="lj-iw">
              <i class="fa-solid fa-envelope lj-iw-ico"></i>
              <input type="email" id="email" name="email"
                class="lj-input @error('email') is-invalid @enderror"
                placeholder="you@example.com"
                value="{{ old('email') }}"
                required autocomplete="email" />
            </div>
          </div>

          <div class="lj-fgroup">
            <label class="lj-label" for="password">Password <span class="req">*</span></label>
            <div class="lj-iw">
              <i class="fa-solid fa-lock lj-iw-ico"></i>
              <input type="password" id="password" name="password"
                class="lj-input pr @error('password') is-invalid @enderror"
                placeholder="Enter your password"
                required autocomplete="current-password" />
              <button type="button" class="lj-iw-ico-r" onclick="togglePwd('password',this)" tabindex="-1">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="lj-row-check">
            <label class="lj-check">
              <input type="checkbox" name="remember"> Remember me for 30 days
            </label>
            <a href="{{ route('forgot.password') }}" class="lj-forgot">
              <i class="fa-solid fa-key" style="font-size:.72rem;margin-right:3px;"></i> Forgot Password?
            </a>
          </div>

          <button type="submit" class="lj-submit">
            <i class="fa-solid fa-right-to-bracket"></i> Sign In
          </button>
        </form>

        <div class="lj-or">or</div>

        <div class="lj-auth-switch">
          New to LinearJobs? <a href="{{ route('jobseeker.register') }}">Register Free</a>
        </div>
        <div class="lj-auth-switch" style="margin-top:10px;">
          Are you an employer? <a href="{{ route('employer.login') }}">Employer Login</a>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function togglePwd(id,btn){
  const inp=document.getElementById(id);
  const ico=btn.querySelector('i');
  if(inp.type==='password'){inp.type='text';ico.className='fa-solid fa-eye-slash';}
  else{inp.type='password';ico.className='fa-solid fa-eye';}
}
</script>
@endpush