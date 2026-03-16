{{-- ══════════════════════════════════════════════════════
     resources/views/frontend/home.blade.php
     LinearJobs — Homepage
     Premium search hero + best-in-class ads section
══════════════════════════════════════════════════════ --}}

@extends('frontend.app')
@section('title', 'LinearJobs – Find Your Dream Job in India')

@push('styles')
<style>

/* ═══════════════════════════════════════════════════════
   GLOBAL PAGE TOKENS
═══════════════════════════════════════════════════════ */
:root {
  --blue:         #2563eb;
  --blue-h:       #1d4ed8;
  --blue-light:   #eff6ff;
  --blue-mid:     #bfdbfe;
  --green:        #059669;
  --green-light:  #ecfdf5;
  --orange:       #d97706;
  --orange-light: #fffbeb;
  --amber:        #f59e0b;
  --red:          #dc2626;
  --red-light:    #fef2f2;
  --purple:       #7c3aed;

  --n900: #0f172a;
  --n800: #1e293b;
  --n700: #334155;
  --n600: #475569;
  --n500: #64748b;
  --n400: #94a3b8;
  --n300: #cbd5e1;
  --n200: #e2e8f0;
  --n100: #f1f5f9;
  --n50:  #f8fafc;

  --f:         'Plus Jakarta Sans', sans-serif;
  --f-display: 'Outfit', sans-serif;

  --shadow-sm: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
  --shadow:    0 4px 12px rgba(0,0,0,.08);
  --shadow-lg: 0 10px 32px rgba(0,0,0,.14);
  --shadow-xl: 0 20px 60px rgba(0,0,0,.18);
  --radius:    14px;
  --radius-sm: 8px;
  --radius-lg: 20px;
}

/* ═══════════════════════════════════════════════════════
   HERO SECTION
   — deep slate hero, animated mesh, editorial layout
═══════════════════════════════════════════════════════ */
.lj-hero {
  position: relative;
  background: var(--n900);
  overflow: hidden;
  padding: 90px 0 80px;
  min-height: 560px;
  display: flex;
  align-items: center;
}

/* Animated gradient orbs */
.lj-hero::before {
  content: '';
  position: absolute;
  width: 720px; height: 720px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(37,99,235,.22) 0%, transparent 70%);
  top: -200px; left: -180px;
  animation: heroOrb1 18s ease-in-out infinite alternate;
  pointer-events: none;
}
.lj-hero::after {
  content: '';
  position: absolute;
  width: 500px; height: 500px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(124,58,237,.18) 0%, transparent 70%);
  bottom: -120px; right: -100px;
  animation: heroOrb2 14s ease-in-out infinite alternate;
  pointer-events: none;
}
@keyframes heroOrb1 { from { transform: translate(0,0) scale(1); } to { transform: translate(60px,40px) scale(1.15); } }
@keyframes heroOrb2 { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,-30px) scale(1.1); } }

/* Grid texture overlay */
.lj-hero-grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none;
}

/* Amber accent line */
.lj-hero-accentline {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, var(--amber), var(--blue), transparent);
}

.lj-hero-inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
  text-align: center;
}

/* Pill label above headline */
.lj-hero-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(37,99,235,.18);
  border: 1px solid rgba(37,99,235,.35);
  border-radius: 100px;
  padding: 5px 14px 5px 8px;
  font-family: var(--f);
  font-size: .75rem;
  font-weight: 700;
  color: #93c5fd;
  letter-spacing: .04em;
  text-transform: uppercase;
  margin-bottom: 22px;
  backdrop-filter: blur(8px);
}
.lj-hero-pill-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: var(--amber);
  animation: pillPulse 2s ease-in-out infinite;
}
@keyframes pillPulse {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .5; transform: scale(.75); }
}

