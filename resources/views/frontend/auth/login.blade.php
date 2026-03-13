<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Sign In – LinearJobs</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
<style>
/* ═══════════════════════════════════════
   CSS VARIABLES
═══════════════════════════════════════ */
:root {
  --blue: #1a56db;
  --blue-d: #1e3a8a;
  --blue-lt: rgba(26,86,219,.07);
  --green: #059669;
  --green-d: #065f46;
  --green-lt: rgba(5,150,105,.07);
  --amber: #d97706;
  --n50: #f8f9fb;
  --n100: #f1f2f5;
  --n200: #e4e6ed;
  --n300: #c8ccd8;
  --n400: #9297aa;
  --n500: #6b7280;
  --n600: #4b5160;
  --n700: #374151;
  --n800: #1f2937;
  --n900: #111827;
  --r: 10px;
  --r-sm: 8px;
  --r-lg: 16px;
  --sh: 0 2px 8px rgba(0,0,0,.06);
  --sh-md: 0 4px 20px rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
  --sh-lg: 0 12px 40px rgba(0,0,0,.12);
  --t: .18s ease;
  --f:  'Plus Jakarta Sans', sans-serif;
  --fh: 'Outfit', sans-serif;

* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--f); background: var(--n50); color: var(--n900); min-height: 100vh; overflow-x: hidden; }

/* ═══════════════════════════════════════
   NAVBAR
═══════════════════════════════════════ */
.navbar {
  background: #fff;
  border-bottom: 1.5px solid var(--n200);
  padding: 0 32px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 200;
}
.logo {
  font-family: var(--fh);
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--blue);
  letter-spacing: -.5px;
  text-decoration: none;
  cursor: pointer;
}
.logo span { color: var(--n900); }
.nav-link { font-size: .875rem; font-weight: 500; color: var(--n500); text-decoration: none; transition: color var(--t); }
.nav-link:hover { color: var(--blue); }

/* ═══════════════════════════════════════
   PAGE SYSTEM
═══════════════════════════════════════ */
.page { display: none; }
.page.active { display: block; }

/* ═══════════════════════════════════════
   SELECTION PAGE
═══════════════════════════════════════ */
.sel-page {
  min-height: calc(100vh - 64px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px 60px;
  background: var(--n50);
  position: relative;
  overflow: hidden;
}
.sel-page::before {
  content: '';
  position: absolute;
  top: -140px; right: -140px;
  width: 520px; height: 520px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,86,219,.06) 0%, transparent 70%);
  pointer-events: none;
}
.sel-page::after {
  content: '';
  position: absolute;
  bottom: -120px; left: -120px;
  width: 440px; height: 440px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(5,150,105,.05) 0%, transparent 70%);
  pointer-events: none;
}

/* Floating dots decoration */
.sel-deco {
  position: absolute;
  top: 60px; left: 60px;
  display: grid;
  grid-template-columns: repeat(5,1fr);
  gap: 10px;
  opacity: .06;
  pointer-events: none;
}
.sel-deco span { width: 5px; height: 5px; border-radius: 50%; background: var(--n900); display: block; }

