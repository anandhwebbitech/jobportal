@extends('frontend.app')
@section('title', 'LinearJobs – Find Your Next Job in India')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ══════════════════════════════════════════════════════
               ROOT
            ══════════════════════════════════════════════════════ */
        .error {
            border: 1px solid red !important;
        }

        :root {
            --blue: #1a56db;
            --blue-d: #1e3a8a;
            --blue-lt: rgba(26, 86, 219, .08);
            --green: #059669;
            --green-d: #064e3b;
            --green-lt: rgba(5, 150, 105, .08);

            --n0: #ffffff;
            --n50: #ffffff;
            /* Forced pure white background */
            --n100: #f0f1f7;
            --n150: #e8eaf2;
            --n200: #dde0ec;
            --n300: #c2c7d9;
            --n400: #8f96b0;
            --n500: #636a82;
            --n600: #464d63;
            --n700: #343b52;
            --n800: #1e2333;
            --n900: #0f1320;

            --r: 12px;
            --r-sm: 8px;
            --r-lg: 18px;
            --r-xl: 24px;
            --t: .2s ease;
            --fh: 'Outfit', sans-serif;
            --fb: 'Geist', sans-serif;
            --sh: 0 2px 10px rgba(0, 0, 0, .07);
            --sh-md: 0 8px 32px rgba(0, 0, 0, .10);
            --sh-lg: 0 20px 60px rgba(0, 0, 0, .14);
            --sh-xl: 0 32px 80px rgba(0, 0, 0, .18);
            --nav-h: 68px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--fb);
            background: var(--n50);
            color: var(--n900);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            font-size: 16px;
            /* Increased base font size */
        }

        /* ── PAGE BG ── */
        .page-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
            background-color: var(--n50);
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .7;
        }

        .bg-orb-1 {
            width: 700px;
            height: 700px;
            top: -250px;
            right: -180px;
            background: radial-gradient(circle, rgba(5, 150, 105, .06) 0%, transparent 70%);
        }

        .bg-orb-2 {
            width: 560px;
            height: 560px;
            bottom: -180px;
            left: -140px;
            background: radial-gradient(circle, rgba(5, 150, 105, .05) 0%, transparent 70%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(180, 185, 210, .08) 1px, transparent 1px), linear-gradient(90deg, rgba(180, 185, 210, .08) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        /* ══════════════════════════════════════════════════════
               HEADER & NAV
            ══════════════════════════════════════════════════════ */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            height: var(--nav-h);
            display: flex;
            align-items: center;
            padding: 0 40px;
            background: rgba(255, 255, 255, .82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(221, 224, 236, .6);
            transition: background .3s ease, box-shadow .3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 2px 20px rgba(0, 0, 0, .08);
        }

        .nav-logo {
            font-family: var(--fh);
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -.5px;
            color: var(--green);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ══════════════════════════════════════════════════════
               MAIN — REGISTER SPLIT LAYOUT
            ══════════════════════════════════════════════════════ */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 20px 80px;
            position: relative;
            z-index: 1;
        }

        .reg-split {
            display: grid;
            grid-template-columns: 380px 1fr;
            /* Slightly wider sidebar */
            max-width: 1200px;
            /* Increased max width */
            width: 100%;
            gap: 36px;
            /* Better gapping between columns */
            align-items: flex-start;
        }

        /* ── LEFT SIDEBAR ── */
        .reg-left {
            position: sticky;
            top: calc(var(--nav-h) + 32px);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--sh-lg);
            transition: background .45s ease;
            animation: sideIn .45s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes sideIn {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .reg-left.mode-green {
            background: linear-gradient(152deg, #059669 0%, #064e3b 100%);
        }

        .rl-inner {
            padding: 48px 36px 36px;
            position: relative;
            overflow: hidden;
        }

        .rl-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            background: rgba(255, 255, 255, .06);
        }

        .rl-orb-1 {
            width: 280px;
            height: 280px;
            top: -80px;
            right: -70px;
        }

        .rl-orb-2 {
            width: 180px;
            height: 180px;
            bottom: -50px;
            left: -40px;
        }

        .rl-dots {
            position: absolute;
            top: 32px;
            left: 32px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 9px;
            opacity: .1;
            pointer-events: none;
        }

        .rl-dots span {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #fff;
            display: block;
        }

        .rl-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: .8rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .95);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 20px;
            width: fit-content;
        }

        .rl-title {
            font-family: var(--fh);
            font-size: 1.7rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
            letter-spacing: -.03em;
            margin-bottom: 12px;
        }

        .rl-sub {
            font-size: 1rem;
            color: rgba(255, 255, 255, .75);
            line-height: 1.6;
            margin-bottom: 36px;
        }

        .rl-perks {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .rl-perk {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .rl-perk-ico {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 10px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: #fff;
        }

        .rl-perk-body {
            font-size: .95rem;
            color: rgba(255, 255, 255, .8);
            line-height: 1.5;
        }

        .rl-perk-body strong {
            color: #fff;
            display: block;
            font-size: 1rem;
            margin-bottom: 3px;
            font-weight: 700;
        }

        .rl-stats {
            padding: 24px 36px;
            border-top: 1px solid rgba(255, 255, 255, .13);
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
        }

        .rl-stat-val {
            font-family: var(--fh);
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .rl-stat-lbl {
            font-size: .8rem;
            color: rgba(255, 255, 255, .6);
            margin-top: 6px;
            font-weight: 500;
        }

        .rl-steps {
            padding: 24px 36px 32px;
            border-top: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .rl-step {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 0;
            position: relative;
        }

        .rl-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 15px;
            top: 44px;
            width: 2px;
            height: calc(100% - 20px);
            background: rgba(255, 255, 255, .15);
            border-radius: 2px;
        }

        .rl-step.s-done::after {
            background: rgba(255, 255, 255, .4);
        }

        .rl-step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            font-weight: 700;
            z-index: 1;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .5);
            transition: all .25s ease;
        }

        .reg-left.mode-green .rl-step.s-active .rl-step-num {
            color: var(--green);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, .2);
        }

        .rl-step.s-done .rl-step-num {
            background: rgba(255, 255, 255, .25);
            color: #fff;
        }

        .rl-step-name {
            font-size: 1rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .5);
            transition: color .25s ease;
        }

        .rl-step.s-active .rl-step-name {
            color: #fff;
            font-weight: 700;
        }

        .rl-step.s-done .rl-step-name {
            color: rgba(255, 255, 255, .8);
        }

        /* ── RIGHT FORM AREA ── */
        .reg-right {
            animation: formIn .45s .1s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes formIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── FORM CARD ── */
        .lj-card {
            background: #fff;
            border: 1px solid var(--n200);
            border-radius: var(--r-xl);
            box-shadow: var(--sh-md);
            overflow: hidden;
        }

        .card-head {
            padding: 24px 36px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .card-head.green-hd {
            background: linear-gradient(90deg, #059669, #10b981);
        }

        .card-head>i {
            color: rgba(255, 255, 255, .95);
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .card-head-title {
            font-family: var(--fh);
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
        }

        .card-head-sub {
            font-size: .9rem;
            color: rgba(255, 255, 255, .8);
            margin-top: 4px;
        }

        .card-body {
            padding: 36px 40px;
        }

        .card-foot {
            padding: 24px 40px;
            border-top: 1px solid var(--n100);
            background: var(--n50);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Panels */
        .panel {
            display: none;
        }

        .panel.active {
            display: block;
            animation: fadeUp .28s ease;
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

        /* ── FORM ELEMENTS ── */
        .fgrp {
            margin-bottom: 24px;
        }

        .frow {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .frow3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .flbl {
            display: block;
            font-size: .95rem;
            font-weight: 600;
            color: var(--n800);
            margin-bottom: 8px;
        }

        .flbl .req {
            color: #ef4444;
            margin-left: 4px;
        }

        .flbl .opt {
            font-size: .75rem;
            font-weight: 600;
            color: var(--n500);
            margin-left: 8px;
            background: var(--n100);
            padding: 3px 8px;
            border-radius: 100px;
        }

        .fiw {
            position: relative;
        }

        .fiw-l {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: 1rem;
            pointer-events: none;
        }

        .fiw-l.t {
            top: 16px;
            transform: none;
        }

        .fiw-r {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            transition: color var(--t);
        }

        .fiw-r:hover {
            color: var(--n700);
        }

        .finput {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: var(--r);
            padding: 12px 16px 12px 42px;
            font-family: var(--fb);
            font-size: 1rem;
            color: var(--n900);
            background: #fff;
            outline: none;
            transition: border-color var(--t), box-shadow var(--t);
        }

        .finput.no-ico {
            padding-left: 16px;
        }

        .finput.pr {
            padding-right: 44px;
        }

        .finput::placeholder {
            color: var(--n400);
        }

        .finput.fc-g:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, .12);
        }

        .finput.err {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, .12);
        }

        select.finput {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }

        textarea.finput {
            padding-top: 14px;
            resize: vertical;
            min-height: 100px;
            line-height: 1.5;
        }

        .fhint {
            font-size: .85rem;
            color: var(--n500);
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fhint i {
            font-size: .8rem;
            color: var(--n400);
        }

        .ferr-msg {
            font-size: .85rem;
            color: #dc2626;
            margin-top: 8px;
            display: none;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .ferr-msg.show {
            display: flex;
        }

        .ferr-msg i {
            font-size: .8rem;
            flex-shrink: 0;
        }

        .fsec {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 32px 0 24px;
        }

        .fsec-line {
            flex: 1;
            height: 1px;
            background: var(--n150);
        }

        .fsec-lbl {
            font-size: .85rem;
            font-weight: 800;
            color: var(--n500);
            letter-spacing: .1em;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fsec-lbl.gi {
            color: var(--green);
        }

        .step-alert {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: var(--r);
            padding: 14px 18px;
            margin-bottom: 24px;
            display: none;
            align-items: flex-start;
            gap: 12px;
            font-size: .95rem;
            color: #b91c1c;
            animation: shakeX .35s ease;
            font-weight: 500;
            line-height: 1.5;
        }

        .step-alert.show {
            display: flex;
        }

        @keyframes shakeX {

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

        .info-box {
            border-radius: var(--r);
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: .95rem;
            color: var(--n800);
            line-height: 1.5;
        }

        .info-box.green {
            background: var(--green-lt);
            border: 1.5px solid rgba(5, 150, 105, .15);
        }

        .info-box.green i {
            color: var(--green);
            flex-shrink: 0;
            margin-top: 2px;
            font-size: 1.1rem;
        }

        /* File zone */
        .file-zone {
            border: 2px dashed var(--n200);
            border-radius: var(--r);
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            transition: all var(--t);
            background: var(--n50);
            position: relative;
        }

        .file-zone:hover {
            border-color: var(--green);
            background: rgba(5, 150, 105, .04);
        }

        .file-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .fz-ico {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #fff;
            border: 1.5px solid var(--n200);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--n400);
            margin: 0 auto 12px;
            box-shadow: var(--sh);
            transition: all var(--t);
        }

        .file-zone:hover .fz-ico {
            border-color: var(--green);
            transform: translateY(-2px);
        }

        .fz-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--n800);
            margin-bottom: 6px;
        }

        .fz-sub {
            font-size: .85rem;
            color: var(--n500);
        }

        /* Password strength */
        .pwd-wrap {
            height: 6px;
            border-radius: 3px;
            background: var(--n150);
            margin-top: 10px;
            overflow: hidden;
        }

        .pwd-bar {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: width .3s, background .3s;
        }

        /* Summary */
        .summary-box {
            background: var(--n50);
            border: 1.5px solid var(--n200);
            border-radius: var(--r-lg);
            padding: 28px;
            margin-top: 32px;
            box-shadow: var(--sh);
        }

        .summary-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--n800);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-title i {
            font-size: 1.2rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 28px;
            font-size: .95rem;
            color: var(--n700);
            line-height: 1.5;
        }

        .summary-grid div span:first-child {
            color: var(--n500);
            display: inline-block;
            min-width: 80px;
        }

        .summary-grid div strong {
            color: var(--n900);
            font-weight: 600;
        }

        /* Card foot buttons */
        .foot-info {
            font-size: .95rem;
            color: var(--n600);
        }

        .foot-info a {
            color: var(--green);
            font-weight: 700;
            text-decoration: none;
            transition: color var(--t);
        }

        .foot-info a:hover {
            color: var(--green-d);
            text-decoration: underline;
        }

        .foot-btns {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-prev {
            border: 2px solid var(--n200);
            border-radius: var(--r);
            background: #fff;
            color: var(--n700);
            font-family: var(--fb);
            font-size: 1rem;
            font-weight: 700;
            padding: 12px 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--t);
        }

        .btn-prev:hover {
            border-color: var(--n400);
            background: var(--n50);
            color: var(--n900);
        }

        .btn-next,
        .btn-submit {
            border: none;
            border-radius: var(--r);
            color: #fff;
            font-family: var(--fb);
            font-size: 1rem;
            font-weight: 700;
            padding: 12px 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all var(--t);
            position: relative;
            overflow: hidden;
        }

        .green-next {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 14px rgba(5, 150, 105, .25);
        }

        .green-sub {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 6px 18px rgba(5, 150, 105, .3);
        }

        .btn-next:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
        }

        .green-next:hover {
            box-shadow: 0 6px 20px rgba(5, 150, 105, .35);
        }

        .green-sub:hover {
            box-shadow: 0 8px 24px rgba(5, 150, 105, .4);
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .15);
            opacity: 0;
            transition: opacity .2s ease;
        }

        .btn-submit:hover::after {
            opacity: 1;
        }

        .btn-submit:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .to-top {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 500;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(5, 150, 105, .35);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .3s ease, transform .3s ease;
            pointer-events: none;
        }

        .to-top.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        .to-top:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(5, 150, 105, .45);
        }

        /* ── RESPONSIVE ── */
        @media(max-width:860px) {
            .reg-split {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .reg-left {
                display: none;
            }
        }

        @media(max-width:580px) {

            .frow,
            .frow3 {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .card-head {
                padding: 20px 24px;
            }

            .card-body {
                padding: 24px 20px;
            }

            .card-foot {
                padding: 20px;
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }

            .foot-btns {
                justify-content: stretch;
                width: 100%;
            }

            .btn-prev,
            .btn-next,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            main {
                padding: 32px 16px 64px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .fgrp {
                margin-bottom: 20px;
            }

            .fsec {
                margin: 24px 0 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-bg" aria-hidden="true">
        <div class="bg-grid"></div>
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
    </div>

    <!-- ════════════════════════════════════
                 MAIN CONTENT
            ════════════════════════════════════ -->
    <main>
        <div class="reg-split">

            <!-- LEFT SIDEBAR -->
            <div class="reg-left mode-green" id="regLeft">
                <div class="rl-inner">
                    <div class="rl-orb rl-orb-1"></div>
                    <div class="rl-orb rl-orb-2"></div>
                    <div class="rl-dots" id="rlDots"></div>

                    <!-- Employer content -->
                    <div id="rlEmp">
                        <div class="rl-badge"><i class="fa-solid fa-building"></i> Employer</div>
                        <div class="rl-title">Register Your Company</div>
                        <div class="rl-sub">Connect with thousands of skilled professionals across Tamil Nadu.</div>
                        <div class="rl-perks">
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-users"></i></div>
                                <div class="rl-perk-body"><strong>50,000+ Candidates</strong>Access a large verified talent
                                    pool.</div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-tag"></i></div>
                                <div class="rl-perk-body"><strong>From ₹600</strong>Affordable plans for MSMEs.</div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-map-location-dot"></i></div>
                                <div class="rl-perk-body"><strong>All 32 Districts</strong>Reach candidates across Tamil
                                    Nadu.</div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-chart-line"></i></div>
                                <div class="rl-perk-body"><strong>Easy Dashboard</strong>Manage everything in one place.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rl-stats" id="rlStats">
                    <div>
                        <div class="rl-stat-val">1,200+</div>
                        <div class="rl-stat-lbl">Employers</div>
                    </div>
                    <div>
                        <div class="rl-stat-val">₹600</div>
                        <div class="rl-stat-lbl">Starting</div>
                    </div>
                    <div>
                        <div class="rl-stat-val">48hr</div>
                        <div class="rl-stat-lbl">Response</div>
                    </div>
                </div>
                <div class="rl-steps" id="rlSteps"></div>
            </div>

            <!-- RIGHT FORM -->
            <div class="reg-right">
                <!-- ════ EMPLOYER FORM ════ -->
                <form id="employer_registrationForm" method="POST" action="{{ route('employer_register.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="empForm">
                        <div class="lj-card">
                            <div class="card-head green-hd" id="empHead">
                                <i class="fa-solid fa-building" id="empHeadIco"></i>
                                <div>
                                    <div class="card-head-title" id="empHeadTitle">Company Information</div>
                                    <div class="card-head-sub" id="empHeadSub">Step 1 of 5 — Tell us about your business
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Emp Panel 1 -->
                                <div class="panel active" id="emp-p1">
                                    <div class="step-alert" id="emp-al1"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all required
                                            fields.</span></div>
                                    <div class="fgrp">
                                        <label class="flbl" for="company_name">Company Name <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-building fiw-l"></i>
                                            <input type="text" id="company_name" name="company_name" class="finput fc-g"
                                                placeholder="e.g. ABC Industries Pvt Ltd" />
                                        </div>
                                        <div class="ferr-msg" id="e-company_name"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Company name is
                                                required.</span></div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="company_address">Company Address <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-map-pin fiw-l t"></i>
                                            <textarea id="company_address" name="company_address" class="finput fc-g" rows="3"
                                                placeholder="Full registered address"></textarea>
                                        </div>
                                        <div class="ferr-msg" id="e-company_address"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Please enter your company
                                                address.</span></div>
                                    </div>
                                    <div class="frow3">
                                        <div class="fgrp">
                                            <label class="flbl" for="c_state">State <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-map fiw-l"></i>
                                                <select id="c_state" name="c_state" class="finput fc-g">
                                                    <option value="" disabled selected>Select State</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-c_state"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    state.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_district">District <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-location-dot fiw-l"></i>
                                                <select id="c_district" name="c_district" class="finput fc-g">
                                                    <option value="" disabled selected>Select District</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-c_district"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    district.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_city">City <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-city fiw-l"></i>
                                                <input type="text" id="c_city" name="c_city" class="finput fc-g"
                                                    placeholder="City" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_city"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please enter the
                                                    city.</span></div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="c_pincode">Pincode <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-hashtag fiw-l"></i>
                                            <input type="text" id="c_pincode" name="c_pincode" class="finput fc-g"
                                                placeholder="6-digit pincode" maxlength="6" style="max-width:240px;" />
                                        </div>
                                        <div class="ferr-msg" id="e-c_pincode"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 6-digit
                                                pincode.</span></div>
                                    </div>
                                </div>

                                <!-- Emp Panel 2 -->
                                <div class="panel" id="emp-p2">
                                    <div class="step-alert" id="emp-al2"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all contact
                                            fields.</span></div>
                                    <div class="fsec" style="margin-top:0;">
                                        <div class="fsec-lbl gi"><i class="fa-solid fa-user-tie"></i> Owner / Director
                                        </div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="c_ownername">Owner Name <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-user fiw-l"></i>
                                                <input type="text" id="c_ownername" name="c_ownername"
                                                    class="finput fc-g" placeholder="Full name" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_ownername"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Owner name is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_mobile">Owner Mobile <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-mobile-screen fiw-l"></i>
                                                <input type="tel" id="c_mobile" name="c_mobile" class="finput fc-g"
                                                    placeholder="+91 XXXXX XXXXX" maxlength="15" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_mobile"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit
                                                    mobile number.</span></div>
                                        </div>
                                    </div>
                                    <div class="fsec">
                                        <div class="fsec-lbl gi"><i class="fa-solid fa-user-gear"></i> HR / Recruiter
                                        </div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="info-box green"><i class="fa-solid fa-circle-info"></i><span>If you don't
                                            have a dedicated HR, enter the owner's details again below.</span></div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="c_hr_name">HR Name <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-user fiw-l"></i>
                                                <input type="text" id="c_hr_name" name="c_hr_name"
                                                    class="finput fc-g" placeholder="Full name" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_hr_name"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>HR name is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_hr_mobile">HR Mobile <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-mobile-screen fiw-l"></i>
                                                <input type="tel" id="c_hr_mobile" name="c_hr_mobile"
                                                    class="finput fc-g" placeholder="+91 XXXXX XXXXX" maxlength="15" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_hr_mobile"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit
                                                    mobile number.</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emp Panel 3 -->
                                <div class="panel" id="emp-p3">
                                    <div class="step-alert" id="emp-al3"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all account
                                            fields.</span></div>
                                    <div class="fgrp">
                                        <label class="flbl" for="c_email">Official Email Address <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-envelope fiw-l"></i>
                                            <input type="email" id="c_email" name="c_email" class="finput fc-g"
                                                placeholder="company@example.com" />
                                        </div>
                                        <div class="ferr-msg" id="e-c_email"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Enter a valid email
                                                address.</span></div>
                                        <div class="fhint"><i class="fa-solid fa-circle-info"></i> This will be your
                                            login email</div>
                                    </div>
                                    <div class="fsec">
                                        <div class="fsec-line"></div>
                                        <div class="fsec-lbl gi"><i class="fa-solid fa-lock"></i> Account Security</div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="c_password">Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="c_password" name="c_password"
                                                    class="finput pr fc-g" placeholder="Min. 8 characters"
                                                    oninput="pwdStr(this.value,'e-pb')" />
                                                <button type="button" class="fiw-r" onclick="togPwd('c_password',this)"
                                                    tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="pwd-wrap">
                                                <div class="pwd-bar" id="e-pb"></div>
                                            </div>
                                            <div class="ferr-msg" id="e-c_password"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Password must be at
                                                    least 8 characters.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_confirm_password">Confirm Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="c_confirm_password" name="c_confirm_password"
                                                    class="finput pr fc-g" placeholder="Re-enter password" />
                                                <button type="button" class="fiw-r"
                                                    onclick="togPwd('c_confirm_password',this)" tabindex="-1"><i
                                                        class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="ferr-msg" id="e-c_confirm_password"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Passwords do not
                                                    match.</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emp Panel 4 -->
                                <div class="panel" id="emp-p4">
                                    <div class="step-alert" id="emp-al4"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please provide valid GST and
                                            PAN numbers.</span></div>
                                    <div class="info-box green"><i class="fa-solid fa-shield-check"></i><span>Your
                                            business details are encrypted and used only for verification. Only verified
                                            employers can post jobs.</span></div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="c_gst">GST Number <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-receipt fiw-l"></i>
                                                <input type="text" id="c_gst" name="c_gst" class="finput fc-g"
                                                    placeholder="e.g. 33AABCU9603R1ZX" maxlength="15"
                                                    oninput="this.value=this.value.toUpperCase()" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_gst"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid
                                                    15-character GST number.</span></div>
                                            <div class="fhint"><i class="fa-solid fa-circle-info"></i> 15-character
                                                alphanumeric GST number</div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="c_pan">PAN Number <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-id-card fiw-l"></i>
                                                <input type="text" id="c_pan" name="c_pan" class="finput fc-g"
                                                    placeholder="e.g. AABCU9603R" maxlength="10"
                                                    oninput="this.value=this.value.toUpperCase()" />
                                            </div>
                                            <div class="ferr-msg" id="e-c_pan"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid
                                                    10-character PAN number.</span></div>
                                            <div class="fhint"><i class="fa-solid fa-circle-info"></i> Company /
                                                Individual PAN number</div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="c_msme">MSME Number <span
                                                class="opt">Optional</span></label>
                                        <div class="fiw"><i class="fa-solid fa-industry fiw-l"></i>
                                            <input type="text" id="c_msme" name="c_msme" class="finput fc-g"
                                                placeholder="UDYAM-TN-01-0000000" style="max-width:380px;" />
                                        </div>
                                        <div class="fhint"><i class="fa-solid fa-circle-info"></i> Udyam registration
                                            number — recommended for MSMEs</div>
                                    </div>
                                </div>

                                <!-- Emp Panel 5 -->
                                <div class="panel" id="emp-p5">
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl">GST Certificate <span class="req">*</span></label>
                                            <div class="file-zone">
                                                <input type="file" id="gst_certificate" name="gst_certificate"
                                                    accept=".pdf,.jpg,.jpeg,.png" onchange="setFileLabel(this,'eg-rl')">
                                                <div class="fz-ico"><i class="fa-solid fa-file-invoice"
                                                        style="color:var(--green);"></i></div>
                                                <div class="fz-title" id="eg-rl">Click to upload GST certificate</div>
                                                <div class="fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                                            </div>
                                            <div class="ferr-msg" id="e-gst_certificate"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>GST certificate is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl">PAN Document <span class="req">*</span></label>
                                            <div class="file-zone">
                                                <input type="file" id="pan_document" name="pan_document"
                                                    accept=".pdf,.jpg,.jpeg,.png" onchange="setFileLabel(this,'ep-rl')">
                                                <div class="fz-ico"><i class="fa-solid fa-id-card"
                                                        style="color:var(--green);"></i></div>
                                                <div class="fz-title" id="ep-rl">Click to upload PAN document</div>
                                                <div class="fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                                            </div>
                                            <div class="ferr-msg" id="e-pan_document"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>PAN document is
                                                    required.</span></div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl">MSME Certificate <span
                                                class="opt">Optional</span></label>
                                        <div class="file-zone" style="max-width:380px;">
                                            <input type="file" id="msme_certificate" name="msme_certificate"
                                                accept=".pdf,.jpg,.jpeg,.png" onchange="setFileLabel(this,'em-rl')">
                                            <div class="fz-ico"><i class="fa-solid fa-industry"
                                                    style="color:var(--green);"></i></div>
                                            <div class="fz-title" id="em-rl">Click to upload MSME certificate</div>
                                            <div class="fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                                        </div>
                                    </div>
                                    <div class="summary-box">
                                        <div class="summary-title"><i class="fa-solid fa-list-check"
                                                style="color:var(--green);"></i> Registration Summary</div>
                                        <div class="summary-grid">
                                            <div><span>Company: </span><strong id="es-co">—</strong></div>
                                            <div><span>Location: </span><strong id="es-lc">—</strong></div>
                                            <div><span>Owner: </span><strong id="es-ow">—</strong></div>
                                            <div><span>HR: </span><strong id="es-hr">—</strong></div>
                                            <div><span>Email: </span><strong id="es-em">—</strong></div>
                                            <div><span>GST: </span><strong id="es-gs">—</strong></div>
                                            <div><span>PAN: </span><strong id="es-pn">—</strong></div>
                                            <div><span>MSME: </span><strong id="es-ms">Not provided</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-foot">
                                <div class="foot-info" id="empFootInfo">Already registered? <a href="#">Login
                                        here</a></div>
                                <div class="foot-btns">
                                    <button type="button" class="btn-prev" id="empBtnPrev" onclick="empNav(-1)"
                                        style="display:none;"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button type="button" class="btn-next green-next" id="empBtnNext"
                                        onclick="empNav(1)">Next <i class="fa-solid fa-arrow-right"></i></button>
                                    <button type="submit" class="btn-submit green-sub" id="employer_register"
                                        style="display:none;"><i class="fa-solid fa-building-flag"></i> Register
                                        Company</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /empForm -->
                </form>

            </div><!-- /reg-right -->
        </div><!-- /reg-split -->
    </main>

    <button class="to-top" id="toTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        aria-label="Back to top"><i class="fa-solid fa-chevron-up"></i></button>

    <!-- ════════ JAVASCRIPT ════════ -->
    @push('scripts')
        <script>
            /* ── STICKY HEADER ── */
            const toTop = document.getElementById('toTop');

            window.addEventListener('scroll', () => {
                if (toTop) {
                    toTop.classList.toggle('visible', window.scrollY > 300);
                }
            }, {
                passive: true
            });

            /* ── CONFIG ── */
            const empMeta = [{
                    ico: 'fa-building',
                    title: 'Company Information',
                    sub: 'Step 1 of 5 — Tell us about your business'
                },
                {
                    ico: 'fa-address-book',
                    title: 'Contact Details',
                    sub: 'Step 2 of 5 — Owner & HR information'
                },
                {
                    ico: 'fa-shield-halved',
                    title: 'Account Details',
                    sub: 'Step 3 of 5 — Login credentials'
                },
                {
                    ico: 'fa-file-certificate',
                    title: 'Business Verification',
                    sub: 'Step 4 of 5 — GST & PAN details'
                },
                {
                    ico: 'fa-file-arrow-up',
                    title: 'Documents',
                    sub: 'Step 5 of 5 — Upload & confirm'
                },
            ];
            const empSideLabels = ['Company', 'Contact', 'Account', 'Verification', 'Documents'];

            let empStep = 1;

            function renderSideSteps(cur, labels) {
                const c = document.getElementById('rlSteps');
                c.innerHTML = '';
                labels.forEach((lbl, i) => {
                    const n = i + 1;
                    const cls = n < cur ? 's-done' : n === cur ? 's-active' : '';
                    const icon = n < cur ? '<i class="fa-solid fa-check" style="font-size:.65rem;"></i>' : n + '';
                    c.innerHTML +=
                        `<div class="rl-step ${cls}"><div class="rl-step-num">${icon}</div><div class="rl-step-name">${lbl}</div></div>`;
                });
            }

            /* ── EMP NAVIGATION ── */
            function empNav(dir) {
                if (dir === 1 && !empValidate(empStep)) return;
                empStep = Math.max(1, Math.min(5, empStep + dir));
                empShowStep(empStep);
                if (empStep === 5) empBuildSummary();
            }

            function empShowStep(s) {
                document.querySelectorAll('#empForm .panel').forEach(p => p.classList.remove('active'));
                document.getElementById('emp-p' + s).classList.add('active');

                const m = empMeta[s - 1];
                document.getElementById('empHeadIco').className = 'fa-solid ' + m.ico;
                document.getElementById('empHeadTitle').textContent = m.title;
                document.getElementById('empHeadSub').textContent = m.sub;

                document.getElementById('empBtnPrev').style.display = s > 1 ? '' : 'none';
                document.getElementById('empBtnNext').style.display = s < 5 ? '' : 'none';
                document.getElementById('employer_register').style.display = s === 5 ? '' : 'none';

                renderSideSteps(s, empSideLabels);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            /* ── VALIDATION ── */
            const g = id => (document.getElementById(id) || {}).value || '';

            function empValidate(step) {
                let valid = true;
                let firstError = null;

                document.querySelectorAll('.finput').forEach(el => el.classList.remove('error'));

                function check(name, message) {
                    let field = document.querySelector(`[name="${name}"]`);
                    if (!field || !field.value.trim()) {
                        valid = false;
                        field.classList.add('error');
                        if (!firstError) firstError = message;
                    }
                }

                if (step === 1) {
                    check('company_name', 'Company name is required');
                    check('company_address', 'Company address is required');
                    check('c_state', 'State is required');
                    check('c_district', 'District is required');
                    check('c_city', 'City is required');
                    check('c_pincode', 'Pincode is required');
                }
                if (step === 2) {
                    check('c_ownername', 'Owner name is required');
                    check('c_mobile', 'Owner mobile is required');
                    check('c_hr_name', 'HR name is required');
                    check('c_hr_mobile', 'HR mobile is required');
                }
                if (step === 3) {
                    check('c_email', 'Email is required');
                    check('c_password', 'Password is required');
                    check('c_confirm_password', 'Confirm password is required');

                    if (g('c_password').length > 0 && g('c_password').length < 8) {
                        valid = false;
                        document.getElementById('c_password').classList.add('error');
                        if (!firstError) firstError = 'Password must be at least 8 characters.';
                    }
                    if (g('c_password') !== g('c_confirm_password')) {
                        valid = false;
                        document.getElementById('c_confirm_password').classList.add('error');
                        if (!firstError) firstError = 'Passwords do not match.';
                    }
                }
                if (step === 4) {
                    check('c_gst', 'GST number is required');
                    check('c_pan', 'PAN number is required');
                }
                if (step === 5) {
                    check('gst_certificate', 'GST certificate is required');
                    check('pan_document', 'PAN document is required');
                }

                if (!valid && typeof toastr !== 'undefined') {
                    toastr.error(firstError);
                    document.querySelector('.error')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return valid;
            }

            /* ── SUMMARY ── */
            function empBuildSummary() {
                document.getElementById('es-co').textContent = g('company_name') || '—';
                document.getElementById('es-lc').textContent = [g('c_city'), g('c_district'), g('c_state')].filter(Boolean)
                    .join(', ') || '—';
                document.getElementById('es-ow').textContent = (g('c_ownername') || '—') + (g('c_mobile') ? ' · ' + g(
                    'c_mobile') : '');
                document.getElementById('es-hr').textContent = (g('c_hr_name') || '—') + (g('c_hr_mobile') ? ' · ' + g(
                    'c_hr_mobile') : '');
                document.getElementById('es-em').textContent = g('c_email') || '—';
                document.getElementById('es-gs').textContent = g('c_gst') || '—';
                document.getElementById('es-pn').textContent = g('c_pan') || '—';
                document.getElementById('es-ms').textContent = g('c_msme') || 'Not provided';
            }

            /* ── SUBMIT ── */
            document.getElementById('employer_register').addEventListener('click', function(e) {
                e.preventDefault();

                let form = document.getElementById('employer_registrationForm');
                let formData = new FormData(form);

                let btn = document.getElementById('employer_register');
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    })
                    .then(async response => {
                        let data = await response.json();
                        if (!response.ok) {
                            throw {
                                status: response.status,
                                data: data
                            };
                        }
                        return data;
                    })
                    .then(data => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-building-flag"></i> Register Company';

                        if (data.status) {
                            if (typeof toastr !== 'undefined') toastr.success(data.message);

                            setTimeout(() => {
                                form.reset();
                                empBuildSummary(); // Clear summary

                                document.getElementById('eg-rl').innerText =
                                    'Click to upload GST certificate';
                                document.getElementById('ep-rl').innerText = 'Click to upload PAN document';
                                document.getElementById('em-rl').innerText =
                                    'Click to upload MSME certificate';

                                empStep = 1;
                                empShowStep(1);
                            }, 1500);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message);
                        }
                    })
                    .catch(error => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-building-flag"></i> Register Company';

                        if (error.status === 422 && typeof toastr !== 'undefined') {
                            let errors = error.data.errors;
                            Object.values(errors).forEach(err => {
                                toastr.error(err[0]);
                            });
                        } else if (error.status === 500 && typeof toastr !== 'undefined') {
                            toastr.error(error.data.message || 'Server error');
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error('Something went wrong');
                        }
                    });
            });

            /* ── TOGGLE PASSWORD ── */
            function togPwd(id, btn) {
                const i = document.getElementById(id);
                const ico = btn.querySelector('i');
                if (i.type === 'password') {
                    i.type = 'text';
                    ico.className = 'fa-solid fa-eye-slash';
                } else {
                    i.type = 'password';
                    ico.className = 'fa-solid fa-eye';
                }
            }

            /* ── PASSWORD STRENGTH ── */
            function pwdStr(v, bid) {
                const b = document.getElementById(bid);
                if (!b) return;
                let s = 0;
                if (v.length >= 8) s++;
                if (/[A-Z]/.test(v)) s++;
                if (/[0-9]/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                b.style.width = ['0%', '30%', '55%', '78%', '100%'][s];
                b.style.background = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'][s];
            }

            /* ── FILE LABEL ── */
            function setFileLabel(inp, lid) {
                if (inp.files && inp.files[0]) document.getElementById(lid).textContent = inp.files[0].name;
            }

            /* ── BUILD DOTS ── */
            (function() {
                const d = document.getElementById('rlDots');
                for (let i = 0; i < 30; i++) {
                    const s = document.createElement('span');
                    d.appendChild(s);
                }
            })();

            /* ── LIVE CLEAR ERRORS ── */
            document.querySelectorAll('.finput').forEach(inp => {
                ['input', 'change'].forEach(ev => inp.addEventListener(ev, function() {
                    this.classList.remove('err');
                    this.classList.remove('error');
                    const e = document.getElementById('e-' + this.id);
                    if (e) e.classList.remove('show');
                }));
            });

            /* ── AJAX STATE / DISTRICT ── */
            if (typeof $ !== 'undefined') {
                $('#c_state').on('change', function() {
                    let state = $(this).val();
                    $('#c_district').html('<option value="">Loading...</option>');

                    if (state) {
                        let url = "{{ route('get.districts', ':state') }}";
                        url = url.replace(':state', encodeURIComponent(state));

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                let options = '<option value="" disabled selected>Select District</option>';
                                response.forEach(function(district) {
                                    options += `<option value="${district}">${district}</option>`;
                                });
                                $('#c_district').html(options);
                            }
                        });
                    } else {
                        $('#c_district').html('<option value="" disabled selected>Select District</option>');
                    }
                });
            }

            /* ── INIT ── */
            document.addEventListener('DOMContentLoaded', () => {
                empShowStep(1);
            });
        </script>
    @endpush

@endsection