.lj-hero-title {
  font-family: var(--f-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 900;
  color: #fff;
  letter-spacing: -.04em;
  line-height: 1.08;
  margin-bottom: 18px;
}
.lj-hero-title em {
  font-style: normal;
  background: linear-gradient(135deg, var(--amber) 0%, #fb923c 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.lj-hero-sub {
  font-family: var(--f);
  font-size: 1.05rem;
  color: rgba(255,255,255,.58);
  max-width: 520px;
  margin: 0 auto 36px;
  line-height: 1.65;
  font-weight: 400;
}

/* ── SEARCH BAR (layout unchanged, styling elevated) ── */
.lj-search-form {
  background: rgba(255,255,255,.07);
  border: 1.5px solid rgba(255,255,255,.13);
  border-radius: var(--radius-lg);
  padding: 8px 8px 8px 6px;
  display: flex;
  align-items: center;
  gap: 6px;
  max-width: 780px;
  margin: 0 auto 22px;
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  box-shadow: 0 8px 32px rgba(0,0,0,.28), inset 0 1px 0 rgba(255,255,255,.08);
  transition: border-color .25s, box-shadow .25s;
}
.lj-search-form:focus-within {
  border-color: rgba(37,99,235,.6);
  box-shadow: 0 8px 32px rgba(0,0,0,.28), 0 0 0 4px rgba(37,99,235,.15), inset 0 1px 0 rgba(255,255,255,.08);
}

.lj-search-field {
  display: flex;
  align-items: center;
  flex: 1;
  min-width: 0;
  background: transparent;
  border: none;
  gap: 0;
  position: relative;
}
.lj-search-field i {
  position: absolute;
  left: 14px;
  color: rgba(255,255,255,.38);
  font-size: .85rem;
  pointer-events: none;
}
.lj-search-field input {
  width: 100%;
  background: transparent;
  border: none;
  outline: none;
  font-family: var(--f);
  font-size: .92rem;
  color: #fff;
  padding: 12px 14px 12px 40px;
}
.lj-search-field input::placeholder { color: rgba(255,255,255,.32); }

.lj-search-sep {
  width: 1px;
  height: 28px;
  background: rgba(255,255,255,.1);
  flex-shrink: 0;
}

.lj-search-select-wrap {
  display: flex;
  align-items: center;
  position: relative;
  min-width: 160px;
  flex-shrink: 0;
}
.lj-search-select-wrap i {
  position: absolute;
  left: 13px;
  color: rgba(255,255,255,.35);
  font-size: .78rem;
  pointer-events: none;
}
.lj-search-select-wrap select {
  width: 100%;
  background: transparent;
  border: none;
  outline: none;
  font-family: var(--f);
  font-size: .88rem;
  color: rgba(255,255,255,.75);
  padding: 12px 30px 12px 36px;
  cursor: pointer;
  -webkit-appearance: none;
  appearance: none;
}
.lj-search-select-wrap select option { background: var(--n800); color: #fff; }

.lj-search-btn {
  flex-shrink: 0;
  background: linear-gradient(135deg, var(--blue) 0%, var(--blue-h) 100%);
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 12px 26px;
  font-family: var(--f);
  font-size: .9rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all .2s;
  white-space: nowrap;
  box-shadow: 0 4px 14px rgba(37,99,235,.4);
}
.lj-search-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(37,99,235,.5);
}
.lj-search-btn:active { transform: translateY(0); }

/* Trending tags */
.lj-hero-tags {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: 4px;
}
.lj-hero-tags-lbl {
  font-size: .74rem;
  color: rgba(255,255,255,.38);
  font-weight: 600;
  letter-spacing: .04em;
  text-transform: uppercase;
  margin-right: 2px;
}
.lj-hero-tag {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 100px;
  padding: 4px 12px;
  font-family: var(--f);
  font-size: .74rem;
  color: rgba(255,255,255,.6);
  text-decoration: none;
  transition: all .18s;
  font-weight: 500;
}
.lj-hero-tag:hover { background: rgba(255,255,255,.13); color: #fff; border-color: rgba(255,255,255,.22); }

/* Stats row */
.lj-hero-stats {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 40px;
  margin-top: 48px;
  padding-top: 36px;
  border-top: 1px solid rgba(255,255,255,.07);
  flex-wrap: wrap;
}
.lj-hero-stat-val {
  font-family: var(--f-display);
  font-size: 1.9rem;
  font-weight: 900;
  color: #fff;
  letter-spacing: -.04em;
  line-height: 1;
  margin-bottom: 3px;
}
.lj-hero-stat-val span { color: var(--amber); }
.lj-hero-stat-lbl {
  font-size: .76rem;
  color: rgba(255,255,255,.42);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .07em;
}
.lj-hero-stat-sep {
  width: 1px;
  height: 42px;
  background: rgba(255,255,255,.1);
}

/* ═══════════════════════════════════════════════════════
   AD SECTION  — premium editorial ad cards
═══════════════════════════════════════════════════════ */
.lj-ads {
  padding: 64px 0 72px;
  background: linear-gradient(180deg, #f8fafc 0%, #f0f4f8 100%);
  position: relative;
  overflow: hidden;
}

/* Subtle background pattern */
.lj-ads::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle at 1px 1px, rgba(37,99,235,.06) 1px, transparent 0);
  background-size: 28px 28px;
  pointer-events: none;
}

.lj-ads .lj-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
  position: relative;
  z-index: 1;
}

/* Section header */
.lj-ads-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 32px;
  gap: 16px;
  flex-wrap: wrap;
}

