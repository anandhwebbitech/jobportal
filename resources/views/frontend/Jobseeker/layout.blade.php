{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/layout.blade.php
     LinearJobs – Job Seeker Dashboard Layout
     v4: Unified sidebar toggle, fixed overlay, clean JS
═══════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title', 'Dashboard') – LinearJobs</title>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('frontend/css/lj-global.css') }}" rel="stylesheet"/>
@stack('styles')

<style>
/* ═══════════════════════════════════════════════════════
   DESIGN TOKENS
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
  --red:          #dc2626;
  --red-light:    #fef2f2;
  --purple:       #7c3aed;
  --purple-light: #f5f3ff;

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

  --sidebar-w: 260px;
  --header-h:  60px;

  --f:         'Plus Jakarta Sans', sans-serif;
  --f-display: 'Outfit', sans-serif;

  --shadow-xs: 0 1px 2px rgba(0,0,0,.05);
  --shadow-sm: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
  --shadow:    0 4px 12px rgba(0,0,0,.08);
  --shadow-lg: 0 10px 32px rgba(0,0,0,.14);
  --radius:    12px;
  --radius-sm: 8px;
}

/* ═══════════════════════════════════════════════════════
   RESET
═══════════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: var(--f);
  background: #f0f4f8;
  color: var(--n800);
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* ── TOPBAR ──────────────────────────────────────────── */
.lj-topbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: var(--header-h);
  background: #fff;
  border-bottom: 1px solid var(--n200);
  display: flex;
  align-items: center;
  z-index: 1000;
  box-shadow: 0 1px 0 var(--n200), 0 2px 8px rgba(0,0,0,.04);
}

.lj-topbar-brand {
  width: var(--sidebar-w);
  flex-shrink: 0;
  display: flex;
  align-items: center;
  padding: 0 18px;
  gap: 10px;
  border-right: 1px solid var(--n200);
  height: 100%;
  text-decoration: none;
}
.lj-brand-logo {
  width: 34px; height: 34px;
  background: var(--blue);
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 800;
  color: #fff; font-size: .9rem; letter-spacing: -1px;
  flex-shrink: 0;
}
.lj-brand-name {
  font-family: var(--f-display); font-weight: 800;
  font-size: 1.05rem; color: var(--n900); letter-spacing: -.3px;
}
.lj-brand-name em { font-style: normal; color: var(--blue); }

.lj-topbar-right {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  gap: 12px;
  min-width: 0;
}
.lj-topbar-search {
  position: relative; max-width: 280px; width: 100%;
}
.lj-topbar-search i {
  position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
  color: var(--n400); font-size: .76rem; pointer-events: none;
}
.lj-topbar-search input {
  width: 100%; border: 1.5px solid var(--n200); border-radius: var(--radius-sm);
  padding: 7px 12px 7px 32px; font-family: var(--f); font-size: .83rem;
  color: var(--n800); background: var(--n50); outline: none;
  transition: border-color .2s, background .2s;
}
.lj-topbar-search input:focus { border-color: var(--blue); background: #fff; }
.lj-topbar-search input::placeholder { color: var(--n400); }

.lj-topbar-actions { display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
.lj-top-icon-btn {
  width: 36px; height: 36px; border-radius: var(--radius-sm);
  border: 1.5px solid var(--n200); background: #fff; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: var(--n600); font-size: .82rem;
  transition: all .18s; position: relative; text-decoration: none;
}
.lj-top-icon-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-light); }
.lj-notif-dot {
  position: absolute; top: 5px; right: 5px;
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--red); border: 1.5px solid #fff;
}
.lj-topbar-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), #7c3aed);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-family: var(--f-display); font-weight: 700; font-size: .82rem;
  cursor: pointer; flex-shrink: 0; border: 2px solid var(--n200);
  text-decoration: none; overflow: hidden;
}
.lj-topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

/* ── HAMBURGER BUTTON ────────────────────────────────── */
/*
  Single hamburger button, lives inside the topbar on the right on mobile.
  Hidden on desktop. Shown via the @media block below.
*/
.lj-hamburger {
  display: none; /* hidden on desktop */
  width: 36px;
  height: 36px;
  border-radius: var(--radius-sm);
  border: 1.5px solid var(--n200);
  background: #fff;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 5px;
  flex-shrink: 0;
  padding: 0;
  transition: all .18s;
  margin-left: 4px;
}
.lj-hamburger:hover { border-color: var(--blue); background: var(--blue-light); }
.lj-hamburger span {
  display: block;
  width: 18px; height: 2px;
  background: var(--n600);
  border-radius: 2px;
  transition: transform .28s cubic-bezier(.4,0,.2,1), opacity .28s, background .18s;
  transform-origin: center;
}
.lj-hamburger:hover span { background: var(--blue); }
/* Animated X state */
.lj-hamburger.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); background: var(--blue); }
.lj-hamburger.is-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.lj-hamburger.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); background: var(--blue); }
.lj-hamburger.is-open { border-color: var(--blue); background: var(--blue-light); }

