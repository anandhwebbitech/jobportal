{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/dashboard.blade.php
     LinearJobs – Employer Dashboard  ·  Premium Gradient Design
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Dashboard')
@php $activeNav = 'dashboard'; @endphp

@push('styles')
<style>
/* ══════════════════════════════════════════════════════
   TOKENS
══════════════════════════════════════════════════════ */
:root{
  --blue:     #1a56db; --blue-h:#1648c0;
  --blue-lt:  #eff6ff; --blue-mid:#bfdbfe;
  --green:    #059669; --green-lt:#ecfdf5;
  --amber:    #d97706; --amber-lt:#fffbeb;
  --red:      #dc2626; --red-lt:#fef2f2;
  --indigo:   #4f46e5; --indigo-lt:#eef2ff;
  --teal:     #0d9488; --teal-lt:#f0fdfa;
  --rose:     #e11d48; --rose-lt:#fff1f2;
  --purple:   #7c3aed; --purple-lt:#f5f3ff;

  --n900:#0f172a;--n800:#1e293b;--n700:#334155;
  --n600:#475569;--n500:#64748b;--n400:#94a3b8;
  --n300:#cbd5e1;--n200:#e2e8f0;--n100:#f1f5f9;--n50:#f8fafc;

  --rXL:22px;--rLG:16px;--rMD:11px;--rSM:8px;
  --shXS:0 1px 3px rgba(0,0,0,.06);
  --shSM:0 2px 10px rgba(0,0,0,.08);
  --shMD:0 6px 24px rgba(0,0,0,.10);
  --shLG:0 12px 40px rgba(0,0,0,.14);
  --t:.22s ease;
}

/* ══════════════════════════════════════════════════════
   PAGE BACKGROUND
══════════════════════════════════════════════════════ */
.db-page{
  display:flex;flex-direction:column;gap:26px;
  padding:0 0 48px;
  background:
    radial-gradient(ellipse 80% 60% at 0% 0%,   rgba(26,86,219,.07) 0%,transparent 60%),
    radial-gradient(ellipse 60% 50% at 100% 30%, rgba(124,58,237,.05) 0%,transparent 60%),
    radial-gradient(ellipse 50% 40% at 60% 100%, rgba(5,150,105,.05) 0%,transparent 60%),
    #f0f4fb;
}

/* ══════════════════════════════════════════════════════
   HERO WELCOME
══════════════════════════════════════════════════════ */
.dash-welcome{
  background:linear-gradient(135deg,#0f2d8a 0%,#1a56db 45%,#3b82f6 75%,#60a5fa 100%);
  border-radius:var(--rXL);
  padding:36px 40px;
  display:flex;align-items:center;justify-content:space-between;
  gap:24px;flex-wrap:wrap;
  position:relative;overflow:hidden;
  box-shadow:0 10px 40px rgba(26,86,219,.4),0 2px 8px rgba(0,0,0,.12);
}
.dw-ring{
  position:absolute;border-radius:50%;
  border:1.5px solid rgba(255,255,255,.12);pointer-events:none;
}
.dw-ring-1{width:320px;height:320px;top:-100px;right:-80px;}
.dw-ring-2{width:200px;height:200px;bottom:-60px;right:140px;border-color:rgba(255,255,255,.07);}
.dw-ring-3{width:110px;height:110px;top:18px;right:280px;border-color:rgba(255,255,255,.1);}
.dw-glow{
  position:absolute;width:260px;height:180px;top:-40px;right:0;
  background:radial-gradient(ellipse,rgba(147,197,253,.25) 0%,transparent 70%);
  pointer-events:none;
}
.dw-dots{
  position:absolute;inset:0;pointer-events:none;
  background-image:radial-gradient(circle,rgba(255,255,255,.08) 1px,transparent 1px);
  background-size:24px 24px;
}
.dw-text{position:relative;z-index:2;}
.dw-greeting{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
  color:rgba(255,255,255,.8);
  background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);
  border-radius:100px;padding:5px 14px;margin-bottom:10px;
}
.dw-title{
  font-size:clamp(1.5rem,2.8vw,2.1rem);font-weight:900;
  color:#fff;letter-spacing:-.7px;line-height:1.1;margin-bottom:8px;
}
.dw-company{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.84rem;color:rgba(255,255,255,.75);
}
.dw-verified{
  display:inline-flex;align-items:center;gap:5px;
  font-size:.72rem;font-weight:700;
  background:rgba(74,222,128,.2);border:1px solid rgba(74,222,128,.35);
  color:#86efac;border-radius:100px;padding:3px 10px;
}
.dw-verified i{font-size:.6rem;color:#4ade80;}
.dw-actions{display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:2;}
.dw-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:12px 24px;border-radius:var(--rMD);
  font-size:.85rem;font-weight:700;cursor:pointer;
  border:none;transition:all var(--t);text-decoration:none;
}
.dw-btn-white{background:#fff;color:var(--blue);box-shadow:0 4px 14px rgba(0,0,0,.18);}
.dw-btn-white:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.22);color:var(--blue-h);}
.dw-btn-outline{background:rgba(255,255,255,.14);color:#fff;border:1.5px solid rgba(255,255,255,.32);}
.dw-btn-outline:hover{background:rgba(255,255,255,.24);}

/* ══════════════════════════════════════════════════════
   PLAN EXPIRY BAR
══════════════════════════════════════════════════════ */
.plan-expiry-bar{
  display:flex;align-items:center;gap:14px;
  background:linear-gradient(135deg,#fffbeb,#fef3c7);
  border:1.5px solid #fde68a;border-left:5px solid var(--amber);
  border-radius:var(--rLG);padding:15px 20px;
  font-size:.84rem;color:#78350f;
  box-shadow:0 2px 12px rgba(217,119,6,.12);
}
.peb-ico{
  width:36px;height:36px;border-radius:10px;
  background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#fff;
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;flex-shrink:0;box-shadow:0 2px 8px rgba(245,158,11,.4);
}
.plan-expiry-bar a{
  margin-left:auto;white-space:nowrap;
  display:inline-flex;align-items:center;gap:6px;
  background:linear-gradient(135deg,var(--amber),#f59e0b);color:#fff;
  border-radius:var(--rSM);padding:8px 16px;
  font-size:.8rem;font-weight:700;text-decoration:none;
  transition:all var(--t);box-shadow:0 2px 10px rgba(217,119,6,.35);
}
.plan-expiry-bar a:hover{transform:translateY(-1px);box-shadow:0 4px 16px rgba(217,119,6,.45);}

/* ══════════════════════════════════════════════════════
   QUICK ACTIONS
══════════════════════════════════════════════════════ */
.quick-actions{
  display:grid;grid-template-columns:repeat(4,1fr);gap:16px;
}
@media(max-width:720px){.quick-actions{grid-template-columns:repeat(2,1fr);}}

.qa-item{
  background:#fff;border:1.5px solid var(--n200);
  border-radius:var(--rLG);padding:24px 18px 20px;
  text-align:center;cursor:pointer;
  display:flex;flex-direction:column;align-items:center;gap:14px;
  transition:all .28s;text-decoration:none;
  position:relative;overflow:hidden;box-shadow:var(--shXS);
}
.qa-item::before{
  content:'';position:absolute;inset:0;opacity:0;
  transition:opacity .28s;border-radius:inherit;
}
.qa-item-post::before  {background:linear-gradient(160deg,#eff6ff,#dbeafe);}
.qa-item-apps::before  {background:linear-gradient(160deg,#ecfdf5,#d1fae5);}
.qa-item-resume::before{background:linear-gradient(160deg,#f5f3ff,#ede9fe);}
.qa-item-billing::before{background:linear-gradient(160deg,#fffbeb,#fef3c7);}
.qa-item::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
  transform:scaleX(0);transform-origin:left;transition:transform .28s ease;
}
.qa-item-post::after   {background:linear-gradient(90deg,var(--blue),#60a5fa);}
.qa-item-apps::after   {background:linear-gradient(90deg,var(--green),#34d399);}
.qa-item-resume::after {background:linear-gradient(90deg,var(--purple),#a78bfa);}
.qa-item-billing::after{background:linear-gradient(90deg,var(--amber),#fcd34d);}
.qa-item:hover{transform:translateY(-4px);box-shadow:var(--shMD);border-color:transparent;}
.qa-item:hover::before{opacity:1;}
.qa-item:hover::after{transform:scaleX(1);}

.qa-ico{
  width:56px;height:56px;border-radius:16px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.2rem;transition:all .28s;position:relative;z-index:1;
}
.qa-ico-blue   {background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:var(--blue);}
.qa-ico-green  {background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:var(--green);}
.qa-ico-purple {background:linear-gradient(135deg,#ede9fe,#ddd6fe);color:var(--purple);}
.qa-ico-amber  {background:linear-gradient(135deg,#fef3c7,#fde68a);color:var(--amber);}
.qa-item-post:hover   .qa-ico{background:linear-gradient(135deg,var(--blue),#3b82f6);color:#fff;box-shadow:0 6px 18px rgba(26,86,219,.45);}
.qa-item-apps:hover   .qa-ico{background:linear-gradient(135deg,var(--green),#10b981);color:#fff;box-shadow:0 6px 18px rgba(5,150,105,.45);}
.qa-item-resume:hover .qa-ico{background:linear-gradient(135deg,var(--purple),#8b5cf6);color:#fff;box-shadow:0 6px 18px rgba(124,58,237,.45);}
.qa-item-billing:hover .qa-ico{background:linear-gradient(135deg,var(--amber),#f59e0b);color:#fff;box-shadow:0 6px 18px rgba(217,119,6,.45);}

.qa-content{position:relative;z-index:1;text-align:center;}
.qa-label{font-size:.85rem;font-weight:800;color:var(--n800);margin-bottom:2px;}
.qa-sub  {font-size:.72rem;color:var(--n400);}

/* ══════════════════════════════════════════════════════
   STAT CARDS  (8 cards, 4-col)
══════════════════════════════════════════════════════ */
.stat-grid{
  display:grid;grid-template-columns:repeat(4,1fr);gap:16px;
}
@media(max-width:1100px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:560px){ .stat-grid{grid-template-columns:1fr 1fr;gap:12px;}}

.stat-card{
  border-radius:var(--rLG);padding:22px 20px 20px;
  position:relative;overflow:hidden;
  border:1.5px solid transparent;
  transition:all .28s;
  box-shadow:var(--shSM);
}
.stat-card:hover{transform:translateY(-4px);box-shadow:var(--shLG);}

/* Gradient card backgrounds */
.sc-blue   {background:linear-gradient(145deg,#eff6ff 0%,#dbeafe 55%,#fff 100%);border-color:#bfdbfe;}
.sc-green  {background:linear-gradient(145deg,#ecfdf5 0%,#d1fae5 55%,#fff 100%);border-color:#a7f3d0;}
.sc-red    {background:linear-gradient(145deg,#fef2f2 0%,#fee2e2 55%,#fff 100%);border-color:#fca5a5;}
.sc-amber  {background:linear-gradient(145deg,#fffbeb 0%,#fef3c7 55%,#fff 100%);border-color:#fde68a;}
.sc-purple {background:linear-gradient(145deg,#f5f3ff 0%,#ede9fe 55%,#fff 100%);border-color:#ddd6fe;}
.sc-teal   {background:linear-gradient(145deg,#f0fdfa 0%,#ccfbf1 55%,#fff 100%);border-color:#99f6e4;}
.sc-indigo {background:linear-gradient(145deg,#eef2ff 0%,#e0e7ff 55%,#fff 100%);border-color:#c7d2fe;}
.sc-rose   {background:linear-gradient(145deg,#fff1f2 0%,#ffe4e6 55%,#fff 100%);border-color:#fecdd3;}

/* Top gradient stripe */
.stat-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:4px 4px 0 0;
}
.sc-blue::before   {background:linear-gradient(90deg,#1a56db,#60a5fa);}
.sc-green::before  {background:linear-gradient(90deg,#059669,#34d399);}
.sc-red::before    {background:linear-gradient(90deg,#dc2626,#f87171);}
.sc-amber::before  {background:linear-gradient(90deg,#d97706,#fcd34d);}
.sc-purple::before {background:linear-gradient(90deg,#7c3aed,#a78bfa);}
.sc-teal::before   {background:linear-gradient(90deg,#0d9488,#2dd4bf);}
.sc-indigo::before {background:linear-gradient(90deg,#4f46e5,#818cf8);}
.sc-rose::before   {background:linear-gradient(90deg,#e11d48,#fb7185);}

/* Bottom glow blob */
.stat-card::after{
  content:'';position:absolute;bottom:-24px;right:-24px;
  width:90px;height:90px;border-radius:50%;opacity:.35;
}
.sc-blue::after   {background:radial-gradient(circle,#bfdbfe,transparent);}
.sc-green::after  {background:radial-gradient(circle,#a7f3d0,transparent);}
.sc-red::after    {background:radial-gradient(circle,#fca5a5,transparent);}
.sc-amber::after  {background:radial-gradient(circle,#fde68a,transparent);}
.sc-purple::after {background:radial-gradient(circle,#ddd6fe,transparent);}
.sc-teal::after   {background:radial-gradient(circle,#99f6e4,transparent);}
.sc-indigo::after {background:radial-gradient(circle,#c7d2fe,transparent);}
.sc-rose::after   {background:radial-gradient(circle,#fecdd3,transparent);}

.stat-card-top{
  display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;
}
.stat-card-ico{
  width:48px;height:48px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.05rem;flex-shrink:0;
  box-shadow:0 3px 12px rgba(0,0,0,.15);
}
.sc-blue   .stat-card-ico{background:linear-gradient(135deg,#1a56db,#3b82f6);color:#fff;}
.sc-green  .stat-card-ico{background:linear-gradient(135deg,#059669,#10b981);color:#fff;}
.sc-red    .stat-card-ico{background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;}
.sc-amber  .stat-card-ico{background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;}
.sc-purple .stat-card-ico{background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:#fff;}
.sc-teal   .stat-card-ico{background:linear-gradient(135deg,#0d9488,#14b8a6);color:#fff;}
.sc-indigo .stat-card-ico{background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;}
.sc-rose   .stat-card-ico{background:linear-gradient(135deg,#e11d48,#f43f5e);color:#fff;}

.stat-badge{
  font-size:.65rem;font-weight:700;letter-spacing:.03em;
  border-radius:100px;padding:4px 10px;
  display:inline-flex;align-items:center;gap:4px;
}
.stat-badge.up     {background:#dcfce7;color:#15803d;}
.stat-badge.down   {background:#fee2e2;color:#b91c1c;}

.stat-card-value{
  font-size:2.2rem;font-weight:900;line-height:1;letter-spacing:-.8px;margin-bottom:5px;
}
.sc-blue   .stat-card-value{color:#1e3a8a;}
.sc-green  .stat-card-value{color:#065f46;}
.sc-red    .stat-card-value{color:#991b1b;}
.sc-amber  .stat-card-value{color:#92400e;}
.sc-purple .stat-card-value{color:#4c1d95;}
.sc-teal   .stat-card-value{color:#134e4a;}
.sc-indigo .stat-card-value{color:#312e81;}
.sc-rose   .stat-card-value{color:#881337;}

.stat-card-label{
  font-size:.72rem;font-weight:700;text-transform:uppercase;
  letter-spacing:.05em;color:var(--n500);
}
.stat-card-trend{
  display:flex;align-items:center;gap:5px;
  font-size:.74rem;font-weight:600;margin-top:10px;color:var(--n400);
}
.stat-card-trend.up  {color:#16a34a;}
.stat-card-trend.down{color:var(--red);}

/* ══════════════════════════════════════════════════════
   LOWER 3-COL GRID
══════════════════════════════════════════════════════ */
.dash-lower{
  display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:20px;
}
@media(max-width:1050px){.dash-lower{grid-template-columns:1fr 1fr;}}
@media(max-width:680px) {.dash-lower{grid-template-columns:1fr;}}

/* Base Card */
.emp-card{
  background:#fff;border:1.5px solid var(--n200);
  border-radius:var(--rXL);overflow:hidden;
  box-shadow:var(--shSM);
  display:flex;flex-direction:column;
  transition:box-shadow .28s,transform .28s;
}
.emp-card:hover{box-shadow:var(--shLG);transform:translateY(-2px);}

/* Card header */
.emp-card-head{
  display:flex;align-items:center;gap:14px;
  padding:18px 22px 16px;
  border-bottom:1.5px solid var(--n100);
  position:relative;overflow:hidden;
}
.emp-card-head-blue  {background:linear-gradient(135deg,#f0f7ff,#e8f0fe);}
.emp-card-head-green {background:linear-gradient(135deg,#f0fdf7,#e6faf1);}
.emp-card-head-amber {background:linear-gradient(135deg,#fffdf0,#fef9e7);}

.emp-card-head-ico{
  width:42px;height:42px;border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.12);
}
.ico-blue  {background:linear-gradient(135deg,var(--blue),#3b82f6);color:#fff;}
.ico-green {background:linear-gradient(135deg,var(--green),#10b981);color:#fff;}
.ico-amber {background:linear-gradient(135deg,var(--amber),#f59e0b);color:#fff;}

.emp-card-head-title{font-size:.94rem;font-weight:800;color:var(--n900);letter-spacing:-.1px;}
.emp-card-head-sub  {font-size:.72rem;color:var(--n400);margin-top:1px;}
.emp-card-head-badge{
  margin-left:auto;font-size:.65rem;font-weight:700;
  border-radius:100px;padding:4px 12px;color:#fff;white-space:nowrap;
}
.badge-pill-blue  {background:linear-gradient(135deg,var(--blue),#3b82f6);box-shadow:0 2px 8px rgba(26,86,219,.3);}
.badge-pill-green {background:linear-gradient(135deg,var(--green),#10b981);box-shadow:0 2px 8px rgba(5,150,105,.3);}
.badge-pill-rose  {background:linear-gradient(135deg,var(--rose),#f43f5e);box-shadow:0 2px 8px rgba(225,29,72,.3);}

.emp-card-body{padding:18px 22px 20px;flex:1;}

/* Link button */
.emp-link{
  display:inline-flex;align-items:center;gap:6px;
  font-size:.79rem;font-weight:700;border-radius:var(--rSM);
  padding:8px 16px;transition:all var(--t);text-decoration:none;margin-top:16px;
}
.emp-link-blue {background:var(--blue-lt);border:1.5px solid var(--blue-mid);color:var(--blue);}
.emp-link-blue:hover{background:var(--blue);color:#fff;border-color:var(--blue);box-shadow:0 4px 14px rgba(26,86,219,.3);}
.emp-link-green{background:var(--green-lt);border:1.5px solid #a7f3d0;color:var(--green);}
.emp-link-green:hover{background:var(--green);color:#fff;border-color:var(--green);box-shadow:0 4px 14px rgba(5,150,105,.3);}
.emp-link-amber{background:var(--amber-lt);border:1.5px solid #fde68a;color:var(--amber);}
.emp-link-amber:hover{background:var(--amber);color:#fff;border-color:var(--amber);box-shadow:0 4px 14px rgba(217,119,6,.3);}
.emp-link i{font-size:.68rem;transition:transform var(--t);}
.emp-link:hover i{transform:translateX(3px);}

/* Application rows */
.app-item{
  display:flex;align-items:center;gap:14px;
  padding:12px 0;border-bottom:1px solid var(--n100);
}
.app-item:last-of-type{border-bottom:none;}
.app-avatar{
  width:42px;height:42px;border-radius:12px;
  color:#fff;font-size:.75rem;font-weight:900;
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;letter-spacing:-.5px;
}
.av-blue  {background:linear-gradient(135deg,#1a56db,#60a5fa);box-shadow:0 3px 10px rgba(26,86,219,.3);}
.av-green {background:linear-gradient(135deg,#059669,#34d399);box-shadow:0 3px 10px rgba(5,150,105,.3);}
.av-purple{background:linear-gradient(135deg,#7c3aed,#a78bfa);box-shadow:0 3px 10px rgba(124,58,237,.3);}
.av-rose  {background:linear-gradient(135deg,#e11d48,#fb7185);box-shadow:0 3px 10px rgba(225,29,72,.3);}
.av-teal  {background:linear-gradient(135deg,#0d9488,#2dd4bf);box-shadow:0 3px 10px rgba(13,148,136,.3);}

.app-info{flex:1;min-width:0;}
.app-name{font-size:.85rem;font-weight:700;color:var(--n800);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.app-meta{font-size:.72rem;color:var(--n400);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* Job rows */
.job-item{
  display:flex;align-items:center;gap:13px;
  padding:11px 0;border-bottom:1px solid var(--n100);
}
.job-item:last-of-type{border-bottom:none;}
.job-ico{
  width:40px;height:40px;border-radius:11px;
  display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;
}
.job-ico-active {background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:var(--green);}
.job-ico-expired{background:linear-gradient(135deg,#fef2f2,#fee2e2);color:var(--red);}
.job-info{flex:1;min-width:0;}
.job-title-sm{font-size:.84rem;font-weight:700;color:var(--n800);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.job-meta{font-size:.72rem;color:var(--n400);margin-top:2px;}
.job-right{display:flex;flex-direction:column;align-items:flex-end;gap:5px;flex-shrink:0;}
.job-apps-pill{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.68rem;font-weight:700;
  background:var(--blue-lt);color:var(--blue);
  border-radius:100px;padding:3px 9px;
}

/* Notification rows */
.notif-item{
  display:flex;align-items:flex-start;gap:13px;
  padding:13px 0;border-bottom:1px solid var(--n100);
}
.notif-item:last-of-type{border-bottom:none;}
.notif-ico{
  width:38px;height:38px;border-radius:11px;
  display:flex;align-items:center;justify-content:center;
  font-size:.82rem;flex-shrink:0;margin-top:1px;
}
.notif-ico.app  {background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:var(--blue);}
.notif-ico.alert{background:linear-gradient(135deg,#fef3c7,#fde68a);color:var(--amber);}
.notif-ico.ok   {background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:var(--green);}
.notif-body{flex:1;min-width:0;}
.notif-title{font-size:.83rem;font-weight:700;color:var(--n800);}
.notif-msg{font-size:.74rem;color:var(--n500);margin-top:3px;line-height:1.45;}
.notif-date{font-size:.68rem;color:var(--n300);margin-top:4px;display:flex;align-items:center;gap:4px;}
.notif-dot{
  width:9px;height:9px;border-radius:50%;
  background:var(--blue);flex-shrink:0;margin-top:8px;
  box-shadow:0 0 0 3px rgba(26,86,219,.2);
  animation:nd-pulse 2s ease-in-out infinite;
}
@keyframes nd-pulse{
  0%,100%{box-shadow:0 0 0 3px rgba(26,86,219,.2);}
  50%    {box-shadow:0 0 0 5px rgba(26,86,219,.08);}
}

/* Status badges */
.badge{
  display:inline-flex;align-items:center;gap:3px;
  font-size:.68rem;font-weight:700;letter-spacing:.02em;
  border-radius:100px;padding:4px 10px;white-space:nowrap;flex-shrink:0;
}
.badge-green{background:linear-gradient(135deg,#dcfce7,#bbf7d0);color:#15803d;}
.badge-blue {background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#1d4ed8;}
.badge-amber{background:linear-gradient(135deg,#fef3c7,#fde68a);color:#b45309;}
.badge-red  {background:linear-gradient(135deg,#fee2e2,#fecaca);color:#b91c1c;}

@media(max-width:600px){
  .dash-welcome{padding:26px 22px;}
  .dw-title{font-size:1.4rem;}
  .stat-card-value{font-size:1.75rem;}
  .emp-card-body{padding:14px 16px 16px;}
  .emp-card-head{padding:14px 16px;}
}
</style>
@endpush

@section('content')
<div class="db-page">

{{-- ══ HERO ════════════════════════════════════════════ --}}
@php
  $hour    = now()->hour;
  $emoji   = $hour < 12 ? '☀️' : ($hour < 17 ? '🌤' : '🌙');
  $greet   = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
  $empName = auth()->check() ? auth()->user()->name : 'Karthik Selvan';
  $compName= 'TechBridge Solutions Pvt. Ltd.';
@endphp

<div class="dash-welcome">
  <div class="dw-dots"></div>
  <div class="dw-glow"></div>
  <div class="dw-ring dw-ring-1"></div>
  <div class="dw-ring dw-ring-2"></div>
  <div class="dw-ring dw-ring-3"></div>
  <div class="dw-text">
    <div class="dw-greeting">{{ $emoji }} {{ $greet }}</div>
    <div class="dw-title">{{ $empName }}</div>
    <div class="dw-company">
      <i class="fas fa-building" style="font-size:.78rem;"></i>
      {{ $compName }}
      <div class="dw-verified"><i class="fas fa-circle-check"></i> Verified Employer</div>
    </div>
  </div>
  <div class="dw-actions">
    <a href="{{ route('employer.jobs.create') }}" class="dw-btn dw-btn-white">
      <i class="fas fa-plus"></i> Post a Job
    </a>
    <a href="{{ route('employer.candidates') }}" class="dw-btn dw-btn-outline">
      <i class="fas fa-users"></i> View Candidates
    </a>
  </div>
</div>

{{-- ══ EXPIRY BAR ══════════════════════════════════════ --}}
<div class="plan-expiry-bar">
  <div class="peb-ico"><i class="fas fa-triangle-exclamation"></i></div>
  <span>Your <strong>30 Day Plan</strong> expires in <strong>7 days</strong> (10 Apr 2025). Renew to keep your listings live and visible.</span>
  <a href="{{ route('employer.billing') }}"><i class="fas fa-bolt"></i> Renew Now</a>
</div>

{{-- ══ QUICK ACTIONS ════════════════════════════════════ --}}
<div class="quick-actions">
  <a href="{{ route('employer.jobs.create') }}" class="qa-item qa-item-post">
    <div class="qa-ico qa-ico-blue"><i class="fas fa-plus-circle"></i></div>
    <div class="qa-content"><div class="qa-label">Post a Job</div><div class="qa-sub">Create new listing</div></div>
  </a>
  <a href="{{ route('employer.candidates') }}" class="qa-item qa-item-apps">
    <div class="qa-ico qa-ico-green"><i class="fas fa-users"></i></div>
    <div class="qa-content"><div class="qa-label">Applicants</div><div class="qa-sub">148 total received</div></div>
  </a>
  <a href="{{ route('employer.resume') }}" class="qa-item qa-item-resume">
    <div class="qa-ico qa-ico-purple"><i class="fas fa-database"></i></div>
    <div class="qa-content"><div class="qa-label">Resume Search</div><div class="qa-sub">18 downloads left</div></div>
  </a>
  <a href="{{ route('employer.billing') }}" class="qa-item qa-item-billing">
    <div class="qa-ico qa-ico-amber"><i class="fas fa-credit-card"></i></div>
    <div class="qa-content"><div class="qa-label">Billing</div><div class="qa-sub">Pro · Expires in 7d</div></div>
  </a>
</div>

{{-- ══ STAT CARDS ═══════════════════════════════════════ --}}
@php
$stats = [
  ['label'=>'Total Jobs Posted',  'value'=>12,    'icon'=>'fa-briefcase',         'cls'=>'sc-blue',   'trend'=>'+2 this month',   'up'=>true,  'badge'=>'+2 new'],
  ['label'=>'Active Jobs',        'value'=>7,     'icon'=>'fa-circle-check',      'cls'=>'sc-green',  'trend'=>'Live &amp; visible','up'=>true, 'badge'=>'Live'],
  ['label'=>'Expired Jobs',       'value'=>3,     'icon'=>'fa-clock-rotate-left', 'cls'=>'sc-red',    'trend'=>'Needs renewal',   'up'=>false, 'badge'=>'Action'],
  ['label'=>'Total Applications', 'value'=>148,   'icon'=>'fa-file-user',         'cls'=>'sc-purple', 'trend'=>'+24 this week',   'up'=>true,  'badge'=>'+24'],
  ['label'=>'Shortlisted',        'value'=>24,    'icon'=>'fa-star',              'cls'=>'sc-amber',  'trend'=>'Ready to review', 'up'=>true,  'badge'=>'24'],
  ['label'=>'Downloads Left',     'value'=>18,    'icon'=>'fa-download',          'cls'=>'sc-teal',   'trend'=>'of 30 total',     'up'=>true,  'badge'=>'60%'],
  ['label'=>'Current Plan',       'value'=>'Pro', 'icon'=>'fa-crown',             'cls'=>'sc-indigo', 'trend'=>'30 Day Plan',     'up'=>true,  'badge'=>'Active'],
  ['label'=>'Plan Expiry',        'value'=>'7d',  'icon'=>'fa-calendar-xmark',    'cls'=>'sc-rose',   'trend'=>'10 Apr 2025',     'up'=>false, 'badge'=>'Soon'],
];
@endphp
<div class="stat-grid">
  @foreach($stats as $s)
  <div class="stat-card {{ $s['cls'] }}">
    <div class="stat-card-top">
      <div class="stat-card-ico"><i class="fas {{ $s['icon'] }}"></i></div>
      <span class="stat-badge {{ $s['up'] ? 'up' : 'down' }}">
        <i class="fas {{ $s['up'] ? 'fa-arrow-up' : 'fa-arrow-down' }}" style="font-size:.52rem;"></i>
        {{ $s['badge'] }}
      </span>
    </div>
    <div class="stat-card-value">{{ $s['value'] }}</div>
    <div class="stat-card-label">{{ $s['label'] }}</div>
    <div class="stat-card-trend {{ $s['up'] ? 'up' : 'down' }}">
      <i class="fas {{ $s['up'] ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
      {!! $s['trend'] !!}
    </div>
  </div>
  @endforeach
</div>

{{-- ══ LOWER 3-COL ══════════════════════════════════════ --}}
<div class="dash-lower">

  {{-- COL 1 · Recent Applications --}}
  <div class="emp-card">
    <div class="emp-card-head emp-card-head-blue">
      <div class="emp-card-head-ico ico-blue"><i class="fas fa-file-user"></i></div>
      <div>
        <div class="emp-card-head-title">Recent Applications</div>
        <div class="emp-card-head-sub">Latest candidate activity</div>
      </div>
      <div class="emp-card-head-badge badge-pill-blue">5 new</div>
    </div>
    <div class="emp-card-body">
      @php
      $apps = [
        ['name'=>'Arun Kumar',  'job'=>'Senior React Developer','status'=>'Shortlisted','date'=>'14 Mar','cls'=>'badge-green','av'=>'av-blue'],
        ['name'=>'Priya Devi',  'job'=>'UI/UX Designer',        'status'=>'New',        'date'=>'12 Mar','cls'=>'badge-blue', 'av'=>'av-green'],
        ['name'=>'Murugan S',   'job'=>'Sales Executive',       'status'=>'Interview',  'date'=>'13 Mar','cls'=>'badge-amber','av'=>'av-purple'],
        ['name'=>'Vijay Anand', 'job'=>'Senior React Developer','status'=>'New',        'date'=>'10 Mar','cls'=>'badge-blue', 'av'=>'av-rose'],
        ['name'=>'Kavitha M',   'job'=>'Operations Manager',    'status'=>'Shortlisted','date'=>'09 Mar','cls'=>'badge-green','av'=>'av-teal'],
      ];
      @endphp
      @foreach($apps as $a)
      <div class="app-item">
        <div class="app-avatar {{ $a['av'] }}">{{ strtoupper(substr($a['name'],0,1).substr(strrchr($a['name'],' '),1,1)) }}</div>
        <div class="app-info">
          <div class="app-name">{{ $a['name'] }}</div>
          <div class="app-meta"><i class="fas fa-briefcase" style="font-size:.58rem;margin-right:3px;"></i>{{ $a['job'] }} · {{ $a['date'] }}</div>
        </div>
        <span class="badge {{ $a['cls'] }}">{{ $a['status'] }}</span>
      </div>
      @endforeach
      <a href="{{ route('employer.candidates') }}" class="emp-link emp-link-blue">
        View All Applications <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  {{-- COL 2 · Recent Jobs --}}
  <div class="emp-card">
    <div class="emp-card-head emp-card-head-green">
      <div class="emp-card-head-ico ico-green"><i class="fas fa-briefcase"></i></div>
      <div>
        <div class="emp-card-head-title">Jobs Posted</div>
        <div class="emp-card-head-sub">Your active listings</div>
      </div>
      <div class="emp-card-head-badge badge-pill-green">7 live</div>
    </div>
    <div class="emp-card-body">
      @php
      $jobs = [
        ['title'=>'Senior React Developer','apps'=>32,'status'=>'Active', 'cls'=>'badge-green','ico'=>'job-ico-active', 'date'=>'01 Mar'],
        ['title'=>'Operations Manager',    'apps'=>18,'status'=>'Active', 'cls'=>'badge-green','ico'=>'job-ico-active', 'date'=>'05 Mar'],
        ['title'=>'Sales Executive',       'apps'=>27,'status'=>'Active', 'cls'=>'badge-green','ico'=>'job-ico-active', 'date'=>'10 Mar'],
        ['title'=>'UI/UX Designer',        'apps'=>45,'status'=>'Expired','cls'=>'badge-red',  'ico'=>'job-ico-expired','date'=>'20 Feb'],
      ];
      @endphp
      @foreach($jobs as $j)
      <div class="job-item">
        <div class="job-ico {{ $j['ico'] }}"><i class="fas fa-briefcase"></i></div>
        <div class="job-info">
          <div class="job-title-sm">{{ $j['title'] }}</div>
          <div class="job-meta"><i class="fas fa-calendar-days" style="font-size:.58rem;margin-right:3px;"></i>{{ $j['date'] }}</div>
        </div>
        <div class="job-right">
          <span class="badge {{ $j['cls'] }}">{{ $j['status'] }}</span>
          <span class="job-apps-pill"><i class="fas fa-user" style="font-size:.55rem;"></i>{{ $j['apps'] }}</span>
        </div>
      </div>
      @endforeach
      <a href="{{ route('employer.jobs.index') }}" class="emp-link emp-link-green">
        Manage All Jobs <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  {{-- COL 3 · Notifications --}}
  <div class="emp-card">
    <div class="emp-card-head emp-card-head-amber">
      <div class="emp-card-head-ico ico-amber"><i class="fas fa-bell"></i></div>
      <div>
        <div class="emp-card-head-title">Notifications</div>
        <div class="emp-card-head-sub">Recent alerts</div>
      </div>
      <div class="emp-card-head-badge badge-pill-rose">2 unread</div>
    </div>
    <div class="emp-card-body">
      @php
      $notifs = [
        ['type'=>'app',   'ico'=>'fa-file-user',            'title'=>'New Application',      'msg'=>'Arun Kumar applied for Senior React Developer.',    'date'=>'14 Mar · 9:42 am', 'unread'=>true],
        ['type'=>'alert', 'ico'=>'fa-triangle-exclamation', 'title'=>'Plan Expiry Alert',     'msg'=>'Your 30-day plan expires in 7 days. Renew now.',     'date'=>'13 Mar · 2:15 pm', 'unread'=>true],
        ['type'=>'ok',    'ico'=>'fa-circle-check',         'title'=>'Verification Approved', 'msg'=>'TechBridge Solutions verified successfully.',         'date'=>'10 Mar · 11:00 am','unread'=>false],
      ];
      @endphp
      @foreach($notifs as $n)
      <div class="notif-item">
        <div class="notif-ico {{ $n['type'] }}"><i class="fas {{ $n['ico'] }}"></i></div>
        <div class="notif-body">
          <div class="notif-title">{{ $n['title'] }}</div>
          <div class="notif-msg">{{ $n['msg'] }}</div>
          <div class="notif-date"><i class="fas fa-clock" style="font-size:.6rem;"></i>{{ $n['date'] }}</div>
        </div>
        @if($n['unread'])<div class="notif-dot"></div>@endif
      </div>
      @endforeach
      <a href="{{ route('employer.notifications') }}" class="emp-link emp-link-amber">
        All Notifications <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

</div>{{-- dash-lower --}}
</div>{{-- db-page --}}
@endsection