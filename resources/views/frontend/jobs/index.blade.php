{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/jobs/find-jobs.blade.php
     Find Jobs – LinearJobs (Modern & Responsive)
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Find Jobs in Tamil Nadu – LinearJobs')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ── CSS VARIABLES (Fallbacks & Customization) ────────── */
        :root {
            --blue: #1a56db;
            --blue-h: #1e429f;
            --n50: #f9fafb;
            --n100: #f3f4f6;
            --n200: #e5e7eb;
            --n400: #9ca3af;
            --n500: #6b7280;
            --n600: #4b5563;
            --n700: #374151;
            --n800: #1f2937;
            --n900: #111827;
            --green: #10b981;
            --f: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* ── RESET & BASE ─────────────────────────────────── */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        body {
            background-color: #ffffff; /* Requested White Background */
        }

        /* ── BACKDROP OVERLAY (For Mobile Drawers) ────────── */
        .lj-backdrop {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(17, 24, 39, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(2px);
        }
        .lj-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* ── TOP SEARCH BAR ───────────────────────────────── */
        .lj-jobs-searchbar {
            background: #ffffff;
            border-bottom: 1px solid var(--n200);
            padding: 16px 24px;
            position: sticky;
            top: 64px; /* Adjust based on your main navbar height */
            z-index: 100;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
        }

        .lj-jobs-searchbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .lj-sb-field {
            position: relative;
            flex: 1;
        }

        .lj-sb-field i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: .9rem;
            pointer-events: none;
        }

        .lj-sb-field input,
        .lj-sb-field select {
            width: 100%;
            border: 1px solid var(--n200);
            border-radius: 8px;
            padding: 12px 14px 12px 40px;
            font-family: var(--f);
            font-size: .95rem;
            color: var(--n900);
            background: var(--n50);
            outline: none;
            transition: all .2s ease;
        }

        .lj-sb-field input:focus,
        .lj-sb-field select:focus {
            background: #ffffff;
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(26, 86, 219, .1);
        }

        .lj-sb-field input::placeholder { color: var(--n500); }

        select.lj-sb-field-sel {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .lj-sb-btn {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-family: var(--f);
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all .2s;
        }

        .lj-sb-btn:hover { background: var(--blue-h); }

        .lj-sb-reset {
            background: #ffffff;
            color: var(--n600);
            border: 1px solid var(--n200);
            border-radius: 8px;
            padding: 12px 16px;
            font-family: var(--f);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all .2s;
        }

        .lj-sb-reset:hover {
            border-color: var(--n400);
            color: var(--n900);
            background: var(--n50);
        }

        /* ── 3-COLUMN LAYOUT ──────────────────────────────── */
        .lj-jobs-page {
            background: #ffffff; /* Requested White Background */
            min-height: calc(100vh - 64px);
        }

        .lj-jobs-layout {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 260px 1fr 500px;
            gap: 0;
            min-height: calc(100vh - 140px);
        }

        /* ── LEFT SIDEBAR ─────────────────────────────────── */
        .lj-jobs-sidebar {
            background: #ffffff;
            border-right: 1px solid var(--n200);
            padding: 24px 20px;
            position: sticky;
            top: 140px; /* Adjust based on navbar + searchbar */
            height: calc(100vh - 140px);
            overflow-y: auto;
        }
        
        .lj-sidebar-mobile-header {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--n200);
        }
        
        .lj-sidebar-mobile-header h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--n900);
        }
        
        .lj-sidebar-close {
            background: var(--n100); border: none; font-size: 1.1rem;
            color: var(--n600); cursor: pointer; padding: 6px 10px; border-radius: 6px;
            transition: all .2s;
        }
        .lj-sidebar-close:hover { background: var(--n200); color: var(--n900); }

        .lj-sidebar-title {
            font-size: .8rem;
            font-weight: 800;
            color: var(--n500);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-sidebar-title i { color: var(--blue); }

        .lj-filter-group { margin-bottom: 26px; }

        .lj-filter-label {
            font-size: .9rem;
            font-weight: 700;
            color: var(--n800);
            margin-bottom: 12px;
            display: block;
        }

        .lj-filter-select {
            width: 100%;
            border: 1px solid var(--n200);
            border-radius: 8px;
            padding: 12px 30px 12px 14px;
            font-family: var(--f);
            font-size: .9rem;
            color: var(--n800);
            background: var(--n50);
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
            outline: none;
            transition: all .2s;
        }

        .lj-filter-select:focus {
            border-color: var(--blue);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(26, 86, 219, .1);
        }

        .lj-filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .lj-filter-chip {
            border: 1px solid var(--n200);
            border-radius: 100px;
            padding: 8px 16px;
            font-size: .85rem;
            font-weight: 500;
            color: var(--n600);
            background: #ffffff;
            cursor: pointer;
            transition: all .2s;
        }

        .lj-filter-chip:hover {
            border-color: var(--n400);
            color: var(--n900);
        }

        .lj-filter-chip.active {
            background: rgba(26, 86, 219, .08);
            border-color: var(--blue);
            color: var(--blue);
            font-weight: 600;
        }

        .lj-sidebar-divider {
            height: 1px;
            background: var(--n200);
            margin: 24px 0;
        }

        .lj-filter-apply-btn {
            width: 100%;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-family: var(--f);
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s;
        }

        .lj-filter-apply-btn:hover { background: var(--blue-h); }

        .lj-filter-reset-btn {
            width: 100%;
            background: transparent;
            color: var(--n500);
            border: none;
            padding: 12px;
            font-family: var(--f);
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: color .2s;
        }
        .lj-filter-reset-btn:hover { color: var(--n800); text-decoration: underline; }

        /* ── JOB LIST (MIDDLE) ────────────────────────────── */
        .lj-jobs-list {
            border-right: 1px solid var(--n200);
            background: var(--n50); /* Subtle contrast to make white cards pop */
            overflow-y: auto;
            height: calc(100vh - 140px);
            padding: 16px;
        }

        .lj-jobs-list-header {
            margin: -16px -16px 16px -16px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--n200);
            background: #ffffff;
            position: sticky;
            top: -16px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .lj-jobs-count {
            font-size: .9rem;
            color: var(--n600);
        }

        .lj-jobs-count strong {
            color: var(--n900);
            font-weight: 700;
        }
        
        .lj-jobs-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lj-jobs-sort {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .9rem;
            color: var(--n600);
            font-weight: 500;
        }

        .lj-sort-select {
            border: 1px solid var(--n200);
            border-radius: 8px;
            padding: 8px 32px 8px 12px;
            font-size: .9rem;
            font-weight: 600;
            color: var(--n900);
            background: #ffffff;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5'%3E%3Cpath d='M0 0l4.5 5 4.5-5z' fill='%236b7280'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            cursor: pointer;
            outline: none;
        }

        /* ── JOB CARD (Modern UI Update) ──────────────────── */
        .lj-job-card {
            padding: 20px;
            border: 1px solid var(--n200);
            border-radius: 12px;
            margin-bottom: 16px;
            cursor: pointer;
            transition: all .2s ease;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .lj-job-card:hover {
            border-color: var(--blue);
            box-shadow: 0 6px 16px rgba(26, 86, 219, 0.08);
            transform: translateY(-1px);
        }

        .lj-job-card.active {
            background: #f0f5ff;
            border-color: var(--blue);
            box-shadow: 0 0 0 2px rgba(26, 86, 219, 0.2);
        }

        .lj-job-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .lj-job-badge {
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .lj-job-badge.urgent { background: #fef3c7; color: #b45309; }
        .lj-job-badge.new { background: #dcfce7; color: #166534; }
        .lj-job-badge.hiring { background: #ede9fe; color: #6d28d9; }

        .lj-job-card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--n900);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .lj-job-card-title:hover { color: var(--blue); }

        .lj-job-card-company {
            font-size: .9rem;
            color: var(--n700);
            font-weight: 600;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-job-card-company i { font-size: .8rem; color: var(--n400); }

        .lj-job-card-location {
            font-size: .85rem;
            color: var(--n500);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lj-job-card-location i { font-size: .8rem; color: var(--n400); }

        .lj-job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 16px;
        }

        .lj-job-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 600;
            color: var(--n700);
            background: var(--n100);
            border-radius: 6px;
            padding: 6px 10px;
        }

        .lj-job-tag i { font-size: .75rem; color: var(--n500); }

        .lj-job-tag.salary { color: #047857; background: #f0fdf4; border: 1px solid #bbf7d0; }
        .lj-job-tag.salary i { color: #047857; }
        .lj-job-tag.type { color: #1d4ed8; background: #eff6ff; border: 1px solid #bfdbfe; }
        .lj-job-tag.openings { color: #0f766e; background: #f0fdfa; border: 1px solid #99f6e4; }
        .lj-job-tag.openings i { color: #0f766e; }

        .lj-job-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--n200);
        }

        .lj-job-date {
            font-size: .85rem;
            color: var(--n500);
            font-weight: 500;
        }

        .lj-job-save {
            background: none;
            border: none;
            color: var(--n400);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 50%;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lj-job-save:hover {
            color: var(--blue);
            background: rgba(26, 86, 219, .1);
        }

        .lj-job-logo {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--n400);
            flex-shrink: 0;
            border: 1px solid var(--n200);
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }

        .lj-job-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        /* ── PAGINATION ───────────────────────────────────── */
        .lj-pagination {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid var(--n200);
            margin-bottom: 24px;
        }

        .lj-page-btn {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid var(--n200);
            background: #ffffff;
            font-family: var(--f);
            font-size: .9rem;
            font-weight: 600;
            color: var(--n700);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            text-decoration: none;
        }

        .lj-page-btn:hover:not(:disabled) {
            border-color: var(--blue);
            color: var(--blue);
            background: #f0f5ff;
        }

        .lj-page-btn.active {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .lj-page-btn.nav {
            padding: 0 16px;
            width: auto;
            gap: 6px;
        }
        .lj-page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--n50);
        }

        /* ── FLOATING FILTER BUTTON (Mobile Only) ─────────── */
        .lj-mobile-fab {
            display: none;
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--n900); /* Dark elegant contrast */
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 28px;
            font-family: var(--f);
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            z-index: 900;
            cursor: pointer;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
            transition: transform 0.2s;
        }
        .lj-mobile-fab:active {
            transform: translateX(-50%) scale(0.95);
        }

        /* ── RIGHT PANEL (Job Preview) ────────────────────── */
        .lj-jobs-preview {
            background: #ffffff;
            overflow-y: auto;
            height: calc(100vh - 140px);
            position: sticky;
            top: 140px;
        }

        .lj-preview-mobile-header {
            display: none; /* Only visible on mobile/tablet */
            padding: 16px 24px;
            background: #ffffff;
            border-bottom: 1px solid var(--n200);
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        
        .lj-preview-back-btn {
            background: none; border: none; font-size: 1rem; font-weight: 700;
            color: var(--n900); display: flex; align-items: center; gap: 8px; cursor: pointer;
        }

        .lj-preview-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            gap: 16px;
            color: var(--n400);
            text-align: center;
            padding: 40px;
        }

        .lj-preview-empty i { font-size: 3.5rem; opacity: .2; }
        .lj-preview-empty p { font-size: 1.1rem; color: var(--n500); font-weight: 500; }

        .lj-preview-header {
            padding: 30px 24px 24px;
            border-bottom: 1px solid var(--n200);
            background: #ffffff;
        }

        .lj-preview-badge-row { display: flex; gap: 8px; margin-bottom: 16px; }

        .lj-preview-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--n900);
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .lj-preview-company {
            font-size: 1.1rem;
            color: var(--n800);
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-preview-company i { font-size: .9rem; color: var(--n400); }

        .lj-preview-location {
            font-size: .95rem;
            color: var(--n600);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-preview-actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }

        .lj-apply-btn {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: var(--f);
            font-size: 1rem;
            font-weight: 700;
            padding: 14px 28px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all .2s;
            text-decoration: none;
        }

        .lj-apply-btn:hover { background: var(--blue-h); box-shadow: 0 4px 12px rgba(26, 86, 219, 0.2); }

        .lj-save-btn {
            background: #ffffff;
            color: var(--n700);
            border: 1px solid var(--n200);
            border-radius: 8px;
            font-family: var(--f);
            font-size: .95rem;
            font-weight: 600;
            padding: 14px 24px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            text-decoration: none;
        }

        .lj-save-btn:hover { border-color: var(--blue); color: var(--blue); background: #f0f5ff; }

        .lj-preview-body { padding: 30px 24px; }

        .lj-preview-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 30px;
            background: var(--n50);
            border: 1px solid var(--n200);
            border-radius: 12px;
            padding: 20px;
        }

        .lj-meta-item { display: flex; flex-direction: column; gap: 6px; }

        .lj-meta-label {
            font-size: .8rem;
            font-weight: 700;
            color: var(--n500);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .lj-meta-value {
            font-size: .95rem;
            font-weight: 700;
            color: var(--n900);
            display: flex; align-items: center; gap: 8px;
        }

        .lj-meta-value i { color: var(--n400); font-size: .85rem; }

        .lj-preview-section { margin-bottom: 32px; }

        .lj-preview-section-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--n900);
            margin-bottom: 16px;
        }

        .lj-preview-desc {
            font-size: 1rem;
            color: var(--n700);
            line-height: 1.7;
        }

        .lj-preview-list {
            list-style: none; padding: 0; margin: 0;
            display: flex; flex-direction: column; gap: 12px;
        }

        .lj-preview-list li {
            display: flex; align-items: flex-start; gap: 12px;
            font-size: 1rem; color: var(--n700); line-height: 1.6;
        }

        .lj-preview-list li::before {
            content: '•';
            color: var(--blue);
            font-size: 1.4rem;
            line-height: 1;
        }

        .lj-skill-tags, .lj-benefit-tags { display: flex; flex-wrap: wrap; gap: 10px; }

        .lj-skill-tag {
            border: 1px solid var(--n200); border-radius: 100px;
            padding: 8px 16px; font-size: .9rem; font-weight: 600;
            color: var(--n800); background: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .lj-benefit-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 100px;
            padding: 8px 16px; font-size: .9rem; font-weight: 600; color: #166534;
        }

        .lj-preview-apply-bar {
            padding: 20px 24px;
            border-top: 1px solid var(--n200);
            background: #ffffff;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        /* ── ACTIVE JOB HIGHLIGHT ─────────────────────────── */
        .lj-no-jobs {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 80px 20px; gap: 16px; color: var(--n500); text-align: center;
        }
        .lj-no-jobs i { font-size: 3rem; opacity: .3; }

        /* ── SCROLLBAR ────────────────────────────────────── */
        .lj-jobs-list::-webkit-scrollbar,
        .lj-jobs-preview::-webkit-scrollbar,
        .lj-jobs-sidebar::-webkit-scrollbar { width: 6px; }
        .lj-jobs-list::-webkit-scrollbar-track,
        .lj-jobs-preview::-webkit-scrollbar-track,
        .lj-jobs-sidebar::-webkit-scrollbar-track { background: transparent; }
        .lj-jobs-list::-webkit-scrollbar-thumb,
        .lj-jobs-preview::-webkit-scrollbar-thumb,
        .lj-jobs-sidebar::-webkit-scrollbar-thumb { background: var(--n200); border-radius: 10px; }

        /* ═══════════════════════════════════════════════════
           RESPONSIVE DESIGN (MOBILE & TABLET EXCELLENCE)
           ═══════════════════════════════════════════════════ */
        
        @media(max-width: 1100px) {
            /* Switch to 2 columns on tablet */
            .lj-jobs-layout { grid-template-columns: 1fr 1fr; }
            
            /* Sidebar becomes a Drawer */
            .lj-jobs-sidebar {
                position: fixed;
                top: 0; left: -100%; /* Hidden off-screen */
                width: 340px; max-width: 85vw;
                height: 100vh;
                z-index: 1000;
                box-shadow: 4px 0 24px rgba(0,0,0,0.15);
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                padding-top: 20px;
                padding-bottom: 100px; /* Safe space at bottom */
            }
            .lj-jobs-sidebar.open { left: 0; }
            .lj-sidebar-mobile-header { display: flex; }
        }

        @media(max-width: 850px) {
            /* Switch to 1 column on mobile */
            .lj-jobs-layout { grid-template-columns: 1fr; min-height: auto; }
            
            /* UN-STICK AND SHRINK SEARCH BAR ON MOBILE (Fixes issue) */
            .lj-jobs-searchbar { 
                position: relative; /* Removes the massive sticky block */
                top: 0; 
                padding: 16px; 
                z-index: 10;
                box-shadow: none;
            }
            
            /* Arrange inputs into a tight 2-column grid instead of stacking */
            .lj-jobs-searchbar-inner { 
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .lj-jobs-searchbar-inner .lj-sb-field { max-width: 100% !important; }
            .lj-jobs-searchbar-inner .lj-sb-field:nth-child(1) { grid-column: 1 / -1; } /* Keyword spans full width */
            
            .lj-sb-btn { grid-column: 1 / -1; justify-content: center; padding: 14px; font-size: 1rem; }
            .lj-sb-reset { display: none; } /* Hide reset on mobile to save vertical space */
            
            .lj-jobs-list { border-right: none; height: auto; overflow: visible; background: #ffffff; padding: 16px; }
            
            /* Show Floating Action Button on mobile */
            .lj-mobile-fab { display: flex; }
            
            /* Job Preview Modal full screen overlay */
            .lj-jobs-preview {
                position: fixed;
                top: 0; right: -100%;
                width: 100%; height: 100vh;
                z-index: 1000;
                transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -4px 0 24px rgba(0,0,0,0.15);
            }
            .lj-jobs-preview.open { right: 0; }
            .lj-preview-mobile-header { display: flex; }
            .lj-preview-empty { display: none !important; } 
            
            .lj-jobs-list-header { 
                flex-direction: column; align-items: flex-start; gap: 16px; 
                margin: -16px -16px 16px -16px; padding: 20px 16px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            .lj-jobs-header-actions { width: 100%; justify-content: space-between; }
        }
    </style>
@endpush

@section('content')

    {{-- Backdrop Overlay for Drawers/Modals --}}
    <div class="lj-backdrop" id="ljBackdrop" onclick="closeAllDrawers()"></div>

    {{-- ── TOP SEARCH BAR ── --}}
    <div class="lj-jobs-searchbar">
        <form method="GET" action="{{ route('jobs.index') }}" id="searchForm">
            <div class="lj-jobs-searchbar-inner">
                <div class="lj-sb-field" style="max-width:320px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="title" placeholder="Job title, skill or keyword"
                        value="{{ request('title') }}" />
                </div>
                <div class="lj-sb-field" style="max-width:220px;">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <select name="skill" class="lj-sb-field-sel">
                        <option value="">All Skills</option>
                        @php $skills = ['PHP Developer','Java Developer','Python Developer','React Developer','Node.js Developer','MySQL / Database','WordPress Developer','UI/UX Designer','Electrician','Plumber','Welder','Machine Operator','CNC Operator','Sales Executive','Marketing Executive','Field Sales','Data Entry','HR Executive','Accountant','Driver','Delivery Executive']; @endphp
                        @foreach ($skills as $s)
                            <option value="{{ $s }}" {{ request('skill') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lj-sb-field" style="max-width:220px;">
                    <i class="fa-solid fa-location-dot"></i>
                    <select name="location" class="lj-sb-field-sel">
                        <option value="">All Locations</option>
                        @php $districts = ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                        @foreach ($districts as $d)
                            <option value="{{ $d }}" {{ request('location') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="lj-sb-btn"><i class="fa-solid fa-magnifying-glass"></i> Find Jobs</button>
                <button type="button" class="lj-sb-reset" onclick="resetSearch()"><i class="fa-solid fa-rotate-left"></i> Reset</button>
            </div>
        </form>
    </div>

    {{-- ── 3-COLUMN LAYOUT ── --}}
    <div class="lj-jobs-page">
        <div class="lj-jobs-layout">

            {{-- ── LEFT: FILTERS SIDEBAR (Drawer on Mobile/Tab) ── --}}
            <aside class="lj-jobs-sidebar" id="ljFiltersSidebar">
                <div class="lj-sidebar-mobile-header">
                    <h3>Filters</h3>
                    <button class="lj-sidebar-close" onclick="closeFilters()"><i class="fa-solid fa-xmark"></i></button>
                </div>
                
                <div class="lj-sidebar-title"><i class="fa-solid fa-sliders"></i> Job Filters</div>

                <div class="lj-filter-group">
                    <label class="lj-filter-label">Experience Level</label>
                    <div class="lj-filter-chips filter-chip-experience">
                        @foreach (['Any', 'Fresher', '1-2 Years', '3-5 Years', '5+ Years'] as $exp)
                            <div class="lj-filter-chip {{ request('experience') == $exp ? 'active' : '' }}"
                                onclick="setFilter('experience','{{ $exp }}',this)">{{ $exp }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="lj-sidebar-divider"></div>

                <div class="lj-filter-group">
                    <label class="lj-filter-label">Salary Range</label>
                    <select class="lj-filter-select" name="salary" form="searchForm"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="">Any Salary</option>
                        <option value="0-15000" {{ request('salary') == '0-15000' ? 'selected' : '' }}>Up to ₹15,000/mo</option>
                        <option value="15000-25000" {{ request('salary') == '15000-25000' ? 'selected' : '' }}>₹15,000 – ₹25,000/mo</option>
                        <option value="25000-50000" {{ request('salary') == '25000-50000' ? 'selected' : '' }}>₹25,000 – ₹50,000/mo</option>
                        <option value="50000+" {{ request('salary') == '50000+' ? 'selected' : '' }}>₹50,000+/mo</option>
                    </select>
                </div>

                <div class="lj-sidebar-divider"></div>

                <div class="lj-filter-group">
                    <label class="lj-filter-label">Job Type</label>
                    <div class="lj-filter-chips">
                        @foreach (['Full-time', 'Part-time', 'Contract', 'Internship', 'Remote'] as $type)
                            <div class="lj-filter-chip {{ request('job_type') == $type ? 'active' : '' }}"
                                onclick="setFilter('job_type','{{ $type }}',this)">{{ $type }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="lj-sidebar-divider"></div>

                <div class="lj-filter-group">
                    <label class="lj-filter-label">Category</label>
                    <select class="lj-filter-select" name="category" form="searchForm"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="">All Categories</option>
                        <option value="IT & Software" {{ request('category') == 'IT & Software' ? 'selected' : '' }}>IT & Software</option>
                        <option value="Technical & Trade" {{ request('category') == 'Technical & Trade' ? 'selected' : '' }}>Technical & Trade</option>
                        <option value="Sales & Marketing" {{ request('category') == 'Sales & Marketing' ? 'selected' : '' }}>Sales & Marketing</option>
                        <option value="Office & Admin" {{ request('category') == 'Office & Admin' ? 'selected' : '' }}>Office & Admin</option>
                        <option value="Driver & Logistics" {{ request('category') == 'Driver & Logistics' ? 'selected' : '' }}>Driver & Logistics</option>
                    </select>
                </div>

                <div class="lj-sidebar-divider"></div>

                <div class="lj-filter-group">
                    <label class="lj-filter-label">Posted Within</label>
                    <div class="lj-filter-chips">
                        @foreach (['Any', 'Today', '3 Days', '7 Days', '30 Days'] as $posted)
                            <div class="lj-filter-chip {{ request('posted') == $posted ? 'active' : '' }}"
                                onclick="setFilter('posted','{{ $posted }}',this)">{{ $posted }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="lj-sidebar-divider"></div>
                <button class="lj-filter-apply-btn" onclick="document.getElementById('searchForm').submit()">
                    <i class="fa-solid fa-check"></i> Apply Filters
                </button>
                <button class="lj-filter-reset-btn" onclick="resetSearch()">
                    Reset All Filters
                </button>
            </aside>

            {{-- ── MIDDLE: JOB LIST ── --}}
            <div class="lj-jobs-list" id="jobsList">
                <div class="lj-jobs-list-header">
                    <div class="lj-jobs-count">Showing <strong>{{ $jobs->total() ?? count($jobs) }}</strong> jobs
                        {{ request('title') ? 'for "' . request('title') . '"' : 'in Tamil Nadu' }}</div>
                    
                    <div class="lj-jobs-header-actions">
                        <div class="lj-jobs-sort">
                            Sort by:
                            <select class="lj-sort-select" onchange="document.getElementById('searchForm').submit()" name="sort">
                                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                                <option value="relevant" {{ request('sort') == 'relevant' ? 'selected' : '' }}>Most Relevant</option>
                                <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary: High to Low</option>
                                <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary: Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>

                @forelse($jobs as $job)
                    <div class="lj-job-card {{ $loop->first ? 'active' : '' }}"
                        onclick="loadPreview({{ $job->id }}, this)" id="job-card-{{ $job->id }}">
                        <div class="lj-job-card-top">
                            <div style="flex:1;">
                                @if ($job->is_urgent ?? false)
                                    <span class="lj-job-badge urgent">Urgently Hiring</span>
                                @elseif($job->created_at->diffInDays() <= 1)
                                    <span class="lj-job-badge new">New</span>
                                @elseif(($job->openings ?? 0) > 1)
                                    <span class="lj-job-badge hiring">Multiple Openings</span>
                                @endif
                                <div class="lj-job-card-title">{{ $job->title }}</div>
                                <div class="lj-job-card-company">
                                    <i class="fa-solid fa-building"></i>
                                    {{ $job->company->name ?? $job->company_name }}
                                    @if ($job->company->is_verified ?? false)
                                        <i class="fa-solid fa-circle-check" style="color:var(--blue);"></i>
                                    @endif
                                </div>
                                <div class="lj-job-card-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $job->city }}, {{ $job->district }}, Tamil Nadu
                                </div>
                            </div>
                            <div class="lj-job-logo">
                                @if ($job->company->logo ?? false)
                                    <img src="{{ asset('storage/' . $job->company->logo) }}" alt="{{ $job->company->name }}">
                                @else
                                    <i class="fa-solid fa-building"></i>
                                @endif
                            </div>
                        </div>
                        <div class="lj-job-tags">
                            @if ($job->salary_min)
                                <span class="lj-job-tag salary"><i class="fa-solid fa-indian-rupee-sign"></i>
                                    {{ number_format($job->salary_min / 1000, 0) }}k – {{ number_format($job->salary_max / 1000, 0) }}k/mo</span>
                            @endif
                            @if ($job->job_type)
                                <span class="lj-job-tag type">{{ $job->job_type }}</span>
                            @endif
                            @if ($job->experience)
                                <span class="lj-job-tag"><i class="fa-solid fa-briefcase"></i> {{ $job->experience }}</span>
                            @endif
                            <span class="lj-job-tag openings"><i class="fa-solid fa-users"></i> {{ $job->openings ?? 5 }} Openings</span>
                        </div>
                        <div class="lj-job-card-footer">
                            <span class="lj-job-date">{{ $job->created_at->diffForHumans() }}</span>
                            <button class="lj-job-save" onclick="event.stopPropagation();toggleSave(this)" data-jobid="{{ $job->id }}" title="Save job">
                                <i class="fa-regular fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="lj-no-jobs">
                        <i class="fa-solid fa-magnifying-glass-location"></i>
                        <strong style="font-size:1.2rem;color:var(--n900);">No jobs found</strong>
                        <p style="font-size:1rem;">Try adjusting your search filters or keywords to find what you're looking for.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if (isset($jobs) && method_exists($jobs, 'hasPages') && $jobs->hasPages())
                    <div class="lj-pagination">
                        @if ($jobs->onFirstPage())
                            <button class="lj-page-btn nav" disabled><i class="fa-solid fa-chevron-left"></i> Prev</button>
                        @else
                            <a href="{{ $jobs->previousPageUrl() }}" class="lj-page-btn nav"><i class="fa-solid fa-chevron-left"></i> Prev</a>
                        @endif

                        @foreach ($jobs->getUrlRange(max(1, $jobs->currentPage() - 2), min($jobs->lastPage(), $jobs->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" class="lj-page-btn {{ $page == $jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if ($jobs->hasMorePages())
                            <a href="{{ $jobs->nextPageUrl() }}" class="lj-page-btn nav">Next <i class="fa-solid fa-chevron-right"></i></a>
                        @else
                            <button class="lj-page-btn nav" disabled>Next <i class="fa-solid fa-chevron-right"></i></button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ── RIGHT: JOB PREVIEW PANEL (Slide Modal on Mobile) ── --}}
            <div class="lj-jobs-preview" id="jobPreview">
                <div class="lj-preview-mobile-header">
                    <button class="lj-preview-back-btn" onclick="closePreview()"><i class="fa-solid fa-arrow-left"></i> Back to Jobs</button>
                </div>

                <div class="lj-preview-empty" id="previewEmpty">
                    <i class="fa-solid fa-file-lines"></i>
                    <p>Select a job to see full details here</p>
                </div>

                <div id="previewContent" style="display:none;">
                    {{-- Preview Header --}}
                    <div class="lj-preview-header">
                        <div class="lj-preview-badge-row" id="prevBadges"></div>
                        <div class="lj-preview-title" id="prevTitle"></div>
                        <div class="lj-preview-company" id="prevCompany"></div>
                        <div class="lj-preview-location" id="prevLocation"></div>
                        <div class="lj-preview-actions">
                            <a href="#" class="lj-apply-btn" id="prevApplyBtn">
                                <i class="fa-solid fa-paper-plane"></i> Apply Now
                            </a>
                            <button class="lj-save-btn" onclick="toggleSavePreview(this)">
                                <i class="fa-regular fa-bookmark"></i> Save
                            </button>
                            <a href="#" class="lj-save-btn" id="prevDetailsLink" target="_blank" title="Open in new tab">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Preview Body --}}
                    <div class="lj-preview-body">
                        <div class="lj-preview-meta" id="prevMeta"></div>

                        <div class="lj-preview-section">
                            <div class="lj-preview-section-title">Job Description</div>
                            <div class="lj-preview-desc" id="prevDesc"></div>
                        </div>

                        <div class="lj-preview-section" id="secResponsibilities">
                            <div class="lj-preview-section-title">Responsibilities</div>
                            <ul class="lj-preview-list" id="prevResponsibilities"></ul>
                        </div>

                        <div class="lj-preview-section" id="secSkills">
                            <div class="lj-preview-section-title">Required Skills</div>
                            <div class="lj-skill-tags" id="prevSkills"></div>
                        </div>

                        <div class="lj-preview-section" id="secEducation">
                            <div class="lj-preview-section-title">Education</div>
                            <div class="lj-preview-desc" id="prevEducation"></div>
                        </div>

                        <div class="lj-preview-section" id="secBenefits">
                            <div class="lj-preview-section-title">Benefits</div>
                            <div class="lj-benefit-tags" id="prevBenefits"></div>
                        </div>
                    </div>

                    {{-- Sticky Apply at bottom --}}
                    <div class="lj-preview-apply-bar">
                        <a href="#" class="lj-apply-btn" id="prevApplyBtnBottom" style="width:100%;justify-content:center;">
                            <i class="fa-solid fa-paper-plane"></i> Apply Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    {{-- Floating Mobile Filter Button --}}
    <button class="lj-mobile-fab" onclick="openFilters()">
        <i class="fa-solid fa-sliders"></i> Filters & Search
    </button>
    
@endsection

@push('scripts')
    <script>
        // ── MOBILE DRAWER/MODAL LOGIC ─────────────────────────
        const backdrop = document.getElementById('ljBackdrop');
        const filtersSidebar = document.getElementById('ljFiltersSidebar');
        const jobPreview = document.getElementById('jobPreview');

        function openFilters() {
            filtersSidebar.classList.add('open');
            backdrop.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }

        function closeFilters() {
            filtersSidebar.classList.remove('open');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        }

        function openPreviewMobile() {
            if(window.innerWidth <= 850) {
                jobPreview.classList.add('open');
                backdrop.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePreview() {
            jobPreview.classList.remove('open');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        }

        function closeAllDrawers() {
            closeFilters();
            closePreview();
        }

        // ── LOAD SAVED JOBS ──────────────────────────────────
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('jobseeker.jobs.getSaved') }}",
                type: "GET",
                success: function(response) {
                    if(response.savedJobs) {
                        response.savedJobs.forEach(jobId => {
                            const btn = document.querySelector(`button[data-jobid='${jobId}']`);
                            if (btn) {
                                const ico = btn.querySelector('i');
                                ico.classList.replace('fa-regular', 'fa-solid');
                                btn.style.color = 'var(--blue)';
                                btn.style.background = 'rgba(26, 86, 219, .1)';
                            }
                        });
                    }
                },
                error: function() { console.log('Failed to load saved jobs'); }
            });
        });

        // ── FILTER CHIPS LOGIC ───────────────────────────────
        function setFilter(name, value, el) {
            el.parentElement.querySelectorAll('.lj-filter-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');

            const form = document.getElementById('searchForm');
            let input = form.querySelector(`input[name="${name}"]`);

            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                form.appendChild(input);
            }

            input.value = (value === 'Any') ? '' : value;
            form.submit();
        }

        function resetSearch() {
            window.location.href = '{{ route('jobs.index') }}';
        }

        // ── SAVE TOGGLE LOGIC ────────────────────────────────
        function toggleSave(btn) {
            const ico = btn.querySelector('i');
            const jobId = btn.getAttribute('data-jobid');
            
            // Note: you can integrate AJAX toggle here too, mimicking toggleSavePreview logic
            if (ico.classList.contains('fa-regular')) {
                ico.classList.replace('fa-regular', 'fa-solid');
                btn.style.color = 'var(--blue)';
                btn.style.background = 'rgba(26, 86, 219, .1)';
            } else {
                ico.classList.replace('fa-solid', 'fa-regular');
                btn.style.color = '';
                btn.style.background = '';
            }
        }

        function toggleSavePreview(btn) {
            const jobId = document.querySelector('.lj-job-card.active')?.id?.replace('job-card-', '');
            if (!jobId) return;

            const ico = btn.querySelector('i');

            $.ajax({
                url: "{{ route('jobseeker.jobs.toggleSave') }}",
                type: "POST",
                data: { _token: "{{ csrf_token() }}", job_id: jobId },
                success: function(response) {
                    if (response.savestatus == 1) {
                        ico.classList.replace('fa-regular', 'fa-solid');
                        btn.style.borderColor = 'var(--blue)';
                        btn.style.color = 'var(--blue)';
                    } else {
                        ico.classList.replace('fa-solid', 'fa-regular');
                        btn.style.borderColor = '';
                        btn.style.color = '';
                    }
                }
            });
        }

        // ── LOAD JOB PREVIEW ─────────────────────────────────
        function loadPreview(jobId, cardEl) {
            $('.lj-job-card').removeClass('active');
            $(cardEl).addClass('active');

            const previewEmpty = $('#previewEmpty');
            const previewContent = $('#previewContent');

            previewEmpty.hide();
            previewContent.show();
            $('#prevTitle').text('Loading...');
            
            // Open panel on mobile
            openPreviewMobile();

            $.ajax({
                url: "{{ url('/jobs-preview') }}/" + jobId,
                type: 'GET',
                success: function(job) {
                    renderPreview(job);
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('#prevTitle').text('Failed to load job');
                }
            });
        }

        function renderPreview(job) {
            // Badges
            const badges = document.getElementById('prevBadges');
            badges.innerHTML = '';
            const badgeHTML = [];
            if (job.is_urgent) badgeHTML.push('<span class="lj-job-badge urgent">Urgently Hiring</span>');
            if (job.is_new) badgeHTML.push('<span class="lj-job-badge new">New</span>');
            badges.innerHTML = badgeHTML.join('');

            // Headings
            document.getElementById('prevTitle').textContent = job.title;
            document.getElementById('prevCompany').innerHTML = `<i class="fa-solid fa-building"></i> ${job.company_name}`;
            document.getElementById('prevLocation').innerHTML = `<i class="fa-solid fa-location-dot"></i> ${job.city}, ${job.district}, Tamil Nadu`;

            // Links
            const applyUrl = "{{ route('jobs.apply', ':id') }}".replace(':id', job.id);
            const detailUrl = "{{ url('/jobs/:id') }}".replace(':id', job.id);
            document.getElementById('prevApplyBtn').href = applyUrl;
            document.getElementById('prevApplyBtnBottom').href = applyUrl;
            document.getElementById('prevDetailsLink').href = detailUrl;

            // Meta Details
            const meta = document.getElementById('prevMeta');
            meta.innerHTML = `
                <div class="lj-meta-item"><div class="lj-meta-label">Salary</div><div class="lj-meta-value"><i class="fa-solid fa-indian-rupee-sign"></i>${
                    (job.salary_min && job.salary_max) 
                    ? `₹${Math.round(job.salary_min / 1000)}k - ₹${Math.round(job.salary_max / 1000)}k/mo` 
                    : 'Not disclosed'
                }</div></div>
                <div class="lj-meta-item"><div class="lj-meta-label">Job Type</div><div class="lj-meta-value"><i class="fa-solid fa-clock"></i>${job.job_type || '—'}</div></div>
                <div class="lj-meta-item"><div class="lj-meta-label">Experience</div><div class="lj-meta-value"><i class="fa-solid fa-briefcase"></i>${job.experience || '—'}</div></div>
                <div class="lj-meta-item"><div class="lj-meta-label">Education</div><div class="lj-meta-value"><i class="fa-solid fa-graduation-cap"></i>${job.education || '—'}</div></div>
            `;

            // Descriptions and arrays (hide sections if empty)
            document.getElementById('prevDesc').innerHTML = job.description || '—';

            const respList = document.getElementById('prevResponsibilities');
            respList.innerHTML = '';
            if(job.responsibilities && job.responsibilities.length > 0) {
                job.responsibilities.forEach(r => {
                    const li = document.createElement('li');
                    li.textContent = r;
                    respList.appendChild(li);
                });
                document.getElementById('secResponsibilities').style.display = 'block';
            } else {
                document.getElementById('secResponsibilities').style.display = 'none';
            }

            const skillsEl = document.getElementById('prevSkills');
            if(job.skills && job.skills.length > 0) {
                skillsEl.innerHTML = job.skills.map(s => `<span class="lj-skill-tag">${s}</span>`).join('');
                document.getElementById('secSkills').style.display = 'block';
            } else {
                document.getElementById('secSkills').style.display = 'none';
            }

            if(job.education) {
                document.getElementById('prevEducation').textContent = job.education;
                document.getElementById('secEducation').style.display = 'block';
            } else {
                document.getElementById('secEducation').style.display = 'none';
            }

            const benefitsEl = document.getElementById('prevBenefits');
            if(job.benefits && job.benefits.length > 0) {
                benefitsEl.innerHTML = job.benefits.map(b => `<span class="lj-benefit-tag"><i class="fa-solid fa-check"></i>${b}</span>`).join('');
                document.getElementById('secBenefits').style.display = 'block';
            } else {
                document.getElementById('secBenefits').style.display = 'none';
            }

            // Scroll to top of preview
            document.getElementById('jobPreview').scrollTop = 0;
        }

        // Auto-load first job ONLY on desktop/tablet, avoid popping up modal on mobile startup
        document.addEventListener('DOMContentLoaded', function() {
            const firstCard = document.querySelector('.lj-job-card');
            if (firstCard && window.innerWidth > 850) {
                const jobId = firstCard.id.replace('job-card-', '');
                loadPreview(parseInt(jobId), firstCard);
            }
        });
    </script>
@endpush