.lj-ads-lbl {
  display: flex;
  align-items: center;
  gap: 10px;
}
.lj-ads-lbl-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #fff;
  border: 1.5px solid var(--n200);
  border-radius: 100px;
  padding: 5px 13px 5px 8px;
  font-family: var(--f);
  font-size: .7rem;
  font-weight: 700;
  color: var(--n500);
  letter-spacing: .06em;
  text-transform: uppercase;
  box-shadow: var(--shadow-sm);
}
.lj-ads-lbl-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: var(--amber);
  animation: pillPulse 2s ease-in-out infinite;
}
.lj-ads-section-title {
  font-family: var(--f-display);
  font-size: 1.35rem;
  font-weight: 800;
  color: var(--n900);
  letter-spacing: -.03em;
}
.lj-ads-section-sub {
  font-size: .82rem;
  color: var(--n500);
  margin-top: 2px;
}
.lj-ads-why-link {
  font-size: .78rem;
  color: var(--n400);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: color .15s;
  font-weight: 500;
  white-space: nowrap;
}
.lj-ads-why-link:hover { color: var(--n700); }

/* ── AD GRID ── */
.lj-ad-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 22px;
}

/* ── SINGLE AD CARD ── */
.lj-ad-card {
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: var(--radius-lg);
  border: 1.5px solid var(--n200);
  overflow: hidden;
  text-decoration: none;
  transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s ease, border-color .22s;
  box-shadow: 0 2px 8px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.03);
  position: relative;
  cursor: pointer;
}
.lj-ad-card:hover {
  transform: translateY(-5px) scale(1.008);
  box-shadow: 0 20px 56px rgba(0,0,0,.13), 0 4px 12px rgba(0,0,0,.06);
  border-color: transparent;
}

