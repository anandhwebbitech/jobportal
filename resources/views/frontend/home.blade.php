{{-- ════════════════════════════════════════════════════════
     resources/views/frontend/home.blade.php
     STATIC VERSION — no backend data, no @auth
════════════════════════════════════════════════════════ --}}

@extends('frontend.app')
@section('title', 'LinearJobs – Find Your Next Job in India')

{{-- ═══════════════════════════════
     PAGE CSS (home-specific)
═══════════════════════════════ --}}
@push('styles')
    {{-- Font Awesome 6 Free CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ── HERO ──────────────────────────────────────────────────── */
        .lj-hero {
            background: #fff;
            padding: 20px 20px 15px 20px;
            text-align: center;
            border-bottom: var(--border);
        }

        .lj-hero-logo {
            font-size: clamp(1.4rem, 5vw, 2.5rem);
            font-weight: 800;
            color: var(--blue);
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 10px;
        }

        .lj-hero-title {
            font-size: clamp(1rem, 2.6vw, 1.1rem);
            font-weight: 700;
            color: var(--n900);
            margin-bottom: 6px;
        }

        .lj-hero-sub {
            font-size: .9375rem;
            color: var(--n500);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        /* ===============================
                    SEARCH BAR - MODERN UI
                   (Updated: Individual Field Highlight)
                ================================ */

        /* MAIN WRAPPER BOX */
        .lj-search-box {
            max-width: 840px;
            margin: 0 auto 14px;
            background: #fff;
            border: 1.5px solid var(--n200, #e5e7eb);
            border-radius: calc(var(--r, 8px) + 4px);
            box-shadow: var(--sh-md, 0 4px 12px rgba(0, 0, 0, 0.05));
            overflow: hidden;
            transition: all 0.25s ease;
        }

        /* Elevate slightly on hover */
        .lj-search-box:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        /* FORM CONTAINER */
        .lj-search-form {
            width: 100%;
            display: flex;
            align-items: stretch;
            padding: 6px;
            /* Inner padding so focused fields have room to glow */
            gap: 4px;
        }

        /* INDIVIDUAL FIELD WRAPPER */
        .lj-field-wrap {
            display: flex;
            align-items: center;
            position: relative;
            background: transparent;
            border: 1.5px solid transparent;
            border-radius: var(--r, 8px);
            transition: all 0.25s ease;
        }

        /* 🔥 FOCUS EFFECT: ONLY HIGHLIGHTS THE CLICKED FIELD */
        .lj-field-wrap:focus-within {
            background: #f9fbff;
            border-color: var(--blue, #1a56db);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15);
        }

        /* Flex sizes for different fields */
        .lj-field-keyword {
            flex: 1.5;
        }

        .lj-field-state {
            flex: 1;
            min-width: 130px;
        }

        .lj-field-district {
            flex: 1;
            min-width: 130px;
        }

        /* ICON */
        .lj-search-ico {
            padding: 0 0 0 14px;
            color: var(--n400, #9ca3af);
            font-size: .9rem;
            transition: color 0.25s ease;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        /* Icon turns blue only when its specific wrapper is focused */
        .lj-field-wrap:focus-within .lj-search-ico {
            color: var(--blue, #1a56db);
        }

        /* INPUTS & SELECTS */
        .lj-search-input,
        .lj-search-sel {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-family: var(--f, inherit);
            font-size: .9375rem;
            color: var(--n900, #111827);
            padding: 14px 12px;
            transition: all 0.25s ease;
        }

        .lj-search-input::placeholder {
            color: var(--n400, #9ca3af);
            transition: all 0.25s ease;
        }

        .lj-search-input:focus::placeholder {
            color: var(--blue, #1a56db);
            transform: translateX(4px);
        }

        .lj-search-sel {
            font-size: .875rem;
            color: var(--n700, #374151);
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        /* Text turns blue on select focus */
        .lj-field-wrap:focus-within .lj-search-sel {
            color: var(--blue, #1a56db);
        }

        .lj-search-sel option {
            color: var(--n900, #111827);
            background: #fff;
        }

        /* SEPARATOR */
        .lj-search-sep {
            width: 1px;
            background: var(--n200, #e5e7eb);
            margin: 8px 2px;
            flex-shrink: 0;
            transition: opacity 0.25s ease;
        }

        /* CTA AREA */
        .lj-search-cta {
            display: flex;
            align-items: stretch;
            padding-left: 2px;
            flex-shrink: 0;
        }

        /* BUTTON */
        .lj-search-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--blue, #1a56db);
            color: #fff;
            border: none;
            border-radius: var(--r, 8px);
            font-family: var(--f, inherit);
            font-size: .9375rem;
            font-weight: 600;
            padding: 0 24px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.25s ease;
        }

        .lj-search-btn:hover {
            background: var(--blue-h, #1e40af);
            box-shadow: 0 4px 14px rgba(26, 86, 219, 0.3);
            transform: translateY(-1px);
        }

        /* Trending tags */
        .lj-trend-row {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
            font-size: .8125rem;
            color: var(--n500);
        }

        .lj-trend-label {
            font-weight: 600;
            color: var(--n700);
        }

        .lj-trend-tag {
            display: inline-flex;
            align-items: center;
            color: var(--blue);
            background: var(--blue-lt);
            border: 1px solid var(--blue-mid);
            border-radius: 100px;
            padding: 3px 12px;
            font-size: .8rem;
            font-weight: 500;
            cursor: pointer;
            transition: background var(--t), color var(--t), border-color var(--t);
        }

        .lj-trend-tag:hover {
            background: var(--blue);
            color: #fff;
            border-color: var(--blue);
        }

        /* Mobile search overrides */
        @media (max-width: 600px) {
            .lj-hero {
                padding: 40px 16px 36px;
            }

            .lj-search-form {
                flex-direction: column;
                gap: 8px;
            }

            .lj-search-sep {
                display: none;
            }

            .lj-search-ico {
                padding-left: 16px;
            }

            .lj-search-cta {
                padding-left: 0;
                margin-top: 4px;
            }

            .lj-search-btn {
                width: 100%;
                justify-content: center;
                padding: 14px;
            }
        }

        /* ── STATS BAR ─────────────────────────────────────────────── */
        .lj-stats {
            background: var(--n50);
            border-bottom: var(--border);
            padding: 14px 20px;
        }

        .lj-stats-row {
            max-width: 780px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .lj-stat {
            text-align: center;
            padding: 6px 28px;
            border-right: var(--border);
        }

        .lj-stat:last-child {
            border-right: none;
        }

        .lj-stat-val {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--blue);
            line-height: 1;
            margin-bottom: 2px;
        }

        .lj-stat-lbl {
            font-size: .72rem;
            color: var(--n500);
        }

        @media (max-width: 560px) {
            .lj-stats {
                padding: 10px 16px;
            }

            .lj-stats-row {
                gap: 0;
            }

            .lj-stat {
                flex: 1 1 50%;
                padding: 10px 8px;
                border-right: none;
                border-bottom: var(--border);
            }

            .lj-stat:nth-child(odd) {
                border-right: var(--border);
            }

            .lj-stat:nth-child(3),
            .lj-stat:nth-child(4) {
                border-bottom: none;
            }
        }

        /* ── CHIPS BAR ─────────────────────────────────────────────── */
        .lj-chips-bar {
            border-bottom: var(--border);
            background: #fff;
            padding: 0 20px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .lj-chips-bar::-webkit-scrollbar {
            display: none;
        }

        .lj-chips-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 0;
            min-width: max-content;
        }

        .lj-chips-lbl {
            font-size: .8rem;
            font-weight: 700;
            color: var(--n500);
            white-space: nowrap;
            margin-right: 4px;
            flex-shrink: 0;
        }

        /* ── AUDIENCE CARDS ─────────────────────────────────────────── */
        .lj-aud-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .lj-aud-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: var(--r-lg);
            padding: 32px 28px;
            transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        }

        .lj-aud-card:hover {
            border-color: var(--blue);
            box-shadow: var(--sh-lg);
            transform: translateY(-2px);
        }

        .lj-aud-ico {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 16px;
        }

        .lj-aud-ico-blue {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .lj-aud-ico-green {
            background: var(--green-lt);
            color: var(--green);
        }

        .lj-aud-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--n900);
            margin-bottom: 8px;
        }

        .lj-aud-desc {
            font-size: .9rem;
            color: var(--n500);
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .lj-aud-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 680px) {
            .lj-aud-grid {
                grid-template-columns: 1fr;
            }

            .lj-aud-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 400px) {
            .lj-aud-btns {
                flex-direction: column;
            }

            .lj-aud-btns .lj-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* ── FEATURE CARDS ──────────────────────────────────────────── */
        .lj-feat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .lj-feat-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: var(--r-lg);
            padding: 22px 18px;
            position: relative;
            overflow: hidden;
            transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        }

        .lj-feat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .25s ease;
        }

        .lj-feat-card:hover {
            box-shadow: var(--sh-lg);
            transform: translateY(-3px);
        }

        .lj-feat-card:hover::after {
            transform: scaleX(1);
        }

        .lj-fc-b:hover {
            border-color: var(--blue);
        }

        .lj-fc-b::after {
            background: var(--blue);
        }

        .lj-fc-g:hover {
            border-color: var(--green);
        }

        .lj-fc-g::after {
            background: var(--green);
        }

        .lj-fc-a:hover {
            border-color: var(--amber);
        }

        .lj-fc-a::after {
            background: var(--amber);
        }

        .lj-fc-r:hover {
            border-color: var(--red);
        }

        .lj-fc-r::after {
            background: var(--red);
        }

        .lj-feat-ico {
            width: 42px;
            height: 42px;
            border-radius: var(--r);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            margin-bottom: 14px;
        }

        .lj-fi-b {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .lj-fi-g {
            background: var(--green-lt);
            color: var(--green);
        }

        .lj-fi-a {
            background: #fef3c7;
            color: #b45309;
        }

        .lj-fi-r {
            background: #fee2e2;
            color: #b91c1c;
        }

        .lj-feat-name {
            font-size: .9375rem;
            font-weight: 700;
            color: var(--n900);
            margin-bottom: 6px;
        }

        .lj-feat-text {
            font-size: .8125rem;
            color: var(--n500);
            line-height: 1.6;
        }

        @media (max-width: 900px) {
            .lj-feat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .lj-feat-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── JOB CARDS ──────────────────────────────────────────────── */
        .lj-jobs-hdr {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 22px;
        }

        .lj-jobs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .lj-job-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: var(--r-lg);
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: border-color var(--t), box-shadow var(--t), transform var(--t);
        }

        .lj-job-card:hover {
            border-color: var(--blue);
            box-shadow: var(--sh-lg);
            transform: translateY(-2px);
        }

        .lj-job-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .lj-co-logo {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: var(--r);
            border: var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8125rem;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .lj-job-name {
            font-size: .9375rem;
            font-weight: 700;
            color: var(--blue);
            line-height: 1.3;
            margin-bottom: 2px;
            cursor: pointer;
        }

        .lj-job-name:hover {
            text-decoration: underline;
        }

        .lj-job-co {
            font-size: .8125rem;
            color: var(--n500);
        }

        .lj-job-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .lj-job-sal {
            font-size: .8125rem;
            font-weight: 700;
            color: var(--green);
            margin-bottom: 14px;
            margin-top: auto;
        }

        .lj-job-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .lj-btn-apply {
            background: var(--blue);
            color: #fff;
            border-color: var(--blue);
        }

        .lj-btn-apply:hover {
            background: var(--blue-h);
            border-color: var(--blue-h);
            color: #fff;
        }

        .lj-btn-view {
            background: #fff;
            color: var(--blue);
            border-color: var(--blue);
        }

        .lj-btn-view:hover {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .lj-posted {
            font-size: .72rem;
            color: var(--n400);
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        @media (max-width: 960px) {
            .lj-jobs-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 540px) {
            .lj-jobs-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── LOYALTY BANNER ─────────────────────────────────────────── */
        .lj-loyalty {
            background: var(--blue);
            padding: 52px 20px;
            text-align: center;
        }

        .lj-loy-body {
            max-width: 580px;
            margin: 0 auto;
        }

        .lj-loy-shield {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            border: 2px solid rgba(255, 255, 255, .28);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 18px;
        }

        .lj-loy-title {
            font-size: clamp(1.2rem, 3.5vw, 1.5rem);
            font-weight: 800;
            color: #fff;
            letter-spacing: -.25px;
            margin-bottom: 10px;
        }

        .lj-loy-text {
            font-size: .9375rem;
            color: rgba(255, 255, 255, .82);
            line-height: 1.7;
            margin-bottom: 22px;
        }

        .lj-loy-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 26px;
        }

        .lj-loy-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .92);
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: var(--r-sm);
            padding: 6px 14px;
        }

        .lj-loy-tag i {
            font-size: .68rem;
            color: #6ee7b7;
        }

        /* ═══════════════════════════════════════════════════════
                    ── SPONSORED / IMAGE ADS SECTION ─────────────────────
                ═══════════════════════════════════════════════════════ */

        .lj-ads {
            background: #ffffff;
            /* Strict white background */
            padding: 26px 20px;
            position: relative;
            overflow: hidden;
            border-top: 1px solid var(--n200);
            border-bottom: 1px solid var(--n200);
        }

        .lj-ads-lbl {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }

        .lj-ads-lbl-inner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(26, 86, 219, 0.2);
            border-radius: 100px;
            padding: 6px 20px 6px 14px;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--blue);
            box-shadow: 0 4px 15px rgba(26, 86, 219, 0.08);
        }

        .lj-ads-lbl-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, .2);
            flex-shrink: 0;
            animation: lj-pulse-dot 2.2s ease-in-out infinite;
        }

        @keyframes lj-pulse-dot {

            0%,
            100% {
                box-shadow: 0 0 0 3px rgba(245, 158, 11, .2);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(245, 158, 11, .08);
            }
        }

        /* Large, prominent grid for a "little big show" */
        .lj-ad-img-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(480px, 1fr));
            gap: 28px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .lj-ad-img-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Glassmorphism & Neon Glow on Hover */
        .lj-ad-img-wrap {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            display: block;
            text-decoration: none;
            aspect-ratio: 18 / 9;
            /* Wider, cinematic aspect ratio */
            background: #fff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border: 2px solid rgba(26, 86, 219, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
        }

        .lj-ad-img-wrap:hover {
            transform: translateY(-8px) scale(1.02);
            /* Soft Neon gradient mix (Blue & Green) */
            box-shadow: 0 24px 48px rgba(26, 86, 219, 0.18), 0 0 30px rgba(16, 185, 129, 0.1);
            border-color: rgba(26, 86, 219, 0.3);
        }

        .lj-ad-img-wrap img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform .6s ease;
        }

        .lj-ad-img-wrap:hover img {
            transform: scale(1.04);
        }

        /* Glassmorphic Pill */
        .lj-ad-img-pill {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 4;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 100px;
            padding: 4px 12px;
            font-size: .65rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #fff;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            pointer-events: none;
        }

        .lj-ad-img-pill i {
            font-size: .6rem;
        }

        /* Refined Overlay */
        .lj-ad-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 60%);
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            padding: 24px;
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }

        .lj-ad-img-wrap:hover .lj-ad-img-overlay {
            opacity: 1;
        }

        .lj-ad-img-overlay-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: .85rem;
            font-weight: 800;
            border-radius: 12px;
            padding: 10px 20px;
            letter-spacing: .02em;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .lj-ad-img-overlay-cta i {
            font-size: .75rem;
        }

        .lj-ad-img-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #e8ecf2 25%, #f2f4f8 50%, #e8ecf2 75%);
            background-size: 200% 100%;
            animation: lj-shimmer 1.6s infinite linear;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            color: #94a3b8;
        }

        @keyframes lj-shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .lj-ad-img-placeholder i {
            font-size: 2rem;
            opacity: .35;
        }

        .lj-ad-img-placeholder span {
            font-size: .78rem;
            font-weight: 600;
            opacity: .45;
            letter-spacing: .04em;
        }

        @media (max-width: 400px) {
            .lj-ad-img-wrap {
                aspect-ratio: 16 / 9;
            }
        }

        /* ── RESULT GRID / JOBS LIST ───────────────────────────────── */
        #jobResults {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 18px;
        }

        .job-card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition: 0.25s ease;
            border: 1px solid #f1f1f1;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .job-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #1f2937;
        }

        .job-title-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .badge-new {
            background: #10b981;
            color: #fff;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .job-company,
        .job-location {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        .job-company i,
        .job-location i {
            margin-right: 5px;
        }

        .job-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .job-body {
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 20px;
            margin: 4px 4px 0 0;
            background: #f3f4f6;
            color: #374151;
        }

        .badge.salary {
            background: #ecfdf5;
            color: #065f46;
        }

        .badge.type {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge.exp {
            background: #fef3c7;
            color: #92400e;
        }

        .job-desc {
            font-size: 13px;
            color: #6b7280;
            margin-top: 8px;
            line-height: 1.4;
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            border-top: 1px solid #f3f4f6;
            padding-top: 10px;
        }

        .time {
            font-size: 12px;
            color: #9ca3af;
        }

        .save-btn {
            background: transparent;
            border: none;
            font-size: 16px;
            color: #6b7280;
            cursor: pointer;
            transition: 0.2s;
        }

        .save-btn:hover {
            color: #111827;
        }

        .no-jobs {
            padding: 20px;
            color: #6b7280;
        }
    </style>
@endpush


{{-- ═══════════════════════════════════════════════════
     PAGE CONTENT
═══════════════════════════════════════════════════ --}}
@section('content')

    {{-- ── HERO ────────────────────────────────────────── --}}
    <section class="lj-hero">

        <div class="lj-hero-logo lj-anim">LinearJobs</div>

        <div class="lj-anim lj-anim-d1">
            <div class="lj-hero-title">Find Your Next Job in India</div>
            <div class="lj-hero-sub">Connecting skilled professionals with verified MSME employers.</div>
        </div>

        {{-- Search Bar --}}
        <div class="lj-anim lj-anim-d2">
            <div class="lj-search-box">
                <form method="GET" action="{{ route('jobs.index') }}" class="lj-search-form">

                    <!-- Field 1: Keyword/Title -->
                    <div class="lj-field-wrap lj-field-keyword">
                        <div class="lj-search-ico">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input class="lj-search-input" id="ljSearchInput" name="title" type="text"
                            placeholder="Job title, keywords, or company">
                    </div>

                    <div class="lj-search-sep"></div>

                    <!-- Field 2: State -->
                    <div class="lj-field-wrap lj-field-state">
                        <select class="lj-search-sel" id="ljStateSel" name="state">
                            <option value="">State</option>
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
                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and
                                Diu</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Ladakh">Ladakh</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Puducherry">Puducherry</option>
                        </select>
                    </div>

                    <div class="lj-search-sep"></div>

                    <!-- Field 3: District -->
                    <div class="lj-field-wrap lj-field-district">
                        <select class="lj-search-sel" id="ljLocationSel" name="location">
                            <option value="">District</option>
                        </select>
                    </div>

                    <!-- Submit CTA -->
                    <div class="lj-search-cta">
                        <button type="submit" class="lj-search-btn" id="ljSearchBtn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Find Jobs</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- <div id="jobResults">
            @include('frontend.jobs.job-list')
        </div> --}}

        {{-- Trending tags --}}


    </section>


    <section class="lj-ads">
        <div class="lj-wrap">

            @if ($banners->count())
                <div class="lj-ads-lbl">
                    <div class="lj-ads-lbl-inner">
                        <span class="lj-ads-lbl-dot"></span>
                        <i class="fa-solid fa-rectangle-ad"></i>&nbsp;Premium Partners
                    </div>
                </div>

                <div class="lj-ad-img-grid">
                    @foreach ($banners as $banner)
                        <a href="#" class="lj-ad-img-wrap" target="_blank" rel="noopener">
                            <span class="lj-ad-img-pill">
                                <i class="fa-solid fa-star"></i> Featured
                            </span>
                            <img src="{{ asset('public/storage/banners/' . $banner->banner_image) }}" alt="Sponsored Banner"
                                loading="lazy" />
                            <div class="lj-ad-img-overlay">
                                <span class="lj-ad-img-overlay-cta">
                                    Visit Website
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <hr class="lj-rule" />


    {{-- ── FEATURES ────────────────────────────────────── --}}
    <section class="lj-section lj-bg-gray">
        <div class="lj-wrap">
            <div style="text-align:center; margin-bottom:28px;">
                <div class="lj-eyebrow">Why LinearJobs</div>
                <div class="lj-heading">Built for India</div>
            </div>
            <div class="lj-feat-grid">

                <div class="lj-feat-card lj-fc-b" data-reveal>
                    <div class="lj-feat-ico lj-fi-b">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="lj-feat-name">Trusted by MSMEs</div>
                    <div class="lj-feat-text">Hundreds of verified small and medium businesses rely on LinearJobs to find
                        reliable talent efficiently.</div>
                </div>

                <div class="lj-feat-card lj-fc-g" data-reveal>
                    <div class="lj-feat-ico lj-fi-g">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="lj-feat-name">Verified Employers</div>
                    <div class="lj-feat-text">Every employer is verified with GST and PAN documents, ensuring a safe and
                        authentic job search experience.</div>
                </div>

                <div class="lj-feat-card lj-fc-a" data-reveal>
                    <div class="lj-feat-ico lj-fi-a">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <div class="lj-feat-name">Affordable Hiring</div>
                    <div class="lj-feat-text">Post jobs starting at just ₹600. Budget-friendly plans designed for growing
                        businesses across India.</div>
                </div>

                <div class="lj-feat-card lj-fc-r" data-reveal>
                    <div class="lj-feat-ico lj-fi-r">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div class="lj-feat-name">India Focused</div>
                    <div class="lj-feat-text">Covering all 32 districts with region-specific listings and dedicated support
                        for local job seekers.</div>
                </div>

            </div>
        </div>
    </section>

    <hr class="lj-rule" />


    {{-- ── LOYALTY ──────────────────────────────────────── --}}
    <section class="lj-loyalty">
        <div class="lj-loy-body">
            <div class="lj-loy-shield">
                <i class="fa-solid fa-shield-heart" style="color:#fff; font-size:1.5rem;"></i>
            </div>
            <div class="lj-loy-title">100% Loyalty to Job Seekers</div>
            <div class="lj-loy-text">
                We provide 100% loyalty to job seekers and connect them only with verified and trusted employers. No fake
                listings. No spam. Just real opportunities from real companies across every district in India.
            </div>
            <div class="lj-loy-tags">
                <span class="lj-loy-tag"><i class="fa-solid fa-circle-check"></i> Zero Fake Listings</span>
                <span class="lj-loy-tag"><i class="fa-solid fa-user-shield"></i> Verified Employers Only</span>
                <span class="lj-loy-tag"><i class="fa-solid fa-hand-holding-heart"></i> Free to Apply</span>
                <span class="lj-loy-tag"><i class="fa-solid fa-lock"></i> Safe &amp; Private</span>
            </div>
            <a href="{{ route('jobseeker.register') }}" class="lj-btn lj-btn-white lj-btn-lg">
                Create Free Account <i class="fa-solid fa-arrow-right" style="font-size:.78rem; margin-left:4px;"></i>
            </a>
        </div>
    </section>

    <script>
        function isNew(date) {
            let created = new Date(date);
            let now = new Date();
            let diff = (now - created) / (1000 * 60 * 60 * 24);

            return diff <= 2 ? `<span class="lj-job-badge new">New</span>` : '';
        }

        function timeAgo(date) {
            let seconds = Math.floor((new Date() - new Date(date)) / 1000);

            let intervals = {
                year: 31536000,
                month: 2592000,
                day: 86400,
                hour: 3600,
                minute: 60
            };

            for (let key in intervals) {
                let value = Math.floor(seconds / intervals[key]);
                if (value > 0) {
                    return value + " " + key + (value > 1 ? "s" : "") + " ago";
                }
            }

            return "Just now";
        }

        function truncate(text, length) {
            if (!text) return '';
            return text.length > length ? text.substring(0, length) + '...' : text;
        }

        document.getElementById('ljStateSel').addEventListener('change', async function() {

            let state = this.value;
            let districtSel = document.getElementById('ljLocationSel');

            // reset
            districtSel.innerHTML = '<option value="">Loading...</option>';

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
                    result.data.forEach(function(district) {
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

@endsection
