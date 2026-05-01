{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/candidates.blade.php
     LinearJobs – Candidates Module  ·  Ultra Premium Design
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Candidates')
@section('breadcrumb','Candidates')
@php $activeNav = 'candidates'; @endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800;900&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════
   TOKENS
══════════════════════════════════════════════ */
:root{
  /* Blue */
  --p900:#1e3a8a;--p800:#1e40af;--p700:#1d4ed8;
  --p600:#2563eb;--p500:#3b82f6;--p400:#60a5fa;
  --p200:#bfdbfe;--p100:#dbeafe;--p50:#eff6ff;
  /* Green */
  --g700:#047857;--g600:#059669;--g500:#10b981;
  --g200:#a7f3d0;--g100:#d1fae5;--g50:#ecfdf5;
  /* Amber */
  --a700:#b45309;--a600:#d97706;--a500:#f59e0b;
  --a200:#fde68a;--a100:#fef3c7;--a50:#fffbeb;
  /* Red */
  --r700:#b91c1c;--r600:#dc2626;--r500:#ef4444;
  --r200:#fecaca;--r100:#fee2e2;--r50:#fef2f2;
  /* Purple */
  --pu700:#6d28d9;--pu500:#8b5cf6;--pu100:#ede9fe;--pu50:#f5f3ff;
  /* Ink */
  --ink:#0f172a;--ink2:#1e293b;--ink3:#334155;
  --ink4:#475569;--ink5:#64748b;--ink6:#94a3b8;
  --line:#e2e8f0;--line2:#f1f5f9;--surf:#f8fafc;--white:#ffffff;
  /* Type */
  --fh:'Sora',sans-serif; --fb:'DM Sans',sans-serif;
  /* Shadows */
  --sh-xs:0 1px 2px rgba(0,0,0,.05);
  --sh:0 1px 4px rgba(15,23,42,.06),0 4px 14px rgba(15,23,42,.06);
  --sh-md:0 4px 18px rgba(15,23,42,.10);
  --sh-lg:0 8px 38px rgba(15,23,42,.13);
  --sh-blue:0 4px 16px rgba(37,99,235,.28);
  --sh-blue-lg:0 8px 32px rgba(37,99,235,.38);
  /* Motion */
  --ease:.22s cubic-bezier(.4,0,.2,1);
  --spring:.34s cubic-bezier(.34,1.4,.64,1);
}
*,*::before,*::after{box-sizing:border-box;}

/* ══════════════════════════════════════════════
   PAGE SHELL
══════════════════════════════════════════════ */
.cd-root{
  min-height:100vh;
  background:
    radial-gradient(ellipse 65% 35% at 0% 0%,   rgba(37,99,235,.07) 0%,transparent 55%),
    radial-gradient(ellipse 50% 30% at 100% 15%, rgba(109,40,217,.05) 0%,transparent 55%),
    #eef2f8;
  padding-bottom:60px;
}
.cd-wrap{max-width:1200px;margin:0 auto;}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.cd-hero{
  background:linear-gradient(138deg,#0f2d8a 0%,#1e40af 38%,#2563eb 72%,#3b82f6 100%);
  border-radius:22px;padding:32px 38px 82px;
  position:relative;overflow:hidden;
  box-shadow:var(--sh-blue-lg),0 2px 6px rgba(0,0,0,.12);
}
.cd-hero-dots{position:absolute;inset:0;pointer-events:none;background-image:radial-gradient(circle,rgba(255,255,255,.09) 1px,transparent 1px);background-size:20px 20px;}
.cd-hero-ring{position:absolute;border-radius:50%;border:1px solid rgba(255,255,255,.08);pointer-events:none;}
.cd-hero-r1{width:400px;height:400px;top:-110px;right:-70px;}
.cd-hero-r2{width:230px;height:230px;bottom:-70px;left:20px;border-color:rgba(255,255,255,.05);}
.cd-hero-inner{position:relative;z-index:2;display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:18px;}
.cd-hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.22);border-radius:100px;padding:4px 14px;font-family:var(--fh);font-size:.67rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:rgba(255,255,255,.88);margin-bottom:12px;}
.cd-hero-title{font-family:var(--fh);font-size:clamp(1.4rem,3vw,2rem);font-weight:900;color:#fff;letter-spacing:-.5px;line-height:1.1;margin-bottom:7px;}
.cd-hero-sub{font-family:var(--fb);font-size:.88rem;color:rgba(255,255,255,.68);line-height:1.6;}
.cd-hero-stats{display:flex;gap:12px;flex-wrap:wrap;margin-top:18px;}
.cd-hero-stat{background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.18);border-radius:12px;padding:10px 18px;text-align:center;}
.cd-hero-stat-n{font-family:var(--fh);font-size:1.3rem;font-weight:900;color:#fff;line-height:1;}
.cd-hero-stat-l{font-family:var(--fb);font-size:.7rem;color:rgba(255,255,255,.65);margin-top:3px;}
.cd-hero-right{display:flex;flex-direction:column;align-items:flex-end;gap:9px;}
.cd-hero-export{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.22);border-radius:10px;padding:9px 18px;font-family:var(--fh);font-size:.8rem;font-weight:700;color:#fff;cursor:pointer;transition:all var(--ease);}
.cd-hero-export:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.35);}

/* ══════════════════════════════════════════════
   CONTROL BAR (floats over hero)
══════════════════════════════════════════════ */
.cd-bar-wrap{margin:-44px 0 0;position:relative;z-index:20;}
.cd-bar{background:var(--white);border-radius:18px;box-shadow:var(--sh-lg);padding:16px 22px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;}