/* ── AD BANNER (visual top strip) ── */
.lj-ad-banner {
  position: relative;
  height: 148px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Blue theme */
.lj-ad-banner-blue {
  background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 45%, #3b82f6 100%);
}
/* Green theme */
.lj-ad-banner-green {
  background: linear-gradient(135deg, #064e3b 0%, #059669 45%, #34d399 100%);
}
/* Amber / orange theme */
.lj-ad-banner-amber {
  background: linear-gradient(135deg, #78350f 0%, #d97706 45%, #fbbf24 100%);
}
/* Purple theme */
.lj-ad-banner-purple {
  background: linear-gradient(135deg, #3b0764 0%, #7c3aed 45%, #a78bfa 100%);
}

/* Decorative animated rings */
.lj-ad-ring {
  position: absolute;
  border-radius: 50%;
  border: 1.5px solid rgba(255,255,255,.12);
  pointer-events: none;
  animation: ringExpand 6s ease-in-out infinite;
}
.lj-ad-ring-1 { width: 120px; height: 120px; top: -40px; right: -30px; animation-delay: 0s; }
.lj-ad-ring-2 { width: 200px; height: 200px; top: -80px; right: -70px; animation-delay: .8s; }
.lj-ad-ring-3 { width: 300px; height: 300px; top: -130px; right: -120px; animation-delay: 1.6s; }
.lj-ad-ring-4 { width: 80px;  height: 80px;  bottom: -10px; left: 20px; border-color: rgba(255,255,255,.08); animation-delay: .4s; }
@keyframes ringExpand {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .5; transform: scale(1.08); }
}

/* Ad badge (top-left "Ad") */
.lj-ad-badge {
  position: absolute;
  top: 12px; left: 12px;
  background: rgba(0,0,0,.28);
  border: 1px solid rgba(255,255,255,.18);
  border-radius: 6px;
  padding: 3px 8px;
  font-family: var(--f);
  font-size: .62rem;
  font-weight: 700;
  color: rgba(255,255,255,.8);
  letter-spacing: .06em;
  text-transform: uppercase;
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  gap: 4px;
  z-index: 2;
}

/* Center icon + tagline */
.lj-ad-center {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  position: relative;
  z-index: 2;
}
.lj-ad-icon-wrap {
  width: 58px; height: 58px;
  border-radius: 16px;
  background: rgba(255,255,255,.15);
  border: 1.5px solid rgba(255,255,255,.22);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: #fff;
  backdrop-filter: blur(8px);
  box-shadow: 0 4px 16px rgba(0,0,0,.18);
  transition: transform .2s;
}
.lj-ad-card:hover .lj-ad-icon-wrap { transform: scale(1.08) rotate(-4deg); }

.lj-ad-banner-tagline {
  font-family: var(--f-display);
  font-size: .75rem;
  font-weight: 700;
  color: rgba(255,255,255,.82);
  text-transform: uppercase;
  letter-spacing: .1em;
  background: rgba(0,0,0,.2);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: 100px;
  padding: 3px 12px;
  backdrop-filter: blur(6px);
}

/* Shine sweep on hover */
.lj-ad-card::before {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 60%; height: 148px;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.07) 50%, transparent 60%);
  z-index: 3;
  pointer-events: none;
  transition: left .55s ease;
}
.lj-ad-card:hover::before { left: 140%; }

/* ── AD BODY ── */
.lj-ad-body {
  padding: 20px 22px 22px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  flex: 1;
}

/* Advertiser name */
.lj-ad-name {
  font-family: var(--f-display);
  font-size: 1.08rem;
  font-weight: 800;
  color: var(--n900);
  letter-spacing: -.02em;
  line-height: 1.25;
}

/* Description */
.lj-ad-desc {
  font-size: .83rem;
  color: var(--n500);
  line-height: 1.65;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Offer badges row */
.lj-ad-badges {
  display: flex;
  gap: 7px;
  flex-wrap: wrap;
}
.lj-ad-badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: 100px;
  padding: 4px 11px;
  font-family: var(--f);
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .02em;
  border: 1.5px solid transparent;
  white-space: nowrap;
}
.lj-ad-badge-pill-blue   { background: var(--blue-light);  color: #1e40af; border-color: var(--blue-mid); }
.lj-ad-badge-pill-green  { background: var(--green-light); color: #065f46; border-color: #a7f3d0; }
.lj-ad-badge-pill-amber  { background: #fffbeb; color: #78350f; border-color: #fde68a; }
.lj-ad-badge-pill-purple { background: #f5f3ff; color: #4c1d95; border-color: #ddd6fe; }

/* CTA row */
.lj-ad-cta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  margin-top: 2px;
  padding-top: 14px;
  border-top: 1px solid var(--n100);
}
.lj-ad-cta-link {
  font-family: var(--f);
  font-size: .82rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: gap .18s;
}
.lj-ad-cta-link-blue   { color: var(--blue); }
.lj-ad-cta-link-green  { color: var(--green); }
.lj-ad-cta-link-amber  { color: var(--orange); }
.lj-ad-cta-link-purple { color: var(--purple); }
.lj-ad-card:hover .lj-ad-cta-link { gap: 10px; }

.lj-ad-cta-arrow {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px; height: 28px;
  border-radius: 50%;
  font-size: .7rem;
  transition: transform .2s;
}
.lj-ad-cta-arrow-blue   { background: var(--blue-light);  color: var(--blue); }
.lj-ad-cta-arrow-green  { background: var(--green-light); color: var(--green); }
.lj-ad-cta-arrow-amber  { background: #fffbeb; color: var(--orange); }
.lj-ad-cta-arrow-purple { background: #f5f3ff; color: var(--purple); }
.lj-ad-card:hover .lj-ad-cta-arrow { transform: translate(2px,-2px); }

.lj-ad-trust {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: .72rem;
  color: var(--n400);
  font-weight: 600;
}
.lj-ad-trust i { color: var(--amber); font-size: .68rem; }

/* ── ADVERTISE WITH US banner ── */
.lj-ads-promote {
  margin-top: 28px;
  background: linear-gradient(135deg, var(--n900) 0%, #1e3a8a 100%);
  border-radius: var(--radius-lg);
  padding: 28px 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  overflow: hidden;
}
.lj-ads-promote::before {
  content: '';
  position: absolute;
  width: 300px; height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(37,99,235,.25) 0%, transparent 70%);
  right: -60px; top: -80px;
  pointer-events: none;
}
.lj-ads-promote-left { position: relative; z-index: 1; }
.lj-ads-promote-eyebrow {
  font-size: .68rem;
  font-weight: 700;
  color: var(--amber);
  text-transform: uppercase;
  letter-spacing: .1em;
  margin-bottom: 4px;
}
.lj-ads-promote-title {
  font-family: var(--f-display);
  font-size: 1.25rem;
  font-weight: 800;
  color: #fff;
  letter-spacing: -.02em;
  margin-bottom: 5px;
}
.lj-ads-promote-sub {
  font-size: .83rem;
  color: rgba(255,255,255,.55);
  line-height: 1.5;
}
.lj-ads-promote-right {
  display: flex;
  gap: 10px;
  align-items: center;
  position: relative;
  z-index: 1;
  flex-wrap: wrap;
}
.lj-ads-promote-stat {
  text-align: center;
}
.lj-ads-promote-stat-val {
  font-family: var(--f-display);
  font-size: 1.4rem;
  font-weight: 900;
  color: #fff;
  letter-spacing: -.04em;
}
.lj-ads-promote-stat-val span { color: var(--amber); }
.lj-ads-promote-stat-lbl {
  font-size: .65rem;
  color: rgba(255,255,255,.42);
  text-transform: uppercase;
  letter-spacing: .07em;
  font-weight: 600;
  margin-top: 1px;
}
.lj-ads-promote-sep {
  width: 1px; height: 40px;
  background: rgba(255,255,255,.1);
}
.lj-ads-promote-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--amber);
  color: var(--n900);
  border: none;
  border-radius: 10px;
  padding: 11px 22px;
  font-family: var(--f);
  font-size: .85rem;
  font-weight: 800;
  cursor: pointer;
  text-decoration: none;
  transition: all .2s;
  white-space: nowrap;
  box-shadow: 0 4px 14px rgba(245,158,11,.35);
}
.lj-ads-promote-btn:hover {
  background: #fbbf24;
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(245,158,11,.45);
}

/* ═══════════════════════════════════════════════════════
   POPULAR CATEGORIES (bonus section below ads)
═══════════════════════════════════════════════════════ */
.lj-cats {
  padding: 68px 0;
  background: #fff;
}
.lj-cats .lj-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
}
.lj-cats-header {
  text-align: center;
  margin-bottom: 40px;
}
.lj-cats-eyebrow {
  font-size: .72rem; font-weight: 700; color: var(--blue);
  text-transform: uppercase; letter-spacing: .1em; margin-bottom: 8px;
}
.lj-cats-title {
  font-family: var(--f-display); font-size: 2rem; font-weight: 800;
  color: var(--n900); letter-spacing: -.04em; margin-bottom: 8px;
}
.lj-cats-sub {
  font-size: .88rem; color: var(--n500); max-width: 440px; margin: 0 auto; line-height: 1.6;
}

.lj-cat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}
.lj-cat-card {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 12px;
  padding: 20px 18px;
  border-radius: var(--radius);
  border: 1.5px solid var(--n200);
  text-decoration: none;
  background: #fff;
  transition: all .2s;
  position: relative;
  overflow: hidden;
}
.lj-cat-card::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, var(--color-light) 0%, transparent 60%);
  opacity: 0;
  transition: opacity .2s;
}
.lj-cat-card:hover {
  border-color: var(--color);
  transform: translateY(-2px);
  box-shadow: var(--shadow);
}
.lj-cat-card:hover::after { opacity: 1; }

