{{-- ════════════════════════════════════════════════════════
     resources/views/employer/jobs/show.blade.php
     View Job Details – LinearJobs Employer Dashboard
════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title', ($job->job_title ?? 'Job Details') . ' – View')
@section('page-title', 'Job Details')

@push('styles')
    <style>
        /* ── Base Wrapper ── */
        .js-wrap {
            max-width: 1440px;
            /* Slightly wider for better breathing room */
            margin: 0 auto;
            padding-bottom: 40px;
        }

        /* ── Hero ── */
        .js-hero {
            background: linear-gradient(120deg, #1a56db 0%, #1e3a8a 55%, #312e81 100%);
            border-radius: var(--r-xl, 16px);
            padding: 32px 36px 85px;
            /* Enhanced padding */
            position: relative;
            overflow: hidden;
            margin-bottom: 0;
            box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.3);
            /* Added soft shadow */
        }

        .js-hero::before {
            content: '';
            position: absolute;
            top: -90px;
            right: -90px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            pointer-events: none;
        }

        .js-hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -50px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .03);
            pointer-events: none;
        }

        .js-hero-inner {
            position: relative;
            z-index: 1;
        }

        .js-hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .js-hero-left {
            flex: 1;
            min-width: 0;
        }

        .js-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 100px;
            padding: 5px 14px;
            font-size: .68rem;
            font-weight: 800;
            color: rgba(255, 255, 255, .95);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 14px;
            backdrop-filter: blur(4px);
        }

        .js-hero-title {
            font-family: var(--f, system-ui);
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -.5px;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .js-hero-company {
            font-size: .9rem;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-weight: 500;
        }

        .js-hero-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .js-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: .75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .95);
            backdrop-filter: blur(4px);
            transition: all 0.2s;
        }

        .js-chip:hover {
            background: rgba(255, 255, 255, .18);
        }

        .js-chip i {
            font-size: .7rem;
            opacity: 0.8;
        }

        .js-hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .js-ha-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            padding: 10px 20px;
            font-family: var(--f, system-ui);
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .25s ease;
        }

        .js-ha-edit {
            background: rgba(255, 255, 255, .15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .25);
            backdrop-filter: blur(4px);
        }

        .js-ha-edit:hover {
            background: rgba(255, 255, 255, .25);
            transform: translateY(-2px);
        }

        .js-ha-view {
            background: #fff;
            color: var(--blue, #1a56db);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .js-ha-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .js-ha-del {
            background: rgba(239, 68, 68, .2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, .3);
            backdrop-filter: blur(4px);
        }

        .js-ha-del:hover {
            background: rgba(239, 68, 68, .4);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ── Cards grid ── */
        .js-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-top: -48px;
            position: relative;
            z-index: 10;
        }

        .js-col {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Card ── */
        .js-card {
            background: #fff;
            border-radius: var(--r-lg, 14px);
            border: 1px solid var(--n200, #e5e7eb);
            box-shadow: var(--sh, 0 4px 6px -1px rgba(0, 0, 0, 0.05));
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .js-card:hover {
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.08);
        }

        .js-card-head {
            background: linear-gradient(90deg, var(--blue, #1a56db) 0%, var(--blue-d, #1e3a8a) 100%);
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .js-card-head-ico {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            color: #fff;
            flex-shrink: 0;
            backdrop-filter: blur(2px);
        }

        .js-card-head-title {
            font-family: var(--f, system-ui);
            font-size: .9rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.2px;
        }

        .js-card-head-right {
            margin-left: auto;
        }

        .js-card-body {
            padding: 24px;
        }

        /* ── Stat row ── */
        .js-stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .js-stat {
            background: #fff;
            border: 1px solid var(--n200, #e5e7eb);
            border-radius: 12px;
            padding: 18px 12px;
            text-align: center;
            border-top: 3px solid var(--blue, #1a56db);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .js-stat:hover {
            transform: translateY(-3px);
        }

        .js-stat.green {
            border-top-color: var(--green, #10b981);
        }

        .js-stat.orange {
            border-top-color: var(--orange, #f59e0b);
        }

        .js-stat.purple {
            border-top-color: var(--purple, #8b5cf6);
        }

        .js-stat-val {
            font-family: var(--f, system-ui);
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--n900, #111827);
            margin-bottom: 4px;
        }

        .js-stat-lbl {
            font-size: .7rem;
            font-weight: 700;
            color: var(--n500, #6b7280);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* ── Prose content ── */
        .js-prose {
            font-family: var(--f-body, system-ui);
            font-size: .9rem;
            color: var(--n700, #374151);
            line-height: 1.7;
            white-space: pre-line;
        }

        ul.js-prose {
            margin: 0;
            padding-left: 20px;
            list-style-type: none;
        }

        ul.js-prose li {
            margin-bottom: 8px;
            position: relative;
        }

        ul.js-prose li::before {
            content: "•";
            color: var(--blue, #1a56db);
            font-weight: bold;
            font-size: 1.2rem;
            position: absolute;
            left: -16px;
            top: -3px;
        }

        /* ── Info rows ── */
        .js-info-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--n100, #f3f4f6);
        }

        .js-info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .js-info-row:first-child {
            padding-top: 0;
        }

        .js-info-ico {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .js-info-ico.blue {
            background: rgba(26, 86, 219, .08);
            color: var(--blue, #1a56db);
        }

        .js-info-ico.green {
            background: rgba(16, 185, 129, .08);
            color: var(--green, #10b981);
        }

        .js-info-ico.orange {
            background: rgba(245, 158, 11, .08);
            color: var(--orange, #f59e0b);
        }

        .js-info-ico.purple {
            background: rgba(139, 92, 246, .08);
            color: var(--purple, #8b5cf6);
        }

        .js-info-ico.red {
            background: rgba(239, 68, 68, .08);
            color: var(--red, #ef4444);
        }

        .js-info-label {
            font-family: var(--f, system-ui);
            font-size: .68rem;
            font-weight: 800;
            color: var(--n400, #9ca3af);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
        }

        .js-info-value {
            font-family: var(--f, system-ui);
            font-size: .9rem;
            font-weight: 700;
            color: var(--n800, #1f2937);
        }

        /* ── Skills ── */
        .js-skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .js-skill-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(26, 86, 219, .06);
            border: 1px solid rgba(26, 86, 219, .15);
            border-radius: 100px;
            padding: 6px 14px;
            font-family: var(--f, system-ui);
            font-size: .8rem;
            font-weight: 700;
            color: #1e40af;
            transition: all 0.2s;
        }

        .js-skill-chip:hover {
            background: rgba(26, 86, 219, .1);
            border-color: rgba(26, 86, 219, .25);
        }

        .js-skill-chip i {
            font-size: .65rem;
            color: var(--blue, #1a56db);
        }

        /* ── Status badge ── */
        .js-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            padding: 6px 14px;
            font-family: var(--f, system-ui);
            font-size: .75rem;
            font-weight: 800;
        }

        .js-status-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .js-status-badge.active {
            background: #dcfce7;
            color: #166534;
        }

        .js-status-badge.active .dot {
            background: #22c55e;
            animation: blink 1.4s infinite;
        }

        .js-status-badge.inactive {
            background: var(--n100, #f3f4f6);
            color: var(--n500, #6b7280);
        }

        .js-status-badge.inactive .dot {
            background: var(--n400, #9ca3af);
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        /* ── Screening ── */
        .js-sq-item {
            border: 1px solid var(--n200, #e5e7eb);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .js-sq-item:last-child {
            margin-bottom: 0;
        }

        .js-sq-head {
            background: var(--n50, #f9fafb);
            border-bottom: 1px solid var(--n200, #e5e7eb);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .js-sq-num {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: var(--blue, #1a56db);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--f, system-ui);
            font-size: .7rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .js-sq-q {
            font-family: var(--f, system-ui);
            font-size: .85rem;
            font-weight: 700;
            color: var(--n800, #1f2937);
            flex: 1;
            line-height: 1.4;
        }

        .js-sq-type {
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .js-sq-type.select {
            background: #ede9fe;
            color: #6d28d9;
        }

        .js-sq-type.input {
            background: #dcfce7;
            color: #166534;
        }

        .js-sq-body {
            padding: 14px 18px;
            background: #fff;
        }

        .js-sq-opt {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            font-size: .85rem;
            color: var(--n600, #4b5563);
        }

        .js-sq-opt-ltr {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: var(--n100, #f3f4f6);
            color: var(--n600, #4b5563);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--f, system-ui);
            font-size: .65rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .js-sq-text-note {
            background: var(--n50, #f9fafb);
            border: 1px dashed var(--n300, #d1d5db);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: .85rem;
            color: var(--n500, #6b7280);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Applicants mini table ── */
        .js-apps-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }

        .js-apps-table th {
            background: var(--n50, #f9fafb);
            padding: 12px 14px;
            font-family: var(--f, system-ui);
            font-size: .68rem;
            font-weight: 800;
            color: var(--n500, #6b7280);
            text-transform: uppercase;
            letter-spacing: .08em;
            text-align: left;
            border-bottom: 1px solid var(--n200, #e5e7eb);
            white-space: nowrap;
        }

        .js-apps-table td {
            padding: 14px;
            border-bottom: 1px solid var(--n100, #f3f4f6);
            color: var(--n700, #374151);
            vertical-align: middle;
            white-space: nowrap;
        }

        .js-apps-table tr:last-child td {
            border-bottom: none;
        }

        .js-apps-table tr:hover td {
            background: var(--n50, #f9fafb);
        }

        .js-apps-empty {
            text-align: center;
            padding: 40px 20px;
        }

        .js-apps-empty i {
            font-size: 2rem;
            color: var(--n300, #d1d5db);
            display: block;
            margin-bottom: 12px;
        }

        .js-apps-empty p {
            font-size: .9rem;
            color: var(--n500, #6b7280);
            line-height: 1.5;
        }

        /* ── Toggle status ── */
        .js-toggle-form {
            display: inline;
        }

        .js-toggle-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 8px;
            padding: 8px 16px;
            font-family: var(--f, system-ui);
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid;
            transition: all 0.2s ease;
        }

        .js-toggle-btn.deactivate {
            background: #fffbeb;
            color: #92400e;
            border-color: #fcd34d;
        }

        .js-toggle-btn.deactivate:hover {
            background: #fef3c7;
        }

        .js-toggle-btn.activate {
            background: #ecfdf5;
            color: #065f46;
            border-color: #6ee7b7;
        }

        .js-toggle-btn.activate:hover {
            background: #d1fae5;
        }

        /* ── Delete modal ── */
        .js-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .js-modal.open {
            display: flex;
        }

        .js-modal-box {
            background: #fff;
            border-radius: var(--r-xl, 16px);
            padding: 32px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: fadeUp .3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        /* ── Responsive Enhancements ── */
        @media(max-width: 960px) {
            .js-wrap {
                padding: 0 16px 40px;
            }
        }

        @media(max-width: 860px) {
            .js-grid {
                grid-template-columns: 1fr;
                margin-top: -30px;
            }

            .js-hero {
                padding: 28px 24px 60px;
            }

            .js-hero::before,
            .js-hero::after {
                display: none;
            }

            /* Cleaner on mobile */
        }

        @media(max-width: 640px) {
            .js-stat-row {
                grid-template-columns: 1fr 1fr;
            }

            .js-hero-top {
                flex-direction: column;
            }

            .js-hero-actions {
                width: 100%;
            }

            .js-ha-btn {
                width: 100%;
            }

            .js-card-body {
                padding: 18px;
            }
        }

        @media(max-width: 480px) {
            .js-stat-row {
                grid-template-columns: 1fr;
            }

            /* Stack stats on tiny screens */
            .js-hero {
                padding: 24px 18px 50px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        // Safe Variable Initialization
        $j = $job ?? null;
        $status = ($j->status ?? 0) == 1 ? 'active' : 'in-active';

        // Safely decode JSON fields to prevent errors
        $skills = is_string($j->skills ?? null) ? json_decode($j->skills, true) : $j->skills ?? [];
        $resps = is_string($j->responsibilities ?? null)
            ? json_decode($j->responsibilities, true)
            : $j->responsibilities ?? [];
        $bens = is_string($j->benefits ?? null) ? json_decode($j->benefits, true) : $j->benefits ?? [];
        $sq = is_string($j->screening_questions ?? null)
            ? json_decode($j->screening_questions, true)
            : $j->screening_questions ?? [];

        $salary =
            $j && ($j->salary_min ?? 0) + ($j->salary_max ?? 0) > 0
                ? '₹' . number_format($j->salary_min ?? 0) . ' – ₹' . number_format($j->salary_max ?? 0) . ' /mo'
                : 'Not Disclosed';

        $loc = collect([$j->city ?? null, $j->district ?? null, $j->state ?? null])
            ->filter()
            ->implode(', ');
        $apps = $j->applications ?? collect();
        $posted = $j ? \Carbon\Carbon::parse($j->created_at)->format('d M Y') : '—';
    @endphp

    <div class="js-wrap">

        {{-- ══ HERO ══ --}}
        <div class="js-hero">
            <div class="js-hero-inner">
                <div class="js-hero-top">
                    <div class="js-hero-left">
                        <div class="js-hero-badge"><i class="fa-solid fa-briefcase"></i> Job Listing</div>
                        <div class="js-hero-title">{{ $j->job_title ?? 'Job Title' }}</div>
                        <div class="js-hero-company">
                            <i class="fa-solid fa-building" style="font-size:.8rem;"></i>
                            {{ auth()->user()->company->name ?? (auth()->user()->name ?? 'Your Company') }}
                            <span style="opacity:0.5">&middot;</span>
                            <i class="fa-solid fa-location-dot" style="font-size:.8rem;"></i> {{ $loc ?: '—' }}
                        </div>
                        <div class="js-hero-chips">
                            @if ($j)
                                <span class="js-chip"><i class="fa-solid fa-clock"></i>
                                    {{ $j->job_type ?? 'Full Time' }}</span>
                                <span class="js-chip"><i class="fa-solid fa-briefcase"></i>
                                    {{ $j->experience_required ?? '—' }}</span>
                                <span class="js-chip"><i class="fa-solid fa-indian-rupee-sign"></i>
                                    {{ $salary }}</span>
                                <span class="js-chip"><i class="fa-solid fa-graduation-cap"></i>
                                    {{ $j->education ?? '—' }}</span>
                                <span class="js-chip"><i class="fa-solid fa-calendar"></i> Posted {{ $posted }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="js-hero-actions">
                        <a href="{{ route('employer.jobs.edit', $j->id ?? 0) }}" class="js-ha-btn js-ha-edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Job
                        </a>
                        <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}" class="js-ha-btn js-ha-view">
                            <i class="fa-solid fa-users"></i> View Applicants
                        </a>
                        <button type="button" class="js-ha-btn js-ha-del"
                            onclick="document.getElementById('deleteModal').classList.add('open')">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ MAIN GRID ══ --}}
        <div class="js-grid">

            {{-- ── LEFT COLUMN ── --}}
            <div class="js-col">

                {{-- Stats Row --}}
                <div class="js-stat-row">
                    <div class="js-stat">
                        <div class="js-stat-val">{{ $apps->count() }}</div>
                        <div class="js-stat-lbl">Total Applicants</div>
                    </div>
                    <div class="js-stat green">
                        <div class="js-stat-val">{{ $apps->where('status', 'shortlisted')->count() }}</div>
                        <div class="js-stat-lbl">Shortlisted</div>
                    </div>
                    <div class="js-stat orange">
                        <div class="js-stat-val">{{ $apps->where('status', 'interview')->count() }}</div>
                        <div class="js-stat-lbl">Interview</div>
                    </div>
                    <div class="js-stat purple">
                        <div class="js-stat-val">{{ $j->vacancies ?? 1 }}</div>
                        <div class="js-stat-lbl">Vacancies</div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-file-lines"></i></div>
                        <div class="js-card-head-title">Job Description</div>
                    </div>
                    <div class="js-card-body">
                        <div class="js-prose">{{ $j->description ?? 'No description provided.' }}</div>
                    </div>
                </div>

                {{-- Responsibilities --}}
                @if (!empty($resps))
                    <div class="js-card">
                        <div class="js-card-head">
                            <div class="js-card-head-ico"><i class="fa-solid fa-list-check"></i></div>
                            <div class="js-card-head-title">Responsibilities</div>
                        </div>
                        <div class="js-card-body">
                            <ul class="js-prose">
                                @foreach ($resps as $res)
                                    <li>{{ $res }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Benefits --}}
                @if (!empty($bens))
                    <div class="js-card">
                        <div class="js-card-head">
                            <div class="js-card-head-ico"><i class="fa-solid fa-gift"></i></div>
                            <div class="js-card-head-title">Benefits</div>
                        </div>
                        <div class="js-card-body">
                            <ul class="js-prose">
                                @foreach ($bens as $ben)
                                    <li>{{ $ben }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Screening Questions --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-clipboard-question"></i></div>
                        <div class="js-card-head-title">Screening Questions</div>
                        <div class="js-card-head-right">
                            <span style="font-size:.75rem;font-weight:800;color:rgba(255,255,255,.8);">{{ count($sq) }}
                                question(s)</span>
                        </div>
                    </div>
                    <div class="js-card-body">
                        @if (count($sq) > 0)
                            @foreach ($sq as $qi => $q)
                                <div class="js-sq-item">
                                    <div class="js-sq-head">
                                        <div class="js-sq-num">Q{{ $qi + 1 }}</div>
                                        <div class="js-sq-q">{{ $q['question'] ?? 'Question' }}</div>
                                        <span class="js-sq-type {{ $q['type'] ?? 'select' }}">
                                            {{ ($q['type'] ?? 'select') === 'select' ? 'Multiple Choice' : 'Text Input' }}
                                        </span>
                                    </div>
                                    <div class="js-sq-body">
                                        @if (($q['type'] ?? 'select') === 'select' && !empty($q['options']))
                                            @php $letters = ['A','B','C','D','E','F','G','H']; @endphp
                                            @foreach ($q['options'] as $oi => $opt)
                                                <div class="js-sq-opt">
                                                    <div class="js-sq-opt-ltr">{{ $letters[$oi] ?? $oi + 1 }}</div>
                                                    {{ $opt }}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="js-sq-text-note">
                                                <i class="fa-solid fa-keyboard" style="color:var(--n400, #9ca3af);"></i>
                                                Candidate will type their answer in a text field
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align:center;padding:30px;color:var(--n500, #6b7280);">
                                <i class="fa-solid fa-clipboard-question"
                                    style="font-size:2rem;opacity:.3;display:block;margin-bottom:12px;"></i>
                                <div style="font-size:.9rem;">No screening questions added for this job.</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Applicants --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-users"></i></div>
                        <div class="js-card-head-title">Recent Applicants</div>
                        <div class="js-card-head-right">
                            <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}"
                                style="font-size:.75rem;font-weight:800;color:rgba(255,255,255,.9);text-decoration:none;">
                                View All <i class="fa-solid fa-arrow-right" style="font-size:.7rem; margin-left:4px;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="js-card-body" style="padding:0;">
                        @if ($apps && $apps->count() > 0)
                            <div style="overflow-x:auto;">
                                <table class="js-apps-table">
                                    <thead>
                                        <tr>
                                            <th>Candidate</th>
                                            <th>Applied</th>
                                            <th>Experience</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($apps->take(6) as $app)
                                            @php
                                                $sts = $app->status ?? 'new';
                                                $stsBadge = [
                                                    'new' => 'badge-blue',
                                                    'shortlisted' => 'badge-green',
                                                    'interview' => 'badge-purple',
                                                    'rejected' => 'badge-red',
                                                ];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div style="display:flex;align-items:center;gap:12px;">
                                                        <div
                                                            style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--blue, #1a56db),var(--purple, #8b5cf6));color:#fff;font-family:var(--f, system-ui);font-size:.85rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                            {{ strtoupper(substr($app->jobseeker->name ?? 'C', 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div
                                                                style="font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;color:var(--n900, #111827);">
                                                                {{ $app->jobseeker->name ?? 'Candidate' }}</div>
                                                            <div
                                                                style="font-size:.75rem;color:var(--n500, #6b7280);margin-top:2px;">
                                                                {{ $app->jobseeker->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="font-size:.8rem;color:var(--n600, #4b5563);">
                                                    {{ \Carbon\Carbon::parse($app->created_at)->diffForHumans() }}</td>
                                                <td style="font-size:.8rem;color:var(--n600, #4b5563);">
                                                    {{ $app->jobseeker->experience ?? '—' }}</td>
                                                <td><span class="badge {{ $stsBadge[$sts] ?? 'badge-gray' }}"
                                                        style="text-transform:capitalize;">{{ $sts }}</span></td>
                                                <td>
                                                    <a href="{{ route('employer.candidates') }}#app-{{ $app->id ?? '' }}"
                                                        style="font-family:var(--f, system-ui);font-size:.8rem;font-weight:700;color:var(--blue, #1a56db);text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                                        View <i class="fa-solid fa-arrow-right"
                                                            style="font-size:.65rem;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="js-apps-empty">
                                <i class="fa-solid fa-user-plus"></i>
                                <p>No applications received yet.<br>Share your job link to attract candidates.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>{{-- /left col --}}

            {{-- ── RIGHT COLUMN ── --}}
            <div class="js-col">

                {{-- Status & Actions --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-toggle-on"></i></div>
                        <div class="js-card-head-title">Job Status</div>
                    </div>
                    <div class="js-card-body">
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                            <div>
                                <div
                                    style="font-family:var(--f, system-ui);font-size:.7rem;font-weight:700;color:var(--n500, #6b7280);margin-bottom:6px; letter-spacing: 0.5px;">
                                    CURRENT STATUS</div>
                                <span class="js-status-badge {{ $status }}">
                                    <span class="dot"></span>
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                            <form class="js-toggle-form" method="POST"
                                action="{{ route('employer.jobs.toggle', $j->id ?? 0) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="js-toggle-btn {{ $status === 'active' ? 'deactivate' : 'activate' }}">
                                    @if ($status === 'active')
                                        <i class="fa-solid fa-circle-pause"></i> Deactivate
                                    @else
                                        <i class="fa-solid fa-circle-play"></i> Activate
                                    @endif
                                </button>
                            </form>
                        </div>
                        <div
                            style="background:var(--n50, #f9fafb);border-radius:10px;padding:14px;font-size:.8rem;color:var(--n600, #4b5563);line-height:1.6;display:flex;align-items:flex-start;gap:10px; border:1px solid var(--n100, #f3f4f6);">
                            <i class="fa-solid fa-circle-info"
                                style="color:var(--blue, #1a56db);font-size:.85rem;margin-top:3px;flex-shrink:0;"></i>
                            {{ $status === 'active' ? 'This job is visible to job seekers and actively accepting new applications.' : 'This job is hidden from job seekers and not accepting applications.' }}
                        </div>
                    </div>
                </div>

                {{-- Job Details --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="js-card-head-title">Job Details</div>
                    </div>
                    <div class="js-card-body" style="padding:18px 24px;">
                        <div class="js-info-row">
                            <div class="js-info-ico blue"><i class="fa-solid fa-layer-group"></i></div>
                            <div>
                                <div class="js-info-label">Category</div>
                                <div class="js-info-value">{{ $j->category ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico purple"><i class="fa-solid fa-industry"></i></div>
                            <div>
                                <div class="js-info-label">Industry</div>
                                <div class="js-info-value">{{ $j->industry ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico orange"><i class="fa-solid fa-clock"></i></div>
                            <div>
                                <div class="js-info-label">Job Type</div>
                                <div class="js-info-value">{{ $j->job_type ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico green"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                            <div>
                                <div class="js-info-label">Salary Range</div>
                                <div class="js-info-value">{{ $salary }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico blue"><i class="fa-solid fa-briefcase"></i></div>
                            <div>
                                <div class="js-info-label">Experience Required</div>
                                <div class="js-info-value">{{ $j->experience ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico purple"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div>
                                <div class="js-info-label">Education</div>
                                <div class="js-info-value">{{ $j->education ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico orange"><i class="fa-solid fa-users"></i></div>
                            <div>
                                <div class="js-info-label">Vacancies</div>
                                <div class="js-info-value">{{ $j->num_vacancies ?? 1 }} position(s)</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico green"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <div class="js-info-label">Location</div>
                                <div class="js-info-value">{{ $loc ?: '—' }}</div>
                            </div>
                        </div>
                        <div class="js-info-row">
                            <div class="js-info-ico blue"><i class="fa-solid fa-calendar-plus"></i></div>
                            <div>
                                <div class="js-info-label">Posted On</div>
                                <div class="js-info-value">{{ $posted }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Skills --}}
                @if (count($skills) > 0)
                    <div class="js-card">
                        <div class="js-card-head">
                            <div class="js-card-head-ico"><i class="fa-solid fa-tags"></i></div>
                            <div class="js-card-head-title">Required Skills</div>
                        </div>
                        <div class="js-card-body">
                            <div class="js-skills-wrap">
                                @foreach ($skills as $skill)
                                    <span class="js-skill-chip"><i class="fa-solid fa-check"></i>
                                        {{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Quick Actions --}}
                <div class="js-card">
                    <div class="js-card-head">
                        <div class="js-card-head-ico"><i class="fa-solid fa-bolt"></i></div>
                        <div class="js-card-head-title">Quick Actions</div>
                    </div>
                    <div class="js-card-body" style="display:flex;flex-direction:column;gap:12px;">
                        <a href="{{ route('employer.jobs.edit', $j->id ?? 0) }}"
                            style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:10px;background:rgba(26,86,219,.08);color:var(--blue, #1a56db);font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;text-decoration:none;transition:all 0.2s;">
                            <i class="fa-solid fa-pen-to-square"
                                style="font-size:.9rem;width:18px;text-align:center;"></i>
                            Edit Job Details
                            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.7rem;"></i>
                        </a>
                        <a href="{{ route('employer.candidates') }}?job={{ $j->id ?? '' }}"
                            style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:10px;background:rgba(16,185,129,.08);color:var(--green, #10b981);font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;text-decoration:none;transition:all 0.2s;">
                            <i class="fa-solid fa-users" style="font-size:.9rem;width:18px;text-align:center;"></i>
                            View All Applicants
                            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.7rem;"></i>
                        </a>
                        <a href="{{ route('employer.jobs.create') }}"
                            style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:10px;background:rgba(139,92,246,.08);color:var(--purple, #8b5cf6);font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;text-decoration:none;transition:all 0.2s;">
                            <i class="fa-solid fa-plus-circle" style="font-size:.9rem;width:18px;text-align:center;"></i>
                            Post Another Job
                            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.7rem;"></i>
                        </a>
                        <a href="{{ route('employer.jobs.index') }}"
                            style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:10px;background:var(--n50, #f9fafb);color:var(--n600, #4b5563);border:1px solid var(--n200, #e5e7eb);font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;text-decoration:none;transition:all 0.2s;">
                            <i class="fa-solid fa-list" style="font-size:.9rem;width:18px;text-align:center;"></i>
                            Back to Manage Jobs
                            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.7rem;"></i>
                        </a>
                        <button type="button" onclick="document.getElementById('deleteModal').classList.add('open')"
                            style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:10px;background:rgba(239,68,68,.08);color:var(--red, #ef4444);font-family:var(--f, system-ui);font-size:.85rem;font-weight:700;cursor:pointer;border:none;width:100%;text-align:left;transition:all 0.2s;">
                            <i class="fa-solid fa-trash" style="font-size:.9rem;width:18px;text-align:center;"></i>
                            Delete This Job
                            <i class="fa-solid fa-arrow-right" style="margin-left:auto;font-size:.7rem;"></i>
                        </button>
                    </div>
                </div>

            </div>{{-- /right col --}}

        </div>{{-- /grid --}}
    </div>{{-- /wrap --}}

    {{-- ══ DELETE MODAL ══ --}}
    <div class="js-modal" id="deleteModal" onclick="if(event.target===this) this.classList.remove('open')">
        <div class="js-modal-box">
            <div style="text-align:center;margin-bottom:24px;">
                <div
                    style="width:64px;height:64px;border-radius:16px;background:#fef2f2;color:var(--red, #ef4444);font-size:1.6rem;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fa-solid fa-trash"></i>
                </div>
                <div
                    style="font-family:var(--f, system-ui);font-size:1.2rem;font-weight:900;color:var(--n900, #111827);margin-bottom:8px;">
                    Delete This Job?</div>
                <div style="font-size:.9rem;color:var(--n500, #6b7280);line-height:1.6;">
                    Deleting <strong>{{ $j->job_title ?? 'this job' }}</strong> will permanently remove the listing and all
                    associated applications. This action cannot be undone.
                </div>
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <button onclick="document.getElementById('deleteModal').classList.remove('open')"
                    style="flex:1;min-width:120px;padding:12px;border-radius:10px;background:#fff;border:1px solid var(--n300, #d1d5db);font-family:var(--f, system-ui);font-size:.9rem;font-weight:700;color:var(--n600, #4b5563);cursor:pointer;transition:all 0.2s;">
                    Cancel
                </button>
                <form method="POST" action="{{ route('employer.jobs.destroy', $j->id ?? 0) }}"
                    style="flex:1;min-width:120px;display:flex;">
                    @csrf @method('DELETE')
                    <button type="submit"
                        style="width:100%;padding:12px;border-radius:10px;background:var(--red, #ef4444);color:#fff;border:none;font-family:var(--f, system-ui);font-size:.9rem;font-weight:800;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 6px rgba(239,68,68,.2);">
                        <i class="fa-solid fa-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
