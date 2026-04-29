{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/notifications.blade.php
     LinearJobs – Notifications Module · Ultra Premium Design
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Notifications')
@section('breadcrumb','Notifications')
@php $activeNav = 'notifications'; @endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════
   TOKENS
══════════════════════════════════════════════ */
:root{
  --p900:#1e3a8a;--p800:#1e40af;--p700:#1d4ed8;
  --p600:#2563eb;--p500:#3b82f6;--p400:#60a5fa;
  --p200:#bfdbfe;--p100:#dbeafe;--p50:#eff6ff;
  --g700:#047857;--g600:#059669;--g500:#10b981;
  --g200:#a7f3d0;--g100:#d1fae5;--g50:#ecfdf5;
  --a700:#b45309;--a600:#d97706;--a500:#f59e0b;
  --a200:#fde68a;--a100:#fef3c7;--a50:#fffbeb;
  --r700:#b91c1c;--r600:#dc2626;--r500:#ef4444;
  --r200:#fecaca;--r100:#fee2e2;--r50:#fef2f2;
  --pu700:#6d28d9;--pu600:#7c3aed;--pu500:#8b5cf6;
  --pu100:#ede9fe;--pu50:#f5f3ff;
  --t600:#0891b2;--t500:#06b6d4;--t100:#cffafe;--t50:#ecfeff;
  --ink:#0f172a;--ink2:#1e293b;--ink3:#334155;
  --ink4:#475569;--ink5:#64748b;--ink6:#94a3b8;
  --line:#e2e8f0;--line2:#f1f5f9;--surf:#f8fafc;--white:#ffffff;
  --fh:'Sora',sans-serif;--fb:'DM Sans',sans-serif;
  --sh-xs:0 1px 2px rgba(0,0,0,.05);
  --sh:0 1px 4px rgba(15,23,42,.06),0 4px 14px rgba(15,23,42,.06);
  --sh-md:0 4px 18px rgba(15,23,42,.10);
  --sh-lg:0 8px 38px rgba(15,23,42,.13);
  --sh-blue:0 4px 16px rgba(37,99,235,.28);
  --sh-blue-lg:0 8px 32px rgba(37,99,235,.38);
  --ease:.22s cubic-bezier(.4,0,.2,1);
  --spring:.34s cubic-bezier(.34,1.4,.64,1);
}
*,*::before,*::after{box-sizing:border-box;}

/* ══════════════════════════════════════════════
   PAGE SHELL
══════════════════════════════════════════════ */
.nf-root{
  min-height:100vh;
  background:
    radial-gradient(ellipse 65% 35% at 0% 0%,   rgba(37,99,235,.07) 0%,transparent 55%),
    radial-gradient(ellipse 50% 30% at 100% 15%, rgba(109,40,217,.05) 0%,transparent 55%),
    #eef2f8;
  padding-bottom:60px;
}
.nf-wrap{max-width:1200px;margin:0 auto;}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.nf-hero{
  background:linear-gradient(138deg,#0f2d8a 0%,#1e40af 38%,#2563eb 72%,#3b82f6 100%);
  border-radius:22px;padding:32px 38px 88px;
  position:relative;overflow:hidden;
  box-shadow:var(--sh-blue-lg),0 2px 6px rgba(0,0,0,.12);
}
.nf-hero-dots{position:absolute;inset:0;pointer-events:none;background-image:radial-gradient(circle,rgba(255,255,255,.09) 1px,transparent 1px);background-size:20px 20px;}
.nf-hero-ring{position:absolute;border-radius:50%;border:1px solid rgba(255,255,255,.08);pointer-events:none;}
.nf-hero-r1{width:380px;height:380px;top:-100px;right:-60px;}
.nf-hero-r2{width:210px;height:210px;bottom:-65px;left:24px;border-color:rgba(255,255,255,.05);}
.nf-hero-inner{position:relative;z-index:2;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;}

.nf-hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.22);border-radius:100px;padding:4px 14px;font-family:var(--fh);font-size:.67rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:rgba(255,255,255,.88);margin-bottom:12px;}
.nf-hero-title{font-family:var(--fh);font-size:clamp(1.4rem,3vw,2rem);font-weight:900;color:#fff;letter-spacing:-.5px;line-height:1.1;margin-bottom:7px;}
.nf-hero-sub{font-family:var(--fb);font-size:.88rem;color:rgba(255,255,255,.68);line-height:1.6;max-width:440px;}

.nf-hero-stats{display:flex;gap:10px;flex-wrap:wrap;margin-top:18px;}
.nf-hstat{
  background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.18);
  border-radius:12px;padding:11px 20px;
  display:flex;align-items:center;gap:12px;
}
.nf-hstat-ico{width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:.82rem;color:#fff;flex-shrink:0;}
.nf-hstat-n{font-family:var(--fh);font-size:1.25rem;font-weight:900;color:#fff;line-height:1;}
.nf-hstat-l{font-family:var(--fb);font-size:.7rem;color:rgba(255,255,255,.62);margin-top:2px;}

.nf-hero-btns{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0;}
.nf-hero-btn{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.22);border-radius:10px;padding:9px 18px;font-family:var(--fh);font-size:.8rem;font-weight:700;color:#fff;cursor:pointer;transition:all var(--ease);white-space:nowrap;}
.nf-hero-btn:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.35);}
.nf-hero-btn.danger{background:rgba(239,68,68,.18);border-color:rgba(239,68,68,.3);color:#fca5a5;}
.nf-hero-btn.danger:hover{background:rgba(239,68,68,.28);border-color:rgba(239,68,68,.5);}

/* ══════════════════════════════════════════════
   CONTROL BAR
══════════════════════════════════════════════ */
.nf-bar-wrap{margin:-44px 0 0;position:relative;z-index:20;}
.nf-bar{
  background:var(--white);border-radius:18px;box-shadow:var(--sh-lg);
  padding:16px 22px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;
}

.nf-search-wrap{position:relative;flex:1;min-width:180px;}
.nf-search-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--ink6);font-size:.78rem;pointer-events:none;z-index:1;transition:color var(--ease);}
.nf-search{width:100%;border:2px solid var(--line);border-radius:11px;padding:10px 14px 10px 38px;font-family:var(--fb);font-size:.88rem;font-weight:500;color:var(--ink);background:var(--surf);outline:none;transition:all var(--ease);}
.nf-search:focus{border-color:var(--p500);box-shadow:0 0 0 4px rgba(59,130,246,.12);background:var(--white);}
.nf-search-wrap:focus-within .nf-search-ico{color:var(--p600);}