.lj-cat-ico {
  width: 44px; height: 44px;
  border-radius: 11px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.15rem;
  background: var(--color-light);
  color: var(--color);
  position: relative; z-index: 1;
  transition: transform .2s;
}
.lj-cat-card:hover .lj-cat-ico { transform: scale(1.1) rotate(-5deg); }

.lj-cat-name {
  font-family: var(--f-display); font-size: .92rem; font-weight: 700;
  color: var(--n900); line-height: 1.3; position: relative; z-index: 1;
}
.lj-cat-count {
  font-size: .73rem; color: var(--n400); font-weight: 600; position: relative; z-index: 1;
  display: flex; align-items: center; gap: 4px;
}
.lj-cat-count-dot {
  width: 5px; height: 5px; border-radius: 50%; background: var(--color);
}

/* ═══════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════ */
@media (max-width: 900px) {
  .lj-hero { padding: 70px 0 60px; }
  .lj-search-form { flex-wrap: wrap; border-radius: 14px; }
  .lj-search-sep { display: none; }
  .lj-search-select-wrap { flex: 1; min-width: 140px; }
  .lj-search-btn { width: 100%; justify-content: center; border-radius: 10px; padding: 13px 0; }
  .lj-ad-grid { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; }
  .lj-cat-grid { grid-template-columns: repeat(2, 1fr); }
  .lj-hero-stats { gap: 24px; }
  .lj-ads-promote { text-align: center; justify-content: center; }
  .lj-ads-promote-right { justify-content: center; }
}

