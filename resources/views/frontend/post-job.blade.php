{{-- ═══════════════════════════════════════════════════
     resources/views/employer/jobs/create.blade.php
     Post a Job – LinearJobs Employer Panel
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Post a Job – LinearJobs')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ══════════════════════════════════════════════════
       VARIABLES & RESET
    ══════════════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        /* ══════════════════════════════════════════════════
       PAGE SHELL
    ══════════════════════════════════════════════════ */
        .pj-page {
            background: #f1f4f9;
            min-height: calc(100vh - 64px);
            padding: 0 0 80px;
        }

        /* ══════════════════════════════════════════════════
       TOP HERO BANNER
    ══════════════════════════════════════════════════ */
        .pj-hero {
            background: linear-gradient(120deg, #1a56db 0%, #1e3a8a 60%, #312e81 100%);
            padding: 36px 24px 80px;
            position: relative;
            overflow: hidden;
        }

        .pj-hero::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .pj-hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -40px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .pj-hero-inner {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .pj-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 100px;
            padding: 5px 14px;
            font-size: .72rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .9);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .pj-hero-title {
            font-size: clamp(1.4rem, 2.8vw, 1.9rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -.5px;
            margin-bottom: 8px;
        }

        .pj-hero-sub {
            font-size: .88rem;
            color: rgba(255, 255, 255, .72);
            line-height: 1.6;
        }

        .pj-plan-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .22);
            border-radius: 10px;
            padding: 8px 16px;
            margin-top: 18px;
            font-size: .8rem;
            color: #fff;
        }

        .pj-plan-chip strong {
            color: #fcd34d;
        }

        .pj-plan-chip .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            animation: blink 1.4s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .35
            }
        }

        /* ══════════════════════════════════════════════════
       STEP PROGRESS BAR
    ══════════════════════════════════════════════════ */
        .pj-progress-wrap {
            max-width: 900px;
            margin: -44px auto 0;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .pj-progress-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .1);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0;
            overflow: hidden;
        }

        .pj-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
            cursor: default;
        }

        .pj-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 16px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #e5e7eb;
            z-index: 0;
            transition: background .4s;
        }

        .pj-step.done:not(:last-child)::after {
            background: #16a34a;
        }

        .pj-step.active:not(:last-child)::after {
            background: #1a56db;
        }

        .pj-step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
            transition: all .3s;
            border: 2px solid #e5e7eb;
        }

        .pj-step.active .pj-step-circle {
            background: #1a56db;
            color: #fff;
            border-color: #1a56db;
            box-shadow: 0 0 0 5px rgba(26, 86, 219, .12);
        }

        .pj-step.done .pj-step-circle {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }

        .pj-step-lbl {
            font-size: .65rem;
            font-weight: 700;
            color: #9ca3af;
            margin-top: 6px;
            text-align: center;
            white-space: nowrap;
            letter-spacing: .02em;
        }

        .pj-step.active .pj-step-lbl {
            color: #1a56db;
        }

        .pj-step.done .pj-step-lbl {
            color: #16a34a;
        }

        /* ══════════════════════════════════════════════════
       MAIN CONTENT AREA
    ══════════════════════════════════════════════════ */
        .pj-content {
            max-width: 900px;
            margin: 28px auto 0;
            padding: 0 20px;
        }

        /* ══════════════════════════════════════════════════
       SECTION CARD
    ══════════════════════════════════════════════════ */
        .pj-card {
            background: #fff;
            border-radius: 16px;
            border: 1.5px solid #e5e7eb;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .pj-card-head {
            background: linear-gradient(90deg, #1a56db 0%, #1e3a8a 100%);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pj-card-head-ico {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: #fff;
            flex-shrink: 0;
        }

        .pj-card-head-title {
            font-size: .9375rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.2px;
        }

        .pj-card-head-sub {
            font-size: .75rem;
            color: rgba(255, 255, 255, .7);
            margin-top: 1px;
        }

        .pj-card-body {
            padding: 24px;
        }

        /* ══════════════════════════════════════════════════
       TAB PANELS
    ══════════════════════════════════════════════════ */
        .pj-tab {
            display: none;
        }

        .pj-tab.active {
            display: block;
            animation: fadeUp .3s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ══════════════════════════════════════════════════
       FORM ELEMENTS
    ══════════════════════════════════════════════════ */
        .pj-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .pj-row3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        .pj-fgroup {
            margin-bottom: 20px;
        }

        .pj-fgroup:last-child {
            margin-bottom: 0;
        }

        .pj-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 7px;
        }

        .pj-label i {
            font-size: .75rem;
            color: #1a56db;
        }

        .pj-req {
            color: #ef4444;
            margin-left: 2px;
        }

        .pj-opt {
            font-size: .67rem;
            font-weight: 500;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 1px 7px;
            border-radius: 100px;
            margin-left: 4px;
        }

        .pj-iw {
            position: relative;
        }

        .pj-iw-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: .82rem;
            pointer-events: none;
            z-index: 1;
        }

        .pj-iw-ico.ta {
            top: 14px;
            transform: none;
        }

        .pj-input {
            width: 100%;
            border: 1.5px solid #d1d5db;
            border-radius: 9px;
            padding: 10px 14px 10px 38px;
            font-family: inherit;
            font-size: .875rem;
            color: #111827;
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .pj-input.no-ico {
            padding-left: 14px;
        }

        .pj-input:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .pj-input::placeholder {
            color: #9ca3af;
        }

        .pj-input.err {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        select.pj-input {
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7'%3E%3Cpath d='M0 0l5.5 7 5.5-7z' fill='%239ca3af'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 34px;
            cursor: pointer;
        }

        textarea.pj-input {
            padding-top: 11px;
            resize: vertical;
            min-height: 110px;
            line-height: 1.6;
        }

        .pj-field-err {
            font-size: .73rem;
            color: #dc2626;
            margin-top: 5px;
            display: none;
            align-items: center;
            gap: 5px;
        }

        .pj-field-err.show {
            display: flex;
        }

        .pj-hint {
            font-size: .73rem;
            color: #9ca3af;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pj-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0 18px;
        }

        .pj-divider-line {
            flex: 1;
            height: 1px;
            background: #f3f4f6;
        }

        .pj-divider-lbl {
            font-size: .68rem;
            font-weight: 800;
            color: #9ca3af;
            letter-spacing: .09em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .pj-divider-lbl i {
            font-size: .72rem;
            color: #1a56db;
        }

        .pj-alert {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 9px;
            padding: 11px 14px;
            margin-bottom: 18px;
            display: none;
            align-items: flex-start;
            gap: 9px;
            font-size: .82rem;
            color: #b91c1c;
            animation: shake .35s ease;
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
                transform: translateX(-5px)
            }

            40% {
                transform: translateX(5px)
            }

            60% {
                transform: translateX(-3px)
            }

            80% {
                transform: translateX(3px)
            }
        }

        /* ══════════════════════════════════════════════════
       JOB TYPE RADIO BUTTONS
    ══════════════════════════════════════════════════ */
        .pj-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .pj-type-opt input[type="radio"] {
            display: none;
        }

        .pj-type-opt label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 7px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 10px;
            cursor: pointer;
            transition: all .2s;
            text-align: center;
        }

        .pj-type-opt label .ico {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            background: #f3f4f6;
            color: #6b7280;
            transition: all .2s;
        }

        .pj-type-opt label .name {
            font-size: .82rem;
            font-weight: 700;
            color: #374151;
        }

        .pj-type-opt label .desc {
            font-size: .7rem;
            color: #9ca3af;
        }

        .pj-type-opt input:checked+label {
            border-color: #1a56db;
            background: rgba(26, 86, 219, .04);
        }

        .pj-type-opt input:checked+label .ico {
            background: rgba(26, 86, 219, .1);
            color: #1a56db;
        }

        .pj-type-opt input:checked+label .name {
            color: #1a56db;
        }

        .pj-type-opt label:hover {
            border-color: #93c5fd;
        }

        /* ══════════════════════════════════════════════════
       SALARY RANGE
    ══════════════════════════════════════════════════ */
        .pj-salary-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto;
            gap: 10px;
            align-items: center;
        }

        .pj-salary-sep {
            font-size: .82rem;
            color: #9ca3af;
            font-weight: 600;
            text-align: center;
        }

        .pj-salary-unit {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .78rem;
            font-weight: 600;
            color: #6b7280;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 9px;
            padding: 10px 12px;
            white-space: nowrap;
        }

        /* ══════════════════════════════════════════════════
       SKILLS MULTI-SELECT CHIPS
    ══════════════════════════════════════════════════ */
        .pj-skills-box {
            border: 1.5px solid #d1d5db;
            border-radius: 9px;
            padding: 10px 12px;
            min-height: 52px;
            cursor: text;
            transition: border-color .2s;
            background: #fff;
        }

        .pj-skills-box:focus-within {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .pj-skills-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }

        .pj-skill-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(26, 86, 219, .08);
            border: 1.5px solid rgba(26, 86, 219, .25);
            border-radius: 100px;
            padding: 3px 10px 3px 12px;
            font-size: .78rem;
            font-weight: 600;
            color: #1e40af;
        }

        .pj-skill-chip button {
            background: none;
            border: none;
            color: #60a5fa;
            cursor: pointer;
            font-size: .7rem;
            padding: 0;
            line-height: 1;
            transition: color .15s;
        }

        .pj-skill-chip button:hover {
            color: #ef4444;
        }

        .pj-skills-search {
            border: none;
            outline: none;
            font-family: inherit;
            font-size: .875rem;
            color: #111827;
            width: 100%;
            min-width: 120px;
            background: transparent;
        }

        .pj-skills-search::placeholder {
            color: #9ca3af;
        }

        .pj-skills-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            z-index: 50;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        .pj-skills-dropdown.open {
            display: block;
        }

        .pj-skill-opt {
            padding: 9px 14px;
            font-size: .85rem;
            color: #374151;
            cursor: pointer;
            transition: background .15s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pj-skill-opt:hover {
            background: #eff6ff;
            color: #1a56db;
        }

        .pj-skill-opt.selected {
            color: #9ca3af;
            pointer-events: none;
        }

        .pj-skill-opt.selected::after {
            content: '✓';
            margin-left: auto;
            color: #16a34a;
            font-weight: 700;
        }

        .pj-skills-no-result {
            padding: 12px 14px;
            font-size: .82rem;
            color: #9ca3af;
            text-align: center;
        }

        /* ══════════════════════════════════════════════════
       CHARACTER COUNTER
    ══════════════════════════════════════════════════ */
        .pj-char-counter {
            font-size: .72rem;
            color: #9ca3af;
            text-align: right;
            margin-top: 4px;
        }

        /* ══════════════════════════════════════════════════
       SCREENING QUESTIONS
    ══════════════════════════════════════════════════ */
        .pj-sq-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pj-sq-add-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(26, 86, 219, .07);
            border: 1.5px solid rgba(26, 86, 219, .2);
            border-radius: 9px;
            padding: 9px 16px;
            font-size: .84rem;
            font-weight: 700;
            color: #1a56db;
            cursor: pointer;
            transition: all .2s;
        }

        .pj-sq-add-btn:hover {
            background: rgba(26, 86, 219, .12);
            transform: translateY(-1px);
        }

        .pj-sq-empty {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 36px 20px;
            text-align: center;
            color: #9ca3af;
        }

        .pj-sq-empty i {
            font-size: 1.8rem;
            opacity: .4;
            display: block;
            margin-bottom: 10px;
        }

        .pj-sq-empty p {
            font-size: .85rem;
        }

        .pj-sq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .pj-sq-block {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            transition: box-shadow .2s;
            animation: fadeUp .25s ease;
        }

        .pj-sq-block:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .07);
        }

        .pj-sq-block-head {
            background: linear-gradient(90deg, #f8faff, #f0f4ff);
            padding: 13px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .pj-sq-num {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: #1a56db;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .pj-sq-q-preview {
            font-size: .84rem;
            font-weight: 600;
            color: #374151;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pj-sq-type-badge {
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 5px;
            flex-shrink: 0;
        }

        .pj-sq-type-badge.select {
            background: #ede9fe;
            color: #6d28d9;
        }

        .pj-sq-type-badge.input {
            background: #dcfce7;
            color: #166534;
        }

        .pj-sq-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pj-sq-action-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
            cursor: pointer;
            color: #6b7280;
            transition: all .2s;
        }

        .pj-sq-action-btn:hover {
            border-color: #9ca3af;
            color: #111827;
        }

        .pj-sq-action-btn.delete:hover {
            border-color: #fca5a5;
            color: #ef4444;
            background: #fef2f2;
        }

        .pj-sq-block-body {
            padding: 18px 18px 20px;
        }

        .pj-sq-type-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }

        .pj-sq-type-opt input[type="radio"] {
            display: none;
        }

        .pj-sq-type-opt label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 2px solid #e5e7eb;
            border-radius: 9px;
            padding: 10px;
            font-size: .82rem;
            font-weight: 700;
            color: #6b7280;
            cursor: pointer;
            transition: all .2s;
        }

        .pj-sq-type-opt input:checked+label {
            border-color: #1a56db;
            background: rgba(26, 86, 219, .05);
            color: #1a56db;
        }

        .pj-sq-type-opt label:hover {
            border-color: #93c5fd;
        }

        .pj-sq-options-wrap {
            margin-top: 14px;
        }

        .pj-sq-options-label {
            font-size: .72rem;
            font-weight: 800;
            color: #9ca3af;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .pj-sq-option-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .pj-opt-handle {
            color: #d1d5db;
            font-size: .75rem;
            cursor: grab;
            padding: 4px;
        }

        .pj-opt-letter {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 800;
            color: #6b7280;
            flex-shrink: 0;
        }

        .pj-opt-input {
            flex: 1;
            border: 1.5px solid #e5e7eb;
            border-radius: 7px;
            padding: 8px 12px;
            font-family: inherit;
            font-size: .84rem;
            color: #111827;
            outline: none;
            transition: border-color .2s;
        }

        .pj-opt-input:focus {
            border-color: #1a56db;
        }

        .pj-opt-remove {
            background: none;
            border: none;
            color: #d1d5db;
            cursor: pointer;
            font-size: .75rem;
            padding: 4px 6px;
            border-radius: 5px;
            transition: all .2s;
        }

        .pj-opt-remove:hover {
            color: #ef4444;
            background: #fef2f2;
        }

        .pj-add-opt-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: 1.5px dashed #d1d5db;
            border-radius: 7px;
            padding: 7px 12px;
            font-size: .78rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            margin-top: 4px;
            transition: all .2s;
        }

        .pj-add-opt-btn:hover {
            border-color: #1a56db;
            color: #1a56db;
        }

        .pj-sq-answer-preview {
            border: 1.5px dashed #d1d5db;
            border-radius: 7px;
            padding: 10px 14px;
            font-size: .82rem;
            color: #9ca3af;
            background: #f9fafb;
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        /* ══════════════════════════════════════════════════
       PLAN SELECT
    ══════════════════════════════════════════════════ */
        .pj-plan-select-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .pj-plan-opt input[type="radio"] {
            display: none;
        }

        .pj-plan-opt label {
            display: flex;
            flex-direction: column;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .pj-plan-opt label:hover {
            border-color: #93c5fd;
        }

        .pj-plan-opt input:checked+label {
            border-color: #1a56db;
            background: rgba(26, 86, 219, .03);
        }

        .pj-plan-opt input:checked+label .pj-plan-check {
            opacity: 1;
            transform: scale(1);
        }

        .pj-plan-check {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #1a56db;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            opacity: 0;
            transform: scale(.5);
            transition: all .25s;
        }

        .pj-plan-popular {
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(90deg, #1a56db, #7c3aed);
            color: #fff;
            font-size: .6rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 3px 12px;
            border-radius: 0 0 9px 0;
        }

        .pj-plan-ico {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 12px;
        }

        .pj-plan-ico.basic {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .pj-plan-ico.pro {
            background: #ede9fe;
            color: #7c3aed;
        }

        .pj-plan-name {
            font-size: .78rem;
            font-weight: 800;
            color: #9ca3af;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .pj-plan-price {
            font-size: 1.8rem;
            font-weight: 900;
            color: #111827;
            letter-spacing: -1px;
            line-height: 1;
        }

        .pj-plan-price sup {
            font-size: .9rem;
            font-weight: 700;
            vertical-align: super;
        }

        .pj-plan-price span {
            font-size: .8rem;
            color: #9ca3af;
            font-weight: 500;
        }

        .pj-plan-validity {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f3f4f6;
            border-radius: 100px;
            padding: 4px 11px;
            font-size: .73rem;
            font-weight: 700;
            color: #374151;
            margin: 10px 0;
        }

        .pj-plan-opt input:checked+label .pj-plan-validity {
            background: rgba(26, 86, 219, .1);
            color: #1a56db;
        }

        .pj-plan-feat-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pj-plan-feat-list li {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: .78rem;
            color: #6b7280;
            padding: 4px 0;
        }

        .pj-plan-feat-list li i {
            color: #16a34a;
            font-size: .7rem;
            flex-shrink: 0;
        }

        .pj-gst-note {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fefce8;
            border: 1.5px solid #fde68a;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: .8rem;
            color: #92400e;
            margin-top: 16px;
        }

        /* ══════════════════════════════════════════════════
       FOOTER NAVIGATION
    ══════════════════════════════════════════════════ */
        .pj-footer {
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
        }

        .pj-step-info {
            font-size: .8rem;
            color: #9ca3af;
            font-weight: 600;
        }

        .pj-step-info span {
            color: #1a56db;
            font-weight: 800;
        }

        .pj-footer-btns {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .pj-btn-prev {
            background: #fff;
            border: 1.5px solid #d1d5db;
            border-radius: 9px;
            font-family: inherit;
            font-size: .875rem;
            font-weight: 700;
            padding: 10px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            color: #374151;
            transition: all .2s;
        }

        .pj-btn-prev:hover {
            border-color: #6b7280;
        }

        .pj-btn-next {
            background: #1a56db;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: .9rem;
            font-weight: 700;
            padding: 10px 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
        }

        .pj-btn-next:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26, 86, 219, .28);
        }

        .pj-btn-publish {
            background: linear-gradient(135deg, #1a56db, #1e3a8a);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: .9375rem;
            font-weight: 800;
            padding: 12px 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 9px;
            transition: all .25s;
        }

        .pj-btn-publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 86, 219, .35);
        }

        .pj-btn-publish:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none;
        }

        .pj-save-draft {
            background: none;
            border: none;
            font-family: inherit;
            font-size: .82rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px;
            border-radius: 7px;
            transition: color .2s;
        }

        .pj-save-draft:hover {
            color: #1a56db;
        }

        /* ══════════════════════════════════════════════════
       PREVIEW CARD (Step 6)
    ══════════════════════════════════════════════════ */
        .pj-preview-banner {
            background: linear-gradient(135deg, #1a56db, #1e3a8a);
            border-radius: 14px;
            padding: 22px 24px;
            color: #fff;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .pj-preview-banner::after {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .pj-preview-title {
            font-size: 1.2rem;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .pj-preview-company {
            font-size: .84rem;
            color: rgba(255, 255, 255, .78);
            margin-bottom: 12px;
        }

        .pj-preview-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pj-preview-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 100px;
            padding: 3px 11px;
            font-size: .72rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .pj-review-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 16px;
        }

        .pj-review-item {
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .pj-review-label {
            font-size: .67rem;
            font-weight: 800;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 4px;
        }

        .pj-review-value {
            font-size: .88rem;
            font-weight: 700;
            color: #111827;
        }

        /* ══════════════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════════════ */
        @media (max-width: 768px) {
            .pj-progress-card {
                padding: 16px 16px;
                gap: 0;
                overflow-x: auto;
            }

            .pj-step-lbl {
                font-size: .58rem;
            }

            .pj-card-body {
                padding: 18px 16px;
            }

            .pj-row {
                grid-template-columns: 1fr;
            }

            .pj-row3 {
                grid-template-columns: 1fr;
            }

            .pj-type-grid {
                grid-template-columns: 1fr;
            }

            .pj-plan-select-grid {
                grid-template-columns: 1fr;
            }

            .pj-salary-row {
                grid-template-columns: 1fr 1fr;
            }

            .pj-salary-sep,
            .pj-salary-unit {
                display: none;
            }

            .pj-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .pj-footer-btns {
                flex-direction: column;
            }

            .pj-btn-prev,
            .pj-btn-next,
            .pj-btn-publish {
                width: 100%;
                justify-content: center;
            }

            .pj-sq-type-row {
                grid-template-columns: 1fr;
            }

            .pj-review-grid {
                grid-template-columns: 1fr;
            }

            .pj-hero {
                padding: 24px 16px 72px;
            }
        }

        @media (max-width: 480px) {
            .pj-progress-wrap {
                padding: 0 12px;
            }

            .pj-content {
                padding: 0 12px;
            }

            .pj-step-circle {
                width: 26px;
                height: 26px;
                font-size: .68rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pj-page">

        {{-- ══ HERO ══ --}}
        <div class="pj-hero">
            <div class="pj-hero-inner">
                <div class="pj-hero-badge"><i class="fa-solid fa-briefcase"></i> Employer Dashboard</div>
                <div class="pj-hero-title">Post a New Job</div>
                <div class="pj-hero-sub">Reach thousands of skilled professionals across Tamil Nadu. Fill in the details
                    below to get started.</div>
                @if (isset($activePlan))
                    <div class="pj-plan-chip">
                        <div class="dot"></div>
                        Active Plan: <strong>{{ $activePlan->name }}</strong>
                        &nbsp;&middot;&nbsp; Expires {{ $activePlan->expires_at->format('d M Y') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ STEP PROGRESS ══ --}}
        <div class="pj-progress-wrap">
            <div class="pj-progress-card">
                @php
                    $steps = [
                        ['ico' => 'fa-tag', 'lbl' => 'Plan'],
                        ['ico' => 'fa-file-lines', 'lbl' => 'Basic Details'],
                        ['ico' => 'fa-location-dot', 'lbl' => 'Location'],
                        ['ico' => 'fa-circle-info', 'lbl' => 'Job Info'],
                        ['ico' => 'fa-question-circle', 'lbl' => 'Screening'],
                        ['ico' => 'fa-eye', 'lbl' => 'Review'],
                    ];
                @endphp
                @foreach ($steps as $i => $s)
                    <div class="pj-step {{ $i === 0 ? 'active' : '' }}" data-step="{{ $i + 1 }}"
                        id="pjStep{{ $i + 1 }}">
                        <div class="pj-step-circle" id="pjStepCircle{{ $i + 1 }}">
                            <i class="fa-solid {{ $s['ico'] }}" style="font-size:.6rem;"></i>
                        </div>
                        <div class="pj-step-lbl">{{ $s['lbl'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ══ CONTENT ══ --}}
        <div class="pj-content">
            <form method="POST" action="{{ route('jobs.store') }}" id="postJobForm" novalidate>
                @csrf

                {{-- SERVER ERRORS --}}
                @if ($errors->any())
                    <div class="pj-alert show" style="margin-bottom:16px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <strong>Please fix the following:</strong>
                            <ul style="margin:4px 0 0 14px;padding:0;">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- ══ STEP 1 — SELECT PLAN ══ --}}
                <div class="pj-tab active" id="pjTab1">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-tag"></i></div>
                            <div>
                                <div class="pj-card-head-title">Select Your Job Posting Plan</div>
                                <div class="pj-card-head-sub">Choose a plan to activate your job listing</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert1">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Please select a plan to continue.</span>
                            </div>
                            <div class="pj-plan-select-grid">
                                <div class="pj-plan-opt">
                                    <input type="radio" id="plan_15" name="plan_id" value="15_day"
                                        {{ old('plan_id', '15_day') == '15_day' ? 'checked' : '' }}>
                                    <label for="plan_15">
                                        <div class="pj-plan-check"><i class="fa-solid fa-check"
                                                style="font-size:.55rem;"></i></div>
                                        <div class="pj-plan-ico basic"><i class="fa-solid fa-bolt"></i></div>
                                        <div class="pj-plan-name">15 Day Plan</div>
                                        <div class="pj-plan-price"><sup>₹</sup>600 <span>+ GST</span></div>
                                        <div class="pj-plan-validity"><i class="fa-solid fa-calendar-check"
                                                style="color:#16a34a;"></i> Valid for 15 Days</div>
                                        <ul class="pj-plan-feat-list">
                                            <li><i class="fa-solid fa-check"></i> Post 1 Job Opening</li>
                                            <li><i class="fa-solid fa-check"></i> Applicant Management</li>
                                            <li><i class="fa-solid fa-check"></i> Email Notifications</li>
                                            <li><i class="fa-solid fa-check"></i> Tamil Nadu Reach</li>
                                        </ul>
                                    </label>
                                </div>
                                <div class="pj-plan-opt">
                                    <input type="radio" id="plan_30" name="plan_id" value="30_day"
                                        {{ old('plan_id') == '30_day' ? 'checked' : '' }}>
                                    <label for="plan_30">
                                        <div class="pj-plan-popular">Most Popular</div>
                                        <div class="pj-plan-check"><i class="fa-solid fa-check"
                                                style="font-size:.55rem;"></i></div>
                                        <div class="pj-plan-ico pro"><i class="fa-solid fa-crown"></i></div>
                                        <div class="pj-plan-name">30 Day Plan</div>
                                        <div class="pj-plan-price"><sup>₹</sup>1000 <span>+ GST</span></div>
                                        <div class="pj-plan-validity"><i class="fa-solid fa-calendar-check"
                                                style="color:#16a34a;"></i> Valid for 30 Days</div>
                                        <ul class="pj-plan-feat-list">
                                            <li><i class="fa-solid fa-check"></i> Post 1 Job Opening</li>
                                            <li><i class="fa-solid fa-check"></i> Applicant Management</li>
                                            <li><i class="fa-solid fa-check"></i> Email Notifications</li>
                                            <li><i class="fa-solid fa-check"></i> Featured Listing</li>
                                            <li><i class="fa-solid fa-check"></i> Priority Support</li>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                            <div class="pj-gst-note">
                                <i class="fa-solid fa-circle-info" style="color:#92400e;"></i>
                                All prices are exclusive of GST (18%). Final amount will be shown at checkout.
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>1</span> of 6 — Plan Selection</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-btn-next" onclick="nextStep(1)">
                                Continue to Job Details <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 2 — BASIC DETAILS ══ --}}
                <div class="pj-tab" id="pjTab2">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-file-lines"></i></div>
                            <div>
                                <div class="pj-card-head-title">Basic Job Details</div>
                                <div class="pj-card-head-sub">Job title, category and industry</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert2">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Please fill in all required fields.</span>
                            </div>
                            <div class="pj-fgroup">
                                <label class="pj-label" for="job_title">
                                    <i class="fa-solid fa-briefcase"></i> Job Title <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <i class="fa-solid fa-briefcase pj-iw-ico"></i>
                                    <input type="text" id="job_title" name="job_title"
                                        class="pj-input @error('job_title') err @enderror"
                                        placeholder="e.g. Senior Sales Executive, PHP Developer, Electrician"
                                        value="{{ old('job_title') }}" />
                                </div>
                                <div class="pj-field-err @error('job_title') show @enderror" id="err-job_title">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('job_title')
                                            {{ $message }}
                                        @else
                                            Job title is required.
                                        @enderror
                                    </span>
                                </div>
                                <div class="pj-hint"><i class="fa-solid fa-circle-info"></i> Be specific — a clear title
                                    attracts better candidates</div>
                            </div>
                            <div class="pj-row">
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="job_category">
                                        <i class="fa-solid fa-layer-group"></i> Job Category <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-layer-group pj-iw-ico"></i>
                                        <select id="job_category" name="job_category"
                                            class="pj-input @error('job_category') err @enderror">
                                            <option value="" disabled {{ old('job_category') ? '' : 'selected' }}>
                                                Select Category</option>
                                            <option value="IT & Software"
                                                {{ old('job_category') == 'IT & Software' ? 'selected' : '' }}>IT & Software
                                            </option>
                                            <option value="Technical & Trade"
                                                {{ old('job_category') == 'Technical & Trade' ? 'selected' : '' }}>Technical &
                                                Trade</option>
                                            <option value="Sales & Marketing"
                                                {{ old('job_category') == 'Sales & Marketing' ? 'selected' : '' }}>Sales &
                                                Marketing</option>
                                            <option value="Office & Admin"
                                                {{ old('job_category') == 'Office & Admin' ? 'selected' : '' }}>Office & Admin
                                            </option>
                                            <option value="Driver & Logistics"
                                                {{ old('job_category') == 'Driver & Logistics' ? 'selected' : '' }}>Driver &
                                                Logistics</option>
                                            <option value="Manufacturing"
                                                {{ old('job_category') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                                            </option>
                                            <option value="Healthcare"
                                                {{ old('job_category') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                            <option value="Education"
                                                {{ old('job_category') == 'Education' ? 'selected' : '' }}>Education</option>
                                            <option value="Hospitality"
                                                {{ old('job_category') == 'Hospitality' ? 'selected' : '' }}>Hospitality
                                            </option>
                                            <option value="Other" {{ old('job_category') == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <div class="pj-field-err @error('job_category') show @enderror" id="err-job_category">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('job_category')
                                                {{ $message }}
                                            @else
                                                Please select a category.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="industry_type">
                                        <i class="fa-solid fa-industry"></i> Industry Type <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-industry pj-iw-ico"></i>
                                        <select id="industry_type" name="industry_type"
                                            class="pj-input @error('industry_type') err @enderror">
                                            <option value="" disabled {{ old('industry_type') ? '' : 'selected' }}>
                                                Select Industry</option>
                                            <option value="Automobile"
                                                {{ old('industry_type') == 'Automobile' ? 'selected' : '' }}>Automobile
                                            </option>
                                            <option value="Banking & Finance"
                                                {{ old('industry_type') == 'Banking & Finance' ? 'selected' : '' }}>Banking &
                                                Finance</option>
                                            <option value="Construction"
                                                {{ old('industry_type') == 'Construction' ? 'selected' : '' }}>Construction
                                            </option>
                                            <option value="Education & Training"
                                                {{ old('industry_type') == 'Education & Training' ? 'selected' : '' }}>
                                                Education & Training</option>
                                            <option value="FMCG / Retail"
                                                {{ old('industry_type') == 'FMCG / Retail' ? 'selected' : '' }}>FMCG / Retail
                                            </option>
                                            <option value="Healthcare / Pharma"
                                                {{ old('industry_type') == 'Healthcare / Pharma' ? 'selected' : '' }}>
                                                Healthcare / Pharma</option>
                                            <option value="Hospitality"
                                                {{ old('industry_type') == 'Hospitality' ? 'selected' : '' }}>Hospitality
                                            </option>
                                            <option value="IT / Software"
                                                {{ old('industry_type') == 'IT / Software' ? 'selected' : '' }}>IT / Software
                                            </option>
                                            <option value="Logistics / Transport"
                                                {{ old('industry_type') == 'Logistics / Transport' ? 'selected' : '' }}>
                                                Logistics / Transport</option>
                                            <option value="Manufacturing"
                                                {{ old('industry_type') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing
                                            </option>
                                            <option value="Textile / Garments"
                                                {{ old('industry_type') == 'Textile / Garments' ? 'selected' : '' }}>Textile /
                                                Garments</option>
                                            <option value="Other" {{ old('industry_type') == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <div class="pj-field-err @error('industry_type') show @enderror"
                                        id="err-industry_type">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('industry_type')
                                                {{ $message }}
                                            @else
                                                Please select an industry.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>2</span> of 6 — Basic Details</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-save-draft" onclick="saveDraft(event)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="pj-btn-prev" onclick="prevStep(2)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="pj-btn-next" onclick="nextStep(2)">Location <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 3 — LOCATION ══ --}}
                <div class="pj-tab" id="pjTab3">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <div class="pj-card-head-title">Job Location</div>
                                <div class="pj-card-head-sub">Where is this job based?</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert3">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Please fill in all location fields.</span>
                            </div>
                            <div class="pj-row3">
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="state">
                                        <i class="fa-solid fa-map"></i> State <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-map pj-iw-ico"></i>
                                        <select id="state" name="state"
                                            class="pj-input @error('state') err @enderror">
                                            <option value="" disabled {{ old('state') ? '' : 'selected' }}>Select
                                                State</option>
                                            <option value="Tamil Nadu"
                                                {{ old('state', 'Tamil Nadu') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu
                                            </option>
                                            <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala
                                            </option>
                                            <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>
                                                Karnataka</option>
                                            <option value="Andhra Pradesh"
                                                {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh
                                            </option>
                                            <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>
                                                Telangana</option>
                                        </select>
                                    </div>
                                    <div class="pj-field-err @error('state') show @enderror" id="err-state">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('state')
                                                {{ $message }}
                                            @else
                                                Please select a state.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="district">
                                        <i class="fa-solid fa-location-dot"></i> District <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-location-dot pj-iw-ico"></i>
                                        <select id="district" name="district"
                                            class="pj-input @error('district') err @enderror">
                                            <option value="" disabled {{ old('district') ? '' : 'selected' }}>Select
                                                District</option>
                                            @php $districts=['Chennai','Coimbatore','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Sivakasi','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                                            @foreach ($districts as $d)
                                                <option value="{{ $d }}"
                                                    {{ old('district') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="pj-field-err @error('district') show @enderror" id="err-district">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('district')
                                                {{ $message }}
                                            @else
                                                Please select a district.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="city">
                                        <i class="fa-solid fa-city"></i> City / Town <span class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-city pj-iw-ico"></i>
                                        <input type="text" id="city" name="city"
                                            class="pj-input @error('city') err @enderror" placeholder="e.g. Coimbatore"
                                            value="{{ old('city') }}" />
                                    </div>
                                    <div class="pj-field-err @error('city') show @enderror" id="err-city">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('city')
                                                {{ $message }}
                                            @else
                                                Please enter the city.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>3</span> of 6 — Location</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-save-draft" onclick="saveDraft(event)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="pj-btn-prev" onclick="prevStep(3)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="pj-btn-next" onclick="nextStep(3)">Job Info <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 4 — JOB INFORMATION ══ --}}
                <div class="pj-tab" id="pjTab4">

                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-circle-info"></i></div>
                            <div>
                                <div class="pj-card-head-title">Job Information</div>
                                <div class="pj-card-head-sub">Experience, salary, vacancies, type and education</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-alert" id="alert4">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Please fill in all required job information.</span>
                            </div>

                            <div class="pj-row">
                                <div class="pj-fgroup">
                                    <label class="pj-label" for="experience_required">
                                        <i class="fa-solid fa-briefcase"></i> Required Experience <span
                                            class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-briefcase pj-iw-ico"></i>
                                        <select id="experience_required" name="experience_required"
                                            class="pj-input @error('experience_required') err @enderror">
                                            <option value="" disabled
                                                {{ old('experience_required') ? '' : 'selected' }}>Select Experience
                                            </option>
                                            <option value="Fresher"
                                                {{ old('experience_required') == 'Fresher' ? 'selected' : '' }}>Fresher / No
                                                Experience</option>
                                            <option value="Less than 1 year"
                                                {{ old('experience_required') == 'Less than 1 year' ? 'selected' : '' }}>Less
                                                than 1 Year</option>
                                            <option value="1-2 Years"
                                                {{ old('experience_required') == '1-2 Years' ? 'selected' : '' }}>1 – 2 Years
                                            </option>
                                            <option value="2-3 Years"
                                                {{ old('experience_required') == '2-3 Years' ? 'selected' : '' }}>2 – 3 Years
                                            </option>
                                            <option value="3-5 Years"
                                                {{ old('experience_required') == '3-5 Years' ? 'selected' : '' }}>3 – 5 Years
                                            </option>
                                            <option value="5-8 Years"
                                                {{ old('experience_required') == '5-8 Years' ? 'selected' : '' }}>5 – 8 Years
                                            </option>
                                            <option value="8-10 Years"
                                                {{ old('experience_required') == '8-10 Years' ? 'selected' : '' }}>8 – 10 Years
                                            </option>
                                            <option value="10+ Years"
                                                {{ old('experience_required') == '10+ Years' ? 'selected' : '' }}>10+ Years
                                            </option>
                                        </select>
                                    </div>
                                    <div class="pj-field-err @error('experience_required') show @enderror"
                                        id="err-experience_required">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('experience_required')
                                                {{ $message }}
                                            @else
                                                Please select experience.
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="pj-fgroup">
                                    <label class="pj-label" for="vacancies">
                                        <i class="fa-solid fa-users"></i> Number of Vacancies <span
                                            class="pj-req">*</span>
                                    </label>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-users pj-iw-ico"></i>
                                        <input type="number" id="vacancies" name="vacancies"
                                            class="pj-input @error('vacancies') err @enderror" placeholder="e.g. 3"
                                            min="1" max="100" value="{{ old('vacancies', 1) }}" />
                                    </div>
                                    <div class="pj-field-err @error('vacancies') show @enderror" id="err-vacancies">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('vacancies')
                                                {{ $message }}
                                            @else
                                                Please enter number of vacancies.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="pj-fgroup">
                                <label class="pj-label">
                                    <i class="fa-solid fa-indian-rupee-sign"></i> Salary Range <span
                                        class="pj-req">*</span>
                                </label>
                                <div class="pj-salary-row">
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-indian-rupee-sign pj-iw-ico"></i>
                                        <input type="number" id="salary_min" name="salary_min"
                                            class="pj-input @error('salary_min') err @enderror"
                                            placeholder="Min e.g. 15000" value="{{ old('salary_min', '') }}"
                                            min="0" />
                                    </div>
                                    <div class="pj-salary-sep">to</div>
                                    <div class="pj-iw">
                                        <i class="fa-solid fa-indian-rupee-sign pj-iw-ico"></i>
                                        <input type="number" id="salary_max" name="salary_max"
                                            class="pj-input @error('salary_max') err @enderror"
                                            placeholder="Max e.g. 25000" value="{{ old('salary_max', '') }}"
                                            min="0" />
                                    </div>
                                    <div class="pj-salary-unit"><i class="fa-solid fa-calendar"></i> / month</div>
                                </div>
                                <div class="pj-field-err @error('salary_min') show @enderror" id="err-salary_min">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('salary_min')
                                            {{ $message }}
                                        @else
                                            Please enter minimum salary (use 0 if not disclosed).
                                        @enderror
                                    </span>
                                </div>
                                <div class="pj-hint"><i class="fa-solid fa-circle-info"></i> Enter 0 in both fields if
                                    salary is not disclosed</div>
                            </div>

                            <div class="pj-fgroup">
                                <label class="pj-label" for="education">
                                    <i class="fa-solid fa-graduation-cap"></i> Education Requirement <span
                                        class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <i class="fa-solid fa-graduation-cap pj-iw-ico"></i>
                                    <select id="education" name="education"
                                        class="pj-input @error('education') err @enderror">
                                        <option value="" disabled {{ old('education') ? '' : 'selected' }}>Select
                                            Minimum Education</option>
                                        <option value="None" {{ old('education') == 'None' ? 'selected' : '' }}>None (No
                                            Requirement)</option>
                                        <option value="10th" {{ old('education') == '10th' ? 'selected' : '' }}>10th Pass
                                            (SSLC)</option>
                                        <option value="12th" {{ old('education') == '12th' ? 'selected' : '' }}>12th Pass
                                            (HSC / +2)</option>
                                        <option value="Diploma" {{ old('education') == 'Diploma' ? 'selected' : '' }}>Diploma
                                        </option>
                                        <option value="Bachelor" {{ old('education') == 'Bachelor' ? 'selected' : '' }}>
                                            Bachelor's Degree (UG)</option>
                                        <option value="Master" {{ old('education') == 'Master' ? 'selected' : '' }}>Master's
                                            Degree (PG)</option>
                                        <option value="Doctorate" {{ old('education') == 'Doctorate' ? 'selected' : '' }}>
                                            Doctorate / PhD</option>
                                    </select>
                                </div>
                                <div class="pj-field-err @error('education') show @enderror" id="err-education">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('education')
                                            {{ $message }}
                                        @else
                                            Please select education requirement.
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="pj-fgroup">
                                <label class="pj-label"><i class="fa-solid fa-clock"></i> Job Type <span
                                        class="pj-req">*</span></label>
                                <div class="pj-type-grid">
                                    @php
                                        $jobTypes = [
                                            [
                                                'value' => 'Full Time',
                                                'icon' => 'fa-clock',
                                                'name' => 'Full Time',
                                                'desc' => 'Standard working hours',
                                            ],
                                            [
                                                'value' => 'Part Time',
                                                'icon' => 'fa-hourglass-half',
                                                'name' => 'Part Time',
                                                'desc' => 'Flexible / fewer hours',
                                            ],
                                            [
                                                'value' => 'Contract',
                                                'icon' => 'fa-file-contract',
                                                'name' => 'Contract',
                                                'desc' => 'Fixed-term engagement',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($jobTypes as $jt)
                                        <div class="pj-type-opt">
                                            <input type="radio" id="jt_{{ Str::slug($jt['value']) }}" name="job_type"
                                                value="{{ $jt['value'] }}"
                                                {{ old('job_type', 'Full Time') == $jt['value'] ? 'checked' : '' }}>
                                            <label for="jt_{{ Str::slug($jt['value']) }}">
                                                <div class="ico"><i class="fa-solid {{ $jt['icon'] }}"></i></div>
                                                <div class="name">{{ $jt['name'] }}</div>
                                                <div class="desc">{{ $jt['desc'] }}</div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Skills Card --}}
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                            <div>
                                <div class="pj-card-head-title">Required Skills</div>
                                <div class="pj-card-head-sub">Select skills needed for this role</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-fgroup">
                                <label class="pj-label"><i class="fa-solid fa-tags"></i> Skills <span
                                        class="pj-req">*</span></label>
                                <div style="position:relative;">
                                    <div class="pj-skills-box" id="skillsBox"
                                        onclick="document.getElementById('skillSearch').focus()">
                                        <div class="pj-skills-chips" id="skillChips"></div>
                                        <input type="text" id="skillSearch" class="pj-skills-search"
                                            placeholder="Type to search and add skills..." autocomplete="off"
                                            oninput="filterSkills(this.value)" onkeydown="handleSkillKey(event)"
                                            onfocus="openSkillsDropdown()"
                                            onblur="setTimeout(closeSkillsDropdown, 200)" />
                                    </div>
                                    <div class="pj-skills-dropdown" id="skillsDropdown"></div>
                                </div>
                                <input type="hidden" name="skills" id="skillsHidden"
                                    value="{{ old('skills', '') }}" />
                                <div class="pj-field-err" id="err-skills">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>Please add at least one skill.</span>
                                </div>
                                <div class="pj-hint"><i class="fa-solid fa-circle-info"></i> Add up to 10 relevant skills
                                    for this position</div>
                            </div>
                        </div>
                    </div>

                    {{-- Job Description Card --}}
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-pen-to-square"></i></div>
                            <div>
                                <div class="pj-card-head-title">Job Description & Details</div>
                                <div class="pj-card-head-sub">Provide full job information</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-fgroup">
                                <label class="pj-label" for="description">
                                    <i class="fa-solid fa-file-lines"></i> Job Description <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <i class="fa-solid fa-file-lines pj-iw-ico ta"></i>
                                    <textarea id="description" name="description" class="pj-input @error('description') err @enderror"
                                        style="padding-left:38px;min-height:130px;"
                                        placeholder="Describe the job role, work environment, company culture..." maxlength="3000"
                                        oninput="updateCounter('description','descCount',3000)">{{ old('description') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px;">
                                    <div class="pj-field-err @error('description') show @enderror" id="err-description">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('description')
                                                {{ $message }}
                                            @else
                                                Job description is required (min. 50 characters).
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="pj-char-counter"><span id="descCount">0</span>/3000</div>
                                </div>
                            </div>

                            <div class="pj-fgroup">
                                <label class="pj-label" for="responsibilities">
                                    <i class="fa-solid fa-list-check"></i> Responsibilities <span class="pj-req">*</span>
                                </label>
                                <div class="pj-iw">
                                    <i class="fa-solid fa-list-check pj-iw-ico ta"></i>
                                    <textarea id="responsibilities" name="responsibilities" class="pj-input @error('responsibilities') err @enderror"
                                        style="padding-left:38px;"
                                        placeholder="• Manage daily operations&#10;• Work with the team&#10;• Complete assigned targets&#10;(Enter each responsibility on a new line)"
                                        maxlength="2000" oninput="updateCounter('responsibilities','respCount',2000)">{{ old('responsibilities') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:4px;">
                                    <div class="pj-field-err @error('responsibilities') show @enderror"
                                        id="err-responsibilities">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('responsibilities')
                                                {{ $message }}
                                            @else
                                                Please enter job responsibilities.
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="pj-char-counter"><span id="respCount">0</span>/2000</div>
                                </div>
                            </div>

                            <div class="pj-fgroup">
                                <label class="pj-label" for="benefits">
                                    <i class="fa-solid fa-gift"></i> Benefits <span class="pj-opt">Optional</span>
                                </label>
                                <div class="pj-iw">
                                    <i class="fa-solid fa-gift pj-iw-ico ta"></i>
                                    <textarea id="benefits" name="benefits" class="pj-input" style="padding-left:38px;min-height:90px;"
                                        placeholder="Health Insurance, Performance Bonus, Travel Allowance..." maxlength="500"
                                        oninput="updateCounter('benefits','benCount',500)">{{ old('benefits') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:flex-end;margin-top:4px;">
                                    <div class="pj-char-counter"><span id="benCount">0</span>/500</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>4</span> of 6 — Job Information</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-save-draft" onclick="saveDraft(event)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="pj-btn-prev" onclick="prevStep(4)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="pj-btn-next" onclick="nextStep(4)">Screening Questions <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 5 — SCREENING QUESTIONS ══ --}}
                <div class="pj-tab" id="pjTab5">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-clipboard-question"></i></div>
                            <div>
                                <div class="pj-card-head-title">Screening Questions</div>
                                <div class="pj-card-head-sub">Add questions to filter candidates before interview</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-sq-header">
                                <div>
                                    <div style="font-size:.85rem;font-weight:700;color:#374151;margin-bottom:3px;">
                                        Candidate Screening <span style="color:#9ca3af;font-weight:500;">(Optional)</span>
                                    </div>
                                    <div style="font-size:.78rem;color:#9ca3af;display:flex;align-items:center;gap:5px;">
                                        <i class="fa-solid fa-circle-info" style="font-size:.72rem;"></i>
                                        Candidates must answer these questions when applying
                                    </div>
                                </div>
                                <button type="button" class="pj-sq-add-btn" onclick="addScreeningQuestion()">
                                    <i class="fa-solid fa-circle-plus"></i> Add Question
                                </button>
                            </div>
                            <div id="sqList" class="pj-sq-list"></div>
                            <div id="sqEmpty" class="pj-sq-empty">
                                <i class="fa-solid fa-clipboard-question"></i>
                                <p>No screening questions added yet.<br>Click "Add Question" to create your first question.
                                </p>
                            </div>
                            <input type="hidden" name="screening_questions" id="screeningQuestionsData"
                                value="{{ old('screening_questions', '[]') }}" />
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>5</span> of 6 — Screening Questions</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-save-draft" onclick="saveDraft(event)"><i
                                    class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                            <button type="button" class="pj-btn-prev" onclick="prevStep(5)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="button" class="pj-btn-next" onclick="nextStep(5)">Preview & Publish <i
                                    class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 6 — REVIEW & PUBLISH ══ --}}
                <div class="pj-tab" id="pjTab6">
                    <div class="pj-card">
                        <div class="pj-card-head">
                            <div class="pj-card-head-ico"><i class="fa-solid fa-eye"></i></div>
                            <div>
                                <div class="pj-card-head-title">Review & Publish</div>
                                <div class="pj-card-head-sub">Confirm your job details before going live</div>
                            </div>
                        </div>
                        <div class="pj-card-body">
                            <div class="pj-preview-banner">
                                <div style="position:relative;z-index:1;">
                                    <div class="pj-preview-title" id="rev-title">—</div>
                                    <div class="pj-preview-company">
                                        {{ auth()->user()->company->name ?? 'Your Company' }} &middot; <span
                                            id="rev-location">—</span>
                                    </div>
                                    <div class="pj-preview-chips" id="rev-chips"></div>
                                </div>
                            </div>
                            <div class="pj-review-grid" id="reviewGrid">
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Plan</div>
                                    <div class="pj-review-value" id="rev-plan">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Category</div>
                                    <div class="pj-review-value" id="rev-category">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Industry</div>
                                    <div class="pj-review-value" id="rev-industry">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Experience</div>
                                    <div class="pj-review-value" id="rev-exp">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Salary Range</div>
                                    <div class="pj-review-value" id="rev-salary">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Job Type</div>
                                    <div class="pj-review-value" id="rev-jobtype">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Education</div>
                                    <div class="pj-review-value" id="rev-education">—</div>
                                </div>
                                <div class="pj-review-item">
                                    <div class="pj-review-label">Vacancies</div>
                                    <div class="pj-review-value" id="rev-vacancies">—</div>
                                </div>
                                <div class="pj-review-item" style="grid-column:1/-1;">
                                    <div class="pj-review-label">Skills</div>
                                    <div class="pj-review-value" id="rev-skills">—</div>
                                </div>
                                <div class="pj-review-item" style="grid-column:1/-1;">
                                    <div class="pj-review-label">Screening Questions</div>
                                    <div class="pj-review-value" id="rev-sq">None added</div>
                                </div>
                            </div>
                            <div
                                style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:14px 16px;display:flex;align-items:flex-start;gap:12px;">
                                <input type="checkbox" id="termsCheck" name="terms" value="1"
                                    style="width:16px;height:16px;accent-color:#1a56db;margin-top:2px;flex-shrink:0;cursor:pointer;">
                                <label for="termsCheck"
                                    style="font-size:.83rem;color:#166534;cursor:pointer;line-height:1.5;">
                                    I confirm that all job details are accurate and comply with LinearJobs'
                                    <a href="{{ route('home') }}" target="_blank"
                                        style="color:#1a56db;font-weight:600;">Terms &amp; Conditions</a>.
                                    I agree not to post fraudulent or misleading job listings.
                                </label>
                            </div>
                            <div class="pj-field-err" id="err-terms" style="margin-top:6px;">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>Please accept the terms and conditions.</span>
                            </div>
                        </div>
                    </div>
                    <div class="pj-footer">
                        <div class="pj-step-info">Step <span>6</span> of 6 — Final Review</div>
                        <div class="pj-footer-btns">
                            <button type="button" class="pj-btn-prev" onclick="prevStep(6)"><i
                                    class="fa-solid fa-arrow-left"></i> Back</button>
                            <button type="submit" class="pj-btn-publish" id="publishBtn">
                                <i class="fa-solid fa-rocket"></i> Publish Job Now
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

            /* ════════════════════════════════════════════
               STEP NAVIGATION
            ════════════════════════════════════════════ */
            var currentStep = 1;

            function showStep(step) {
                document.querySelectorAll('.pj-tab').forEach(function(t) {
                    t.classList.remove('active');
                });
                document.getElementById('pjTab' + step).classList.add('active');

                document.querySelectorAll('.pj-step').forEach(function(s) {
                    var n = parseInt(s.getAttribute('data-step'), 10);
                    s.classList.remove('active', 'done');
                    var circle = document.getElementById('pjStepCircle' + n);
                    if (!circle) return;
                    if (n === step) {
                        s.classList.add('active');
                        // restore icon
                        var stepIcons = ['fa-tag', 'fa-file-lines', 'fa-location-dot', 'fa-circle-info',
                            'fa-question-circle', 'fa-eye'
                        ];
                        circle.innerHTML = '<i class="fa-solid ' + (stepIcons[n - 1] || 'fa-circle') +
                            '" style="font-size:.6rem;"></i>';
                    } else if (n < step) {
                        s.classList.add('done');
                        circle.innerHTML = '<i class="fa-solid fa-check" style="font-size:.6rem;"></i>';
                    } else {
                        // future step — restore icon
                        var stepIcons2 = ['fa-tag', 'fa-file-lines', 'fa-location-dot', 'fa-circle-info',
                            'fa-question-circle', 'fa-eye'
                        ];
                        circle.innerHTML = '<i class="fa-solid ' + (stepIcons2[n - 1] || 'fa-circle') +
                            '" style="font-size:.6rem;"></i>';
                    }
                });

                currentStep = step;
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                if (step === 6) {
                    buildReview();
                }
            }

            window.nextStep = function(from) {
                if (!validateStep(from)) {
                    return;
                }
                showStep(from + 1);
            };

            window.prevStep = function(from) {
                showStep(from - 1);
            };

            /* ════════════════════════════════════════════
               HELPERS
            ════════════════════════════════════════════ */
            function getVal(name) {
                var el = document.querySelector('[name="' + name + '"]');
                return el ? el.value.trim() : '';
            }

            function showFieldError(id, msg) {
                var field = document.getElementById(id);
                var errEl = document.getElementById('err-' + id);
                if (field) {
                    field.classList.add('err');
                }
                if (errEl) {
                    errEl.classList.add('show');
                    var sp = errEl.querySelector('span');
                    if (sp && msg) {
                        sp.textContent = msg;
                    }
                }
            }

            function clearStepErrors(step) {
                var tab = document.getElementById('pjTab' + step);
                if (!tab) {
                    return;
                }
                tab.querySelectorAll('.pj-field-err').forEach(function(e) {
                    e.classList.remove('show');
                });
                tab.querySelectorAll('.pj-input').forEach(function(i) {
                    i.classList.remove('err');
                });
                var alertEl = document.getElementById('alert' + step);
                if (alertEl) {
                    alertEl.classList.remove('show');
                }
            }

            /* ════════════════════════════════════════════
               VALIDATION
            ════════════════════════════════════════════ */
            function validateStep(step) {
                clearStepErrors(step);
                var ok = true;
                var alertEl = document.getElementById('alert' + step);

                if (step === 1) {
                    var plan = document.querySelector('input[name="plan_id"]:checked');
                    if (!plan) {
                        if (alertEl) {
                            alertEl.classList.add('show');
                        }
                        ok = false;
                    }
                }

                if (step === 2) {
                    var jobTitle = getVal('job_title');
                    if (jobTitle.length < 3) {
                        showFieldError('job_title', 'Job title must be at least 3 characters.');
                        ok = false;
                    }
                    if (!getVal('job_category')) {
                        showFieldError('job_category', 'Please select a category.');
                        ok = false;
                    }
                    if (!getVal('industry_type')) {
                        showFieldError('industry_type', 'Please select an industry.');
                        ok = false;
                    }
                }

                if (step === 3) {
                    if (!getVal('state')) {
                        showFieldError('state', 'Please select a state.');
                        ok = false;
                    }
                    if (!getVal('district')) {
                        showFieldError('district', 'Please select a district.');
                        ok = false;
                    }
                    if (getVal('city').length < 2) {
                        showFieldError('city', 'Please enter the city.');
                        ok = false;
                    }
                }

                if (step === 4) {
                    if (!getVal('experience_required')) {
                        showFieldError('experience_required', 'Please select experience level.');
                        ok = false;
                    }

                    var vacVal = document.getElementById('vacancies') ? document.getElementById('vacancies').value
                    .trim() : '';
                    if (!vacVal || parseInt(vacVal, 10) < 1) {
                        showFieldError('vacancies', 'Please enter at least 1 vacancy.');
                        ok = false;
                    }

                    // Salary: field may be empty string or a number (including 0)
                    var salaryMinEl = document.getElementById('salary_min');
                    var salaryMinVal = salaryMinEl ? salaryMinEl.value.trim() : '';
                    if (salaryMinVal === '') {
                        showFieldError('salary_min', 'Please enter minimum salary (use 0 if not disclosed).');
                        ok = false;
                    }

                    if (!getVal('education')) {
                        showFieldError('education', 'Please select education requirement.');
                        ok = false;
                    }

                    // Skills
                    if (selectedSkills.length === 0) {
                        var errSkills = document.getElementById('err-skills');
                        if (errSkills) {
                            errSkills.classList.add('show');
                        }
                        ok = false;
                    }

                    var desc = document.getElementById('description') ? document.getElementById('description').value
                        .trim() : '';
                    if (desc.length < 50) {
                        showFieldError('description', 'Job description is required (min. 50 characters).');
                        ok = false;
                    }

                    var resp = document.getElementById('responsibilities') ? document.getElementById('responsibilities')
                        .value.trim() : '';
                    if (resp.length < 20) {
                        showFieldError('responsibilities', 'Please enter job responsibilities (min. 20 characters).');
                        ok = false;
                    }

                    // Save skills to hidden field
                    document.getElementById('skillsHidden').value = JSON.stringify(selectedSkills);
                }

                if (step === 5) {
                    // Optional step — just save data
                    saveScreeningData();
                }

                if (!ok && alertEl) {
                    alertEl.classList.add('show');
                }
                return ok;
            }

            /* ════════════════════════════════════════════
               LIVE ERROR CLEAR
            ════════════════════════════════════════════ */
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.pj-input').forEach(function(inp) {
                    ['input', 'change'].forEach(function(ev) {
                        inp.addEventListener(ev, function() {
                            this.classList.remove('err');
                            var e = document.getElementById('err-' + this.id);
                            if (e) {
                                e.classList.remove('show');
                            }
                        });
                    });
                });
                initSkills();
                updateCounter('description', 'descCount', 3000);
                updateCounter('responsibilities', 'respCount', 2000);
                updateCounter('benefits', 'benCount', 500);
            });

            /* ════════════════════════════════════════════
               CHAR COUNTER
            ════════════════════════════════════════════ */
            window.updateCounter = function(fieldId, counterId, max) {
                var field = document.getElementById(fieldId);
                var counter = document.getElementById(counterId);
                if (field && counter) {
                    counter.textContent = field.value.length;
                    counter.style.color = field.value.length > max * 0.9 ? '#ef4444' : '#9ca3af';
                }
            };

            /* ════════════════════════════════════════════
               SKILLS MULTI-SELECT
            ════════════════════════════════════════════ */
            var selectedSkills = [];

            @php
                $defaultSkills = ['PHP Developer', 'Java Developer', 'Python Developer', 'React Developer', 'Angular Developer', 'Node.js Developer', 'MySQL / Database', 'WordPress Developer', 'UI/UX Designer', 'Network Engineer', 'Electrician', 'Plumber', 'Welder', 'Machine Operator', 'CNC Operator', 'Lathe Operator', 'Mechanic', 'HVAC Technician', 'Quality Inspector', 'Sales Executive', 'Marketing Executive', 'Field Sales', 'Tele-calling', 'Data Entry', 'HR Executive', 'Accountant', 'Office Admin', 'Receptionist', 'Driver', 'Delivery Executive', 'Forklift Operator', 'Warehouse Staff'];
            @endphp

            var ALL_SKILLS = @json($skills ?? $defaultSkills);


            function initSkills() {
                var oldVal = document.getElementById('skillsHidden').value;
                if (oldVal && oldVal !== '') {
                    try {
                        var parsed = JSON.parse(oldVal);
                        if (Array.isArray(parsed) && parsed.length > 0) {
                            parsed.forEach(function(s) {
                                if (s && selectedSkills.indexOf(s) === -1) {
                                    selectedSkills.push(s);
                                    renderSkillChip(s);
                                }
                            });
                        }
                    } catch (e) {
                        /* ignore */ }
                }
                renderSkillsDropdown('');
            }

            window.openSkillsDropdown = function() {
                filterSkills(document.getElementById('skillSearch').value);
                document.getElementById('skillsDropdown').classList.add('open');
            };

            window.closeSkillsDropdown = function() {
                document.getElementById('skillsDropdown').classList.remove('open');
            };

            window.filterSkills = function(query) {
                var dropdown = document.getElementById('skillsDropdown');
                if (!dropdown) {
                    return;
                }
                var q = (query || '').toLowerCase();
                var filtered = ALL_SKILLS.filter(function(s) {
                    return s.toLowerCase().indexOf(q) !== -1 && selectedSkills.indexOf(s) === -1;
                });
                if (filtered.length === 0) {
                    dropdown.innerHTML = '<div class="pj-skills-no-result">No matching skills found</div>';
                } else {
                    dropdown.innerHTML = filtered.slice(0, 8).map(function(s) {
                        var safe = s.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
                        return '<div class="pj-skill-opt" onmousedown="event.preventDefault();addSkill(\'' +
                            safe + '\')">' +
                            '<i class="fa-solid fa-screwdriver-wrench" style="font-size:.7rem;color:#9ca3af;"></i> ' +
                            s +
                            '</div>';
                    }).join('');
                }
                dropdown.classList.add('open');
            };

            function renderSkillsDropdown(query) {
                window.filterSkills(query);
            }

            window.addSkill = function(skill) {
                if (!skill || selectedSkills.indexOf(skill) !== -1 || selectedSkills.length >= 10) {
                    return;
                }
                selectedSkills.push(skill);
                renderSkillChip(skill);
                document.getElementById('skillSearch').value = '';
                window.filterSkills('');
                var errSkills = document.getElementById('err-skills');
                if (errSkills) {
                    errSkills.classList.remove('show');
                }
            };

            function renderSkillChip(skill) {
                var chip = document.createElement('div');
                chip.className = 'pj-skill-chip';
                chip.setAttribute('data-skill', skill);
                var safe = skill.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
                chip.innerHTML = skill + '<button type="button" onclick="removeSkill(\'' + safe +
                    '\')"><i class="fa-solid fa-xmark"></i></button>';
                document.getElementById('skillChips').appendChild(chip);
            }

            window.removeSkill = function(skill) {
                selectedSkills = selectedSkills.filter(function(s) {
                    return s !== skill;
                });
                var chips = document.getElementById('skillChips');
                if (chips) {
                    var allChips = chips.querySelectorAll('.pj-skill-chip');
                    allChips.forEach(function(c) {
                        if (c.getAttribute('data-skill') === skill) {
                            c.remove();
                        }
                    });
                }
                window.filterSkills(document.getElementById('skillSearch').value);
            };

            window.handleSkillKey = function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var val = e.target.value.trim();
                    if (val) {
                        window.addSkill(val);
                    }
                }
            };

            /* ════════════════════════════════════════════
               SCREENING QUESTIONS
            ════════════════════════════════════════════ */
            var sqCount = 0;
            var optCounts = {};

            window.addScreeningQuestion = function() {
                sqCount++;
                var qId = 'sq_' + sqCount;
                var block = document.createElement('div');
                block.className = 'pj-sq-block';
                block.id = qId;
                block.innerHTML = buildQuestionBlock(qId, sqCount);
                document.getElementById('sqList').appendChild(block);
                document.getElementById('sqEmpty').style.display = 'none';
                saveScreeningData();
            };

            function buildQuestionBlock(qId, num) {
                return '<div class="pj-sq-block-head">' +
                    '<div class="pj-sq-num">Q' + num + '</div>' +
                    '<div class="pj-sq-q-preview" id="' + qId + '_preview">New Question ' + num + '</div>' +
                    '<span class="pj-sq-type-badge select" id="' + qId + '_badge">Multiple Choice</span>' +
                    '<div class="pj-sq-actions">' +
                    '<button type="button" class="pj-sq-action-btn delete" onclick="deleteQuestion(\'' + qId +
                    '\')" title="Delete"><i class="fa-solid fa-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '<div class="pj-sq-block-body">' +
                    '<div class="pj-fgroup">' +
                    '<label class="pj-label"><i class="fa-solid fa-question-circle"></i> Question <span class="pj-req">*</span></label>' +
                    '<div class="pj-iw"><i class="fa-solid fa-question pj-iw-ico"></i>' +
                    '<input type="text" id="' + qId + '_question" class="pj-input"' +
                    ' placeholder="e.g. Do you have a valid driving licence?"' +
                    ' oninput="var p=document.getElementById(\'' + qId +
                    '_preview\');if(p){p.textContent=this.value||\'New Question\'}saveScreeningData();" />' +
                    '</div></div>' +
                    '<label class="pj-label" style="margin-bottom:8px;"><i class="fa-solid fa-list"></i> Question Type <span class="pj-req">*</span></label>' +
                    '<div class="pj-sq-type-row">' +
                    '<div class="pj-sq-type-opt"><input type="radio" id="' + qId + '_type_select" name="' + qId +
                    '_type" value="select" checked onchange="syncTypeSelection(\'' + qId + '\',\'select\')">' +
                    '<label for="' + qId +
                    '_type_select"><i class="fa-solid fa-list-ul"></i> Select Option</label></div>' +
                    '<div class="pj-sq-type-opt"><input type="radio" id="' + qId + '_type_input" name="' + qId +
                    '_type" value="input" onchange="syncTypeSelection(\'' + qId + '\',\'input\')">' +
                    '<label for="' + qId +
                    '_type_input"><i class="fa-solid fa-keyboard"></i> Text Input</label></div>' +
                    '</div>' +
                    '<div id="' + qId + '_select_fields" class="pj-sq-options-wrap">' +
                    '<div class="pj-sq-options-label">Answer Options</div>' +
                    '<div id="' + qId + '_options">' +
                    buildOption(qId, 1, 'A') +
                    buildOption(qId, 2, 'B') +
                    buildOption(qId, 3, 'C') +
                    buildOption(qId, 4, 'D') +
                    '</div>' +
                    '<button type="button" class="pj-add-opt-btn" onclick="addOption(\'' + qId +
                    '\')"><i class="fa-solid fa-plus"></i> Add Option</button>' +
                    '</div>' +
                    '<div id="' + qId + '_input_fields" style="display:none;">' +
                    '<div class="pj-sq-answer-preview"><i class="fa-solid fa-keyboard" style="color:#9ca3af;"></i> Candidate will type their answer in a text field</div>' +
                    '</div>' +
                    '</div>';
            }

            function buildOption(qId, num, letter) {
                var removeBtn = num > 2 ?
                    '<button type="button" class="pj-opt-remove" onclick="removeOption(\'' + qId + '\',' + num +
                    ')" title="Remove"><i class="fa-solid fa-xmark"></i></button>' :
                    '<span style="width:22px;display:inline-block;"></span>';
                return '<div class="pj-sq-option-row" id="' + qId + '_opt_row_' + num + '">' +
                    '<i class="fa-solid fa-grip-dots-vertical pj-opt-handle"></i>' +
                    '<div class="pj-opt-letter">' + letter + '</div>' +
                    '<input type="text" class="pj-opt-input" id="' + qId + '_opt_' + num + '" placeholder="Option ' +
                    letter + '" oninput="saveScreeningData()" />' +
                    removeBtn +
                    '</div>';
            }

            window.addOption = function(qId) {
                if (!optCounts[qId]) {
                    optCounts[qId] = 4;
                }
                optCounts[qId]++;
                var n = optCounts[qId];
                var letters = 'ABCDEFGHIJKLMNOP';
                var letter = n <= letters.length ? letters[n - 1] : String(n);
                var container = document.getElementById(qId + '_options');
                if (!container) {
                    return;
                }
                var tmp = document.createElement('div');
                tmp.innerHTML = buildOption(qId, n, letter);
                container.appendChild(tmp.firstElementChild);
                saveScreeningData();
            };

            window.removeOption = function(qId, num) {
                var row = document.getElementById(qId + '_opt_row_' + num);
                if (row) {
                    row.remove();
                }
                saveScreeningData();
            };

            window.syncTypeSelection = function(qId, type) {
                var sel = document.getElementById(qId + '_select_fields');
                var inp = document.getElementById(qId + '_input_fields');
                var badge = document.getElementById(qId + '_badge');
                if (type === 'select') {
                    if (sel) {
                        sel.style.display = 'block';
                    }
                    if (inp) {
                        inp.style.display = 'none';
                    }
                    if (badge) {
                        badge.className = 'pj-sq-type-badge select';
                        badge.textContent = 'Multiple Choice';
                    }
                } else {
                    if (sel) {
                        sel.style.display = 'none';
                    }
                    if (inp) {
                        inp.style.display = 'block';
                    }
                    if (badge) {
                        badge.className = 'pj-sq-type-badge input';
                        badge.textContent = 'Text Input';
                    }
                }
                saveScreeningData();
            };

            window.deleteQuestion = function(qId) {
                var block = document.getElementById(qId);
                if (!block) {
                    return;
                }
                block.style.opacity = '0';
                block.style.transform = 'scale(.97)';
                block.style.transition = 'all .2s';
                setTimeout(function() {
                    block.remove();
                    renumberQuestions();
                    if (document.getElementById('sqList').children.length === 0) {
                        document.getElementById('sqEmpty').style.display = 'block';
                    }
                    saveScreeningData();
                }, 200);
            };

            function renumberQuestions() {
                document.querySelectorAll('.pj-sq-block').forEach(function(block, i) {
                    var num = block.querySelector('.pj-sq-num');
                    if (num) {
                        num.textContent = 'Q' + (i + 1);
                    }
                });
            }

            function saveScreeningData() {
                var data = [];
                document.querySelectorAll('.pj-sq-block').forEach(function(block) {
                    var qId = block.id;
                    var qInput = document.getElementById(qId + '_question');
                    var question = qInput ? qInput.value : '';
                    var typeRadio = document.querySelector('input[name="' + qId + '_type"]:checked');
                    var type = typeRadio ? typeRadio.value : 'select';
                    var q = {
                        question: question,
                        type: type,
                        options: []
                    };
                    if (type === 'select') {
                        block.querySelectorAll('.pj-opt-input').forEach(function(opt) {
                            if (opt.value.trim()) {
                                q.options.push(opt.value.trim());
                            }
                        });
                    }
                    data.push(q);
                });
                var hidden = document.getElementById('screeningQuestionsData');
                if (hidden) {
                    hidden.value = JSON.stringify(data);
                }
            }

            /* ════════════════════════════════════════════
               REVIEW BUILD (Step 6)
            ════════════════════════════════════════════ */
            function buildReview() {
                var planRadio = document.querySelector('input[name="plan_id"]:checked');
                var planVal = planRadio ? planRadio.value : '';

                var setText = function(id, txt) {
                    var el = document.getElementById(id);
                    if (el) {
                        el.textContent = txt || '—';
                    }
                };

                setText('rev-title', getVal('job_title'));

                var city = getVal('city'),
                    district = getVal('district'),
                    state = getVal('state');
                var loc = [city, district, state].filter(Boolean).join(', ');
                setText('rev-location', loc || '—');

                setText('rev-plan', planVal === '15_day' ? '15 Day Plan — ₹600 + GST' : planVal === '30_day' ?
                    '30 Day Plan — ₹1000 + GST' : '—');
                setText('rev-category', getVal('job_category'));
                setText('rev-industry', getVal('industry_type'));
                setText('rev-exp', getVal('experience_required'));

                var salMinEl = document.getElementById('salary_min');
                var salMaxEl = document.getElementById('salary_max');
                var smin = salMinEl ? salMinEl.value.trim() : '';
                var smax = salMaxEl ? salMaxEl.value.trim() : '';
                if (smin !== '' || smax !== '') {
                    setText('rev-salary', '₹' + (parseInt(smin, 10) || 0).toLocaleString('en-IN') + ' – ₹' + (parseInt(
                        smax, 10) || 0).toLocaleString('en-IN') + ' /mo');
                } else {
                    setText('rev-salary', 'Not disclosed');
                }

                var jobTypeRadio = document.querySelector('input[name="job_type"]:checked');
                setText('rev-jobtype', jobTypeRadio ? jobTypeRadio.value : '—');
                setText('rev-education', getVal('education'));
                setText('rev-vacancies', getVal('vacancies'));
                setText('rev-skills', selectedSkills.length ? selectedSkills.join(', ') : 'None selected');

                try {
                    var sqDataStr = document.getElementById('screeningQuestionsData').value || '[]';
                    var sqData = JSON.parse(sqDataStr);
                    setText('rev-sq', sqData.length > 0 ? sqData.length + ' question(s) added' : 'None added');
                } catch (e) {
                    setText('rev-sq', 'None added');
                }

                // Preview chips
                var chips = document.getElementById('rev-chips');
                if (chips) {
                    chips.innerHTML = '';
                    if (jobTypeRadio) {
                        chips.innerHTML += '<span class="pj-preview-chip"><i class="fa-solid fa-clock"></i> ' +
                            jobTypeRadio.value + '</span>';
                    }
                    if (smin !== '') {
                        chips.innerHTML +=
                            '<span class="pj-preview-chip"><i class="fa-solid fa-indian-rupee-sign"></i> ₹' +
                            (parseInt(smin, 10) || 0).toLocaleString('en-IN') + '–₹' +
                            (parseInt(smax, 10) || 0).toLocaleString('en-IN') + '/mo</span>';
                    }
                    var expVal = getVal('experience_required');
                    if (expVal) {
                        chips.innerHTML += '<span class="pj-preview-chip"><i class="fa-solid fa-briefcase"></i> ' +
                            expVal + '</span>';
                    }
                }
            }

            /* ════════════════════════════════════════════
               PUBLISH VALIDATION
            ════════════════════════════════════════════ */
            var form = document.getElementById('postJobForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var terms = document.getElementById('termsCheck');
                    var errTerms = document.getElementById('err-terms');
                    if (!terms || !terms.checked) {
                        e.preventDefault();
                        if (errTerms) {
                            errTerms.classList.add('show');
                        }
                        return;
                    }
                    if (errTerms) {
                        errTerms.classList.remove('show');
                    }
                    var btn = document.getElementById('publishBtn');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Publishing...';
                    }
                });
            }

            var termsCheck = document.getElementById('termsCheck');
            if (termsCheck) {
                termsCheck.addEventListener('change', function() {
                    if (this.checked) {
                        var errTerms = document.getElementById('err-terms');
                        if (errTerms) {
                            errTerms.classList.remove('show');
                        }
                    }
                });
            }

            /* ════════════════════════════════════════════
               SAVE DRAFT
            ════════════════════════════════════════════ */
            window.saveDraft = function(e) {
                var btn = e && e.currentTarget ? e.currentTarget : (e && e.target ? e.target : null);
                if (!btn) {
                    return;
                }
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                btn.disabled = true;
                setTimeout(function() {
                    btn.innerHTML = '<i class="fa-solid fa-check" style="color:#16a34a;"></i> Saved!';
                    setTimeout(function() {
                        btn.innerHTML = '<i class="fa-regular fa-floppy-disk"></i> Save Draft';
                        btn.disabled = false;
                    }, 2000);
                }, 800);
            };

        })();
    </script>
@endpush
