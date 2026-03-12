{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/layout.blade.php
     Job Seeker Dashboard Layout – LinearJobs
═══════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title', 'Dashboard') – LinearJobs</title>

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>

  {{-- Global CSS --}}
  <link href="{{ asset('frontend/css/lj-global.css') }}" rel="stylesheet"/>
@stack('styles')

<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS & RESET
═══════════════════════════════════════════════ */
:root {
  --blue:        #1a56db;
  --blue-h:      #1648c4;
  --blue-light:  #eff6ff;
  --blue-mid:    #bfdbfe;
  --green:       #059669;
  --green-light: #f0fdf4;
  --orange:      #d97706;
  --orange-light:#fffbeb;
  --red:         #dc2626;
  --red-light:   #fef2f2;
  --purple:      #7c3aed;
  --purple-light:#f5f3ff;
  --n900: #111827; --n800: #1f2937; --n700: #374151;
  --n600: #4b5563; --n500: #6b7280; --n400: #9ca3af;
  --n300: #d1d5db; --n200: #e5e7eb; --n100: #f3f4f6; --n50: #f9fafb;
  --sidebar-w:  256px;
  --header-h:   60px;
  --f:          'DM Sans', sans-serif;
  --f-display:  'Syne', sans-serif;
  --shadow-sm:  0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
  --shadow:     0 4px 12px rgba(0,0,0,.08);
  --shadow-lg:  0 10px 32px rgba(0,0,0,.12);
  --radius:     12px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: var(--f);
  background: #f0f4f8;
  color: var(--n800);
  min-height: 100vh;
}

/* ═══ TOPBAR ═══════════════════════════════════ */
.lj-topbar {
  position: fixed; top: 0; left: 0; right: 0; height: var(--header-h);
  background: #fff; border-bottom: 1px solid var(--n200);
  display: flex; align-items: center; padding: 0;
  z-index: 1000; box-shadow: var(--shadow-sm);
}
.lj-topbar-brand {
  width: var(--sidebar-w); flex-shrink: 0;
  display: flex; align-items: center; padding: 0 20px;
  gap: 10px; border-right: 1px solid var(--n200); height: 100%;
  text-decoration: none;
}
.lj-brand-logo {
  width: 34px; height: 34px; background: var(--blue);
  border-radius: 9px; display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 800; color: #fff; font-size: 1rem;
  letter-spacing: -1px; flex-shrink: 0;
}
.lj-brand-name {
  font-family: var(--f-display); font-weight: 700; font-size: 1.05rem;
  color: var(--n900); letter-spacing: -.3px;
}
.lj-brand-name em { font-style: normal; color: var(--blue); }
.lj-topbar-right {
  flex: 1; display: flex; align-items: center; justify-content: space-between;
  padding: 0 20px;
}
.lj-topbar-search {
  position: relative; max-width: 320px; width: 100%;
}
.lj-topbar-search i {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
  color: var(--n400); font-size: .8rem; pointer-events: none;
}
.lj-topbar-search input {
  width: 100%; border: 1.5px solid var(--n200); border-radius: 8px;
  padding: 8px 14px 8px 34px; font-family: var(--f); font-size: .84rem;
  color: var(--n800); background: var(--n50); outline: none; transition: border-color .2s;
}
.lj-topbar-search input:focus { border-color: var(--blue); background: #fff; }
.lj-topbar-search input::placeholder { color: var(--n400); }
.lj-topbar-actions { display: flex; align-items: center; gap: 8px; }
.lj-top-icon-btn {
  width: 36px; height: 36px; border-radius: 9px; border: 1.5px solid var(--n200);
  background: #fff; cursor: pointer; display: flex; align-items: center;
  justify-content: center; color: var(--n600); font-size: .85rem;
  transition: all .2s; position: relative; text-decoration: none;
}
.lj-top-icon-btn:hover { border-color: var(--blue); color: var(--blue); }
.lj-notif-dot {
  position: absolute; top: 6px; right: 6px; width: 7px; height: 7px;
  border-radius: 50%; background: var(--red); border: 1.5px solid #fff;
}
.lj-topbar-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), #7c3aed);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-family: var(--f-display); font-weight: 700; font-size: .84rem;
  cursor: pointer; flex-shrink: 0; border: 2px solid var(--n200);
  text-decoration: none;
}
.lj-mobile-menu-btn {
  display: none; width: 36px; height: 36px; border-radius: 9px;
  border: 1.5px solid var(--n200); background: #fff; cursor: pointer;
  align-items: center; justify-content: center; color: var(--n600);
  font-size: .9rem; margin-left: 12px;
}

