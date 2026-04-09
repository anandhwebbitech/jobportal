@extends('frontend.app')
@section('title', 'Register Your Company – LinearJobs')

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
        #skillsBox {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Container */
        .skill-chip {
            position: relative;
        }

        /* Hide checkbox */
        .skill-chip input {
            display: none;
        }

        /* Default pill style */
        .skill-chip label {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background-color: #f8fafc;
            color: #374151;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* Hover */
        .skill-chip label:hover {
            border-color: #2563eb;
            color: #2563eb;
        }

        /* Selected (IMPORTANT) */
        .skill-chip input:checked+label {
            background-color: #eef4ff;
            border-color: #2563eb;
            color: #2563eb;
            font-weight: 500;
        }

        :root {
            --blue: #1a56db;
            --blue-d: #1e3a8a;
            --blue-lt: rgba(26, 86, 219, .08);
            --green: #059669;
            --green-d: #064e3b;
            --green-lt: rgba(5, 150, 105, .08);

            --n0: #ffffff;
            --n50: #f7f8fc;
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
        }

        /* ── PAGE BG ── */
        .page-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
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
            background: radial-gradient(circle, rgba(26, 86, 219, .06) 0%, transparent 70%);
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
           ANNOUNCE BAR
        ══════════════════════════════════════════════════════ */
        .announce-bar {
            background: linear-gradient(90deg, var(--blue-d), var(--blue));
            color: rgba(255, 255, 255, .95);
            text-align: center;
            font-size: .78rem;
            font-weight: 500;
            padding: 9px 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 1001;
        }

        .announce-bar a {
            color: #fff;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .announce-bar i {
            font-size: .7rem;
        }

        .announce-close {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: rgba(255, 255, 255, .7);
            cursor: pointer;
            font-size: .8rem;
            padding: 4px;
            transition: color var(--t);
        }

        .announce-close:hover {
            color: #fff;
        }

        /* ══════════════════════════════════════════════════════
           HEADER
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
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: -.7px;
            color: var(--blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .nav-logo-badge {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1a56db, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(26, 86, 219, .3);
        }

        .nav-logo-text {
            color: var(--n900);
        }

        .nav-logo-text span {
            color: var(--blue);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            margin: 0 auto;
        }

        .nav-link {
            font-family: var(--fb);
            font-size: .875rem;
            font-weight: 500;
            color: var(--n500);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: var(--r-sm);
            transition: color var(--t), background var(--t);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--n800);
            background: var(--n100);
        }

        .nav-link.active {
            color: var(--blue);
            background: var(--blue-lt);
        }

        .nav-link i {
            font-size: .72rem;
            opacity: .7;
        }

        .nav-drop {
            position: relative;
        }

        .nav-drop-menu {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            transform: translateX(-50%) translateY(-6px);
            background: #fff;
            border: 1px solid var(--n200);
            border-radius: var(--r-lg);
            box-shadow: var(--sh-lg);
            min-width: 220px;
            padding: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .18s ease, transform .18s ease;
            z-index: 100;
        }

        .nav-drop:hover .nav-drop-menu {
            opacity: 1;
            pointer-events: all;
            transform: translateX(-50%) translateY(0);
        }

        .ndm-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--r-sm);
            text-decoration: none;
            color: var(--n700);
            font-size: .84rem;
            font-weight: 500;
            transition: background var(--t), color var(--t);
        }

        .ndm-item:hover {
            background: var(--n50);
            color: var(--blue);
        }

        .ndm-item i {
            width: 20px;
            text-align: center;
            color: var(--n400);
            font-size: .78rem;
        }

        .ndm-item:hover i {
            color: var(--blue);
        }

        .ndm-divider {
            height: 1px;
            background: var(--n100);
            margin: 4px 0;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .nav-btn {
            font-family: var(--fb);
            font-size: .855rem;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: var(--r);
            text-decoration: none;
            cursor: pointer;
            transition: all var(--t);
            border: none;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .nav-btn-ghost {
            background: transparent;
            color: var(--n600);
            border: 1.5px solid var(--n200);
        }

        .nav-btn-ghost:hover {
            background: var(--n100);
            color: var(--n800);
            border-color: var(--n300);
        }

        .nav-btn-solid {
            background: linear-gradient(135deg, #1a56db, #2563eb);
            color: #fff;
            box-shadow: 0 3px 12px rgba(26, 86, 219, .25);
        }

        .nav-btn-solid:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(26, 86, 219, .35);
        }

        .nav-ham {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            border-radius: var(--r-sm);
            background: none;
            border: none;
            transition: background var(--t);
        }

        .nav-ham:hover {
            background: var(--n100);
        }

        .nav-ham span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--n700);
            border-radius: 4px;
            transition: all .25s ease;
        }

        .nav-ham.open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .nav-ham.open span:nth-child(2) {
            opacity: 0;
        }

        .nav-ham.open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: var(--nav-h);
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, .98);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--n200);
            padding: 16px 20px 24px;
            z-index: 999;
            flex-direction: column;
            gap: 4px;
            animation: slideDown .22s ease;
        }

        .mobile-menu.open {
            display: flex;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mm-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: var(--r);
            text-decoration: none;
            color: var(--n700);
            font-size: .9rem;
            font-weight: 500;
            transition: background var(--t), color var(--t);
        }

        .mm-link:hover {
            background: var(--n100);
            color: var(--blue);
        }

        .mm-link i {
            width: 18px;
            text-align: center;
            color: var(--n400);
            font-size: .82rem;
        }

        .mm-divider {
            height: 1px;
            background: var(--n150);
            margin: 8px 0;
        }

        .mm-btns {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 4px;
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
            padding: 40px 20px 64px;
            position: relative;
            z-index: 1;
        }

        .reg-split {
            display: grid;
            grid-template-columns: 340px 1fr;
            max-width: 1000px;
            width: 100%;
            gap: 28px;
            align-items: flex-start;
        }

        /* ── LEFT SIDEBAR ── */
        .reg-left {
            position: sticky;
            top: calc(var(--nav-h) + 24px);
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

        .reg-left.mode-blue {
            background: linear-gradient(152deg, #1a56db 0%, #1e3a8a 100%);
        }

        .reg-left.mode-green {
            background: linear-gradient(152deg, #059669 0%, #064e3b 100%);
        }

        .rl-inner {
            padding: 40px 32px 32px;
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
            padding: 5px 14px;
            font-size: .7rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .92);
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-bottom: 16px;
            width: fit-content;
        }

        .rl-title {
            font-family: var(--fh);
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.22;
            letter-spacing: -.04em;
            margin-bottom: 9px;
        }

        .rl-sub {
            font-size: .82rem;
            color: rgba(255, 255, 255, .68);
            line-height: 1.72;
            margin-bottom: 26px;
        }

        .rl-perks {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .rl-perk {
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .rl-perk-ico {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            border-radius: 9px;
            background: rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .76rem;
            color: #fff;
        }

        .rl-perk-body {
            font-size: .8rem;
            color: rgba(255, 255, 255, .72);
            line-height: 1.55;
        }

        .rl-perk-body strong {
            color: #fff;
            display: block;
            font-size: .82rem;
            margin-bottom: 1px;
        }

        .rl-stats {
            padding: 18px 32px;
            border-top: 1px solid rgba(255, 255, 255, .13);
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .rl-stat-val {
            font-family: var(--fh);
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .rl-stat-lbl {
            font-size: .65rem;
            color: rgba(255, 255, 255, .48);
            margin-top: 2px;
        }

        /* Step tracker in sidebar */
        .rl-steps {
            padding: 16px 32px 24px;
            border-top: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .rl-step {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            position: relative;
        }

        .rl-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 12px;
            top: 36px;
            width: 2px;
            height: calc(100% - 16px);
            background: rgba(255, 255, 255, .14);
            border-radius: 2px;
        }

        .rl-step.s-done::after {
            background: rgba(255, 255, 255, .35);
        }

        .rl-step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 700;
            z-index: 1;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .45);
            transition: all .25s ease;
        }

        .rl-step.s-active .rl-step-num {
            background: #fff;
            color: var(--blue);
        }

        .reg-left.mode-green .rl-step.s-active .rl-step-num {
            color: var(--green);
        }

        .rl-step.s-done .rl-step-num {
            background: rgba(255, 255, 255, .22);
            color: #fff;
        }

        .rl-step-name {
            font-size: .79rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .45);
            transition: color .25s ease;
        }

        .rl-step.s-active .rl-step-name {
            color: #fff;
        }

        .rl-step.s-done .rl-step-name {
            color: rgba(255, 255, 255, .65);
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

        /* ── TYPE SELECTOR ── */
        .type-bar {
            background: #fff;
            border: 1px solid var(--n200);
            border-radius: var(--r-xl);
            padding: 18px 22px;
            margin-bottom: 18px;
            box-shadow: var(--sh);
        }

        .type-bar-label {
            font-size: .72rem;
            font-weight: 700;
            color: var(--n400);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .type-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .ts-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 13px;
            border: 2px solid var(--n200);
            border-radius: var(--r);
            background: #fff;
            cursor: pointer;
            transition: all .24s cubic-bezier(.34, 1.3, .64, 1);
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        .ts-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .22s ease;
            border-radius: calc(var(--r) - 2px);
        }

        .ts-btn.ts-js::before {
            background: linear-gradient(135deg, rgba(26, 86, 219, .05), rgba(30, 58, 138, .06));
        }

        .ts-btn.ts-emp::before {
            background: linear-gradient(135deg, rgba(5, 150, 105, .05), rgba(6, 78, 59, .06));
        }

        .ts-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--sh);
        }

        .ts-btn.ts-js:hover {
            border-color: rgba(26, 86, 219, .3);
        }

        .ts-btn.ts-emp:hover {
            border-color: rgba(5, 150, 105, .3);
        }

        .ts-btn:hover::before {
            opacity: 1;
        }

        .ts-btn.sel-blue {
            border-color: var(--blue);
            background: var(--blue-lt);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
            transform: translateY(-2px);
        }

        .ts-btn.sel-green {
            border-color: var(--green);
            background: var(--green-lt);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, .1);
            transform: translateY(-2px);
        }

        .ts-btn.sel-blue::before,
        .ts-btn.sel-green::before {
            opacity: 1;
        }

        .ts-ico {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .84rem;
            transition: all .24s cubic-bezier(.34, 1.4, .64, 1);
        }

        .ts-js .ts-ico {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .ts-emp .ts-ico {
            background: #d1fae5;
            color: #065f46;
        }

        .ts-btn.sel-blue .ts-ico {
            background: var(--blue);
            color: #fff;
            transform: scale(1.1) rotate(-4deg);
        }

        .ts-btn.sel-green .ts-ico {
            background: var(--green);
            color: #fff;
            transform: scale(1.1) rotate(-4deg);
        }

        .ts-name {
            font-family: var(--fh);
            font-size: .88rem;
            font-weight: 700;
            color: var(--n800);
            line-height: 1.2;
            transition: color .22s ease;
        }

        .ts-desc {
            font-size: .71rem;
            color: var(--n500);
            margin-top: 1px;
        }

        .ts-btn.sel-blue .ts-name {
            color: var(--blue);
        }

        .ts-btn.sel-green .ts-name {
            color: var(--green);
        }

        .ts-check {
            margin-left: auto;
            flex-shrink: 0;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .58rem;
            color: #fff;
            opacity: 0;
            transform: scale(0);
            transition: all .24s cubic-bezier(.34, 1.6, .64, 1);
        }

        .ts-btn.sel-blue .ts-check {
            background: var(--blue);
            opacity: 1;
            transform: scale(1);
        }

        .ts-btn.sel-green .ts-check {
            background: var(--green);
            opacity: 1;
            transform: scale(1);
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
            padding: 20px 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .card-head.blue-hd {
            background: linear-gradient(90deg, #1a56db, #2563eb);
        }

        .card-head.green-hd {
            background: linear-gradient(90deg, #059669, #10b981);
        }

        .card-head>i {
            color: rgba(255, 255, 255, .92);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .card-head-title {
            font-family: var(--fh);
            font-size: .95rem;
            font-weight: 700;
            color: #fff;
        }

        .card-head-sub {
            font-size: .75rem;
            color: rgba(255, 255, 255, .7);
            margin-top: 1px;
        }

        .card-body {
            padding: 26px 28px;
        }

        .card-foot {
            padding: 17px 28px;
            border-top: 1px solid var(--n100);
            background: var(--n50);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
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
            margin-bottom: 15px;
        }

        .frow {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .frow3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 13px;
        }

        .flbl {
            display: block;
            font-size: .79rem;
            font-weight: 600;
            color: var(--n700);
            margin-bottom: 5px;
        }

        .flbl .req {
            color: #ef4444;
            margin-left: 2px;
        }

        .flbl .opt {
            font-size: .67rem;
            font-weight: 500;
            color: var(--n400);
            margin-left: 6px;
            background: var(--n100);
            padding: 1px 7px;
            border-radius: 100px;
        }

        .fiw {
            position: relative;
        }

        .fiw-l {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: .77rem;
            pointer-events: none;
        }

        .fiw-l.t {
            top: 13px;
            transform: none;
        }

        .fiw-r {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: .77rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 3px;
            transition: color var(--t);
        }

        .fiw-r:hover {
            color: var(--n700);
        }

        .finput {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: var(--r);
            padding: 10px 13px 10px 36px;
            font-family: var(--fb);
            font-size: .875rem;
            color: var(--n900);
            background: #fff;
            outline: none;
            transition: border-color var(--t), box-shadow var(--t);
        }

        .finput.no-ico {
            padding-left: 13px;
        }

        .finput.pr {
            padding-right: 37px;
        }

        .finput::placeholder {
            color: var(--n400);
        }

        .finput.fc-b:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .finput.fc-g:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, .1);
        }

        .finput.err {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        select.finput {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            padding-right: 32px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }

        textarea.finput {
            padding-top: 10px;
            resize: vertical;
            min-height: 86px;
        }

        .fhint {
            font-size: .72rem;
            color: var(--n400);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .fhint i {
            font-size: .67rem;
        }

        .ferr-msg {
            font-size: .74rem;
            color: #dc2626;
            margin-top: 4px;
            display: none;
            align-items: center;
            gap: 4px;
        }

        .ferr-msg.show {
            display: flex;
        }

        .ferr-msg i {
            font-size: .7rem;
            flex-shrink: 0;
        }

        .fsec {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0 15px;
        }

        .fsec-line {
            flex: 1;
            height: 1px;
            background: var(--n100);
        }

        .fsec-lbl {
            font-size: .67rem;
            font-weight: 800;
            color: var(--n400);
            letter-spacing: .08em;
            text-transform: uppercase;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .fsec-lbl i {
            font-size: .7rem;
        }

        .fsec-lbl.bi {
            color: var(--blue);
        }

        .fsec-lbl.gi {
            color: var(--green);
        }

        .step-alert {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: var(--r);
            padding: 10px 14px;
            margin-bottom: 15px;
            display: none;
            align-items: flex-start;
            gap: 9px;
            font-size: .82rem;
            color: #b91c1c;
            animation: shakeX .35s ease;
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
            padding: 12px 15px;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: .82rem;
            color: var(--n700);
        }

        .info-box.blue {
            background: var(--blue-lt);
            border: 1.5px solid rgba(26, 86, 219, .12);
        }

        .info-box.green {
            background: var(--green-lt);
            border: 1.5px solid rgba(5, 150, 105, .12);
        }

        .info-box i {
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-box.blue i {
            color: var(--blue);
        }

        .info-box.green i {
            color: var(--green);
        }

        /* Experience radio */
        .exp-row {
            display: flex;
            gap: 10px;
        }

        .exp-opt {
            flex: 1;
        }

        .exp-opt input[type="radio"] {
            display: none;
        }

        .exp-opt label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1.5px solid var(--n200);
            border-radius: var(--r);
            padding: 9px 14px;
            font-size: .875rem;
            font-weight: 600;
            color: var(--n600);
            cursor: pointer;
            transition: all var(--t);
        }

        .exp-opt input:checked+label {
            background: var(--blue-lt);
            border-color: var(--blue);
            color: var(--blue);
        }

        /* Skills chips */
        .skill-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .skill-chip input[type="checkbox"] {
            display: none;
        }

        .skill-chip label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1.5px solid var(--n200);
            border-radius: 100px;
            padding: 5px 13px;
            font-size: .79rem;
            font-weight: 500;
            color: var(--n600);
            cursor: pointer;
            transition: all var(--t);
        }

        .skill-chip label:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
        }

        .skill-chip input:checked+label {
            background: var(--blue-lt);
            border-color: var(--blue);
            color: var(--blue);
        }

        /* File zone */
        .file-zone {
            border: 1.5px dashed var(--n200);
            border-radius: var(--r);
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: border-color var(--t), background var(--t);
            background: var(--n50);
            position: relative;
        }

        .file-zone:hover {
            border-color: var(--blue);
            background: rgba(26, 86, 219, .03);
        }

        .file-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .fz-ico {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #fff;
            border: 1.5px solid var(--n200);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            color: var(--n400);
            margin: 0 auto 9px;
        }

        .fz-title {
            font-size: .86rem;
            font-weight: 600;
            color: var(--n700);
            margin-bottom: 3px;
        }

        .fz-sub {
            font-size: .73rem;
            color: var(--n400);
        }

        /* Password strength */
        .pwd-wrap {
            height: 4px;
            border-radius: 2px;
            background: var(--n100);
            margin-top: 6px;
            overflow: hidden;
        }

        .pwd-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width .3s, background .3s;
        }

        /* Summary */
        .summary-box {
            background: var(--n50);
            border: 1.5px solid var(--n150);
            border-radius: var(--r-lg);
            padding: 17px;
            margin-top: 18px;
        }

        .summary-title {
            font-size: .79rem;
            font-weight: 700;
            color: var(--n700);
            margin-bottom: 11px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px 22px;
            font-size: .79rem;
            color: var(--n600);
        }

        .summary-grid div span:first-child {
            color: var(--n400);
        }

        /* Card foot buttons */
        .foot-info {
            font-size: .86rem;
            color: var(--n500);
        }

        .foot-info a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        .foot-info a:hover {
            text-decoration: underline;
        }

        .foot-btns {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .btn-prev {
            border: 1.5px solid var(--n200);
            border-radius: var(--r);
            background: #fff;
            color: var(--n700);
            font-family: var(--fb);
            font-size: .87rem;
            font-weight: 700;
            padding: 10px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all var(--t);
        }

        .btn-prev:hover {
            border-color: var(--n400);
            background: var(--n50);
        }

        .btn-next {
            border: none;
            border-radius: var(--r);
            color: #fff;
            font-family: var(--fb);
            font-size: .87rem;
            font-weight: 700;
            padding: 10px 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all var(--t);
        }

        .btn-next.blue-next {
            background: linear-gradient(135deg, #1a56db, #2563eb);
            box-shadow: 0 3px 12px rgba(26, 86, 219, .25);
        }

        .btn-next.green-next {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 3px 12px rgba(5, 150, 105, .25);
        }

        .btn-next:hover {
            transform: translateY(-1px);
        }

        .btn-next.blue-next:hover {
            box-shadow: 0 5px 18px rgba(26, 86, 219, .35);
        }

        .btn-next.green-next:hover {
            box-shadow: 0 5px 18px rgba(5, 150, 105, .35);
        }

        .btn-submit {
            border: none;
            border-radius: var(--r);
            color: #fff;
            font-family: var(--fh);
            font-size: .93rem;
            font-weight: 700;
            padding: 11px 26px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 9px;
            transition: all var(--t);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .1);
            opacity: 0;
            transition: opacity .15s ease;
        }

        .btn-submit:hover::after {
            opacity: 1;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit.blue-sub {
            background: linear-gradient(135deg, #1a56db, #2563eb);
            box-shadow: 0 4px 14px rgba(26, 86, 219, .28);
        }

        .btn-submit.green-sub {
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 14px rgba(5, 150, 105, .28);
        }

        /* ══════════════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════════════ */
        footer {
            position: relative;
            z-index: 1;
            background: var(--n900);
            color: rgba(255, 255, 255, .65);
            overflow: hidden;
        }

        .footer-strip {
            height: 3px;
            background: linear-gradient(90deg, #1a56db, #059669, #1a56db);
            background-size: 200% 100%;
            animation: stripFlow 4s linear infinite;
        }

        @keyframes stripFlow {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 200% 0;
            }
        }

        .footer-inner {
            padding: 52px 60px 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 44px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .ft-logo {
            font-family: var(--fh);
            font-size: 1.45rem;
            font-weight: 900;
            letter-spacing: -.6px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 14px;
            text-decoration: none;
        }

        .ft-logo-ico {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1a56db, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            color: #fff;
            box-shadow: 0 2px 10px rgba(26, 86, 219, .4);
        }

        .ft-logo span {
            color: rgba(255, 255, 255, .4);
        }

        .ft-desc {
            font-size: .84rem;
            line-height: 1.72;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 22px;
            max-width: 270px;
        }

        .ft-socials {
            display: flex;
            gap: 8px;
        }

        .ft-social {
            width: 36px;
            height: 36px;
            border-radius: var(--r-sm);
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            color: rgba(255, 255, 255, .55);
            text-decoration: none;
            transition: all var(--t);
        }

        .ft-social:hover {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
            transform: translateY(-2px);
        }

        .ft-col-title {
            font-family: var(--fh);
            font-size: .76rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .45);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .ft-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ft-links li a {
            font-size: .84rem;
            color: rgba(255, 255, 255, .52);
            text-decoration: none;
            transition: color var(--t);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ft-links li a:hover {
            color: #fff;
        }

        .ft-links li a i {
            font-size: .65rem;
            opacity: 0;
            transition: all var(--t);
        }

        .ft-links li a:hover i {
            opacity: 1;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 22px 60px;
        }

        .fb-copy {
            font-size: .78rem;
            color: rgba(255, 255, 255, .3);
        }

        .fb-copy a {
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
            font-weight: 600;
        }

        .fb-copy a:hover {
            color: #fff;
        }

        .fb-links {
            display: flex;
            gap: 20px;
        }

        .fb-links a {
            font-size: .76rem;
            color: rgba(255, 255, 255, .35);
            text-decoration: none;
            transition: color var(--t);
        }

        .fb-links a:hover {
            color: rgba(255, 255, 255, .7);
        }

        .fb-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .73rem;
            color: rgba(255, 255, 255, .3);
        }

        .fb-badge i {
            color: var(--green);
            font-size: .65rem;
        }

        .to-top {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 500;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a56db, #2563eb);
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: .82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(26, 86, 219, .35);
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .3s ease, transform .3s ease;
            pointer-events: none;
        }

        .to-top.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        .to-top:hover {
            transform: translateY(-2px);
        }

        /* ── RESPONSIVE ── */
        @media(max-width:940px) {

            .nav-links,
            .nav-drop {
                display: none;
            }

            .nav-ham {
                display: flex;
            }
        }

        @media(max-width:820px) {
            .reg-split {
                grid-template-columns: 1fr;
            }

            .reg-left {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-inner {
                padding: 40px 28px 0;
            }

            .footer-bottom {
                padding: 18px 28px;
            }
        }

        @media(max-width:580px) {

            .frow,
            .frow3 {
                grid-template-columns: 1fr;
            }

            .card-body {
                padding: 20px 16px;
            }

            .card-foot {
                padding: 15px;
                flex-direction: column;
                align-items: stretch;
            }

            .foot-btns {
                justify-content: stretch;
            }

            .btn-prev,
            .btn-next,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-inner {
                padding: 32px 20px 0;
            }

            .footer-bottom {
                padding: 16px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .header {
                padding: 0 18px;
            }

            main {
                padding: 28px 14px 56px;
            }
        }

        @media(max-width:400px) {
            .type-row {
                grid-template-columns: 1fr;
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



    <div class="mobile-menu" id="mobileMenu">
        <a class="mm-link" href="#"><i class="fa-solid fa-house"></i> Home</a>
        <a class="mm-link" href="#"><i class="fa-solid fa-briefcase"></i> Browse Jobs</a>
        <a class="mm-link" href="#"><i class="fa-solid fa-building"></i> Companies</a>
        <a class="mm-link" href="#"><i class="fa-solid fa-circle-plus"></i> Post a Job</a>
        <a class="mm-link" href="#"><i class="fa-solid fa-tag"></i> Pricing</a>
        <div class="mm-divider"></div>
        <div class="mm-btns">
            <a class="nav-btn nav-btn-ghost" href="#" style="justify-content:center;">Sign In</a>
            <a class="nav-btn nav-btn-solid" href="#" style="justify-content:center;">Register Free</a>
        </div>
    </div>

    <!-- ════════════════════════════════════
             MAIN CONTENT
        ════════════════════════════════════ -->
    <main>
        <div class="reg-split">

            <!-- LEFT SIDEBAR -->
            <div class="reg-left mode-blue" id="regLeft">
                <div class="rl-inner">
                    <div class="rl-orb rl-orb-1"></div>
                    <div class="rl-orb rl-orb-2"></div>
                    <div class="rl-dots" id="rlDots"></div>

                    <!-- Job Seeker content -->
                    <div id="rlJs">
                        <div class="rl-badge"><i class="fa-solid fa-user-tie"></i> Job Seeker</div>
                        <div class="rl-title">Create Your Free Account</div>
                        <div class="rl-sub">Join thousands of professionals finding great jobs across Tamil Nadu.</div>
                        <div class="rl-perks">
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-briefcase"></i></div>
                                <div class="rl-perk-body"><strong>10,000+ Listings</strong>Browse across all industries &
                                    districts.</div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-shield-halved"></i></div>
                                <div class="rl-perk-body"><strong>Verified Employers</strong>GST & PAN verified companies
                                    only.</div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                                <div class="rl-perk-body"><strong>100% Free Forever</strong>No fees, no subscriptions, ever.
                                </div>
                            </div>
                            <div class="rl-perk">
                                <div class="rl-perk-ico"><i class="fa-solid fa-bell"></i></div>
                                <div class="rl-perk-body"><strong>Instant Job Alerts</strong>Get notified of matching jobs
                                    instantly.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Employer content -->
                    <div id="rlEmp" style="display:none">
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

                <div class="rl-stats" id="rlStats"></div>
                <div class="rl-steps" id="rlSteps"></div>
            </div>

            <!-- RIGHT FORM -->
            <div class="reg-right">

                <!-- Type selector -->
                <div class="type-bar">
                    <div class="type-bar-label">I am registering as</div>
                    <div class="type-row">
                        <button class="ts-btn ts-js sel-blue" id="tsBtnJs" onclick="switchType('jobseeker')">
                            <div class="ts-ico"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <div class="ts-name">Job Seeker</div>
                                <div class="ts-desc">Personal account</div>
                            </div>
                            <div class="ts-check"><i class="fa-solid fa-check"></i></div>
                        </button>
                        <button class="ts-btn ts-emp" id="tsBtnEmp" onclick="switchType('employer')">
                            <div class="ts-ico"><i class="fa-solid fa-building-flag"></i></div>
                            <div>
                                <div class="ts-name">Employer</div>
                                <div class="ts-desc">Company account</div>
                            </div>
                            <div class="ts-check"><i class="fa-solid fa-check"></i></div>
                        </button>
                    </div>
                </div>

                <!-- ════ JOB SEEKER FORM ════ -->
                <form id="registrationForm" method="POST" action="{{ route('jobseeker_register.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="jsForm">
                        <div class="lj-card">
                            <div class="card-head blue-hd" id="jsHead">
                                <i class="fa-solid fa-user" id="jsHeadIco"></i>
                                <div>
                                    <div class="card-head-title" id="jsHeadTitle">Personal Information</div>
                                    <div class="card-head-sub" id="jsHeadSub">Step 1 of 5 — Your basic details</div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Panel 1 -->
                                <div class="panel active" id="js-p1">
                                    <div class="step-alert" id="js-al1"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span id="js-al1-msg">Please fill
                                            in
                                            all required fields.</span></div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="js_name">Full Name <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-user fiw-l"></i><input
                                                    type="text" id="full_name" name="full_name"class="finput fc-b"
                                                    placeholder="Your full name" /></div>
                                            <div class="ferr-msg" id="e-js_name"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Full name required
                                                    (min. 2
                                                    chars).</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="js_mob">Mobile Number <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-mobile-screen fiw-l"></i><input
                                                    type="tel" id="mobile" name="mobile" class="finput fc-b"
                                                    placeholder="+91 XXXXX XXXXX" maxlength="15" /></div>
                                            <div class="ferr-msg" id="e-js_mob"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit
                                                    mobile number.</span></div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="js_email">Email Address <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-envelope fiw-l"></i><input
                                                type="email" id="email" name="email" class="finput fc-b"
                                                placeholder="you@example.com" /></div>
                                        <div class="ferr-msg" id="e-js_email"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Enter a valid email
                                                address.</span></div>
                                    </div>
                                    <div class="fsec">
                                        <div class="fsec-line"></div>
                                        <div class="fsec-lbl bi"><i class="fa-solid fa-lock"></i> Account Security</div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="js_pwd">Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="password"
                                                    name="password"class="finput pr fc-b" placeholder="Min. 8 characters"
                                                    oninput="pwdStr(this.value,'js-pb')" />
                                                <button type="button" class="fiw-r" onclick="togPwd('password',this)"
                                                    tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="pwd-wrap">
                                                <div class="pwd-bar" id="js-pb"></div>
                                            </div>
                                            <div class="ferr-msg" id="e-js_pwd"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Password must be at
                                                    least
                                                    8 characters.</span></div>
                                            <div class="fhint"><i class="fa-solid fa-circle-info"></i> Use letters,
                                                numbers &
                                                symbols</div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="js_cpwd">Confirm Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="confirm_password"
                                                    name="confirm_password"class="finput pr fc-b"
                                                    placeholder="Re-enter password" />
                                                <button type="button" class="fiw-r"
                                                    onclick="togPwd('confirm_password',this)" tabindex="-1"><i
                                                        class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="ferr-msg" id="e-js_cpwd"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Passwords do not
                                                    match.</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel 2 -->
                                <div class="panel" id="js-p2">
                                    <div class="step-alert" id="js-al2"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all location
                                            fields.</span></div>
                                    <div class="frow3">
                                        <div class="fgrp">
                                            <label class="flbl" for="js_state">State <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-map fiw-l"></i>
                                                <select id="state" name="state"class="finput fc-b">
                                                    <option value="" disabled selected>Select State</option>
                                                    <option>Tamil Nadu</option>
                                                    <option>Kerala</option>
                                                    <option>Karnataka</option>
                                                    <option>Andhra Pradesh</option>
                                                    <option>Telangana</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-js_state"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    state.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="js_dist">District <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-location-dot fiw-l"></i>
                                                <select id="district" name="district" class="finput fc-b">
                                                    <option value="" disabled selected>Select District</option>
                                                    <option>Chennai</option>
                                                    <option>Coimbatore</option>
                                                    <option>Madurai</option>
                                                    <option>Tiruchirappalli</option>
                                                    <option>Salem</option>
                                                    <option>Tirunelveli</option>
                                                    <option>Erode</option>
                                                    <option>Vellore</option>
                                                    <option>Thanjavur</option>
                                                    <option>Dindigul</option>
                                                    <option>Kanchipuram</option>
                                                    <option>Tiruppur</option>
                                                    <option>Nagercoil</option>
                                                    <option>Cuddalore</option>
                                                    <option>Sivakasi</option>
                                                    <option>Karur</option>
                                                    <option>Namakkal</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-js_dist"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    district.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="js_city">City / Town <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-city fiw-l"></i><input
                                                    type="text" id="city" name="city" class="finput fc-b"
                                                    placeholder="Your city" /></div>
                                            <div class="ferr-msg" id="e-js_city"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please enter your
                                                    city.</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel 3 -->
                                <div class="panel" id="js-p3">
                                    <div class="step-alert" id="js-al3"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please select your
                                            qualification.</span></div>
                                    <div class="fgrp">
                                        <label class="flbl" for="js_qual">Highest Qualification <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-graduation-cap fiw-l"></i>
                                            <select id="qualification"name="qualification" class="finput fc-b">
                                                <option value="" disabled selected>Select Qualification</option>
                                                <option value="10th">10th Pass (SSLC)</option>
                                                <option value="12th">12th Pass (HSC)</option>
                                                <option value="diploma">Diploma</option>
                                                <option value="bachelor">Bachelor's Degree</option>
                                                <option value="master">Master's Degree</option>
                                                <option value="doctorate">Doctorate / PhD</option>
                                            </select>
                                        </div>
                                        <div class="ferr-msg" id="e-js_qual"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Please select your
                                                qualification.</span></div>
                                    </div>
                                    <div class="fsec">
                                        <div class="fsec-line"></div>
                                        <div class="fsec-lbl bi"><i class="fa-solid fa-briefcase"></i> Experience Level
                                        </div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="fgrp">
                                        <div class="exp-row">
                                            <div class="exp-opt"><input type="radio" id="exp_f" name="exp"
                                                    value="fresher" checked onchange="togExp(false)"><label
                                                    for="exp_f"><i class="fa-solid fa-seedling"></i> Fresher</label>
                                            </div>
                                            <div class="exp-opt"><input type="radio" id="exp_e" name="exp"
                                                    value="experienced" onchange="togExp(true)"><label for="exp_e"><i
                                                        class="fa-solid fa-briefcase"></i> Experienced</label></div>
                                        </div>
                                    </div>
                                    <div id="expFields" style="display:none;">
                                        <div class="frow">
                                            <div class="fgrp">
                                                <label class="flbl" for="js_yrs">Years of Experience</label>
                                                <div class="fiw"><i class="fa-solid fa-clock fiw-l"></i>
                                                    <select id="ex_years" name="ex_years" class="finput fc-b">
                                                        <option value="">Select Years</option>
                                                        <option>Less than 1 year</option>
                                                        <option>1 year</option>
                                                        <option>2 years</option>
                                                        <option>3 years</option>
                                                        <option>4 years</option>
                                                        <option>5 years</option>
                                                        <option>6+ years</option>
                                                        <option>10+ years</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="fgrp">
                                                <label class="flbl" for="js_pco">Previous Company</label>
                                                <div class="fiw"><i class="fa-solid fa-building fiw-l"></i><input
                                                        type="text" id="previous_company" name="previous_company"
                                                        class="finput fc-b" placeholder="e.g. ABC Pvt Ltd" /></div>
                                            </div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="js_prole">Previous Designation</label>
                                            <div class="fiw"><i class="fa-solid fa-id-badge fiw-l"></i><input
                                                    type="text" id="previous_designation" name="previous_designation"
                                                    class="finput fc-b" placeholder="e.g. Sales Executive" /></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel 4 -->
                                <div class="panel" id="js-p4">
                                    <div class="step-alert" id="js-al4"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please select at least one
                                            skill.</span></div>
                                    <div id="skillsBox" name="skillsBox"></div>
                                </div>

                                <!-- Panel 5 -->
                                <div class="panel" id="js-p5">
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl">Upload Resume</label>
                                            <div class="file-zone"><input type="file" name="resume"
                                                    id="resume"accept=".pdf,.doc,.docx"
                                                    onchange="setFileLabel(this,'js-rl')">
                                                <div class="fz-ico"><i class="fa-solid fa-file-pdf"
                                                        style="color:var(--blue);"></i></div>
                                                <div class="fz-title" id="js-rl">Click to upload resume</div>
                                                <div class="fz-sub">PDF, DOC, DOCX — Max 5 MB</div>
                                            </div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl">Profile Photo <span
                                                    class="opt">Optional</span></label>
                                            <div class="file-zone"><input type="file" name="profile_photo"
                                                    id="profile_photo" accept="image/*"
                                                    onchange="setFileLabel(this,'js-pl')">
                                                <div class="fz-ico"><i class="fa-solid fa-image"
                                                        style="color:var(--blue);"></i></div>
                                                <div class="fz-title" id="js-pl">Click to upload photo</div>
                                                <div class="fz-sub">JPG, PNG — Max 2 MB</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-box">
                                        <div class="summary-title"><i class="fa-solid fa-list-check"
                                                style="color:var(--blue);"></i> Registration Summary</div>
                                        <div class="summary-grid">
                                            <div><span>Name: </span><strong id="ss-nm">—</strong></div>
                                            <div><span>Mobile: </span><strong id="ss-mb">—</strong></div>
                                            <div><span>Email: </span><strong id="ss-em">—</strong></div>
                                            <div><span>Location: </span><strong id="ss-lc">—</strong></div>
                                            <div><span>Qualification: </span><strong id="ss-ql">—</strong></div>
                                            <div><span>Experience: </span><strong id="ss-xp">—</strong></div>
                                            <div style="grid-column:1/-1;"><span>Skills: </span><strong
                                                    id="ss-sk">—</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-foot">
                                <div class="foot-info" id="jsFootInfo">Already have an account? <a href="#">Sign
                                        In</a>
                                </div>
                                <div class="foot-btns">
                                    <button type="button" class="btn-prev" id="jsBtnPrev" onclick="jsNav(-1)"
                                        style="display:none;"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button type="button" class="btn-next blue-next" id="jsBtnNext"
                                        onclick="jsNav(1)">Next <i class="fa-solid fa-arrow-right"></i></button>
                                    <button type="submit"class="btn-submit blue-sub" id="jsBtnSub"
                                        style="display:none;"><i class="fa-solid fa-user-plus"></i> Create
                                        Account</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /jsForm -->
                </form>
                <!-- ════ EMPLOYER FORM ════ -->
                <form id="employer_registrationForm" method="POST" action="{{ route('employer_register.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div id="empForm" style="display:none;">
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
                                        <label class="flbl" for="ec_name">Company Name <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-building fiw-l"></i><input
                                                type="text" id="company_name" name="company_name" class="finput fc-g"
                                                placeholder="e.g. ABC Industries Pvt Ltd" /></div>
                                        <div class="ferr-msg" id="e-ec_name"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Company name is
                                                required.</span></div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="ec_addr">Company Address <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-map-pin fiw-l t"></i>
                                            <textarea id="company_address" name="company_address" class="finput fc-g" rows="3"
                                                placeholder="Full registered address"></textarea>
                                        </div>
                                        <div class="ferr-msg" id="e-ec_addr"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Please enter your company
                                                address.</span></div>
                                    </div>
                                    <div class="frow3">
                                        <div class="fgrp">
                                            <label class="flbl" for="ec_state">State <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-map fiw-l"></i>
                                                <select id="c_state" name="c_state" class="finput fc-g">
                                                    <option value="" disabled selected>Select State</option>
                                                    <option>Tamil Nadu</option>
                                                    <option>Kerala</option>
                                                    <option>Karnataka</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-ec_state"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    state.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="ec_dist">District <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-location-dot fiw-l"></i>
                                                <select id="c_district" name="c_district" class="finput fc-g">
                                                    <option value="" disabled selected>Select District</option>
                                                    <option>Chennai</option>
                                                    <option>Coimbatore</option>
                                                    <option>Madurai</option>
                                                    <option>Tiruchirappalli</option>
                                                    <option>Salem</option>
                                                    <option>Erode</option>
                                                    <option>Vellore</option>
                                                    <option>Tiruppur</option>
                                                </select>
                                            </div>
                                            <div class="ferr-msg" id="e-ec_dist"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please select a
                                                    district.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="ec_city">City <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-city fiw-l"></i><input
                                                    type="text" id="c_city" name="c_city" class="finput fc-g"
                                                    placeholder="City" /></div>
                                            <div class="ferr-msg" id="e-ec_city"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Please enter the
                                                    city.</span></div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="ec_pin">Pincode <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-hashtag fiw-l"></i><input
                                                type="text" id="c_pincode" name="c_pincode"class="finput fc-g"
                                                placeholder="6-digit pincode" maxlength="6" style="max-width:200px;" />
                                        </div>
                                        <div class="ferr-msg" id="e-ec_pin"><i
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
                                            <label class="flbl" for="eo_name">Owner Name <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-user fiw-l"></i><input
                                                    type="text" id="c_ownername" name="c_ownername"class="finput fc-g"
                                                    placeholder="Full name" /></div>
                                            <div class="ferr-msg" id="e-eo_name"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Owner name is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="eo_mob">Owner Mobile <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-mobile-screen fiw-l"></i><input
                                                    type="tel" id="c_mobile" name="c_mobile"class="finput fc-g"
                                                    placeholder="+91 XXXXX XXXXX" maxlength="15" /></div>
                                            <div class="ferr-msg" id="e-eo_mob"><i
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
                                            have
                                            a dedicated HR, enter the owner's details again below.</span></div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="eh_name">HR Name <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-user fiw-l"></i><input
                                                    type="text" id="c_hr_name" name="c_hr_name"class="finput fc-g"
                                                    placeholder="Full name" /></div>
                                            <div class="ferr-msg" id="e-eh_name"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>HR name is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="eh_mob">HR Mobile <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-mobile-screen fiw-l"></i><input
                                                    type="tel" id="c_hr_mobile" name="c_hr_mobile"
                                                    class="finput fc-g" placeholder="+91 XXXXX XXXXX" maxlength="15" />
                                            </div>
                                            <div class="ferr-msg" id="e-eh_mob"><i
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
                                        <label class="flbl" for="e_email">Official Email Address <span
                                                class="req">*</span></label>
                                        <div class="fiw"><i class="fa-solid fa-envelope fiw-l"></i><input
                                                type="email" id="c_email" name="c_email" class="finput fc-g"
                                                placeholder="company@example.com" /></div>
                                        <div class="ferr-msg" id="e-e_email"><i
                                                class="fa-solid fa-circle-exclamation"></i><span>Enter a valid email
                                                address.</span></div>
                                        <div class="fhint"><i class="fa-solid fa-circle-info"></i> This will be your
                                            login
                                            email</div>
                                    </div>
                                    <div class="fsec">
                                        <div class="fsec-line"></div>
                                        <div class="fsec-lbl gi"><i class="fa-solid fa-lock"></i> Account Security</div>
                                        <div class="fsec-line"></div>
                                    </div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="e_pwd">Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="c_password" name="c_password"
                                                    class="finput pr fc-g" placeholder="Min. 8 characters"
                                                    oninput="pwdStr(this.value,'e-pb')" />
                                                <button type="button" class="fiw-r" onclick="togPwd('e_pwd',this)"
                                                    tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="pwd-wrap">
                                                <div class="pwd-bar" id="e-pb"></div>
                                            </div>
                                            <div class="ferr-msg" id="e-e_pwd"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Password must be at
                                                    least
                                                    8 characters.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="e_cpwd">Confirm Password <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-lock fiw-l"></i>
                                                <input type="password" id="c_confirm_password" name="c_confirm_password"
                                                    class="finput pr fc-g" placeholder="Re-enter password" />
                                                <button type="button" class="fiw-r" onclick="togPwd('e_cpwd',this)"
                                                    tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                            <div class="ferr-msg" id="e-e_cpwd"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Passwords do not
                                                    match.</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Emp Panel 4 -->
                                <div class="panel" id="emp-p4">
                                    <div class="step-alert" id="emp-al4"><i
                                            class="fa-solid fa-triangle-exclamation"></i><span>Please provide valid GST and
                                            PAN
                                            numbers.</span></div>
                                    <div class="info-box green"><i class="fa-solid fa-shield-check"></i><span>Your
                                            business
                                            details are encrypted and used only for verification. Only verified employers
                                            can
                                            post jobs.</span></div>
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl" for="e_gst">GST Number <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-receipt fiw-l"></i><input
                                                    type="text" id="c_gst" name="c_gst" class="finput fc-g"
                                                    placeholder="e.g. 33AABCU9603R1ZX" maxlength="15"
                                                    oninput="this.value=this.value.toUpperCase()" /></div>
                                            <div class="ferr-msg" id="e-e_gst"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid
                                                    15-character
                                                    GST number.</span></div>
                                            <div class="fhint"><i class="fa-solid fa-circle-info"></i> 15-character
                                                alphanumeric GST number</div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl" for="e_pan">PAN Number <span
                                                    class="req">*</span></label>
                                            <div class="fiw"><i class="fa-solid fa-id-card fiw-l"></i><input
                                                    type="text" id="c_pan" name="c_pan" class="finput fc-g"
                                                    placeholder="e.g. AABCU9603R" maxlength="10"
                                                    oninput="this.value=this.value.toUpperCase()" /></div>
                                            <div class="ferr-msg" id="e-e_pan"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>Enter a valid
                                                    10-character
                                                    PAN number.</span></div>
                                            <div class="fhint"><i class="fa-solid fa-circle-info"></i> Company /
                                                Individual
                                                PAN number</div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl" for="e_msme">MSME Number <span
                                                class="opt">Optional</span></label>
                                        <div class="fiw"><i class="fa-solid fa-industry fiw-l"></i><input
                                                type="text" id="c_msme" name="c_msme" class="finput fc-g"
                                                placeholder="UDYAM-TN-01-0000000" style="max-width:380px;" /></div>
                                        <div class="fhint"><i class="fa-solid fa-circle-info"></i> Udyam registration
                                            number
                                            — recommended for MSMEs</div>
                                    </div>
                                </div>

                                <!-- Emp Panel 5 -->
                                <div class="panel" id="emp-p5">
                                    <div class="frow">
                                        <div class="fgrp">
                                            <label class="flbl">GST Certificate <span class="req">*</span></label>
                                            <div class="file-zone"><input type="file" id="gst_certificate"
                                                    name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png"
                                                    onchange="setFileLabel(this,'eg-rl')">
                                                <div class="fz-ico"><i class="fa-solid fa-file-invoice"
                                                        style="color:var(--green);"></i></div>
                                                <div class="fz-title" id="eg-rl">Click to upload GST certificate</div>
                                                <div class="fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                                            </div>
                                            <div class="ferr-msg" id="e-eg_gstf"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>GST certificate is
                                                    required.</span></div>
                                        </div>
                                        <div class="fgrp">
                                            <label class="flbl">PAN Document <span class="req">*</span></label>
                                            <div class="file-zone"><input type="file" id="pan_document"
                                                    name="pan_document" accept=".pdf,.jpg,.jpeg,.png"
                                                    onchange="setFileLabel(this,'ep-rl')">
                                                <div class="fz-ico"><i class="fa-solid fa-id-card"
                                                        style="color:var(--green);"></i></div>
                                                <div class="fz-title" id="ep-rl">Click to upload PAN document</div>
                                                <div class="fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                                            </div>
                                            <div class="ferr-msg" id="e-eg_panf"><i
                                                    class="fa-solid fa-circle-exclamation"></i><span>PAN document is
                                                    required.</span></div>
                                        </div>
                                    </div>
                                    <div class="fgrp">
                                        <label class="flbl">MSME Certificate <span
                                                class="opt">Optional</span></label>
                                        <div class="file-zone" style="max-width:380px;"><input type="file"
                                                id="msme_certificate" name="msme_certificate"
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
                                        here</a>
                                </div>
                                <div class="foot-btns">
                                    <button class="btn-prev" id="empBtnPrev" onclick="empNav(-1)"
                                        style="display:none;"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button type="button" class="btn-next green-next" id="empBtnNext"
                                        onclick="empNav(1)">Next <i class="fa-solid fa-arrow-right"></i></button>
                                    <button type="submit" class="btn-submit green-sub" id="employer_register"
                                        style="display:none;" onclick="empSubmit()"><i
                                            class="fa-solid fa-building-flag"></i> Register
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
@endsection
<!-- ════════ JAVASCRIPT ════════ -->
@push('scripts')
    <script>
        const skillsData = @json($skills);
    </script>
    <script>
        /* ── ANNOUNCE ── */
        function closeAnnounce() {
            const b = document.getElementById('announceBar');
            b.style.maxHeight = b.offsetHeight + 'px';
            requestAnimationFrame(() => {
                b.style.transition = 'max-height .3s,opacity .3s,padding .3s';
                b.style.maxHeight = '0';
                b.style.opacity = '0';
                b.style.padding = '0';
                b.style.overflow = 'hidden';
            });
        }

        /* ── STICKY HEADER ── */
        // const hdr = document.getElementById('mainHeader');
        // window.addEventListener('scroll', () => {
        //     hdr.classList.toggle('scrolled', window.scrollY > 20);
        //     document.getElementById('toTop').classList.toggle('visible', window.scrollY > 300);
        // }, {
        //     passive: true
        // });
        const hdr = document.getElementById('mainHeader');
        const toTop = document.getElementById('toTop');

        window.addEventListener('scroll', () => {

            if (hdr) {
                hdr.classList.toggle('scrolled', window.scrollY > 20);
            }

            if (toTop) {
                toTop.classList.toggle('visible', window.scrollY > 300);
            }

        }, {
            passive: true
        });

        /* ── MOBILE NAV ── */
        function toggleMobile() {
            document.getElementById('navHam').classList.toggle('open');
            document.getElementById('mobileMenu').classList.toggle('open');
        }

        /* ── CONFIG ── */
        const jsMeta = [{
                ico: 'fa-user',
                title: 'Personal Information',
                sub: 'Step 1 of 5 — Your basic details'
            },
            {
                ico: 'fa-map-location-dot',
                title: 'Location Information',
                sub: 'Step 2 of 5 — Where are you based?'
            },
            {
                ico: 'fa-graduation-cap',
                title: 'Education & Experience',
                sub: 'Step 3 of 5 — Your qualifications'
            },
            {
                ico: 'fa-screwdriver-wrench',
                title: 'Skills Selection',
                sub: 'Step 4 of 5 — Select your skills'
            },
            {
                ico: 'fa-file-arrow-up',
                title: 'Documents',
                sub: 'Step 5 of 5 — Upload & confirm'
            },
        ];
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
        const jsSideLabels = ['Personal', 'Location', 'Education', 'Skills', 'Documents'];
        const empSideLabels = ['Company', 'Contact', 'Account', 'Verification', 'Documents'];

        let curType = 'jobseeker',
            jsStep = 1,
            empStep = 1;

        /* ── SWITCH TYPE ── */
        function switchType(type) {
            curType = type;
            const isJs = type === 'jobseeker';
            document.getElementById('tsBtnJs').className = 'ts-btn ts-js' + (isJs ? ' sel-blue' : '');
            document.getElementById('tsBtnEmp').className = 'ts-btn ts-emp' + (!isJs ? ' sel-green' : '');
            document.getElementById('regLeft').className = 'reg-left ' + (isJs ? 'mode-blue' : 'mode-green');
            document.getElementById('rlJs').style.display = isJs ? '' : 'none';
            document.getElementById('rlEmp').style.display = isJs ? 'none' : '';
            document.getElementById('rlStats').innerHTML = isJs ?
                `<div><div class="rl-stat-val">50K+</div><div class="rl-stat-lbl">Job Seekers</div></div><div><div class="rl-stat-val">1,200+</div><div class="rl-stat-lbl">Companies</div></div><div><div class="rl-stat-val">Free</div><div class="rl-stat-lbl">Always</div></div>` :
                `<div><div class="rl-stat-val">1,200+</div><div class="rl-stat-lbl">Employers</div></div><div><div class="rl-stat-val">₹600</div><div class="rl-stat-lbl">Starting</div></div><div><div class="rl-stat-val">48hr</div><div class="rl-stat-lbl">Response</div></div>`;
            document.getElementById('jsForm').style.display = isJs ? 'block' : 'none';
            document.getElementById('empForm').style.display = isJs ? 'none' : 'block';
            renderSideSteps(isJs ? jsStep : empStep, isJs ? jsSideLabels : empSideLabels, isJs);
        }

        function renderSideSteps(cur, labels, isJs) {
            const c = document.getElementById('rlSteps');
            c.innerHTML = '';
            labels.forEach((lbl, i) => {
                const n = i + 1;
                const cls = n < cur ? 's-done' : n === cur ? 's-active' : '';
                const icon = n < cur ? '<i class="fa-solid fa-check" style="font-size:.56rem;"></i>' : n + '';
                c.innerHTML +=
                    `<div class="rl-step ${cls}"><div class="rl-step-num">${icon}</div><div class="rl-step-name">${lbl}</div></div>`;
            });
        }

        /* ── JS NAVIGATION ── */
        function jsNav(dir) {
            if (dir === 1 && !jsValidate(jsStep)) return;
            jsStep = Math.max(1, Math.min(5, jsStep + dir));
            jsShowStep(jsStep);
            if (jsStep === 5) jsBuildSummary();
        }

        function jsShowStep(s) {
            document.querySelectorAll('#jsForm .panel').forEach(p => p.classList.remove('active'));
            document.getElementById('js-p' + s).classList.add('active');
            const m = jsMeta[s - 1];
            document.getElementById('jsHeadIco').className = 'fa-solid ' + m.ico;
            document.getElementById('jsHeadTitle').textContent = m.title;
            document.getElementById('jsHeadSub').textContent = m.sub;
            document.getElementById('jsBtnPrev').style.display = s > 1 ? '' : 'none';
            document.getElementById('jsBtnNext').style.display = s < 5 ? '' : 'none';
            document.getElementById('jsBtnSub').style.display = s === 5 ? '' : 'none';
            renderSideSteps(s, jsSideLabels, true);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
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
            renderSideSteps(s, empSideLabels, false);
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        /* ── VALIDATION ── */
        const g = id => (document.getElementById(id) || {}).value || '';

        function vErr(id, msg) {
            const f = document.getElementById(id);
            const e = document.getElementById('e-' + id);
            if (f) f.classList.add('err');
            if (e) {
                e.classList.add('show');
                if (msg) {
                    const sp = e.querySelector('span');
                    if (sp) sp.textContent = msg;
                }
            }
        }

        function vClr(...ids) {
            ids.forEach(id => {
                const f = document.getElementById(id);
                const e = document.getElementById('e-' + id);
                if (f) f.classList.remove('err');
                if (e) e.classList.remove('show');
            });
        }

        function jsValidate(s) {
            let ok = true;
            const al = document.getElementById('js-al' + s);
            if (al) al.classList.remove('show');
            if (s === 1) {
                vClr('full_name', 'mobile', 'email', 'password', 'confirm_password');
                if (g('full_name').trim().length < 2) {
                    vErr('full_name');
                    ok = false;
                }
                if (g('mobile').replace(/\D/g, '').length < 10) {
                    vErr('mobile');
                    ok = false;
                }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(g('email').trim())) {
                    vErr('email');
                    ok = false;
                }
                const pw = g('password');
                if (pw.length < 8) {
                    vErr('password');
                    ok = false;
                }
                if (g('confirm_password') !== pw) {
                    vErr('confirm_password');
                    ok = false;
                }
            }
            if (s === 2) {
                vClr('state', 'district', 'city');
                if (!g('state')) {
                    vErr('state');
                    ok = false;
                }
                if (!g('district')) {
                    vErr('district');
                    ok = false;
                }
                if (g('city').trim().length < 2) {
                    vErr('city');
                    ok = false;
                }
            }
            if (s === 3) {
                vClr('qualification');
                if (!g('qualification')) {
                    vErr('qualification');
                    ok = false;
                }
            }
            if (s === 4) {
                if (!document.querySelectorAll('.skill-chip input:checked').length) {
                    if (al) al.classList.add('show');
                    return false;
                }
            }
            if (!ok && al) al.classList.add('show');
            return ok;
        }

        function empValidate(step) {

            let valid = true;
            let firstError = null;

            // clear old errors
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
            }

            if (step === 4) {
                check('c_gst', 'GST number is required');
                check('c_pan', 'PAN number is required');
            }

            if (step === 5) {
                check('gst_certificate', 'GST certificate is required');
                check('pan_document', 'PAN document is required');
            }

            // ❗ Show toaster
            if (!valid) {
                toastr.error(firstError);

                // scroll to first error
                document.querySelector('.error')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return valid;
        }

        /* ── SUMMARIES ── */
        function jsBuildSummary() {
            const qm = {
                none: 'None',
                '10th': '10th Pass',
                '12th': '12th / HSC',
                diploma: 'Diploma',
                bachelor: "Bachelor's",
                master: "Master's",
                doctorate: 'Doctorate'
            };
            const skills = Array.from(document.querySelectorAll('.skill-chip input:checked')).map(c => c.value);
            const q = document.getElementById('qualification');
            document.getElementById('ss-nm').textContent = g('full_name') || '—';
            document.getElementById('ss-mb').textContent = g('mobile') || '—';
            document.getElementById('ss-em').textContent = g('email') || '—';
            document.getElementById('ss-lc').textContent = [g('city'), g('district'), g('state')].filter(Boolean).join(
                ', ') || '—';
            document.getElementById('ss-ql').textContent = (q && qm[q.value]) || q.value || '—';
            document.getElementById('ss-xp').textContent = document.getElementById('exp_e').checked ? 'Experienced' :
                'Fresher';
            document.getElementById('ss-sk').textContent = skills.length ? skills.slice(0, 8).join(', ') + (skills.length >
                8 ? ' +more' : '') : 'None';
        }

        function empBuildSummary() {
            document.getElementById('es-co').textContent = g('company_name') || '—';
            document.getElementById('es-lc').textContent = [g('c_city'), g('c_district'), g('c_state')].filter(Boolean)
                .join(
                    ', ') || '—';
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
        function jsSubmit() {
            const b = document.getElementById('jsBtnSub');
            b.disabled = true;
            b.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Account...';
        }
        document.getElementById('jsBtnSub').addEventListener('click', function(e) {
            e.preventDefault();

            let form = document.getElementById('registrationForm');
            let formData = new FormData(form);

            let btn = document.getElementById('jsBtnSub');
            btn.disabled = true;
            btn.innerHTML = 'Processing...';

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Create Account';

                    if (data.status) {
                        toastr.success(data.message);

                        setTimeout(() => {
                            form.reset();
                            document.getElementById('ss-nm').innerText = '—';
                            document.getElementById('ss-mb').innerText = '—';
                            document.getElementById('ss-em').innerText = '—';
                            document.getElementById('ss-lc').innerText = '—';
                            document.getElementById('ss-ql').innerText = '—';
                            document.getElementById('ss-xp').innerText = '—';
                            document.getElementById('ss-sk').innerText = '—';

                            document.getElementById('js-rl').innerText = 'Click to upload resume';
                            document.getElementById('js-pl').innerText = 'Click to upload photo';

                            document.querySelectorAll('.panel').forEach(p => p.classList.remove(
                                'active'));
                            document.getElementById('js-p1').classList.add('active');

                            document.getElementById('jsBtnPrev').style.display = 'none';
                            document.getElementById('jsBtnNext').style.display = 'inline-block';
                            document.getElementById('jsBtnSub').style.display = 'none';
                        }, 1500);
                    } else {
                        toastr.error(data.message);
                    }

                })
                .catch(error => {

                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Create Account';

                    if (error.errors) {
                        Object.values(error.errors).forEach(err => {
                            toastr.error(err[0]);
                        });
                    } else {
                        toastr.error('Something went wrong');
                    }
                });
        });

        document.getElementById('employer_register').addEventListener('click', function(e) {
            e.preventDefault();

            let form = document.getElementById('employer_registrationForm');
            let formData = new FormData(form);

            let btn = document.getElementById('employer_register');
            btn.disabled = true;
            btn.innerHTML = 'Processing...';

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

                // ❗ HANDLE VALIDATION ERROR (422)
                if (!response.ok) {
                    throw { status: response.status, data: data };
                }

                return data;
            })
            .then(data => {

                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Create Account';

                if (data.status) {
                    toastr.success(data.message);

                    setTimeout(() => {
                        form.reset();

                        // reset summary
                        document.getElementById('es-co').innerText = '—';
                        document.getElementById('es-lc').innerText = '—';
                        document.getElementById('es-ow').innerText = '—';
                        document.getElementById('es-hr').innerText = '—';
                        document.getElementById('es-em').innerText = '—';
                        document.getElementById('es-gs').innerText = '—';
                        document.getElementById('es-pn').innerText = '—';
                        document.getElementById('es-ms').innerText = '—';

                        document.getElementById('eg-rl').innerText = 'Click to upload GST certificate';
                        document.getElementById('ep-rl').innerText = 'Click to upload PAN document';
                        document.getElementById('em-rl').innerText = 'Click to upload MSME certificate';

                        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
                        document.getElementById('emp-p1').classList.add('active');

                        document.getElementById('empBtnPrev').style.display = 'none';
                        document.getElementById('empBtnNext').style.display = 'inline-block';
                        document.getElementById('employer_register').style.display = 'none';

                    }, 1500);

                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {

                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-user-plus"></i> Create Account';

                // ✅ VALIDATION ERRORS (422)
                if (error.status === 422) {
                    let errors = error.data.errors;

                    Object.values(errors).forEach(err => {
                        toastr.error(err[0]);
                    });
                }

                // ✅ SERVER ERROR
                else if (error.status === 500) {
                    toastr.error(error.data.message || 'Server error');
                }

                // ✅ OTHER
                else {
                    toastr.error('Something went wrong');
                }
            });
        });

        function empSubmit() {
            const b = document.getElementById('employer_register');
            b.disabled = true;
            b.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Registering Company...';
        }

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

        /* ── EXP TOGGLE ── */
        function togExp(show) {
            document.getElementById('expFields').style.display = show ? 'block' : 'none';
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

        /* ── BUILD SKILLS ── */
        (function() {
            const c = document.getElementById('skillsBox');

            skillsData.forEach(skill => {
                const id = 'sk_' + skill.id;

                const ch = document.createElement('div');
                ch.className = 'skill-chip';

                ch.innerHTML = `
                <input type="checkbox" name="skills[]" id="${id}" value="${skill.id}">
                <label for="${id}">${skill.skill_name}</label>
            `;

                c.appendChild(ch);
            });
        })();

        /* ── LIVE CLEAR ERRORS ── */
        document.querySelectorAll('.finput').forEach(inp => {
            ['input', 'change'].forEach(ev => inp.addEventListener(ev, function() {
                this.classList.remove('err');
                const e = document.getElementById('e-' + this.id);
                if (e) e.classList.remove('show');
            }));
        });

        /* ── INIT ── */
        switchType('jobseeker');
    </script>
@endpush