.nf-bar-divider{width:1.5px;height:36px;background:var(--line);border-radius:2px;flex-shrink:0;}

/* ══════════════════════════════════════════════
   TYPE TABS
══════════════════════════════════════════════ */
.nf-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-top:22px;}
.nf-tab{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 18px;border-radius:100px;
  font-family:var(--fh);font-size:.78rem;font-weight:700;
  border:2px solid var(--line);background:var(--white);color:var(--ink5);
  cursor:pointer;transition:all var(--ease);box-shadow:var(--sh-xs);
  white-space:nowrap;
}
.nf-tab i{font-size:.72rem;flex-shrink:0;}
.nf-tab-badge{
  min-width:20px;height:20px;padding:0 6px;
  border-radius:100px;font-family:var(--fh);font-size:.65rem;font-weight:900;
  line-height:20px;text-align:center;
  background:var(--line2);color:var(--ink5);
  transition:all var(--ease);display:inline-block;
}
.nf-tab:hover{border-color:var(--ink4);color:var(--ink2);}

/* Active variants */
.nf-tab.t-all.on   {background:linear-gradient(135deg,var(--p800),var(--p500));border-color:transparent;color:#fff;box-shadow:var(--sh-blue);}
.nf-tab.t-unread.on{background:linear-gradient(135deg,var(--r700),var(--r500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(185,28,28,.24);}
.nf-tab.t-app.on   {background:linear-gradient(135deg,#0369a1,var(--p500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(3,105,161,.28);}
.nf-tab.t-alert.on {background:linear-gradient(135deg,var(--a700),var(--a500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(180,83,9,.24);}
.nf-tab.t-plan.on  {background:linear-gradient(135deg,var(--g700),var(--g500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(4,120,87,.24);}
.nf-tab.t-admin.on {background:linear-gradient(135deg,var(--pu700),var(--pu500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(109,40,217,.24);}
.nf-tab.on .nf-tab-badge{background:rgba(255,255,255,.25);color:#fff;}

/* ══════════════════════════════════════════════
   RESULTS BAR
══════════════════════════════════════════════ */
.nf-results-bar{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:10px;margin:18px 0 12px;
}
.nf-results-txt{font-family:var(--fb);font-size:.82rem;color:var(--ink5);}
.nf-results-txt strong{font-family:var(--fh);font-weight:800;color:var(--ink2);}
.nf-mark-all{display:inline-flex;align-items:center;gap:6px;font-family:var(--fh);font-size:.78rem;font-weight:700;color:var(--p600);background:var(--p50);border:1.5px solid var(--p200);border-radius:9px;padding:7px 16px;cursor:pointer;transition:all var(--ease);}
.nf-mark-all:hover{background:var(--p100);border-color:var(--p400);}

/* ══════════════════════════════════════════════
   NOTIFICATION CARD
══════════════════════════════════════════════ */
.nf-card{
  background:var(--white);border:1.5px solid var(--line);
  border-radius:16px;padding:0;
  margin-bottom:10px;
  transition:all var(--ease);cursor:pointer;
  position:relative;overflow:hidden;
  display:flex;align-items:stretch;
}
.nf-card:hover{border-color:var(--p200);box-shadow:var(--sh-md);transform:translateY(-1px);}

/* Unread styles */
.nf-card.unread{
  background:linear-gradient(135deg,#fafcff,#f0f6ff);
  border-color:rgba(37,99,235,.22);
}
.nf-card.unread:hover{border-color:var(--p400);}

/* Left accent bar */
.nf-card-bar{width:4px;border-radius:4px 0 0 4px;flex-shrink:0;transition:background var(--ease);}
.nf-card.unread  .nf-card-bar{background:linear-gradient(180deg,var(--p600),var(--p400));}
.nf-card.type-application .nf-card-bar{background:linear-gradient(180deg,#0369a1,var(--p500));}
.nf-card.type-alert       .nf-card-bar{background:linear-gradient(180deg,var(--a700),var(--a500));}
.nf-card.type-plan        .nf-card-bar{background:linear-gradient(180deg,var(--g700),var(--g500));}
.nf-card.type-admin       .nf-card-bar{background:linear-gradient(180deg,var(--pu700),var(--pu500));}
.nf-card.type-shortlist   .nf-card-bar{background:linear-gradient(180deg,var(--g700),var(--g500));}
.nf-card.type-system      .nf-card-bar{background:linear-gradient(180deg,var(--t600),var(--t500));}
.nf-card:not(.unread) .nf-card-bar{background:var(--line);}

/* Inner content wrapper */
.nf-card-inner{display:flex;align-items:flex-start;gap:16px;padding:18px 20px;flex:1;min-width:0;}

/* Type icon */
.nf-ico{
  width:46px;height:46px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:.92rem;flex-shrink:0;
  box-shadow:var(--sh-xs);
}
.ni-app  {background:linear-gradient(135deg,#dbeafe,var(--p50));color:var(--p700);border:1.5px solid var(--p200);}
.ni-alert{background:linear-gradient(135deg,var(--a100),var(--a50));color:var(--a700);border:1.5px solid var(--a200);}
.ni-plan {background:linear-gradient(135deg,var(--g100),var(--g50));color:var(--g700);border:1.5px solid var(--g200);}
.ni-admin{background:linear-gradient(135deg,var(--pu100),var(--pu50));color:var(--pu700);border:1.5px solid #ddd6fe;}
.ni-sl   {background:linear-gradient(135deg,var(--a100),var(--a50));color:var(--a700);border:1.5px solid var(--a200);}
.ni-sys  {background:linear-gradient(135deg,var(--t100),var(--t50));color:var(--t600);border:1.5px solid #a5f3fc;}

/* Body */
.nf-body{flex:1;min-width:0;}
.nf-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:5px;}
.nf-title-wrap{display:flex;align-items:center;gap:8px;flex-wrap:wrap;flex:1;min-width:0;}
.nf-title{font-family:var(--fh);font-size:.9rem;font-weight:800;color:var(--ink);letter-spacing:-.15px;line-height:1.3;}
.nf-unread-dot{width:8px;height:8px;border-radius:50%;background:var(--p600);flex-shrink:0;box-shadow:0 0 0 3px rgba(37,99,235,.16);animation:nd-pulse 2s infinite;}
@keyframes nd-pulse{0%,100%{opacity:1}50%{opacity:.4}}

.nf-type-chip{display:inline-flex;align-items:center;gap:4px;font-family:var(--fh);font-size:.62rem;font-weight:800;letter-spacing:.05em;text-transform:uppercase;border-radius:100px;padding:2px 9px;flex-shrink:0;}
.nc-app  {background:var(--p100);color:var(--p700);}
.nc-alert{background:var(--a100);color:var(--a700);}
.nc-plan {background:var(--g100);color:var(--g700);}
.nc-admin{background:var(--pu100);color:var(--pu700);}
.nc-sl   {background:var(--g100);color:var(--g700);}
.nc-sys  {background:var(--t100);color:var(--t600);}

.nf-time{font-family:var(--fb);font-size:.7rem;color:var(--ink6);white-space:nowrap;flex-shrink:0;display:flex;align-items:center;gap:4px;margin-top:2px;}
.nf-time i{font-size:.62rem;}

.nf-msg{font-family:var(--fb);font-size:.82rem;font-weight:500;color:var(--ink4);line-height:1.6;margin-bottom:12px;}

/* Footer */
.nf-foot{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}

/* Action chips */
.nf-act-row{display:flex;align-items:center;gap:7px;flex-wrap:wrap;}
.nf-act{
  display:inline-flex;align-items:center;gap:5px;
  border-radius:8px;padding:6px 13px;
  font-family:var(--fh);font-size:.74rem;font-weight:700;
  border:1.5px solid var(--line);background:var(--white);
  color:var(--ink4);cursor:pointer;transition:all var(--ease);
  white-space:nowrap;
}
.nf-act:hover{border-color:var(--ink4);color:var(--ink2);transform:translateY(-1px);}
.nf-act.primary{background:linear-gradient(135deg,var(--p700),var(--p500));color:#fff;border-color:transparent;box-shadow:var(--sh-blue);}
.nf-act.primary:hover{transform:translateY(-1px);box-shadow:var(--sh-blue-lg);}
.nf-act.green{background:var(--g50);border-color:var(--g200);color:var(--g700);}
.nf-act.green:hover{background:var(--g100);border-color:var(--g500);}
.nf-act.red{background:var(--r50);border-color:var(--r200);color:var(--r700);}
.nf-act.red:hover{background:var(--r100);border-color:var(--r500);}
.nf-act.ghost{color:var(--ink5);}
.nf-act.ghost:hover{color:var(--ink2);}

/* Trash icon btn */
.nf-del{
  width:32px;height:32px;border-radius:9px;
  display:flex;align-items:center;justify-content:center;
  border:1.5px solid var(--line);background:var(--white);
  color:var(--ink6);font-size:.72rem;cursor:pointer;
  transition:all var(--ease);flex-shrink:0;
}
.nf-del:hover{border-color:var(--r200);color:var(--r600);background:var(--r50);transform:translateY(-1px);}

/* ══════════════════════════════════════════════
   DATE GROUP HEADER
══════════════════════════════════════════════ */
.nf-date-grp{
  display:flex;align-items:center;gap:12px;
  margin:22px 0 12px;
}
.nf-date-grp-line{flex:1;height:1.5px;background:linear-gradient(90deg,transparent,var(--line) 20%,var(--line) 80%,transparent);}
.nf-date-grp-lbl{
  display:flex;align-items:center;gap:7px;
  font-family:var(--fh);font-size:.68rem;font-weight:800;
  color:var(--ink5);letter-spacing:.07em;text-transform:uppercase;white-space:nowrap;
}

/* ══════════════════════════════════════════════
   EMPTY STATE
══════════════════════════════════════════════ */
.nf-empty{
  text-align:center;padding:60px 24px;
  border:2px dashed var(--line);border-radius:18px;
  background:linear-gradient(135deg,var(--surf),#f3f5f9);
}
.nf-empty-ico{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,var(--line2),var(--surf));border:1.5px solid var(--line);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--ink6);margin:0 auto 15px;}
.nf-empty-t{font-family:var(--fh);font-size:.96rem;font-weight:800;color:var(--ink4);margin-bottom:5px;}
.nf-empty-s{font-family:var(--fb);font-size:.82rem;color:var(--ink6);}

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media(max-width:640px){
  .nf-hero{padding:24px 20px 82px;}
  .nf-bar{flex-direction:column;align-items:stretch;}
  .nf-card-inner{padding:15px 16px;gap:12px;}
  .nf-ico{width:40px;height:40px;font-size:.82rem;}
  .nf-act-row{flex-wrap:wrap;}
  .nf-hstat{flex:1;}
}
</style>
@endpush

@section('content')
@php


$alerts   = 1;

$groups = ['today'=>'Today','yesterday'=>'Yesterday','older'=>'Earlier'];
@endphp

<div class="nf-root">
<div class="nf-wrap">

  {{-- ══ HERO ══ --}}
  <div class="nf-hero">
    <div class="nf-hero-dots"></div>
    <div class="nf-hero-ring nf-hero-r1"></div>
    <div class="nf-hero-ring nf-hero-r2"></div>
    <div class="nf-hero-inner">
      <div>
        <div class="nf-hero-badge"><i class="fas fa-bell"></i> Notifications Centre</div>
        <div class="nf-hero-title">Your Notifications</div>
        <div class="nf-hero-sub">Stay on top of applications, plan alerts, and important updates</div>
        <div class="nf-hero-stats">
          <div class="nf-hstat">
            <div class="nf-hstat-ico"><i class="fas fa-bell"></i></div>
            <div><div class="nf-hstat-n">{{ $all }}</div><div class="nf-hstat-l">Total</div></div>
          </div>
          <div class="nf-hstat">
            <div class="nf-hstat-ico"><i class="fas fa-circle-dot"></i></div>
            <div><div class="nf-hstat-n">{{ $unread }}</div><div class="nf-hstat-l">Unread</div></div>
          </div>
          <div class="nf-hstat">
            <div class="nf-hstat-ico"><i class="fas fa-file-user"></i></div>
            <div><div class="nf-hstat-n">{{ $application }}</div><div class="nf-hstat-l">Applications</div></div>
          </div>
          <div class="nf-hstat">
            <div class="nf-hstat-ico"><i class="fas fa-triangle-exclamation"></i></div>
            <div><div class="nf-hstat-n">{{ $alerts }}</div><div class="nf-hstat-l">Alerts</div></div>
          </div>
        </div>
      </div>
      <div class="nf-hero-btns">
        <button class="nf-hero-btn" onclick="nfMarkAll()"><i class="fas fa-check-double"></i> Mark All Read</button>
        <button class="nf-hero-btn danger" onclick="nfClearAll()"><i class="fas fa-trash"></i> Clear All</button>
      </div>
    </div>
  </div>

  {{-- ══ CONTROL BAR ══ --}}
  <div class="nf-bar-wrap">
    <div class="nf-bar">
      <div class="nf-search-wrap">
        <i class="fas fa-magnifying-glass nf-search-ico"></i>
        <input type="text" class="nf-search" placeholder="Search notifications…" oninput="nfSearch(this.value)" />
      </div>
      <div class="nf-bar-divider"></div>
      <span style="font-family:var(--fh);font-size:.78rem;font-weight:700;color:var(--ink5);white-space:nowrap;flex-shrink:0;">
        <i class="fas fa-clock" style="color:var(--p500);margin-right:4px;"></i>
        Last updated: <strong style="color:var(--ink3);">Just now</strong>
      </span>
      <button class="nf-hero-btn" style="background:var(--p50);border-color:var(--p200);color:var(--p700);font-size:.78rem;padding:8px 16px;" onclick="location.reload()">
        <i class="fas fa-rotate-right"></i> Refresh
      </button>
    </div>
  </div>

  {{-- ══ TYPE TABS ══ --}}
  <div class="nf-tabs">
    <button class="nf-tab t-all on" onclick="nfTab('all',this)">
      <i class="fas fa-bell"></i> All
      <span class="nf-tab-badge">{{ $all }}</span>
    </button>
    <button class="nf-tab t-unread" onclick="nfTab('unread',this)">
      <i class="fas fa-circle-dot"></i> Unread
      <span class="nf-tab-badge">{{ $unread }}</span>
    </button>
    <button class="nf-tab t-app" onclick="nfTab('application',this)">
      <i class="fas fa-file-user"></i> Applications
      <span class="nf-tab-badge">{{ $application }}</span>
    </button>
    <button class="nf-tab t-alert" onclick="nfTab('alert',this)">
      <i class="fas fa-triangle-exclamation"></i> Alerts
      <span class="nf-tab-badge">{{ $alerts }}</span>
    </button>
    {{-- <button class="nf-tab t-plan" onclick="nfTab('shortlist',this)">
      <i class="fas fa-star"></i> Shortlisted
    </button> --}}
    <button class="nf-tab t-admin" onclick="nfTab('admin',this)">
      <i class="fas fa-shield-check"></i> Admin
      <span class="nf-tab-badge">{{ $admin }}</span>
    </button>
  </div>

  {{-- ══ RESULTS BAR ══ --}}
  <div class="nf-results-bar">
    <div class="nf-results-txt">
      Showing <strong id="nfCount">{{ $all }}</strong> notifications
      &nbsp;·&nbsp; <span style="color:var(--r600);font-weight:700;">{{ $unread }} unread</span>
    </div>
    <button class="nf-mark-all" onclick="nfMarkAll()">
      <i class="fas fa-check-double"></i> Mark All as Read
    </button>
  </div>

  {{-- ══ NOTIFICATION LIST ══ --}}
  <div id="nfList">
    


  </div>{{-- /nfList --}}

  {{-- ══ EMPTY STATE ══ --}}
  <div class="nf-empty" id="nfEmpty" style="display:none;">
    <div class="nf-empty-ico"><i class="fas fa-bell-slash"></i></div>
    <div class="nf-empty-t">No notifications found</div>
    <div class="nf-empty-s">You're all caught up — nothing to show here</div>
  </div>

</div>{{-- /nf-wrap --}}
</div>{{-- /nf-root --}}
@endsection

@push('scripts')
<script>
(function(){
'use strict';

var activeType   = 'all';
var activeSearch = '';

/* ── Helpers ── */
function allCards(){
  return document.querySelectorAll('.nf-card');
}
function updateCount(){
  var vis = 0;
  allCards().forEach(function(c){ if(c.style.display !== 'none') vis++; });
  var ct = document.getElementById('nfCount');
  if(ct) ct.textContent = vis;
  var em = document.getElementById('nfEmpty');
  if(em) em.style.display = vis === 0 ? 'block' : 'none';

  // Hide date group headers if all items in group hidden
  document.querySelectorAll('.nf-date-grp').forEach(function(grp){
    var gk = grp.getAttribute('data-group');
    var anyVis = false;
    allCards().forEach(function(c){
      if(c.getAttribute('data-group') === gk && c.style.display !== 'none') anyVis = true;
    });
    grp.style.display = anyVis ? '' : 'none';
  });
}
function applyFilters(){
  allCards().forEach(function(c){
    var type  = c.getAttribute('data-type')  || '';
    var read  = c.getAttribute('data-read')  || '1';
    var srch  = c.getAttribute('data-search')|| '';
    var ok =
      (activeType === 'all' || (activeType === 'unread' ? read === '0' : type === activeType)) &&
      (activeSearch === '' || srch.includes(activeSearch));
    c.style.display = ok ? '' : 'none';
  });
  updateCount();
}

/* ── Tab ── */
window.nfTab = function(type, btn){
  document.querySelectorAll('.nf-tab').forEach(function(b){ b.classList.remove('on'); });
  btn.classList.add('on');
  activeType = type;
  applyFilters();
};

/* ── Search ── */
window.nfSearch = function(q){
  activeSearch = q.trim().toLowerCase();
  applyFilters();
};

/* ── Clear All ── */


})();
function loadNotifications() {

    let filter = new URLSearchParams(window.location.search).get('filter');

    $.ajax({
        url: "{{ route('notifications.list') }}",
        type: "GET",

        data: {
            filter: filter
        },

        success: function (res) {

            if (res.status) {

                renderNotifications(res.data);
            }
        },

        error: function () {

            $("#nfList").html(`
                <div style="padding:20px;">
                    Failed to load notifications
                </div>
            `);
        }
    });
}

$(document).ready(function () {
    loadNotifications();
});
function renderNotifications(notifs) {
    let container = $("#nfList");
    container.html("");

    let groups = {
        today: "Today",
        older: "Earlier"
    };

    Object.keys(groups).forEach(gKey => {

        let grpItems = notifs.filter(n => n.group === gKey);

        if (grpItems.length > 0) {

            // Group Header
            container.append(`
                <div class="nf-date-grp" data-group="${gKey}">
                    <div class="nf-date-grp-line"></div>
                    <div class="nf-date-grp-lbl">
                        <i class="fas fa-calendar-day"></i>
                        ${groups[gKey]}
                    </div>
                    <div class="nf-date-grp-line"></div>
                </div>
            `);

            grpItems.forEach(n => {

                let actionsHtml = "";

              n.actions.forEach((act, idx) => {
                  actionsHtml += `
                      <button class="nf-act ${act.cls}" onclick="handleActionClick(${n.type_id})">
                          <i class="${act.ico}"></i> ${act.lbl}
                      </button>
                  `;  
              });
                
                if (n.read != 1) {
                    actionsHtml += `
                        <button class="nf-act ghost" onclick="nfMarkRead(${n.id})">
                            <i class="fas fa-check"></i> Mark Read
                        </button>
                    `;
                }else{
                  actionsHtml += `<button class="nf-act ghost" >
                            <i class="fas fa-check"></i> Readed
                        </button>`;
                }
                let readClass = n.read == 1 ? 'read' : 'unread';

                container.append(`
                    <div class="nf-card ${readClass}  type-${n.type}"
                        id="nf_${n.id}"
                        data-type="${n.type}"
                        data-read="${n.read ? 1 : 0}"
                        data-group="${n.group}"
                        data-search="${(n.title + ' ' + n.msg).toLowerCase()}"
                        onclick="nfMarkRead(${n.id})">

                        <div class="nf-card-bar"></div>

                        <div class="nf-card-inner">

                            <div class="nf-ico ${n.icls}">
                                <i class="${n.ico}"></i>
                            </div>

                            <div class="nf-body">

                                <div class="nf-head">
                                    <div class="nf-title-wrap">
                                        ${!n.read ? '<span class="nf-unread-dot"></span>' : ''}
                                        <div class="nf-title">${n.title}</div>
                                        <span class="nf-type-chip ${n.tcls}">
                                            <i class="${n.ico}" style="font-size:.58rem;"></i>
                                            ${n.tlbl}
                                        </span>
                                    </div>
                                    <div class="nf-time">
                                        <i class="fas fa-clock"></i> ${n.date}
                                    </div>
                                </div>

                                <div class="nf-msg">${n.msg}</div>

                                <div class="nf-foot" onclick="event.stopPropagation()">
                                    <div class="nf-act-row">
                                        ${actionsHtml}
                                    </div>
                                    <button class="nf-del" onclick="nfDelete(${n.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                `);
            });
        }
    });
}

const markReadUrl = "{{ route('notifications.markRead', ':id') }}";
function nfMarkRead(notificationId) {
    let url = markReadUrl.replace(':id', notificationId);
    $.ajax({
        url: url, // Laravel route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}" // include CSRF token
        },
        success: function(res) {
            if(res.status) {
                // Update the card UI immediately
                let card = $(`#nf_${notificationId}`);
                card.removeClass('unread');
                card.attr('data-read', 1);
                card.find('.nf-unread-dot').remove();
                
                // Remove the "Mark Read" button
                card.find('.nf-act.ghost').remove();

                // Optionally update unread badge
                let unreadCountElem = $('.t-unread .nf-tab-badge');
                let unreadCount = parseInt(unreadCountElem.text());
                unreadCountElem.text(unreadCount - 1 >= 0 ? unreadCount - 1 : 0);
            } else {
                alert('Failed to mark as read');
            }
        },
        error: function(err) {
            console.error(err);
            alert('Error marking notification as read');
        }
    });
}

function nfDelete(notificationId) {
    if(!confirm("Are you sure you want to delete this notification?")) return;

    // Use Laravel route with placeholder
    let url = "{{ route('notifications.delete', ':id') }}".replace(':id', notificationId);

    $.ajax({
        url: url,
        type: "DELETE",
        data: {
            _token: "{{ csrf_token() }}" // CSRF token required for DELETE
        },
        success: function(res) {
            if(res.status) {
                // Remove the notification card from DOM
                $(`#nf_${notificationId}`).remove();

                // Optionally update badge counts
                let totalElem = $('.t-all .nf-tab-badge');
                let totalCount = parseInt(totalElem.text());
                totalElem.text(totalCount - 1 >= 0 ? totalCount - 1 : 0);

                let unreadElem = $('.t-unread .nf-tab-badge');
                // let isUnread = $(`#nf_${notificationId}`).attr('data-read') == 0;
                let card = $(`#nf_${notificationId}`);
                let isUnread = card.attr('data-read') == 0;

                card.remove();
                if(isUnread) {
                    let unreadCount = parseInt(unreadElem.text());
                    unreadElem.text(unreadCount - 1 >= 0 ? unreadCount - 1 : 0);
                }
                location.reload();

            } else {
                alert('Failed to delete notification');
            }
        },
        error: function(err) {
            console.error(err);
            alert('Error deleting notification');
        }
    });
}
function nfMarkAll() {

    $.ajax({
        url: "{{ route('notifications.markAllRead') }}", // Laravel named route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}" // CSRF token
        },
        success: function(res) {
            if(res.status) {
                // Option 1: Reload the page to refresh all notifications and badges
                location.reload();

                // Option 2: Or update UI dynamically without reload
                // $('.nf-card.unread').removeClass('unread').attr('data-read', 1);
                // $('.nf-unread-dot').remove();
                // $('.t-unread .nf-tab-badge').text(0);
            } else {
                alert('Failed to mark all notifications as read');
            }
        },
        error: function(err) {
            console.error(err);
            alert('Error marking all notifications as read');
        }
    });
}
function nfClearAll() {

    $.ajax({
        url: "{{ route('notifications.clearAll') }}", // Laravel named route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}" // CSRF token
        },
        success: function(res) {
            if(res.status) {
                // Option 1: Reload the page to refresh all notifications and badges
                location.reload();

                // Option 2: Or update UI dynamically without reload
                // $('.nf-card.unread').removeClass('unread').attr('data-read', 1);
                // $('.nf-unread-dot').remove();
                // $('.t-unread .nf-tab-badge').text(0);
            } else {
                alert('Failed to mark all notifications as read');
            }
        },
        error: function(err) {
            console.error(err);
            alert('Error marking all notifications as read');
        }
    });
}
function handleActionClick(type) {
  // window.location.href = "{{ route('employer.candidates') }}";
   if (type === 1) {
        // Redirect to /jobs
        window.location.href = "{{ route('employer.jobs.index') }}";
    } else {
        window.location.href = "{{ route('employer.candidates') }}";
    }
}
</script>
@endpush