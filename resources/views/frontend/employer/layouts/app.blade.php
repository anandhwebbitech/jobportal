{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/layouts/app.blade.php
     LinearJobs – Employer Dashboard Master Layout
══════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Employer Dashboard') – LinearJobs</title>

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&display=swap"
        rel="stylesheet" />
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    {{-- Shared Employer CSS --}}
    <link href="{{ asset('frontend/css/lj-employer.css') }}" rel="stylesheet" />
    {{-- Page CSS --}}
    @stack('styles')
</head>

<body>

    <div class="emp-layout">

        {{-- SIDEBAR --}}
        @include('frontend.employer.partials.sidebar')
        <div class="sb-overlay" id="sbOverlay"></div>

        {{-- MAIN --}}
        <div class="emp-main" id="empMain">

            {{-- TOPBAR --}}
            <header class="emp-topbar">
                <button class="topbar-ham" id="sbToggle" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-breadcrumb">
                    <a href="{{ route('employer.dashboard') }}">Dashboard</a>
                    @hasSection('breadcrumb')
                        <i class="fas fa-chevron-right"></i>
                        @yield('breadcrumb')
                    @endif
                </div>
                <div class="topbar-right">
                    @php
                        $planName = auth()->check()
                            ? auth()->user()->employer->activePlan->name ?? '30 Day Plan'
                            : '30 Day Plan';
                        $unread = 3;
                    @endphp
                    <span class="topbar-plan-chip"><i class="fas fa-bolt"></i> {{ $planName }}</span>
                    <a href="{{ route('employer.notifications') }}" class="topbar-bell">
                        <i class="fas fa-bell"></i>
                        @if ($unread > 0)
                            <span class="topbar-bell-dot"></span>
                        @endif
                    </a>
                    <div class="topbar-avatar">KS</div>
                </div>
            </header>

            {{-- CONTENT --}}
            <div class="emp-content">
                @yield('content')
            </div>

        </div>
    </div>

    {{-- Sidebar Toggle JS --}}
    <script>
        (function() {
            var toggle = document.getElementById('sbToggle');
            var sidebar = document.getElementById('empSidebar');
            var overlay = document.getElementById('sbOverlay');
            var close = document.getElementById('sbClose');

            function open() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function shut() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
            if (toggle) toggle.addEventListener('click', open);
            if (overlay) overlay.addEventListener('click', shut);
            if (close) close.addEventListener('click', shut);
        })();
    </script>

    @stack('scripts')
</body>

</html>