/* ── SIDEBAR ─────────────────────────────────────────── */
.lj-sidebar {
  position: fixed;
  top: var(--header-h);
  left: 0;
  width: var(--sidebar-w);
  height: calc(100vh - var(--header-h));
  background: #fff;
  border-right: 1px solid var(--n200);
  overflow-y: auto;
  overflow-x: hidden;
  z-index: 900;
  display: flex;
  flex-direction: column;
  padding: 10px 8px 24px;
  scrollbar-width: thin;
  scrollbar-color: var(--n200) transparent;
  /* Desktop: always visible — no transform needed */
}
.lj-sidebar::-webkit-scrollbar { width: 3px; }
.lj-sidebar::-webkit-scrollbar-thumb { background: var(--n200); border-radius: 3px; }
.lj-sidebar::-webkit-scrollbar-track { background: transparent; }

/* Sidebar profile card */
.lj-sidebar-profile {
  margin: 2px 0 6px;
  padding: 12px 13px;
  background: linear-gradient(135deg, var(--blue) 0%, #6d28d9 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  gap: 10px;
  flex-shrink: 0;
}
.lj-sp-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: rgba(255,255,255,.2);
  border: 2px solid rgba(255,255,255,.35);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 700;
  color: #fff; font-size: .88rem; flex-shrink: 0; overflow: hidden;
}
.lj-sp-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.lj-sp-name {
  font-family: var(--f); font-weight: 700; color: #fff;
  font-size: .83rem; line-height: 1.25;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.lj-sp-role {
  font-size: .69rem; color: rgba(255,255,255,.72); margin-top: 2px;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Section labels */
.lj-sidebar-label {
  font-size: .63rem; font-weight: 700; color: var(--n400);
  letter-spacing: .1em; text-transform: uppercase;
  padding: 14px 10px 4px;
  display: block;
  flex-shrink: 0;
}

/* Nav items */
.lj-nav-item {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 8px 10px;
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: background .14s, color .14s;
  font-family: var(--f);
  font-size: .835rem;
  font-weight: 500;
  color: var(--n600);
  text-decoration: none;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  position: relative;
  flex-shrink: 0;
}
.lj-nav-item:hover { background: var(--n100); color: var(--n900); }
.lj-nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
.lj-nav-icon {
  width: 20px; text-align: center; font-size: .8rem;
  color: var(--n400); flex-shrink: 0; transition: color .14s;
}
.lj-nav-item:hover .lj-nav-icon { color: var(--n700); }
.lj-nav-item.active .lj-nav-icon { color: var(--blue); }
.lj-nav-badge {
  margin-left: auto; min-width: 18px; height: 18px;
  background: var(--red); color: #fff; border-radius: 100px;
  font-size: .59rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  padding: 0 5px; flex-shrink: 0;
}
.lj-nav-badge.green  { background: var(--green); }
.lj-nav-badge.blue   { background: var(--blue); }
.lj-nav-badge.orange { background: var(--orange); }

/* Sidebar divider */
.lj-sidebar-divider { height: 1px; background: var(--n100); margin: 6px 0; flex-shrink: 0; }

/* Push logout to bottom */
.lj-sidebar-spacer { flex: 1; min-height: 12px; }

/* ── OVERLAY ─────────────────────────────────────────── */
.lj-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.5);
  z-index: 850;
  backdrop-filter: blur(2px);
  -webkit-backdrop-filter: blur(2px);
  cursor: pointer;
}
.lj-overlay.is-visible { display: block; }

/* ── MAIN CONTENT ────────────────────────────────────── */
.lj-main {
  margin-left: var(--sidebar-w);
  margin-top: var(--header-h);
  min-height: calc(100vh - var(--header-h));
  padding: 24px 26px 72px;
}

/* ── FOOTER wrapper ──────────────────────────────────── */
.lj-footer-wrap {
  margin-left: var(--sidebar-w);
}

/* ═══════════════════════════════════════════════════════
   TYPOGRAPHY
═══════════════════════════════════════════════════════ */
.lj-page-header {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 22px; gap: 14px; flex-wrap: wrap;
}
.lj-page-title {
  font-family: var(--f-display); font-weight: 800;
  font-size: 1.6rem; color: var(--n900);
  letter-spacing: -.4px; line-height: 1.2;
}
.lj-page-subtitle {
  font-size: .84rem; color: var(--n500);
  margin-top: 4px; line-height: 1.5;
}

/* ═══════════════════════════════════════════════════════
   CARDS
═══════════════════════════════════════════════════════ */
.lj-card {
  background: #fff;
  border: 1.5px solid var(--n200);
  border-radius: var(--radius);
  overflow: hidden;
}
.lj-card-head {
  padding: 15px 20px;
  border-bottom: 1px solid var(--n100);
  display: flex; align-items: center;
  justify-content: space-between; gap: 10px;
}
.lj-card-title {
  font-family: var(--f-display); font-weight: 700;
  font-size: .94rem; color: var(--n900);
  display: flex; align-items: center; gap: 8px;
}
.lj-card-title i { color: var(--blue); font-size: .84rem; }
.lj-card-body { padding: 20px; }

