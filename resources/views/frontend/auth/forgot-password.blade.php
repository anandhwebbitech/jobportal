{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/auth/forgot-password.blade.php
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Forgot Password – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.lj-auth-page{min-height:calc(100vh - 64px);background:var(--n50);display:flex;align-items:center;justify-content:center;padding:40px 20px;}
.lj-fp-card{background:#fff;border:1.5px solid var(--n200);border-radius:var(--r-lg);box-shadow:var(--sh-lg);width:100%;max-width:480px;padding:44px 40px;}
.lj-fp-icon{width:64px;height:64px;border-radius:50%;background:var(--blue-lt);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin:0 auto 20px;}
.lj-fp-title{font-size:1.45rem;font-weight:800;color:var(--n900);letter-spacing:-.4px;margin-bottom:8px;text-align:center;}
.lj-fp-sub{font-size:.875rem;color:var(--n500);line-height:1.7;margin-bottom:28px;text-align:center;}
.lj-fgroup{margin-bottom:18px;}
.lj-label{display:block;font-size:.8125rem;font-weight:600;color:var(--n700);margin-bottom:6px;}
.lj-label .req{color:#e53e3e;margin-left:2px;}
.lj-iw{position:relative;}
.lj-iw-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--n400);font-size:.82rem;pointer-events:none;}
.lj-input{width:100%;border:1.5px solid var(--n200);border-radius:var(--r);padding:11px 14px 11px 38px;font-family:var(--f);font-size:.9rem;color:var(--n900);background:#fff;outline:none;transition:border-color var(--t),box-shadow var(--t);}
.lj-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
.lj-input::placeholder{color:var(--n400);}
.lj-submit{width:100%;background:var(--blue);color:#fff;border:none;border-radius:var(--r);font-family:var(--f);font-size:.9375rem;font-weight:700;padding:13px 20px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:background var(--t),transform var(--t),box-shadow var(--t);margin-bottom:18px;}
.lj-submit:hover{background:var(--blue-h);transform:translateY(-1px);box-shadow:0 4px 16px rgba(26,86,219,.28);}
.lj-back-link{display:flex;align-items:center;justify-content:center;gap:8px;font-size:.875rem;color:var(--n500);text-decoration:none;font-weight:500;transition:color var(--t);}
.lj-back-link:hover{color:var(--blue);}
.lj-back-link i{font-size:.78rem;}
.lj-alert-success{background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:var(--r);padding:14px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;font-size:.875rem;color:#166534;}
.lj-alert-success i{color:#22c55e;flex-shrink:0;margin-top:1px;font-size:1rem;}
.lj-alert-err{background:#fef2f2;border:1.5px solid #fecaca;border-radius:var(--r);padding:12px 14px;margin-bottom:18px;display:flex;align-items:flex-start;gap:10px;font-size:.84rem;color:#b91c1c;}
.lj-alert-err i{color:#ef4444;flex-shrink:0;margin-top:1px;}
.lj-fp-divider{height:1px;background:var(--n100);margin:20px 0;}
.lj-fp-types{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:24px;}
.lj-fp-type{border:1.5px solid var(--n200);border-radius:var(--r);padding:12px 14px;cursor:pointer;transition:all var(--t);display:flex;align-items:center;gap:10px;}
.lj-fp-type:hover{border-color:var(--blue);}
.lj-fp-type.active{border-color:var(--blue);background:var(--blue-lt);}
.lj-fp-type input[type="radio"]{display:none;}
.lj-fp-type-ico{width:34px;height:34px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0;}
.lj-fp-type-ico.blue{background:var(--blue-lt);color:var(--blue);}
.lj-fp-type-ico.green{background:var(--green-lt);color:var(--green);}
.lj-fp-type-lbl{font-size:.84rem;font-weight:600;color:var(--n700);}
.lj-fp-type-sub{font-size:.72rem;color:var(--n400);}
.lj-fp-type.active .lj-fp-type-lbl{color:var(--blue);}
@media(max-width:520px){.lj-fp-card{padding:32px 24px;}.lj-fp-types{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')
<div class="lj-auth-page">
  <div class="lj-fp-card">

    <div class="lj-fp-icon"><i class="fa-solid fa-key"></i></div>
    <div class="lj-fp-title">Forgot your password?</div>
    <div class="lj-fp-sub">No worries! Enter your registered email address and we'll send you a secure link to reset your password.</div>

    @if (session('status'))
      <div class="lj-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <div><strong>Email sent!</strong> We've emailed a password reset link. Please check your inbox and spam folder.</div>
      </div>
    @endif

    @if ($errors->any())
      <div class="lj-alert-err"><i class="fa-solid fa-circle-exclamation"></i><div>{{ $errors->first() }}</div></div>
    @endif

    {{-- Account type selector --}}
    <div class="lj-fp-types" id="fpTypeWrap">
      <label class="lj-fp-type active" id="typeJobseeker">
        <input type="radio" name="account_type_ui" value="jobseeker" checked>
        <div class="lj-fp-type-ico blue"><i class="fa-solid fa-user-tie"></i></div>
        <div>
          <div class="lj-fp-type-lbl">Job Seeker</div>
          <div class="lj-fp-type-sub">Personal account</div>
        </div>
      </label>
      <label class="lj-fp-type" id="typeEmployer">
        <input type="radio" name="account_type_ui" value="employer">
        <div class="lj-fp-type-ico green"><i class="fa-solid fa-building"></i></div>
        <div>
          <div class="lj-fp-type-lbl">Employer</div>
          <div class="lj-fp-type-sub">Company account</div>
        </div>
      </label>
    </div>

    <form method="POST" action="{{ route('forgot.password.submit') }}">
      @csrf
      <input type="hidden" name="account_type" id="accountTypeHidden" value="jobseeker">

      <div class="lj-fgroup">
        <label class="lj-label" for="email">Email Address <span class="req">*</span></label>
        <div class="lj-iw">
          <i class="fa-solid fa-envelope lj-iw-ico"></i>
          <input type="email" id="email" name="email" class="lj-input @error('email') is-invalid @enderror" placeholder="Enter your registered email" value="{{ old('email') }}" required autocomplete="email" />
        </div>
      </div>

      <button type="submit" class="lj-submit">
        <i class="fa-solid fa-paper-plane"></i> Send Reset Link
      </button>
    </form>

    <div class="lj-fp-divider"></div>

    <a href="{{ route('jobseeker.login') }}" class="lj-back-link">
      <i class="fa-solid fa-arrow-left"></i> Back to Login
    </a>

  </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.lj-fp-type').forEach(function(el){
  el.addEventListener('click', function(){
    document.querySelectorAll('.lj-fp-type').forEach(function(e){ e.classList.remove('active'); });
    el.classList.add('active');
    document.getElementById('accountTypeHidden').value = el.querySelector('input').value;
  });
});
</script>
@endpush