/* Search */
.cd-search-wrap{position:relative;flex:1;min-width:200px;}
.cd-search-ico{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--ink6);font-size:.78rem;pointer-events:none;z-index:1;transition:color var(--ease);}
.cd-search{width:100%;border:2px solid var(--line);border-radius:11px;padding:10px 14px 10px 38px;font-family:var(--fb);font-size:.88rem;font-weight:500;color:var(--ink);background:var(--surf);outline:none;transition:all var(--ease);}
.cd-search:focus{border-color:var(--p500);box-shadow:0 0 0 4px rgba(59,130,246,.12);background:var(--white);}
.cd-search:focus~.cd-search-ico,.cd-search-wrap:focus-within .cd-search-ico{color:var(--p600);}

/* Select filters */
.cd-sel{border:2px solid var(--line);border-radius:11px;padding:10px 36px 10px 14px;font-family:var(--fh);font-size:.82rem;font-weight:700;color:var(--ink3);background:var(--surf);outline:none;cursor:pointer;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none'%3E%3Cpath d='M1 1.5l5 5 5-5' stroke='%2394a3b8' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;transition:all var(--ease);}
.cd-sel:focus{border-color:var(--p500);box-shadow:0 0 0 4px rgba(59,130,246,.12);color:var(--p700);}

/* View toggle */
.cd-view-btns{display:flex;border:2px solid var(--line);border-radius:10px;overflow:hidden;flex-shrink:0;}
.cd-view-btn{width:36px;height:36px;display:flex;align-items:center;justify-content:center;background:var(--surf);border:none;cursor:pointer;font-size:.78rem;color:var(--ink6);transition:all var(--ease);}
.cd-view-btn.on{background:var(--p600);color:#fff;}
.cd-view-btn:first-child{border-right:2px solid var(--line);}

/* ══════════════════════════════════════════════
   STATUS TABS
══════════════════════════════════════════════ */
.cd-tabs-wrap{margin-top:22px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.cd-tab-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 18px;border-radius:100px;
  font-family:var(--fh);font-size:.78rem;font-weight:700;
  border:2px solid var(--line);background:var(--white);color:var(--ink5);
  cursor:pointer;transition:all var(--ease);
  box-shadow:var(--sh-xs);
}
.cd-tab-btn i{font-size:.72rem;}
.cd-tab-count{
  min-width:20px;height:20px;padding:0 6px;border-radius:100px;
  font-family:var(--fh);font-size:.65rem;font-weight:900;line-height:20px;text-align:center;
  background:var(--line2);color:var(--ink5);
  transition:all var(--ease);display:inline-block;
}
.cd-tab-btn:hover{border-color:var(--ink5);color:var(--ink2);}
/* Active variants */
.cd-tab-btn.all.on  {background:linear-gradient(135deg,var(--p800),var(--p500));border-color:transparent;color:#fff;box-shadow:var(--sh-blue);}
.cd-tab-btn.all.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}
.cd-tab-btn.new.on  {background:linear-gradient(135deg,#0369a1,var(--p500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(3,105,161,.28);}
.cd-tab-btn.new.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}
.cd-tab-btn.sl.on   {background:linear-gradient(135deg,var(--g700),var(--g500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(5,150,105,.28);}
.cd-tab-btn.sl.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}
.cd-tab-btn.iv.on   {background:linear-gradient(135deg,var(--a700),var(--a500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(180,83,9,.24);}
.cd-tab-btn.iv.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}
.cd-tab-btn.rj.on   {background:linear-gradient(135deg,var(--r700),var(--r500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(185,28,28,.24);}
.cd-tab-btn.rj.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}
.cd-tab-btn.of.on   {background:linear-gradient(135deg,var(--pu700),var(--pu500));border-color:transparent;color:#fff;box-shadow:0 4px 14px rgba(109,40,217,.24);}
.cd-tab-btn.of.on .cd-tab-count{background:rgba(255,255,255,.25);color:#fff;}

/* ══════════════════════════════════════════════
   RESULTS BAR
══════════════════════════════════════════════ */
.cd-results-bar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin:18px 0 14px;}
.cd-results-txt{font-family:var(--fb);font-size:.82rem;color:var(--ink5);}
.cd-results-txt strong{font-family:var(--fh);font-weight:800;color:var(--ink2);}
.cd-sort{display:flex;align-items:center;gap:8px;font-family:var(--fb);font-size:.8rem;color:var(--ink5);}
.cd-sort-sel{border:none;font-family:var(--fh);font-size:.8rem;font-weight:700;color:var(--p600);background:transparent;cursor:pointer;outline:none;}

/* ══════════════════════════════════════════════
   CANDIDATE CARD  (List View)
══════════════════════════════════════════════ */
.cd-card{
  background:var(--white);border:1.5px solid var(--line);border-radius:16px;
  padding:18px 20px;display:flex;align-items:flex-start;gap:16px;
  transition:all var(--ease);margin-bottom:10px;
  position:relative;overflow:hidden;
}
.cd-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:4px;background:transparent;border-radius:4px 0 0 4px;transition:background var(--ease);}
.cd-card:hover{border-color:var(--p200);box-shadow:var(--sh-md);transform:translateY(-1px);}
.cd-card:hover::before{background:linear-gradient(180deg,var(--p600),var(--p400));}
/* Status left-border colours */
.cd-card[data-status="Shortlisted"]:hover::before{background:linear-gradient(180deg,var(--g600),var(--g500));}
.cd-card[data-status="Interview"]:hover::before  {background:linear-gradient(180deg,var(--a600),var(--a500));}
.cd-card[data-status="Rejected"]:hover::before   {background:linear-gradient(180deg,var(--r600),var(--r500));}
.cd-card[data-status="Offered"]:hover::before    {background:linear-gradient(180deg,var(--pu700),var(--pu500));}

/* Avatar */
.cd-av{
  width:46px;height:46px;border-radius:13px;
  display:flex;align-items:center;justify-content:center;
  font-family:var(--fh);font-size:.9rem;font-weight:800;color:#fff;
  flex-shrink:0;
}
.av-0{background:linear-gradient(135deg,#2563eb,#60a5fa);}
.av-1{background:linear-gradient(135deg,#7c3aed,#a78bfa);}
.av-2{background:linear-gradient(135deg,#059669,#34d399);}
.av-3{background:linear-gradient(135deg,#d97706,#fbbf24);}
.av-4{background:linear-gradient(135deg,#dc2626,#f87171);}
.av-5{background:linear-gradient(135deg,#0891b2,#22d3ee);}

/* Info */
.cd-info{flex:1;min-width:0;}
.cd-name-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;}
.cd-name{font-family:var(--fh);font-size:.96rem;font-weight:800;color:var(--ink);letter-spacing:-.2px;}
.cd-job{font-family:var(--fb);font-size:.78rem;font-weight:600;color:var(--p600);margin-bottom:8px;display:flex;align-items:center;gap:5px;}
.cd-job i{font-size:.68rem;}

.cd-meta{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:8px;}
.cd-meta-i{display:flex;align-items:center;gap:5px;font-family:var(--fb);font-size:.75rem;color:var(--ink5);}
.cd-meta-i i{font-size:.67rem;color:var(--ink6);width:12px;text-align:center;}

.cd-tags{display:flex;flex-wrap:wrap;gap:5px;}
.cd-tag{display:inline-flex;align-items:center;font-family:var(--fh);font-size:.69rem;font-weight:700;background:linear-gradient(135deg,var(--p100),var(--p50));border:1px solid var(--p200);color:var(--p700);border-radius:6px;padding:2px 9px;}

/* Status badges */
.cd-badge{font-family:var(--fh);font-size:.65rem;font-weight:800;letter-spacing:.05em;text-transform:uppercase;border-radius:100px;padding:3px 10px;flex-shrink:0;}
.cb-new {background:var(--p100);color:var(--p700);}
.cb-sl  {background:var(--g100);color:var(--g700);}
.cb-iv  {background:var(--a100);color:var(--a700);}
.cb-rj  {background:var(--r100);color:var(--r700);}
.cb-of  {background:var(--pu100);color:var(--pu700);}

/* Actions column */
.cd-actions{display:flex;flex-direction:column;align-items:flex-end;gap:7px;flex-shrink:0;}
.cd-date{font-family:var(--fb);font-size:.68rem;color:var(--ink6);text-align:right;margin-bottom:2px;}

/* Icon action buttons */
.cd-btn-row{display:flex;gap:5px;}
.cd-ibtn{
  width:32px;height:32px;border-radius:9px;border:1.5px solid var(--line);
  background:var(--white);display:flex;align-items:center;justify-content:center;
  font-size:.72rem;color:var(--ink5);cursor:pointer;transition:all var(--ease);
}
.cd-ibtn:hover{border-color:var(--p200);color:var(--p600);background:var(--p50);transform:translateY(-1px);}
.cd-ibtn.sl:hover{border-color:var(--g200);color:var(--g600);background:var(--g50);}
.cd-ibtn.iv:hover{border-color:var(--a200);color:var(--a600);background:var(--a50);}
.cd-ibtn.rj:hover{border-color:var(--r200);color:var(--r600);background:var(--r50);}

.cd-view-btn-main{
  display:inline-flex;align-items:center;gap:6px;
  background:linear-gradient(135deg,var(--p700),var(--p500));
  color:#fff;border:none;border-radius:9px;
  padding:8px 16px;font-family:var(--fh);font-size:.76rem;font-weight:800;
  cursor:pointer;box-shadow:var(--sh-blue);transition:all var(--ease);
  white-space:nowrap;
}
.cd-view-btn-main:hover{transform:translateY(-1px);box-shadow:var(--sh-blue-lg);}

/* ══════════════════════════════════════════════
   GRID VIEW (card style)
══════════════════════════════════════════════ */
.cd-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;}
.cd-grid-card{
  background:var(--white);border:1.5px solid var(--line);border-radius:18px;
  padding:20px;transition:all var(--ease);cursor:pointer;
}
.cd-grid-card:hover{border-color:var(--p200);box-shadow:var(--sh-md);transform:translateY(-2px);}
.cd-grid-card .cd-av{width:52px;height:52px;font-size:.95rem;margin-bottom:13px;}
.cd-grid-card .cd-name{font-size:.94rem;margin-bottom:3px;}
.cd-grid-card .cd-job{font-size:.76rem;margin-bottom:10px;}
.cd-grid-card .cd-meta{margin-bottom:10px;gap:7px;}
.cd-grid-card .cd-tags{margin-bottom:13px;}
.cd-grid-card .cd-grid-foot{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;padding-top:12px;border-top:1.5px solid var(--line2);}
.cd-grid-card .cd-date{font-size:.68rem;color:var(--ink6);}

/* ══════════════════════════════════════════════
   EMPTY STATE
══════════════════════════════════════════════ */
.cd-empty{
  text-align:center;padding:60px 24px;
  border:2px dashed var(--line);border-radius:18px;
  background:linear-gradient(135deg,var(--surf),#f3f5f9);
}
.cd-empty-ico{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,var(--line2),var(--surf));border:1.5px solid var(--line);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--ink6);margin:0 auto 15px;}
.cd-empty-t{font-family:var(--fh);font-size:.96rem;font-weight:800;color:var(--ink4);margin-bottom:5px;}
.cd-empty-s{font-family:var(--fb);font-size:.82rem;color:var(--ink6);}

/* ══════════════════════════════════════════════
   PROFILE MODAL
══════════════════════════════════════════════ */
.cd-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(15,23,42,.55);backdrop-filter:blur(5px);
  z-index:600;align-items:center;justify-content:center;padding:20px;
}
.cd-overlay.open{display:flex;animation:ov-in .2s ease;}
@keyframes ov-in{from{opacity:0;}to{opacity:1;}}

.cd-modal{
  background:var(--white);border-radius:22px;
  max-width:680px;width:100%;max-height:92vh;overflow-y:auto;
  position:relative;box-shadow:0 24px 80px rgba(0,0,0,.25);
  animation:mo-in .28s cubic-bezier(.34,1.2,.64,1);
}
@keyframes mo-in{from{opacity:0;transform:scale(.93)translateY(12px);}to{opacity:1;transform:scale(1)translateY(0);}}

.cd-modal-close{
  position:absolute;top:14px;right:14px;z-index:10;
  width:34px;height:34px;border-radius:10px;
  background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.25);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:.8rem;cursor:pointer;transition:all var(--ease);
}
.cd-modal-close:hover{background:rgba(255,255,255,.28);}

/* Modal hero */
.cd-mo-hero{
  background:linear-gradient(140deg,var(--p900),var(--p700),var(--p500));
  padding:28px 28px 48px;position:relative;overflow:hidden;border-radius:22px 22px 0 0;
}
.cd-mo-hero::before{content:'';position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.08) 1px,transparent 1px);background-size:18px 18px;pointer-events:none;}
.cd-mo-hero::after{content:'';position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none;}
.cd-mo-hero-body{position:relative;z-index:1;display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
.cd-mo-av{width:62px;height:62px;border-radius:16px;font-family:var(--fh);font-size:1.1rem;font-weight:900;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2.5px solid rgba(255,255,255,.3);}
.cd-mo-name{font-family:var(--fh);font-size:1.2rem;font-weight:900;color:#fff;margin-bottom:4px;letter-spacing:-.3px;}
.cd-mo-job{font-family:var(--fb);font-size:.82rem;color:rgba(255,255,255,.72);}
.cd-mo-status{margin-left:auto;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.28);border-radius:100px;padding:4px 13px;font-family:var(--fh);font-size:.68rem;font-weight:800;letter-spacing:.05em;text-transform:uppercase;color:#fff;}

/* Modal body */
.cd-mo-body{padding:26px;}

/* Stat grid */
.cd-mo-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;}
.cd-mo-stat{background:linear-gradient(135deg,var(--surf),#f3f5f9);border:1.5px solid var(--line);border-radius:12px;padding:13px 16px;}
.cd-mo-stat-l{font-family:var(--fh);font-size:.63rem;font-weight:800;color:var(--ink6);text-transform:uppercase;letter-spacing:.07em;margin-bottom:4px;}
.cd-mo-stat-v{font-family:var(--fh);font-size:.92rem;font-weight:700;color:var(--ink);}

/* Section header */
.cd-mo-sec{font-family:var(--fh);font-size:.68rem;font-weight:800;color:var(--ink6);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;display:flex;align-items:center;gap:7px;}
.cd-mo-sec::after{content:'';flex:1;height:1.5px;background:var(--line);}

/* Progress meter for match score */
.cd-match-wrap{margin-bottom:20px;}
.cd-match-bar{height:7px;background:var(--line2);border-radius:100px;overflow:hidden;margin-top:7px;}
.cd-match-fill{height:100%;border-radius:100px;background:linear-gradient(90deg,var(--g700),var(--g500),#34d399);transition:width .8s cubic-bezier(.4,0,.2,1);}

/* Screening answers */
.cd-sq-item{background:var(--surf);border:1.5px solid var(--line);border-radius:11px;padding:12px 15px;margin-bottom:9px;}
.cd-sq-q{font-family:var(--fh);font-size:.8rem;font-weight:700;color:var(--ink3);margin-bottom:5px;}
.cd-sq-a{font-family:var(--fb);font-size:.84rem;font-weight:500;color:var(--ink);display:flex;align-items:center;gap:7px;}
.cd-sq-a i{color:var(--g600);font-size:.75rem;flex-shrink:0;}

/* Modal action row */
.cd-mo-actions{display:flex;gap:9px;flex-wrap:wrap;padding-top:16px;border-top:1.5px solid var(--line);margin-top:4px;}
.cd-mo-btn{display:inline-flex;align-items:center;gap:7px;border-radius:10px;padding:9px 18px;font-family:var(--fh);font-size:.8rem;font-weight:800;cursor:pointer;transition:all var(--ease);border:1.5px solid transparent;}
.cd-mo-btn.primary{background:linear-gradient(135deg,var(--p700),var(--p500));color:#fff;box-shadow:var(--sh-blue);}
.cd-mo-btn.primary:hover{transform:translateY(-1px);box-shadow:var(--sh-blue-lg);}
.cd-mo-btn.ghost{background:var(--white);border-color:var(--line);color:var(--ink4);}
.cd-mo-btn.ghost:hover{border-color:var(--ink5);color:var(--ink2);}
.cd-mo-btn.green{background:var(--g50);border-color:var(--g200);color:var(--g700);}
.cd-mo-btn.green:hover{background:var(--g100);border-color:var(--g500);}
.cd-mo-btn.amber{background:var(--a50);border-color:var(--a200);color:var(--a700);}
.cd-mo-btn.amber:hover{background:var(--a100);border-color:var(--a500);}
.cd-mo-btn.red{background:var(--r50);border-color:var(--r200);color:var(--r700);}
.cd-mo-btn.red:hover{background:var(--r100);border-color:var(--r500);}

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media(max-width:680px){
  .cd-hero{padding:24px 22px 78px;}
  .cd-bar{gap:9px;}
  .cd-card{flex-wrap:wrap;}
  .cd-actions{flex-direction:row;align-items:center;width:100%;}
  .cd-mo-grid{grid-template-columns:1fr;}
  .cd-mo-actions{flex-direction:column;}
  .cd-mo-btn{justify-content:center;}
}
</style>
@endpush

@section('content')
@php
// dd($candidates);
$total = $candidates->count();
$new = $candidates->where('status','New')->count();
$shortlisted = $candidates->where('status','Shortlisted')->count();
$interview = $candidates->where('status','Interview')->count();
$rejected = $candidates->where('status','Rejected')->count();
$offered = $candidates->where('status','Offered')->count();
@endphp

<div class="cd-root">
<div class="cd-wrap">

  {{-- ══ HERO ══ --}}
  <div class="cd-hero">
    <div class="cd-hero-dots"></div>
    <div class="cd-hero-ring cd-hero-r1"></div>
    <div class="cd-hero-ring cd-hero-r2"></div>
    <div class="cd-hero-inner">
      <div>
        <div class="cd-hero-badge"><i class="fas fa-users"></i> Candidates Module</div>
        <div class="cd-hero-title">Candidate Pipeline</div>
        <div class="cd-hero-sub">Review, shortlist and manage applicants across all your job listings</div>
        <div class="cd-hero-stats">
          <div class="cd-hero-stat"><div class="cd-hero-stat-n">{{ $total }}</div><div class="cd-hero-stat-l">Total</div></div>
          <div class="cd-hero-stat"><div class="cd-hero-stat-n">{{ $shortlisted }}</div><div class="cd-hero-stat-l">Shortlisted</div></div>
          <div class="cd-hero-stat"><div class="cd-hero-stat-n">{{ $interview }}</div><div class="cd-hero-stat-l">Interview</div></div>
          <div class="cd-hero-stat"><div class="cd-hero-stat-n">{{ $new }}</div><div class="cd-hero-stat-l">New</div></div>
        </div>
      </div>
      <div class="cd-hero-right">
        <button class="cd-hero-export"><i class="fas fa-file-export"></i> Export CSV</button>
        <button class="cd-hero-export"><i class="fas fa-bell"></i> Alerts</button>
      </div>
    </div>
  </div>

  {{-- ══ CONTROL BAR ══ --}}
  <div class="cd-bar-wrap">
    <div class="cd-bar">
      {{-- Search --}}
      <div class="cd-search-wrap">
        <i class="fas fa-magnifying-glass cd-search-ico"></i>
        <input type="text" class="cd-search" placeholder="Search by name, skill or location…" oninput="cdSearch(this.value)" />
      </div>
      {{-- Job filter --}}
      <select class="cd-sel" onchange="cdFilterJob(this.value)">
        <option value="">All Jobs</option>
        <option>Senior React Developer</option>
        <option>Operations Manager</option>
        <option>Sales Executive</option>
        <option>HR Executive</option>
        <option>UI/UX Designer</option>
      </select>
      {{-- Sort --}}
      <select class="cd-sel" onchange="cdSort(this.value)">
        <option value="newest">Newest First</option>
        <option value="oldest">Oldest First</option>
        <option value="match">Best Match</option>
        <option value="name">Name A–Z</option>
      </select>
      {{-- View toggle --}}
      <div class="cd-view-btns">
        <button class="cd-view-btn on" id="viewList" onclick="cdSetView('list')" title="List view"><i class="fas fa-list"></i></button>
        <button class="cd-view-btn"    id="viewGrid" onclick="cdSetView('grid')" title="Grid view"><i class="fas fa-grip"></i></button>
      </div>
    </div>
  </div>

  {{-- ══ STATUS TABS ══ --}}
  <div class="cd-tabs-wrap">
    <button class="cd-tab-btn all on" onclick="cdTab('',this)">
      <i class="fas fa-users"></i> All
      <span class="cd-tab-count">{{ $total }}</span>
    </button>
    <button class="cd-tab-btn new" onclick="cdTab('New',this)">
      <i class="fas fa-sparkles"></i> New
      <span class="cd-tab-count">{{ $new }}</span>
    </button>
    <button class="cd-tab-btn sl" onclick="cdTab('Shortlisted',this)">
      <i class="fas fa-star"></i> Shortlisted
      <span class="cd-tab-count">{{ $shortlisted }}</span>
    </button>
    <button class="cd-tab-btn iv" onclick="cdTab('Interview',this)">
      <i class="fas fa-calendar-check"></i> Interview
      <span class="cd-tab-count">{{ $interview }}</span>
    </button>
    <button class="cd-tab-btn rj" onclick="cdTab('Rejected',this)">
      <i class="fas fa-circle-xmark"></i> Rejected
      <span class="cd-tab-count">{{ $rejected }}</span>
    </button>
    <!-- <button class="cd-tab-btn of" onclick="cdTab('Offered',this)">
      <i class="fas fa-handshake"></i> Offered
      <span class="cd-tab-count">{{ $offered }}</span>
    </button> -->
  </div>

  {{-- ══ RESULTS BAR ══ --}}
  <div class="cd-results-bar">
    <div class="cd-results-txt">Showing <strong id="cdCount">{{ $total }}</strong> candidates</div>
    <div class="cd-sort">
      Sort by &nbsp;
      <select class="cd-sort-sel" onchange="cdSort(this.value)">
        <option value="newest">Newest First</option>
        <option value="match">Best Match</option>
        <option value="name">Name A–Z</option>
      </select>
    </div>
  </div>

  {{-- ══ LIST VIEW ══ --}}
  <div id="cdListView">
  @foreach($candidates as $i => $c)
  @php
    $statusCls = match($c['status']){
      'New'       =>'cb-new',
      'Shortlisted'=>'cb-sl',
      'Interview' =>'cb-iv',
      'Rejected'  =>'cb-rj',
      'Offered'   =>'cb-of',
      default     =>'cb-new',
    };
    $matchColor = $c['match'] >= 80 ? 'var(--g600)' : ($c['match'] >= 60 ? 'var(--a600)' : 'var(--r600)');
  @endphp
  <div class="cd-card"
       data-name="{{ strtolower($c['applicant_name']) }}"
       data-status="{{ $c['status'] }}"
       data-job="{{ $c['job_id'] }}"
       data-match="{{ $c['match'] }}"
       data-date="{{ $i }}"
       onclick="cdOpenModal({{ $i }})">
    <div class="cd-av av-{{ $c['av'] }}">{{ $c['init'] }}</div>
    <div class="cd-info">
      <div class="cd-name-row">
        <div class="cd-name">{{ $c['applicant_name'] }}</div>
        <span class="cd-badge {{ $statusCls }}">{{ $c['status'] }}</span>
        {{-- Match score --}}
        <span style="margin-left:auto;display:flex;align-items:center;gap:5px;font-family:var(--fh);font-size:.69rem;font-weight:800;color:{{ $matchColor }};">
          <i class="fas fa-bullseye" style="font-size:.62rem;"></i> {{ $c['match'] }}% match
        </span>
      </div>
      <div class="cd-job"><i class="fas fa-briefcase"></i> {{ $c['job'] }}</div>
      <div class="cd-meta">
        <div class="cd-meta-i"><i class="fas fa-clock"></i> {{ $c['exp'] }}</div>
        <div class="cd-meta-i"><i class="fas fa-graduation-cap"></i> {{ $c['edu'] }}</div>
        <div class="cd-meta-i"><i class="fas fa-location-dot"></i> {{ $c['loc'] }}</div>
        <div class="cd-meta-i"><i class="fas fa-calendar"></i> {{ $c['date'] }}</div>
      </div>
      <div class="cd-tags">
        @foreach($c['skills'] as $sk)
        <span class="cd-tag">{{ $sk }}</span>
        @endforeach
      </div>
    </div>
    <div class="cd-actions" onclick="event.stopPropagation()">
      <div class="cd-date">{{ $c['date'] }}</div>
      <button class="cd-view-btn-main" onclick="cdOpenModal({{ $i }})">
        <i class="fas fa-eye"></i> View
      </button>
      <div class="cd-btn-row">
        {{-- <button class="cd-ibtn" title="Download Resume"><i class="fas fa-download"></i></button> --}}
        {{-- <button class="cd-ibtn" title="Screening Answers"><i class="fas fa-clipboard-list"></i></button> --}}
        <button class="cd-ibtn sl" title="Shortlist" onclick="updateStatus(5)"><i class="fas fa-star"></i></button>
        <button class="cd-ibtn iv" title="Mark Interview" onclick="updateStatus(6)"><i class="fas fa-calendar-check"></i></button>
        <button class="cd-ibtn rj" title="Reject" onclick="updateStatus(4)"><i class="fas fa-circle-xmark"></i></button>
      </div>
    </div>
  </div>
  @endforeach
  </div>

  {{-- ══ GRID VIEW ══ --}}
  <div id="cdGridView" style="display:none;">
  <div class="cd-grid" id="cdGridInner">
  @foreach($candidates as $i => $c)
  @php
    $statusCls = match($c['status']){
      'New'       =>'cb-new','Shortlisted'=>'cb-sl',
      'Interview' =>'cb-iv','Rejected'  =>'cb-rj',
      'Offered'   =>'cb-of', default=>'cb-new',
    };
    $matchColor = $c['match'] >= 80 ? 'var(--g600)' : ($c['match'] >= 60 ? 'var(--a600)' : 'var(--r600)');
  @endphp
  <div class="cd-grid-card"
       data-name="{{ strtolower($c['applicant_name']) }}"
       data-status="{{ $c['status'] }}"
       data-job="{{ $c['job_id'] }}"
       data-match="{{ $c['match'] }}"
       data-date="{{ $i }}"
       onclick="cdOpenModal({{ $i }})">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
      <div class="cd-av av-{{ $c['av'] }}">{{ $c['init'] }}</div>
      <span class="cd-badge {{ $statusCls }}">{{ $c['status'] }}</span>
    </div>
    <div class="cd-name">{{ $c['applicant_name'] }}</div>
    <div class="cd-job" style="margin-top:3px;"><i class="fas fa-briefcase"></i> {{ $c['job_id'] }}</div>
    <div class="cd-meta" style="margin-top:8px;margin-bottom:8px;">
      <div class="cd-meta-i"><i class="fas fa-clock"></i> {{ $c['exp'] }}</div>
      <div class="cd-meta-i"><i class="fas fa-location-dot"></i> {{ $c['loc'] }}</div>
    </div>
    <div class="cd-tags" style="margin-bottom:13px;">
      @foreach($c['skills'] as $sk)
      <span class="cd-tag">{{ $sk }}</span>
      @endforeach
    </div>
    {{-- Match bar --}}
    <div style="margin-bottom:12px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
        <span style="font-family:var(--fh);font-size:.67rem;font-weight:800;color:var(--ink6);text-transform:uppercase;letter-spacing:.06em;">Match Score</span>
        <span style="font-family:var(--fh);font-size:.72rem;font-weight:800;color:{{ $matchColor }};">{{ $c['match'] }}%</span>
      </div>
      <div class="cd-match-bar"><div class="cd-match-fill" style="width:{{ $c['match'] }}%"></div></div>
    </div>
    <div class="cd-grid-foot" onclick="event.stopPropagation()">
      <div class="cd-date"><i class="fas fa-calendar"></i> {{ $c['date'] }}</div>
      <div class="cd-btn-row">
        <button class="cd-ibtn sl" title="Shortlist" onclick="cdSetStatus({{ $i }},'Shortlisted')"><i class="fas fa-star"></i></button>
        <button class="cd-ibtn iv" title="Interview" onclick="cdSetStatus({{ $i }},'Interview')"><i class="fas fa-calendar-check"></i></button>
        <button class="cd-ibtn rj" title="Reject"    onclick="cdSetStatus({{ $i }},'Rejected')"><i class="fas fa-circle-xmark"></i></button>
      </div>
    </div>
  </div>
  @endforeach
  </div>
  </div>

  {{-- ══ EMPTY STATE ══ --}}
  <div class="cd-empty" id="cdEmpty" style="display:none;">
    <div class="cd-empty-ico"><i class="fas fa-users-slash"></i></div>
    <div class="cd-empty-t">No candidates found</div>
    <div class="cd-empty-s">Try adjusting your search or filter criteria</div>
  </div>

</div>{{-- /cd-wrap --}}
</div>{{-- /cd-root --}}

{{-- ══ PROFILE MODAL ══ --}}
<div class="cd-overlay" id="cdModalOverlay" onclick="if(event.target===this)cdCloseModal()">
  <div class="cd-modal" id="cdModal">

    <button class="cd-modal-close" onclick="cdCloseModal()"><i class="fas fa-xmark"></i></button>

    <div class="cd-mo-hero">
      <div class="cd-mo-hero-body">
        <div class="cd-mo-av" id="moAv" style="background:linear-gradient(135deg,#2563eb,#60a5fa);"></div>
        <div>
          <div class="cd-mo-name" id="moName"></div>
          <div class="cd-mo-job" id="moJob"></div>
        </div>
        <span class="cd-mo-status" id="moStatus"></span>
      </div>
    </div>

    <div class="cd-mo-body">

      {{-- Match bar --}}
      <div class="cd-match-wrap">
        <div class="cd-mo-sec"><i class="fas fa-bullseye" style="color:var(--p600);"></i> Profile Match</div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
          <span style="font-family:var(--fb);font-size:.82rem;color:var(--ink5);">Overall compatibility with this role</span>
          <span id="moMatchPct" style="font-family:var(--fh);font-size:.9rem;font-weight:900;color:var(--g600);"></span>
        </div>
        <div class="cd-match-bar"><div class="cd-match-fill" id="moMatchBar" style="width:0%"></div></div>
      </div>

      {{-- Details grid --}}
      <div class="cd-mo-sec"><i class="fas fa-id-card" style="color:var(--p600);"></i> Candidate Details</div>
      <div class="cd-mo-grid">
        <div class="cd-mo-stat"><div class="cd-mo-stat-l"><i class="fas fa-clock"></i> Experience</div><div class="cd-mo-stat-v" id="moExp"></div></div>
        <div class="cd-mo-stat"><div class="cd-mo-stat-l"><i class="fas fa-graduation-cap"></i> Education</div><div class="cd-mo-stat-v" id="moEdu"></div></div>
        <div class="cd-mo-stat"><div class="cd-mo-stat-l"><i class="fas fa-location-dot"></i> Location</div><div class="cd-mo-stat-v" id="moLoc"></div></div>
        <div class="cd-mo-stat"><div class="cd-mo-stat-l"><i class="fas fa-calendar"></i> Applied On</div><div class="cd-mo-stat-v" id="moDate"></div></div>
      </div>

      {{-- Skills --}}
      <div class="cd-mo-sec" style="margin-top:4px;"><i class="fas fa-tags" style="color:var(--p600);"></i> Skills</div>
      <div id="moSkills" style="display:flex;flex-wrap:wrap;gap:7px;margin-bottom:22px;"></div>

      {{-- Screening --}}
      <div class="cd-mo-sec"><i class="fas fa-clipboard-question" style="color:var(--p600);"></i> Screening Answers</div>
      <div id="moScreening">
        <div class="cd-sq-item">
          <div class="cd-sq-q">Do you have a valid driving licence?</div>
          <div class="cd-sq-a"><i class="fas fa-check-circle"></i> Yes, I hold a valid LMV licence</div>
        </div>
        <div class="cd-sq-item">
          <div class="cd-sq-q">Are you willing to relocate?</div>
          <div class="cd-sq-a"><i class="fas fa-check-circle"></i> Yes, open to relocation anywhere in Tamil Nadu</div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="cd-mo-actions">
        <button class="cd-mo-btn primary" id="downloadResume"><i class="fas fa-download" ></i> Resume</button>
        <button class="cd-mo-btn ghost"><i class="fas fa-clipboard-list"></i> Screening</button>
        <button class="cd-mo-btn green" id="moBtnSL"><i class="fas fa-star"></i> Shortlist</button>
        <button class="cd-mo-btn amber" id="moBtnIV"><i class="fas fa-calendar-check"></i> Interview</button>
        <button class="cd-mo-btn red"   id="moBtnRJ"><i class="fas fa-circle-xmark"></i> Reject</button>
      </div>

    </div>{{-- /cd-mo-body --}}
  </div>{{-- /cd-modal --}}
</div>{{-- /cd-overlay --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
'use strict';
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true
});
/* ===============================
   GLOBALS
================================ */
let DATA = @json($candidates);
let currentCandidateId = null;
let currentModalIdx = -1;

let downloadBaseUrl = "{{ route('employer.candidateresume.download', ':id') }}";

/* ===============================
   OPEN MODAL
================================ */
window.cdOpenModal = function(idx){
    let c = DATA[idx];

    currentCandidateId = c.id;
    currentModalIdx = idx;

    // Avatar
    document.getElementById('moAv').textContent = c.init;

    // Basic info
    document.getElementById('moName').textContent = c.name;
    document.getElementById('moJob').textContent  = c.job;
    document.getElementById('moStatus').textContent = c.status;

    document.getElementById('moExp').textContent  = c.exp;
    document.getElementById('moEdu').textContent  = c.edu;
    document.getElementById('moLoc').textContent  = c.loc;
    document.getElementById('moDate').textContent = c.date;

    // Skills
    document.getElementById('moSkills').innerHTML =
        c.skills.map(s => `<span class="cd-tag">${s}</span>`).join('');

    // Match
    document.getElementById('moMatchPct').textContent = c.match + '%';
    let bar = document.getElementById('moMatchBar');
    bar.style.width = '0%';
    setTimeout(() => bar.style.width = c.match + '%', 100);

    // Button actions
    document.getElementById('downloadResume').onclick = downloadResume;
    document.getElementById('downloadResume').onclick = downloadResume;
    document.getElementById('moBtnSL').onclick = () => updateStatus(5);
    document.getElementById('moBtnIV').onclick = () => updateStatus(6);
    document.getElementById('moBtnRJ').onclick = () => updateStatus(4);

    // Open modal
    document.getElementById('cdModalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
};

/* ===============================
   CLOSE MODAL
================================ */
window.cdCloseModal = function(){
    document.getElementById('cdModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
};

document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') cdCloseModal();
});

/* ===============================
   DOWNLOAD RESUME
================================ */
function downloadResume(){
    if (!currentCandidateId) {
        alert('No candidate selected');
        return;
    }

    let url = downloadBaseUrl.replace(':id', currentCandidateId);
    window.open(url, '_blank');
}

/* ===============================
   UPDATE STATUS (AJAX)
================================ */
function updateStatus(status){

    if (!currentCandidateId) {
        Toast.fire({
            icon: 'warning',
            title: 'No candidate selected'
        });
        return;
    }

    let confirmMsg = {
        5: "Shortlist this candidate?",
        6: "Mark for interview?",
        4: "Reject this candidate?"
    };

    let successMsg = {
        5: "Candidate shortlisted",
        6: "Marked for interview",
        4: "Candidate rejected"
    };
    if (status == 6) {

        Swal.fire({
            title: 'Schedule Interview',
            html: `
                <input type="date" id="interview_date" class="swal2-input">

                <select id="interview_mode" class="swal2-input">
                    <option value="">Select Mode</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
            `,
            confirmButtonText: 'Schedule',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            preConfirm: () => {
                let date = document.getElementById('interview_date').value;
                let mode = document.getElementById('interview_mode').value;

                if (!date || !mode) {
                    Swal.showValidationMessage('Please select date and mode');
                    return false;
                }

                return { date, mode };
            }
        }).then((result) => {

            if (!result.isConfirmed) return;

            sendStatusUpdate(status, result.value.date, result.value.mode, successMsg[status]);
        });

        return;
    }

    Swal.fire({
        title: confirmMsg[status],
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#2563eb'
    }).then((result) => {

        if (!result.isConfirmed) return;

        Swal.fire({
            title: 'Processing...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch("{{ route('employer.candidate.update.status') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id: currentCandidateId,
                status: status
            })
        })
        .then(res => res.json())
        .then(data => {

            Swal.close();

            if (!data.success) {
                Toast.fire({
                    icon: 'error',
                    title: 'Update failed'
                });
                return;
            }

            Toast.fire({
                icon: 'success',
                title: successMsg[status]
            });

            // 🔥 RELOAD PAGE AFTER SUCCESS
            setTimeout(() => {
                location.reload();
            }, 1500);

        })
        .catch(() => {
            Swal.close();

            Toast.fire({
                icon: 'error',
                title: 'Something went wrong'
            });
        });

    });
}
function sendStatusUpdate(status, date = null, mode = null, successText = '') {

    Swal.fire({
        title: 'Processing...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch("{{ route('employer.candidate.update.status') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id: currentCandidateId,
            status: status,
            interview_date: date,
            interview_mode: mode
        })
    })
    .then(res => res.json())
    .then(data => {

        Swal.close();

        if (!data.success) {
            Toast.fire({
                icon: 'error',
                title: 'Update failed'
            });
            return;
        }

        Toast.fire({
            icon: 'success',
            title: successText || 'Updated successfully'
        });

        setTimeout(() => {
            location.reload();
        }, 1500);

    })
    .catch((err) => {
        Swal.close();

        console.error(err);

        Toast.fire({
            icon: 'error',
            title: 'Something went wrong'
        });
    });
}
/* ===============================
   FILTER / SEARCH / SORT
================================ */
let activeSearch = '';
let activeStatus = '';
let activeJob = '';

function allCards(){
    return document.querySelectorAll('#cdListView .cd-card, #cdGridView .cd-grid-card');
}

function updateCount(){
    let visible = 0;

    allCards().forEach(c => {
        if(c.style.display !== 'none') visible++;
    });

    document.getElementById('cdCount').textContent = visible;
    document.getElementById('cdEmpty').style.display = visible ? 'none' : 'block';
}

function applyFilters(){
    allCards().forEach(c => {

        let name = (c.dataset.name || '').toLowerCase();
        let status = c.dataset.status || '';
        let job = c.dataset.job || '';

        let ok =
            (!activeSearch || name.includes(activeSearch)) &&
            (!activeStatus || status === activeStatus) &&
            (!activeJob || job === activeJob);

        c.style.display = ok ? '' : 'none';
    });

    updateCount();
}

window.cdSearch = function(q){
    activeSearch = q.toLowerCase();
    applyFilters();
};

window.cdTab = function(status, btn){
    document.querySelectorAll('.cd-tab-btn').forEach(b => b.classList.remove('on'));
    btn.classList.add('on');

    activeStatus = status;
    applyFilters();
};

window.cdFilterJob = function(job){
    activeJob = job;
    applyFilters();
};

window.cdSort = function(val){

    let list = document.getElementById('cdListView');
    let cards = Array.from(list.querySelectorAll('.cd-card'));

    cards.sort((a, b) => {

        if(val === 'match')
            return b.dataset.match - a.dataset.match;

        if(val === 'oldest')
            return a.dataset.date - b.dataset.date;

        if(val === 'name')
            return a.dataset.name.localeCompare(b.dataset.name);

        return b.dataset.date - a.dataset.date;
    });

    cards.forEach(c => list.appendChild(c));
};

/* ===============================
   VIEW TOGGLE
================================ */
window.cdSetView = function(v){
    document.getElementById('cdListView').style.display = v === 'list' ? 'block' : 'none';
    document.getElementById('cdGridView').style.display = v === 'grid' ? 'block' : 'none';

    document.getElementById('viewList').classList.toggle('on', v === 'list');
    document.getElementById('viewGrid').classList.toggle('on', v === 'grid');

    applyFilters();
};

</script>
@endpush