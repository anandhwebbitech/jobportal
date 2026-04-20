{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/billing.blade.php
     LinearJobs – Billing / Plans Module (Full & Fixed)
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Billing / Plans')
@section('breadcrumb','Billing / Plans')
@php $activeNav = 'billing'; @endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ════════ ROOT VARIABLES ════════ */
:root {
  --blue:          #1a56db;
  --blue-light:    #ebf2ff;
  --blue-text:     #1e40af;
  --green:         #059669;
  --green-light:   #d1fae5;
  --green-text:    #065f46;
  --amber:         #b45309;
  --amber-light:   #fef3c7;
  --amber-text:    #92400e;
  --red:           #dc2626;
  --red-light:     #fee2e2;
  --purple:        #7c3aed;
  --purple-light:  #ede9fe;
  --purple-text:   #4c1d95;
  --teal:          #0d9488;
  --teal-light:    #ccfbf1;
  --gray-50:       #f9fafb;
  --gray-100:      #f3f4f6;
  --gray-200:      #e5e7eb;
  --gray-300:      #d1d5db;
  --gray-400:      #9ca3af;
  --gray-500:      #6b7280;
  --gray-600:      #4b5563;
  --gray-700:      #374151;
  --gray-800:      #1f2937;
  --gray-900:      #111827;
  --grad-blue:     linear-gradient(135deg,#1a56db 0%,#7c3aed 100%);
  --grad-green:    linear-gradient(135deg,#059669 0%,#0d9488 100%);
  --grad-amber:    linear-gradient(135deg,#b45309 0%,#d97706 100%);
  --shadow-card:   0 1px 4px rgba(0,0,0,.07),0 4px 16px rgba(0,0,0,.06);
  --shadow-hover:  0 8px 30px rgba(0,0,0,.13);
  --r:             14px;
  --font:          'Sora', sans-serif;
  --body:          'DM Sans', sans-serif;
}

*, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
body { font-family:var(--body); color:var(--gray-700); }

/* ════ PAGE HEADER ════ */
.page-hdr        { margin-bottom:22px; }
.page-title      { font-family:var(--font); font-size:1.35rem; font-weight:900; color:var(--gray-900); letter-spacing:-.4px; }
.page-sub        { font-size:.82rem; color:var(--gray-500); margin-top:3px; }

/* ════ TAB BAR ════ */
.billing-tabs {
  display:flex; gap:5px; padding:5px;
  background:var(--gray-100); border-radius:13px; margin-bottom:26px;
}
.billing-tab {
  flex:1; padding:10px 14px; border-radius:10px; border:none;
  background:transparent; font-family:var(--font); font-size:.8rem;
  font-weight:700; color:var(--gray-500); cursor:pointer;
  transition:all .2s; display:flex; align-items:center;
  justify-content:center; gap:6px; white-space:nowrap;
}
.billing-tab i { font-size:.8rem; }
.billing-tab.active { background:#fff; color:var(--blue); box-shadow:0 2px 8px rgba(0,0,0,.09); }
@media(max-width:640px){
  .billing-tabs { flex-wrap:wrap; }
  .billing-tab  { flex:1 1 45%; font-size:.72rem; padding:9px 8px; }
}

/* ════ TAB PANELS ════ */
.tab-panel        { display:none; }
.tab-panel.active { display:block; animation:fadeUp .28s ease both; }
@keyframes fadeUp { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

/* ════ HERO BANNER ════ */
.hero-banner {
  border-radius:var(--r); padding:26px 28px;
  display:grid; grid-template-columns:1fr auto; gap:18px; align-items:center;
  margin-bottom:22px; position:relative; overflow:hidden;
}
.hero-banner.blue  { background:var(--grad-blue); }
.hero-banner.green { background:var(--grad-green); }
.hero-banner.amber { background:var(--grad-amber); }
.hero-banner::before {
  content:''; position:absolute; top:-50px; right:-50px;
  width:180px; height:180px; border-radius:50%;
  background:rgba(255,255,255,.06); pointer-events:none;
}
.hero-body   { position:relative; z-index:1; }
.hero-pill {
  display:inline-flex; align-items:center; gap:6px;
  background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.28);
  border-radius:100px; padding:4px 13px;
  font-family:var(--font); font-size:.65rem; font-weight:700;
  color:rgba(255,255,255,.95); letter-spacing:.06em; text-transform:uppercase; margin-bottom:9px;
}
.hero-title  { font-family:var(--font); font-size:1.3rem; font-weight:900; color:#fff; letter-spacing:-.3px; }
.hero-sub    { font-size:.79rem; color:rgba(255,255,255,.72); margin-top:4px; }
.hero-stats  { display:grid; grid-template-columns:repeat(3,1fr); gap:11px; margin-top:16px; }
@media(max-width:580px){ .hero-stats{ grid-template-columns:1fr 1fr; } }
.hero-stat   { background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.2); border-radius:10px; padding:11px 13px; }
.hero-stat-val { font-family:var(--font); font-size:1.05rem; font-weight:900; color:#fff; }
.hero-stat-lbl { font-size:.65rem; color:rgba(255,255,255,.65); margin-top:2px; }
.hero-actions  { display:flex; flex-direction:column; gap:8px; align-items:flex-end; position:relative; z-index:1; }
.btn-hero {
  background:#fff; border:none; border-radius:9px; padding:10px 20px;
  font-family:var(--font); font-size:.8rem; font-weight:800;
  cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:7px;
  box-shadow:0 2px 8px rgba(0,0,0,.12);
}
.btn-hero.blue  { color:var(--blue); }
.btn-hero.green { color:var(--green); }
.btn-hero.amber { color:var(--amber); }
.btn-hero:hover { transform:translateY(-2px); }
.btn-hero-ghost {
  background:rgba(255,255,255,.13); color:#fff;
  border:1.5px solid rgba(255,255,255,.3); border-radius:9px;
  padding:9px 18px; font-family:var(--font); font-size:.78rem; font-weight:700;
  cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:7px;
}
.btn-hero-ghost:hover { background:rgba(255,255,255,.22); }
@media(max-width:768px){
  .hero-banner { grid-template-columns:1fr; }
  .hero-actions { align-items:flex-start; flex-direction:row; flex-wrap:wrap; }
}

/* ════ DETAIL MINI CARDS ════ */
.detail-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:22px; }
@media(max-width:900px){ .detail-grid{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .detail-grid{ grid-template-columns:1fr 1fr; } }
.detail-card {
  background:#fff; border:1.5px solid var(--gray-200); border-radius:12px;
  padding:14px 15px; display:flex; align-items:center; gap:11px; box-shadow:var(--shadow-card);
}
.detail-ico {
  width:36px; height:36px; border-radius:9px;
  display:flex; align-items:center; justify-content:center; font-size:.88rem; flex-shrink:0;
}
.detail-ico.blue   { background:var(--blue-light);   color:var(--blue); }
.detail-ico.green  { background:var(--green-light);  color:var(--green); }
.detail-ico.amber  { background:var(--amber-light);  color:var(--amber); }
.detail-ico.red    { background:var(--red-light);    color:var(--red); }
.detail-ico.purple { background:var(--purple-light); color:var(--purple); }
.detail-ico.gray   { background:var(--gray-100);     color:var(--gray-600); }
.detail-lbl { font-family:var(--font); font-size:.62rem; font-weight:800; color:var(--gray-400); text-transform:uppercase; letter-spacing:.05em; }
.detail-val { font-family:var(--font); font-size:.86rem; font-weight:900; color:var(--gray-900); margin-top:2px; }

/* ════ EMP CARD ════ */
.emp-card { background:#fff; border:1.5px solid var(--gray-200); border-radius:var(--r); overflow:hidden; margin-bottom:22px; box-shadow:var(--shadow-card); }
.emp-card-head { display:flex; align-items:center; gap:13px; padding:18px 22px; border-bottom:1.5px solid var(--gray-100); }
.emp-card-head-ico {
  width:38px; height:38px; border-radius:10px;
  display:flex; align-items:center; justify-content:center; font-size:.95rem; flex-shrink:0;
}
.emp-card-head-ico.blue   { background:var(--blue-light);   color:var(--blue); }
.emp-card-head-ico.green  { background:var(--green-light);  color:var(--green); }
.emp-card-head-ico.amber  { background:var(--amber-light);  color:var(--amber); }
.emp-card-head-ico.purple { background:var(--purple-light); color:var(--purple); }
.emp-card-head-title { font-family:var(--font); font-size:.92rem; font-weight:800; color:var(--gray-900); }
.emp-card-head-sub   { font-size:.76rem; color:var(--gray-500); margin-top:2px; }
.emp-card-body       { padding:22px; }

/* ════ PLAN GRIDS ════ */
.plan-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px; }
.plan-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:18px; }
@media(max-width:768px){ .plan-grid-3{ grid-template-columns:1fr 1fr; } }
@media(max-width:580px){ .plan-grid-2,.plan-grid-3{ grid-template-columns:1fr; } }

/* ════ PLAN CARD ════ */
.plan-card {
  border:2px solid var(--gray-200); border-radius:var(--r);
  padding:20px; position:relative; overflow:hidden;
  cursor:pointer; transition:all .22s; background:#fff;
}
.plan-card input[type="radio"] { display:none; }
/* — selected states — each module gets its own ONE colour, no bleed — */
.plan-card.sel-blue   { border-color:var(--blue);   background:#f4f8ff; box-shadow:0 4px 20px rgba(26,86,219,.12); }
.plan-card.sel-green  { border-color:var(--green);  background:#f0fdf7; box-shadow:0 4px 20px rgba(5,150,105,.11); }
.plan-card.sel-purple { border-color:var(--purple); background:#f8f5ff; box-shadow:0 4px 20px rgba(124,58,237,.11); }
.plan-card.sel-amber  { border-color:var(--amber);  background:#fffbf0; box-shadow:0 4px 20px rgba(180,83,9,.11); }
/* hover per-tab */
#tab-job .plan-card:hover     { border-color:var(--blue);  transform:translateY(-3px); box-shadow:var(--shadow-hover); }
#tab-resume .plan-card:hover  { border-color:var(--green); transform:translateY(-3px); box-shadow:var(--shadow-hover); }

/* tick top-left */
.plan-tick {
  position:absolute; top:13px; left:13px; width:21px; height:21px; border-radius:50%;
  color:#fff; display:flex; align-items:center; justify-content:center;
  font-size:.52rem; opacity:0; transform:scale(.4); transition:all .22s;
}
.plan-tick.blue   { background:var(--blue); }
.plan-tick.green  { background:var(--green); }
.plan-tick.purple { background:var(--purple); }
.sel-blue   .plan-tick,
.sel-green  .plan-tick,
.sel-purple .plan-tick,
.sel-amber  .plan-tick { opacity:1; transform:scale(1); }

/* popular badge top-right */
.plan-badge-top {
  position:absolute; top:0; right:0; color:#fff;
  font-family:var(--font); font-size:.58rem; font-weight:800;
  letter-spacing:.06em; text-transform:uppercase;
  padding:5px 12px; border-radius:0 var(--r) 0 9px;
}
.plan-badge-top.blue  { background:var(--grad-blue); }
.plan-badge-top.green { background:var(--grad-green); }

/* plan icon */
.plan-ico {
  width:46px; height:46px; border-radius:12px; margin-bottom:13px;
  display:flex; align-items:center; justify-content:center; font-size:1.15rem;
}
.plan-ico.blue   { background:var(--blue-light);   color:var(--blue); }
.plan-ico.green  { background:var(--green-light);  color:var(--green); }
.plan-ico.purple { background:var(--purple-light); color:var(--purple); }
.plan-ico.amber  { background:var(--amber-light);  color:var(--amber); }
.plan-ico.teal   { background:var(--teal-light);   color:var(--teal); }
.plan-ico.silver { background:#f1f5f9;             color:#64748b; }

.plan-name    { font-family:var(--font); font-size:.63rem; font-weight:800; color:var(--gray-400); letter-spacing:.07em; text-transform:uppercase; margin-bottom:6px; }
.plan-price   { font-family:var(--font); font-size:1.85rem; font-weight:900; color:var(--gray-900); letter-spacing:-1px; line-height:1.1; }
.plan-price sup { font-size:.85rem; vertical-align:super; }
.plan-price .plus-gst { font-family:var(--body); font-size:.73rem; font-weight:500; color:var(--gray-400); }

.plan-validity {
  display:inline-flex; align-items:center; gap:5px;
  background:var(--gray-100); border-radius:100px;
  padding:4px 11px; font-family:var(--font); font-size:.7rem; font-weight:700;
  color:var(--gray-600); margin:9px 0 13px;
}
/* validity accent when selected */
.sel-blue   .plan-validity { background:var(--blue-light);   color:var(--blue-text); }
.sel-green  .plan-validity { background:var(--green-light);  color:var(--green-text); }
.sel-purple .plan-validity { background:var(--purple-light); color:var(--purple-text); }
.sel-amber  .plan-validity { background:var(--amber-light);  color:var(--amber-text); }

.plan-divider { border:none; border-top:1.5px dashed var(--gray-200); margin:12px 0; }

.plan-feats { list-style:none; }
.plan-feats li {
  display:flex; align-items:flex-start; gap:8px;
  font-size:.77rem; color:var(--gray-600); padding:3px 0; font-family:var(--body);
}
.feat-dot {
  flex-shrink:0; width:15px; height:15px; border-radius:50%;
  display:flex; align-items:center; justify-content:center; font-size:.5rem; margin-top:1px;
}
.feat-dot.blue   { background:var(--blue-light);   color:var(--blue); }
.feat-dot.green  { background:var(--green-light);  color:var(--green); }
.feat-dot.purple { background:var(--purple-light); color:var(--purple); }
.feat-dot.amber  { background:var(--amber-light);  color:var(--amber); }

/* total strip at bottom of card */
.plan-total {
  margin-top:14px; padding:9px 13px; border-radius:9px;
  font-family:var(--font); font-size:.74rem;
}
.plan-total.blue   { background:var(--blue-light);   color:var(--blue-text); }
.plan-total.green  { background:var(--green-light);  color:var(--green-text); }
.plan-total.purple { background:var(--purple-light); color:var(--purple-text); }
.plan-total.amber  { background:var(--amber-light);  color:var(--amber-text); }
.plan-total strong { font-weight:900; }

/* ════ GST NOTE ════ */
.gst-row {
  display:flex; align-items:flex-start; gap:9px;
  background:#fefce8; border:1.5px solid #fde68a; border-radius:9px;
  padding:10px 14px; font-size:.79rem; color:#92400e; margin-top:16px; font-family:var(--body);
}
.gst-row i { margin-top:2px; flex-shrink:0; }

/* ════ BUTTONS ════ */
.btn-primary {
  display:inline-flex; align-items:center; gap:7px; color:#fff; border:none;
  border-radius:10px; padding:11px 24px; font-family:var(--font); font-size:.82rem;
  font-weight:800; cursor:pointer; transition:all .2s;
}
.btn-primary:hover { transform:translateY(-2px); filter:brightness(1.07); }
.btn-primary.blue  { background:var(--grad-blue);  box-shadow:0 4px 14px rgba(26,86,219,.28); }
.btn-primary.green { background:var(--grad-green); box-shadow:0 4px 14px rgba(5,150,105,.26); }
.btn-primary.amber { background:var(--grad-amber); box-shadow:0 4px 14px rgba(180,83,9,.26); }
.btn-outline {
  display:inline-flex; align-items:center; gap:7px; background:#fff; border-radius:10px;
  padding:10px 20px; font-family:var(--font); font-size:.8rem; font-weight:700; cursor:pointer; transition:all .2s;
}
.btn-outline.blue  { color:var(--blue);  border:2px solid var(--blue);  }
.btn-outline.blue:hover  { background:var(--blue-light); }
.btn-outline.green { color:var(--green); border:2px solid var(--green); }
.btn-outline.green:hover { background:var(--green-light); }
.btn-outline.amber { color:var(--amber); border:2px solid var(--amber); }
.btn-outline.amber:hover { background:var(--amber-light); }
.divider-actions { display:flex; gap:10px; margin-top:20px; flex-wrap:wrap; }

/* ════ BANNER WIDE CARD ════ */
.banner-wide {
  border:2px solid var(--gray-200); border-radius:var(--r); padding:22px;
  display:grid; grid-template-columns:54px 1fr auto;
  gap:16px; align-items:start; cursor:default; background:#fff; transition:border .2s;
}
.banner-wide.sel-amber { border-color:var(--amber); background:#fffbf0; }
.banner-wide input[type="radio"] { display:none; }
.banner-wide-ico {
  width:54px; height:54px; border-radius:13px;
  background:var(--amber-light); color:var(--amber);
  display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;
}

/* ════ FEATURE TILES ════ */
.feat-tile-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:22px; }
@media(max-width:640px){ .feat-tile-grid{ grid-template-columns:1fr; } }
.feat-tile { background:var(--gray-50); border:1.5px solid var(--gray-200); border-radius:12px; padding:17px 15px; }
.feat-tile-ico {
  width:38px; height:38px; border-radius:10px;
  display:flex; align-items:center; justify-content:center; font-size:.9rem; margin-bottom:11px;
}
.feat-tile-ico.amber { background:var(--amber-light); color:var(--amber); }
.feat-tile-ico.blue  { background:var(--blue-light);  color:var(--blue); }
.feat-tile-ico.green { background:var(--green-light); color:var(--green); }
.feat-tile-title { font-family:var(--font); font-size:.82rem; font-weight:800; color:var(--gray-900); margin-bottom:4px; }
.feat-tile-desc  { font-size:.73rem; color:var(--gray-500); line-height:1.5; }

/* ════ UPLOAD ════ */
.upload-label {
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  border:2px dashed #d97706; border-radius:11px; padding:26px;
  cursor:pointer; background:#fffbeb; transition:background .2s;
}
.upload-label:hover { background:#fef3c7; }
.upload-label input { display:none; }

/* ════ SUMMARY BOX ════ */
.summary-box { background:var(--gray-50); border:1.5px solid var(--gray-200); border-radius:11px; padding:16px 18px; }
.summary-row { display:flex; justify-content:space-between; align-items:center; padding:6px 0; font-size:.82rem; color:var(--gray-600); font-family:var(--body); }
.summary-row:not(:last-child) { border-bottom:1px dashed var(--gray-200); }
.s-lbl { font-weight:500; }
.s-val { font-family:var(--font); font-weight:800; color:var(--gray-900); }
.s-total .s-lbl { font-family:var(--font); font-weight:800; font-size:.88rem; color:var(--gray-900); }
.s-total .s-val { font-size:1.1rem; color:var(--amber); }

/* ════ TABLE ════ */
.emp-table-wrap { overflow-x:auto; }
.emp-table { width:100%; border-collapse:collapse; }
.emp-table thead tr { background:var(--gray-50); }
.emp-table th {
  padding:11px 15px; text-align:left; font-family:var(--font); font-size:.66rem;
  font-weight:800; color:var(--gray-500); text-transform:uppercase; letter-spacing:.06em;
  border-bottom:2px solid var(--gray-200);
}
.emp-table td { padding:12px 15px; font-size:.81rem; color:var(--gray-700); border-bottom:1px solid var(--gray-100); font-family:var(--body); }
.emp-table tbody tr:hover { background:var(--gray-50); }
.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:100px; font-family:var(--font); font-size:.66rem; font-weight:800; }
.badge-green  { background:var(--green-light);  color:var(--green-text); }
.badge-blue   { background:var(--blue-light);   color:var(--blue-text); }
.badge-amber  { background:var(--amber-light);  color:var(--amber-text); }
.badge-purple { background:var(--purple-light); color:var(--purple-text); }
.btn-sm {
  padding:5px 12px; font-size:.72rem; border-radius:7px; border:1.5px solid var(--gray-300);
  background:#fff; color:var(--gray-700); cursor:pointer; font-family:var(--font); font-weight:700;
  display:inline-flex; align-items:center; gap:5px; transition:all .17s; text-decoration:none;
}
.btn-sm:hover { border-color:var(--blue); color:var(--blue); }
</style>
@endpush

@section('content')

<div class="page-hdr">
  <div class="page-title">Billing &amp; Plans</div>
  <div class="page-sub">Manage your subscription, resume access &amp; advertisement plans</div>
</div>

{{-- ═══ TAB BAR ═══ --}}
<div class="billing-tabs">
  <button class="billing-tab active" onclick="switchTab(this,'job')"><i class="fas fa-briefcase"></i> Job Posting</button>
  <button class="billing-tab"        onclick="switchTab(this,'resume')"><i class="fas fa-database"></i> Resume DB</button>
  <button class="billing-tab"        onclick="switchTab(this,'banner')"><i class="fas fa-image"></i> Banner Ad</button>
  <button class="billing-tab"        onclick="switchTab(this,'invoices')"><i class="fas fa-file-invoice"></i> Invoices</button>
</div>

{{-- ══════════════════════════════════════════════════════
     TAB 1 – JOB POSTING
══════════════════════════════════════════════════════ --}}
<div class="tab-panel active" id="tab-job">

  {{-- Hero --}}
  <div class="hero-banner blue">
    <div class="hero-body">
      <div class="hero-pill"><i class="fas fa-bolt"></i> Active Plan</div>
      <div class="hero-title">30 Days Plan – Premium</div>
      <div class="hero-sub">Payment ID: pay_OsK89AbCdEfGh12 &nbsp;·&nbsp; Invoice: #INV-2025-031</div>
      <div class="hero-stats">
        <div class="hero-stat"><div class="hero-stat-val">₹1,180</div><div class="hero-stat-lbl">Total Paid (incl. GST)</div></div>
        <div class="hero-stat"><div class="hero-stat-val">11 Mar</div><div class="hero-stat-lbl">Plan Start Date</div></div>
        <div class="hero-stat"><div class="hero-stat-val">10 Apr</div><div class="hero-stat-lbl">Plan Expiry</div></div>
      </div>
    </div>
    <div class="hero-actions">
      <button class="btn-hero blue"><i class="fas fa-rotate-right"></i> Renew Plan</button>
      <button class="btn-hero-ghost"><i class="fas fa-file-invoice"></i> Download Invoice</button>
    </div>
  </div>

  {{-- Detail mini cards --}}
  <div class="detail-grid">
    <div class="detail-card"><div class="detail-ico blue"><i class="fas fa-tag"></i></div><div><div class="detail-lbl">Plan Name</div><div class="detail-val">30 Days Plan</div></div></div>
    <div class="detail-card"><div class="detail-ico gray"><i class="fas fa-indian-rupee-sign"></i></div><div><div class="detail-lbl">Plan Price</div><div class="detail-val">₹1,000</div></div></div>
    <div class="detail-card"><div class="detail-ico amber"><i class="fas fa-receipt"></i></div><div><div class="detail-lbl">GST (18%)</div><div class="detail-val">₹180</div></div></div>
    <div class="detail-card"><div class="detail-ico green"><i class="fas fa-wallet"></i></div><div><div class="detail-lbl">Total Paid</div><div class="detail-val">₹1,180</div></div></div>
    <div class="detail-card"><div class="detail-ico green"><i class="fas fa-calendar-check"></i></div><div><div class="detail-lbl">Start Date</div><div class="detail-val">11 Mar 2025</div></div></div>
    <div class="detail-card"><div class="detail-ico red"><i class="fas fa-calendar-xmark"></i></div><div><div class="detail-lbl">Expiry Date</div><div class="detail-val">10 Apr 2025</div></div></div>
    <div class="detail-card"><div class="detail-ico green"><i class="fas fa-circle-check"></i></div><div><div class="detail-lbl">Status</div><div class="detail-val">Active</div></div></div>
    <div class="detail-card"><div class="detail-ico purple"><i class="fas fa-crown"></i></div><div><div class="detail-lbl">Plan Type</div><div class="detail-val">Premium</div></div></div>
  </div>

  {{-- Purchase / Renew --}}
  <div class="emp-card">
    <div class="emp-card-head">
      <div class="emp-card-head-ico blue"><i class="fas fa-briefcase"></i></div>
      <div>
        <div class="emp-card-head-title">Purchase / Renew Job Posting Plan</div>
        <div class="emp-card-head-sub">Post jobs and manage applicants — job post visible for the plan duration from activation</div>
      </div>
    </div>
    <div class="emp-card-body">

      <div class="plan-grid-2">

        @foreach($jobPlans as $plan)

          <div class="plan-card" id="jp_{{ $plan->id }}Card"
              onclick="selectPlan('jp','{{ $plan->id }}','sel-blue')">

            <input type="radio" name="job_plan" id="jp_{{ $plan->id }}"
                  value="{{ $plan->id }}"{{ $loop->first ? 'checked' : '' }} />

            <div class="plan-tick blue"><i class="fas fa-check"></i></div>

            <div class="plan-ico blue">
              <i class="fas 
                @if($plan->id == 1) fa-bolt
                @elseif($plan->id == 2) fa-crown
                @else fa-gem
                @endif
              "></i>
            </div>

            <div class="plan-name">
              {{ $plan->name }} Plan
            </div>

            <div class="plan-price">
              <sup>₹</sup>{{ $plan->price }}
              <span class="plus-gst">+ GST</span>
            </div>

            <div class="plan-validity">
              <i class="fas fa-clock" style="color:var(--green);font-size:.7rem;"></i>
              &nbsp;Job visible for {{ $plan->duration_days }} Days
            </div>

            <hr class="plan-divider"/>

            <ul class="plan-feats">

              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Post {{ $plan->job_post_limit }} Job Opening
              </li>

              @if($plan->applicant_management)
              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Applicant Management
              </li>
              @endif

              @if($plan->email_notifications)
              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Email Notifications
              </li>
              @endif

              @if($plan->tamil_nadu_reach)
              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Tamil Nadu Reach
              </li>
              @endif

              @if($plan->featured_listing)
              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Featured Listing
              </li>
              @endif

              @if($plan->priority_support)
              <li>
                <span class="feat-dot blue"><i class="fas fa-check"></i></span>
                Priority Support
              </li>
              @endif

            </ul>

            <div class="plan-total blue">
              Total: <strong>₹{{ $plan->total_price }}</strong>
              <span style="opacity:.65;font-weight:500;">
                (incl. 18% GST)
              </span>
            </div>

          </div>

          @endforeach

      </div>

      <div class="gst-row">
        <i class="fas fa-circle-info" style="color:#92400e;"></i>
        Prices are exclusive of 18% GST.&nbsp;
        <strong>15 Days: ₹600 + ₹108 GST = ₹708</strong>&nbsp;|&nbsp;
        <strong>30 Days: ₹1,000 + ₹180 GST = ₹1,180</strong>
      </div>

      <div class="divider-actions">
        <button class="btn-primary blue"  onclick="buyJobPlan()"><i class="fas fa-bolt"></i> Buy Plan</button>
        <button class="btn-outline blue"  onclick="renewJobPlan()"><i class="fas fa-rotate-right"></i> Renew Current Plan</button>
      </div>

    </div>
  </div>

</div>{{-- /tab-job --}}


{{-- ══════════════════════════════════════════════════════
     TAB 2 – RESUME DB
══════════════════════════════════════════════════════ --}}
<div class="tab-panel" id="tab-resume">

  <div class="hero-banner green">
    <div class="hero-body">
      <div class="hero-pill"><i class="fas fa-database"></i> Resume Database</div>
      <div class="hero-title">Download Resumes from Our Database</div>
      <div class="hero-sub">Access Tamil Nadu's active job-seeker pool — 3 flexible plans</div>
      <div class="hero-stats">
        <div class="hero-stat"><div class="hero-stat-val">100–500</div><div class="hero-stat-lbl">Downloads / Plan</div></div>
        <div class="hero-stat"><div class="hero-stat-val">30–60</div><div class="hero-stat-lbl">Days Validity</div></div>
        <div class="hero-stat"><div class="hero-stat-val">3 Plans</div><div class="hero-stat-lbl">Available</div></div>
      </div>
    </div>
    <div class="hero-actions">
      <button class="btn-hero green" onclick="viewDownloads()"><i class="fas fa-download"></i> My Downloads</button>
    </div>
  </div>

  <div class="emp-card">
    <div class="emp-card-head">
      <div class="emp-card-head-ico green"><i class="fas fa-database"></i></div>
      <div>
        <div class="emp-card-head-title">Purchase Resume Database Access</div>
        <div class="emp-card-head-sub">Download candidate resumes from our active database</div>
      </div>
    </div>
    <div class="emp-card-body">

      <div class="plan-grid-3">

        {{-- Silver --}}
        {{-- <div class="plan-card" id="rdb_silverCard" onclick="selectPlan('rdb','silver','sel-green')">
          <input type="radio" name="resume_plan" id="rdb_silver" value="silver"/>
          <div class="plan-tick green"><i class="fas fa-check"></i></div>
          <div class="plan-ico silver"><i class="fas fa-medal" style="color:#94a3b8;"></i></div>
          <div class="plan-name">Silver Plan</div>
          <div class="plan-price"><sup>₹</sup>2,000 <span class="plus-gst">+ GST</span></div>
          <div class="plan-validity"><i class="fas fa-clock" style="color:var(--green);font-size:.7rem;"></i>&nbsp;Valid 30 Days</div>
          <hr class="plan-divider"/>
          <ul class="plan-feats">
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>100 Resume Downloads</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Full Profile Access</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Filter by Skills &amp; Location</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Export to Excel / PDF</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Email Support</li>
          </ul>
          <div class="plan-total green">Total: <strong>₹2,360</strong>&nbsp;<span style="opacity:.65;font-weight:500;">(incl. 18% GST)</span></div>
        </div> --}}

        {{-- Gold --}}
        {{-- <div class="plan-card sel-green" id="rdb_goldCard" onclick="selectPlan('rdb','gold','sel-green')">
          <div class="plan-badge-top green">🥇 Best Value</div>
          <input type="radio" name="resume_plan" id="rdb_gold" value="gold" checked/>
          <div class="plan-tick green"><i class="fas fa-check"></i></div>
          <div class="plan-ico teal"><i class="fas fa-medal"></i></div>
          <div class="plan-name">Gold Plan</div>
          <div class="plan-price"><sup>₹</sup>3,000 <span class="plus-gst">+ GST</span></div>
          <div class="plan-validity"><i class="fas fa-clock" style="color:var(--green);font-size:.7rem;"></i>&nbsp;Valid 45 Days</div>
          <hr class="plan-divider"/>
          <ul class="plan-feats">
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>200 Resume Downloads</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Full Profile Access</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Advanced Filters</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Export to Excel / PDF</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Priority Email Support</li>
            <li><span class="feat-dot green"><i class="fas fa-check"></i></span>Candidate Shortlisting</li>
          </ul>
          <div class="plan-total green">Total: <strong>₹3,540</strong>&nbsp;<span style="opacity:.65;font-weight:500;">(incl. 18% GST)</span></div>
        </div> --}}

        {{-- Platinum --}}
        {{-- <div class="plan-card" id="rdb_platinumCard" onclick="selectPlan('rdb','platinum','sel-purple')">
          <input type="radio" name="resume_plan" id="rdb_platinum" value="platinum"/>
          <div class="plan-tick purple"><i class="fas fa-check"></i></div>
          <div class="plan-ico purple"><i class="fas fa-gem"></i></div>
          <div class="plan-name">Platinum Plan</div>
          <div class="plan-price"><sup>₹</sup>5,000 <span class="plus-gst">+ GST</span></div>
          <div class="plan-validity"><i class="fas fa-clock" style="color:var(--green);font-size:.7rem;"></i>&nbsp;Valid 60 Days</div>
          <hr class="plan-divider"/>
          <ul class="plan-feats">
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>500 Resume Downloads</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>Full Profile Access</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>All Advanced Filters</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>Export to Excel / PDF</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>Dedicated Account Manager</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>Unlimited Shortlisting</li>
            <li><span class="feat-dot purple"><i class="fas fa-check"></i></span>WhatsApp Support</li>
          </ul>
          <div class="plan-total purple">Total: <strong>₹5,900</strong>&nbsp;<span style="opacity:.65;font-weight:500;">(incl. 18% GST)</span></div>
        </div> --}}
        @foreach($resumeplans as $plan)

          @php
              // dynamic styles based on plan name
              $key = strtolower($plan->name);

              $colorClass = match($key) {
                  'silver' => 'green',
                  'gold' => 'green',
                  'platinum' => 'purple',
                  default => 'green'
              };

              $iconClass = match($key) {
                  'silver' => 'fa-medal',
                  'gold' => 'fa-medal',
                  'platinum' => 'fa-gem',
                  default => 'fa-medal'
              };

              $extraClass = $key == 'gold' ? 'sel-green' : '';
          @endphp

          <div class="plan-card {{ $extraClass }}"
              id="rdb_{{ $key }}Card"
              onclick="selectPlan('rdb','{{ $key }}','sel-{{ $colorClass }}')">

              {{-- Best Value badge --}}
              @if($key == 'gold')
                  <div class="plan-badge-top green">🥇 Best Value</div>
              @endif

              <input type="radio"
                    name="resume_plan"
                    id="rdb_{{ $key }}"
                    value="{{ $plan->id }}"
                    {{ $loop->first ? 'checked' : '' }} />

              <div class="plan-tick {{ $colorClass }}">
                  <i class="fas fa-check"></i>
              </div>

              <div class="plan-ico {{ $colorClass }}">
                  <i class="fas {{ $iconClass }}"></i>
              </div>

              <div class="plan-name">
                  {{ $plan->name }} Plan
              </div>

              <div class="plan-price">
                  <sup>₹</sup>{{ $plan->price }}
                  <span class="plus-gst">+ GST</span>
              </div>

              <div class="plan-validity">
                  <i class="fas fa-clock" style="color:var(--green);font-size:.7rem;"></i>
                  &nbsp;Valid {{ $plan->duration_days }} Days
              </div>

              <hr class="plan-divider"/>

              <ul class="plan-feats">
                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      {{ $plan->download_limit }} Resume Downloads
                  </li>

                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      Full Profile Access
                  </li>

                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      Advanced Filters
                  </li>

                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      Export to Excel / PDF
                  </li>

                  @if($key == 'gold' || $key == 'platinum')
                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      Priority Support
                  </li>
                  @endif

                  @if($key == 'platinum')
                  <li>
                      <span class="feat-dot {{ $colorClass }}">
                          <i class="fas fa-check"></i>
                      </span>
                      Dedicated Manager
                  </li>
                  @endif
              </ul>

              <div class="plan-total {{ $colorClass }}">
                  Total:
                  <strong>₹{{ $plan->price + ($plan->price * 0.18) }}</strong>
                  <span style="opacity:.65;font-weight:500;">
                      (incl. 18% GST)
                  </span>
              </div>

          </div>

          @endforeach

      </div>

      <div class="gst-row">
        <i class="fas fa-circle-info" style="color:#92400e;"></i>
        Prices exclude 18% GST.&nbsp;
        <strong>Silver: ₹2,000 + ₹360 = ₹2,360</strong>&nbsp;|&nbsp;
        <strong>Gold: ₹3,000 + ₹540 = ₹3,540</strong>&nbsp;|&nbsp;
        <strong>Platinum: ₹5,000 + ₹900 = ₹5,900</strong>
      </div>

      <div class="divider-actions">
        <button class="btn-primary green" onclick="buyResumePlan()"><i class="fas fa-database"></i> Purchase Resume Access</button>
        <button class="btn-outline green"  onclick="viewDownloads()"><i class="fas fa-download"></i> View My Downloads</button>
      </div>

    </div>
  </div>

</div>{{-- /tab-resume --}}


{{-- ══════════════════════════════════════════════════════
     TAB 3 – BANNER ADVERTISEMENT
══════════════════════════════════════════════════════ --}}
  <div class="tab-panel" id="tab-banner">

    <div class="hero-banner amber">
      <div class="hero-body">
        <div class="hero-pill"><i class="fas fa-image"></i> Home Page Ad</div>
        <div class="hero-title">Advertise on the Home Page</div>
        <div class="hero-sub">Post your job ad as an image banner — mention multiple positions in one ad</div>
        <div class="hero-stats">
          <div class="hero-stat"><div class="hero-stat-val">10 Days</div><div class="hero-stat-lbl">Duration</div></div>
          <div class="hero-stat"><div class="hero-stat-val">₹2,360</div><div class="hero-stat-lbl">Total incl. GST</div></div>
          <div class="hero-stat"><div class="hero-stat-val">Home Page</div><div class="hero-stat-lbl">Placement</div></div>
        </div>
      </div>
      <div class="hero-actions">
        <button class="btn-hero amber" onclick="previewBanner()"><i class="fas fa-eye"></i> Preview Slot</button>
      </div>
    </div>

    <div class="emp-card">
      <div class="emp-card-head">
        <div class="emp-card-head-ico amber"><i class="fas fa-image"></i></div>
        <div>
          <div class="emp-card-head-title">Home Page Banner Advertisement</div>
          <div class="emp-card-head-sub">Upload an image banner — supports multiple job positions in one ad</div>
        </div>
      </div>
      <div class="emp-card-body">

        <div class="feat-tile-grid">
          <div class="feat-tile">
            <div class="feat-tile-ico amber"><i class="fas fa-image"></i></div>
            <div class="feat-tile-title">Image Banner</div>
            <div class="feat-tile-desc">Upload your ad as a high-quality PNG, JPG or WEBP image</div>
          </div>
          <div class="feat-tile">
            <div class="feat-tile-ico blue"><i class="fas fa-list-check"></i></div>
            <div class="feat-tile-title">Multi-Position</div>
            <div class="feat-tile-desc">Mention multiple job positions within a single banner image</div>
          </div>
          <div class="feat-tile">
            <div class="feat-tile-ico green"><i class="fas fa-calendar-days"></i></div>
            <div class="feat-tile-title">10-Day Exposure</div>
            <div class="feat-tile-desc">Banner stays live for 10 continuous days from activation date</div>
          </div>
        </div>

        {{-- Banner plan wide card --}}
        <div class="banner-wide sel-amber" id="bannerCard">
          <input type="radio" name="banner_plan" id="banner_10day" value="banner_10day" checked/>
          <div class="banner-wide-ico"><i class="fas fa-image"></i></div>
          <div>
            <div style="display:flex;align-items:center;gap:9px;margin-bottom:7px;">
              <span style="font-family:var(--font);font-size:.62rem;font-weight:800;color:var(--gray-400);letter-spacing:.07em;text-transform:uppercase;">Home Page Banner</span>
              <span style="background:var(--amber-light);color:var(--amber-text);font-family:var(--font);font-size:.6rem;font-weight:800;padding:2px 9px;border-radius:100px;">10 Days</span>
            </div>
            <div style="font-family:var(--font);font-size:1.7rem;font-weight:900;color:var(--gray-900);letter-spacing:-1px;line-height:1.1;">
              <sup style="font-size:.85rem;vertical-align:super;">₹</sup>2,000
              <span style="font-family:var(--body);font-size:.75rem;font-weight:500;color:var(--gray-400);">+ GST</span>
            </div>
            <ul class="plan-feats" style="margin-top:10px;display:flex;flex-wrap:wrap;gap:3px 18px;">
              <li><span class="feat-dot amber"><i class="fas fa-check"></i></span>Image-based banner ad</li>
              <li><span class="feat-dot amber"><i class="fas fa-check"></i></span>Multiple job positions</li>
              <li><span class="feat-dot amber"><i class="fas fa-check"></i></span>Home page prime placement</li>
              <li><span class="feat-dot amber"><i class="fas fa-check"></i></span>10 days continuous display</li>
              <li><span class="feat-dot amber"><i class="fas fa-check"></i></span>High-visibility slot</li>
            </ul>
          </div>
          <div style="text-align:right;flex-shrink:0;">
            <div style="font-family:var(--font);font-size:.64rem;font-weight:800;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:3px;">Total (incl. GST)</div>
            <div style="font-family:var(--font);font-size:1.35rem;font-weight:900;color:var(--amber);">₹2,360</div>
            <div style="font-size:.7rem;color:var(--gray-400);margin-top:2px;">GST: ₹360</div>
            <div style="margin-top:10px;width:24px;height:24px;border-radius:50%;background:var(--amber);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.55rem;margin-left:auto;">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </div>

        {{-- Upload + Summary --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px;align-items:start;">
          <div>
            <div style="font-family:var(--font);font-size:.8rem;font-weight:800;color:var(--gray-800);margin-bottom:9px;">
              <i class="fas fa-upload" style="color:var(--amber);margin-right:5px;"></i>Upload Banner Image
            </div>
            <label class="upload-label">
              <input type="file" accept="image/*" onchange="handleBannerUpload(this)"/>
              <i class="fas fa-cloud-upload-alt" style="font-size:1.7rem;color:var(--amber);margin-bottom:8px;"></i>
              <div style="font-family:var(--font);font-size:.8rem;font-weight:700;color:var(--amber);">Click to upload</div>
              <div style="font-size:.7rem;color:var(--gray-500);margin-top:3px;text-align:center;">PNG, JPG, WEBP · Max 5 MB · Recommended 1200×400 px</div>
            </label>
            <div id="bannerPreview" style="display:none;margin-top:10px;border-radius:10px;overflow:hidden;border:1.5px solid var(--gray-200);">
              <img id="bannerImg" src="" alt="Preview" style="width:100%;display:block;"/>
            </div>
          </div>
          <div>
            <div style="font-family:var(--font);font-size:.8rem;font-weight:800;color:var(--gray-800);margin-bottom:9px;">
              <i class="fas fa-receipt" style="color:var(--amber);margin-right:5px;"></i>Order Summary
            </div>
            <div class="summary-box">
              <div class="summary-row"><span class="s-lbl">Plan</span><span class="s-val">Home Page Banner</span></div>
              <div class="summary-row"><span class="s-lbl">Duration</span><span class="s-val">10 Days</span></div>
              <div class="summary-row"><span class="s-lbl">Base Price</span><span class="s-val">₹2,000</span></div>
              <div class="summary-row"><span class="s-lbl">GST (18%)</span><span class="s-val" style="color:var(--amber);">₹360</span></div>
              <div class="summary-row s-total" style="padding-top:10px;margin-top:4px;border-top:2px solid var(--gray-200);">
                <span class="s-lbl">Total Payable</span>
                <span class="s-val">₹2,360</span>
              </div>
            </div>
          </div>
        </div>

        <div class="gst-row" style="background:#fff7ed;border-color:#fed7aa;">
          <i class="fas fa-circle-info" style="color:#92400e;"></i>
          Banner: ₹2,000 + 18% GST (₹360) = <strong>₹2,360 total.</strong>&nbsp; Goes live within 24 hours of payment.
        </div>

        <div class="divider-actions">
          <button class="btn-primary amber" onclick="buyBannerPlan()"><i class="fas fa-image"></i> Purchase Banner Ad</button>
          <button class="btn-outline amber"  onclick="previewBanner()"><i class="fas fa-eye"></i> Preview Placement</button>
        </div>

      </div>
    </div>

  </div>{{-- /tab-banner --}}


{{-- ══════════════════════════════════════════════════════
     TAB 4 – INVOICE HISTORY
══════════════════════════════════════════════════════ --}}
<div class="tab-panel" id="tab-invoices">

  <div class="emp-card">
    <div class="emp-card-head">
      <div class="emp-card-head-ico blue"><i class="fas fa-file-invoice"></i></div>
      <div>
        <div class="emp-card-head-title">Invoice History</div>
        <div class="emp-card-head-sub">All past transactions across Job Posting, Resume DB &amp; Banner Ad</div>
      </div>
      <div style="margin-left:auto;">
        <button class="btn-sm"><i class="fas fa-filter"></i> Filter</button>
      </div>
    </div>
    <div class="emp-card-body" style="padding:0;">
      <div class="emp-table-wrap">
        <table class="emp-table">
          <thead>
            <tr>
              <th>Invoice</th>
              <th>Module</th>
              <th>Plan</th>
              <th>Base Price</th>
              <th>GST (18%)</th>
              <th>Total Paid</th>
              <th>Payment ID</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php
            $invoices = [
              ['inv'=>'#INV-2025-031','module'=>'Job Posting','plan'=>'30 Days Plan',  'base'=>'₹1,000','gst'=>'₹180','total'=>'₹1,180','pid'=>'pay_OsK89AbCdEf','date'=>'11 Mar 2025','mod'=>'blue'],
              ['inv'=>'#INV-2025-028','module'=>'Resume DB',  'plan'=>'Gold Plan',     'base'=>'₹3,000','gst'=>'₹540','total'=>'₹3,540','pid'=>'pay_QpT45MnBvCx','date'=>'05 Mar 2025','mod'=>'green'],
              ['inv'=>'#INV-2025-020','module'=>'Banner Ad',  'plan'=>'Home Page 10D', 'base'=>'₹2,000','gst'=>'₹360','total'=>'₹2,360','pid'=>'pay_RsU12WxYzAb','date'=>'18 Feb 2025','mod'=>'amber'],
              ['inv'=>'#INV-2025-012','module'=>'Job Posting','plan'=>'15 Days Plan',  'base'=>'₹600',  'gst'=>'₹108','total'=>'₹708',  'pid'=>'pay_NpJ72XyZwVu','date'=>'10 Feb 2025','mod'=>'blue'],
              ['inv'=>'#INV-2025-005','module'=>'Resume DB',  'plan'=>'Silver Plan',   'base'=>'₹2,000','gst'=>'₹360','total'=>'₹2,360','pid'=>'pay_LkM38PqRsTu','date'=>'02 Jan 2025','mod'=>'green'],
              ['inv'=>'#INV-2024-089','module'=>'Job Posting','plan'=>'30 Days Plan',  'base'=>'₹1,000','gst'=>'₹180','total'=>'₹1,180','pid'=>'pay_MkL58AbCfGh','date'=>'15 Dec 2024','mod'=>'blue'],
            ];
            $mod_icon = ['Job Posting'=>'fa-briefcase','Resume DB'=>'fa-database','Banner Ad'=>'fa-image'];
            @endphp
            @foreach($invoices as $inv)
            <tr>
              <td><strong style="font-family:var(--font);">{{ $inv['inv'] }}</strong></td>
              <td><span class="badge badge-{{ $inv['mod'] }}"><i class="fas {{ $mod_icon[$inv['module']] }}"></i> {{ $inv['module'] }}</span></td>
              <td style="font-family:var(--font);font-weight:600;">{{ $inv['plan'] }}</td>
              <td>{{ $inv['base'] }}</td>
              <td style="color:var(--amber);font-family:var(--font);font-weight:700;">{{ $inv['gst'] }}</td>
              <td><strong style="color:var(--green);font-family:var(--font);">{{ $inv['total'] }}</strong></td>
              <td style="font-family:monospace;font-size:.72rem;color:var(--gray-500);">{{ $inv['pid'] }}</td>
              <td>{{ $inv['date'] }}</td>
              <td><span class="badge badge-green"><i class="fas fa-check"></i> Paid</span></td>
              <td><a href="#" class="btn-sm"><i class="fas fa-download"></i> PDF</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>{{-- /tab-invoices --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ─── TAB SWITCH ─── */
function switchTab(btn, tab) {
  document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
  document.querySelectorAll('.billing-tab').forEach(function(b){ b.classList.remove('active'); });
  document.getElementById('tab-' + tab).classList.add('active');
  btn.classList.add('active');
}

/* ─── GENERIC PLAN SELECTOR ─── */
var planMeta = {
  jp: {
    ids: [
      @foreach($jobPlans as $plan)
        '{{ $plan->id }}',
      @endforeach
    ]
  },
  rdb: { ids: ['silver','gold','platinum'] },
};
function selectPlan(prefix, id, selClass) {
  var meta = planMeta[prefix];
  if (!meta) return;
  meta.ids.forEach(function(gid){
    var c = document.getElementById(prefix + '_' + gid + 'Card');
    if (c) c.classList.remove('sel-blue','sel-green','sel-purple','sel-amber');
  });
  var target = document.getElementById(prefix + '_' + id + 'Card');
  if (target) target.classList.add(selClass);
  var radio = document.getElementById(prefix + '_' + id);
  if (radio) radio.checked = true;
}

/* ─── JOB POSTING ─── */
// function buyJobPlan() {
//   var sel = document.querySelector('input[name="job_plan"]:checked');
//   if (!sel) return alert('Please select a plan.');
//   var info = sel.value === '15_day' ? '15 Days Plan – ₹708 (incl. GST)' : '30 Days Plan – ₹1,180 (incl. GST)';
//   if (confirm('Proceed to payment for ' + info + '?')) {
//     window.location.href = '{{ route("employer.billing.purchase") }}?plan=' + sel.value;
//   }
// }

function buyJobPlan() {
    let selected = document.querySelector('input[name="job_plan"]:checked');

    if (!selected) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Please select a plan!'
        });
        return;
    }

    let planId = selected.value;

    fetch('{{ url("/buy-plan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ plan_id: planId })
    })
    .then(async res => {
        let data = await res.json();

        if (!res.ok) {
            throw data;
        }

        return data;
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Success 🎉',
            text: data.message,
            confirmButtonColor: '#1a56db'
        }).then(() => {
            location.reload(); // refresh after OK
        });
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Failed ❌',
            text: err.message || 'Something went wrong!',
            confirmButtonColor: '#dc2626'
        });
    });
}

function renewJobPlan() {
  if (confirm('Renew current 30 Days Plan for ₹1,180 (incl. GST)?')) {
    window.location.href = '{{ route("employer.billing.purchase") }}?plan=30_day&renew=1';
  }
}

/* ─── RESUME DB ─── */
// function buyResumePlan() {
//   var sel = document.querySelector('input[name="resume_plan"]:checked');
//   if (!sel) return alert('Please select a plan.');
//   var prices = { silver:'₹2,360', gold:'₹3,540', platinum:'₹5,900' };
//   var name = sel.value.charAt(0).toUpperCase() + sel.value.slice(1) + ' Plan – ' + prices[sel.value] + ' (incl. GST)';
//   if (confirm('Proceed to payment for ' + name + '?')) {
//     window.location.href = '{{ route("employer.billing.purchase") }}?plan=resume_' + sel.value;
//   }
// }
function viewDownloads() {
  window.location.href = '{{ route("employer.resume") }}';
}

/* ─── BANNER ─── */
function buyBannerPlan() {

    let fileInput = document.querySelector('input[type="file"]');
    let file = fileInput.files[0];

    if (!file) {
        Swal.fire('Error', 'Upload banner image', 'error');
        return;
    }

    let tokenElement = document.querySelector('meta[name="csrf-token"]');

    if (!tokenElement) {
        Swal.fire('Error', 'CSRF token missing', 'error');
        return;
    }

    let formData = new FormData();
    formData.append('banner_plan_id', 1);
    formData.append('banner_image', file);

    fetch("{{ route('banner.purchase') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': tokenElement.getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire('Success', data.message, 'success');
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Something went wrong', 'error');
    });
}
function previewBanner() {
  alert('Your banner image will appear in the featured slot on the home page for 10 days from activation.');
}
function handleBannerUpload(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('bannerImg').src = e.target.result;
      document.getElementById('bannerPreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function buyResumePlan() {
    let selected = document.querySelector('input[name="resume_plan"]:checked');

    if (!selected) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Please select a plan!'
        });
        return;
    }

    let planId = selected.value;

    fetch('{{ url("/buy-resume-plan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ plan_id: planId })
    })
    .then(async res => {
        let data = await res.json();

        if (!res.ok) throw data;

        return data;
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Success 🎉',
            text: data.message
        }).then(() => location.reload());
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Failed ❌',
            text: err.message || 'Something went wrong!'
        });
    });
}
</script>
@endpush