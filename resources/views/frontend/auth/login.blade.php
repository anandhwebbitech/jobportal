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
  --blue:       #1a56db;
  --blue-d:     #1e3a8a;
  --blue-lt:    rgba(26,86,219,.08);
  --blue-glow:  rgba(26,86,219,.22);
  --green:      #059669;
  --green-d:    #065f46;
  --green-lt:   rgba(5,150,105,.08);
  --green-glow: rgba(5,150,105,.22);

  /* neutrals */
  --n50:  #f8f9fb;
  --n100: #f1f2f6;
  --n200: #e4e7ef;
  --n300: #c8cdd9;
  --n400: #9298ab;
  --n500: #6b7280;
  --n600: #4b5160;
  --n700: #374151;
  --n800: #1f2937;
  --n900: #111827;

  --r:    12px;
  --r-sm: 8px;
  --r-lg: 20px;
  --t:    .2s ease;
  --fh:   'Outfit', sans-serif;
  --fb:   'DM Sans', sans-serif;
  --sh:   0 2px 8px rgba(0,0,0,.06);
  --sh-md:0 8px 32px rgba(0,0,0,.09), 0 2px 8px rgba(0,0,0,.04);
  --sh-lg:0 20px 60px rgba(0,0,0,.13);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
  position: fixed; pointer-events: none; z-index: 0;
  border-radius: 50%;
  filter: blur(80px);
}
.bg-blob-1 {
  width: 600px; height: 600px;
  top: -180px; right: -120px;
  background: radial-gradient(circle, rgba(26,86,219,.07) 0%, transparent 70%);
}
.bg-blob-2 {
  width: 500px; height: 500px;
  bottom: -140px; left: -100px;
  background: radial-gradient(circle, rgba(5,150,105,.06) 0%, transparent 70%);
}

/* ═══════════════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════════════ */
.navbar {
  position: relative; z-index: 10;
  background: rgba(255,255,255,.82);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-bottom: 1.5px solid rgba(228,231,239,.8);
  height: 64px;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 36px;
}
.logo {
  font-family: var(--fh);
  font-size: 1.45rem; font-weight: 800;
  letter-spacing: -.6px;
  color: var(--blue);
  text-decoration: none; cursor: pointer;
}
.logo span { color: var(--n900); }
.nav-link {
  font-size: .875rem; font-weight: 500;
  color: var(--n500); text-decoration: none;
  transition: color var(--t);
}
.nav-link:hover { color: var(--blue); }

/* ═══════════════════════════════════════════════════
   PAGE WRAPPER
═══════════════════════════════════════════════════ */
.page-wrap {
  flex: 1;
  display: flex; align-items: center; justify-content: center;
  padding: 40px 20px 60px;
  position: relative; z-index: 1;
}

/* ═══════════════════════════════════════════════════
   SPLIT LAYOUT
═══════════════════════════════════════════════════ */
.split {
  display: grid;
  grid-template-columns: 400px 1fr;
  max-width: 900px; width: 100%;
  background: #fff;
  border-radius: 24px;
  box-shadow: var(--sh-lg);
  overflow: hidden;
  border: 1.5px solid var(--n200);
  animation: riseUp .45s cubic-bezier(.22,1,.36,1) both;
}

@keyframes riseUp {
  from { opacity:0; transform:translateY(28px) scale(.98); }
  to   { opacity:1; transform:translateY(0) scale(1); }
}

/* ─── LEFT PANEL ─────────────────────── */
.left-panel {
  position: relative; overflow: hidden;
  padding: 52px 40px 48px;
  display: flex; flex-direction: column;
  transition: background .4s ease;
}
.left-panel.blue  { background: linear-gradient(150deg, #1a56db 0%, #1e3a8a 100%); }
.left-panel.green { background: linear-gradient(150deg, #059669 0%, #065f46 100%); }

/* orbs */
.lp-orb {
  position: absolute; border-radius: 50%; pointer-events: none;
  background: rgba(255,255,255,.07);
}
.lp-orb-1 { width: 320px; height: 320px; top: -100px; right: -80px; }
.lp-orb-2 { width: 220px; height: 220px; bottom: -70px; left: -50px; }

/* grid dots */
.lp-dots {
  position: absolute; top: 36px; left: 36px;
  display: grid; grid-template-columns: repeat(5,1fr); gap: 10px;
  opacity: .1; pointer-events: none;
}
.lp-dots span { width: 5px; height: 5px; border-radius: 50%; background: #fff; display: block; }

.lp-back {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.22);
  border-radius: 100px; padding: 6px 14px;
  font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.85);
  text-decoration: none; cursor: pointer; margin-bottom: 28px;
  width: fit-content; transition: background .2s ease;
}
.lp-back:hover { background: rgba(255,255,255,.22); }

.lp-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.22);
  border-radius: 100px; padding: 5px 14px;
  font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.9);
  letter-spacing: .06em; text-transform: uppercase;
  margin-bottom: 20px; width: fit-content;
}

