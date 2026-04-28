{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/jobs/find-jobs.blade.php
     Find Jobs – LinearJobs (Indeed-style layout)
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Find Jobs in Tamil Nadu – LinearJobs')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ── RESET & BASE ─────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /* ── TOP SEARCH BAR ───────────────────────────────── */
        .lj-jobs-searchbar {
            background: #fff;
            border-bottom: 1.5px solid var(--n200);
            padding: 14px 24px;
            position: sticky;
            top: 64px;
            z-index: 100;
        }
        .lj-job-tag.openings {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    font-weight: 600;
}

        .lj-jobs-searchbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .lj-sb-field {
            position: relative;
            flex: 1;
        }

        .lj-sb-field i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: .85rem;
            pointer-events: none;
        }

        .lj-sb-field input,
        .lj-sb-field select {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: 8px;
            padding: 10px 14px 10px 38px;
            font-family: var(--f);
            font-size: .875rem;
            color: var(--n900);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .lj-sb-field input:focus,
        .lj-sb-field select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .lj-sb-field input::placeholder {
            color: var(--n400);
        }

        select.lj-sb-field-sel {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23a09e9b'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
            cursor: pointer;
        }

        .lj-sb-btn {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-family: var(--f);
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: background .2s, transform .15s;
        }

        .lj-sb-btn:hover {
            background: var(--blue-h);
            transform: translateY(-1px);
        }

        .lj-sb-reset {
            background: #fff;
            color: var(--n600);
            border: 1.5px solid var(--n200);
            border-radius: 8px;
            padding: 10px 16px;
            font-family: var(--f);
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: border-color .2s, color .2s;
        }

        .lj-sb-reset:hover {
            border-color: var(--n400);
            color: var(--n800);
        }

        /* ── 3-COLUMN LAYOUT ──────────────────────────────── */
        .lj-jobs-page {
            background: var(--n50);
            min-height: calc(100vh - 64px);
        }

        .lj-jobs-layout {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 260px 1fr 500px;
            gap: 0;
            /* min-height: calc(100vh - 130px); */
            min-height: calc(100vh - 60px);

        }

        /* ── LEFT SIDEBAR ─────────────────────────────────── */
        .lj-jobs-sidebar {
            background: #fff;
            border-right: 1.5px solid var(--n200);
            padding: 20px 18px;
            position: sticky;
            top: 130px;
            height: calc(100vh - 130px);
            overflow-y: auto;
        }

        .lj-sidebar-title {
            font-size: .72rem;
            font-weight: 800;
            color: var(--n400);
            letter-spacing: .09em;
            text-transform: uppercase;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-sidebar-title i {
            color: var(--blue);
            font-size: .75rem;
        }

        .lj-filter-group {
            margin-bottom: 22px;
        }

        .lj-filter-label {
            font-size: .78rem;
            font-weight: 700;
            color: var(--n700);
            margin-bottom: 8px;
            display: block;
        }

        .lj-filter-input {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: 7px;
            padding: 8px 12px;
            font-family: var(--f);
            font-size: .82rem;
            color: var(--n900);
            outline: none;
            transition: border-color .2s;
        }

        .lj-filter-input:focus {
            border-color: var(--blue);
        }

        .lj-filter-select {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: 7px;
            padding: 8px 30px 8px 10px;
            font-family: var(--f);
            font-size: .82rem;
            color: var(--n700);
            background: #fff;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23a09e9b'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .lj-filter-select:focus {
            border-color: var(--blue);
        }

        .lj-filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .lj-filter-chip {
            border: 1.5px solid var(--n200);
            border-radius: 100px;
            padding: 4px 12px;
            font-size: .75rem;
            font-weight: 600;
            color: var(--n600);
            cursor: pointer;
            transition: all .2s;
        }

        .lj-filter-chip:hover,
        .lj-filter-chip.active {
            background: rgba(26, 86, 219, .07);
            border-color: var(--blue);
            color: var(--blue);
        }

        .lj-sidebar-divider {
            height: 1px;
            background: var(--n100);
            margin: 16px 0;
        }

        .lj-filter-apply-btn {
            width: 100%;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 7px;
            padding: 9px;
            font-family: var(--f);
            font-size: .84rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 8px;
            transition: background .2s;
        }

        .lj-filter-apply-btn:hover {
            background: var(--blue-h);
        }

        .lj-filter-reset-btn {
            width: 100%;
            background: #fff;
            color: var(--n600);
            border: 1.5px solid var(--n200);
            border-radius: 7px;
            padding: 8px;
            font-family: var(--f);
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: all .2s;
        }

        .lj-filter-reset-btn:hover {
            border-color: var(--n400);
        }

        /* ── JOB LIST (MIDDLE) ────────────────────────────── */
        .lj-jobs-list {
            border-right: 1.5px solid var(--n200);
            overflow-y: auto;
            height: calc(100vh - 130px);
        }

        .lj-jobs-list-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--n100);
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lj-jobs-count {
            font-size: .82rem;
            color: var(--n500);
            font-weight: 500;
        }

        .lj-jobs-count strong {
            color: var(--n800);
            font-weight: 700;
        }

        .lj-jobs-sort {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .78rem;
            color: var(--n500);
        }

        .lj-sort-select {
            border: 1.5px solid var(--n200);
            border-radius: 6px;
            padding: 5px 26px 5px 8px;
            font-size: .78rem;
            color: var(--n700);
            background: #fff;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5'%3E%3Cpath d='M0 0l4.5 5 4.5-5z' fill='%23a09e9b'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            cursor: pointer;
            outline: none;
        }

        /* ── JOB CARD ─────────────────────────────────────── */
        .lj-job-card {
            padding: 16px 18px;
            border-bottom: 1px solid var(--n100);
            cursor: pointer;
            transition: background .15s;
            position: relative;
            background: #fff;
        }

        .lj-job-card:hover {
            background: #f8faff;
        }

        .lj-job-card.active {
            background: #eef3ff;
            border-left: 3px solid var(--blue);
        }

        .lj-job-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
        }

        .lj-job-badge {
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 5px;
        }

        .lj-job-badge.urgent {
            background: #fef3c7;
            color: #b45309;
        }

        .lj-job-badge.new {
            background: #dcfce7;
            color: #166534;
        }

        .lj-job-badge.hiring {
            background: #ede9fe;
            color: #6d28d9;
        }

        .lj-job-card-title {
            font-size: .9375rem;
            font-weight: 700;
            color: var(--n900);
            margin-bottom: 2px;
            line-height: 1.3;
        }

        .lj-job-card-title:hover {
            color: var(--blue);
        }

        .lj-job-card-company {
            font-size: .82rem;
            color: var(--n600);
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lj-job-card-company i {
            font-size: .7rem;
            color: var(--n400);
        }

        .lj-job-card-location {
            font-size: .8rem;
            color: var(--n500);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lj-job-card-location i {
            font-size: .7rem;
            color: var(--n400);
        }

        .lj-job-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }

        .lj-job-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .72rem;
            font-weight: 600;
            color: var(--n600);
            background: var(--n50);
            border: 1px solid var(--n100);
            border-radius: 4px;
            padding: 2px 8px;
        }

        .lj-job-tag i {
            font-size: .65rem;
            color: var(--green);
        }

        .lj-job-tag.salary {
            color: #047857;
            background: #f0fdf4;
            border-color: #bbf7d0;
        }

        .lj-job-tag.type {
            color: #1e40af;
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .lj-job-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lj-job-date {
            font-size: .72rem;
            color: var(--n400);
        }

        .lj-job-save {
            background: none;
            border: none;
            color: var(--n400);
            cursor: pointer;
            font-size: .85rem;
            padding: 4px 6px;
            border-radius: 6px;
            transition: color .2s, background .2s;
        }

        .lj-job-save:hover {
            color: var(--blue);
            background: rgba(26, 86, 219, .07);
        }

        .lj-job-logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--n100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--n500);
            flex-shrink: 0;
            border: 1px solid var(--n200);
            overflow: hidden;
        }

        .lj-job-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── PAGINATION ───────────────────────────────────── */
        .lj-pagination {
            padding: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-top: 1px solid var(--n100);
            background: #fff;
        }

        .lj-page-btn {
            width: 34px;
            height: 34px;
            border-radius: 7px;
            border: 1.5px solid var(--n200);
            background: #fff;
            font-family: var(--f);
            font-size: .82rem;
            font-weight: 600;
            color: var(--n600);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .lj-page-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .lj-page-btn.active {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .lj-page-btn.nav {
            padding: 0 10px;
            width: auto;
            gap: 5px;
            font-size: .78rem;
        }

        /* ── RIGHT PANEL (Job Preview) ────────────────────── */
        .lj-jobs-preview {
            background: #fff;
            overflow-y: auto;
            height: calc(100vh - 130px);
            position: sticky;
            top: 130px;
        }

        .lj-preview-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            gap: 14px;
            color: var(--n400);
            text-align: center;
            padding: 40px;
        }

        .lj-preview-empty i {
            font-size: 2.5rem;
            opacity: .3;
        }

        .lj-preview-empty p {
            font-size: .875rem;
            line-height: 1.6;
        }

        .lj-preview-header {
            padding: 22px 24px 18px;
            border-bottom: 1.5px solid var(--n100);
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 5;
        }

        .lj-preview-badge-row {
            display: flex;
            gap: 6px;
            margin-bottom: 10px;
        }

        .lj-preview-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--n900);
            line-height: 1.3;
            margin-bottom: 5px;
            letter-spacing: -.3px;
        }

        .lj-preview-company {
            font-size: .875rem;
            color: var(--n700);
            font-weight: 600;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lj-preview-company i {
            font-size: .72rem;
            color: var(--n400);
        }

        .lj-preview-location {
            font-size: .82rem;
            color: var(--n500);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lj-preview-location i {
            font-size: .72rem;
        }

        .lj-preview-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .lj-apply-btn {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: var(--f);
            font-size: .9rem;
            font-weight: 700;
            padding: 10px 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            text-decoration: none;
        }

        .lj-apply-btn:hover {
            background: var(--blue-h);
            transform: translateY(-1px);
        }

        .lj-save-btn {
            background: #fff;
            color: var(--n600);
            border: 1.5px solid var(--n200);
            border-radius: 8px;
            font-family: var(--f);
            font-size: .875rem;
            font-weight: 600;
            padding: 10px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all .2s;
        }

        .lj-save-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .lj-preview-body {
            padding: 22px 24px;
        }

        .lj-preview-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 22px;
            background: var(--n50);
            border: 1.5px solid var(--n100);
            border-radius: 10px;
            padding: 14px 16px;
        }

        .lj-meta-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .lj-meta-label {
            font-size: .68rem;
            font-weight: 700;
            color: var(--n400);
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .lj-meta-value {
            font-size: .84rem;
            font-weight: 700;
            color: var(--n800);
        }

        .lj-meta-value i {
            color: var(--blue);
            margin-right: 4px;
            font-size: .72rem;
        }

        .lj-preview-section {
            margin-bottom: 22px;
        }

        .lj-preview-section-title {
            font-size: .78rem;
            font-weight: 800;
            color: var(--n500);
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .lj-preview-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--n100);
        }

        .lj-preview-desc {
            font-size: .875rem;
            color: var(--n700);
            line-height: 1.7;
        }

        .lj-preview-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .lj-preview-list li {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: .875rem;
            color: var(--n700);
            line-height: 1.5;
        }

        .lj-preview-list li::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--blue);
            flex-shrink: 0;
            margin-top: 7px;
        }

        .lj-skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .lj-skill-tag {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid var(--n200);
            border-radius: 100px;
            padding: 4px 13px;
            font-size: .78rem;
            font-weight: 600;
            color: var(--n700);
            background: #fff;
        }

        .lj-benefit-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .lj-benefit-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: 100px;
            padding: 4px 13px;
            font-size: .78rem;
            font-weight: 600;
            color: #166534;
        }

        .lj-benefit-tag i {
            font-size: .7rem;
        }

        .lj-preview-apply-bar {
            padding: 16px 24px;
            border-top: 1.5px solid var(--n100);
            background: #fff;
            position: sticky;
            bottom: 0;
        }

        /* ── ACTIVE JOB HIGHLIGHT ─────────────────────────── */
        .lj-no-jobs {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            gap: 12px;
            color: var(--n400);
            text-align: center;
        }

        .lj-no-jobs i {
            font-size: 2rem;
            opacity: .3;
        }

        /* ── SCROLLBAR ────────────────────────────────────── */
        .lj-jobs-list::-webkit-scrollbar,
        .lj-jobs-preview::-webkit-scrollbar,
        .lj-jobs-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .lj-jobs-list::-webkit-scrollbar-track,
        .lj-jobs-preview::-webkit-scrollbar-track,
        .lj-jobs-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .lj-jobs-list::-webkit-scrollbar-thumb,
        .lj-jobs-preview::-webkit-scrollbar-thumb,
        .lj-jobs-sidebar::-webkit-scrollbar-thumb {
            background: var(--n200);
            border-radius: 4px;
        }

        /* ── RESPONSIVE ───────────────────────────────────── */
        @media(max-width:1100px) {
            .lj-jobs-layout {
                grid-template-columns: 220px 1fr;
            }

            .lj-jobs-preview {
                display: none;
            }
        }

        @media(max-width:760px) {
            .lj-jobs-layout {
                grid-template-columns: 1fr;
            }

            .lj-jobs-sidebar {
                display: none;
            }

            .lj-jobs-preview {
                display: none;
            }

            .lj-jobs-list {
                height: auto;
                border-right: none;
            }

            .lj-jobs-searchbar {
                padding: 10px 14px;
            }

            .lj-jobs-searchbar-inner {
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── TOP SEARCH BAR ── --}}
    <div class="lj-jobs-searchbar">
        <form method="GET" action="{{ route('jobs.index') }}" id="searchForm">
            <div class="lj-jobs-searchbar-inner">
                <div class="lj-sb-field" style="max-width:280px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="title" placeholder="Job title, skill or keyword"
                        value="{{ request('title') }}" />
                </div>
                <div class="lj-sb-field" style="max-width:200px;">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <select name="skill" class="lj-sb-field-sel">
                        <option value="">All Skills</option>
                        @php $skills = ['PHP Developer','Java Developer','Python Developer','React Developer','Node.js Developer','MySQL / Database','WordPress Developer','UI/UX Designer','Electrician','Plumber','Welder','Machine Operator','CNC Operator','Sales Executive','Marketing Executive','Field Sales','Data Entry','HR Executive','Accountant','Driver','Delivery Executive']; @endphp
                        @foreach ($skills as $s)
                            <option value="{{ $s }}" {{ request('skill') == $s ? 'selected' : '' }}>
                                {{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lj-sb-field" style="max-width:200px;">
                    <i class="fa-solid fa-location-dot"></i>
                    <select name="location" class="lj-sb-field-sel">
                        <option value="">All Locations</option>
                        @php $districts = ['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                        @foreach ($districts as $d)
                            <option value="{{ $d }}" {{ request('location') == $d ? 'selected' : '' }}>
                                {{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="lj-sb-btn"><i class="fa-solid fa-magnifying-glass"></i> Find Jobs</button>
                <button type="button" class="lj-sb-reset" onclick="resetSearch()"><i class="fa-solid fa-rotate-left"></i>
                    Reset</button>
            </div>
        </form>
    </div>

    {{-- ── 3-COLUMN LAYOUT ── --}}
    <div class="lj-jobs-page">
        <div class="lj-jobs-layout">

            {{-- ── LEFT: FILTERS SIDEBAR ── --}}
            <aside class="lj-jobs-sidebar">
                <div class="lj-sidebar-title"><i class="fa-solid fa-sliders"></i> Filters</div>

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
                        <option value="0-15000" {{ request('salary') == '0-15000' ? 'selected' : '' }}>Up to ₹15,000/mo
                        </option>
                        <option value="15000-25000" {{ request('salary') == '15000-25000' ? 'selected' : '' }}>₹15,000 –
                            ₹25,000/mo</option>
                        <option value="25000-50000" {{ request('salary') == '25000-50000' ? 'selected' : '' }}>₹25,000 –
                            ₹50,000/mo</option>
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
                        <option value="IT & Software" {{ request('category') == 'IT & Software' ? 'selected' : '' }}>IT &
                            Software</option>
                        <option value="Technical & Trade"
                            {{ request('category') == 'Technical & Trade' ? 'selected' : '' }}>
                            Technical & Trade</option>
                        <option value="Sales & Marketing"
                            {{ request('category') == 'Sales & Marketing' ? 'selected' : '' }}>
                            Sales & Marketing</option>
                        <option value="Office & Admin" {{ request('category') == 'Office & Admin' ? 'selected' : '' }}>
                            Office
                            & Admin</option>
                        <option value="Driver & Logistics"
                            {{ request('category') == 'Driver & Logistics' ? 'selected' : '' }}>Driver & Logistics</option>
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
                    <div class="lj-jobs-sort">
                        Sort by:
                        <select class="lj-sort-select" onchange="document.getElementById('searchForm').submit()"
                            name="sort">
                            <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent
                            </option>
                            <option value="relevant" {{ request('sort') == 'relevant' ? 'selected' : '' }}>Most Relevant
                            </option>
                            <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Salary:
                                High to Low</option>
                            <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Salary: Low
                                to High</option>
                        </select>
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
                                    <img src="{{ asset('storage/' . $job->company->logo) }}"
                                        alt="{{ $job->company->name }}">
                                @else
                                    <i class="fa-solid fa-building" style="font-size:.85rem;"></i>
                                @endif
                            </div>
                        </div>
                        <div class="lj-job-tags">
                            @if ($job->salary_min)
                                <span class="lj-job-tag salary"><i class="fa-solid fa-check"></i>
                                    ₹{{ number_format($job->salary_min / 1000, 0) }}k –
                                    ₹{{ number_format($job->salary_max / 1000, 0) }}k/mo</span>
                            @endif
                            @if ($job->job_type)
                                <span class="lj-job-tag type">{{ $job->job_type }}</span>
                            @endif
                            @if ($job->experience)
                                <span class="lj-job-tag"><i class="fa-solid fa-check"></i>
                                    {{ $job->experience }}</span>
                            @endif
                            <span class="lj-job-tag openings">
                                <i class="fa-solid fa-users"></i>
                                5 Openings
                            </span>
                            @foreach (array_slice($job->benefits ?? [], 0, 2) as $benefit)
                                <span class="lj-job-tag">{{ $benefit }}</span>
                            @endforeach
                        </div>
                        <div class="lj-job-card-footer">
                            <span class="lj-job-date">{{ $job->created_at->diffForHumans() }}</span>
                            <button class="lj-job-save" onclick="event.stopPropagation();toggleSave(this)"
                                title="Save job">
                                <i class="fa-regular fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="lj-no-jobs">
                        <i class="fa-solid fa-briefcase"></i>
                        <strong style="font-size:.9rem;color:var(--n600);">No jobs found</strong>
                        <p style="font-size:.82rem;">Try adjusting your search filters or keywords.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if (isset($jobs) && method_exists($jobs, 'hasPages') && $jobs->hasPages())
                    <div class="lj-pagination">
                        @if ($jobs->onFirstPage())
                            <button class="lj-page-btn nav" disabled><i class="fa-solid fa-chevron-left"></i>
                                Prev</button>
                        @else
                            <a href="{{ $jobs->previousPageUrl() }}" class="lj-page-btn nav"><i
                                    class="fa-solid fa-chevron-left"></i> Prev</a>
                        @endif

                        @foreach ($jobs->getUrlRange(max(1, $jobs->currentPage() - 2), min($jobs->lastPage(), $jobs->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}"
                                class="lj-page-btn {{ $page == $jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if ($jobs->hasMorePages())
                            <a href="{{ $jobs->nextPageUrl() }}" class="lj-page-btn nav">Next <i
                                    class="fa-solid fa-chevron-right"></i></a>
                        @else
                            <button class="lj-page-btn nav" disabled>Next <i
                                    class="fa-solid fa-chevron-right"></i></button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ── RIGHT: JOB PREVIEW PANEL ── --}}
            <div class="lj-jobs-preview" id="jobPreview">
                <div class="lj-preview-empty" id="previewEmpty">
                    <i class="fa-solid fa-file-lines"></i>
                    <p>Click on a job to see full details here</p>
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
                            <a href="#" class="lj-save-btn" id="prevDetailsLink" target="_blank">
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

                        <div class="lj-preview-section">
                            <div class="lj-preview-section-title">Responsibilities</div>
                            <ul class="lj-preview-list" id="prevResponsibilities"></ul>
                        </div>

                        <div class="lj-preview-section">
                            <div class="lj-preview-section-title">Required Skills</div>
                            <div class="lj-skill-tags" id="prevSkills"></div>
                        </div>

                        <div class="lj-preview-section">
                            <div class="lj-preview-section-title">Education</div>
                            <div class="lj-preview-desc" id="prevEducation"></div>
                        </div>

                        <div class="lj-preview-section">
                            <div class="lj-preview-section-title">Benefits</div>
                            <div class="lj-benefit-tags" id="prevBenefits"></div>
                        </div>
                    </div>

                    {{-- Sticky Apply --}}
                    <div class="lj-preview-apply-bar">
                        <a href="#" class="lj-apply-btn" id="prevApplyBtnBottom"
                            style="width:100%;justify-content:center;">
                            <i class="fa-solid fa-paper-plane"></i> Apply Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('jobseeker.jobs.getSaved') }}", // New route to get saved jobs
                type: "GET",
                success: function(response) {
                    // response should be an array of saved job IDs
                    response.savedJobs.forEach(jobId => {
                        const btn = document.querySelector(`button[data-jobid='${jobId}']`);
                        if (btn) {
                            const ico = btn.querySelector('i');
                            ico.classList.replace('fa-regular', 'fa-solid');
                            btn.style.borderColor = 'var(--blue)';
                            btn.style.color = 'var(--blue)';
                        }
                    });
                },
                error: function() {
                    console.log('Failed to load saved jobs');
                }
            });
        });
        // ── FILTER CHIPS ────────────────────────────────────
        function setFilter(name, value, el) {

            // remove active from SAME group only
            el.parentElement.querySelectorAll('.lj-filter-chip')
                .forEach(c => c.classList.remove('active'));

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

        // ── RESET ────────────────────────────────────────────
        function resetSearch() {
            window.location.href = '{{ route('jobs.index') }}';
        }

        // ── SAVE TOGGLE ──────────────────────────────────────
        function toggleSave(btn) {
            const ico = btn.querySelector('i');
            if (ico.classList.contains('fa-regular')) {
                ico.classList.replace('fa-regular', 'fa-solid');
                btn.style.color = 'var(--blue)';
            } else {
                ico.classList.replace('fa-solid', 'fa-regular');
                btn.style.color = '';
            }
        }

        function toggleSavePreview(btn) {
            const jobId = document.querySelector('.lj-job-card.active')
                ?.id?.replace('job-card-', '');

            if (!jobId) return;

            const ico = btn.querySelector('i');

            $.ajax({
                url: "{{ route('jobseeker.jobs.toggleSave') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    job_id: jobId
                },
                success: function(response) {
                    if (response.savestatus == 1) {
                        ico.classList.replace('fa-regular', 'fa-solid');
                        btn.style.color = 'var(--blue)';
                    } else {
                        ico.classList.replace('fa-solid', 'fa-regular');
                        btn.style.color = '';
                    }
                }
            });
        }

        // ── LOAD PREVIEW ─────────────────────────────────────
        let currentJobId = null;

        function loadPreview(jobId, cardEl) {

            // Active card highlight
            $('.lj-job-card').removeClass('active');
            $(cardEl).addClass('active');

            const previewEmpty = $('#previewEmpty');
            const previewContent = $('#previewContent');

            previewEmpty.hide();
            previewContent.show();
            $('#prevTitle').text('Loading...');

            $.ajax({
                url: "{{ url('/jobs-preview') }}/" + jobId,
                type: 'GET',
                success: function(job) {

                    console.log('Fetched job:', job);

                    renderPreview(job);

                },
                error: function(xhr) {

                    console.error('Error:', xhr);

                    toastr.error('Failed to load job preview');
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

            // Title & company
            document.getElementById('prevTitle').textContent = job.title;
            document.getElementById('prevCompany').innerHTML = `<i class="fa-solid fa-building"></i> ${job.company_name}`;
            document.getElementById('prevLocation').innerHTML =
                `<i class="fa-solid fa-location-dot"></i> ${job.city}, ${job.district}, Tamil Nadu`;

            // Apply & details links (dynamic)
            const applyUrl = "{{ route('jobs.apply', ':id') }}".replace(':id', job.id);
            // const detailUrl = `/jobs/${job.id}`;
            // const detailUrl = "{{ route('jobs.show', ':id') }}".replace(':id', job.id);
            const detailUrl = "{{ url('/jobs/:id') }}".replace(':id', job.id);
            document.getElementById('prevApplyBtn').href = applyUrl;
            document.getElementById('prevApplyBtnBottom').href = applyUrl;
            document.getElementById('prevDetailsLink').href = detailUrl;

            // Meta grid
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

            // Description
            document.getElementById('prevDesc').innerHTML = job.description || '—';

            // Responsibilities
            const respList = document.getElementById('prevResponsibilities');
            respList.innerHTML = '';
            (job.responsibilities || []).forEach(r => {
                const li = document.createElement('li');
                li.textContent = r;
                respList.appendChild(li);
            });

            // Skills
            const skillsEl = document.getElementById('prevSkills');
            skillsEl.innerHTML = (job.skills || []).map(s => `<span class="lj-skill-tag">${s}</span>`).join('');

            // Benefits
            const benefitsEl = document.getElementById('prevBenefits');
            benefitsEl.innerHTML = (job.benefits || []).map(b =>
                `<span class="lj-benefit-tag"><i class="fa-solid fa-check"></i>${b}</span>`).join('');
            document.getElementById('prevEducation').textContent = job.education;

            // Scroll preview to top
            document.getElementById('jobPreview').scrollTop = 0;
        }
        // Auto-load first job on page load
        document.addEventListener('DOMContentLoaded', function() {
            const firstCard = document.querySelector('.lj-job-card');
            if (firstCard) {
                const jobId = firstCard.id.replace('job-card-', '');
                loadPreview(parseInt(jobId), firstCard);
            }
        });
    </script>
@endpush