/* ═══ SIDEBAR ═══════════════════════════════════ */
.lj-sidebar {
  position: fixed; top: var(--header-h); left: 0;
  width: var(--sidebar-w); height: calc(100vh - var(--header-h));
  background: #fff; border-right: 1px solid var(--n200);
  overflow-y: auto; padding: 12px 10px 20px; z-index: 900;
  display: flex; flex-direction: column; gap: 2px;
  transition: transform .3s ease;
}
.lj-sidebar::-webkit-scrollbar { width: 3px; }
.lj-sidebar::-webkit-scrollbar-thumb { background: var(--n200); border-radius: 3px; }
.lj-sidebar-profile {
  margin: 4px 0 10px; padding: 12px;
  background: linear-gradient(135deg, var(--blue) 0%, #7c3aed 100%);
  border-radius: 11px; display: flex; align-items: center; gap: 10px;
}
.lj-sp-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: rgba(255,255,255,.2); border: 2px solid rgba(255,255,255,.3);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 700; color: #fff; font-size: .9rem;
  flex-shrink: 0; overflow: hidden;
}
.lj-sp-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.lj-sp-name { font-weight: 700; color: #fff; font-size: .84rem; line-height: 1.2; }
.lj-sp-role { font-size: .7rem; color: rgba(255,255,255,.7); margin-top: 1px; }
.lj-sidebar-section-label {
  font-size: .65rem; font-weight: 800; color: var(--n400);
  letter-spacing: .1em; text-transform: uppercase;
  padding: 14px 10px 6px; display: block;
}
.lj-nav-item {
  display: flex; align-items: center; gap: 10px;
  padding: 9px 12px; border-radius: 9px;
  cursor: pointer; transition: all .18s;
  font-size: .875rem; font-weight: 500; color: var(--n600);
  text-decoration: none; border: none; background: none; width: 100%;
  text-align: left; position: relative; font-family: var(--f);
}
.lj-nav-item:hover { background: var(--n100); color: var(--n800); }
.lj-nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
.lj-nav-icon {
  width: 20px; text-align: center; font-size: .85rem;
  color: var(--n400); flex-shrink: 0; transition: color .18s;
}
.lj-nav-item:hover .lj-nav-icon { color: var(--n700); }
.lj-nav-item.active .lj-nav-icon { color: var(--blue); }
.lj-nav-badge {
  margin-left: auto; min-width: 18px; height: 18px;
  background: var(--red); color: #fff; border-radius: 100px;
  font-size: .6rem; font-weight: 700; display: flex;
  align-items: center; justify-content: center; padding: 0 5px;
}
.lj-nav-badge.green  { background: var(--green); }
.lj-nav-badge.blue   { background: var(--blue); }
.lj-nav-badge.orange { background: var(--orange); }
.lj-sidebar-divider { height: 1px; background: var(--n100); margin: 6px 0; }

/* ═══ SIDEBAR OVERLAY (mobile) ═══════════════════ */
.lj-sidebar-overlay {
  display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45);
  z-index: 850; backdrop-filter: blur(2px);
}

/* ═══ MAIN CONTENT ═══════════════════════════════ */
.lj-main {
  margin-left: var(--sidebar-w);
  margin-top: var(--header-h);
  padding: 28px 28px 60px;
  min-height: calc(100vh - var(--header-h));
}

/* ═══ SHARED COMPONENT STYLES ═══════════════════ */

/* Cards */
.lj-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--radius); overflow: hidden;
}
.lj-card-head {
  padding: 18px 22px; border-bottom: 1px solid var(--n100);
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.lj-card-title {
  font-family: var(--f-display); font-weight: 700; font-size: 1rem;
  color: var(--n900); display: flex; align-items: center; gap: 8px;
}
.lj-card-title i { color: var(--blue); font-size: .9rem; }
.lj-card-body { padding: 22px; }

/* Page header */
.lj-page-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
}
.lj-page-title {
  font-family: var(--f-display); font-weight: 800; font-size: 1.5rem;
  color: var(--n900); letter-spacing: -.5px; line-height: 1.2;
}
.lj-page-subtitle { font-size: .84rem; color: var(--n500); margin-top: 3px; }