.lp-title {
  font-family: var(--fh);
  font-size: clamp(1.3rem, 2.2vw, 1.75rem);
  font-weight: 800; color: #fff;
  line-height: 1.25; letter-spacing: -.03em;
  margin-bottom: 10px;
}
.lp-sub {
  font-size: .84rem; color: rgba(255,255,255,.68);
  line-height: 1.7; margin-bottom: 32px;
}

.lp-perks { display: flex; flex-direction: column; gap: 14px; }
.lp-perk  { display: flex; align-items: flex-start; gap: 12px; }
.lp-perk-ico {
  width: 34px; height: 34px; flex-shrink: 0;
  border-radius: var(--r-sm); background: rgba(255,255,255,.15);
  display: flex; align-items: center; justify-content: center;
  font-size: .78rem; color: #fff;
}
.lp-perk-text { font-size: .82rem; color: rgba(255,255,255,.76); line-height: 1.55; }
.lp-perk-text strong { color: #fff; display: block; font-size: .84rem; margin-bottom: 2px; }

.lp-stats {
  margin-top: auto; padding-top: 28px;
  border-top: 1px solid rgba(255,255,255,.14);
  display: flex; gap: 26px;
}
.lp-stat-val {
  font-family: var(--fh);
  font-size: 1.25rem; font-weight: 800; color: #fff; line-height: 1;
}
.lp-stat-lbl { font-size: .68rem; color: rgba(255,255,255,.5); margin-top: 3px; }

/* ─── RIGHT PANEL ────────────────────── */
.right-panel {
  padding: 52px 44px 48px;
  display: flex; flex-direction: column; justify-content: center;
}

.rp-logo {
  display: flex; align-items: center; gap: 9px;
  font-family: var(--fh); font-size: 1.3rem; font-weight: 800;
  letter-spacing: -.5px; margin-bottom: 4px;
  transition: color .3s ease;
}
.rp-logo-ico {
  width: 34px; height: 34px; border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; transition: background .3s ease, color .3s ease;
}
.rp-logo.blue-mode { color: var(--blue); }
.rp-logo.blue-mode .rp-logo-ico { background: var(--blue-lt); color: var(--blue); }
.rp-logo.green-mode { color: var(--green); }
.rp-logo.green-mode .rp-logo-ico { background: var(--green-lt); color: var(--green); }

.rp-heading {
  font-family: var(--fh); font-size: 1.55rem; font-weight: 800;
  color: var(--n900); letter-spacing: -.04em; margin-top: 20px; margin-bottom: 5px;
}
.rp-sub { font-size: .875rem; color: var(--n500); line-height: 1.6; margin-bottom: 24px; }

/* ─── TYPE SELECTOR ──────────────────── */
.type-selector {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 10px; margin-bottom: 22px;
}
.type-btn {
  display: flex; align-items: center; gap: 10px;
  padding: 11px 14px;
  border-radius: var(--r);
  border: 2px solid var(--n200);
  background: #fff;
  cursor: pointer;
  transition: all .22s cubic-bezier(.34,1.2,.64,1);
  position: relative; overflow: hidden;
  text-align: left;
}
.type-btn::before {
  content: '';
  position: absolute; inset: 0;
  opacity: 0; transition: opacity .22s ease;
  border-radius: calc(var(--r) - 2px);
}
.type-btn.js-btn::before  { background: linear-gradient(135deg, rgba(26,86,219,.05), rgba(30,58,138,.06)); }
.type-btn.emp-btn::before { background: linear-gradient(135deg, rgba(5,150,105,.05), rgba(6,95,70,.06)); }

.type-btn:hover { transform: translateY(-2px); box-shadow: var(--sh); }
.type-btn.js-btn:hover  { border-color: rgba(26,86,219,.3); }
.type-btn.emp-btn:hover { border-color: rgba(5,150,105,.3); }
.type-btn:hover::before { opacity: 1; }

/* active state */
.type-btn.active-js {
  border-color: var(--blue);
  background: var(--blue-lt);
  box-shadow: 0 0 0 3px rgba(26,86,219,.1);
  transform: translateY(-2px);
}
.type-btn.active-js::before { opacity: 1; }
.type-btn.active-green {
  border-color: var(--green);
  background: var(--green-lt);
  box-shadow: 0 0 0 3px rgba(5,150,105,.1);
  transform: translateY(-2px);
}
.type-btn.active-green::before { opacity: 1; }

.type-ico {
  width: 38px; height: 38px; flex-shrink: 0;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: .85rem;
  transition: background .22s ease, color .22s ease, transform .22s cubic-bezier(.34,1.4,.64,1);
}
.js-btn  .type-ico { background: #e0e7ff; color: #3730a3; }
.emp-btn .type-ico { background: #d1fae5; color: #065f46; }

.type-btn.active-js   .type-ico { background: var(--blue); color: #fff; transform: scale(1.08) rotate(-4deg); }
.type-btn.active-green .type-ico { background: var(--green); color: #fff; transform: scale(1.08) rotate(-4deg); }

.type-info {}
.type-name {
  font-family: var(--fh); font-size: .9rem; font-weight: 700;
  color: var(--n800); line-height: 1.2;
}
.type-desc { font-size: .73rem; color: var(--n500); margin-top: 1px; }

.type-btn.active-js   .type-name { color: var(--blue); }
.type-btn.active-green .type-name { color: var(--green); }

.type-check {
  margin-left: auto; flex-shrink: 0;
  width: 18px; height: 18px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: .6rem; color: #fff;
  opacity: 0; transform: scale(0);
  transition: all .22s cubic-bezier(.34,1.4,.64,1);
}
.type-btn.active-js   .type-check { background: var(--blue);  opacity: 1; transform: scale(1); }
.type-btn.active-green .type-check { background: var(--green); opacity: 1; transform: scale(1); }

/* ─── FORM FIELDS ────────────────────── */
.fgroup { margin-bottom: 15px; }
.flabel {
  display: block; font-size: .8rem; font-weight: 600;
  color: var(--n700); margin-bottom: 5px;
}
.flabel .req { color: #e53e3e; margin-left: 2px; }
.fiw { position: relative; }
.fiw-ico {
  position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
  color: var(--n400); font-size: .8rem; pointer-events: none;
}
.fiw-btn-r {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  color: var(--n400); font-size: .8rem;
  background: none; border: none; cursor: pointer; padding: 2px;
  transition: color var(--t);
}
.fiw-btn-r:hover { color: var(--n700); }

.finput {
  width: 100%; border: 1.5px solid var(--n200); border-radius: var(--r);
  padding: 11px 14px 11px 38px;
  font-family: var(--fb); font-size: .88rem;
  color: var(--n900); background: #fff; outline: none;
  transition: border-color var(--t), box-shadow var(--t);
}
.finput.has-right { padding-right: 40px; }
.finput::placeholder { color: var(--n400); }

.finput.blue-focus:focus  { border-color: var(--blue);  box-shadow: 0 0 0 3px rgba(26,86,219,.1); }
.finput.green-focus:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(5,150,105,.1); }

/* ─── ROW CHECK ──────────────────────── */
.row-check {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 18px;
}
.fcheck {
  display: flex; align-items: center; gap: 7px;
  font-size: .83rem; color: var(--n600); cursor: pointer;
}
.fcheck input { width: 14px; height: 14px; }
.fcheck.blue  input { accent-color: var(--blue); }
.fcheck.green input { accent-color: var(--green); }
.fforgot {
  font-size: .83rem; font-weight: 600; text-decoration: none;
  display: inline-flex; align-items: center; gap: 4px;
  transition: opacity .15s ease;
}
.fforgot:hover { text-decoration: underline; opacity: .85; }
.fforgot.blue  { color: var(--blue); }
.fforgot.green { color: var(--green); }

/* ─── SUBMIT ─────────────────────────── */
.fsubmit {
  width: 100%; border: none; border-radius: var(--r);
  font-family: var(--fh); font-size: .95rem; font-weight: 700;
  padding: 13px 20px; cursor: pointer; color: #fff; letter-spacing: -.01em;
  display: flex; align-items: center; justify-content: center; gap: 9px;
  transition: all .2s ease; margin-bottom: 18px;
  position: relative; overflow: hidden;
}
.fsubmit::after {
  content: '';
  position: absolute; inset: 0;
  background: rgba(255,255,255,.12);
  opacity: 0; transition: opacity .15s ease;
}
.fsubmit:hover::after { opacity: 1; }
.fsubmit:hover { transform: translateY(-1px); }
.fsubmit:active { transform: translateY(0); }
.fsubmit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

.fsubmit.blue-btn {
  background: linear-gradient(135deg,#1a56db,#2563eb);
  box-shadow: 0 4px 16px rgba(26,86,219,.28);
}
.fsubmit.blue-btn:hover  { box-shadow: 0 6px 22px rgba(26,86,219,.38); }
.fsubmit.green-btn {
  background: linear-gradient(135deg,#059669,#10b981);
  box-shadow: 0 4px 16px rgba(5,150,105,.28);
}
.fsubmit.green-btn:hover { box-shadow: 0 6px 22px rgba(5,150,105,.38); }

/* ─── OR DIVIDER ─────────────────────── */
.for { display: flex; align-items: center; gap: 12px; margin: 4px 0 14px; color: var(--n400); font-size: .76rem; }
.for::before,.for::after { content: ''; flex: 1; height: 1px; background: var(--n100); }

/* ─── AUTH SWITCH ────────────────────── */
.auth-switch {
  text-align: center; font-size: .85rem; color: var(--n500); line-height: 2;
}
.auth-switch a { font-weight: 600; text-decoration: none; transition: opacity .15s ease; }
.auth-switch a:hover { text-decoration: underline; opacity: .85; }
.auth-switch a.blue  { color: var(--blue); }
.auth-switch a.green { color: var(--green); }

.switch-divider { height: 1px; background: var(--n100); margin: 10px 0; }

/* ─── ALERT ──────────────────────────── */
.alert-err {
  background: #fef2f2; border: 1.5px solid #fecaca;
  border-radius: var(--r); padding: 11px 13px; margin-bottom: 16px;
  display: flex; align-items: flex-start; gap: 9px;
  font-size: .82rem; color: #b91c1c;
}
.alert-err i { color: #ef4444; flex-shrink: 0; margin-top: 1px; }

/* ─── TRUST STRIP ────────────────────── */
.trust-strip {
  display: flex; align-items: center; justify-content: center;
  gap: 20px; flex-wrap: wrap;
  margin-top: 36px; padding-top: 22px;
  border-top: 1px solid var(--n100);
}
.trust-item {
  display: flex; align-items: center; gap: 6px;
  font-size: .75rem; color: var(--n400); font-weight: 500;
}
.trust-item i { font-size: .73rem; color: var(--green); }

/* ═══════════════════════════════════════════════════
   ANIMATIONS — panel content
═══════════════════════════════════════════════════ */
.fade-in { animation: fadeIn .3s ease both; }
@keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

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
  .type-selector { grid-template-columns: 1fr 1fr; gap: 8px; }
  .type-name { font-size: .82rem; }
  .type-desc { font-size: .7rem; }
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
    <div class="left-panel blue" id="leftPanel">
      <div class="lp-orb lp-orb-1"></div>
      <div class="lp-orb lp-orb-2"></div>
      <div class="lp-dots" id="lpDots"></div>

      <a class="lp-back" href="#" onclick="return false;" style="display:none" id="lpBack">
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>

      <!-- Job Seeker panel content -->
      <div id="lpJs" class="fade-in">
        <div class="lp-badge"><i class="fa-solid fa-user-tie"></i> Job Seeker Portal</div>
        <div class="lp-title">Find Your Next Job in Tamil Nadu</div>
        <div class="lp-sub">Connect with verified MSME employers and take the next step in your career — completely free.</div>
        <div class="lp-perks">
          <div class="lp-perk">
            <div class="lp-perk-ico"><i class="fa-solid fa-briefcase"></i></div>
            <div class="lp-perk-text"><strong>10,000+ Job Listings</strong>Browse opportunities across all industries and districts.</div>
          </div>
          <div class="lp-perk">
            <div class="lp-perk-ico"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="lp-perk-text"><strong>Verified Employers</strong>All companies are GST & PAN verified for your safety.</div>
          </div>
          <div class="lp-perk">
            <div class="lp-perk-ico"><i class="fa-solid fa-indian-rupee-sign"></i></div>
            <div class="lp-perk-text"><strong>100% Free for Job Seekers</strong>No fees, no subscriptions. Apply to unlimited jobs.</div>
          </div>
          <div class="lp-perk">
            <div class="lp-perk-ico"><i class="fa-solid fa-bell"></i></div>
            <div class="lp-perk-text"><strong>Instant Job Alerts</strong>Get notified the moment matching jobs are posted.</div>
          </div>
        </div>
        <div class="lp-stats">
          <div><div class="lp-stat-val">50,000+</div><div class="lp-stat-lbl">Job Seekers</div></div>
          <div><div class="lp-stat-val">1,200+</div><div class="lp-stat-lbl">Employers</div></div>
          <div><div class="lp-stat-val">100%</div><div class="lp-stat-lbl">Free</div></div>
        </div>
      </div>

      <!-- Employer panel content -->
      <div id="lpEmp" style="display:none" class="fade-in">
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
          <div><div class="lp-stat-val">1,200+</div><div class="lp-stat-lbl">Employers</div></div>
          <div><div class="lp-stat-val">₹600</div><div class="lp-stat-lbl">Starting Plan</div></div>
          <div><div class="lp-stat-val">48hr</div><div class="lp-stat-lbl">Avg. Response</div></div>
        </div>
      </div>
    </div>

    <!-- ════ RIGHT PANEL ════ -->
    <div class="right-panel">

      <!-- Logo -->
      <div class="rp-logo blue-mode" id="rpLogo">
        <div class="rp-logo-ico" id="rpLogoIco"><i class="fa-solid fa-user-tie"></i></div>
        LinearJobs
      </div>

      <div class="rp-heading" id="rpHeading">Welcome Back</div>
      <div class="rp-sub" id="rpSub">Select your account type and sign in to continue.</div>

      <!-- TYPE SELECTOR -->
      <div class="type-selector">
        <!-- Job Seeker -->
        <button class="type-btn js-btn active-js" id="btnJs" onclick="selectType('jobseeker')">
          <div class="type-ico"><i class="fa-solid fa-user-tie"></i></div>
          <div class="type-info">
            <div class="type-name">Job Seeker</div>
            <div class="type-desc">Personal account</div>
          </div>
          <div class="type-check"><i class="fa-solid fa-check"></i></div>
        </button>
        <!-- Employer -->
        <button class="type-btn emp-btn" id="btnEmp" onclick="selectType('employer')">
          <div class="type-ico"><i class="fa-solid fa-building-flag"></i></div>
          <div class="type-info">
            <div class="type-name">Employer</div>
            <div class="type-desc">Company account</div>
          </div>
          <div class="type-check"><i class="fa-solid fa-check"></i></div>
        </button>
      </div>

      <!-- FORM -->
      <form id="loginForm" onsubmit="handleSubmit(); return false;">

        <div class="fgroup">
          <label class="flabel" for="f_email">Email Address <span class="req">*</span></label>
          <div class="fiw">
            <i class="fa-solid fa-envelope fiw-ico"></i>
            <input type="email" id="f_email" name="email"
              class="finput blue-focus" id="emailInput"
              placeholder="you@example.com" required autocomplete="email" />
          </div>
        </div>

        <div class="fgroup">
          <label class="flabel" for="f_password">Password <span class="req">*</span></label>
          <div class="fiw">
            <i class="fa-solid fa-lock fiw-ico"></i>
            <input type="password" id="f_password" name="password"
              class="finput has-right blue-focus"
              placeholder="Enter your password" required autocomplete="current-password" />
            <button type="button" class="fiw-btn-r" onclick="togglePwd()" tabindex="-1">
              <i class="fa-solid fa-eye" id="pwdEyeIco"></i>
            </button>
          </div>
        </div>

        <div class="row-check">
          <label class="fcheck blue" id="checkLabel">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a href="/forgot-password" class="fforgot blue" id="forgotLink">
            <i class="fa-solid fa-key" style="font-size:.65rem;"></i> Forgot Password?
          </a>
        </div>

        <button type="submit" class="fsubmit blue-btn" id="submitBtn">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span id="submitLabel">Sign In as Job Seeker</span>
        </button>
      </form>

      <div class="for">or</div>

      <div class="auth-switch" id="switchBottom">
        New to LinearJobs? <a href="/register" class="blue" id="switchRegLink">Register Free</a>
        <div class="switch-divider"></div>
        Are you an employer? <a href="#" class="green" onclick="selectType('employer'); return false;" id="switchOtherLink">Employer Login</a>
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
let currentType = 'jobseeker';

/* ─── BUILD DOTS ─────────────────────── */
const dotsEl = document.getElementById('lpDots');
for (let i = 0; i < 25; i++) {
  const s = document.createElement('span');
  dotsEl.appendChild(s);
}

/* ─── SELECT TYPE ────────────────────── */
function selectType(type) {
  currentType = type;

  const isJs = type === 'jobseeker';

  // ── Buttons
  const btnJs  = document.getElementById('btnJs');
  const btnEmp = document.getElementById('btnEmp');
  btnJs.className  = 'type-btn js-btn'  + (isJs ? ' active-js' : '');
  btnEmp.className = 'type-btn emp-btn' + (!isJs ? ' active-green' : '');

  // ── Left panel
  const panel = document.getElementById('leftPanel');
  panel.className = 'left-panel ' + (isJs ? 'blue' : 'green');

  document.getElementById('lpJs').style.display  = isJs ? '' : 'none';
  document.getElementById('lpEmp').style.display = isJs ? 'none' : '';

  // ── Logo
  const logo    = document.getElementById('rpLogo');
  const logoIco = document.getElementById('rpLogoIco');
  logo.className    = 'rp-logo ' + (isJs ? 'blue-mode' : 'green-mode');
  logoIco.innerHTML = isJs
    ? '<i class="fa-solid fa-user-tie"></i>'
    : '<i class="fa-solid fa-building"></i>';

  // ── Heading / sub
  document.getElementById('rpHeading').textContent = isJs ? 'Job Seeker Login' : 'Employer Login';
  document.getElementById('rpSub').textContent     = isJs
    ? 'Welcome back! Sign in to find your next opportunity.'
    : 'Access your employer dashboard to manage postings.';

  // ── Input focus classes
  const emailIn = document.getElementById('f_email');
  const passIn  = document.getElementById('f_password');
  emailIn.className = 'finput ' + (isJs ? 'blue-focus' : 'green-focus');
  passIn.className  = 'finput has-right ' + (isJs ? 'blue-focus' : 'green-focus');

  // ── Email placeholder
  emailIn.placeholder = isJs ? 'you@example.com' : 'company@example.com';

  // ── Remember / forgot colors
  document.getElementById('checkLabel').className = 'fcheck ' + (isJs ? 'blue' : 'green');
  document.getElementById('forgotLink').className = 'fforgot ' + (isJs ? 'blue' : 'green');

  // ── Submit button
  const btn = document.getElementById('submitBtn');
  btn.className = 'fsubmit ' + (isJs ? 'blue-btn' : 'green-btn');
  document.getElementById('submitLabel').textContent = isJs ? 'Sign In as Job Seeker' : 'Login to Dashboard';

  // ── Switch bottom links
  if (isJs) {
    document.getElementById('switchBottom').innerHTML = `
      New to LinearJobs? <a href="/register" class="blue">Register Free</a>
      <div class="switch-divider"></div>
      Are you an employer? <a href="#" class="green" onclick="selectType('employer'); return false;">Employer Login</a>
    `;
  } else {
    document.getElementById('switchBottom').innerHTML = `
      New employer? <a href="/employer/register" class="green">Register Your Company</a>
      <div class="switch-divider"></div>
      Looking for a job? <a href="#" class="blue" onclick="selectType('jobseeker'); return false;">Job Seeker Login</a>
    `;
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
  const btn   = document.getElementById('submitBtn');
  const label = document.getElementById('submitLabel');
  btn.disabled = true;
  label.textContent = 'Signing in…';
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Signing in…</span>';

  // Reset after 2s (demo)
  setTimeout(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="fa-solid fa-right-to-bracket"></i> <span id="submitLabel">' +
      (currentType === 'jobseeker' ? 'Sign In as Job Seeker' : 'Login to Dashboard') + '</span>';
  }, 2000);
}

/* ─── INIT ───────────────────────────── */
selectType('jobseeker');
</script>

@endpush