/* ═══════════════════════════════════════════════════════
   BUTTONS
═══════════════════════════════════════════════════════ */
.lj-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--f); font-weight: 600;
  border-radius: var(--radius-sm); cursor: pointer;
  transition: all .18s; text-decoration: none;
  font-size: .84rem; border: none;
  padding: 9px 16px; white-space: nowrap; line-height: 1.4;
}
.lj-btn-primary  { background: var(--blue); color: #fff; }
.lj-btn-primary:hover  { background: var(--blue-h); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,.3); }
.lj-btn-outline  { background: #fff; color: var(--n700); border: 1.5px solid var(--n200); }
.lj-btn-outline:hover  { border-color: var(--blue); color: var(--blue); }
.lj-btn-ghost    { background: none; color: var(--n600); padding: 9px 12px; }
.lj-btn-ghost:hover    { background: var(--n100); color: var(--n900); }
.lj-btn-sm       { padding: 6px 11px; font-size: .76rem; border-radius: 6px; }
.lj-btn-danger   { background: var(--red-light); color: var(--red); border: 1.5px solid #fecaca; }
.lj-btn-danger:hover   { background: var(--red); color: #fff; }
.lj-btn-green    { background: var(--green-light); color: var(--green); border: 1.5px solid #86efac; }
.lj-btn-green:hover    { background: var(--green); color: #fff; }

/* ═══════════════════════════════════════════════════════
   FORMS
═══════════════════════════════════════════════════════ */
.lj-form-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.lj-form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
.lj-fgroup      { display: flex; flex-direction: column; gap: 5px; }
.lj-fgroup.full { grid-column: 1 / -1; }
.lj-label       { font-size: .78rem; font-weight: 600; color: var(--n700); letter-spacing: .01em; }
.lj-label .req  { color: var(--red); margin-left: 2px; }

.lj-input {
  width: 100%; border: 1.5px solid var(--n200); border-radius: var(--radius-sm);
  padding: 9px 13px; font-family: var(--f); font-size: .875rem;
  color: var(--n900); background: #fff; outline: none;
  transition: border-color .18s, box-shadow .18s; line-height: 1.5;
}
.lj-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.lj-input::placeholder { color: var(--n400); }
.lj-input:disabled { background: var(--n50); color: var(--n500); cursor: not-allowed; }
select.lj-input {
  -webkit-appearance: none; appearance: none; cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 12px center;
  padding-right: 30px;
}
textarea.lj-input { resize: vertical; min-height: 96px; padding-top: 10px; }
.lj-input-wrap  { position: relative; }
.lj-input-ico   {
  position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
  color: var(--n400); font-size: .76rem; pointer-events: none;
}
.lj-input-ico.ta { top: 12px; transform: none; }
.lj-input.has-ico { padding-left: 34px; }
.lj-input-hint  { font-size: .72rem; color: var(--n400); display: flex; align-items: center; gap: 4px; line-height: 1.4; }
.lj-form-divider {
  font-size: .67rem; font-weight: 700; color: var(--n400);
  text-transform: uppercase; letter-spacing: .1em;
  margin: 18px 0 14px; display: flex; align-items: center; gap: 10px;
}
.lj-form-divider::before, .lj-form-divider::after { content: ''; flex: 1; height: 1px; background: var(--n100); }
.lj-form-footer {
  display: flex; align-items: center; justify-content: flex-end; gap: 10px;
  padding: 14px 20px; border-top: 1px solid var(--n100); background: var(--n50);
}

/* ═══════════════════════════════════════════════════════
   STATUS BADGES
═══════════════════════════════════════════════════════ */
.lj-status-badge {
  font-family: var(--f); font-size: .67rem; font-weight: 700;
  letter-spacing: .05em; text-transform: uppercase;
  padding: 3px 9px; border-radius: 100px; flex-shrink: 0; white-space: nowrap;
}
.lj-status-badge.applied     { background: var(--blue-light);   color: var(--blue); }
.lj-status-badge.shortlisted { background: var(--orange-light);  color: var(--orange); }
.lj-status-badge.interview   { background: var(--purple-light);  color: var(--purple); }
.lj-status-badge.rejected    { background: var(--red-light);     color: var(--red); }
.lj-status-badge.hired       { background: var(--green-light);   color: var(--green); }

/* ═══════════════════════════════════════════════════════
   TOGGLE SWITCH
═══════════════════════════════════════════════════════ */
.lj-toggle {
  width: 40px; height: 22px; border-radius: 100px;
  background: var(--n300); position: relative; cursor: pointer;
  transition: background .2s; flex-shrink: 0;
}
.lj-toggle.on { background: var(--blue); }
.lj-toggle::after {
  content: ''; position: absolute; left: 3px; top: 3px;
  width: 16px; height: 16px; border-radius: 50%; background: #fff;
  transition: left .2s; box-shadow: 0 1px 3px rgba(0,0,0,.18);
}
.lj-toggle.on::after { left: calc(100% - 19px); }

/* ═══════════════════════════════════════════════════════
   CHIPS
═══════════════════════════════════════════════════════ */
.chip-select { display: flex; flex-wrap: wrap; gap: 7px; }
.chip {
  padding: 5px 13px; border-radius: 100px; border: 1.5px solid var(--n200);
  font-size: .78rem; font-weight: 600; color: var(--n600);
  cursor: pointer; transition: all .15s; background: #fff;
  user-select: none; font-family: var(--f); line-height: 1.4;
}
.chip:hover  { border-color: var(--blue); color: var(--blue); }
.chip.active { background: var(--blue); border-color: var(--blue); color: #fff; }

/* ═══════════════════════════════════════════════════════
   SKILL TAGS
═══════════════════════════════════════════════════════ */
.lj-skill-cloud { display: flex; flex-wrap: wrap; gap: 7px; }
.lj-skill-tag {
  display: inline-flex; align-items: center; gap: 6px;
  border: 1.5px solid var(--n200); border-radius: 100px;
  padding: 4px 12px; font-size: .78rem; font-weight: 600;
  color: var(--n700); background: #fff;
  cursor: pointer; transition: all .15s; user-select: none;
}
.lj-skill-tag.selected { background: var(--blue); border-color: var(--blue); color: #fff; }
.lj-skill-tag .rm {
  width: 14px; height: 14px; border-radius: 50%;
  background: rgba(255,255,255,.3);
  display: flex; align-items: center; justify-content: center;
  font-size: .56rem; flex-shrink: 0;
}

/* ═══════════════════════════════════════════════════════
   INFO BOX
═══════════════════════════════════════════════════════ */
.lj-info-box {
  background: var(--blue-light); border: 1.5px solid var(--blue-mid);
  border-radius: var(--radius-sm); padding: 11px 13px;
  font-size: .8rem; color: #1e40af;
  display: flex; align-items: flex-start; gap: 9px;
  margin-bottom: 16px; line-height: 1.5;
}
.lj-info-box i { font-size: .76rem; margin-top: 1px; flex-shrink: 0; }

/* ═══════════════════════════════════════════════════════
   GRID LAYOUTS
═══════════════════════════════════════════════════════ */
.lj-grid-2    { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 22px; }
.lj-grid-3    { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 22px; }
.lj-section-gap { margin-bottom: 20px; }
.lj-divider   { height: 1px; background: var(--n100); margin: 12px 0; }

/* ═══════════════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════════════ */
.lj-empty {
  text-align: center; padding: 48px 20px;
  display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.lj-empty i         { font-size: 2.4rem; color: var(--n300); }
.lj-empty-title     { font-family: var(--f-display); font-weight: 700; color: var(--n600); font-size: .95rem; }
.lj-empty-sub       { font-size: .82rem; color: var(--n400); max-width: 260px; line-height: 1.6; }

/* ═══════════════════════════════════════════════════════
   TABLE
═══════════════════════════════════════════════════════ */
.lj-table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.lj-table { width: 100%; border-collapse: collapse; table-layout: auto; }
.lj-table th {
  text-align: left; font-family: var(--f); font-size: .67rem;
  font-weight: 700; color: var(--n500);
  text-transform: uppercase; letter-spacing: .08em;
  padding: 10px 16px; background: var(--n50);
  border-bottom: 1.5px solid var(--n200); white-space: nowrap;
}
.lj-table td {
  padding: 13px 16px; border-bottom: 1px solid var(--n100);
  font-size: .84rem; color: var(--n700); vertical-align: middle;
}
.lj-table tr:last-child td { border-bottom: none; }
.lj-table tr:hover td      { background: var(--n50); }
.lj-table th:last-child,
.lj-table td:last-child    { text-align: right; }
.lj-table-logo {
  width: 36px; height: 36px; border-radius: var(--radius-sm);
  background: var(--n100); border: 1px solid var(--n200);
  display: flex; align-items: center; justify-content: center;
  color: var(--n400); font-size: .74rem; flex-shrink: 0; overflow: hidden;
}
.lj-table-logo img { width: 100%; height: 100%; object-fit: cover; }
.lj-table-title { font-weight: 700; color: var(--n900); font-size: .875rem; line-height: 1.3; }
.lj-table-sub   { font-size: .73rem; color: var(--n500); margin-top: 2px; }

/* ═══════════════════════════════════════════════════════
   ALERT ITEMS
═══════════════════════════════════════════════════════ */
.lj-alert-item {
  display: flex; align-items: center; gap: 12px;
  padding: 13px 0; border-bottom: 1px solid var(--n100);
}
.lj-alert-item:last-child { border-bottom: none; }
.lj-alert-icon {
  width: 38px; height: 38px; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; flex-shrink: 0;
}
.lj-alert-name { font-weight: 600; color: var(--n900); font-size: .875rem; }
.lj-alert-meta { font-size: .73rem; color: var(--n500); margin-top: 2px; }

/* ═══════════════════════════════════════════════════════
   NOTIFICATION ITEMS
═══════════════════════════════════════════════════════ */
.lj-notif-item {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 13px 0; border-bottom: 1px solid var(--n100);
}
.lj-notif-item:last-child { border-bottom: none; }
.lj-notif-ico {
  width: 36px; height: 36px; border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: .78rem; flex-shrink: 0;
}
.lj-notif-ico.blue   { background: var(--blue-light);   color: var(--blue); }
.lj-notif-ico.green  { background: var(--green-light);  color: var(--green); }
.lj-notif-ico.orange { background: var(--orange-light); color: var(--orange); }
.lj-notif-ico.purple { background: var(--purple-light); color: var(--purple); }
.lj-notif-ico.red    { background: var(--red-light);    color: var(--red); }
.lj-notif-text { font-size: .84rem; color: var(--n700); line-height: 1.55; flex: 1; }
.lj-notif-text strong { color: var(--n900); }
.lj-notif-time { font-size: .7rem; color: var(--n400); margin-top: 4px; }
.lj-notif-unread-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--blue); flex-shrink: 0; margin-top: 6px;
}

/* ═══════════════════════════════════════════════════════
   SETTINGS
═══════════════════════════════════════════════════════ */
.lj-setting-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 15px 0; border-bottom: 1px solid var(--n100); gap: 16px;
}
.lj-setting-row:last-child { border-bottom: none; }
.lj-setting-label { font-weight: 600; color: var(--n800); font-size: .875rem; }
.lj-setting-sub   { font-size: .73rem; color: var(--n500); margin-top: 2px; line-height: 1.4; }

/* ═══════════════════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════════════════ */
.lj-stat-grid {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 16px; margin-bottom: 22px;
}
.lj-stat-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--radius); padding: 18px 18px 14px;
  position: relative; overflow: hidden;
  transition: transform .2s, box-shadow .2s;
}
.lj-stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
.lj-stat-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
}
.lj-stat-card.blue::before   { background: var(--blue); }
.lj-stat-card.green::before  { background: var(--green); }
.lj-stat-card.orange::before { background: var(--orange); }
.lj-stat-card.purple::before { background: var(--purple); }
.lj-stat-icon {
  width: 38px; height: 38px; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; margin-bottom: 10px;
}
.lj-stat-icon.blue   { background: var(--blue-light);   color: var(--blue); }
.lj-stat-icon.green  { background: var(--green-light);  color: var(--green); }
.lj-stat-icon.orange { background: var(--orange-light); color: var(--orange); }
.lj-stat-icon.purple { background: var(--purple-light); color: var(--purple); }
.lj-stat-val {
  font-family: var(--f-display); font-weight: 800; font-size: 1.85rem;
  color: var(--n900); letter-spacing: -.5px; line-height: 1; margin-bottom: 3px;
}
.lj-stat-label { font-size: .78rem; color: var(--n500); font-weight: 500; }
.lj-stat-delta {
  font-size: .72rem; font-weight: 600; margin-top: 8px;
  display: flex; align-items: center; gap: 4px;
}
.lj-stat-delta.up      { color: var(--green); }
.lj-stat-delta.neutral { color: var(--n400); }

/* ═══════════════════════════════════════════════════════
   PROFILE COMPLETION CARD
═══════════════════════════════════════════════════════ */
.lj-progress-card {
  background: linear-gradient(135deg, #1d4ed8 0%, #6d28d9 100%);
  border-radius: var(--radius); padding: 22px 24px;
  margin-bottom: 22px; position: relative; overflow: hidden;
}
.lj-progress-card::before {
  content: ''; position: absolute; top: -50px; right: -50px;
  width: 180px; height: 180px; border-radius: 50%;
  background: rgba(255,255,255,.06);
}
.lj-progress-card::after {
  content: ''; position: absolute; bottom: -30px; right: 60px;
  width: 100px; height: 100px; border-radius: 50%;
  background: rgba(255,255,255,.04);
}
.lj-pc-inner {
  display: flex; align-items: center; gap: 22px;
  position: relative; z-index: 1; flex-wrap: wrap;
}
.lj-pc-text  { flex: 1; min-width: 200px; }
.lj-pc-label {
  font-size: .7rem; font-weight: 700; color: rgba(255,255,255,.72);
  text-transform: uppercase; letter-spacing: .08em; margin-bottom: 3px;
}
.lj-pc-title {
  font-family: var(--f-display); font-size: 1.15rem; font-weight: 800;
  color: #fff; margin-bottom: 4px; line-height: 1.3;
}
.lj-pc-sub   { font-size: .82rem; color: rgba(255,255,255,.75); line-height: 1.55; }
.lj-pc-bar-wrap  { margin-top: 12px; }
.lj-pc-bar-track { height: 6px; background: rgba(255,255,255,.2); border-radius: 100px; overflow: hidden; }
.lj-pc-bar-fill  { height: 100%; background: #fff; border-radius: 100px; transition: width 1.2s ease; }
.lj-pc-pct {
  font-family: var(--f-display); font-size: 2.4rem; font-weight: 900;
  color: #fff; letter-spacing: -1.5px; text-align: center; flex-shrink: 0; line-height: 1;
}
.lj-pc-pct small { font-size: .95rem; font-weight: 600; color: rgba(255,255,255,.7); }
.lj-pc-checklist { margin-top: 11px; display: flex; gap: 6px; flex-wrap: wrap; }
.lj-pc-check {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: .68rem; font-weight: 600;
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 100px; padding: 3px 9px; color: rgba(255,255,255,.8);
}
.lj-pc-check.done { background: rgba(255,255,255,.25); color: #fff; }

/* ═══════════════════════════════════════════════════════
   JOB LISTING
═══════════════════════════════════════════════════════ */
.lj-rec-job {
  padding: 12px 16px; border-bottom: 1px solid var(--n100);
  transition: background .14s; cursor: pointer;
}
.lj-rec-job:last-child { border-bottom: none; }
.lj-rec-job:hover      { background: var(--n50); }
.lj-rec-job-title  { font-weight: 700; color: var(--n900); font-size: .875rem; margin-bottom: 2px; line-height: 1.3; }
.lj-rec-job-co     { font-size: .75rem; color: var(--n600); margin-bottom: 7px; display: flex; align-items: center; gap: 5px; }
.lj-rec-job-tags   { display: flex; gap: 5px; flex-wrap: wrap; }
.lj-rec-tag {
  font-size: .66rem; font-weight: 600; padding: 2px 8px;
  border-radius: 4px; border: 1px solid var(--n200);
  color: var(--n600); background: var(--n50);
}
.lj-rec-tag.salary { background: var(--green-light);  border-color: #86efac; color: #065f46; }
.lj-rec-tag.type   { background: var(--blue-light);   border-color: var(--blue-mid); color: #1e40af; }
.lj-rec-job-match  {
  font-size: .68rem; font-weight: 700; color: var(--green);
  margin-top: 6px; display: flex; align-items: center; gap: 4px;
}

/* ═══════════════════════════════════════════════════════
   APPLICATION ROW
═══════════════════════════════════════════════════════ */
.lj-app-row {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 0; border-bottom: 1px solid var(--n100);
}
.lj-app-row:last-child { border-bottom: none; }
.lj-app-logo {
  width: 40px; height: 40px; border-radius: var(--radius-sm);
  background: var(--n100); border: 1px solid var(--n200);
  display: flex; align-items: center; justify-content: center;
  color: var(--n500); font-size: .8rem; flex-shrink: 0; overflow: hidden;
}
.lj-app-logo img { width: 100%; height: 100%; object-fit: cover; }
.lj-app-info    { flex: 1; min-width: 0; }
.lj-app-title   { font-weight: 700; color: var(--n900); font-size: .875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lj-app-company { font-size: .73rem; color: var(--n500); margin-top: 1px; }
.lj-app-date    { font-size: .68rem; color: var(--n400); margin-top: 1px; }

/* ═══════════════════════════════════════════════════════
   SAVED JOB CARDS
═══════════════════════════════════════════════════════ */
.lj-saved-job-card {
  border: 1.5px solid var(--n200); border-radius: 10px;
  padding: 16px; transition: all .18s; background: #fff;
}
.lj-saved-job-card:hover { border-color: var(--blue); box-shadow: var(--shadow-sm); }
.lj-sjc-title  { font-weight: 700; color: var(--n900); font-size: .875rem; margin-bottom: 2px; line-height: 1.3; }
.lj-sjc-co     { font-size: .75rem; color: var(--n600); margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
.lj-sjc-tags   { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 10px; }
.lj-sjc-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

/* ═══════════════════════════════════════════════════════
   AVATAR + RESUME UPLOAD
═══════════════════════════════════════════════════════ */
.lj-avatar-upload  { display: flex; align-items: center; gap: 20px; margin-bottom: 22px; flex-wrap: wrap; }
.lj-avatar-preview {
  width: 80px; height: 80px; border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), #6d28d9);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 700; color: #fff; font-size: 1.5rem;
  flex-shrink: 0; border: 3px solid var(--n200); position: relative; overflow: hidden;
}
.lj-avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
.lj-avatar-edit-btn {
  position: absolute; bottom: 0; right: 0;
  width: 24px; height: 24px; border-radius: 50%;
  background: var(--blue); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: .52rem; border: 2px solid #fff; cursor: pointer;
}
.lj-avatar-info { font-size: .8rem; color: var(--n500); line-height: 1.65; }
.lj-avatar-info strong { color: var(--n700); display: block; margin-bottom: 2px; font-size: .875rem; }
.lj-resume-box {
  border: 2px dashed var(--n300); border-radius: 11px; padding: 26px 20px;
  text-align: center; cursor: pointer; transition: all .18s;
  position: relative; background: var(--n50);
}
.lj-resume-box:hover { border-color: var(--blue); background: var(--blue-light); }
.lj-resume-box input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.lj-resume-icon {
  width: 48px; height: 48px; border-radius: 11px;
  background: var(--blue-light); border: 1.5px solid var(--blue-mid);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem; color: var(--blue); margin: 0 auto 10px;
}
.lj-resume-title { font-weight: 700; color: var(--n800); font-size: .875rem; margin-bottom: 3px; }
.lj-resume-sub   { font-size: .76rem; color: var(--n400); }
.lj-resume-uploaded {
  display: flex; align-items: center; gap: 12px;
  background: var(--green-light); border: 1.5px solid #86efac;
  border-radius: 9px; padding: 12px 14px; margin-bottom: 13px;
}
.lj-ru-icon { width: 38px; height: 38px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center; color: var(--green); font-size: .86rem; flex-shrink: 0; }
.lj-ru-name { font-weight: 700; color: #065f46; font-size: .875rem; }
.lj-ru-meta { font-size: .71rem; color: #16a34a; }

/* ═══════════════════════════════════════════════════════
   TIMELINE
═══════════════════════════════════════════════════════ */
.lj-timeline { display: flex; flex-direction: column; }
.lj-tl-item  { display: flex; gap: 13px; padding-bottom: 18px; }
.lj-tl-item:last-child { padding-bottom: 0; }
.lj-tl-left  { display: flex; flex-direction: column; align-items: center; }
.lj-tl-dot {
  width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: .66rem;
  border: 2px solid var(--blue); background: var(--blue); color: #fff;
}
.lj-tl-dot.outline { background: #fff; color: var(--blue); }
.lj-tl-dot.done    { background: var(--green); border-color: var(--green); color: #fff; }
.lj-tl-line  { flex: 1; width: 2px; background: var(--n100); margin-top: 4px; min-height: 18px; }
.lj-tl-content { flex: 1; padding-top: 3px; }
.lj-tl-title { font-weight: 700; color: var(--n900); font-size: .875rem; }
.lj-tl-sub   { font-size: .76rem; color: var(--n500); margin-top: 2px; line-height: 1.55; }

/* ═══════════════════════════════════════════════════════
   PASSWORD STRENGTH
═══════════════════════════════════════════════════════ */
.lj-password-strength { height: 4px; border-radius: 100px; background: var(--n100); overflow: hidden; margin-top: 6px; }
.lj-pwd-bar { height: 100%; border-radius: 100px; transition: width .3s, background .3s; }

/* ═══════════════════════════════════════════════════════
   DANGER ZONE
═══════════════════════════════════════════════════════ */
.lj-danger-zone {
  background: var(--red-light); border: 1.5px solid #fecaca;
  border-radius: 9px; padding: 16px 18px;
}

/* ═══════════════════════════════════════════════════════
   SESSION ALERTS
═══════════════════════════════════════════════════════ */
.lj-session-alert {
  display: flex; align-items: center; gap: 10px;
  border-radius: 9px; padding: 11px 14px; margin-bottom: 18px;
  font-size: .84rem; line-height: 1.4;
}
.lj-session-alert.success { background: var(--green-light); border: 1.5px solid #86efac; color: #065f46; }
.lj-session-alert.error   { background: var(--red-light);   border: 1.5px solid #fecaca; color: var(--red); }

/* ═══════════════════════════════════════════════════════
   RESPONSIVE — DESKTOP LARGE (≤1280px)
═══════════════════════════════════════════════════════ */
@media (max-width: 1280px) {
  .lj-stat-grid { grid-template-columns: 1fr 1fr; }
  .lj-grid-3    { grid-template-columns: 1fr 1fr; }
}

/* ═══════════════════════════════════════════════════════
   RESPONSIVE — TABLET (≤900px)
   Sidebar becomes off-canvas drawer
═══════════════════════════════════════════════════════ */
@media (max-width: 900px) {
  /* Show hamburger inside topbar */
  .lj-hamburger { display: flex; }

  /* Topbar brand: remove fixed width so it can shrink */
  .lj-topbar-brand {
    width: auto;
    border-right: none;
    padding-right: 10px;
  }

  /* Sidebar: starts off-screen, slides in when .is-open is applied */
  .lj-sidebar {
    transform: translateX(-100%);
    transition: transform .28s cubic-bezier(.4,0,.2,1), box-shadow .28s;
    box-shadow: none;
  }
  .lj-sidebar.is-open {
    transform: translateX(0);
    box-shadow: var(--shadow-lg);
  }

  /* Main content: no sidebar offset on mobile */
  .lj-main        { margin-left: 0; padding: 18px 16px 64px; }
  .lj-footer-wrap { margin-left: 0; }

  /* Grids */
  .lj-grid-2    { grid-template-columns: 1fr; }
  .lj-form-grid { grid-template-columns: 1fr; }
  .lj-form-grid .lj-fgroup.full { grid-column: auto; }
  .lj-form-grid-3 { grid-template-columns: 1fr 1fr; }
  .lj-page-title  { font-size: 1.35rem; }
}

/* ═══════════════════════════════════════════════════════
   RESPONSIVE — PHONE (≤640px)
═══════════════════════════════════════════════════════ */
@media (max-width: 640px) {
  .lj-stat-grid     { grid-template-columns: 1fr 1fr; }
  .lj-topbar-search { display: none; }
  .lj-form-grid-3   { grid-template-columns: 1fr; }
  .lj-page-title    { font-size: 1.2rem; }
  .lj-page-header   { flex-direction: column; align-items: stretch; }
  .lj-page-header .lj-btn { width: 100%; justify-content: center; }
  .lj-card-head { padding: 13px 15px; }
  .lj-card-body { padding: 15px; }
  .lj-form-footer { padding: 12px 14px; flex-direction: column; }
  .lj-form-footer .lj-btn { width: 100%; justify-content: center; }
  .lj-main { padding: 14px 12px 60px; }
  .lj-pc-pct { display: none; }
  .lj-table { min-width: 520px; }
}

/* ═══════════════════════════════════════════════════════
   RESPONSIVE — SMALL PHONE (≤400px)
═══════════════════════════════════════════════════════ */
@media (max-width: 400px) {
  .lj-stat-grid { grid-template-columns: 1fr; }
  .lj-main      { padding: 12px 10px 56px; }
}
</style>
</head>
<body>

{{-- ════════ TOPBAR ════════ --}}
<header class="lj-topbar">

  {{-- Brand --}}
  <a href="{{ route('home') }}" class="lj-topbar-brand">
    <div class="lj-brand-logo">LJ</div>
    <span class="lj-brand-name">Linear<em>Jobs</em></span>
  </a>

  {{-- Right section --}}
  <div class="lj-topbar-right">
    {{-- Search --}}
    <div class="lj-topbar-search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" placeholder="Search jobs, companies..."/>
    </div>

    {{-- Action icons --}}
    <div class="lj-topbar-actions">
      <a href="{{ route('jobseeker.notifications.index') }}" class="lj-top-icon-btn" title="Notifications">
        <i class="fa-solid fa-bell"></i>
        @if(($unreadNotifications ?? 0) > 0)
          <span class="lj-notif-dot"></span>
        @endif
      </a>
      <a href="{{ route('jobseeker.profile.index') }}" class="lj-topbar-avatar" title="My Profile">
        @if(auth()->user()->profile_photo ?? false)
          <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}"/>
        @else
          {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        @endif
      </a>

      {{-- ★ HAMBURGER — lives here, inside the topbar on mobile ★ --}}
      <button class="lj-hamburger" id="ljHamburger" aria-label="Toggle navigation" aria-expanded="false" aria-controls="ljSidebar">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </div>

</header>

{{-- ════════ SIDEBAR OVERLAY ════════ --}}
<div class="lj-overlay" id="ljOverlay"></div>

{{-- ════════ SIDEBAR ════════ --}}
<aside class="lj-sidebar" id="ljSidebar" aria-label="Dashboard navigation">

  {{-- Profile mini-card --}}
  <div class="lj-sidebar-profile">
    <div class="lj-sp-avatar">
      @if(auth()->user()->profile_photo ?? false)
        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}"/>
      @else
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
      @endif
    </div>
    <div style="min-width:0;">
      <div class="lj-sp-name">{{ auth()->user()->name ?? 'Job Seeker' }}</div>
      <div class="lj-sp-role">
        {{ auth()->user()->job_title ?? 'Job Seeker' }}
        @if(auth()->user()->city ?? false) · {{ auth()->user()->city }}@endif
      </div>
    </div>
  </div>

  <span class="lj-sidebar-label">Menu</span>

  <a href="{{ route('jobseeker.dashboard') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-gauge-high lj-nav-icon"></i> Dashboard
  </a>
  <a href="{{ route('jobseeker.profile.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.profile.index') ? 'active' : '' }}">
    <i class="fa-solid fa-user lj-nav-icon"></i> My Profile
  </a>
  <a href="{{ route('jobseeker.resume.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.resume.index') ? 'active' : '' }}">
    <i class="fa-solid fa-file-lines lj-nav-icon"></i> My Resume
  </a>
  <a href="{{ route('jobs.index') }}" class="lj-nav-item">
    <i class="fa-solid fa-magnifying-glass lj-nav-icon"></i> Search Jobs
  </a>

  <span class="lj-sidebar-label">Applications</span>

  <a href="{{ route('jobseeker.applied.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.applied.index') ? 'active' : '' }}">
    <i class="fa-solid fa-paper-plane lj-nav-icon"></i> Applied Jobs
    @if(($appliedCount ?? 0) > 0)
      <span class="lj-nav-badge blue">{{ $appliedCount }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.saved.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.saved.index') ? 'active' : '' }}">
    <i class="fa-solid fa-bookmark lj-nav-icon"></i> Saved Jobs
    @if(($savedCount ?? 0) > 0)
      <span class="lj-nav-badge green">{{ $savedCount }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.alerts.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.alerts.index') ? 'active' : '' }}">
    <i class="fa-solid fa-bell lj-nav-icon"></i> Job Alerts
    @if(($alertsCount ?? 0) > 0)
      <span class="lj-nav-badge orange">{{ $alertsCount }}</span>
    @endif
  </a>

  <span class="lj-sidebar-label">Account</span>

  <a href="{{ route('jobseeker.notifications.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.notifications.index') ? 'active' : '' }}">
    <i class="fa-solid fa-inbox lj-nav-icon"></i> Notifications
    @if(($unreadNotifications ?? 0) > 0)
      <span class="lj-nav-badge">{{ $unreadNotifications }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.settings.index') }}"
     class="lj-nav-item {{ request()->routeIs('jobseeker.settings.index') ? 'active' : '' }}">
    <i class="fa-solid fa-sliders lj-nav-icon"></i> Settings
  </a>

  <div class="lj-sidebar-spacer"></div>
  <div class="lj-sidebar-divider"></div>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="lj-nav-item" style="color:var(--red);">
      <i class="fa-solid fa-right-from-bracket lj-nav-icon" style="color:var(--red);"></i>
      Logout
    </button>
  </form>

</aside>

{{-- ════════ MAIN ════════ --}}
<main class="lj-main">
  @if(session('success'))
    <div class="lj-session-alert success">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="lj-session-alert error">
      <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
    </div>
  @endif
  @yield('content')
</main>

{{-- ════════ FOOTER ════════ --}}
<div class="lj-footer-wrap">
  @include('frontend.partials.footer')
</div>

{{-- ════════════════════════════════════════════════════
     SIDEBAR TOGGLE SCRIPT
     Single source of truth — no duplicate functions.
════════════════════════════════════════════════════ --}}
<script>
(function () {
  var sidebar  = document.getElementById('ljSidebar');
  var overlay  = document.getElementById('ljOverlay');
  var hamburger = document.getElementById('ljHamburger');
  var isOpen   = false;

  function openSidebar() {
    isOpen = true;
    sidebar.classList.add('is-open');
    overlay.classList.add('is-visible');
    hamburger.classList.add('is-open');
    hamburger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    isOpen = false;
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-visible');
    hamburger.classList.remove('is-open');
    hamburger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  function toggleSidebar() {
    isOpen ? closeSidebar() : openSidebar();
  }

  // Hamburger click
  hamburger.addEventListener('click', function (e) {
    e.stopPropagation();
    toggleSidebar();
  });

  // Overlay click → close
  overlay.addEventListener('click', closeSidebar);

  // ESC key → close
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen) closeSidebar();
  });

  // Close sidebar when a nav link is clicked on mobile (UX: instant navigation feel)
  sidebar.querySelectorAll('a.lj-nav-item').forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth <= 900) closeSidebar();
    });
  });

  // Close sidebar on desktop resize (avoid stale open state)
  window.addEventListener('resize', function () {
    if (window.innerWidth > 900 && isOpen) closeSidebar();
  });
})();

// ── Skill tag removal ──────────────────────────────────────────────────
document.addEventListener('click', function (e) {
  if (e.target.closest('.lj-skill-tag .rm')) {
    e.target.closest('.lj-skill-tag').remove();
  }
});
</script>

<script src="{{ asset('frontend/js/lj-global.js') }}"></script>
@stack('scripts')
</body>
</html>