@media (max-width: 640px) {
  .lj-hero-title { font-size: 2rem; }
  .lj-hero-stats { display: none; }
  .lj-hero-stat-sep { display: none; }
  .lj-cat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .lj-ads { padding: 44px 0 52px; }
  .lj-cats { padding: 48px 0; }
  .lj-cats-title { font-size: 1.55rem; }
  .lj-ads-promote { padding: 20px; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     HERO — search unchanged structurally, elevated visually
═══════════════════════════════════════════════════════ --}}
<section class="lj-hero">
  <div class="lj-hero-grid"></div>
  <div class="lj-hero-accentline"></div>

  <div class="lj-hero-inner">

    {{-- Pill label --}}
    <div class="lj-hero-pill">
      <span class="lj-hero-pill-dot"></span>
      <i class="fa-solid fa-bolt-lightning"></i>
      2,400+ New Jobs Added This Week
    </div>

    {{-- Headline --}}
    <h1 class="lj-hero-title">
      Find Your <em>Dream Job</em><br>in India's Top Companies
    </h1>
    <p class="lj-hero-sub">
      Browse thousands of verified job listings. Connect with top employers. Land the career you deserve.
    </p>

    {{-- ── SEARCH BAR (layout / fields unchanged) ── --}}
    <form class="lj-search-form" action="{{ route('jobs.index') }}" method="GET">
      {{-- Job title / keyword --}}
      <div class="lj-search-field" style="flex:1.4;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
          type="text"
          name="q"
          placeholder="Job title, skills, or company..."
          value="{{ request('q') }}"
          autocomplete="off"
        />
      </div>

      <div class="lj-search-sep"></div>

      {{-- Location dropdown --}}
      <div class="lj-search-select-wrap">
        <i class="fa-solid fa-location-dot"></i>
        <select name="location">
          <option value="">All Locations</option>
          <option value="bangalore" {{ request('location') == 'bangalore' ? 'selected' : '' }}>Bangalore</option>
          <option value="mumbai"    {{ request('location') == 'mumbai'    ? 'selected' : '' }}>Mumbai</option>
          <option value="delhi"     {{ request('location') == 'delhi'     ? 'selected' : '' }}>Delhi NCR</option>
          <option value="hyderabad" {{ request('location') == 'hyderabad' ? 'selected' : '' }}>Hyderabad</option>
          <option value="pune"      {{ request('location') == 'pune'      ? 'selected' : '' }}>Pune</option>
          <option value="chennai"   {{ request('location') == 'chennai'   ? 'selected' : '' }}>Chennai</option>
          <option value="remote"    {{ request('location') == 'remote'    ? 'selected' : '' }}>Remote</option>
        </select>
      </div>

      <div class="lj-search-sep"></div>

      {{-- Job type --}}
      <div class="lj-search-select-wrap" style="min-width:130px;">
        <i class="fa-solid fa-briefcase"></i>
        <select name="type">
          <option value="">All Types</option>
          <option value="full-time"  {{ request('type') == 'full-time'  ? 'selected' : '' }}>Full-time</option>
          <option value="part-time"  {{ request('type') == 'part-time'  ? 'selected' : '' }}>Part-time</option>
          <option value="contract"   {{ request('type') == 'contract'   ? 'selected' : '' }}>Contract</option>
          <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
          <option value="remote"     {{ request('type') == 'remote'     ? 'selected' : '' }}>Remote</option>
        </select>
      </div>

      {{-- Search button --}}
      <button type="submit" class="lj-search-btn">
        <i class="fa-solid fa-magnifying-glass"></i>
        Search Jobs
      </button>
    </form>

    {{-- Trending tags --}}
    <div class="lj-hero-tags">
      <span class="lj-hero-tags-lbl"><i class="fa-solid fa-fire-flame-curved" style="color:var(--amber);"></i> Trending:</span>
      <a href="{{ route('jobs.index', ['q' => 'React Developer']) }}" class="lj-hero-tag">React Developer</a>
      <a href="{{ route('jobs.index', ['q' => 'Data Analyst']) }}" class="lj-hero-tag">Data Analyst</a>
      <a href="{{ route('jobs.index', ['q' => 'Product Manager']) }}" class="lj-hero-tag">Product Manager</a>
      <a href="{{ route('jobs.index', ['q' => 'UI UX Designer']) }}" class="lj-hero-tag">UI/UX Designer</a>
      <a href="{{ route('jobs.index', ['q' => 'DevOps']) }}" class="lj-hero-tag">DevOps</a>
      <a href="{{ route('jobs.index', ['type' => 'remote']) }}" class="lj-hero-tag">
        <i class="fa-solid fa-laptop"></i> Remote
      </a>
    </div>

    {{-- Stats row --}}
    <div class="lj-hero-stats">
      <div>
        <div class="lj-hero-stat-val">24<span>k+</span></div>
        <div class="lj-hero-stat-lbl">Active Jobs</div>
      </div>
      <div class="lj-hero-stat-sep"></div>
      <div>
        <div class="lj-hero-stat-val">6<span>k+</span></div>
        <div class="lj-hero-stat-lbl">Companies Hiring</div>
      </div>
      <div class="lj-hero-stat-sep"></div>
      <div>
        <div class="lj-hero-stat-val">1.2<span>L+</span></div>
        <div class="lj-hero-stat-lbl">Job Seekers</div>
      </div>
      <div class="lj-hero-stat-sep"></div>
      <div>
        <div class="lj-hero-stat-val">98<span>%</span></div>
        <div class="lj-hero-stat-lbl">Placement Rate</div>
      </div>
    </div>

  </div>
</section>


