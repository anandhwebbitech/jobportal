{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/contact.blade.php
     Contact Page – LinearJobs
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Contact Us – LinearJobs')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* ── PAGE ─────────────────────────────────────────── */
        .lj-contact-page {
            background: var(--n50);
            min-height: calc(100vh - 64px);
            padding: 60px 20px 80px;
        }

        .lj-contact-wrap {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* ── HERO ─────────────────────────────────────────── */
        .lj-contact-hero {
            text-align: center;
            margin-bottom: 52px;
        }

        .lj-contact-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(26, 86, 219, .08), rgba(30, 58, 138, .12));
            border: 1.5px solid rgba(26, 86, 219, .18);
            border-radius: 100px;
            padding: 6px 16px;
            font-size: .78rem;
            font-weight: 700;
            color: var(--blue);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .lj-contact-badge i {
            font-size: .75rem;
        }

        .lj-contact-title {
            font-size: 2.1rem;
            font-weight: 900;
            color: var(--n900);
            letter-spacing: -.6px;
            margin-bottom: 12px;
        }

        .lj-contact-sub {
            font-size: .92rem;
            color: var(--n500);
            line-height: 1.7;
            max-width: 480px;
            margin: 0 auto;
        }

        /* ── INFO CARDS ───────────────────────────────────── */
        .lj-info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 48px;
        }

        .lj-info-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: 16px;
            padding: 28px 24px;
            text-align: center;
            transition: transform .2s, box-shadow .2s;
            position: relative;
            overflow: hidden;
        }

        .lj-info-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1a56db, #7c3aed);
            opacity: 0;
            transition: opacity .25s;
        }

        .lj-info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 32px rgba(0, 0, 0, .08);
        }

        .lj-info-card:hover::before {
            opacity: 1;
        }

        .lj-info-card-ico {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin: 0 auto 14px;
        }

        .lj-info-card-ico.blue {
            background: linear-gradient(135deg, rgba(26, 86, 219, .1), rgba(26, 86, 219, .06));
            color: var(--blue);
        }

        .lj-info-card-ico.green {
            background: linear-gradient(135deg, rgba(22, 163, 74, .1), rgba(22, 163, 74, .06));
            color: #16a34a;
        }

        .lj-info-card-ico.purple {
            background: linear-gradient(135deg, rgba(124, 58, 237, .1), rgba(124, 58, 237, .06));
            color: #7c3aed;
        }

        .lj-info-card-label {
            font-size: .72rem;
            font-weight: 800;
            color: var(--n400);
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .lj-info-card-value {
            font-size: .95rem;
            font-weight: 700;
            color: var(--n800);
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .lj-info-card-sub {
            font-size: .78rem;
            color: var(--n400);
        }

        .lj-info-card a {
            color: var(--blue);
            text-decoration: none;
        }

        .lj-info-card a:hover {
            text-decoration: underline;
        }

        /* ── MAIN LAYOUT ──────────────────────────────────── */
        .lj-contact-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 28px;
            align-items: start;
        }

        /* ── LEFT SIDEBAR ─────────────────────────────────── */
        .lj-contact-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .lj-sidebar-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: 16px;
            padding: 24px;
        }

        .lj-sidebar-card-title {
            font-size: .82rem;
            font-weight: 800;
            color: var(--n700);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lj-sidebar-card-title i {
            color: var(--blue);
        }

        .lj-contact-detail {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 10px 0;
            border-bottom: 1px solid var(--n50);
        }

        .lj-contact-detail:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .lj-contact-detail-ico {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--n50);
            border: 1.5px solid var(--n100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .82rem;
            color: var(--blue);
            flex-shrink: 0;
        }

        .lj-contact-detail-text {
            flex: 1;
        }

        .lj-contact-detail-label {
            font-size: .72rem;
            font-weight: 700;
            color: var(--n400);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 2px;
        }

        .lj-contact-detail-val {
            font-size: .875rem;
            font-weight: 600;
            color: var(--n800);
        }

        .lj-contact-detail-val a {
            color: var(--blue);
            text-decoration: none;
        }

        .lj-contact-detail-val a:hover {
            text-decoration: underline;
        }

        /* Hours */
        .lj-hours-row {
            display: flex;
            justify-content: space-between;
            font-size: .83rem;
            padding: 7px 0;
            border-bottom: 1px solid var(--n50);
            color: var(--n700);
        }

        .lj-hours-row:last-child {
            border-bottom: none;
        }

        .lj-hours-row span:first-child {
            color: var(--n500);
        }

        .lj-hours-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            font-weight: 700;
            color: #16a34a;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 100px;
            padding: 2px 9px;
            margin-top: 8px;
        }

        .lj-hours-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #16a34a;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .4;
            }
        }

        /* ── FORM CARD ────────────────────────────────────── */
        .lj-contact-form-card {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: 16px;
            overflow: hidden;
        }

        .lj-contact-form-head {
            background: linear-gradient(90deg, #1a56db 0%, #1e3a8a 100%);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lj-contact-form-head i {
            color: rgba(255, 255, 255, .9);
            font-size: 1rem;
        }

        .lj-contact-form-head-title {
            font-size: .9375rem;
            font-weight: 700;
            color: #fff;
        }

        .lj-contact-form-head-sub {
            font-size: .78rem;
            color: rgba(255, 255, 255, .7);
            margin-top: 2px;
        }

        .lj-contact-form-body {
            padding: 28px;
        }

        /* Form elements */
        .lj-fgroup {
            margin-bottom: 18px;
        }

        .lj-frow {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .lj-label {
            display: block;
            font-size: .8125rem;
            font-weight: 600;
            color: var(--n700);
            margin-bottom: 6px;
        }

        .lj-label .req {
            color: #e53e3e;
            margin-left: 2px;
        }

        .lj-iw {
            position: relative;
        }

        .lj-iw-ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--n400);
            font-size: .82rem;
            pointer-events: none;
            z-index: 1;
        }

        .lj-iw-ico.ta {
            top: 14px;
            transform: none;
        }

        .lj-input {
            width: 100%;
            border: 1.5px solid var(--n200);
            border-radius: var(--r);
            padding: 10px 14px 10px 38px;
            font-family: var(--f);
            font-size: .875rem;
            color: var(--n900);
            background: #fff;
            outline: none;
            transition: border-color var(--t), box-shadow var(--t);
        }

        .lj-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .lj-input::placeholder {
            color: var(--n400);
        }

        .lj-input.field-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .1);
        }

        textarea.lj-input {
            padding-top: 12px;
            resize: vertical;
            min-height: 130px;
        }

        /* Category selector */
        .lj-category-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .lj-category-opt input[type="radio"] {
            display: none;
        }

        .lj-category-opt label {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid var(--n200);
            border-radius: 10px;
            padding: 10px 13px;
            font-size: .82rem;
            font-weight: 600;
            color: var(--n600);
            cursor: pointer;
            transition: all .2s;
        }

        .lj-category-opt label:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(26, 86, 219, .03);
        }

        .lj-category-opt input:checked+label {
            background: rgba(26, 86, 219, .06);
            border-color: var(--blue);
            color: var(--blue);
        }

        .lj-category-opt label i {
            width: 18px;
            text-align: center;
            font-size: .8rem;
        }

        /* Field error */
        .lj-field-err {
            font-size: .75rem;
            color: #dc2626;
            margin-top: 4px;
            display: none;
            align-items: center;
            gap: 4px;
        }

        .lj-field-err.show {
            display: flex;
        }

        .lj-field-err i {
            font-size: .7rem;
        }

        /* Alert */
        .lj-step-alert {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: var(--r);
            padding: 11px 14px;
            margin-bottom: 16px;
            display: none;
            align-items: flex-start;
            gap: 9px;
            font-size: .83rem;
            color: #b91c1c;
        }

        .lj-step-alert.show {
            display: flex;
        }

        /* Success */
        .lj-success-box {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            border-radius: var(--r);
            padding: 18px 20px;
            display: none;
            align-items: flex-start;
            gap: 12px;
            font-size: .875rem;
            color: #166534;
        }

        .lj-success-box.show {
            display: flex;
        }

        .lj-success-box i {
            color: #16a34a;
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Char counter */
        .lj-char-counter {
            font-size: .72rem;
            color: var(--n400);
            text-align: right;
            margin-top: 3px;
        }

        /* Submit */
        .lj-contact-form-footer {
            padding: 0 28px 28px;
        }

        .lj-contact-submit {
            background: linear-gradient(135deg, #1a56db, #1e3a8a);
            color: #fff;
            border: none;
            border-radius: var(--r);
            font-family: var(--f);
            font-size: .9375rem;
            font-weight: 700;
            padding: 13px 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all .25s;
            width: 100%;
            justify-content: center;
        }

        .lj-contact-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26, 86, 219, .3);
        }

        .lj-contact-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none;
        }

        /* ── MAP PLACEHOLDER ──────────────────────────────── */
        .lj-map-section {
            margin-top: 48px;
        }

        .lj-map-head {
            text-align: center;
            margin-bottom: 24px;
        }

        .lj-map-head h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--n900);
            letter-spacing: -.4px;
            margin-bottom: 6px;
        }

        .lj-map-head p {
            font-size: .88rem;
            color: var(--n500);
        }

        .lj-map-box {
            background: #fff;
            border: 1.5px solid var(--n200);
            border-radius: 16px;
            overflow: hidden;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 14px;
        }

        .lj-map-box i {
            font-size: 2rem;
            color: var(--blue);
            opacity: .5;
        }

        .lj-map-box p {
            font-size: .875rem;
            color: var(--n400);
        }

        @media(max-width:720px) {
            .lj-info-cards {
                grid-template-columns: 1fr;
            }

            .lj-contact-layout {
                grid-template-columns: 1fr;
            }

            .lj-frow {
                grid-template-columns: 1fr;
            }

            .lj-contact-form-body,
            .lj-contact-form-footer {
                padding: 20px 16px;
            }

            .lj-contact-form-head {
                padding: 18px 16px;
            }

            .lj-contact-title {
                font-size: 1.6rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="lj-contact-page">
        <div class="lj-contact-wrap">

            {{-- Hero --}}
            <div class="lj-contact-hero">
                <div class="lj-contact-badge"><i class="fa-solid fa-headset"></i> We're Here to Help</div>
                <h1 class="lj-contact-title">Get in Touch with Us</h1>
                <p class="lj-contact-sub">Have a question, need support, or want to partner with us? We'd love to hear from
                    you.</p>
            </div>

            {{-- Info Cards --}}
            <div class="lj-info-cards">
                <div class="lj-info-card">
                    <div class="lj-info-card-ico blue"><i class="fa-solid fa-envelope"></i></div>
                    <div class="lj-info-card-label">Email Support</div>
                    <div class="lj-info-card-value"><a href="mailto:support@linearjobs.com">support@linearjobs.com</a></div>
                    <div class="lj-info-card-sub">We reply within 24 hours</div>
                </div>
                <div class="lj-info-card">
                    <div class="lj-info-card-ico green"><i class="fa-solid fa-phone"></i></div>
                    <div class="lj-info-card-label">Phone Support</div>
                    <div class="lj-info-card-value"><a href="tel:+919XXXXXXXXX">+91 XXXXX XXXXX</a></div>
                    <div class="lj-info-card-sub">Mon – Sat, 9 AM – 6 PM</div>
                </div>
                <div class="lj-info-card">
                    <div class="lj-info-card-ico purple"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="lj-info-card-label">Office Location</div>
                    <div class="lj-info-card-value">Tamil Nadu, India</div>
                    <div class="lj-info-card-sub">Serving across Tamil Nadu</div>
                </div>
            </div>

            {{-- Main Layout --}}
            <div class="lj-contact-layout">

                {{-- Sidebar --}}
                <div class="lj-contact-sidebar">

                    {{-- Contact Details --}}
                    <div class="lj-sidebar-card">
                        <div class="lj-sidebar-card-title"><i class="fa-solid fa-circle-info"></i> Contact Information</div>
                        <div class="lj-contact-detail">
                            <div class="lj-contact-detail-ico"><i class="fa-solid fa-envelope"></i></div>
                            <div class="lj-contact-detail-text">
                                <div class="lj-contact-detail-label">Email</div>
                                <div class="lj-contact-detail-val"><a
                                        href="mailto:support@linearjobs.com">support@linearjobs.com</a></div>
                            </div>
                        </div>
                        <div class="lj-contact-detail">
                            <div class="lj-contact-detail-ico"><i class="fa-solid fa-phone"></i></div>
                            <div class="lj-contact-detail-text">
                                <div class="lj-contact-detail-label">Phone</div>
                                <div class="lj-contact-detail-val"><a href="tel:+919XXXXXXXXX">+91 XXXXX XXXXX</a></div>
                            </div>
                        </div>
                        <div class="lj-contact-detail">
                            <div class="lj-contact-detail-ico"><i class="fa-solid fa-map-pin"></i></div>
                            <div class="lj-contact-detail-text">
                                <div class="lj-contact-detail-label">Office</div>
                                <div class="lj-contact-detail-val">Tamil Nadu, India</div>
                            </div>
                        </div>
                    </div>

                    {{-- Working Hours --}}
                    <div class="lj-sidebar-card">
                        <div class="lj-sidebar-card-title">
                            <i class="fa-solid fa-clock"></i> Working Hours
                        </div>

                        <div class="lj-hours-status open-247">
                            <i class="fa-solid fa-circle-check"></i> Open 24/7
                        </div>

                        <div style="margin-top:12px;">
                            <div class="lj-hours-row">
                                <span>All Days</span>
                                <strong>24 Hours</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="lj-sidebar-card">
                        <div class="lj-sidebar-card-title"><i class="fa-solid fa-link"></i> Quick Help</div>
                        <div style="display:flex;flex-direction:column;gap:8px;margin-top:4px;">
                            @php
                                $links = [
                                    [
                                        'icon' => 'fa-briefcase',
                                        'label' => 'Post a Job',
                                        'url' => route('employer.login'),
                                    ],
                                    [
                                        'icon' => 'fa-magnifying-glass',
                                        'label' => 'Find Jobs',
                                        'url' => route('jobs.index'),
                                    ],
                                    ['icon' => 'fa-tag', 'label' => 'View Pricing', 'url' => route('pricing')],
                                    ['icon' => 'fa-shield-halved', 'label' => 'Privacy Policy', 'url' => route('home')],
                                    [
                                        'icon' => 'fa-file-lines',
                                        'label' => 'Terms & Conditions',
                                        'url' => route('home'),
                                    ],
                                ];
                            @endphp
                            @foreach ($links as $link)
                                <a href="{{ $link['url'] }}"
                                    style="display:flex;align-items:center;gap:10px;font-size:.84rem;color:var(--n700);text-decoration:none;padding:8px 12px;border-radius:8px;transition:background .2s,color .2s;"
                                    onmouseover="this.style.background='var(--n50)';this.style.color='var(--blue)'"
                                    onmouseout="this.style.background='transparent';this.style.color='var(--n700)'">
                                    <i class="fa-solid {{ $link['icon'] }}"
                                        style="width:16px;color:var(--blue);font-size:.8rem;"></i>
                                    {{ $link['label'] }}
                                    <i class="fa-solid fa-chevron-right"
                                        style="margin-left:auto;font-size:.65rem;color:var(--n300);"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Contact Form --}}
                <div class="lj-contact-form-card">
                    <div class="lj-contact-form-head">
                        <i class="fa-solid fa-paper-plane"></i>
                        <div>
                            <div class="lj-contact-form-head-title">Send Us a Message</div>
                            <div class="lj-contact-form-head-sub">We'll get back to you within 24 hours</div>
                        </div>
                    </div>
                    <div class="lj-contact-form-body">

                        {{-- Success message --}}
                        @if (session('success'))
                            <div class="lj-success-box show">
                                <i class="fa-solid fa-circle-check"></i>
                                <div>
                                    <strong>Message sent successfully!</strong><br>
                                    <span style="font-size:.82rem;">Thank you for reaching out. We'll get back to you within
                                        24 hours.</span>
                                </div>
                            </div>
                        @endif

                        {{-- Error alert --}}
                        <div class="lj-step-alert" id="formAlert">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Please fill in all required fields correctly.</span>
                        </div>

                        <form method="POST" action="{{ route('contact.submit') }}" id="contactForm" novalidate>
                            @csrf

                            {{-- Query Type --}}
                            <div class="lj-fgroup">
                                <label class="lj-label">Query Type <span class="req">*</span></label>
                                <div class="lj-category-grid">
                                    @php
                                        $queryTypes = [
                                            [
                                                'value' => 'job_seeker',
                                                'icon' => 'fa-user',
                                                'label' => 'Job Seeker Help',
                                            ],
                                            [
                                                'value' => 'employer',
                                                'icon' => 'fa-building',
                                                'label' => 'Employer Support',
                                            ],
                                            [
                                                'value' => 'billing',
                                                'icon' => 'fa-credit-card',
                                                'label' => 'Billing / Plans',
                                            ],
                                            [
                                                'value' => 'other',
                                                'icon' => 'fa-comment-dots',
                                                'label' => 'Other Enquiry',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($queryTypes as $qt)
                                        <div class="lj-category-opt">
                                            <input type="radio" id="qt_{{ $qt['value'] }}" name="query_type"
                                                value="{{ $qt['value'] }}"
                                                {{ old('query_type', 'job_seeker') == $qt['value'] ? 'checked' : '' }}>
                                            <label for="qt_{{ $qt['value'] }}">
                                                <i class="fa-solid {{ $qt['icon'] }}"></i> {{ $qt['label'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="lj-field-err @error('query_type') show @enderror" id="err-query_type">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('query_type')
                                            {{ $message }}
                                        @else
                                            Please select a query type.
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            {{-- Name & Email --}}
                            <div class="lj-frow">
                                <div class="lj-fgroup">
                                    <label class="lj-label" for="name">Your Name <span
                                            class="req">*</span></label>
                                    <div class="lj-iw">
                                        <i class="fa-solid fa-user lj-iw-ico"></i>
                                        <input type="text" id="name" name="name"
                                            class="lj-input @error('name') field-error @enderror" placeholder="Full name"
                                            value="{{ old('name') }}" />
                                    </div>
                                    <div class="lj-field-err @error('name') show @enderror" id="err-name">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('name')
                                                {{ $message }}
                                            @else
                                                Please enter your name.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="lj-fgroup">
                                    <label class="lj-label" for="email">Email Address <span
                                            class="req">*</span></label>
                                    <div class="lj-iw">
                                        <i class="fa-solid fa-envelope lj-iw-ico"></i>
                                        <input type="email" id="email" name="email"
                                            class="lj-input @error('email') field-error @enderror"
                                            placeholder="you@example.com" value="{{ old('email') }}" />
                                    </div>
                                    <div class="lj-field-err @error('email') show @enderror" id="err-email">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>
                                            @error('email')
                                                {{ $message }}
                                            @else
                                                Enter a valid email address.
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="lj-fgroup">
                                <label class="lj-label" for="subject">Subject <span class="req">*</span></label>
                                <div class="lj-iw">
                                    <i class="fa-solid fa-pen lj-iw-ico"></i>
                                    <input type="text" id="subject" name="subject"
                                        class="lj-input @error('subject') field-error @enderror"
                                        placeholder="Brief description of your query" value="{{ old('subject') }}" />
                                </div>
                                <div class="lj-field-err @error('subject') show @enderror" id="err-subject">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('subject')
                                            {{ $message }}
                                        @else
                                            Please enter a subject.
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="lj-fgroup">
                                <label class="lj-label" for="message">Message <span class="req">*</span></label>
                                <div class="lj-iw">
                                    <i class="fa-solid fa-comment lj-iw-ico ta"></i>
                                    <textarea id="message" name="message" class="lj-input @error('message') field-error @enderror"
                                        placeholder="Describe your query in detail..." maxlength="1000" oninput="updateCounter(this)">{{ old('message') }}</textarea>
                                </div>
                                <div class="lj-char-counter"><span id="charCount">0</span> / 1000 characters</div>
                                <div class="lj-field-err @error('message') show @enderror" id="err-message">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>
                                        @error('message')
                                            {{ $message }}
                                        @else
                                            Please enter your message (minimum 20 characters).
                                        @enderror
                                    </span>
                                </div>
                            </div>

                    </div>
                    <div class="lj-contact-form-footer">
                        <button type="submit" class="lj-contact-submit" id="submitBtn">
                            <i class="fa-solid fa-paper-plane"></i> Send Message
                        </button>
                    </div>
                    </form>
                </div>

            </div>

            {{-- Map Section --}}
   

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateCounter(el) {
            document.getElementById('charCount').textContent = el.value.length;
        }

        // Initialize char counter
        document.addEventListener('DOMContentLoaded', function() {
            const msg = document.getElementById('message');
            if (msg) document.getElementById('charCount').textContent = msg.value.length;

            // Live clear errors
            document.querySelectorAll('.lj-input').forEach(function(inp) {
                ['input', 'change'].forEach(ev => inp.addEventListener(ev, function() {
                    this.classList.remove('field-error');
                    const errEl = document.getElementById('err-' + this.id);
                    if (errEl) errEl.classList.remove('show');
                }));
            });
        });

        // Client-side validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            let valid = true;
            const alertEl = document.getElementById('formAlert');
            document.querySelectorAll('.lj-field-err').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('.lj-input').forEach(el => el.classList.remove('field-error'));
            alertEl.classList.remove('show');

            const name = document.getElementById('name');
            if (!name.value.trim() || name.value.trim().length < 2) {
                name.classList.add('field-error');
                document.getElementById('err-name').classList.add('show');
                valid = false;
            }

            const email = document.getElementById('email');
            if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.classList.add('field-error');
                document.getElementById('err-email').classList.add('show');
                valid = false;
            }

            const subject = document.getElementById('subject');
            if (!subject.value.trim() || subject.value.trim().length < 3) {
                subject.classList.add('field-error');
                document.getElementById('err-subject').classList.add('show');
                valid = false;
            }

            const message = document.getElementById('message');
            if (!message.value.trim() || message.value.trim().length < 20) {
                message.classList.add('field-error');
                document.getElementById('err-message').classList.add('show');
                document.getElementById('err-message').querySelector('span').textContent =
                    'Message must be at least 20 characters.';
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                alertEl.classList.add('show');
                window.scrollTo({
                    top: alertEl.getBoundingClientRect().top + window.scrollY - 100,
                    behavior: 'smooth'
                });
                return;
            }

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending Message...';
        });
    </script>
@endpush