.sel-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(26,86,219,.08);
  border: 1.5px solid rgba(26,86,219,.15);
  border-radius: 100px;
  padding: 6px 16px;
  font-size: .78rem;
  font-weight: 600;
  color: var(--blue);
  margin-bottom: 22px;
  animation: fadeUp .5s ease both;
}
.sel-title {
  font-family: var(--fh);
  font-size: clamp(1.9rem, 4.5vw, 2.8rem);
  font-weight: 800;
  color: var(--n900);
  text-align: center;
  letter-spacing: -.05em;
  line-height: 1.15;
  margin-bottom: 12px;
  animation: fadeUp .5s .07s ease both;
}
.sel-title .accent-blue {
  background: linear-gradient(135deg, #1a56db, #2563eb);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.sel-title .accent-green {
  background: linear-gradient(135deg, #059669, #10b981);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.sel-sub {
  font-size: 1rem;
  color: var(--n500);
  text-align: center;
  max-width: 460px;
  line-height: 1.65;
  margin-bottom: 48px;
  animation: fadeUp .5s .13s ease both;
}

/* Cards */
.sel-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 22px;
  max-width: 740px;
  width: 100%;
  animation: fadeUp .5s .19s ease both;
}
.sel-card {
  background: #fff;
  border: 2px solid var(--n200);
  border-radius: 20px;
  padding: 38px 32px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: all .26s cubic-bezier(.34,1.56,.64,1);
  box-shadow: var(--sh);
}
.sel-card::before {
  content: '';
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity .26s ease;
  border-radius: inherit;
}
.sel-card.js-card::before { background: linear-gradient(135deg, rgba(26,86,219,.03), rgba(30,58,138,.04)); }
.sel-card.emp-card::before { background: linear-gradient(135deg, rgba(5,150,105,.03), rgba(6,95,70,.04)); }
.sel-card:hover { transform: translateY(-8px) scale(1.012); box-shadow: 0 24px 64px rgba(0,0,0,.12); }
.sel-card.js-card:hover { border-color: rgba(26,86,219,.35); }
.sel-card.emp-card:hover { border-color: rgba(5,150,105,.35); }
.sel-card:hover::before { opacity: 1; }

/* Glow */
.card-glow {
  position: absolute;
  top: -40px; left: 50%;
  transform: translateX(-50%);
  width: 180px; height: 90px;
  border-radius: 50%;
  filter: blur(35px);
  opacity: 0;
  transition: opacity .26s ease;
  pointer-events: none;
}
.js-card .card-glow { background: rgba(26,86,219,.22); }
.emp-card .card-glow { background: rgba(5,150,105,.22); }
.sel-card:hover .card-glow { opacity: 1; }

/* Icon */
.sel-card-ico {
  width: 70px; height: 70px;
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.6rem;
  margin: 0 auto 22px;
  transition: transform .26s cubic-bezier(.34,1.56,.64,1);
}
.js-card .sel-card-ico { background: linear-gradient(135deg,#dbeafe,#ede9fe); color: var(--blue); box-shadow: 0 4px 16px rgba(26,86,219,.18); }
.emp-card .sel-card-ico { background: linear-gradient(135deg,#d1fae5,#a7f3d0); color: var(--green); box-shadow: 0 4px 16px rgba(5,150,105,.18); }
.sel-card:hover .sel-card-ico { transform: scale(1.12) rotate(-4deg); }

.sel-card-title { font-family: var(--fh); font-size: 1.35rem; font-weight: 800; color: var(--n900); letter-spacing: -.03em; margin-bottom: 9px; text-align: center; }
.sel-card-desc { font-size: .875rem; color: var(--n500); line-height: 1.6; margin-bottom: 24px; text-align: center; }

.sel-card-perks { list-style: none; margin-bottom: 28px; display: flex; flex-direction: column; gap: 7px; }
.sel-card-perks li { display: flex; align-items: center; gap: 8px; font-size: .82rem; color: var(--n600); font-weight: 500; }
.sel-card-perks li i { font-size: .65rem; width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.js-card .sel-card-perks li i { background: #dbeafe; color: var(--blue); }
.emp-card .sel-card-perks li i { background: #d1fae5; color: var(--green); }

.sel-card-btn {
  display: flex; align-items: center; justify-content: center; gap: 9px;
  width: 100%; border: none; border-radius: 12px;
  padding: 12px 20px;
  font-family: var(--fh); font-size: .9rem; font-weight: 700;
  cursor: pointer; transition: all .2s ease; letter-spacing: -.01em;
  color: #fff;
}
.js-card .sel-card-btn { background: linear-gradient(135deg,#1a56db,#2563eb); box-shadow: 0 4px 14px rgba(26,86,219,.28); }
.emp-card .sel-card-btn { background: linear-gradient(135deg,#059669,#10b981); box-shadow: 0 4px 14px rgba(5,150,105,.28); }
.sel-card-btn:hover { transform: translateY(-1px); filter: brightness(1.06); }

.sel-card-tag {
  position: absolute; top: 14px; right: 14px;
  font-size: .66rem; font-weight: 700; padding: 3px 10px;
  border-radius: 100px; letter-spacing: .04em; text-transform: uppercase;
}
.js-card .sel-card-tag { background: #dbeafe; color: #1d4ed8; }
.emp-card .sel-card-tag { background: #d1fae5; color: #065f46; }

/* Bottom strip */
.sel-bottom { display: flex; align-items: center; gap: 10px; margin-top: 36px; animation: fadeUp .5s .25s ease both; }
.sel-bottom-text { font-size: .875rem; color: var(--n500); }
.sel-bottom-text a { color: var(--blue); font-weight: 600; text-decoration: none; }
.sel-bottom-text a:hover { text-decoration: underline; }
.sel-sep { color: var(--n300); font-size: .75rem; }

.trust-strip { display: flex; align-items: center; justify-content: center; gap: 24px; margin-top: 44px; flex-wrap: wrap; animation: fadeUp .5s .3s ease both; }
.trust-item { display: flex; align-items: center; gap: 7px; font-size: .78rem; color: var(--n400); font-weight: 500; }
.trust-item i { color: var(--green); font-size: .78rem; }

@keyframes fadeUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }

/* ═══════════════════════════════════════
   LOGIN PAGE (full-split layout)
═══════════════════════════════════════ */
.login-page { min-height: calc(100vh - 64px); display: flex; }
.login-split { display: grid; grid-template-columns: 420px 1fr; width: 100%; min-height: calc(100vh - 64px); }

/* Left panel */
.login-left {
  display: flex; flex-direction: column; justify-content: center;
  padding: 60px 48px; position: relative; overflow: hidden;
}
.login-left.blue-panel { background: linear-gradient(155deg,#1a56db 0%,#1e3a8a 100%); }
.login-left.green-panel { background: linear-gradient(155deg,#059669 0%,#065f46 100%); }
.login-left::before {
  content: ''; position: absolute; top:-120px; right:-80px;
  width:400px; height:400px; border-radius:50%;
  background:rgba(255,255,255,.06); pointer-events:none;
}
.login-left::after {
  content: ''; position: absolute; bottom:-100px; left:-60px;
  width:320px; height:320px; border-radius:50%;
  background:rgba(255,255,255,.04); pointer-events:none;
}
.ll-dots { position:absolute; top:40px; left:40px; display:grid; grid-template-columns:repeat(6,1fr); gap:9px; opacity:.12; }
.ll-dots span { width:5px; height:5px; border-radius:50%; background:#fff; display:block; }

.ll-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.2);
  border-radius: 100px; padding: 6px 16px;
  font-size: .75rem; font-weight: 700; color: rgba(255,255,255,.9);
  letter-spacing: .05em; text-transform: uppercase;
  margin-bottom: 28px; width: fit-content;
}
.ll-badge i { opacity: .85; }
.ll-back {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
  border-radius: 100px; padding: 6px 14px;
  font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.85);
  cursor: pointer; margin-bottom: 28px; width: fit-content;
  transition: background .2s ease;
  text-decoration: none;
}
.ll-back:hover { background: rgba(255,255,255,.2); }
.ll-title { font-family: var(--fh); font-size: clamp(1.45rem,2.3vw,1.9rem); font-weight: 800; color: #fff; line-height: 1.22; letter-spacing: -.4px; margin-bottom: 13px; }
.ll-sub { font-size: .875rem; color: rgba(255,255,255,.72); line-height: 1.7; margin-bottom: 34px; }
.ll-perks { display: flex; flex-direction: column; gap: 13px; }
.ll-perk { display: flex; align-items: flex-start; gap: 12px; }
.ll-perk-ico { width: 34px; height: 34px; flex-shrink: 0; border-radius: var(--r-sm); background: rgba(255,255,255,.14); display: flex; align-items: center; justify-content: center; font-size: .8rem; color: #fff; }
.ll-perk-text { font-size: .84rem; color: rgba(255,255,255,.78); line-height: 1.5; }
.ll-perk-text strong { color: #fff; display: block; font-size: .875rem; margin-bottom: 1px; }
.ll-stats { margin-top: 40px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,.14); display: flex; gap: 28px; }
.ll-stat-val { font-family: var(--fh); font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
.ll-stat-lbl { font-size: .7rem; color: rgba(255,255,255,.5); margin-top: 3px; }

/* Right panel */
.login-right {
  background: #fff;
  display: flex; align-items: center; justify-content: center;
  padding: 52px 40px;
  animation: fadeUp .35s ease;
}
.login-form-box { width: 100%; max-width: 420px; }

.lf-logo { font-family: var(--fh); font-size: 1.4rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 4px; display: flex; align-items: center; gap: 9px; }
.lf-logo-ico { width: 36px; height: 36px; border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center; font-size: .88rem; }
.lf-logo.blue-logo { color: var(--blue); }
.lf-logo.blue-logo .lf-logo-ico { background: var(--blue-lt); color: var(--blue); }
.lf-logo.green-logo { color: var(--green); }
.lf-logo.green-logo .lf-logo-ico { background: var(--green-lt); color: var(--green); }

.lf-heading { font-family: var(--fh); font-size: 1.5rem; font-weight: 800; color: var(--n900); letter-spacing: -.04em; margin-bottom: 6px; margin-top: 22px; }
.lf-sub { font-size: .875rem; color: var(--n500); margin-bottom: 28px; line-height: 1.6; }

/* Form */
.lj-fgroup { margin-bottom: 16px; }
.lj-label { display: block; font-size: .8125rem; font-weight: 600; color: var(--n700); margin-bottom: 6px; }
.lj-label .req { color: #e53e3e; margin-left: 2px; }
.lj-iw { position: relative; }
.lj-iw-ico { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--n400); font-size: .82rem; pointer-events: none; z-index: 1; }
.lj-iw-ico-r { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); color: var(--n400); font-size: .82rem; cursor: pointer; z-index: 1; background: none; border: none; padding: 0; transition: color var(--t); }
.lj-iw-ico-r:hover { color: var(--n700); }
.lj-input {
  width: 100%; border: 1.5px solid var(--n200); border-radius: var(--r);
  padding: 11px 14px 11px 38px; font-family: var(--f); font-size: .9rem;
  color: var(--n900); background: #fff; outline: none;
  transition: border-color var(--t), box-shadow var(--t);
}
.lj-input.pr { padding-right: 40px; }
.lj-input::placeholder { color: var(--n400); }
.lj-input.blue-focus:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }
.lj-input.green-focus:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(5,150,105,.1); }

.lj-row-check { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.lj-check { display: flex; align-items: center; gap: 8px; font-size: .85rem; color: var(--n600); cursor: pointer; }
.lj-check input { width: 15px; height: 15px; }
.lj-check.blue input { accent-color: var(--blue); }
.lj-check.green input { accent-color: var(--green); }
.lj-forgot { font-size: .85rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; }
.lj-forgot.blue { color: var(--blue); }
.lj-forgot.green { color: var(--green); }
.lj-forgot:hover { text-decoration: underline; }

.lj-submit {
  width: 100%; border: none; border-radius: var(--r);
  font-family: var(--fh); font-size: .9375rem; font-weight: 700;
  padding: 13px 20px; cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 10px;
  transition: all var(--t); margin-bottom: 20px; color: #fff;
}
.lj-submit.blue-btn { background: linear-gradient(135deg,#1a56db,#2563eb); box-shadow: 0 4px 16px rgba(26,86,219,.25); }
.lj-submit.blue-btn:hover { background: linear-gradient(135deg,#1e40af,#1a56db); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,86,219,.35); }
.lj-submit.green-btn { background: linear-gradient(135deg,#059669,#10b981); box-shadow: 0 4px 16px rgba(5,150,105,.25); }
.lj-submit.green-btn:hover { background: linear-gradient(135deg,#065f46,#059669); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(5,150,105,.35); }
.lj-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }

.lj-or { display: flex; align-items: center; gap: 12px; margin: 16px 0; color: var(--n400); font-size: .78rem; }
.lj-or::before,.lj-or::after { content: ''; flex: 1; height: 1px; background: var(--n100); }

.lj-auth-switch { text-align: center; font-size: .875rem; color: var(--n500); line-height: 2; }
.lj-auth-switch a { font-weight: 600; text-decoration: none; }
.lj-auth-switch a.blue { color: var(--blue); }
.lj-auth-switch a.green { color: var(--green); }
.lj-auth-switch a:hover { text-decoration: underline; }

.lj-alert-err { background: #fef2f2; border: 1.5px solid #fecaca; border-radius: var(--r); padding: 12px 14px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; font-size: .84rem; color: #b91c1c; }
.lj-alert-err i { color: #ef4444; flex-shrink: 0; margin-top: 1px; }
.lj-alert-success { background: #f0fdf4; border: 1.5px solid #86efac; border-radius: var(--r); padding: 12px 14px; margin-bottom: 18px; display: flex; align-items: center; gap: 10px; font-size: .84rem; color: #166534; }

/* Divider line in switch box */
.lj-switch-divider { height: 1px; background: var(--n100); margin: 14px 0; }

@media(max-width:900px) {
  .login-split { grid-template-columns: 1fr; }
  .login-left { display: none; }
  .login-right { padding: 40px 24px; }
}
@media(max-width:660px) {
  .sel-grid { grid-template-columns: 1fr; max-width: 400px; }
  .sel-card { padding: 28px 22px; }
  .sel-bottom { flex-direction: column; gap: 6px; text-align: center; }
  .sel-sep { display: none; }
  .navbar { padding: 0 16px; }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="logo" onclick="showPage('selection')">Linear<span>Jobs</span></div>
  <a class="nav-link" href="#">Browse Jobs</a>
</nav>

<!-- ════════════════════════════════════
     PAGE 1: SELECTION
════════════════════════════════════ -->
<div class="page active" id="page-selection">
  <div class="sel-page">
    <div class="sel-deco">
      <span></span><span></span><span></span><span></span><span></span>
      <span></span><span></span><span></span><span></span><span></span>
      <span></span><span></span><span></span><span></span><span></span>
      <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="sel-eyebrow"><i class="fa-solid fa-right-to-bracket"></i> Welcome back</div>

    <h1 class="sel-title">
      Sign in to<br>
      <span class="accent-blue">LinearJobs</span>
    </h1>
    <p class="sel-sub">Choose how you're signing in. Your dashboard is waiting.</p>

    <div class="sel-grid">

      <!-- Job Seeker -->
      <div class="sel-card js-card" onclick="showLoginPage('jobseeker')">
        <div class="card-glow"></div>
        <div class="sel-card-tag">Free Forever</div>
        <div class="sel-card-ico"><i class="fa-solid fa-user-tie"></i></div>
        <div class="sel-card-title">Job Seeker</div>
        <p class="sel-card-desc">Access your profile, browse jobs, and track your applications.</p>
        <ul class="sel-card-perks">
          <li><i class="fa-solid fa-check"></i> View & apply to open positions</li>
          <li><i class="fa-solid fa-check"></i> Track your application status</li>
          <li><i class="fa-solid fa-check"></i> Update your resume & skills</li>
          <li><i class="fa-solid fa-check"></i> Get personalized job alerts</li>
        </ul>
        <button class="sel-card-btn">Sign In as Job Seeker <i class="fa-solid fa-arrow-right"></i></button>
      </div>

      <!-- Employer -->
      <div class="sel-card emp-card" onclick="showLoginPage('employer')">
        <div class="card-glow"></div>
        <div class="sel-card-tag">Hire Faster</div>
        <div class="sel-card-ico"><i class="fa-solid fa-building-flag"></i></div>
        <div class="sel-card-title">Employer</div>
        <p class="sel-card-desc">Manage job postings, review candidates, and grow your team.</p>
        <ul class="sel-card-perks">
          <li><i class="fa-solid fa-check"></i> Post and manage job listings</li>
          <li><i class="fa-solid fa-check"></i> Review incoming applications</li>
          <li><i class="fa-solid fa-check"></i> Access candidate profiles</li>
          <li><i class="fa-solid fa-check"></i> Analytics & hiring dashboard</li>
        </ul>
        <button class="sel-card-btn">Sign In as Employer <i class="fa-solid fa-arrow-right"></i></button>
      </div>

    </div>

    <div class="sel-bottom">
      <div class="sel-bottom-text">New here? <a href="/register">Create a free account</a></div>
      <div class="sel-sep">•</div>
      <div class="sel-bottom-text"><a href="/forgot-password">Forgot your password?</a></div>
    </div>

    <div class="trust-strip">
      <div class="trust-item"><i class="fa-solid fa-shield-halved"></i> Secure & Encrypted</div>
      <div class="trust-item"><i class="fa-solid fa-check-circle"></i> Verified Companies</div>
      <div class="trust-item"><i class="fa-solid fa-users"></i> 50,000+ Users</div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     PAGE 2: JOB SEEKER LOGIN
════════════════════════════════════ -->
<div class="page" id="page-jobseeker">
  <div class="login-page">
    <div class="login-split">

      <!-- Left Panel -->
      <div class="login-left blue-panel">
        <div class="ll-dots" id="jsDotsLeft"></div>

        <a class="ll-back" onclick="showPage('selection'); return false;" href="#">
          <i class="fa-solid fa-arrow-left"></i> Change login type
        </a>

        <div class="ll-badge"><i class="fa-solid fa-user-tie"></i> Job Seeker Portal</div>
        <div class="ll-title">Find Your Next Job in Tamil Nadu</div>
        <div class="ll-sub">Connect with verified MSME employers and take the next step in your career — completely free.</div>

        <div class="ll-perks">
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-briefcase"></i></div>
            <div class="ll-perk-text"><strong>10,000+ Job Listings</strong>Browse opportunities across all industries and districts.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="ll-perk-text"><strong>Verified Employers</strong>All employers are GST and PAN verified for your safety.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-indian-rupee-sign"></i></div>
            <div class="ll-perk-text"><strong>100% Free for Job Seekers</strong>No fees, no subscriptions. Apply to unlimited jobs.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-bell"></i></div>
            <div class="ll-perk-text"><strong>Instant Job Alerts</strong>Get notified when jobs matching your skills are posted.</div>
          </div>
        </div>

        <div class="ll-stats">
          <div><div class="ll-stat-val">50,000+</div><div class="ll-stat-lbl">Job Seekers</div></div>
          <div><div class="ll-stat-val">1,200+</div><div class="ll-stat-lbl">Employers</div></div>
          <div><div class="ll-stat-val">100%</div><div class="ll-stat-lbl">Free</div></div>
        </div>
      </div>

      <!-- Right Panel -->
      <div class="login-right">
        <div class="login-form-box">

          <div class="lf-logo blue-logo">
            <div class="lf-logo-ico"><i class="fa-solid fa-user-tie"></i></div>
            LinearJobs
          </div>
          <div class="lf-heading">Job Seeker Login</div>
          <div class="lf-sub">Welcome back! Sign in to find your next opportunity.</div>

          <form method="POST" action="/jobseeker/login" id="jsLoginForm" onsubmit="handleSubmit('jsLoginBtn','jsLoginForm'); return false;">

            <div class="lj-fgroup">
              <label class="lj-label" for="js_email">Email Address <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-envelope lj-iw-ico"></i>
                <input type="email" id="js_email" name="email" class="lj-input blue-focus" placeholder="you@example.com" required autocomplete="email" />
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="js_password">Password <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-lock lj-iw-ico"></i>
                <input type="password" id="js_password" name="password" class="lj-input pr blue-focus" placeholder="Enter your password" required autocomplete="current-password" />
                <button type="button" class="lj-iw-ico-r" onclick="togglePwd('js_password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
              </div>
            </div>

            <div class="lj-row-check">
              <label class="lj-check blue"><input type="checkbox" name="remember"> Remember me for 30 days</label>
              <a href="/forgot-password" class="lj-forgot blue"><i class="fa-solid fa-key" style="font-size:.7rem;"></i> Forgot Password?</a>
            </div>

            <button type="submit" class="lj-submit blue-btn" id="jsLoginBtn">
              <i class="fa-solid fa-right-to-bracket"></i> Sign In
            </button>
          </form>

          <div class="lj-or">or</div>

          <div class="lj-auth-switch">
            New to LinearJobs? <a href="/register" class="blue">Register Free</a>
          </div>
          <div class="lj-switch-divider"></div>
          <div class="lj-auth-switch">
            Are you an employer? <a href="#" class="green" onclick="showLoginPage('employer'); return false;">Employer Login</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     PAGE 3: EMPLOYER LOGIN
════════════════════════════════════ -->
<div class="page" id="page-employer">
  <div class="login-page">
    <div class="login-split">

      <!-- Left Panel -->
      <div class="login-left green-panel">
        <div class="ll-dots" id="empDotsLeft"></div>

        <a class="ll-back" onclick="showPage('selection'); return false;" href="#">
          <i class="fa-solid fa-arrow-left"></i> Change login type
        </a>

        <div class="ll-badge"><i class="fa-solid fa-building"></i> Employer Portal</div>
        <div class="ll-title">Find the Right Talent for Your Business</div>
        <div class="ll-sub">Post jobs and connect with thousands of skilled professionals across Tamil Nadu — starting at just ₹600.</div>

        <div class="ll-perks">
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-users"></i></div>
            <div class="ll-perk-text"><strong>Large Talent Pool</strong>Access 50,000+ registered job seekers across all skills.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-tag"></i></div>
            <div class="ll-perk-text"><strong>Affordable Plans</strong>Post jobs from ₹600. Plans designed for MSMEs.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="ll-perk-text"><strong>Local Hiring Focus</strong>Reach candidates in all 32 districts of Tamil Nadu.</div>
          </div>
          <div class="ll-perk">
            <div class="ll-perk-ico"><i class="fa-solid fa-chart-line"></i></div>
            <div class="ll-perk-text"><strong>Easy Dashboard</strong>Manage all applications from one simple dashboard.</div>
          </div>
        </div>

        <div class="ll-stats">
          <div><div class="ll-stat-val">1,200+</div><div class="ll-stat-lbl">Employers</div></div>
          <div><div class="ll-stat-val">₹600</div><div class="ll-stat-lbl">Starting Plan</div></div>
          <div><div class="ll-stat-val">48hr</div><div class="ll-stat-lbl">Avg. Response</div></div>
        </div>
      </div>

      <!-- Right Panel -->
      <div class="login-right">
        <div class="login-form-box">

          <div class="lf-logo green-logo">
            <div class="lf-logo-ico"><i class="fa-solid fa-building"></i></div>
            LinearJobs
          </div>
          <div class="lf-heading">Employer Login</div>
          <div class="lf-sub">Access your employer dashboard to manage job postings and applications.</div>

          <form method="POST" action="/employer/login" id="empLoginForm" onsubmit="handleSubmit('empLoginBtn','empLoginForm'); return false;">

            <div class="lj-fgroup">
              <label class="lj-label" for="emp_email">Official Email Address <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-envelope lj-iw-ico"></i>
                <input type="email" id="emp_email" name="email" class="lj-input green-focus" placeholder="company@example.com" required autocomplete="email" />
              </div>
            </div>

            <div class="lj-fgroup">
              <label class="lj-label" for="emp_password">Password <span class="req">*</span></label>
              <div class="lj-iw">
                <i class="fa-solid fa-lock lj-iw-ico"></i>
                <input type="password" id="emp_password" name="password" class="lj-input pr green-focus" placeholder="Enter your password" required autocomplete="current-password" />
                <button type="button" class="lj-iw-ico-r" onclick="togglePwd('emp_password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
              </div>
            </div>

            <div class="lj-row-check">
              <label class="lj-check green"><input type="checkbox" name="remember"> Remember me</label>
              <a href="/forgot-password" class="lj-forgot green"><i class="fa-solid fa-key" style="font-size:.7rem;"></i> Forgot Password?</a>
            </div>

            <button type="submit" class="lj-submit green-btn" id="empLoginBtn">
              <i class="fa-solid fa-right-to-bracket"></i> Login to Dashboard
            </button>
          </form>

          <div class="lj-or">or</div>

          <div class="lj-auth-switch">
            New employer? <a href="/employer/register" class="green">Register Your Company</a>
          </div>
          <div class="lj-switch-divider"></div>
          <div class="lj-auth-switch">
            Looking for a job? <a href="#" class="blue" onclick="showLoginPage('jobseeker'); return false;">Job Seeker Login</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════ -->
<script>
/* ─── PAGE ROUTING ───────────────────── */
function showPage(name) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + name).classList.add('active');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showLoginPage(type) {
  showPage(type);
  // Focus email input after transition
  setTimeout(() => {
    const input = document.getElementById(type === 'jobseeker' ? 'js_email' : 'emp_email');
    if (input) input.focus();
  }, 80);
}

/* ─── GENERATE DOTS ──────────────────── */
function buildDots(containerId, count) {
  const el = document.getElementById(containerId);
  if (!el) return;
  for (let i = 0; i < count; i++) {
    const s = document.createElement('span');
    el.appendChild(s);
  }
}

/* ─── TOGGLE PASSWORD ────────────────── */
function togglePwd(id, btn) {
  const inp = document.getElementById(id);
  const ico = btn.querySelector('i');
  if (inp.type === 'password') { inp.type = 'text'; ico.className = 'fa-solid fa-eye-slash'; }
  else { inp.type = 'password'; ico.className = 'fa-solid fa-eye'; }
}

/* ─── SUBMIT LOADING ─────────────────── */
function handleSubmit(btnId, formId) {
  const btn = document.getElementById(btnId);
  const isJs = btnId === 'jsLoginBtn';
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Signing in…';
  // In real use, remove the return false from onsubmit and let the form submit normally
  // Reset for demo after 2s
  setTimeout(() => {
    btn.disabled = false;
    btn.innerHTML = isJs
      ? '<i class="fa-solid fa-right-to-bracket"></i> Sign In'
      : '<i class="fa-solid fa-right-to-bracket"></i> Login to Dashboard';
  }, 2000);
}

/* ─── INIT ───────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
  buildDots('jsDotsLeft', 30);
  buildDots('empDotsLeft', 30);
});
</script>
</body>
</html>