{{-- ════════════════════════════════════════════════════════
     resources/views/employer/jobs/edit.blade.php
     Edit Job — LinearJobs Employer Dashboard (Ultra Redesign)
════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title', 'Edit Job — ' . $job->job_title)
@section('page-title', 'Edit Job')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Instrument+Sans:wght@400;500;600;700&display=swap');

        /* ══════════════════════════════════════
                           DESIGN TOKENS (shared with create)
                        ══════════════════════════════════════ */
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
            --green-d: #047857;
            --green-lt: #ecfdf5;
            --green-mid: #a7f3d0;
            --green-ring: rgba(5, 150, 105, .13);

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

        /* ══ WRAP ══ */
        .pj-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        /* ══ HERO — GREEN edition for edit ══ */
        .pj-hero {
            background: linear-gradient(140deg, #064e3b 0%, #059669 45%, #10b981 75%, #34d399 100%);
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
            background: #fde68a;
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
            color: #a7f3d0;
        }

        .pj-hero-sub {
            font-family: var(--fb);
            font-size: .9rem;
            color: rgba(255, 255, 255, .75);
            line-height: 1.7;
            max-width: 560px;
        }

        .pj-hero-jobcard {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .2);
            border-radius: var(--r-md);
            padding: 12px 20px;
            margin-top: 20px;
            font-family: var(--fb);
            font-size: .84rem;
            color: rgba(255, 255, 255, .92);
        }

        .pj-hero-jobcard strong {
            font-family: var(--fh);
            font-weight: 800;
            color: #fff;
        }

        /* ══ WIZARD PROGRESS ══ */
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
            background: linear-gradient(90deg, var(--green-d), var(--green), #34d399);
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
            background: linear-gradient(135deg, var(--green), var(--green-d));
            border-color: var(--green);
            color: #fff;
            box-shadow: 0 0 0 5px var(--green-ring), 0 4px 12px rgba(5, 150, 105, .3);
        }

        .pj-step.done .pj-step-bubble {
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            border-color: var(--blue);
            color: #fff;
            box-shadow: 0 0 0 4px var(--blue-ring);
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
            color: var(--green);
        }

        .pj-step.done .pj-step-name {
            color: var(--blue);
        }

        /* ══ FORM AREA & TABS ══ */
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
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        /* ══ CARD ══ */
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
            background: linear-gradient(180deg, var(--green), #34d399);
            border-radius: 0 4px 4px 0;
        }

        .pj-head-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--green-lt), var(--green-mid));
            color: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px var(--green-ring);
        }

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

        /* ══ GRID LAYOUTS ══ */
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

        /* ══ FIELD GROUP ══ */
        .pj-fg {
            margin-bottom: 24px;
        }

        .pj-fg:last-child {
            margin-bottom: 0;
        }

        /* ══ LABELS ══ */
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
            background: var(--green-lt);
            color: var(--green);
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

        /* ══ INPUT WRAPPER & INPUTS ══ */
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
            border-color: var(--green);
            box-shadow: 0 0 0 4px var(--green-ring);
            background: #f0fdf9;
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
            color: var(--green);
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

        /* success alert */
        .pj-alert-success {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--green-lt);
            border: 1.5px solid var(--green-mid);
            border-radius: var(--r-sm);
            padding: 14px 18px;
            font-family: var(--fb);
            font-size: .84rem;
            color: #065f46;
            margin-bottom: 22px;
        }

        /* ══ SECTION DIVIDER ══ */
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

        /* ══ JOB TYPE SELECTOR CARDS ══ */
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
            background: linear-gradient(135deg, var(--green-lt), transparent);
            opacity: 0;
            transition: opacity .2s;
        }

        .pj-type-opt label:hover {
            border-color: var(--green-mid);
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
            border-color: var(--green);
            background: linear-gradient(135deg, var(--green-lt) 0%, #d1fae5 100%);
            box-shadow: 0 0 0 3px var(--green-ring), var(--sh-sm);
            transform: translateY(-2px);
        }

        .pj-type-opt input:checked+label .pj-type-ico {
            background: linear-gradient(135deg, var(--green), var(--green-d));
            color: #fff;
            box-shadow: 0 4px 14px rgba(5, 150, 105, .3);
        }

        .pj-type-opt input:checked+label .pj-type-nm {
            color: var(--green-d);
        }

        .pj-type2 {
            grid-template-columns: 1fr 1fr;
        }

        /* ══ SKILLS INPUT ══ */
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
            border-color: var(--green);
            box-shadow: 0 0 0 4px var(--green-ring);
            background: #f0fdf9;
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
            background: linear-gradient(135deg, var(--green-lt), #d1fae5);
            border: 1.5px solid var(--green-mid);
            border-radius: 8px;
            padding: 5px 10px 5px 13px;
            font-family: var(--fh);
            font-size: .77rem;
            font-weight: 700;
            color: var(--green-d);
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
            color: var(--green-mid);
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
            background: var(--green-lt);
            color: var(--green-d);
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
            border-color: var(--green);
            color: var(--green);
            background: var(--green-lt);
            transform: translateY(-1px);
            box-shadow: var(--sh-xs);
        }

        .pj-sug i {
            font-size: .62rem;
        }

        /* ══ REVIEW ══ */
        .pj-rev-hero {
            background: linear-gradient(140deg, #064e3b, #059669 55%, #10b981);
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

        /* ══ FOOTER NAV ══ */
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
            color: var(--green);
            font-family: var(--fh);
            font-weight: 800;
        }

        .pj-footer-right {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
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
            background: linear-gradient(135deg, var(--green), var(--green-d));
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
            box-shadow: 0 2px 8px rgba(5, 150, 105, .25);
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, .35);
        }

        .btn-save {
            background: linear-gradient(135deg, #064e3b, var(--green-d), var(--green));
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
            box-shadow: 0 4px 16px rgba(5, 150, 105, .3);
            letter-spacing: -.2px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(5, 150, 105, .4);
        }

        .btn-save:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ══ RESPONSIVE ══ */
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
            .pj-type-grid {
                grid-template-columns: 1fr;
            }

            .pj-type2 {
                grid-template-columns: 1fr 1fr;
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
            .btn-save {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pj-wrap">

        {{-- ════════════ HERO ════════════ --}}
        <div class="pj-hero">
            <div class="pj-hero-orb1"></div>
            <div class="pj-hero-orb2"></div>
            <div class="pj-hero-grid"></div>
            <div class="pj-hero-inner">
                <div class="pj-hero-eyebrow">
                    <span></span> Employer Portal &mdash; Edit Job Listing
                </div>
                <div class="pj-hero-title">
                    Edit <span>Job Details</span>
                </div>
                <div class="pj-hero-sub">
                    Update your job listing below. Changes go live immediately after saving.
                </div>
                <div class="pj-hero-jobcard">
                    <i class="fa-solid fa-briefcase" style="color:#a7f3d0;"></i>
                    Editing: <strong>{{ $job->title }}</strong>
                    &middot; Posted {{ $job->created_at->diffForHumans() }}
                </div>
            </div>
        </div>

        {{-- ════════════ WIZARD ════════════ --}}
        <div class="pj-wizard-shell">
            <div class="pj-wizard-card">
                <div class="pj-wizard-track">
                    <div class="pj-wz-fill" id="wizFill"></div>
                    @php
                        $wsteps = [
                            ['fa-file-lines', 'Details'],
                            ['fa-location-dot', 'Location'],
                            ['fa-circle-info', 'Job & Skills'],
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

        {{-- ════════════ FORM ════════════ --}}
        <div class="pj-form-area">
            <form method="POST" action="{{ route('employer.jobs.update', $job->id) }}" id="pjForm" novalidate>
                @csrf
                @method('PUT')

                @if (session('success'))
                    <div class="pj-alert-success">
                        <i class="fa-solid fa-circle-check" style="font-size:1rem;flex-shrink:0;color:var(--green);"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

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
                            <div>
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
                                        placeholder="e.g. Senior Sales Executive"
                                        value="{{ old('title', $job->title) }}" />
                                </div>
                                <div class="pj-ferr @error('job_title') show @enderror" id="err-job_title">
                                    <i class="fa-solid fa-circle-exclamation"></i><span>Job title is required (min. 3
                                        characters).</span>
                                </div>
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
                                            <option value="" disabled>Select Category</option>
                                            @foreach (['IT & Software', 'Technical & Trade', 'Sales & Marketing', 'Office & Admin', 'Driver & Logistics', 'Manufacturing', 'Healthcare', 'Education', 'Hospitality', 'Other'] as $cat)
                                                <option value="{{ $cat }}"
                                                    {{ old('job_category', $job->job_category) === $cat ? 'selected' : '' }}>
                                                    {{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('job_category') show @enderror" id="err-job_category">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select a category.</span>
                                    </div>
                                </div>
                                <div class="pj-fg">
                                    <label class="pj-lbl" for="industry_type">
                                        <span class="pj-lbl-ico"><i class="fa-solid fa-industry"></i></span>
                                        Industry <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <div class="pj-iw-prefix"><i class="fa-solid fa-industry"></i></div>
                                        <select id="industry_type" name="industry_type"
                                            class="pj-input @error('industry_type') err @enderror">
                                            <option value="" disabled>Select Industry</option>
                                            @foreach (['Automobile', 'Banking & Finance', 'Construction', 'Education & Training', 'FMCG / Retail', 'Healthcare / Pharma', 'Hospitality', 'IT / Software', 'Logistics / Transport', 'Manufacturing', 'Textile / Garments', 'Other'] as $ind)
                                                <option value="{{ $ind }}"
                                                    {{ old('industry_type', $job->industry_type) === $ind ? 'selected' : '' }}>
                                                    {{ $ind }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-ferr @error('industry_type') show @enderror" id="err-industry_type">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please select an
                                            industry.</span>
                                    </div>
                                </div>
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
                                        style="padding-left:44px;min-height:140px;" maxlength="3000" oninput="charCount(this,'descCnt',3000)">{{ old('description', $job->description) }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;margin-top:6px;">
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
                                        style="padding-left:44px;" maxlength="2000" oninput="charCount(this,'respCnt',2000)">
{{ old('responsibilities', is_array($job->responsibilities) ? implode("\n", $job->responsibilities) : $job->responsibilities) }}
    </textarea>

                                </div>

                                <div style="display:flex;justify-content:space-between;margin-top:6px;">
                                    <div class="pj-ferr @error('responsibilities') show @enderror"
                                        id="err-responsibilities">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>Minimum 20 characters required.</span>
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
                                        maxlength="500" oninput="charCount(this,'benCnt',500)">
                                        {{ old('benefits', is_array($job->benefits) ? implode("\n", $job->benefits) : $job->benefits) }}
                                                </textarea>
                                </div>

                                <div style="display:flex;justify-content:flex-end;margin-top:6px;">
                                    <div class="pj-counter" id="benCnt">0 / 500</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>1</strong> of 4 &mdash; Basic Details</div>
                        <div class="pj-footer-right">
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
                            <div>
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
                                            <option value="" disabled>Select State</option>
                                            @foreach (['Tamil Nadu', 'Kerala', 'Karnataka', 'Andhra Pradesh', 'Telangana'] as $st)
                                                <option value="{{ $st }}"
                                                    {{ old('state', $job->state) === $st ? 'selected' : '' }}>
                                                    {{ $st }}</option>
                                            @endforeach
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
                                            <option value="" disabled>Select District</option>
                                            @php $dists=['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Sivakasi','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                                            @foreach ($dists as $d)
                                                <option value="{{ $d }}"
                                                    {{ old('district', $job->district) === $d ? 'selected' : '' }}>
                                                    {{ $d }}</option>
                                            @endforeach
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
                                            value="{{ old('location', $job->location) }}" />
                                    </div>
                                    <div class="pj-ferr @error('city') show @enderror" id="err-city">
                                        <i class="fa-solid fa-circle-exclamation"></i><span>Please enter the city/town
                                            name.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>2</strong> of 4 &mdash; Location</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-back" onclick="prevStep(2)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(2)">Job Info &amp; Skills &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 3 — JOB INFO + SKILLS (MERGED) ══════════ --}}
                <div class="pj-tab" id="pjTab3">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-circle-info"></i></div>
                            <div>
                                <div class="pj-head-title">Job Information &amp; Skills</div>
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
                                            <option value="" disabled>Select Experience</option>
                                            @foreach (['Fresher', 'Less than 1 year', '1-2 Years', '2-3 Years', '3-5 Years', '5-8 Years', '8-10 Years', '10+ Years'] as $ex)
                                                <option value="{{ $ex }}"
                                                    {{ old('experience_required', $job->experience_required) === $ex ? 'selected' : '' }}>
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
                                            min="1" max="100"
                                            value="{{ old('num_vacancies', $job->num_vacancies) }}" />
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
                                    @php
                                        $selectedSalary = '';

                                        if (!empty($job->salary_min) && !empty($job->salary_max)) {
                                            $selectedSalary = $job->salary_min . '-' . $job->salary_max;
                                        } elseif ($job->salary_min == 0 && $job->salary_max == 0) {
                                            $selectedSalary = 'Not Disclosed';
                                        }
                                    @endphp
                                    <select id="salary_range" name="salary_range"
                                        class="pj-input @error('salary_range') err @enderror">
                                        <option value="" disabled
                                            {{ old('salary_range', $selectedSalary) ? '' : 'selected' }}>
                                            Select Salary Range
                                        </option>
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
                                                {{ old('salary_range', $selectedSalary) === $val ? 'selected' : '' }}>
                                                {{ $lbl }}
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
                                        <option value="" disabled>Select Education Requirement</option>
                                        @foreach (['None (No Requirement)' => 'None', '10th Pass (SSLC)' => '10th', '12th Pass (HSC / +2)' => '12th', 'Diploma' => 'Diploma', "Bachelor's Degree (UG)" => 'Bachelor', "Master's Degree (PG)" => 'Master', 'Doctorate / PhD' => 'Doctorate'] as $lbl => $val)
                                            <option value="{{ $val }}"
                                                {{ old('education', $job->education) === $val ? 'selected' : '' }}>
                                                {{ $lbl }}</option>
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
                                                {{ old('job_type', $job->job_type) === $jt ? 'checked' : '' }}>
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
                                    @php
                                        $selectedStatus = old('status', $job->status == 1 ? 'active' : 'inactive');
                                    @endphp
                                    @foreach ([
            'active' => ['Active', 'fa-circle-check', 'Visible to job seekers immediately'],
            'inactive' => ['Inactive', 'fa-circle-pause', 'Hidden — publish later'],
        ] as $val => [$lbl, $ico, $desc])
                                        <div class="pj-type-opt">
                                            <input type="radio" id="status_{{ $val }}" name="status"
                                                value="{{ $val }}"
                                                {{ $selectedStatus === $val ? 'checked' : '' }}>

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

                            {{-- ── SKILLS SECTION ── --}}
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
                                            placeholder="Type a skill and press Enter, or pick from suggestions..."
                                            autocomplete="off" oninput="filterSkills(this.value)"
                                            onkeydown="handleSkillKey(event)" onfocus="openSkillsDD()"
                                            onblur="setTimeout(closeSkillsDD,200)" />
                                    </div>
                                    <div class="pj-skills-dd" id="skillsDD"></div>
                                </div>
                                @php
                                    $skillsOld = old(
                                        'skills',
                                        is_array($job->skills) ? implode(',', $job->skills) : $job->skills ?? '',
                                    );
                                @endphp
                                <input type="hidden" name="skills" id="skillsHidden" value="{{ $skillsOld }}" />
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
                                    @foreach (['Sales Executive', 'PHP Developer', 'Data Entry Operator', 'Driver', 'Electrician', 'CNC Operator', 'HR Executive', 'Accountant', 'Delivery Executive', 'Tele-calling', 'Machine Operator', 'Office Admin', 'React Developer', 'Python Developer', 'AutoCAD', 'Tally ERP', 'MS Excel', 'Digital Marketing', 'Quality Inspector', 'Warehouse Staff'] as $sg)
                                        <button type="button" class="pj-sug" onclick="addSkill('{{ $sg }}')">
                                            <i class="fa-solid fa-plus"></i> {{ $sg }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>3</strong> of 4 &mdash; Job Info &amp; Skills</div>
                        <div class="pj-footer-right">
                            <button type="button" class="btn-back" onclick="prevStep(3)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="btn-next" onclick="nextStep(3)">Review &nbsp;<i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══════════ STEP 4 — REVIEW ══════════ --}}
                <div class="pj-tab" id="pjTab4">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-head-icon"><i class="fa-solid fa-eye"></i></div>
                            <div>
                                <div class="pj-head-title">Review &amp; Save Changes</div>
                                <div class="pj-head-sub">Confirm all updates before saving your listing</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-rev-hero">
                                <div class="pj-rev-title" id="rev-title">—</div>
                                <div class="pj-rev-co">
                                    {{ auth()->user()->company->name ?? (auth()->user()->name ?? 'Your Company') }} · <span
                                        id="rev-location">—</span></div>
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
                            </div>

                            <div
                                style="background:var(--amber-lt);border:1.5px solid #fde68a;border-radius:var(--r-sm);padding:14px 18px;display:flex;align-items:flex-start;gap:12px;font-family:var(--fb);font-size:.84rem;color:#92400e;line-height:1.6;">
                                <i class="fa-solid fa-triangle-exclamation"
                                    style="color:var(--amber);margin-top:1px;flex-shrink:0;"></i>
                                Changes will go live immediately after saving. Candidates currently viewing this job may see
                                the updated information right away.
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-footer-info">Step <strong>4</strong> of 4 &mdash; Final Review</div>
                        <div class="pj-footer-right">
                            <a href="{{ route('employer.jobs.index') }}"
                                style="display:flex;align-items:center;gap:6px;font-family:var(--fb);font-size:.82rem;color:var(--ink3);text-decoration:none;padding:9px 14px;border-radius:var(--r-sm);transition:color .18s;"
                                onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--ink3)'">
                                <i class="fa-solid fa-xmark"></i> Discard Changes
                            </a>
                            <button type="button" class="btn-back" onclick="prevStep(4)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="submit" class="btn-save" id="saveBtn">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            'use strict';
            var TOTAL = 4;
            var STEP_ICONS = ['fa-file-lines', 'fa-location-dot', 'fa-circle-info', 'fa-eye'];
            var currentStep = 1;

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
                    if (!gv('industry_type')) {
                        showFE('industry_type', 'Please select an industry.');
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
                        showFE('city', 'Please enter the city/town name.');
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
                if (!ok && al) al.classList.add('show');
                return ok;
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.pj-input').forEach(function(inp) {
                    ['input', 'change'].forEach(ev => inp.addEventListener(ev, function() {
                        this.classList.remove('err');
                        var e = document.getElementById('err-' + this.id);
                        if (e) e.classList.remove('show');
                    }));
                });
                initSkills();
                [
                    ['description', 'descCnt', 3000],
                    ['responsibilities', 'respCnt', 2000],
                    ['benefits', 'benCnt', 500]
                ].forEach(function([id, cid, max]) {
                    var el = document.getElementById(id);
                    if (el) charCount(el, cid, max);
                });
            });

            window.charCount = function(el, cid, max) {
                var c = document.getElementById(cid);
                if (!c) return;
                var len = el.value.length;
                c.textContent = len + ' / ' + max;
                c.className = 'pj-counter' + (len > max * .97 ? ' over' : len > max * .82 ? ' warn' : '');
            };

            /* ══ SKILLS ══ */
            var selectedSkills = [];
            var ALL_SKILLS = [
                'PHP Developer', 'Java Developer', 'Python Developer', 'React Developer', 'Vue.js Developer',
                'Node.js Developer', 'MySQL / Database', 'Laravel Developer', 'WordPress Developer',
                'UI/UX Designer', 'Network Engineer', 'Electrician', 'Plumber', 'Welder',
                'Machine Operator', 'CNC Operator', 'Lathe Operator', 'Mechanic', 'HVAC Technician',
                'Quality Inspector', 'Sales Executive', 'Marketing Executive', 'Digital Marketing',
                'Field Sales', 'Tele-calling', 'Data Entry Operator', 'HR Executive', 'Accountant',
                'Office Admin', 'Receptionist', 'Driver', 'Delivery Executive', 'Forklift Operator',
                'Warehouse Staff', 'Customer Support', 'AutoCAD', 'Tally ERP', 'MS Excel', 'MS Office',
                'Communication Skills', 'Team Management', 'Stock Management', 'GST Filing',
                'Content Writing', 'Graphic Design', 'Video Editing', 'Social Media Marketing',
                'SEO / SEM', 'Project Management', 'Business Development', 'Supply Chain'
            ];

            function initSkills() {
                var old = document.getElementById('skillsHidden').value;
                if (old) {
                    var arr;
                    try {
                        arr = JSON.parse(old);
                    } catch (e) {
                        arr = old.split(',');
                    }
                    arr.forEach(function(s) {
                        s = s.trim();
                        if (s && selectedSkills.indexOf(s) === -1) {
                            selectedSkills.push(s);
                            renderChip(s);
                        }
                    });
                }
                filterSkills('');
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
                        '<div class="pj-dd-empty"><i class="fa-solid fa-keyboard" style="color:var(--green);"></i> Press Enter to add "<strong>' +
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
                if (!skill || selectedSkills.indexOf(skill) !== -1 || selectedSkills.length >= 10) return;
                selectedSkills.push(skill);
                renderChip(skill);
                document.getElementById('skillInput').value = '';
                filterSkills('');
                document.getElementById('err-skills').classList.remove('show');
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
                filterSkills(document.getElementById('skillInput').value);
            };

            window.handleSkillKey = function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    var v = e.target.value.replace(/,/g, '').trim();
                    if (v) addSkill(v);
                }
            };

            /* ══ REVIEW BUILD ══ */
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

                var chips = document.getElementById('rev-chips');
                if (!chips) return;
                chips.innerHTML = '';

                function chip(icon, txt) {
                    return '<span class="pj-rev-chip"><i class="fa-solid ' + icon + '"></i> ' + escHtml(txt) +
                        '</span>';
                }
                if (jtr) chips.innerHTML += chip('fa-clock', jtr.value);
                if (gv('salary_range')) chips.innerHTML += chip('fa-indian-rupee-sign', gv('salary_range'));
                if (gv('experience_required')) chips.innerHTML += chip('fa-briefcase', gv('experience_required'));
                if (gv('city')) chips.innerHTML += chip('fa-location-dot', [gv('city'), gv('state')].filter(Boolean)
                    .join(', '));
            }

            document.getElementById('pjForm').addEventListener('submit', function() {
                var btn = document.getElementById('saveBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                }
            });

            function escHtml(s) {
                return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                    '&quot;');
            }

        })();
    </script>
@endpush