{{-- ═══════════════════════════════════════════════════
     PREMIUM ADVERTISEMENT SECTION
═══════════════════════════════════════════════════════ --}}
<section class="lj-ads">
  <div class="lj-wrap">

    {{-- Section header --}}
    <div class="lj-ads-header">
      <div>
        <div class="lj-ads-lbl">
          <div class="lj-ads-lbl-pill">
            <span class="lj-ads-lbl-dot"></span>
            <i class="fa-solid fa-rectangle-ad" style="font-size:.7rem;"></i>
            Sponsored
          </div>
        </div>
        <div class="lj-ads-section-title" style="margin-top:8px;">Featured Partners</div>
        <div class="lj-ads-section-sub">Trusted services to accelerate your career</div>
      </div>
      <a href="#" class="lj-ads-why-link">
        <i class="fa-solid fa-circle-question"></i> Why these ads?
      </a>
    </div>

    {{-- Ad cards grid --}}
    <div class="lj-ad-grid">

      {{-- ── CARD 1: SkillBridge Academy (Blue) ── --}}
      <a href="#" class="lj-ad-card">
        {{-- Banner --}}
        <div class="lj-ad-banner lj-ad-banner-blue">
          <div class="lj-ad-ring lj-ad-ring-1"></div>
          <div class="lj-ad-ring lj-ad-ring-2"></div>
          <div class="lj-ad-ring lj-ad-ring-3"></div>
          <div class="lj-ad-ring lj-ad-ring-4"></div>
          <span class="lj-ad-badge">
            <i class="fa-solid fa-circle-info"></i> Ad
          </span>
          <div class="lj-ad-center">
            <div class="lj-ad-icon-wrap">
              <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <span class="lj-ad-banner-tagline">Online Learning</span>
          </div>
        </div>
        {{-- Body --}}
        <div class="lj-ad-body">
          <div class="lj-ad-name">SkillBridge Academy</div>
          <div class="lj-ad-desc">
            Upgrade your skills with India's top online courses. Get certified and land your dream job faster with industry-recognized programs from expert instructors.
          </div>
          <div class="lj-ad-badges">
            <span class="lj-ad-badge-pill lj-ad-badge-pill-blue">
              <i class="fa-solid fa-bolt"></i> 50% OFF This Month
            </span>
            <span class="lj-ad-badge-pill lj-ad-badge-pill-blue">
              <i class="fa-solid fa-certificate"></i> Certified Courses
            </span>
          </div>
          <div class="lj-ad-cta">
            <span class="lj-ad-cta-link lj-ad-cta-link-blue">
              Visit SkillBridge.in
              <span class="lj-ad-cta-arrow lj-ad-cta-arrow-blue">
                <i class="fa-solid fa-arrow-right"></i>
              </span>
            </span>
            <span class="lj-ad-trust">
              <i class="fa-solid fa-star"></i> 4.8 · 12k+ learners
            </span>
          </div>
        </div>
      </a>

      {{-- ── CARD 2: MSMEPro Services (Green) ── --}}
      <a href="#" class="lj-ad-card">
        {{-- Banner --}}
        <div class="lj-ad-banner lj-ad-banner-green">
          <div class="lj-ad-ring lj-ad-ring-1"></div>
          <div class="lj-ad-ring lj-ad-ring-2"></div>
          <div class="lj-ad-ring lj-ad-ring-3"></div>
          <div class="lj-ad-ring lj-ad-ring-4"></div>
          <span class="lj-ad-badge">
            <i class="fa-solid fa-circle-info"></i> Ad
          </span>
          <div class="lj-ad-center">
            <div class="lj-ad-icon-wrap">
              <i class="fa-solid fa-file-signature"></i>
            </div>
            <span class="lj-ad-banner-tagline">MSME Registration</span>
          </div>
        </div>
        {{-- Body --}}
        <div class="lj-ad-body">
          <div class="lj-ad-name">MSMEPro Services</div>
          <div class="lj-ad-desc">
            Get your MSME / Udyam certification done fast and easy. Trusted by 10,000+ businesses across India. Quick, simple, and highly affordable online process.
          </div>
          <div class="lj-ad-badges">
            <span class="lj-ad-badge-pill lj-ad-badge-pill-green">
              <i class="fa-solid fa-indian-rupee-sign"></i> Starting ₹999
            </span>
            <span class="lj-ad-badge-pill lj-ad-badge-pill-green">
              <i class="fa-solid fa-clock"></i> Fast Processing
            </span>
          </div>
          <div class="lj-ad-cta">
            <span class="lj-ad-cta-link lj-ad-cta-link-green">
              Visit MSMEPro.in
              <span class="lj-ad-cta-arrow lj-ad-cta-arrow-green">
                <i class="fa-solid fa-arrow-right"></i>
              </span>
            </span>
            <span class="lj-ad-trust">
              <i class="fa-solid fa-star"></i> 4.9 · 10k+ businesses
            </span>
          </div>
        </div>
      </a>

    </div>{{-- /.lj-ad-grid --}}

    {{-- Advertise with us banner --}}
    <div class="lj-ads-promote">
      <div class="lj-ads-promote-left">
        <div class="lj-ads-promote-eyebrow">
          <i class="fa-solid fa-chart-line"></i> &nbsp;Grow Your Business
        </div>
        <div class="lj-ads-promote-title">Reach 1.2 Lakh+ Active Job Seekers</div>
        <div class="lj-ads-promote-sub">
          Advertise your product, service, or course to a highly engaged audience of professionals and job seekers across India.
        </div>
      </div>
      <div class="lj-ads-promote-right">
        <div class="lj-ads-promote-stat">
          <div class="lj-ads-promote-stat-val">1.2<span>L+</span></div>
          <div class="lj-ads-promote-stat-lbl">Monthly Visitors</div>
        </div>
        <div class="lj-ads-promote-sep"></div>
        <div class="lj-ads-promote-stat">
          <div class="lj-ads-promote-stat-val">6<span>k+</span></div>
          <div class="lj-ads-promote-stat-lbl">Daily Clicks</div>
        </div>
        <div class="lj-ads-promote-sep"></div>
        <a href="{{ route('contact') }}" class="lj-ads-promote-btn">
          <i class="fa-solid fa-rocket"></i>
          Advertise with Us
        </a>
      </div>
    </div>

  </div>{{-- /.lj-wrap --}}
