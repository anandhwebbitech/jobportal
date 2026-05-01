{{-- ════════════════════════════════════════════════════════
     resources/views/employer/jobs/create.blade.php
     Post a Job – LinearJobs Employer Dashboard  (Ultra Redesign)
════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title', 'Post a New Job')
@section('page-title', 'Post New Job')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Instrument+Sans:wght@400;500;600;700&display=swap');

        /* ══════════════════════════════
       DESIGN TOKENS
    ══════════════════════════════ */
        :root {
            --ink: #0c1425;
            --ink2: #1e293b;
            --ink3: #475569;
            --ink4: #94a3b8;
            --ink5: #cbd5e1;
            --surface: #f8fafd;
            --white: #ffffff;

            --blue: #2563eb;
            --blue-d: #1d4ed8;
            --blue-deep: #1e3a8a;
            --blue-lt: #eff6ff;
            --blue-mid: #bfdbfe;
            --blue-ring: rgba(37, 99, 235, .14);

            --green: #059669;
            --green-lt: #ecfdf5;
            --green-mid: #a7f3d0;

            --red: #dc2626;
            --red-lt: #fef2f2;
            --red-mid: #fecaca;

            --amber: #d97706;
            --amber-lt: #fffbeb;

            --purple: #7c3aed;
            --purple-lt: #f5f3ff;

            --border: #e2e8f0;
            --border-h: #c7d2fe;

            --r: 10px;
            --r-sm: 8px;
            --r-md: 14px;
            --r-lg: 18px;
            --r-xl: 24px;

            --sh-xs: 0 1px 2px rgba(0, 0, 0, .05);
            --sh-sm: 0 1px 4px rgba(0, 0, 0, .06), 0 4px 12px rgba(0, 0, 0, .05);
            --sh-md: 0 4px 20px rgba(0, 0, 0, .09);
            --sh-lg: 0 8px 40px rgba(0, 0, 0, .12);
            --sh-xl: 0 20px 60px rgba(0, 0, 0, .15);

            --ease: cubic-bezier(.4, 0, .2, 1);
            --spring: cubic-bezier(.34, 1.56, .64, 1);

            --fh: 'Plus Jakarta Sans', sans-serif;
            --fb: 'Instrument Sans', sans-serif;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--fb);
        }

        /* ══════════════════════════════
       WRAP & LAYOUT
    ══════════════════════════════ */
        .pj-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        /* ══════════════════════════════
       HERO BANNER
    ══════════════════════════════ */
        .pj-hero {
            background: linear-gradient(140deg, #0f2460 0%, #1d4ed8 45%, #3b82f6 75%, #60a5fa 100%);
            border-radius: var(--r-xl);
            padding: 36px 40px 100px;
            position: relative;
            overflow: hidden;
            margin-bottom: 0;
        }

        .pj-hero-orb1 {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, .12) 0%, transparent 70%);
            pointer-events: none;
        }

        .pj-hero-orb2 {
            position: absolute;
            bottom: -60px;
            left: -40px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, .07) 0%, transparent 70%);
            pointer-events: none;
        }

        .pj-hero-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .pj-hero-inner {
            position: relative;
            z-index: 2;
        }

        .pj-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 100px;
            padding: 5px 14px;
            font-family: var(--fh);
            font-size: .67rem;
            font-weight: 800;
            color: rgba(255, 255, 255, .9);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .pj-hero-eyebrow span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4ade80;
            animation: blink 1.8s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .2
            }
        }

        .pj-hero-title {
            font-family: var(--fh);
            font-size: clamp(1.6rem, 3.5vw, 2.4rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
            line-height: 1.15;
            margin-bottom: 10px;
        }

        .pj-hero-title span {
            color: #93c5fd;
        }

        .pj-hero-sub {
            font-family: var(--fb);
            font-size: .9rem;
            color: rgba(255, 255, 255, .72);
            line-height: 1.7;
            max-width: 540px;
        }

        .pj-plan-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .1);
            border: 1.5px solid rgba(255, 255, 255, .18);
            border-radius: 14px;
            padding: 10px 18px;
            margin-top: 22px;
            font-family: var(--fb);
            font-size: .82rem;
            color: rgba(255, 255, 255, .9);
        }

        .pj-plan-badge strong {
            color: #fde68a;
            font-family: var(--fh);
            font-weight: 800;
        }

        /* ══════════════════════════════
       WIZARD PROGRESS BAR
    ══════════════════════════════ */
        .pj-wizard-shell {
            margin: -52px 0 0;
            position: relative;
            z-index: 30;
        }

        .pj-wizard-card {
            background: var(--white);
            border-radius: var(--r-lg);
            box-shadow: var(--sh-xl);
            border: 1.5px solid var(--border);
            padding: 22px 32px;
        }

        .pj-wizard-track {
            display: flex;
            align-items: flex-start;
            position: relative;
        }

        /* connector lines */
        .pj-wizard-track::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 18px;
            right: 18px;
            height: 2px;
            background: var(--border);
            border-radius: 100px;
            z-index: 0;
        }

        .pj-wz-fill {
            position: absolute;
            top: 18px;
            left: 18px;
            height: 2px;
            background: linear-gradient(90deg, var(--blue-deep), var(--blue), #60a5fa);
            border-radius: 100px;
            z-index: 1;
            transition: width .5s var(--ease);
            width: 0%;
        }

        .pj-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .pj-step-bubble {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2.5px solid var(--border);
            background: var(--white);
            color: var(--ink4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            transition: all .35s var(--spring);
        }

        .pj-step.active .pj-step-bubble {
            background: linear-gradient(135deg, var(--blue), var(--blue-deep));
            border-color: var(--blue);
            color: #fff;
            box-shadow: 0 0 0 5px var(--blue-ring), 0 4px 12px rgba(37, 99, 235, .3);
        }

        .pj-step.done .pj-step-bubble {
            background: linear-gradient(135deg, var(--green), #047857);
            border-color: var(--green);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, .12);
        }

        .pj-step-name {
            font-family: var(--fh);
            font-size: .6rem;
            font-weight: 700;
            color: var(--ink4);
            margin-top: 9px;
            text-align: center;
            white-space: nowrap;
            letter-spacing: .03em;
            transition: color .3s;
        }

        .pj-step.active .pj-step-name {
            color: var(--blue);
        }

        .pj-step.done .pj-step-name {
            color: var(--green);
        }

        /* ══════════════════════════════
       FORM AREA & TABS
    ══════════════════════════════ */
        .pj-form-area {
            margin-top: 28px;
        }

        .pj-tab {
            display: none;
        }

        .pj-tab.active {
            display: block;
            animation: tabIn .32s var(--ease);
        }

        @keyframes tabIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ══════════════════════════════
       CARD COMPONENT
    ══════════════════════════════ */
        .pj-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r-lg);
            box-shadow: var(--sh-sm);
            overflow: hidden;
            margin-bottom: 20px;
            transition: box-shadow .2s var(--ease);
        }

        .pj-card:hover {
            box-shadow: var(--sh-md);
        }

        .pj-card-head {
            padding: 18px 26px;
            border-bottom: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            background: linear-gradient(135deg, var(--surface) 0%, #fff 100%);
            position: relative;
        }

        .pj-card-head::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--blue), #60a5fa);
            border-radius: 0 4px 4px 0;
        }

        .pj-head-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--blue-lt), var(--blue-mid));
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px var(--blue-ring);
        }

        .pj-head-text {}

        .pj-head-title {
            font-family: var(--fh);
            font-size: 1rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 2px;
            letter-spacing: -.2px;
        }

        .pj-head-sub {
            font-family: var(--fb);
            font-size: .78rem;
            color: var(--ink3);
        }

        .pj-card-body {
            padding: 28px 26px;
        }

        /* ══════════════════════════════
       GRID LAYOUTS
    ══════════════════════════════ */
        .pj-row2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .pj-row3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
        }

        .pj-col {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        /* ══════════════════════════════
       FIELD GROUP
    ══════════════════════════════ */
        .pj-fg {
            margin-bottom: 24px;
        }

        .pj-fg:last-child {
            margin-bottom: 0;
        }

        /* ══════════════════════════════
       LABELS
    ══════════════════════════════ */
        .pj-lbl {
            display: flex;
            align-items: center;
            gap: 7px;
            font-family: var(--fh);
            font-size: .8rem;
            font-weight: 700;
            color: var(--ink2);
            margin-bottom: 9px;
            letter-spacing: -.1px;
        }

        .pj-lbl-ico {
            width: 18px;
            height: 18px;
            border-radius: 5px;
            background: var(--blue-lt);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            flex-shrink: 0;
        }

        .pj-req {
            color: var(--red);
            font-size: .85em;
            margin-left: 1px;
        }

        .pj-opt {
            font-family: var(--fb);
            font-size: .66rem;
            font-weight: 500;
            color: var(--ink4);
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 2px 8px;
            border-radius: 100px;
            margin-left: 4px;
        }

        /* ══════════════════════════════
       INPUT WRAPPER & INPUTS
    ══════════════════════════════ */
        .pj-iw {
            position: relative;
        }

        .pj-iw-prefix {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink4);
            font-size: .78rem;
            pointer-events: none;
            z-index: 2;
        }

        .pj-iw-prefix.top {
            align-items: flex-start;
            padding-top: 13px;
        }

        .pj-input {
            width: 100%;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            padding: 12px 14px 12px 44px;
            font-family: var(--fb);
            font-size: .9rem;
            color: var(--ink);
            outline: none;
            transition: border-color .2s var(--ease), box-shadow .2s var(--ease), background .2s;
            -webkit-appearance: none;
            appearance: none;
        }

        .pj-input:hover:not(:focus):not(.err) {
            border-color: var(--border-h);
        }

        .pj-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px var(--blue-ring);
            background: #fafcff;
        }

        .pj-input::placeholder {
            color: var(--ink5);
            font-family: var(--fb);
        }

        .pj-input.no-ico {
            padding-left: 14px;
        }

        .pj-input.err {
            border-color: var(--red);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, .07);
        }

        select.pj-input {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='9'%3E%3Cpath d='M1 1.5l6 6 6-6' stroke='%2394a3b8' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        textarea.pj-input {
            padding-top: 13px;
            resize: vertical;
            min-height: 130px;
            line-height: 1.7;
        }

        /* counter */
        .pj-counter {
            font-family: var(--fb);
            font-size: .7rem;
            color: var(--ink4);
            text-align: right;
            margin-top: 6px;
        }

        .pj-counter.warn {
            color: var(--amber);
        }

        .pj-counter.over {
            color: var(--red);
        }

        /* hint */
        .pj-hint {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-family: var(--fb);
            font-size: .75rem;
            color: var(--ink3);
            margin-top: 7px;
            line-height: 1.55;
        }

        .pj-hint i {
            color: var(--blue);
            font-size: .68rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* field error */
        .pj-ferr {
            display: none;
            align-items: center;
            gap: 6px;
            font-family: var(--fb);
            font-size: .75rem;
            color: var(--red);
            margin-top: 6px;
        }

        .pj-ferr.show {
            display: flex;
        }

        /* alert */
        .pj-alert {
            display: none;
            align-items: flex-start;
            gap: 12px;
            background: var(--red-lt);
            border: 1.5px solid var(--red-mid);
            border-radius: var(--r-sm);
            padding: 14px 18px;
            font-family: var(--fb);
            font-size: .84rem;
            color: #b91c1c;
            margin-bottom: 22px;
            animation: shake .38s var(--ease);
        }

        .pj-alert.show {
            display: flex;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0)
            }

            20% {
                transform: translateX(-6px)
            }

            40% {
                transform: translateX(6px)
            }

            60% {
                transform: translateX(-4px)
            }

            80% {
                transform: translateX(4px)
            }
        }

        /* ══════════════════════════════
       SECTION DIVIDER
    ══════════════════════════════ */
        .pj-sec-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0 22px;
        }

        .pj-sec-divider hr {
            flex: 1;
            border: none;
            height: 1px;
            background: var(--border);
        }

        .pj-sec-lbl {
            display: flex;
            align-items: center;
            gap: 7px;
            font-family: var(--fh);
            font-size: .68rem;
            font-weight: 800;
            color: var(--ink3);
            letter-spacing: .09em;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 4px 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 100px;
        }

        /* ══════════════════════════════
       JOB TYPE SELECTOR CARDS
    ══════════════════════════════ */
        .pj-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .pj-type-opt input {
            display: none;
        }

        .pj-type-opt label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            border: 2px solid var(--border);
            border-radius: var(--r-md);
            padding: 20px 14px;
            cursor: pointer;
            text-align: center;
            background: var(--white);
            transition: all .22s var(--ease);
            position: relative;
            overflow: hidden;
        }

        .pj-type-opt label::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--blue-lt), transparent);
            opacity: 0;
            transition: opacity .2s;
        }

        .pj-type-opt label:hover {
            border-color: var(--blue-mid);
            transform: translateY(-2px);
            box-shadow: var(--sh-sm);
        }

        .pj-type-opt label:hover::before {
            opacity: 1;
        }

        .pj-type-ico {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--surface);
            color: var(--ink3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all .22s;
            position: relative;
            z-index: 1;
        }

        .pj-type-nm {
            font-family: var(--fh);
            font-size: .85rem;
            font-weight: 800;
            color: var(--ink2);
            position: relative;
            z-index: 1;
        }

        .pj-type-ds {
            font-family: var(--fb);
            font-size: .72rem;
            color: var(--ink4);
            position: relative;
            z-index: 1;
            line-height: 1.4;
        }

        .pj-type-opt input:checked+label {
            border-color: var(--blue);
            background: linear-gradient(135deg, var(--blue-lt) 0%, #e8f0fe 100%);
            box-shadow: 0 0 0 3px var(--blue-ring), var(--sh-sm);
            transform: translateY(-2px);
        }

        .pj-type-opt input:checked+label .pj-type-ico {
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            color: #fff;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
        }

        .pj-type-opt input:checked+label .pj-type-nm {
            color: var(--blue-d);
        }

        /* 2-col type (status) */
        .pj-type2 {
            grid-template-columns: 1fr 1fr;
        }

        /* ══════════════════════════════
       SALARY ROW
    ══════════════════════════════ */
        .pj-salary-row {
            display: grid;
            grid-template-columns: 1fr 30px 1fr auto;
            gap: 10px;
            align-items: center;
        }

        .pj-salary-sep {
            font-family: var(--fh);
            font-size: .9rem;
            font-weight: 700;
            color: var(--ink4);
            text-align: center;
        }

        .pj-salary-tag {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            padding: 12px 14px;
            font-family: var(--fh);
            font-size: .78rem;
            font-weight: 700;
            color: var(--ink3);
            white-space: nowrap;
        }

        /* ══════════════════════════════
       SKILLS INPUT COMPONENT
    ══════════════════════════════ */
        .pj-skills-wrap {
            position: relative;
        }

        .pj-skills-field {
            border: 1.5px solid var(--border);
            border-radius: var(--r);
            padding: 10px 12px;
            min-height: 56px;
            cursor: text;
            background: var(--white);
            transition: border-color .2s var(--ease), box-shadow .2s var(--ease), background .2s;
        }

        .pj-skills-field:focus-within {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px var(--blue-ring);
            background: #fafcff;
        }

        .pj-chips-row {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 7px;
        }

        .pj-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--blue-lt), #e8f0fe);
            border: 1.5px solid var(--blue-mid);
            border-radius: 8px;
            padding: 5px 10px 5px 13px;
            font-family: var(--fh);
            font-size: .77rem;
            font-weight: 700;
            color: var(--blue-d);
            animation: chipIn .2s var(--spring);
        }

        @keyframes chipIn {
            from {
                opacity: 0;
                transform: scale(.85)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        .pj-chip-rm {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--blue-mid);
            font-size: .7rem;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color .15s;
            border-radius: 4px;
        }

        .pj-chip-rm:hover {
            color: var(--red);
        }

        .pj-skills-input {
            border: none;
            outline: none;
            background: transparent;
            font-family: var(--fb);
            font-size: .9rem;
            color: var(--ink);
            width: 100%;
            min-width: 160px;
        }

        .pj-skills-input::placeholder {
            color: var(--ink5);
        }

        /* dropdown */
        .pj-skills-dd {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            box-shadow: var(--sh-lg);
            z-index: 80;
            max-height: 230px;
            overflow-y: auto;
            display: none;
        }

        .pj-skills-dd.open {
            display: block;
            animation: ddIn .18s var(--ease);
        }

        @keyframes ddIn {
            from {
                opacity: 0;
                transform: translateY(-6px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .pj-dd-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-family: var(--fb);
            font-size: .86rem;
            color: var(--ink2);
            cursor: pointer;
            transition: background .12s;
        }

        .pj-dd-item:hover {
            background: var(--blue-lt);
            color: var(--blue-d);
        }

        .pj-dd-item i {
            font-size: .68rem;
            color: var(--ink5);
        }

        .pj-dd-empty {
            padding: 16px 18px;
            font-family: var(--fb);
            font-size: .82rem;
            color: var(--ink3);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* suggestions */
        .pj-sug-label {
            font-family: var(--fh);
            font-size: .68rem;
            font-weight: 800;
            color: var(--ink3);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pj-sug-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .pj-sug-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pj-sug {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 7px 14px;
            font-family: var(--fh);
            font-size: .76rem;
            font-weight: 700;
            color: var(--ink2);
            cursor: pointer;
            transition: all .18s var(--ease);
        }

        .pj-sug:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
            transform: translateY(-1px);
            box-shadow: var(--sh-xs);
        }

        .pj-sug i {
            font-size: .62rem;
        }

        /* ══════════════════════════════
       SCREENING QUESTIONS
    ══════════════════════════════ */
        .pj-sq-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 22px;
        }

        .pj-sq-header-left {}

        .pj-sq-title {
            font-family: var(--fh);
            font-size: .95rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .pj-sq-title-sub {
            font-family: var(--fb);
            font-size: .78rem;
            color: var(--ink3);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pj-sq-add {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--blue-lt), #e8f0fe);
            border: 1.5px solid var(--blue-mid);
            border-radius: var(--r-sm);
            padding: 10px 20px;
            font-family: var(--fh);
            font-size: .82rem;
            font-weight: 700;
            color: var(--blue);
            cursor: pointer;
            transition: all .2s var(--ease);
        }

        .pj-sq-add:hover {
            background: var(--blue-mid);
            transform: translateY(-1px);
            box-shadow: var(--sh-sm);
        }

        .pj-sq-empty {
            border: 2px dashed var(--border);
            border-radius: var(--r-lg);
            padding: 50px 24px;
            text-align: center;
            color: var(--ink4);
        }

        .pj-sq-empty-ico {
            font-size: 2.2rem;
            opacity: .25;
            display: block;
            margin-bottom: 14px;
        }

        .pj-sq-empty p {
            font-family: var(--fb);
            font-size: .86rem;
            line-height: 1.6;
        }

        .pj-sq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pj-sq-block {
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
            box-shadow: var(--sh-xs);
            transition: box-shadow .2s var(--ease);
            animation: tabIn .25s var(--ease);
        }

        .pj-sq-block:hover {
            box-shadow: var(--sh-md);
        }

        .pj-sq-block-top {
            background: linear-gradient(135deg, var(--surface), #fff);
            padding: 13px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1.5px solid var(--border);
        }

        .pj-sq-num {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--fh);
            font-size: .72rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .pj-sq-prev {
            font-family: var(--fh);
            font-size: .84rem;
            font-weight: 700;
            color: var(--ink2);
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pj-sq-badge {
            font-family: var(--fh);
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .pj-sq-badge.mc {
            background: var(--purple-lt);
            color: var(--purple);
        }

        .pj-sq-badge.tx {
            background: var(--green-lt);
            color: var(--green);
        }

        .pj-sq-badge.yn {
            background: var(--amber-lt);
            color: var(--amber);
        }

        .pj-sq-del {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--ink4);
            cursor: pointer;
            font-size: .72rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .18s;
        }

        .pj-sq-del:hover {
            border-color: var(--red-mid);
            color: var(--red);
            background: var(--red-lt);
        }

        .pj-sq-body {
            padding: 20px 18px;
        }

        .pj-sq-type-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 18px;
        }

        .pj-sq-topt input {
            display: none;
        }

        .pj-sq-topt label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 2px solid var(--border);
            border-radius: var(--r-sm);
            padding: 10px;
            font-family: var(--fh);
            font-size: .78rem;
            font-weight: 700;
            color: var(--ink3);
            cursor: pointer;
            transition: all .18s;
        }

        .pj-sq-topt input:checked+label {
            border-color: var(--blue);
            background: var(--blue-lt);
            color: var(--blue);
        }

        .pj-sq-topt label:hover {
            border-color: var(--blue-mid);
        }

        .pj-sq-opts-lbl {
            font-family: var(--fh);
            font-size: .66rem;
            font-weight: 800;
            color: var(--ink4);
            letter-spacing: .09em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .pj-sq-opt-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .pj-opt-ltr {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--fh);
            font-size: .7rem;
            font-weight: 800;
            color: var(--ink3);
            flex-shrink: 0;
        }

        .pj-opt-field {
            flex: 1;
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 9px 13px;
            font-family: var(--fb);
            font-size: .85rem;
            color: var(--ink);
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .pj-opt-field:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-ring);
        }

        .pj-opt-rm {
            background: none;
            border: none;
            color: var(--ink4);
            cursor: pointer;
            font-size: .72rem;
            padding: 5px 7px;
            border-radius: 6px;
            transition: all .15s;
        }

        .pj-opt-rm:hover {
            color: var(--red);
            background: var(--red-lt);
        }

        .pj-add-opt {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px dashed var(--border);
            border-radius: var(--r-sm);
            background: none;
            padding: 8px 14px;
            margin-top: 6px;
            font-family: var(--fh);
            font-size: .77rem;
            font-weight: 700;
            color: var(--ink3);
            cursor: pointer;
            transition: all .18s;
        }

        .pj-add-opt:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .pj-txt-note {
            background: var(--surface);
            border: 1.5px dashed var(--border);
            border-radius: var(--r-sm);
            padding: 13px 16px;
            font-family: var(--fb);
            font-size: .82rem;
            color: var(--ink4);
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
        }

        /* preset screening questions */
        .pj-sq-presets {
            margin-bottom: 20px;
        }

        .pj-preset-lbl {
            font-family: var(--fh);
            font-size: .7rem;
            font-weight: 800;
            color: var(--ink3);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .pj-preset-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pj-preset-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 7px 13px;
            font-family: var(--fh);
            font-size: .74rem;
            font-weight: 700;
            color: var(--ink2);
            cursor: pointer;
            transition: all .18s var(--ease);
        }

        .pj-preset-btn i {
            font-size: .62rem;
            color: var(--blue);
        }

        .pj-preset-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
            transform: translateY(-1px);
        }

        /* ══════════════════════════════
       REVIEW TAB
    ══════════════════════════════ */
        .pj-rev-hero {
            background: linear-gradient(140deg, #0f2460, #1d4ed8 55%, #3b82f6);
            border-radius: var(--r-md);
            padding: 24px 26px;
            color: #fff;
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
        }

        .pj-rev-hero::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            pointer-events: none;
        }

        .pj-rev-title {
            font-family: var(--fh);
            font-size: 1.25rem;
            font-weight: 900;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .pj-rev-co {
            font-size: .84rem;
            color: rgba(255, 255, 255, .72);
            margin-bottom: 13px;
            position: relative;
            z-index: 1;
        }

        .pj-rev-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .pj-rev-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 100px;
            padding: 4px 13px;
            font-family: var(--fh);
            font-size: .72rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .pj-rev-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }

        .pj-rev-box {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 13px 16px;
        }

        .pj-rev-box.full {
            grid-column: 1 / -1;
        }

        .pj-rev-lbl {
            font-family: var(--fh);
            font-size: .62rem;
            font-weight: 800;
            color: var(--ink4);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
        }

        .pj-rev-val {
            font-family: var(--fh);
            font-size: .88rem;
            font-weight: 700;
            color: var(--ink);
        }

        .pj-terms-box {
            background: var(--green-lt);
            border: 1.5px solid var(--green-mid);
            border-radius: var(--r-sm);
            padding: 15px 18px;
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .pj-terms-box input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 1px;
            accent-color: var(--blue);
            cursor: pointer;
            flex-shrink: 0;
        }

        .pj-terms-box label {
            font-family: var(--fb);
            font-size: .84rem;
            color: #065f46;
            line-height: 1.6;
            cursor: pointer;
        }

        .pj-terms-box a {
            color: var(--blue);
            font-weight: 700;
        }

        /* ══════════════════════════════
       FOOTER NAV
    ══════════════════════════════ */
        .pj-footer {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            padding: 16px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            box-shadow: var(--sh-sm);
            margin-bottom: 20px;
        }

        .pj-footer-info {
            font-family: var(--fb);
            font-size: .82rem;
            color: var(--ink3);
            font-weight: 500;
        }

        .pj-footer-info strong {
            color: var(--blue);
            font-family: var(--fh);
            font-weight: 800;
        }

        .pj-footer-right {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-draft {
            background: none;
            border: none;
            cursor: pointer;
            font-family: var(--fb);
            font-size: .8rem;
            font-weight: 600;
            color: var(--ink3);
            padding: 9px 14px;
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color .18s;
        }

        .btn-draft:hover {
            color: var(--blue);
        }

        .btn-back {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 10px 20px;
            font-family: var(--fh);
            font-size: .85rem;
            font-weight: 700;
            color: var(--ink2);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all .18s;
        }

        .btn-back:hover {
            border-color: var(--ink3);
            color: var(--ink);
        }

        .btn-next {
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            color: var(--white);
            border: none;
            border-radius: var(--r-sm);
            padding: 11px 26px;
            font-family: var(--fh);
            font-size: .9rem;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all .2s var(--ease);
            box-shadow: 0 2px 8px rgba(37, 99, 235, .25);
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
        }

        .btn-publish {
            background: linear-gradient(135deg, #0f2460, var(--blue-d), var(--blue));
            color: var(--white);
            border: none;
            border-radius: var(--r-sm);
            padding: 12px 30px;
            font-family: var(--fh);
            font-size: .92rem;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 9px;
            transition: all .25s var(--ease);
            box-shadow: 0 4px 16px rgba(37, 99, 235, .3);
            letter-spacing: -.2px;
        }

        .btn-publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37, 99, 235, .4);
        }

        .btn-publish:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ══════════════════════════════
       RESPONSIVE
    ══════════════════════════════ */
        @media(max-width:720px) {
            .pj-hero {
                padding: 24px 22px 88px;
            }

            .pj-wizard-card {
                padding: 16px 14px;
            }

            .pj-step-name {
                font-size: .52rem;
            }

            .pj-card-body {
                padding: 18px 16px;
            }

            .pj-card-head {
                padding: 14px 16px;
            }

            .pj-row2,
            .pj-row3,
            .pj-type-grid,
            .pj-sq-type-row {
                grid-template-columns: 1fr;
            }

            .pj-type2 {
                grid-template-columns: 1fr 1fr;
            }

            .pj-salary-row {
                grid-template-columns: 1fr 1fr;
            }

            .pj-salary-sep,
            .pj-salary-tag {
                display: none;
            }

            .pj-rev-grid {
                grid-template-columns: 1fr;
            }

            .pj-footer {
                flex-direction: column;
            }

            .pj-footer-right {
                width: 100%;
                justify-content: flex-end;
            }

            .btn-next,
            .btn-back,
            .btn-publish {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pj-wrap">

        {{-- ═══════════════════ HERO ═══════════════════ --}}
        <div class="pj-hero">
            <div class="pj-hero-orb1"></div>
            <div class="pj-hero-orb2"></div>
            <div class="pj-hero-grid"></div>
            <div class="pj-hero-inner">
                <div class="pj-hero-eyebrow">
                    <span></span> Employer Portal &mdash; Post a Job
                </div>
                <div class="pj-hero-title">
                    Create a <span>New Job</span> Opening
                </div>
                <div class="pj-hero-sub">
                    Reach thousands of skilled professionals across Tamil Nadu. Complete the 5 steps below and publish your
                    listing in minutes.
                </div>
                @if (isset($activePlan))
                    <div class="pj-plan-badge">
                        <i class="fa-solid fa-circle-check" style="color:#4ade80;"></i>
                        Active Plan: <strong>{{ $activePlan->name }}</strong>
                        &middot; Expires {{ \Carbon\Carbon::parse($activePlan->expires_at)->format('d M Y') }}
                    </div>
                @else
                    <div class="pj-plan-badge" style="background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.35);">
                        <i class="fa-solid fa-triangle-exclamation" style="color:#fca5a5;"></i>
                        <span style="color:#fca5a5;">No active plan — <a href="{{ route('employer.billing') }}"
                                style="color:#fde68a;font-weight:800;">Purchase a plan</a> to post jobs.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- ═══════════════════ WIZARD ═══════════════════ --}}
        <div class="pj-wizard-shell">
            <div class="pj-wizard-card">
                <div class="pj-wizard-track">
                    <div class="pj-wz-fill" id="wizFill"></div>
                    @php
                        $wsteps = [
                            ['fa-file-lines', 'Details'],
                            ['fa-location-dot', 'Location'],
                            ['fa-circle-info', 'Job & Skills'],
                            ['fa-clipboard-question', 'Screening'],
                            ['fa-eye', 'Review'],
                        ];
                    @endphp
                    @foreach ($wsteps as $i => $ws)
                        <div class="pj-step {{ $i === 0 ? 'active' : '' }}" id="pjStep{{ $i + 1 }}">
                            <div class="pj-step-bubble" id="pjBub{{ $i + 1 }}">
                                <i class="fa-solid {{ $ws[0] }}"></i>
                            </div>
                            <div class="pj-step-name">{{ $ws[1] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ═══════════════════ FORM ═══════════════════ --}}
        <div class="pj-form-area">
            <form method="POST" action="{{ route('employer.jobs.store') }}" id="pjForm" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="pj-alert show">
                        <i class="fa-solid fa-circle-exclamation" style="font-size:1rem;flex-shrink:0;margin-top:1px;"></i>
                        <div>
                            <strong>Please fix the following:</strong>
                            <ul style="margin:5px 0 0 16px;padding:0;">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- ══════════ STEP 1 — BASIC DETAILS ══════════ --}}
                <div class="pj-tab active" id="pjTab1">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-file-lines"></i></div>
                            <div class="pj-head-text">
                                <div class="pj-head-title">Basic Job Details</div>
                                <div class="pj-head-sub">Title, category, industry and full job description</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert1">
                                <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                                <span>Please fill in all required fields before continuing.</span>
                            </div>

                            {{-- Job Title --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="job_title">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-briefcase"></i></span>
                                    Job Title <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix"><i class="fa-solid fa-briefcase"></i></div>
                                    <input type="text" id="job_title" name="job_title"
                                        class="pj-input @error('job_title') err @enderror"
                                        placeholder="e.g. Senior Sales Executive, PHP Developer, Electrician"
                                        value="{{ old('job_title') }}" />
                                </div>
                                <div class="pj-ferr @error('job_title') show @enderror" id="err-job_title">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('job_title')
                                            {{ $message }}
                                        @else
                                            Job title is required (min. 3 characters).
                                        @enderror
                                    </span>
                                </div>
                                <div class="pj-hint"><i class="fa-solid fa-lightbulb"></i> Be specific — "Senior PHP
                                    Developer" attracts better matches than just "Developer"</div>
                            </div>

                            {{-- Category + Industry --}}
                            <div class="pj-row2">
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="job_category">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-layer-group"></i></span>
                                        Category <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-layer-group"></i></div>
                                        <select id="job_category" name="job_category"
                                            class="pj-input @error('job_category') err @enderror">
                                            <option value="" disabled {{ old('job_category') ? '' : 'selected' }}>
                                                Select Category</option>
                                            @foreach (['IT & Software', 'Technical & Trade', 'Sales & Marketing', 'Office & Admin', 'Driver & Logistics', 'Manufacturing', 'Healthcare', 'Education', 'Hospitality', 'Other'] as $cat)
                                                <option value="{{ $cat }}"
                                                    {{ old('job_category') === $cat ? 'selected' : '' }}>{{ $cat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('job_category') show @enderror" id="err-job_category">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select a category.</span>
                                    </div>
                                </div>
                                <!-- <div class="pj-fg">
                                    <label class="pj-lbl" for="industry_type">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-industry"></i></span>
                                        Industry <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-industry"></i></div>
                                        <select id="industry_type" name="industry_type"
                                            class="pj-input @error('industry_type') err @enderror">
                                            <option value="" disabled {{ old('industry_type') ? '' : 'selected' }}>
                                                Select Industry</option>
                                            @foreach (['Automobile', 'Banking & Finance', 'Construction', 'Education & Training', 'FMCG / Retail', 'Healthcare / Pharma', 'Hospitality', 'IT / Software', 'Logistics / Transport', 'Manufacturing', 'Textile / Garments', 'Other'] as $ind)
                                                <option value="{{ $ind }}"
                                                    {{ old('industry_type') === $ind ? 'selected' : '' }}>
                                                    {{ $ind }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('industry_type') show @enderror" id="err-industry_type">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select an
                                            industry.</span>
                                    </div>
                                </div> -->
                            </div>

                            {{-- Description --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="description">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-file-lines"></i></span>
                                    Job Description <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix top"><i class="fa-solid fa-file-lines"></i></div>
                                    <textarea id="description" name="description" class="pj-input @error('description') err @enderror"
                                        style="padding-left:44px;min-height:140px;" maxlength="3000"
                                        placeholder="Describe the role, responsibilities, company culture and work environment..."
                                        oninput="charCount(this,'descCnt',3000)">{{ old('description') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;margin-top:6px;align-items:center;">
                                    <div class="pj-ferr @error('description') show @enderror" id="err-description">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Minimum 50 characters
                                            required.</span>
                                    </div>
                                    <div class="pj-counter" id="descCnt">0 / 3000</div>
                                </div>
                            </div>

                            {{-- Responsibilities --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="responsibilities">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-list-check"></i></span>
                                    Key Responsibilities <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix top"><i class="fa-solid fa-list-check"></i></div>
                                    <textarea id="responsibilities" name="responsibilities" class="pj-input @error('responsibilities') err @enderror"
                                        style="padding-left:44px;" maxlength="2000"
                                        placeholder="• Manage daily operations and team coordination&#10;• Achieve monthly sales targets&#10;• Coordinate with clients and vendors"
                                        oninput="charCount(this,'respCnt',2000)">{{ old('responsibilities') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;margin-top:6px;align-items:center;">
                                    <div class="pj-ferr @error('responsibilities') show @enderror"
                                        id="err-responsibilities">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please enter responsibilities
                                            (min. 20 characters).</span>
                                    </div>
                                    <div class="pj-counter" id="respCnt">0 / 2000</div>
                                </div>
                            </div>

                            {{-- Benefits --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="benefits">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-gift"></i></span>
                                    Benefits &amp; Perks <span class="pj-opt">Optional</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix top"><i class="fa-solid fa-gift"></i></div>
                                    <textarea id="benefits" name="benefits" class="pj-input" style="padding-left:44px;min-height:90px;"
                                        maxlength="500"
                                        placeholder="e.g. Health Insurance, Performance Bonus, PF &amp; ESI, Travel Allowance, Free Meals..."
                                        oninput="charCount(this,'benCnt',500)">{{ old('benefits') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:flex-end;margin-top:6px;">
                                    <div class="pj-counter" id="benCnt">0 / 500</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>1</strong> of 5 &mdash; Basic Details</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-draft" onclick="saveDraft(this)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="btn-next" onclick="nextStep(1)">Location &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 2 — LOCATION ══════════ --}}
                <div class="pj-tab" id="pjTab2">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="pj-head-text">
                                <div class="pj-head-title">Job Location</div>
                                <div class="pj-head-sub">State, district and city/town for this position</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert2">
                                <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                                <span>Please fill in all location fields.</span>
                            </div>
                            <div class="pj-row3">
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="state">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-map"></i></span>
                                        State <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-map"></i></div>
                                        <select id="state" name="state"
                                            class="pj-input @error('state') err @enderror">
                                            <option value="" disabled selected>Select State</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Rajasthan">Rajasthan</option>
                                                <option value="Sikkim">Sikkim</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Tripura">Tripura</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                <option value="Uttarakhand">Uttarakhand</option>
                                                <option value="West Bengal">West Bengal</option>

                                                <!-- Union Territories -->
                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh">Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu">
                                                    Dadra and Nagar Haveli and Daman and Diu
                                                </option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option value="Ladakh">Ladakh</option>
                                                <option value="Lakshadweep">Lakshadweep</option>
                                                <option value="Puducherry">Puducherry</option>
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('state') show @enderror" id="err-state">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select a state.</span>
                                    </div>
                                </div>
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="district">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-location-dot"></i></span>
                                        District <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-location-dot"></i></div>
                                        <select id="district" name="district"
                                            class="pj-input @error('district') err @enderror">
                                            
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('district') show @enderror" id="err-district">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                            district.</span>
                                    </div>
                                </div>
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="city">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-city"></i></span>
                                        City / Town <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-city"></i></div>
                                        <input type="text" id="city" name="city"
                                            class="pj-input @error('city') err @enderror" placeholder="e.g. Coimbatore"
                                            value="{{ old('city') }}" />
                                    </div>
                                    <div class="pj-ferr @error('city') show @enderror" id="err-city">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please enter the city / town
                                            name.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>2</strong> of 5 &mdash; Location</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-draft" onclick="saveDraft(this)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="btn-back" onclick="prevStep(2)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(2)">Job Info &amp; Skills &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 3 — JOB INFO + SKILLS (MERGED) ══════════ --}}
                <div class="pj-tab" id="pjTab3">

                    {{-- Job Information card --}}
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-circle-info"></i></div>
                            <div class="pj-head-text">
                                <div class="pj-head-title">Job Information</div>
                                <div class="pj-head-sub">Experience, salary, vacancies, type, education and required skills
                                </div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert3">
                                <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                                <span>Please complete all required job information.</span>
                            </div>

                            <div class="pj-row2">
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="experience_required">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-briefcase"></i></span>
                                        Experience Required <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-briefcase"></i></div>
                                        <select id="experience_required" name="experience_required"
                                            class="pj-input @error('experience_required') err @enderror">
                                            <option value="" disabled
                                                {{ old('experience_required') ? '' : 'selected' }}>Select Experience
                                            </option>
                                            @foreach (['Fresher', 'Less than 1 year', '1-2 Years', '2-3 Years', '3-5 Years', '5-8 Years', '8-10 Years', '10+ Years'] as $ex)
                                                <option value="{{ $ex }}"
                                                    {{ old('experience_required') === $ex ? 'selected' : '' }}>
                                                    {{ $ex }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('experience_required') show @enderror"
                                        id="err-experience_required">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select experience
                                            level.</span>
                                    </div>
                                </div>
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="vacancies">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-users"></i></span>
                                        Number of Vacancies <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-users"></i></div>
                                        <input type="number" id="vacancies" name="vacancies"
                                            class="pj-input @error('vacancies') err @enderror" placeholder="e.g. 3"
                                            min="1" max="100" value="{{ old('vacancies', 1) }}" />
                                    </div>
                                    <div class="pj-ferr @error('vacancies') show @enderror" id="err-vacancies">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>At least 1 vacancy
                                            required.</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Salary Range Dropdown --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="salary_range">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                    Monthly Salary Range <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                                    <select id="salary_range" name="salary_range"
                                        class="pj-input @error('salary_range') err @enderror">
                                        <option value="" disabled {{ old('salary_range') ? '' : 'selected' }}>Select
                                            Salary Range</option>
                                        @php
                                            $salaryRanges = [
                                                'Not Disclosed' => 'Not Disclosed',
                                                '₹0 – ₹8,000 /mo' => '0-8000',
                                                '₹8,000 – ₹12,000 /mo' => '8000-12000',
                                                '₹12,000 – ₹15,000 /mo' => '12000-15000',
                                                '₹15,000 – ₹20,000 /mo' => '15000-20000',
                                                '₹20,000 – ₹25,000 /mo' => '20000-25000',
                                                '₹25,000 – ₹30,000 /mo' => '25000-30000',
                                                '₹30,000 – ₹40,000 /mo' => '30000-40000',
                                                '₹40,000 – ₹50,000 /mo' => '40000-50000',
                                                '₹50,000 – ₹70,000 /mo' => '50000-70000',
                                                '₹70,000 – ₹1,00,000 /mo' => '70000-100000',
                                                '₹1,00,000+ /mo' => '100000+',
                                            ];
                                        @endphp
                                        @foreach ($salaryRanges as $lbl => $val)
                                            <option value="{{ $val }}"
                                                {{ old('salary_range') === $val ? 'selected' : '' }}>{{ $lbl }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="pj-ferr @error('salary_range') show @enderror" id="err-salary_range">
                                    <i class="fa-solid fa-circle-exclamation"></i><span>Please select a salary
                                        range.</span>
                                </div>
                                <div class="pj-hint"><i class="fa-solid fa-circle-info"></i> Select "Not Disclosed" if you
                                    prefer not to show salary publicly</div>
                            </div>

                            {{-- Education --}}
                            <div class="pj-fg">
                                <label class="pj-lbl" for="education">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-graduation-cap"></i></span>
                                    Minimum Education <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <div class="pj-iw-prefix"><i class="fa-solid fa-graduation-cap"></i></div>
                                    <select id="education" name="education"
                                        class="pj-input @error('education') err @enderror">
                                        <option value="" disabled {{ old('education') ? '' : 'selected' }}>Select
                                            Education Requirement</option>
                                       @foreach($qualifications as $item)
                                            <option value="{{ $item->qualification }}">
                                                {{ $item->qualification_label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="pj-ferr @error('education') show @enderror" id="err-education">
                                    <i class="fa-solid fa-circle-exclamation"></i><span>Please select education
                                        requirement.</span>
                                </div>
                            </div>

                            {{-- Job Type --}}
                            <div class="pj-fg">
                                <label class="pj-lbl">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-clock"></i></span>
                                    Job Type <span class="pj-req">*</span>
                                </label>
                                <div class="pj-type-grid">
                                    @foreach ([['Full Time', 'fa-clock', 'Standard working hours, Monday to Saturday'], ['Part Time', 'fa-hourglass-half', 'Flexible or reduced hours schedule'], ['Contract', 'fa-file-contract', 'Fixed-term or project-based engagement']] as [$jt, $ico, $desc])
                                        <div class="pj-type-opt">
                                            <input type="radio" id="jt_{{ Str::slug($jt) }}" name="job_type"
                                                value="{{ $jt }}"
                                                {{ old('job_type', 'Full Time') === $jt ? 'checked' : '' }}>
                                            <label for="jt_{{ Str::slug($jt) }}">
                                                <div class="pj-type-ico"><i class="fa-solid {{ $ico }}"></i>
                                                </div>
                                                <div class="pj-type-nm">{{ $jt }}</div>
                                                <div class="pj-type-ds">{{ $desc }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="pj-fg">
                                <label class="pj-lbl">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-toggle-on"></i></span>
                                    Job Status <span class="pj-req">*</span>
                                </label>
                                <div class="pj-type-grid pj-type2" style="max-width:460px;">
                                    @foreach ([
            'active' => ['Active', 'fa-circle-check', 'Visible to job seekers immediately'],
            'inactive' => ['Inactive', 'fa-circle-pause', 'Hidden — publish later'],
        ] as $val => [$lbl, $ico, $desc])
                                        <div class="pj-type-opt">
                                            <input type="radio" id="status_{{ $val }}" name="status"
                                                value="{{ $val }}"
                                                {{ old('status', 'active') === $val ? 'checked' : '' }}>
                                            <label for="status_{{ $val }}">
                                                <div class="pj-type-ico"><i class="fa-solid {{ $ico }}"></i>
                                                </div>
                                                <div class="pj-type-nm">{{ $lbl }}</div>
                                                <div class="pj-type-ds">{{ $desc }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ── SKILLS SECTION (merged inside same card) ── --}}
                            <div class="pj-sec-divider">
                                <hr>
                                <div class="pj-sec-lbl"><i class="fa-solid fa-tags"></i> Required Skills</div>
                                <hr>
                            </div>

                            <div class="pj-fg">
                                <label class="pj-lbl">
                                    <span class="pj-lbl-ico"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                                    Skills <span class="pj-req">*</span>
                                </label>
                                <div class="pj-skills-wrap">
                                    <div class="pj-skills-field" id="skillsField"
                                        onclick="document.getElementById('skillInput').focus()">
                                        <div class="pj-chips-row" id="skillChips"></div>
                                        <input type="text" id="skillInput" class="pj-skills-input"
                                            placeholder="Type a skill and press Enter, or pick from suggestions below..."
                                            autocomplete="off" oninput="filterSkills(this.value)"
                                            onkeydown="handleSkillKey(event)" onfocus="openSkillsDD()"
                                            onblur="setTimeout(closeSkillsDD,200)" />
                                    </div>
                                    <div class="pj-skills-dd" id="skillsDD"></div>
                                </div>
                               
                                <input type="hidden" name="skills" id="skillsHidden" value='@json(old("skills", []))' />
                                <div class="pj-ferr" id="err-skills"><i
                                        class="fa-solid fa-circle-exclamation"></i><span>Please add at least one required
                                        skill.</span></div>
                                <div class="pj-hint" style="margin-top:8px;"><i class="fa-solid fa-circle-info"></i> Add
                                    up to 10 skills. Press Enter or comma to add a custom skill.</div>
                            </div>

                            <div style="margin-top:18px;">
                                <div class="pj-sug-label"><i class="fa-solid fa-fire" style="color:var(--amber);"></i>
                                    Popular Suggestions</div>
                                <div class="pj-sug-grid">
                                    @foreach ($skills as $skill)
                                        <button type="button" class="pj-sug" onclick="addSkill('{{ $skill->skill_name }}')">
                                            <i class="fa-solid fa-plus"></i> {{ $skill->skill_name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>{{-- /card-body --}}
                    </div>{{-- /card --}}

                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>3</strong> of 5 &mdash; Job Info &amp; Skills</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-draft" onclick="saveDraft(this)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="btn-back" onclick="prevStep(3)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(3)">Screening &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 4 — SCREENING QUESTIONS ══════════ --}}
                <div class="pj-tab" id="pjTab4">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-clipboard-question"></i></div>
                            <div class="pj-head-text">
                                <div class="pj-head-title">Screening Questions</div>
                                <div class="pj-head-sub">Candidates must answer these when applying — optional but highly
                                    effective</div>
                            </div>
                        </div>
                        <div class="pj-card-body">

                            {{-- Pre-set question suggestions --}}
                            <div class="pj-sq-presets">
                                <div class="pj-preset-lbl"><i class="fa-solid fa-wand-magic-sparkles"
                                        style="color:var(--blue);"></i> Quick-add preset questions</div>
                                <div class="pj-preset-grid" id="presetGrid">
                                    @php
                                        $presets = [
                                            ['Do you have a valid driving licence?', 'select', ['Yes', 'No']],
                                            [
                                                'Are you comfortable with night / rotational shifts?',
                                                'select',
                                                ['Yes', 'No', 'Depends on the schedule'],
                                            ],
                                            ['What is your current salary (CTC per month)?', 'input', []],
                                            ['How many years of relevant experience do you have?', 'input', []],
                                            [
                                                'Are you willing to relocate for this position?',
                                                'select',
                                                ['Yes, open to relocation', 'No, prefer local', 'Need more details'],
                                            ],
                                            [
                                                'Do you have a two-wheeler / vehicle?',
                                                'select',
                                                ['Yes, own vehicle', 'No'],
                                            ],
                                            [
                                                'When can you join?',
                                                'select',
                                                [
                                                    'Immediately',
                                                    'Within 15 days',
                                                    'Within 30 days',
                                                    'More than 30 days',
                                                ],
                                            ],
                                            [
                                                'Do you have experience with Tally / ERP software?',
                                                'select',
                                                ['Yes', 'No', 'Currently learning'],
                                            ],
                                            [
                                                'What is your highest qualification?',
                                                'select',
                                                ['10th Pass', '12th Pass', 'Diploma', 'Degree', 'Post-Graduate'],
                                            ],
                                            ['Why are you interested in this role?', 'input', []],
                                        ];
                                    @endphp
                                    @foreach ($presets as $pi => [$pq, $pt, $po])
                                        <button type="button" class="pj-preset-btn"
                                            onclick='addPresetSQ({{ $pi }})'>
                                            <i class="fa-solid fa-plus"></i> {{ Str::limit($pq, 38) }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="pj-sec-divider" style="margin:18px 0 20px;">
                                <hr>
                                <div class="pj-sec-lbl"><i class="fa-solid fa-list-check"></i> Your Questions</div>
                                <hr>
                                <button type="button" class="pj-sq-add" onclick="addSQ()">
                                    <i class="fa-solid fa-circle-plus"></i> Add Custom
                                </button>
                            </div>

                            <div class="pj-sq-list" id="sqList"></div>
                            <div class="pj-sq-empty" id="sqEmpty">
                                <span class="pj-sq-empty-ico"><i class="fa-solid fa-clipboard-question"></i></span>
                                <p>No screening questions yet.<br>Use a preset above or click <strong>Add Custom</strong> to
                                    create your own.</p>
                            </div>

                            <input type="hidden" name="screening_questions" id="sqData"
                                value="{{ old('screening_questions', '[]') }}" />
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>4</strong> of 5 &mdash; Screening Questions</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-draft" onclick="saveDraft(this)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="btn-back" onclick="prevStep(4)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(4)">Review &amp; Publish &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 5 — REVIEW ══════════ --}}
                <div class="pj-tab" id="pjTab5">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-eye"></i></div>
                            <div class="pj-head-text">
                                <div class="pj-head-title">Review &amp; Publish</div>
                                <div class="pj-head-sub">Confirm all details before your listing goes live</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-rev-hero">
                                <div class="pj-rev-title" id="rev-title">—</div>
                                <div class="pj-rev-co">
                                    {{ auth()->user()->company->name ?? (auth()->user()->name ?? 'Your Company') }}
                                    &middot; <span id="rev-location">—</span></div>
                                <div class="pj-rev-chips" id="rev-chips"></div>
                            </div>

                            <div class="pj-rev-grid">
                                @foreach ([['rev-category', 'Category'], ['rev-industry', 'Industry'], ['rev-exp', 'Experience'], ['rev-salary', 'Salary Range'], ['rev-type', 'Job Type'], ['rev-education', 'Education'], ['rev-vacancies', 'Vacancies'], ['rev-status', 'Status']] as [$rid, $rlbl])
                                    <div class="pj-rev-box">
                                        <div class="pj-rev-lbl">{{ $rlbl }}</div>
                                        <div class="pj-rev-val" id="{{ $rid }}">—</div>
                                    </div>
                                @endforeach
                                <div class="pj-rev-box full">
                                    <div class="pj-rev-lbl">Skills</div>
                                    <div class="pj-rev-val" id="rev-skills">—</div>
                                </div>
                                <div class="pj-rev-box full">
                                    <div class="pj-rev-lbl">Screening Questions</div>
                                    <div class="pj-rev-val" id="rev-sq">None added</div>
                                </div>
                            </div>

                            <div class="pj-terms-box">
                                <input type="checkbox" id="termsCheck" name="terms" value="1" />
                                <label for="termsCheck">
                                    I confirm that all job details are accurate and comply with LinearJobs'
                                    <a href="{{ route('home') }}" target="_blank">Terms &amp; Conditions</a>.
                                    I agree not to post fraudulent, misleading or illegal job listings.
                                </label>
                            </div>
                            <div class="pj-ferr" id="err-terms" style="margin-top:8px;">
                                <i class="fa-solid fa-circle-exclamation"></i><span>Please accept the terms and conditions
                                    to publish.</span>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>5</strong> of 5 &mdash; Final Review</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-back" onclick="prevStep(5)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="submit" class="btn-publish" id="publishBtn">
                                <i class="fa-solid fa-rocket"></i> Publish Job Now
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>{{-- /form-area --}}
    </div>{{-- /wrap --}}
@endsection

@push('scripts')
    <script>
      @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if ($errors->any())
        toastr.error("Please fix the errors in the form.");
    @endif
        (function() {
            'use strict';
            /* ═══════════════════════════════
               CONSTANTS
            ═══════════════════════════════ */
            var TOTAL = 5;
            var STEP_ICONS = ['fa-file-lines', 'fa-location-dot', 'fa-circle-info', 'fa-clipboard-question', 'fa-eye'];
            var currentStep = 1;

            /* ═══════════════════════════════
               WIZARD NAV
            ═══════════════════════════════ */
            function showStep(n) {
                document.querySelectorAll('.pj-tab').forEach(t => t.classList.remove('active'));
                document.getElementById('pjTab' + n).classList.add('active');

                document.querySelectorAll('.pj-step').forEach(s => {
                    var sn = +s.id.replace('pjStep', '');
                    s.classList.remove('active', 'done');
                    var bub = document.getElementById('pjBub' + sn);
                    if (!bub) return;
                    if (sn === n) {
                        s.classList.add('active');
                        bub.innerHTML = '<i class="fa-solid ' + STEP_ICONS[sn - 1] + '"></i>';
                    } else if (sn < n) {
                        s.classList.add('done');
                        bub.innerHTML = '<i class="fa-solid fa-check"></i>';
                    } else {
                        bub.innerHTML = '<i class="fa-solid ' + STEP_ICONS[sn - 1] + '"></i>';
                    }
                });

                var fill = document.getElementById('wizFill');
                if (fill) fill.style.width = (((n - 1) / (TOTAL - 1)) * 100) + '%';

                currentStep = n;
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                if (n === TOTAL) buildReview();
            }

            window.nextStep = function(from) {
                if (validateStep(from)) showStep(from + 1);
            };
            window.prevStep = function(from) {
                showStep(from - 1);
            };

            /* ═══════════════════════════════
               VALIDATION
            ═══════════════════════════════ */
            function gv(name) {
                var el = document.querySelector('[name="' + name + '"]');
                return el ? el.value.trim() : '';
            }

            function showFE(id, msg) {
                var el = document.getElementById(id);
                var er = document.getElementById('err-' + id);
                if (el) el.classList.add('err');
                if (er) {
                    er.classList.add('show');
                    var sp = er.querySelector('span');
                    if (sp && msg) sp.textContent = msg;
                }
            }

            function clearTab(n) {
                var tab = document.getElementById('pjTab' + n);
                if (!tab) return;
                tab.querySelectorAll('.pj-ferr').forEach(e => e.classList.remove('show'));
                tab.querySelectorAll('.pj-input').forEach(i => i.classList.remove('err'));
                var al = document.getElementById('alert' + n);
                if (al) al.classList.remove('show');
            }

            function validateStep(n) {
                clearTab(n);
                var ok = true;
                var al = document.getElementById('alert' + n);

                if (n === 1) {
                    if (gv('job_title').length < 3) {
                        showFE('job_title', 'Job title must be at least 3 characters.');
                        ok = false;
                    }
                    if (!gv('job_category')) {
                        showFE('job_category', 'Please select a category.');
                        ok = false;
                    }
                    
                    if ((document.getElementById('description')?.value.trim() || '').length < 50) {
                        showFE('description', 'Minimum 50 characters required.');
                        ok = false;
                    }
                    if ((document.getElementById('responsibilities')?.value.trim() || '').length < 20) {
                        showFE('responsibilities', 'Minimum 20 characters required.');
                        ok = false;
                    }
                }
                if (n === 2) {
                    if (!gv('state')) {
                        showFE('state', 'Please select a state.');
                        ok = false;
                    }
                    if (!gv('district')) {
                        showFE('district', 'Please select a district.');
                        ok = false;
                    }
                    if (gv('city').length < 2) {
                        showFE('city', 'Please enter the city / town name.');
                        ok = false;
                    }
                }
                if (n === 3) {
                    if (!gv('experience_required')) {
                        showFE('experience_required', 'Please select experience level.');
                        ok = false;
                    }
                    var vac = document.getElementById('vacancies')?.value.trim() || '';
                    if (!vac || parseInt(vac) < 1) {
                        showFE('vacancies', 'At least 1 vacancy required.');
                        ok = false;
                    }
                    if (!gv('salary_range')) {
                        showFE('salary_range', 'Please select a salary range.');
                        ok = false;
                    }
                    if (!gv('education')) {
                        showFE('education', 'Please select education requirement.');
                        ok = false;
                    }
                    document.getElementById('skillsHidden').value = JSON.stringify(selectedSkills);
                    if (selectedSkills.length === 0) {
                        document.getElementById('err-skills').classList.add('show');
                        ok = false;
                    }
                }
                if (n === 4) {
                    saveSQData();
                }

                if (!ok && al) al.classList.add('show');
                return ok;
            }
            function updateSkillsHidden() {
                document.getElementById('skillsHidden').value = JSON.stringify(selectedSkills);
            }
            /* live clear on input */
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.pj-input').forEach(function(inp) {
                    ['input', 'change'].forEach(ev => inp.addEventListener(ev, function() {
                        this.classList.remove('err');
                        var e = document.getElementById('err-' + this.id);
                        if (e) e.classList.remove('show');
                    }));
                });
                initSkills();
                /* init char counters */
                [
                    ['description', 'descCnt', 3000],
                    ['responsibilities', 'respCnt', 2000],
                    ['benefits', 'benCnt', 500]
                ].forEach(function([id, cid, max]) {
                    var el = document.getElementById(id);
                    if (el) charCount(el, cid, max);
                });
                /* restore old SQ data */
                var oldSQ = document.getElementById('sqData').value;
                try {
                    var arr = JSON.parse(oldSQ);
                    arr.forEach(function(q) {
                        addSQFromData(q);
                    });
                } catch (e) {}
            });

            /* ═══════════════════════════════
               CHAR COUNTER
            ═══════════════════════════════ */
            window.charCount = function(el, cid, max) {
                var c = document.getElementById(cid);
                if (!c) return;
                var len = el.value.length;
                c.textContent = len + ' / ' + max;
                c.className = 'pj-counter' + (len > max * .97 ? ' over' : len > max * .82 ? ' warn' : '');
            };

            /* ═══════════════════════════════
               SKILLS
            ═══════════════════════════════ */
            var selectedSkills = [];
            var ALL_SKILLS = @json($skills->pluck('name'));

            function initSkills() {
                var old = document.getElementById('skillsHidden').value;
                if (old) {
                    try {
                        JSON.parse(old).forEach(s => {
                            if (s && selectedSkills.indexOf(s) === -1) {
                                selectedSkills.push(s);
                                renderChip(s);
                            }
                        });
                    } catch (e) {}
                }
                filterSkills('');
                updateSkillsHidden();
            }

            window.openSkillsDD = function() {
                filterSkills(document.getElementById('skillInput').value);
                document.getElementById('skillsDD').classList.add('open');
            };
            window.closeSkillsDD = function() {
                document.getElementById('skillsDD').classList.remove('open');
            };

            window.filterSkills = function(q) {
                var dd = document.getElementById('skillsDD');
                if (!dd) return;
                var flt = ALL_SKILLS.filter(s => s.toLowerCase().includes((q || '').toLowerCase()) && selectedSkills
                    .indexOf(s) === -1);
                if (flt.length === 0) {
                    dd.innerHTML = q ?
                        '<div class="pj-dd-empty"><i class="fa-solid fa-keyboard" style="color:var(--blue);"></i> Press Enter to add "<strong>' +
                        escHtml(q) + '</strong>"</div>' :
                        '<div class="pj-dd-empty"><i class="fa-solid fa-magnifying-glass"></i> Type to search skills</div>';
                } else {
                    dd.innerHTML = flt.slice(0, 10).map(s => {
                        var safe = s.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
                        return '<div class="pj-dd-item" onmousedown="event.preventDefault();addSkill(\'' +
                            safe + '\')"><i class="fa-solid fa-screwdriver-wrench"></i> ' + escHtml(s) +
                            '</div>';
                    }).join('');
                }
                dd.classList.add('open');
            };

            window.addSkill = function(skill) {
                skill = skill.trim();
                if (!skill || selectedSkills.includes(skill) || selectedSkills.length >= 10) return;

                selectedSkills.push(skill);
                renderChip(skill);
                updateSkillsHidden(); // ✅ added
                document.getElementById('skillInput').value = '';
                filterSkills('');
            };

            function renderChip(skill) {
                var chip = document.createElement('div');
                chip.className = 'pj-chip';
                chip.setAttribute('data-skill', skill);
                var safe = skill.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
                chip.innerHTML = escHtml(skill) +
                    '<button type="button" class="pj-chip-rm" onclick="removeSkill(\'' + safe +
                    '\')" title="Remove"><i class="fa-solid fa-xmark"></i></button>';
                document.getElementById('skillChips').appendChild(chip);
            }

            window.removeSkill = function(skill) {
                selectedSkills = selectedSkills.filter(s => s !== skill);

                document.querySelectorAll('#skillChips .pj-chip').forEach(c => {
                    if (c.getAttribute('data-skill') === skill) c.remove();
                });

                updateSkillsHidden(); // ✅ added
                filterSkills(document.getElementById('skillInput').value);
            };

            window.handleSkillKey = function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    var v = e.target.value.replace(/,/g, '').trim();
                    if (v) addSkill(v);
                }
            };

            /* ═══════════════════════════════
               SCREENING QUESTIONS
            ═══════════════════════════════ */
            var sqCount = 0;
            /* Preset data (matches Blade array above) */
            var PRESETS = [{
                    question: 'Do you have a valid driving licence?',
                    type: 'select',
                    options: ['Yes', 'No']
                },
                {
                    question: 'Are you comfortable with night / rotational shifts?',
                    type: 'select',
                    options: ['Yes', 'No', 'Depends on the schedule']
                },
                {
                    question: 'What is your current salary (CTC per month)?',
                    type: 'input',
                    options: []
                },
                {
                    question: 'How many years of relevant experience do you have?',
                    type: 'input',
                    options: []
                },
                {
                    question: 'Are you willing to relocate for this position?',
                    type: 'select',
                    options: ['Yes, open to relocation', 'No, prefer local', 'Need more details']
                },
                {
                    question: 'Do you have a two-wheeler / vehicle?',
                    type: 'select',
                    options: ['Yes, own vehicle', 'No']
                },
                {
                    question: 'When can you join?',
                    type: 'select',
                    options: ['Immediately', 'Within 15 days', 'Within 30 days', 'More than 30 days']
                },
                {
                    question: 'Do you have experience with Tally / ERP software?',
                    type: 'select',
                    options: ['Yes', 'No', 'Currently learning']
                },
                {
                    question: 'What is your highest qualification?',
                    type: 'select',
                    options: ['10th Pass', '12th Pass', 'Diploma', 'Degree', 'Post-Graduate']
                },
                {
                    question: 'Why are you interested in this role?',
                    type: 'input',
                    options: []
                },
            ];

            window.addPresetSQ = function(pi) {
                var p = PRESETS[pi];
                if (!p) return;
                addSQFromData(p);
            };

            function addSQFromData(data) {
                sqCount++;
                var id = 'sq_' + sqCount;
                var el = document.createElement('div');
                el.className = 'pj-sq-block';
                el.id = id;
                el.innerHTML = buildSQHTML(id, sqCount, data);
                document.getElementById('sqList').appendChild(el);
                document.getElementById('sqEmpty').style.display = 'none';
                /* set initial type display */
                switchSQType(id, data.type || 'select', false);
                saveSQData();
            }

            window.addSQ = function() {
                addSQFromData({
                    question: '',
                    type: 'select',
                    options: ['', '']
                });
            };

            function buildSQHTML(id, num, data) {
                var q = data.question || '';
                var type = data.type || 'select';
                var opts = data.options || [];
                var ltrs = 'ABCDEFGHIJKLMNOP';

                var optsHTML = opts.map(function(o, i) {
                    return buildOptRow(id, i + 1, ltrs[i] || String(i + 1), o);
                }).join('') || (buildOptRow(id, 1, 'A', '') + buildOptRow(id, 2, 'B', ''));

                return '<div class="pj-sq-block-top">' +
                    '<div class="pj-sq-num">Q' + num + '</div>' +
                    '<div class="pj-sq-prev" id="' + id + '_prev">' + (q ? escHtml(q) : 'Question ' + num) + '</div>' +
                    '<span class="pj-sq-badge ' + (type === 'select' ? 'mc' : type === 'yn' ? 'yn' : 'tx') + '" id="' +
                    id + '_badge">' +
                    (type === 'select' ? 'Multiple Choice' : type === 'yn' ? 'Yes / No' : 'Text Input') + '</span>' +
                    '<button type="button" class="pj-sq-del" onclick="delSQ(\'' + id +
                    '\')" title="Remove"><i class="fa-solid fa-trash"></i></button>' +
                    '</div>' +
                    '<div class="pj-sq-body">' +
                    '<div class="pj-fg"><label class="pj-lbl"><span class="pj-lbl-ico"><i class="fa-solid fa-question"></i></span> Question Text <span class="pj-req">*</span></label>' +
                    '<div class="pj-iw"><div class="pj-iw-prefix"><i class="fa-solid fa-question"></i></div>' +
                    '<input type="text" id="' + id +
                    '_q" class="pj-input" style="padding-left:44px;" placeholder="e.g. Do you have a valid driving licence?" value="' +
                    escAttr(q) + '" ' +
                    'oninput="(function(el){var p=document.getElementById(\'' + id +
                    '_prev\');if(p)p.textContent=el.value||\'Question\';saveSQData();})(this)"/>' +
                    '</div></div>' +
                    '<label class="pj-lbl" style="margin-bottom:10px;"><span class="pj-lbl-ico"><i class="fa-solid fa-list"></i></span> Answer Type</label>' +
                    '<div class="pj-sq-type-row">' +
                    '<div class="pj-sq-topt"><input type="radio" id="' + id + '_ts" name="' + id +
                    '_type" value="select" ' + (type === 'select' ? 'checked' : '') + ' onchange="switchSQType(\'' +
                    id + '\',\'select\',true)"><label for="' + id +
                    '_ts"><i class="fa-solid fa-list-ul"></i> Multiple Choice</label></div>' +
                    '<div class="pj-sq-topt"><input type="radio" id="' + id + '_ti" name="' + id +
                    '_type" value="input" ' + (type === 'input' ? 'checked' : '') + ' onchange="switchSQType(\'' + id +
                    '\',\'input\',true)"><label for="' + id +
                    '_ti"><i class="fa-solid fa-keyboard"></i> Text Input</label></div>' +
                    '<div class="pj-sq-topt"><input type="radio" id="' + id + '_ty" name="' + id +
                    '_type" value="yn" ' + (type === 'yn' ? 'checked' : '') + ' onchange="switchSQType(\'' + id +
                    '\',\'yn\',true)"><label for="' + id +
                    '_ty"><i class="fa-solid fa-circle-half-stroke"></i> Yes / No</label></div>' +
                    '</div>' +
                    '<div id="' + id + '_selfields">' +
                    '<div class="pj-sq-opts-lbl">Answer Options</div>' +
                    '<div id="' + id + '_opts">' + optsHTML + '</div>' +
                    '<button type="button" class="pj-add-opt" onclick="addOpt(\'' + id + '\')" id="' + id +
                    '_addOptBtn"><i class="fa-solid fa-plus"></i> Add Option</button>' +
                    '</div>' +
                    '<div id="' + id + '_inpfields" style="display:none;">' +
                    '<div class="pj-txt-note"><i class="fa-solid fa-keyboard" style="color:var(--ink5);"></i> Candidate will type their answer in a free-text field</div>' +
                    '</div>' +
                    '<div id="' + id + '_ynfields" style="display:none;">' +
                    '<div class="pj-sq-opts-lbl">Options (pre-filled)</div>' +
                    '<div style="display:flex;gap:10px;flex-wrap:wrap;">' +
                    '<div style="display:inline-flex;align-items:center;gap:8px;background:var(--green-lt);border:1.5px solid var(--green-mid);border-radius:var(--r-sm);padding:8px 16px;font-family:var(--fh);font-size:.82rem;font-weight:700;color:var(--green);"><i class="fa-solid fa-check"></i> Yes</div>' +
                    '<div style="display:inline-flex;align-items:center;gap:8px;background:var(--red-lt);border:1.5px solid var(--red-mid);border-radius:var(--r-sm);padding:8px 16px;font-family:var(--fh);font-size:.82rem;font-weight:700;color:var(--red);"><i class="fa-solid fa-xmark"></i> No</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }

            function buildOptRow(id, num, ltr, val) {
                var rm = num > 2 ?
                    '<button type="button" class="pj-opt-rm" onclick="removeOpt(\'' + id + '\',' + num +
                    ')" title="Remove option"><i class="fa-solid fa-xmark"></i></button>' :
                    '<span style="width:28px;display:inline-block;"></span>';
                return '<div class="pj-sq-opt-row" id="' + id + '_orow_' + num + '">' +
                    '<div class="pj-opt-ltr">' + escHtml(ltr) + '</div>' +
                    '<input type="text" class="pj-opt-field" id="' + id + '_opt_' + num + '" placeholder="Option ' +
                    escHtml(ltr) + '" value="' + escAttr(val) + '" oninput="saveSQData()"/>' +
                    rm + '</div>';
            }

            var sqOptCounts = {};
            window.addOpt = function(id) {
                sqOptCounts[id] = (sqOptCounts[id] || 4) + 1;
                var n = sqOptCounts[id];
                var ltr = 'ABCDEFGHIJKLMNOP';
                var c = document.getElementById(id + '_opts');
                if (!c) return;
                var tmp = document.createElement('div');
                tmp.innerHTML = buildOptRow(id, n, n <= ltr.length ? ltr[n - 1] : String(n), '');
                c.appendChild(tmp.firstElementChild);
                saveSQData();
            };
            window.removeOpt = function(id, num) {
                var r = document.getElementById(id + '_orow_' + num);
                if (r) r.remove();
                saveSQData();
            };

            window.switchSQType = function(id, type, save) {
                var sf = document.getElementById(id + '_selfields');
                var inf = document.getElementById(id + '_inpfields');
                var ynf = document.getElementById(id + '_ynfields');
                var b = document.getElementById(id + '_badge');
                if (sf) sf.style.display = type === 'select' ? 'block' : 'none';
                if (inf) inf.style.display = type === 'input' ? 'block' : 'none';
                if (ynf) ynf.style.display = type === 'yn' ? 'block' : 'none';
                if (b) {
                    if (type === 'select') {
                        b.className = 'pj-sq-badge mc';
                        b.textContent = 'Multiple Choice';
                    } else if (type === 'yn') {
                        b.className = 'pj-sq-badge yn';
                        b.textContent = 'Yes / No';
                    } else {
                        b.className = 'pj-sq-badge tx';
                        b.textContent = 'Text Input';
                    }
                }
                if (save) saveSQData();
            };

            window.delSQ = function(id) {
                var bl = document.getElementById(id);
                if (!bl) return;
                bl.style.opacity = '0';
                bl.style.transform = 'translateX(-10px)';
                bl.style.transition = 'opacity .2s,transform .2s';
                setTimeout(function() {
                    bl.remove();
                    renumSQ();
                    if (!document.getElementById('sqList').children.length)
                        document.getElementById('sqEmpty').style.display = 'block';
                    saveSQData();
                }, 220);
            };

            function renumSQ() {
                document.querySelectorAll('.pj-sq-block').forEach(function(b, i) {
                    var n = b.querySelector('.pj-sq-num');
                    if (n) n.textContent = 'Q' + (i + 1);
                });
            }

            function saveSQData() {
                var data = [];
                document.querySelectorAll('.pj-sq-block').forEach(function(bl) {
                    var id = bl.id;
                    var q = document.getElementById(id + '_q')?.value || '';
                    var tr = document.querySelector('input[name="' + id + '_type"]:checked');
                    var type = tr ? tr.value : 'select';
                    var obj = {
                        question: q,
                        type: type,
                        options: []
                    };
                    if (type === 'select') {
                        bl.querySelectorAll('.pj-opt-field').forEach(function(o) {
                            if (o.value.trim()) obj.options.push(o.value.trim());
                        });
                    } else if (type === 'yn') {
                        obj.options = ['Yes', 'No'];
                    }
                    data.push(obj);
                });
                var h = document.getElementById('sqData');
                if (h) h.value = JSON.stringify(data);
            }

            /* ═══════════════════════════════
               REVIEW BUILD
            ═══════════════════════════════ */
            function buildReview() {
                function set(id, txt) {
                    var e = document.getElementById(id);
                    if (e) e.textContent = txt || '—';
                }
                set('rev-title', gv('job_title'));
                set('rev-location', [gv('city'), gv('district'), gv('state')].filter(Boolean).join(', ') || '—');
                set('rev-category', gv('job_category'));
                set('rev-industry', gv('industry_type'));
                set('rev-exp', gv('experience_required'));
                set('rev-salary', gv('salary_range') || '—');
                var jtr = document.querySelector('input[name="job_type"]:checked');
                set('rev-type', jtr ? jtr.value : '—');
                set('rev-education', gv('education'));
                set('rev-vacancies', gv('vacancies') ? gv('vacancies') + ' position(s)' : '—');
                var str = document.querySelector('input[name="status"]:checked');
                set('rev-status', str ? str.value : '—');
                set('rev-skills', selectedSkills.length ? selectedSkills.join(', ') : 'None selected');
                try {
                    var sq = JSON.parse(document.getElementById('sqData').value || '[]');
                    set('rev-sq', sq.length ? sq.length + ' question(s) added' : 'None added');
                } catch (e) {
                    set('rev-sq', 'None added');
                }

                var chips = document.getElementById('rev-chips');
                if (!chips) return;
                chips.innerHTML = '';

                function chip(icon, txt) {
                    return '<span class="pj-rev-chip"><i class="fa-solid ' + icon + '"></i> ' + escHtml(txt) +
                    '</span>';
                }
                if (jtr) chips.innerHTML += chip('fa-clock', jtr.value);
                if (gv('salary_range') && gv('salary_range') !== 'Not Disclosed') chips.innerHTML += chip(
                    'fa-indian-rupee-sign', gv('salary_range'));
                if (gv('experience_required')) chips.innerHTML += chip('fa-briefcase', gv('experience_required'));
                if (gv('city')) chips.innerHTML += chip('fa-location-dot', [gv('city'), gv('state')].filter(Boolean)
                    .join(', '));
            }

            /* ═══════════════════════════════
               SUBMIT
            ═══════════════════════════════ */
            document.getElementById('pjForm').addEventListener('submit', function(e) {
                var tc = document.getElementById('termsCheck');
                var et = document.getElementById('err-terms');
                if (!tc || !tc.checked) {
                    e.preventDefault();
                    if (et) et.classList.add('show');
                    return;
                }
                if (et) et.classList.remove('show');
                var btn = document.getElementById('publishBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Publishing...';
                }
            });
            document.getElementById('termsCheck')?.addEventListener('change', function() {
                if (this.checked) document.getElementById('err-terms')?.classList.remove('show');
            });

            /* ═══════════════════════════════
               DRAFT (UI only)
            ═══════════════════════════════ */
            window.saveDraft = function(btn) {
                if (!btn) return;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                btn.disabled = true;
                setTimeout(function() {
                    btn.innerHTML = '<i class="fa-solid fa-check" style="color:var(--green);"></i> Saved!';
                    setTimeout(function() {
                        btn.innerHTML = '<i class="fa-regular fa-floppy-disk"></i> Save Draft';
                        btn.disabled = false;
                    }, 2000);
                }, 900);
            };

            /* ═══════════════════════════════
               HELPERS
            ═══════════════════════════════ */
            function escHtml(s) {
                return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                    '&quot;');
            }

            function escAttr(s) {
                return String(s).replace(/"/g, '&quot;');
            }

        })();
        $('#state').on('change', function () {

            let state = $(this).val();

            $('#district').html('<option value="">Loading...</option>');

            if (state) {

                let url = "{{ route('get.districts', ':state') }}";
                url = url.replace(':state', encodeURIComponent(state));

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {

                        let options = '<option value="" disabled selected>Select District</option>';

                        response.forEach(function (district) {
                            options += `<option value="${district}">${district}</option>`;
                        });

                        $('#district').html(options);
                    }
                });

            } else {
                $('#district').html('<option value="" disabled selected>Select District</option>');
            }
        });

        document.getElementById('state').addEventListener('change', async function () {

            let state = this.value;
            let districtSel = document.getElementById('district');

            // reset
            districtSel.innerHTML = '<option value  ="">Loading...</option>';

            if (!state) {
                districtSel.innerHTML = '<option value="">District</option>';
                return;
            }

            try {
                let response = await fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        country: "India",
                        state: state
                    })
                });

                let result = await response.json();

                districtSel.innerHTML = '<option value="">District</option>';

                if (result.data && result.data.length > 0) {
                    result.data.forEach(function (district) {
                        let opt = document.createElement('option');
                        opt.value = district;
                        opt.textContent = district;
                        districtSel.appendChild(opt);
                    });
                } else {
                    districtSel.innerHTML = '<option value="">No District Found</option>';
                }

            } catch (error) {
                console.error(error);
                districtSel.innerHTML = '<option value="">Error loading districts</option>';
            }
        });
    </script>
@endpush