/* Buttons */
.lj-btn {
  display: inline-flex; align-items: center; gap: 7px;
  font-family: var(--f); font-weight: 600; border-radius: 8px;
  cursor: pointer; transition: all .2s; text-decoration: none;
  font-size: .875rem; border: none; padding: 9px 18px;
}
.lj-btn-primary  { background: var(--blue); color: #fff; }
.lj-btn-primary:hover  { background: var(--blue-h); transform: translateY(-1px); }
.lj-btn-outline  { background: #fff; color: var(--n700); border: 1.5px solid var(--n200); }
.lj-btn-outline:hover  { border-color: var(--blue); color: var(--blue); }
.lj-btn-ghost    { background: none; color: var(--n600); padding: 9px 14px; }
.lj-btn-ghost:hover    { background: var(--n100); color: var(--n900); }
.lj-btn-sm       { padding: 6px 12px; font-size: .78rem; border-radius: 7px; }
.lj-btn-danger   { background: var(--red-light); color: var(--red); border: 1.5px solid #fecaca; }
.lj-btn-danger:hover   { background: var(--red); color: #fff; }
.lj-btn-green    { background: var(--green-light); color: var(--green); border: 1.5px solid #bbf7d0; }
.lj-btn-green:hover    { background: var(--green); color: #fff; }
.lj-btn-icon     { width: 32px; height: 32px; padding: 0; justify-content: center; }

/* Form elements */
.lj-form-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.lj-form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }
.lj-fgroup      { display: flex; flex-direction: column; gap: 6px; }
.lj-fgroup.full { grid-column: 1 / -1; }
.lj-label       { font-size: .8rem; font-weight: 600; color: var(--n700); }
.lj-label .req  { color: var(--red); margin-left: 2px; }
.lj-input {
  width: 100%; border: 1.5px solid var(--n200); border-radius: 8px;
  padding: 10px 14px; font-family: var(--f); font-size: .875rem;
  color: var(--n900); background: #fff; outline: none; transition: all .2s;
}
.lj-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }
.lj-input::placeholder { color: var(--n400); }
select.lj-input {
  -webkit-appearance: none; appearance: none; cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23a09e9b'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
}
textarea.lj-input { resize: vertical; min-height: 100px; padding-top: 11px; }
.lj-input-wrap  { position: relative; }
.lj-input-ico   { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--n400); font-size: .8rem; pointer-events: none; }
.lj-input-ico.ta { top: 13px; transform: none; }
.lj-input.has-ico { padding-left: 36px; }
.lj-input-hint  { font-size: .73rem; color: var(--n400); display: flex; align-items: center; gap: 4px; }
.lj-form-divider {
  font-size: .7rem; font-weight: 800; color: var(--n400); text-transform: uppercase;
  letter-spacing: .09em; margin: 20px 0 16px; display: flex; align-items: center; gap: 10px;
}
.lj-form-divider::before, .lj-form-divider::after { content: ''; flex: 1; height: 1px; background: var(--n100); }
.lj-form-footer {
  display: flex; align-items: center; justify-content: flex-end; gap: 10px;
  padding: 16px 22px; border-top: 1px solid var(--n100); background: var(--n50);
}

/* Status badges */
.lj-status-badge {
  font-size: .68rem; font-weight: 700; letter-spacing: .04em;
  text-transform: uppercase; padding: 3px 10px; border-radius: 100px; flex-shrink: 0;
}
.lj-status-badge.applied     { background: var(--blue-light); color: var(--blue); }
.lj-status-badge.shortlisted { background: var(--orange-light); color: var(--orange); }
.lj-status-badge.interview   { background: var(--purple-light); color: var(--purple); }
.lj-status-badge.rejected    { background: var(--red-light); color: var(--red); }
.lj-status-badge.hired       { background: var(--green-light); color: var(--green); }

/* Toggle switch */
.lj-toggle {
  width: 40px; height: 22px; border-radius: 100px; background: var(--n200);
  position: relative; cursor: pointer; transition: background .2s; flex-shrink: 0;
}
.lj-toggle.on { background: var(--blue); }
.lj-toggle::after {
  content: ''; position: absolute; left: 3px; top: 3px;
  width: 16px; height: 16px; border-radius: 50%; background: #fff;
  transition: left .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.lj-toggle.on::after { left: calc(100% - 19px); }

/* Chips */
.chip-select { display: flex; flex-wrap: wrap; gap: 7px; }
.chip {
  padding: 5px 14px; border-radius: 100px; border: 1.5px solid var(--n200);
  font-size: .8rem; font-weight: 600; color: var(--n600); cursor: pointer;
  transition: all .2s; background: #fff; user-select: none; font-family: var(--f);
}
.chip:hover { border-color: var(--blue); color: var(--blue); }
.chip.active { background: var(--blue); border-color: var(--blue); color: #fff; }

/* Skill tags */
.lj-skill-cloud  { display: flex; flex-wrap: wrap; gap: 8px; }
.lj-skill-tag {
  display: inline-flex; align-items: center; gap: 6px;
  border: 1.5px solid var(--n200); border-radius: 100px;
  padding: 5px 13px; font-size: .8rem; font-weight: 600; color: var(--n700);
  background: #fff; cursor: pointer; transition: all .2s; user-select: none;
}
.lj-skill-tag:hover { border-color: var(--blue); color: var(--blue); }
.lj-skill-tag.selected { background: var(--blue); border-color: var(--blue); color: #fff; }
.lj-skill-tag .rm {
  width: 14px; height: 14px; border-radius: 50%;
  background: rgba(255,255,255,.3); display: flex; align-items: center;
  justify-content: center; font-size: .6rem; flex-shrink: 0;
}

/* Info box */
.lj-info-box {
  background: var(--blue-light); border: 1.5px solid var(--blue-mid);
  border-radius: 10px; padding: 13px 16px; font-size: .82rem;
  color: #1e40af; display: flex; align-items: flex-start; gap: 9px; margin-bottom: 18px;
}
.lj-info-box i { font-size: .8rem; margin-top: 1px; flex-shrink: 0; }

/* Grid layouts */
.lj-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
.lj-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 24px; }
.lj-section-gap { margin-bottom: 24px; }
.lj-divider { height: 1px; background: var(--n100); margin: 16px 0; }

/* Empty state */
.lj-empty {
  text-align: center; padding: 48px 20px;
  display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.lj-empty i { font-size: 2.2rem; color: var(--n300); }
.lj-empty-title { font-weight: 700; color: var(--n600); font-size: .9rem; }
.lj-empty-sub { font-size: .82rem; color: var(--n400); max-width: 260px; line-height: 1.5; }

/* Table */
.lj-table { width: 100%; border-collapse: collapse; }
.lj-table th {
  text-align: left; font-size: .7rem; font-weight: 800; color: var(--n400);
  text-transform: uppercase; letter-spacing: .07em;
  padding: 10px 16px; background: var(--n50); border-bottom: 1.5px solid var(--n200);
}
.lj-table td {
  padding: 14px 16px; border-bottom: 1px solid var(--n100);
  font-size: .875rem; color: var(--n700); vertical-align: middle;
}
.lj-table tr:last-child td { border-bottom: none; }
.lj-table tr:hover td { background: var(--n50); }
.lj-table-logo {
  width: 34px; height: 34px; border-radius: 8px; background: var(--n100);
  border: 1px solid var(--n200); display: flex; align-items: center;
  justify-content: center; color: var(--n400); font-size: .75rem; flex-shrink: 0; overflow: hidden;
}
.lj-table-logo img { width: 100%; height: 100%; object-fit: cover; }
.lj-table-title { font-weight: 700; color: var(--n900); font-size: .875rem; }
.lj-table-sub   { font-size: .75rem; color: var(--n500); margin-top: 1px; }

/* Alert items */
.lj-alert-item {
  display: flex; align-items: center; gap: 14px; padding: 14px 0;
  border-bottom: 1px solid var(--n100);
}
.lj-alert-item:last-child { border-bottom: none; }
.lj-alert-icon {
  width: 38px; height: 38px; border-radius: 9px; background: var(--blue-light);
  display: flex; align-items: center; justify-content: center;
  color: var(--blue); font-size: .85rem; flex-shrink: 0;
}
.lj-alert-name { font-weight: 700; color: var(--n900); font-size: .875rem; }
.lj-alert-meta { font-size: .75rem; color: var(--n500); margin-top: 2px; }

/* Notification items */
.lj-notif-item {
  display: flex; align-items: flex-start; gap: 12px; padding: 14px 0;
  border-bottom: 1px solid var(--n100);
}
.lj-notif-item:last-child { border-bottom: none; }
.lj-notif-ico {
  width: 36px; height: 36px; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; flex-shrink: 0;
}
.lj-notif-ico.blue   { background: var(--blue-light); color: var(--blue); }
.lj-notif-ico.green  { background: var(--green-light); color: var(--green); }
.lj-notif-ico.orange { background: var(--orange-light); color: var(--orange); }
.lj-notif-ico.purple { background: var(--purple-light); color: var(--purple); }
.lj-notif-ico.red    { background: var(--red-light); color: var(--red); }
.lj-notif-text      { font-size: .84rem; color: var(--n700); line-height: 1.5; flex: 1; }
.lj-notif-text strong { color: var(--n900); }
.lj-notif-time      { font-size: .7rem; color: var(--n400); margin-top: 4px; }
.lj-notif-unread-dot {
  width: 8px; height: 8px; border-radius: 50%; background: var(--blue);
  flex-shrink: 0; margin-top: 5px;
}

/* Settings rows */
.lj-setting-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px 0; border-bottom: 1px solid var(--n100); gap: 16px;
}
.lj-setting-row:last-child { border-bottom: none; }
.lj-setting-label { font-weight: 600; color: var(--n800); font-size: .875rem; }
.lj-setting-sub   { font-size: .75rem; color: var(--n500); margin-top: 2px; }

/* Stat cards */
.lj-stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
.lj-stat-card {
  background: #fff; border: 1.5px solid var(--n200);
  border-radius: var(--radius); padding: 20px 20px 16px;
  position: relative; overflow: hidden; transition: transform .2s, box-shadow .2s;
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
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: .95rem; margin-bottom: 12px;
}
.lj-stat-icon.blue   { background: var(--blue-light); color: var(--blue); }
.lj-stat-icon.green  { background: var(--green-light); color: var(--green); }
.lj-stat-icon.orange { background: var(--orange-light); color: var(--orange); }
.lj-stat-icon.purple { background: var(--purple-light); color: var(--purple); }
.lj-stat-val {
  font-family: var(--f-display); font-weight: 800; font-size: 1.9rem;
  color: var(--n900); letter-spacing: -.5px; line-height: 1; margin-bottom: 4px;
}
.lj-stat-label { font-size: .8rem; color: var(--n500); font-weight: 500; }
.lj-stat-delta { font-size: .72rem; font-weight: 600; margin-top: 8px; display: flex; align-items: center; gap: 4px; }
.lj-stat-delta.up      { color: var(--green); }
.lj-stat-delta.neutral { color: var(--n400); }

/* Profile completion gradient card */
.lj-progress-card {
  background: linear-gradient(135deg, #1a56db 0%, #7c3aed 100%);
  border-radius: var(--radius); padding: 22px 24px;
  margin-bottom: 24px; position: relative; overflow: hidden;
}
.lj-progress-card::before {
  content: ''; position: absolute; top: -50px; right: -50px;
  width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,.06);
}
.lj-progress-card::after {
  content: ''; position: absolute; bottom: -30px; right: 60px;
  width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,.04);
}
.lj-pc-inner { display: flex; align-items: center; gap: 22px; position: relative; z-index: 1; flex-wrap: wrap; }
.lj-pc-text  { flex: 1; min-width: 220px; }
.lj-pc-label { font-size: .78rem; font-weight: 700; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: .07em; margin-bottom: 4px; }
.lj-pc-title { font-family: var(--f-display); font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.lj-pc-sub   { font-size: .82rem; color: rgba(255,255,255,.75); line-height: 1.5; }
.lj-pc-bar-wrap  { margin-top: 14px; }
.lj-pc-bar-track { height: 8px; background: rgba(255,255,255,.2); border-radius: 100px; overflow: hidden; }
.lj-pc-bar-fill  { height: 100%; background: #fff; border-radius: 100px; transition: width 1.2s ease; }
.lj-pc-pct { font-family: var(--f-display); font-size: 2.4rem; font-weight: 800; color: #fff; letter-spacing: -1px; text-align: center; flex-shrink: 0; }
.lj-pc-pct small { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,.7); }
.lj-pc-checklist { margin-top: 14px; display: flex; gap: 8px; flex-wrap: wrap; }
.lj-pc-check {
  display: inline-flex; align-items: center; gap: 5px; font-size: .72rem; font-weight: 600;
  background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18);
  border-radius: 100px; padding: 3px 10px; color: rgba(255,255,255,.8);
}
.lj-pc-check.done { background: rgba(255,255,255,.25); color: #fff; }

/* Job listing cards (search / dashboard) */
.lj-rec-job {
  padding: 14px 16px; border-bottom: 1px solid var(--n100);
  transition: background .15s; cursor: pointer;
}
.lj-rec-job:last-child { border-bottom: none; }
.lj-rec-job:hover { background: var(--n50); }
.lj-rec-job-title  { font-weight: 700; color: var(--n900); font-size: .9rem; margin-bottom: 2px; }
.lj-rec-job-co     { font-size: .78rem; color: var(--n600); margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.lj-rec-job-tags   { display: flex; gap: 5px; flex-wrap: wrap; }
.lj-rec-tag {
  font-size: .68rem; font-weight: 600; padding: 2px 8px;
  border-radius: 4px; border: 1px solid var(--n200); color: var(--n600); background: var(--n50);
}
.lj-rec-tag.salary { background: var(--green-light); border-color: #bbf7d0; color: #166534; }
.lj-rec-tag.type   { background: var(--blue-light); border-color: var(--blue-mid); color: #1e40af; }
.lj-rec-job-match  { font-size: .68rem; font-weight: 700; color: var(--green); margin-top: 6px; display: flex; align-items: center; gap: 4px; }

/* Application row */
.lj-app-row {
  display: flex; align-items: center; gap: 14px; padding: 14px 0;
  border-bottom: 1px solid var(--n100);
}
.lj-app-row:last-child { border-bottom: none; }
.lj-app-logo {
  width: 40px; height: 40px; border-radius: 9px; background: var(--n100);
  border: 1px solid var(--n200); display: flex; align-items: center;
  justify-content: center; color: var(--n500); font-size: .85rem; flex-shrink: 0; overflow: hidden;
}
.lj-app-logo img { width: 100%; height: 100%; object-fit: cover; }
.lj-app-info   { flex: 1; min-width: 0; }
.lj-app-title  { font-weight: 700; color: var(--n900); font-size: .875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lj-app-company { font-size: .75rem; color: var(--n500); margin-top: 1px; }
.lj-app-date   { font-size: .68rem; color: var(--n400); margin-top: 1px; }

/* Saved job cards */
.lj-saved-job-card {
  border: 1.5px solid var(--n200); border-radius: 10px; padding: 16px;
  transition: all .2s; background: #fff;
}
.lj-saved-job-card:hover { border-color: var(--blue); box-shadow: var(--shadow-sm); }
.lj-sjc-title  { font-weight: 700; color: var(--n900); font-size: .9rem; margin-bottom: 3px; }
.lj-sjc-co     { font-size: .78rem; color: var(--n600); margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
.lj-sjc-tags   { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 12px; }
.lj-sjc-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

/* Avatar upload */
.lj-avatar-upload   { display: flex; align-items: center; gap: 20px; margin-bottom: 24px; }
.lj-avatar-preview  {
  width: 80px; height: 80px; border-radius: 50%;
  background: linear-gradient(135deg, var(--blue), #7c3aed);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--f-display); font-weight: 700; color: #fff; font-size: 1.5rem;
  flex-shrink: 0; border: 3px solid var(--n200); position: relative; overflow: hidden;
}
.lj-avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
.lj-avatar-edit-btn {
  position: absolute; bottom: 0; right: 0; width: 24px; height: 24px;
  border-radius: 50%; background: var(--blue); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: .55rem; border: 2px solid #fff; cursor: pointer;
}
.lj-avatar-info { font-size: .8rem; color: var(--n500); line-height: 1.6; }
.lj-avatar-info strong { color: var(--n700); display: block; margin-bottom: 2px; font-size: .875rem; }

/* Resume upload */
.lj-resume-box {
  border: 2px dashed var(--n300); border-radius: 12px; padding: 28px;
  text-align: center; cursor: pointer; transition: all .2s; position: relative; background: var(--n50);
}
.lj-resume-box:hover { border-color: var(--blue); background: var(--blue-light); }
.lj-resume-box input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.lj-resume-icon {
  width: 52px; height: 52px; border-radius: 12px; background: var(--blue-light);
  border: 1.5px solid var(--blue-mid); display: flex; align-items: center;
  justify-content: center; font-size: 1.3rem; color: var(--blue); margin: 0 auto 12px;
}
.lj-resume-title { font-weight: 700; color: var(--n800); font-size: .9rem; margin-bottom: 4px; }
.lj-resume-sub   { font-size: .78rem; color: var(--n400); }
.lj-resume-uploaded {
  display: flex; align-items: center; gap: 14px;
  background: var(--green-light); border: 1.5px solid #86efac;
  border-radius: 10px; padding: 14px 16px; margin-bottom: 16px;
}
.lj-ru-icon { width: 40px; height: 40px; border-radius: 8px; background: #dcfce7; display: flex; align-items: center; justify-content: center; color: var(--green); font-size: .9rem; flex-shrink: 0; }
.lj-ru-name { font-weight: 700; color: #166534; font-size: .875rem; }
.lj-ru-meta { font-size: .72rem; color: #16a34a; }

/* Timeline */
.lj-timeline { display: flex; flex-direction: column; }
.lj-tl-item  { display: flex; gap: 14px; padding-bottom: 20px; }
.lj-tl-item:last-child { padding-bottom: 0; }
.lj-tl-left  { display: flex; flex-direction: column; align-items: center; }
.lj-tl-dot {
  width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: .7rem;
  border: 2px solid var(--blue); background: var(--blue); color: #fff;
}
.lj-tl-dot.outline { background: #fff; color: var(--blue); }
.lj-tl-dot.done    { background: var(--green); border-color: var(--green); color: #fff; }
.lj-tl-line  { flex: 1; width: 2px; background: var(--n100); margin-top: 4px; min-height: 20px; }
.lj-tl-content { flex: 1; padding-top: 4px; }
.lj-tl-title { font-weight: 700; color: var(--n900); font-size: .875rem; }
.lj-tl-sub   { font-size: .78rem; color: var(--n500); margin-top: 2px; line-height: 1.5; }

/* Password strength */
.lj-password-strength { height: 4px; border-radius: 100px; background: var(--n100); overflow: hidden; margin-top: 6px; }
.lj-pwd-bar { height: 100%; border-radius: 100px; transition: width .3s, background .3s; }
.lj-danger-zone {
  background: var(--red-light); border: 1.5px solid #fecaca; border-radius: 10px; padding: 16px 18px;
}

/* ═══ RESPONSIVE ══════════════════════════════ */
@media (max-width: 1200px) {
  .lj-stat-grid { grid-template-columns: 1fr 1fr; }
  .lj-grid-3    { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 900px) {
  .lj-sidebar { transform: translateX(-100%); }
  .lj-sidebar.open { transform: translateX(0); box-shadow: var(--shadow-lg); }
  .lj-sidebar-overlay.open { display: block; }
  .lj-main { margin-left: 0; padding: 16px 16px 60px; }
  .lj-topbar-brand { width: auto; }
  .lj-mobile-menu-btn { display: flex; }
  .lj-grid-2    { grid-template-columns: 1fr; }
  .lj-form-grid { grid-template-columns: 1fr; }
  .lj-form-grid-3 { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
  .lj-stat-grid { grid-template-columns: 1fr 1fr; }
  .lj-topbar-search { display: none; }
  .lj-form-grid-3 { grid-template-columns: 1fr; }
  .lj-page-title { font-size: 1.25rem; }
}
</style>
</head>
<body>

  {{-- HEADER --}}
  @include('frontend.partials.header')

  {{-- MAIN CONTENT --}}

{{-- Mobile overlay --}}
<div class="lj-sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ════════════ SIDEBAR ════════════ --}}
<aside class="lj-sidebar" id="ljSidebar">
  <div class="lj-sidebar-profile">
    <div class="lj-sp-avatar">
      @if(auth()->user()->profile_photo ?? false)
        <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}"/>
      @else
        {{ $initials ?? 'U' }}
      @endif
    </div>
    <div>
      <div class="lj-sp-name">{{ auth()->user()->name ?? 'Job Seeker' }}</div>
      <div class="lj-sp-role">
        {{ auth()->user()->job_title ?? 'Job Seeker' }}
        @if(auth()->user()->city ?? false) · {{ auth()->user()->city }} @endif
      </div>
    </div>
  </div>

  <span class="lj-sidebar-section-label">Menu</span>
  <a href="{{ route('jobseeker.dashboard') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-gauge-high lj-nav-icon"></i> Dashboard
  </a>
  <a href="{{ route('jobseeker.profile') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.profile') ? 'active' : '' }}">
    <i class="fa-solid fa-user lj-nav-icon"></i> My Profile
  </a>
  <a href="{{ route('jobseeker.resume') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.resume') ? 'active' : '' }}">
    <i class="fa-solid fa-file-lines lj-nav-icon"></i> My Resume
  </a>
  <a href="{{ route('jobs.index') }}"
    class="lj-nav-item">
    <i class="fa-solid fa-magnifying-glass lj-nav-icon"></i> Search Jobs
  </a>

  <span class="lj-sidebar-section-label">Applications</span>
  <a href="{{ route('jobseeker.applied') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.applied') ? 'active' : '' }}">
    <i class="fa-solid fa-paper-plane lj-nav-icon"></i> Applied Jobs
    @if(($appliedCount ?? 0) > 0)
      <span class="lj-nav-badge blue">{{ $appliedCount }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.saved') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.saved') ? 'active' : '' }}">
    <i class="fa-solid fa-bookmark lj-nav-icon"></i> Saved Jobs
    @if(($savedCount ?? 0) > 0)
      <span class="lj-nav-badge green">{{ $savedCount }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.alerts') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.alerts') ? 'active' : '' }}">
    <i class="fa-solid fa-bell lj-nav-icon"></i> Job Alerts
    @if(($alertsCount ?? 0) > 0)
      <span class="lj-nav-badge orange">{{ $alertsCount }}</span>
    @endif
  </a>

  <span class="lj-sidebar-section-label">Account</span>
  <a href="{{ route('jobseeker.notifications') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.notifications') ? 'active' : '' }}">
    <i class="fa-solid fa-inbox lj-nav-icon"></i> Notifications
    @if(($unreadNotifications ?? 0) > 0)
      <span class="lj-nav-badge" style="background:var(--red);">{{ $unreadNotifications }}</span>
    @endif
  </a>
  <a href="{{ route('jobseeker.settings') }}"
    class="lj-nav-item {{ request()->routeIs('jobseeker.settings') ? 'active' : '' }}">
    <i class="fa-solid fa-sliders lj-nav-icon"></i> Settings
  </a>

  <div class="lj-sidebar-divider" style="margin-top:auto;"></div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="lj-nav-item" style="color:var(--red);">
      <i class="fa-solid fa-right-from-bracket lj-nav-icon" style="color:var(--red);"></i> Logout
    </button>
  </form>
</aside>

{{-- ════════════ MAIN CONTENT ════════════ --}}
<main class="lj-main">
  @if(session('success'))
    <div style="background:var(--green-light);border:1.5px solid #86efac;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.875rem;color:#166534;">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div style="background:var(--red-light);border:1.5px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.875rem;color:var(--red);">
      <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
    </div>
  @endif

  @yield('content')
</main>

  {{-- HEADER --}}
  @include('frontend.partials.footer')

  {{-- MAIN CONTENT --}}
{{-- ════════════ GLOBAL SCRIPTS ════════════ --}}
<script>
function toggleSidebar() {
  document.getElementById('ljSidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('open');
}
function filterChip(el, group) {
  const parent = group ? document.getElementById(group) : el.parentElement;
  parent.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
}
function toggleSwitch(el) { el.classList.toggle('on'); }
// Skill tag removal
document.addEventListener('click', function(e) {
  if (e.target.closest('.lj-skill-tag .rm')) {
    e.target.closest('.lj-skill-tag').remove();
  }
});
</script>

@stack('scripts')

</body>
</html>