</section>


{{-- ═══════════════════════════════════════════════════
     POPULAR CATEGORIES
═══════════════════════════════════════════════════════ --}}
<section class="lj-cats">
  <div class="lj-wrap">
    <div class="lj-cats-header">
      <div class="lj-cats-eyebrow"><i class="fa-solid fa-layer-group"></i> Browse by Category</div>
      <h2 class="lj-cats-title">Explore Top Job Categories</h2>
      <p class="lj-cats-sub">Find the right role in your industry from thousands of verified listings</p>
    </div>

    <div class="lj-cat-grid">

      <a href="{{ route('jobs.index', ['category' => 'technology']) }}" class="lj-cat-card"
         style="--color:#2563eb; --color-light:#eff6ff;">
        <div class="lj-cat-ico"><i class="fa-solid fa-laptop-code"></i></div>
        <div>
          <div class="lj-cat-name">Technology &amp; IT</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 8,200+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'design']) }}" class="lj-cat-card"
         style="--color:#7c3aed; --color-light:#f5f3ff;">
        <div class="lj-cat-ico"><i class="fa-solid fa-pen-ruler"></i></div>
        <div>
          <div class="lj-cat-name">Design &amp; Creative</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 2,100+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'marketing']) }}" class="lj-cat-card"
         style="--color:#d97706; --color-light:#fffbeb;">
        <div class="lj-cat-ico"><i class="fa-solid fa-bullhorn"></i></div>
        <div>
          <div class="lj-cat-name">Marketing &amp; Sales</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 3,500+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'finance']) }}" class="lj-cat-card"
         style="--color:#059669; --color-light:#ecfdf5;">
        <div class="lj-cat-ico"><i class="fa-solid fa-chart-pie"></i></div>
        <div>
          <div class="lj-cat-name">Finance &amp; Accounting</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 1,800+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'healthcare']) }}" class="lj-cat-card"
         style="--color:#dc2626; --color-light:#fef2f2;">
        <div class="lj-cat-ico"><i class="fa-solid fa-stethoscope"></i></div>
        <div>
          <div class="lj-cat-name">Healthcare &amp; Medical</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 1,200+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'education']) }}" class="lj-cat-card"
         style="--color:#0891b2; --color-light:#ecfeff;">
        <div class="lj-cat-ico"><i class="fa-solid fa-book-open"></i></div>
        <div>
          <div class="lj-cat-name">Education &amp; Training</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 960+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['category' => 'operations']) }}" class="lj-cat-card"
         style="--color:#475569; --color-light:#f1f5f9;">
        <div class="lj-cat-ico"><i class="fa-solid fa-gears"></i></div>
        <div>
          <div class="lj-cat-name">Operations &amp; Logistics</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 1,400+ jobs</div>
        </div>
      </a>

      <a href="{{ route('jobs.index', ['type' => 'remote']) }}" class="lj-cat-card"
         style="--color:#0d9488; --color-light:#f0fdfa;">
        <div class="lj-cat-ico"><i class="fa-solid fa-earth-asia"></i></div>
        <div>
          <div class="lj-cat-name">Remote &amp; Freelance</div>
          <div class="lj-cat-count"><span class="lj-cat-count-dot"></span> 4,300+ jobs</div>
        </div>
      </a>

    </div>{{-- /.lj-cat-grid --}}
  </div>
</section>

@endsection