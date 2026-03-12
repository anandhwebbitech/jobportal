{{-- ════════════════════════════════════════════════════════
     resources/views/frontend/home.blade.php
     STATIC VERSION — no backend data, no @auth
════════════════════════════════════════════════════════ --}}

@extends('frontend.app')
@section('title', 'LinearJobs – Find Your Next Job in Tamil Nadu')

{{-- ═══════════════════════════════
     PAGE CSS (home-specific)
═══════════════════════════════ --}}
@push('styles')
{{-- Font Awesome 6 Free CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

/* ── HERO ──────────────────────────────────────────────────── */
.lj-hero {
  background: #fff;
  padding: 60px 20px 52px;
  text-align: center;
  border-bottom: var(--border);
}
.lj-hero-logo {
  font-size: clamp(2.4rem, 8vw, 4.4rem);
  font-weight: 800; color: var(--blue);
  letter-spacing: -2px; line-height: 1;
  margin-bottom: 10px;
}
.lj-hero-title {
  font-size: clamp(1rem, 2.6vw, 1.2rem);
  font-weight: 700; color: var(--n900); margin-bottom: 6px;
}
.lj-hero-sub {
  font-size: .9375rem; color: var(--n500);
  margin-bottom: 28px; line-height: 1.6;
}

/* Search bar */
.lj-search-box {
  max-width: 800px; margin: 0 auto 14px;
  background: #fff;
  border: 1.5px solid var(--n200);
  border-radius: var(--r);
  box-shadow: var(--sh-md);
  display: flex; align-items: stretch;
  overflow: hidden;
  transition: border-color var(--t), box-shadow var(--t);
}
.lj-search-box:focus-within {
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(26,86,219,.13);
}
.lj-search-ico {
  display: flex; align-items: center;
  padding: 0 14px 0 16px;
  color: var(--n400); font-size: .9rem; flex-shrink: 0;
}
.lj-search-input {
  flex: 1.5; min-width: 0;
  border: none; outline: none;
  font-family: var(--f); font-size: .9375rem; color: var(--n900);
  padding: 14px 10px 14px 0; background: transparent;
}
.lj-search-input::placeholder { color: var(--n400); }
.lj-search-sep {
  width: 1px; background: var(--n200);
  flex-shrink: 0; align-self: stretch; margin: 9px 0;
}
.lj-search-sel {
  flex: 1; min-width: 0;
  border: none; outline: none;
  font-family: var(--f); font-size: .875rem; color: var(--n700);
  padding: 14px 32px 14px 14px;
  background: transparent; cursor: pointer;
  appearance: none; -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.lj-search-sel option { background: #fff; color: var(--n900); }
.lj-search-cta { flex-shrink: 0; padding: 6px; display: flex; align-items: stretch; }
.lj-search-btn {
  display: flex; align-items: center; gap: 8px;
  background: var(--blue); color: #fff; border: none;
  border-radius: calc(var(--r) - 2px);
  font-family: var(--f); font-size: .9375rem; font-weight: 600;
  padding: 0 22px; cursor: pointer; white-space: nowrap;
  transition: background var(--t);
}
.lj-search-btn:hover { background: var(--blue-h); }

/* Trending tags */
.lj-trend-row {
  max-width: 800px; margin: 0 auto;
  display: flex; align-items: center;
  flex-wrap: wrap; gap: 6px; justify-content: center;
  font-size: .8125rem; color: var(--n500);
}
.lj-trend-label { font-weight: 600; color: var(--n700); }
.lj-trend-tag {
  display: inline-flex; align-items: center;
  color: var(--blue); background: var(--blue-lt);
  border: 1px solid var(--blue-mid);
  border-radius: 100px; padding: 3px 12px;
  font-size: .8rem; font-weight: 500; cursor: pointer;
  transition: background var(--t), color var(--t), border-color var(--t);
}
.lj-trend-tag:hover { background: var(--blue); color: #fff; border-color: var(--blue); }

/* Mobile search */
@media (max-width: 600px) {
  .lj-hero { padding: 40px 16px 36px; }
  .lj-search-box    { flex-direction: column; }
  .lj-search-ico    { padding: 14px 14px 0; justify-content: flex-start; }
  .lj-search-input  { padding: 10px 14px; }
  .lj-search-sep    { width: calc(100% - 28px); height: 1px; margin: 0 14px; align-self: auto; }
  .lj-search-sel    { padding: 11px 32px 11px 14px; }
  .lj-search-cta    { padding: 6px 8px 8px; }
  .lj-search-btn    { width: 100%; justify-content: center; padding: 12px; border-radius: var(--r-sm); }
}

/* ── STATS BAR ─────────────────────────────────────────────── */
.lj-stats {
  background: var(--n50);
  border-bottom: var(--border);
  padding: 14px 20px;
}
.lj-stats-row {
  max-width: 780px; margin: 0 auto;
  display: flex; align-items: center;
  justify-content: center; flex-wrap: wrap;
}
.lj-stat {
  text-align: center; padding: 6px 28px;
  border-right: var(--border);
}
.lj-stat:last-child { border-right: none; }
.lj-stat-val {
  font-size: 1.25rem; font-weight: 800;
  color: var(--blue); line-height: 1; margin-bottom: 2px;
}
.lj-stat-lbl { font-size: .72rem; color: var(--n500); }

@media (max-width: 560px) {
  .lj-stats { padding: 10px 16px; }
  .lj-stats-row { gap: 0; }
  .lj-stat { flex: 1 1 50%; padding: 10px 8px; border-right: none; border-bottom: var(--border); }
  .lj-stat:nth-child(odd)   { border-right: var(--border); }
  .lj-stat:nth-child(3),
  .lj-stat:nth-child(4)     { border-bottom: none; }
}

/* ── CHIPS BAR ─────────────────────────────────────────────── */
.lj-chips-bar {
  border-bottom: var(--border); background: #fff;
  padding: 0 20px;
  overflow-x: auto; -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.lj-chips-bar::-webkit-scrollbar { display: none; }
.lj-chips-inner {
  max-width: 1160px; margin: 0 auto;
  display: flex; align-items: center;
  gap: 8px; padding: 12px 0; min-width: max-content;
}
.lj-chips-lbl {
  font-size: .8rem; font-weight: 700; color: var(--n500);
  white-space: nowrap; margin-right: 4px; flex-shrink: 0;
}

/* ── AUDIENCE CARDS ─────────────────────────────────────────── */
.lj-aud-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
}
.lj-aud-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--r-lg); padding: 32px 28px;
  transition: border-color var(--t), box-shadow var(--t), transform var(--t);
}
.lj-aud-card:hover { border-color: var(--blue); box-shadow: var(--sh-lg); transform: translateY(-2px); }
.lj-aud-ico {
  width: 48px; height: 48px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; margin-bottom: 16px;
}
.lj-aud-ico-blue  { background: var(--blue-lt); color: var(--blue); }
.lj-aud-ico-green { background: var(--green-lt); color: var(--green); }
.lj-aud-title { font-size: 1.1rem; font-weight: 700; color: var(--n900); margin-bottom: 8px; }
.lj-aud-desc  { font-size: .9rem; color: var(--n500); line-height: 1.65; margin-bottom: 20px; }
.lj-aud-btns  { display: flex; gap: 10px; flex-wrap: wrap; }

@media (max-width: 680px) {
  .lj-aud-grid { grid-template-columns: 1fr; }
  .lj-aud-card { padding: 24px 20px; }
}
@media (max-width: 400px) {
  .lj-aud-btns { flex-direction: column; }
  .lj-aud-btns .lj-btn { width: 100%; justify-content: center; }
}

/* ── FEATURE CARDS ──────────────────────────────────────────── */
.lj-feat-grid {
  display: grid; grid-template-columns: repeat(4,1fr); gap: 16px;
}
.lj-feat-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--r-lg); padding: 22px 18px;
  position: relative; overflow: hidden;
  transition: border-color var(--t), box-shadow var(--t), transform var(--t);
}
.lj-feat-card::after {
  content: ''; position: absolute;
  bottom: 0; left: 0; right: 0; height: 3px;
  transform: scaleX(0); transform-origin: left;
  transition: transform .25s ease;
}
.lj-feat-card:hover { box-shadow: var(--sh-lg); transform: translateY(-3px); }
.lj-feat-card:hover::after { transform: scaleX(1); }
.lj-fc-b:hover  { border-color: var(--blue); }   .lj-fc-b::after { background: var(--blue); }
.lj-fc-g:hover  { border-color: var(--green); }  .lj-fc-g::after { background: var(--green); }
.lj-fc-a:hover  { border-color: var(--amber); }  .lj-fc-a::after { background: var(--amber); }
.lj-fc-r:hover  { border-color: var(--red); }    .lj-fc-r::after { background: var(--red); }
.lj-feat-ico {
  width: 42px; height: 42px; border-radius: var(--r);
  display: flex; align-items: center; justify-content: center;
  font-size: .95rem; margin-bottom: 14px;
}
.lj-fi-b { background: var(--blue-lt);  color: var(--blue); }
.lj-fi-g { background: var(--green-lt); color: var(--green); }
.lj-fi-a { background: #fef3c7; color: #b45309; }
.lj-fi-r { background: #fee2e2; color: #b91c1c; }
.lj-feat-name { font-size: .9375rem; font-weight: 700; color: var(--n900); margin-bottom: 6px; }
.lj-feat-text { font-size: .8125rem; color: var(--n500); line-height: 1.6; }

@media (max-width: 900px) { .lj-feat-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 480px)  { .lj-feat-grid { grid-template-columns: 1fr; } }

/* ── JOB CARDS ──────────────────────────────────────────────── */
.lj-jobs-hdr {
  display: flex; align-items: flex-end;
  justify-content: space-between;
  flex-wrap: wrap; gap: 12px; margin-bottom: 22px;
}
.lj-jobs-grid {
  display: grid; grid-template-columns: repeat(3,1fr); gap: 16px;
}
.lj-job-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--r-lg); padding: 20px;
  display: flex; flex-direction: column; position: relative;
  transition: border-color var(--t), box-shadow var(--t), transform var(--t);
}
.lj-job-card:hover { border-color: var(--blue); box-shadow: var(--sh-lg); transform: translateY(-2px); }
.lj-job-top { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
.lj-co-logo {
  width: 46px; height: 46px; flex-shrink: 0;
  border-radius: var(--r); border: var(--border);
  display: flex; align-items: center; justify-content: center;
  font-size: .8125rem; font-weight: 800; letter-spacing: -.5px;
}
.lj-job-name {
  font-size: .9375rem; font-weight: 700;
  color: var(--blue); line-height: 1.3; margin-bottom: 2px; cursor: pointer;
}
.lj-job-name:hover { text-decoration: underline; }
.lj-job-co    { font-size: .8125rem; color: var(--n500); }
.lj-job-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
.lj-job-sal   { font-size: .8125rem; font-weight: 700; color: var(--green); margin-bottom: 14px; margin-top: auto; }
.lj-job-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.lj-btn-apply       { background: var(--blue);  color: #fff; border-color: var(--blue); }
.lj-btn-apply:hover { background: var(--blue-h); border-color: var(--blue-h); color: #fff; }
.lj-btn-view        { background: #fff; color: var(--blue); border-color: var(--blue); }
.lj-btn-view:hover  { background: var(--blue-lt); color: var(--blue); }
.lj-posted { font-size: .72rem; color: var(--n400); margin-top: 10px; display: flex; align-items: center; gap: 4px; }

@media (max-width: 960px) { .lj-jobs-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 540px)  { .lj-jobs-grid { grid-template-columns: 1fr; } }

/* ── LOYALTY BANNER ─────────────────────────────────────────── */
.lj-loyalty { background: var(--blue); padding: 52px 20px; text-align: center; }
.lj-loy-body { max-width: 580px; margin: 0 auto; }
.lj-loy-shield {
  width: 58px; height: 58px; border-radius: 50%;
  background: rgba(255,255,255,.15);
  border: 2px solid rgba(255,255,255,.28);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; margin: 0 auto 18px;
}
.lj-loy-title { font-size: clamp(1.2rem,3.5vw,1.5rem); font-weight: 800; color: #fff; letter-spacing: -.25px; margin-bottom: 10px; }
.lj-loy-text  { font-size: .9375rem; color: rgba(255,255,255,.82); line-height: 1.7; margin-bottom: 22px; }
.lj-loy-tags  { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 26px; }
.lj-loy-tag {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: .8rem; font-weight: 600;
  color: rgba(255,255,255,.92);
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: var(--r-sm); padding: 6px 14px;
}
.lj-loy-tag i { font-size: .68rem; color: #6ee7b7; }

/* ═══════════════════════════════════════════════════════
   ── PREMIUM ADVERTISEMENT SECTION ─────────────────────
═══════════════════════════════════════════════════════ */

.lj-ads {
  background: #f1f4f9;
  padding: 52px 0 58px;
  position: relative;
  overflow: hidden;
}

/* Soft ambient blobs */
.lj-ads::before {
  content: '';
  position: absolute;
  top: -80px; left: -80px;
  width: 340px; height: 340px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,86,219,0.07) 0%, transparent 70%);
  pointer-events: none;
}
.lj-ads::after {
  content: '';
  position: absolute;
  bottom: -60px; right: -60px;
  width: 280px; height: 280px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(16,185,129,0.07) 0%, transparent 70%);
  pointer-events: none;
}

/* ── Sponsored label pill ── */
.lj-ads-lbl {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 24px;
}
.lj-ads-lbl-inner {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: #fff;
  border: 1.5px solid #e0e5ef;
  border-radius: 100px;
  padding: 5px 16px 5px 10px;
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: #7c8499;
  box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.lj-ads-lbl-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: #f59e0b;
  box-shadow: 0 0 0 3px rgba(245,158,11,.2);
  flex-shrink: 0;
  animation: lj-pulse-dot 2.2s ease-in-out infinite;
}
@keyframes lj-pulse-dot {
  0%, 100% { box-shadow: 0 0 0 3px rgba(245,158,11,.2); }
  50%       { box-shadow: 0 0 0 5px rgba(245,158,11,.1); }
}

/* ── Ad grid ── */
.lj-ad-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  position: relative;
  z-index: 1;
}

/* ── Ad card shell ── */
.lj-ad-card {
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 18px;
  overflow: hidden;
  border: 1.5px solid #e2e8f2;
  text-decoration: none;
  position: relative;
  transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
  box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.lj-ad-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(0,0,0,.11);
  border-color: transparent;
}

/* ── Image / visual banner area ── */
.lj-ad-banner {
  width: 100%;
  height: 148px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  flex-shrink: 0;
}

/* Card 1 – SkillBridge: blue gradient */
.lj-ad-banner-blue {
  background: linear-gradient(135deg, #1a56db 0%, #3b82f6 55%, #60a5fa 100%);
}
/* Card 2 – MSMEPro: green gradient */
.lj-ad-banner-green {
  background: linear-gradient(135deg, #059669 0%, #10b981 55%, #34d399 100%);
}

/* Decorative circles in banner */
.lj-ad-banner-ring {
  position: absolute;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,.18);
  pointer-events: none;
}
.lj-ad-banner-ring-1 { width: 140px; height: 140px; top: -30px; right: -30px; }
.lj-ad-banner-ring-2 { width: 90px;  height: 90px;  bottom: -20px; left: 20px; border-color: rgba(255,255,255,.1); }
.lj-ad-banner-ring-3 { width: 55px;  height: 55px;  top: 16px; left: 50px; border-color: rgba(255,255,255,.12); }

/* Central icon circle in banner */
.lj-ad-banner-ico-wrap {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}
.lj-ad-banner-ico {
  width: 68px; height: 68px;
  border-radius: 50%;
  background: rgba(255,255,255,.18);
  border: 2px solid rgba(255,255,255,.35);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.75rem;
  color: #fff;
  backdrop-filter: blur(4px);
  box-shadow: 0 4px 18px rgba(0,0,0,.15);
}
.lj-ad-banner-tagline {
  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: rgba(255,255,255,.85);
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.22);
  border-radius: 100px;
  padding: 3px 12px;
}

/* Badge pinned top-left */
.lj-ad-badge {
  position: absolute;
  top: 10px; left: 10px;
  z-index: 3;
  font-size: .6rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: rgba(255,255,255,.9);
  background: rgba(0,0,0,.25);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 100px;
  padding: 3px 9px;
  backdrop-filter: blur(4px);
}

/* ── Ad body (below banner) ── */
.lj-ad-body {
  padding: 18px 20px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.lj-ad-name {
  font-size: 1rem;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 5px;
  letter-spacing: -.2px;
}
.lj-ad-desc {
  font-size: .8125rem;
  color: #64748b;
  line-height: 1.6;
  margin-bottom: 14px;
  flex: 1;
}

/* Offer badge row */
.lj-ad-offer-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 14px;
}
.lj-ad-offer-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: .72rem;
  font-weight: 700;
  border-radius: 6px;
  padding: 4px 10px;
}
.lj-ad-offer-badge-blue  { background: #eff6ff; color: #1d4ed8; }
.lj-ad-offer-badge-green { background: #f0fdf4; color: #15803d; }
.lj-ad-offer-badge i     { font-size: .62rem; }

/* CTA row */
.lj-ad-cta-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid #f1f5f9;
  padding-top: 13px;
  margin-top: auto;
}
.lj-ad-cta-link {
  font-size: .8125rem;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: 8px;
  padding: 7px 14px;
  transition: background .18s, color .18s;
  text-decoration: none;
}
.lj-ad-cta-link-blue  { background: #eff6ff; color: #1d4ed8; }
.lj-ad-cta-link-green { background: #f0fdf4; color: #15803d; }
.lj-ad-card:hover .lj-ad-cta-link-blue  { background: #1d4ed8; color: #fff; }
.lj-ad-card:hover .lj-ad-cta-link-green { background: #15803d; color: #fff; }
.lj-ad-cta-link i { font-size: .7rem; transition: transform .18s; }
.lj-ad-card:hover .lj-ad-cta-link i { transform: translateX(3px); }

.lj-ad-trust {
  font-size: .7rem;
  color: #94a3b8;
  display: flex;
  align-items: center;
  gap: 4px;
}
.lj-ad-trust i { font-size: .65rem; color: #f59e0b; }

/* ── Responsive ── */
@media (max-width: 660px) {
  .lj-ad-grid { grid-template-columns: 1fr; }
  .lj-ad-banner { height: 130px; }
}
@media (max-width: 400px) {
  .lj-ad-body { padding: 14px 16px 16px; }
}

</style>
@endpush


{{-- ═══════════════════════════════════════════════════
     PAGE CONTENT
═══════════════════════════════════════════════════ --}}
@section('content')

{{-- ── HERO ────────────────────────────────────────── --}}
<section class="lj-hero">

  <div class="lj-hero-logo lj-anim">LinearJobs</div>

  <div class="lj-anim lj-anim-d1">
    <div class="lj-hero-title">Find Your Next Job in Tamil Nadu</div>
    <div class="lj-hero-sub">Connecting skilled professionals with verified MSME employers.</div>
  </div>

  {{-- Search Bar --}}
  <div class="lj-anim lj-anim-d2">
    <div class="lj-search-box" id="ljSearchBox">
      <div class="lj-search-ico">
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <input
        class="lj-search-input"
        id="ljSearchInput"
        type="text"
        placeholder="Job title, keywords, or company"
        autocomplete="off"
      />
      <div class="lj-search-sep"></div>
      <select class="lj-search-sel" id="ljSkillSel">
        <option value="" disabled selected>Select Skill</option>
        <option>PHP Developer</option>
        <option>Java Developer</option>
        <option>Python Developer</option>
        <option>React Developer</option>
        <option>Electrician</option>
        <option>Machine Operator</option>
        <option>Sales Executive</option>
        <option>Data Entry</option>
        <option>HR Executive</option>
        <option>Accountant</option>
        <option>Welder</option>
        <option>Driver</option>
      </select>
      <div class="lj-search-sep"></div>
      <select class="lj-search-sel" id="ljLocSel">
        <option value="" disabled selected>Location</option>
        <option>Chennai</option>
        <option>Coimbatore</option>
        <option>Madurai</option>
        <option>Tiruchirappalli</option>
        <option>Salem</option>
        <option>Tirunelveli</option>
        <option>Erode</option>
        <option>Vellore</option>
        <option>Thanjavur</option>
        <option>Dindigul</option>
        <option>Remote</option>
      </select>
      <div class="lj-search-cta">
        <button class="lj-search-btn" id="ljSearchBtn">
          <i class="fa-solid fa-magnifying-glass"></i>
          <span>Find jobs</span>
        </button>
      </div>
    </div>
  </div>

  {{-- Trending tags --}}
  <div class="lj-anim lj-anim-d3">
    <div class="lj-trend-row">
      <span class="lj-trend-label">
        <i class="fa-solid fa-fire-flame-curved" style="color:#f97316; margin-right:4px;"></i>Trending:
      </span>
      <a href="find-jobs.html?q=Software+Engineer" class="lj-trend-tag">
        <i class="fa-solid fa-laptop-code" style="margin-right:5px; font-size:.7rem;"></i>Software Engineer
      </a>
      <a href="find-jobs.html?q=Machine+Operator" class="lj-trend-tag">
        <i class="fa-solid fa-gears" style="margin-right:5px; font-size:.7rem;"></i>Machine Operator
      </a>
      <a href="find-jobs.html?q=Sales+Executive" class="lj-trend-tag">
        <i class="fa-solid fa-handshake" style="margin-right:5px; font-size:.7rem;"></i>Sales Executive
      </a>
      <a href="find-jobs.html?q=Data+Entry" class="lj-trend-tag">
        <i class="fa-solid fa-keyboard" style="margin-right:5px; font-size:.7rem;"></i>Data Entry
      </a>
      <a href="find-jobs.html?q=Electrician" class="lj-trend-tag">
        <i class="fa-solid fa-bolt" style="margin-right:5px; font-size:.7rem;"></i>Electrician
      </a>
      <a href="find-jobs.html?q=Fresher" class="lj-trend-tag">
        <i class="fa-solid fa-graduation-cap" style="margin-right:5px; font-size:.7rem;"></i>Fresher Jobs
      </a>
    </div>
  </div>

</section>



{{-- ── AUDIENCE SPLIT ──────────────────────────────── --}}
<section class="lj-section">
  <div class="lj-wrap">
    <div class="lj-aud-grid">

      <div class="lj-aud-card" data-reveal>
        <div class="lj-aud-ico lj-aud-ico-blue">
          <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="lj-aud-title">Looking for a Job?</div>
        <div class="lj-aud-desc">
          Find thousands of opportunities from trusted employers across Tamil Nadu.
          Create your profile and get matched with the right role based on your skills.
        </div>
        <div class="lj-aud-btns">
          <a href="login.html" class="lj-btn lj-btn-blue">
            <i class="fa-solid fa-right-to-bracket" style="margin-right:6px;"></i>Login as Job Seeker
          </a>
          <a href="{{ route('jobseeker.register') }}" class="lj-btn lj-btn-ghost">
            <i class="fa-solid fa-user-plus" style="margin-right:6px;"></i>Register as Job Seeker
          </a>
        </div>
      </div>

      <div class="lj-aud-card" data-reveal>
        <div class="lj-aud-ico lj-aud-ico-green">
          <i class="fa-solid fa-building"></i>
        </div>
        <div class="lj-aud-title">Looking to Hire Talent?</div>
        <div class="lj-aud-desc">
          Post job openings and connect with skilled professionals quickly.
          Affordable plans built for Tamil Nadu MSMEs — starting at just ₹600.
        </div>
        <div class="lj-aud-btns">
          <a href="employer-login.html" class="lj-btn lj-btn-green">
            <i class="fa-solid fa-right-to-bracket" style="margin-right:6px;"></i>Employer Login
          </a>
          <a href="employer-register.html" class="lj-btn lj-btn-ghost-green">
            <i class="fa-solid fa-building-circle-check" style="margin-right:6px;"></i>Register Company
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<hr class="lj-rule"/>


{{-- ── FEATURES ────────────────────────────────────── --}}
<section class="lj-section lj-bg-gray">
  <div class="lj-wrap">
    <div style="text-align:center; margin-bottom:28px;">
      <div class="lj-eyebrow">Why LinearJobs</div>
      <div class="lj-heading">Built for Tamil Nadu</div>
    </div>
    <div class="lj-feat-grid">

      <div class="lj-feat-card lj-fc-b" data-reveal>
        <div class="lj-feat-ico lj-fi-b">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div class="lj-feat-name">Trusted by MSMEs</div>
        <div class="lj-feat-text">Hundreds of verified small and medium businesses rely on LinearJobs to find reliable talent efficiently.</div>
      </div>

      <div class="lj-feat-card lj-fc-g" data-reveal>
        <div class="lj-feat-ico lj-fi-g">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="lj-feat-name">Verified Employers</div>
        <div class="lj-feat-text">Every employer is verified with GST and PAN documents, ensuring a safe and authentic job search experience.</div>
      </div>

      <div class="lj-feat-card lj-fc-a" data-reveal>
        <div class="lj-feat-ico lj-fi-a">
          <i class="fa-solid fa-tag"></i>
        </div>
        <div class="lj-feat-name">Affordable Hiring</div>
        <div class="lj-feat-text">Post jobs starting at just ₹600. Budget-friendly plans designed for growing businesses across Tamil Nadu.</div>
      </div>

      <div class="lj-feat-card lj-fc-r" data-reveal>
        <div class="lj-feat-ico lj-fi-r">
          <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <div class="lj-feat-name">Tamil Nadu Focused</div>
        <div class="lj-feat-text">Covering all 32 districts with region-specific listings and dedicated support for local job seekers.</div>
      </div>

    </div>
  </div>
</section>

<hr class="lj-rule"/>


{{-- ── LOYALTY ──────────────────────────────────────── --}}
<section class="lj-loyalty">
  <div class="lj-loy-body">
    <div class="lj-loy-shield">
      <i class="fa-solid fa-shield-heart" style="color:#fff; font-size:1.5rem;"></i>
    </div>
    <div class="lj-loy-title">100% Loyalty to Job Seekers</div>
    <div class="lj-loy-text">
      We provide 100% loyalty to job seekers and connect them only with verified and trusted employers.
      No fake listings. No spam. Just real opportunities from real companies across every district in Tamil Nadu.
    </div>
    <div class="lj-loy-tags">
      <span class="lj-loy-tag">
        <i class="fa-solid fa-circle-check"></i> Zero Fake Listings
      </span>
      <span class="lj-loy-tag">
        <i class="fa-solid fa-user-shield"></i> Verified Employers Only
      </span>
      <span class="lj-loy-tag">
        <i class="fa-solid fa-hand-holding-heart"></i> Free to Apply
      </span>
      <span class="lj-loy-tag">
        <i class="fa-solid fa-lock"></i> Safe &amp; Private
      </span>
    </div>
    <a href="{{ route('jobseeker.register') }}" class="lj-btn lj-btn-white lj-btn-lg">
      Create Free Account <i class="fa-solid fa-arrow-right" style="font-size:.78rem; margin-left:4px;"></i>
    </a>
  </div>
</section>


{{-- ══════════════════════════════════════════════════════
     ── PREMIUM ADVERTISEMENT SECTION ────────────────────
══════════════════════════════════════════════════════ --}}
<section class="lj-ads">
  <div class="lj-wrap">

    {{-- Sponsored label --}}
    <div class="lj-ads-lbl">
      <div class="lj-ads-lbl-inner">
        <span class="lj-ads-lbl-dot"></span>
        <i class="fa-solid fa-rectangle-ad"></i> Sponsored
      </div>
    </div>

    <div class="lj-ad-grid">

      {{-- ── AD CARD 1 : SkillBridge Academy ── --}}
      <a href="#" class="lj-ad-card">

        {{-- Visual banner --}}
        <div class="lj-ad-banner lj-ad-banner-blue">
          {{-- Decorative rings --}}
          <div class="lj-ad-banner-ring lj-ad-banner-ring-1"></div>
          <div class="lj-ad-banner-ring lj-ad-banner-ring-2"></div>
          <div class="lj-ad-banner-ring lj-ad-banner-ring-3"></div>
          {{-- Sponsored badge --}}
          <span class="lj-ad-badge">
            <i class="fa-solid fa-circle-info" style="font-size:.55rem; margin-right:2px;"></i> Ad
          </span>
          {{-- Center icon + tagline --}}
          <div class="lj-ad-banner-ico-wrap">
            <div class="lj-ad-banner-ico">
              <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <span class="lj-ad-banner-tagline">Online Learning</span>
          </div>
        </div>

        {{-- Body --}}
        <div class="lj-ad-body">
          <div class="lj-ad-name">SkillBridge Academy</div>
          <div class="lj-ad-desc">
            Upgrade your skills with India's top online courses. Get certified and land your dream job faster with industry-recognized programs.
          </div>

          {{-- Offer badge --}}
          <div class="lj-ad-offer-row">
            <span class="lj-ad-offer-badge lj-ad-offer-badge-blue">
              <i class="fa-solid fa-bolt"></i> 50% OFF This Month
            </span>
            <span class="lj-ad-offer-badge lj-ad-offer-badge-blue">
              <i class="fa-solid fa-certificate"></i> Certified Courses
            </span>
          </div>

          {{-- CTA row --}}
          <div class="lj-ad-cta-row">
            <span class="lj-ad-cta-link lj-ad-cta-link-blue">
              Visit SkillBridge.in <i class="fa-solid fa-arrow-right"></i>
            </span>
            <span class="lj-ad-trust">
              <i class="fa-solid fa-star"></i> 4.8 · 12k+ learners
            </span>
          </div>
        </div>

      </a>{{-- end card 1 --}}

      {{-- ── AD CARD 2 : MSMEPro Services ── --}}
      <a href="#" class="lj-ad-card">

        {{-- Visual banner --}}
        <div class="lj-ad-banner lj-ad-banner-green">
          {{-- Decorative rings --}}
          <div class="lj-ad-banner-ring lj-ad-banner-ring-1"></div>
          <div class="lj-ad-banner-ring lj-ad-banner-ring-2"></div>
          <div class="lj-ad-banner-ring lj-ad-banner-ring-3"></div>
          {{-- Sponsored badge --}}
          <span class="lj-ad-badge">
            <i class="fa-solid fa-circle-info" style="font-size:.55rem; margin-right:2px;"></i> Ad
          </span>
          {{-- Center icon + tagline --}}
          <div class="lj-ad-banner-ico-wrap">
            <div class="lj-ad-banner-ico">
              <i class="fa-solid fa-file-signature"></i>
            </div>
            <span class="lj-ad-banner-tagline">MSME Registration</span>
          </div>
        </div>

        {{-- Body --}}
        <div class="lj-ad-body">
          <div class="lj-ad-name">MSMEPro Services</div>
          <div class="lj-ad-desc">
            Get your MSME / Udyam certification done fast and easy. Trusted by 10,000+ businesses across India. Quick, simple, and affordable.
          </div>

          {{-- Offer badge --}}
          <div class="lj-ad-offer-row">
            <span class="lj-ad-offer-badge lj-ad-offer-badge-green">
              <i class="fa-solid fa-indian-rupee-sign"></i> Starting ₹999
            </span>
            <span class="lj-ad-offer-badge lj-ad-offer-badge-green">
              <i class="fa-solid fa-clock"></i> Fast Processing
            </span>
          </div>

          {{-- CTA row --}}
          <div class="lj-ad-cta-row">
            <span class="lj-ad-cta-link lj-ad-cta-link-green">
              Visit MSMEPro.in <i class="fa-solid fa-arrow-right"></i>
            </span>
            <span class="lj-ad-trust">
              <i class="fa-solid fa-star"></i> 4.9 · 10k+ businesses
            </span>
          </div>
        </div>

      </a>{{-- end card 2 --}}

    </div>{{-- end .lj-ad-grid --}}
  </div>{{-- end .lj-wrap --}}
</section>

@endsection