{{-- ═══════════════════════════════════════════════════
resources/views/frontend/auth/employer-login.blade.php
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Employer Login – LinearJobs')

@push('styles')
  <style>
    /* ═══════════════════════════════════════════════════
     VARIABLES
  ═══════════════════════════════════════════════════ */
    :root {
      --blue: #1a56db;
      --green: #059669;
      --green-d: #065f46;
      --green-lt: rgba(5, 150, 105, .08);
      --green-glow: rgba(5, 150, 105, .22);

      /* neutrals */
      --n50: #f8f9fb;
      --n100: #f1f2f6;
      --n200: #e4e7ef;
      --n300: #c8cdd9;
      --n400: #9298ab;
      --n500: #6b7280;
      --n600: #4b5160;
      --n700: #374151;
      --n800: #1f2937;
      --n900: #111827;

      --r: 12px;
      --r-sm: 8px;
      --r-lg: 20px;
      --t: .2s ease;
      --fh: 'Outfit', sans-serif;
      --fb: 'DM Sans', sans-serif;
      --sh: 0 2px 8px rgba(0, 0, 0, .06);
      --sh-md: 0 8px 32px rgba(0, 0, 0, .09), 0 2px 8px rgba(0, 0, 0, .04);
      --sh-lg: 0 20px 60px rgba(0, 0, 0, .13);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--fb);
      background: var(--n50);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: var(--n900);
      overflow-x: hidden;
    }

    /* ═══════════════════════════════════════════════════
     BACKGROUND DECORATION
  ═══════════════════════════════════════════════════ */
    .bg-blob {
      position: fixed;
      pointer-events: none;
      z-index: 0;
      border-radius: 50%;
      filter: blur(80px);
    }

    .bg-blob-1 {
      width: 600px;
      height: 600px;
      top: -180px;
      right: -120px;
      background: radial-gradient(circle, rgba(5, 150, 105, .05) 0%, transparent 70%);
    }

    .bg-blob-2 {
      width: 500px;
      height: 500px;
      bottom: -140px;
      left: -100px;
      background: radial-gradient(circle, rgba(5, 150, 105, .08) 0%, transparent 70%);
    }

    /* ═══════════════════════════════════════════════════
     NAVBAR
  ═══════════════════════════════════════════════════ */
    .navbar {
      position: relative;
      z-index: 10;
      background: rgba(255, 255, 255, .82);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom: 1.5px solid rgba(228, 231, 239, .8);
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 36px;
    }

    .logo {
      font-family: var(--fh);
      font-size: 1.45rem;
      font-weight: 800;
      letter-spacing: -.6px;
      color: var(--green);
      text-decoration: none;
      cursor: pointer;
    }

    .logo span {
      color: var(--n900);
    }

    /* ═══════════════════════════════════════════════════
     PAGE WRAPPER
  ═══════════════════════════════════════════════════ */
    .page-wrap {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px 60px;
      position: relative;
      z-index: 1;
    }

    /* ═══════════════════════════════════════════════════
     SPLIT LAYOUT
  ═══════════════════════════════════════════════════ */
    .split {
      display: grid;
      grid-template-columns: 400px 1fr;
      max-width: 1000px; /* Made slightly smaller since no type-selector */
      width: 100%;
      background: #fff;
      border-radius: 24px;
      box-shadow: var(--sh-lg);
      overflow: hidden;
      border: 1.5px solid var(--n200);
      animation: riseUp .45s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes riseUp {
      from { opacity: 0; transform: translateY(28px) scale(.98); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ─── LEFT PANEL ─────────────────────── */
    .left-panel {
      position: relative;
      overflow: hidden;
      padding: 52px 40px 48px;
      display: flex;
      flex-direction: column;
      background: linear-gradient(150deg, #059669 0%, #065f46 100%);
    }

    .lp-orb {
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
      background: rgba(255, 255, 255, .07);
    }

    .lp-orb-1 { width: 320px; height: 320px; top: -100px; right: -80px; }
    .lp-orb-2 { width: 220px; height: 220px; bottom: -70px; left: -50px; }

    .lp-dots {
      position: absolute;
      top: 36px;
      left: 36px;
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      opacity: .1;
      pointer-events: none;
    }

    .lp-dots span {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: #fff;
      display: block;
    }

    .lp-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .22);
      border-radius: 100px;
      padding: 5px 14px;
      font-size: .72rem;
      font-weight: 700;
      color: rgba(255, 255, 255, .9);
      letter-spacing: .06em;
      text-transform: uppercase;
      margin-bottom: 20px;
      width: fit-content;
    }

    .lp-title {
      font-family: var(--fh);
      font-size: clamp(1.3rem, 2.2vw, 1.75rem);
      font-weight: 800;
      color: #fff;
      line-height: 1.25;
      letter-spacing: -.03em;
      margin-bottom: 10px;
    }

    .lp-sub {
      font-size: .84rem;
      color: rgba(255, 255, 255, .68);
      line-height: 1.7;
      margin-bottom: 32px;
    }

    .lp-perks {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .lp-perk {
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .lp-perk-ico {
      width: 34px;
      height: 34px;
      flex-shrink: 0;
      border-radius: var(--r-sm);
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .78rem;
      color: #fff;
    }

    .lp-perk-text {
      font-size: .82rem;
      color: rgba(255, 255, 255, .76);
      line-height: 1.55;
    }

    .lp-perk-text strong {
      color: #fff;
      display: block;
      font-size: .84rem;
      margin-bottom: 2px;
    }

    .lp-stats {
      margin-top: auto;
      padding-top: 28px;
      border-top: 1px solid rgba(255, 255, 255, .14);
      display: flex;
      gap: 26px;
    }

    .lp-stat-val {
      font-family: var(--fh);
      font-size: 1.25rem;
      font-weight: 800;
      color: #fff;
      line-height: 1;
    }

    .lp-stat-lbl {
      font-size: .68rem;
      color: rgba(255, 255, 255, .5);
      margin-top: 3px;
    }

    /* ─── RIGHT PANEL ────────────────────── */
    .right-panel {
      padding: 52px 44px 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .rp-logo {
      display: flex;
      align-items: center;
      gap: 9px;
      font-family: var(--fh);
      font-size: 1.3rem;
      font-weight: 800;
      letter-spacing: -.5px;
      margin-bottom: 4px;
      color: var(--green);
    }

    .rp-logo-ico {
      width: 34px;
      height: 34px;
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .82rem;
      background: var(--green-lt);
      color: var(--green);
    }

    .rp-heading {
      font-family: var(--fh);
      font-size: 1.55rem;
      font-weight: 800;
      color: var(--n900);
      letter-spacing: -.04em;
      margin-top: 20px;
      margin-bottom: 5px;
    }

    .rp-sub {
      font-size: .875rem;
      color: var(--n500);
      line-height: 1.6;
      margin-bottom: 32px; /* Increased margin since type-selector is removed */
    }

    /* ─── FORM FIELDS ────────────────────── */
    .fgroup { margin-bottom: 15px; }

    .flabel {
      display: block;
      font-size: .8rem;
      font-weight: 600;
      color: var(--n700);
      margin-bottom: 5px;
    }

    .flabel .req { color: #e53e3e; margin-left: 2px; }
    .fiw { position: relative; }

    .fiw-ico {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--n400);
      font-size: .8rem;
      pointer-events: none;
    }

    .fiw-btn-r {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--n400);
      font-size: .8rem;
      background: none;
      border: none;
      cursor: pointer;
      padding: 2px;
      transition: color var(--t);
    }

    .fiw-btn-r:hover { color: var(--n700); }

    .finput {
      width: 100%;
      border: 1.5px solid var(--n200);
      border-radius: var(--r);
      padding: 11px 14px 11px 38px;
      font-family: var(--fb);
      font-size: .88rem;
      color: var(--n900);
      background: #fff;
      outline: none;
      transition: border-color var(--t), box-shadow var(--t);
    }

    .finput.has-right { padding-right: 40px; }
    .finput::placeholder { color: var(--n400); }

    .finput:focus {
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(5, 150, 105, .1);
    }

    /* ─── ROW CHECK ──────────────────────── */
    .row-check {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 18px;
    }

    .fcheck {
      display: flex;
      align-items: center;
      gap: 7px;
      font-size: .83rem;
      color: var(--n600);
      cursor: pointer;
    }

    .fcheck input {
      width: 14px;
      height: 14px;
      accent-color: var(--green);
    }

    .fforgot {
      font-size: .83rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: opacity .15s ease;
      color: var(--green);
    }

    .fforgot:hover { text-decoration: underline; opacity: .85; }

    /* ─── SUBMIT ─────────────────────────── */
    .fsubmit {
      width: 100%;
      border: none;
      border-radius: var(--r);
      font-family: var(--fh);
      font-size: .95rem;
      font-weight: 700;
      padding: 13px 20px;
      cursor: pointer;
      color: #fff;
      letter-spacing: -.01em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      transition: all .2s ease;
      margin-bottom: 18px;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #059669, #10b981);
      box-shadow: 0 4px 16px rgba(5, 150, 105, .28);
    }

    .fsubmit::after {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(255, 255, 255, .12);
      opacity: 0;
      transition: opacity .15s ease;
    }

    .fsubmit:hover::after { opacity: 1; }
    .fsubmit:hover { transform: translateY(-1px); box-shadow: 0 6px 22px rgba(5, 150, 105, .38); }
    .fsubmit:active { transform: translateY(0); }
    .fsubmit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

    /* ─── OR DIVIDER ─────────────────────── */
    .for {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 4px 0 14px;
      color: var(--n400);
      font-size: .76rem;
    }

    .for::before,
    .for::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--n100);
    }

    /* ─── AUTH SWITCH ────────────────────── */
    .auth-switch {
      text-align: center;
      font-size: .85rem;
      color: var(--n500);
      line-height: 2;
    }

    .auth-switch a {
      font-weight: 600;
      text-decoration: none;
      transition: opacity .15s ease;
    }

    .auth-switch a:hover { text-decoration: underline; opacity: .85; }
    .auth-switch a.green { color: var(--green); }
    .auth-switch a.blue { color: var(--blue); }

    .switch-divider {
      height: 1px;
      background: var(--n100);
      margin: 10px 0;
    }

    /* ─── TRUST STRIP ────────────────────── */
    .trust-strip {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-top: 36px;
      padding-top: 22px;
      border-top: 1px solid var(--n100);
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: .75rem;
      color: var(--n400);
      font-weight: 500;
    }

    .trust-item i { font-size: .73rem; color: var(--green); }

    .fade-in { animation: fadeIn .3s ease both; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ═══════════════════════════════════════════════════
     RESPONSIVE
  ═══════════════════════════════════════════════════ */
    @media(max-width:860px) {
      .split { grid-template-columns: 1fr; max-width: 480px; }
      .left-panel { display: none; }
      .right-panel { padding: 40px 28px; }
    }

    @media(max-width:500px) {
      .right-panel { padding: 32px 20px; }
      .navbar { padding: 0 16px; }
    }
  </style>
@endpush

@section('content')
  <!-- BG BLOBS -->
  <div class="bg-blob bg-blob-1"></div>
  <div class="bg-blob bg-blob-2"></div>

  <!-- MAIN -->
  <div class="page-wrap">
    <div class="split">

      <!-- ════ LEFT PANEL ════ -->
      <div class="left-panel">
        <div class="lp-orb lp-orb-1"></div>
        <div class="lp-orb lp-orb-2"></div>
        <div class="lp-dots" id="lpDots"></div>

        <div class="fade-in">
          <div class="lp-badge"><i class="fa-solid fa-building"></i> Employer Portal</div>
          <div class="lp-title">Find the Right Talent for Your Business</div>
          <div class="lp-sub">Post jobs and connect with thousands of skilled professionals across Tamil Nadu — starting at just ₹600.</div>
          
          <div class="lp-perks">
            <div class="lp-perk">
              <div class="lp-perk-ico"><i class="fa-solid fa-users"></i></div>
              <div class="lp-perk-text"><strong>Large Talent Pool</strong>Access 50,000+ registered job seekers across all skills.</div>
            </div>
            <div class="lp-perk">
              <div class="lp-perk-ico"><i class="fa-solid fa-tag"></i></div>
              <div class="lp-perk-text"><strong>Affordable Plans</strong>Post jobs from ₹600. Plans designed for MSMEs.</div>
            </div>
            <div class="lp-perk">
              <div class="lp-perk-ico"><i class="fa-solid fa-map-location-dot"></i></div>
              <div class="lp-perk-text"><strong>Local Hiring Focus</strong>Reach candidates in all 32 districts of Tamil Nadu.</div>
            </div>
            <div class="lp-perk">
              <div class="lp-perk-ico"><i class="fa-solid fa-chart-line"></i></div>
              <div class="lp-perk-text"><strong>Easy Dashboard</strong>Manage all applications from one simple dashboard.</div>
            </div>
          </div>

          <div class="lp-stats">
            <div>
              <div class="lp-stat-val">1,200+</div>
              <div class="lp-stat-lbl">Employers</div>
            </div>
            <div>
              <div class="lp-stat-val">₹600</div>
              <div class="lp-stat-lbl">Starting Plan</div>
            </div>
            <div>
              <div class="lp-stat-val">48hr</div>
              <div class="lp-stat-lbl">Avg. Response</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ════ RIGHT PANEL ════ -->
      <div class="right-panel">

        <!-- Logo -->
        <div class="rp-logo">
          <div class="rp-logo-ico"><i class="fa-solid fa-building"></i></div>
          LinearJobs
        </div>

        <div class="rp-heading">Employer Login</div>
        <div class="rp-sub">Access your employer dashboard to manage postings.</div>

        <!-- FORM -->
        <form id="loginForm" onsubmit="handleSubmit(); return false;">
          @csrf
          <div class="fgroup">
            <label class="flabel" for="f_email">Email Address <span class="req">*</span></label>
            <div class="fiw">
              <i class="fa-solid fa-envelope fiw-ico"></i>
              <input type="email" id="f_email" name="email" class="finput"
                placeholder="company@example.com" required autocomplete="email" />
            </div> 
          </div>

          <div class="fgroup">
            <label class="flabel" for="f_password">Password <span class="req">*</span></label>
            <div class="fiw">
              <i class="fa-solid fa-lock fiw-ico"></i>
              <input type="password" id="f_password" name="password" class="finput has-right"
                placeholder="Enter your password" required autocomplete="current-password" />
              <button type="button" class="fiw-btn-r" onclick="togglePwd()" tabindex="-1">
                <i class="fa-solid fa-eye" id="pwdEyeIco"></i>
              </button>
            </div>
          </div>

          <div class="row-check">
            <label class="fcheck">
              <input type="checkbox" name="remember"> Remember me
            </label>
            <a href="/forgot-password" class="fforgot">
              <i class="fa-solid fa-key" style="font-size:.65rem;"></i> Forgot Password?
            </a>
          </div>

          <button type="submit" class="fsubmit" id="submitBtn">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span id="submitLabel">Login to Dashboard</span>
          </button>
        </form>

        <div class="for">or</div>

        <div class="auth-switch">
          New employer? <a href="{{ route('employer.register') ?? '/register/employer' }}" class="green">Register Your Company</a>
          <div class="switch-divider"></div>
          Looking for a job? <a href="{{ route('jobseeker.login') ?? '/login' }}" class="blue">Job Seeker Login</a>
        </div>

        <div class="trust-strip">
          <div class="trust-item"><i class="fa-solid fa-shield-halved"></i> Secure & Encrypted</div>
          <div class="trust-item"><i class="fa-solid fa-check-circle"></i> Verified Companies</div>
          <div class="trust-item"><i class="fa-solid fa-users"></i> 50,000+ Users</div>
        </div>

      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <!-- ════════════════════════════════════
       JAVASCRIPT
  ════════════════════════════════════ -->
  <script>
    /* ─── BUILD DOTS ─────────────────────── */
    const dotsEl = document.getElementById('lpDots');
    if (dotsEl) {
      for (let i = 0; i < 25; i++) {
        const s = document.createElement('span');
        dotsEl.appendChild(s);
      }
    }

    /* ─── TOGGLE PASSWORD ────────────────── */
    function togglePwd() {
      const inp = document.getElementById('f_password');
      const ico = document.getElementById('pwdEyeIco');
      if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fa-solid fa-eye-slash';
      } else {
        inp.type = 'password';
        ico.className = 'fa-solid fa-eye';
      }
    }

    /* ─── SUBMIT ─────────────────────────── */
    function handleSubmit() {
      const btn = document.getElementById('submitBtn');
      const label = document.getElementById('submitLabel');
      
      btn.disabled = true;
      label.textContent = 'Logging in…';
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Logging in…</span>';

      let email = $('#f_email').val();
      let password = $('#f_password').val();

      $.ajax({
          url: "{{ route('userlogin') }}", 
          type: "POST",
          data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              email: email,
              password: password
          },
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          success: function (res) {
              if (res.status) {
                  toastr.success(res.message);
                  window.location.href = res.redirect;
              } else {
                  toastr.error(res.message);
                  resetBtn();
              }
          },
          error: function (xhr) {
              let msg = 'Login failed';
              if (xhr.responseJSON && xhr.responseJSON.message) {
                  msg = xhr.responseJSON.message;
              }
              toastr.error(msg);
              resetBtn();
          }
      });
    }

    function resetBtn() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i> <span id="submitLabel">Login to Dashboard</span>';
    }
  </script>
@endpush