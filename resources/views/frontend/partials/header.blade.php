{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/partials/header.blade.php
═══════════════════════════════════════════════════ --}}

<header class="lj-nav" id="ljNav">
    <div class="lj-wrap lj-nav-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="lj-brand">Linear<em>Jobs</em></a>

        {{-- Desktop Nav --}}
        <ul class="lj-nav-links">
            <li class="{{ request()->routeIs('home') ? 'lj-cur' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="{{ request()->routeIs('jobs.*') ? 'lj-cur' : '' }}">
                <a href="{{ route('jobs.index') }}">Find Jobs</a>
            </li>
            <li class="{{ request()->routeIs('employer.register') ? 'lj-cur' : '' }}">
                <a href="{{ route('employer.register') }}">Post a Job</a>
            </li>
            <li class="{{ request()->routeIs('pricing') ? 'lj-cur' : '' }}">
                <a href="{{ route('pricing') }}">Pricing</a>
            </li>
            <li class="{{ request()->routeIs('contact') ? 'lj-cur' : '' }}">
                <a href="{{ route('contact') }}">Contact</a>
            </li>
            @auth

                <li class="{{ request()->routeIs('jobseeker.dashboard') ? 'lj-cur' : '' }}">
                    <a href="{{ route('jobseeker.dashboard') }}">Dashboard</a>
                </li>
            @endauth
        </ul>

        {{-- Desktop Actions --}}
        <div class="lj-nav-right">
            @guest
                <a href="{{ route('jobseeker.login') }}" class="lj-btn lj-btn-ghost">Login</a>
                <a href="{{ route('jobseeker.register') }}" class="lj-btn lj-btn-blue">Register</a>
                <a href="{{ route('employer.register') }}" class="lj-btn lj-btn-green">Post a Job</a>
            @else
                <span class="lj-nav-user">
                    <i class="fas fa-circle-user"></i> {{ Auth::user()->name }}
                </span>
                {{-- <a href="{{ route('dashboard') }}" class="lj-btn lj-btn-blue">Dashboard</a> --}}
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="lj-btn lj-btn-ghost">Logout</button>
                </form>
            @endguest
        </div>

        {{-- Hamburger --}}
        <button class="lj-ham" id="ljHam" aria-label="Toggle menu" aria-expanded="false">
            <i class="fas fa-bars" id="ljHamIco"></i>
        </button>

    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</header>

{{-- ══════════════════════════
     MOBILE DRAWER
══════════════════════════ --}}
<nav class="lj-drawer" id="ljDrawer" aria-label="Mobile navigation">
    <a href="{{ route('home') }}"
        class="lj-drawer-link {{ request()->routeIs('home') ? 'lj-drawer-cur' : '' }}">Home</a>
    <a href="{{ route('jobs.index') }}"
        class="lj-drawer-link {{ request()->routeIs('jobs.*') ? 'lj-drawer-cur' : '' }}">Find Jobs</a>
    <a href="{{ route('post-job') }}"
        class="lj-drawer-link {{ request()->routeIs('post-job') ? 'lj-drawer-cur' : '' }}">Post a Job</a>
    <a href="{{ route('pricing') }}"
        class="lj-drawer-link {{ request()->routeIs('pricing') ? 'lj-drawer-cur' : '' }}">Pricing</a>
    <a href="{{ route('contact') }}"
        class="lj-drawer-link {{ request()->routeIs('contact') ? 'lj-drawer-cur' : '' }}">Contact</a>
    <a href="{{ route('jobseeker.dashboard') }}"  class="lj-drawer-link {{ request()->routeIs('jobseeker.dashboard') ? 'lj-drawer-cur' : '' }}">Dashboard</a>

    <div class="lj-drawer-divider"></div>

    @guest
        <div class="lj-drawer-btns">
            <a href="{{ route('jobseeker.login') }}" class="lj-btn lj-btn-ghost lj-btn-w">Login</a>
            <a href="{{ route('jobseeker.register') }}" class="lj-btn lj-btn-blue  lj-btn-w">Register as Job Seeker</a>
            <a href="{{ route('employer.register') }}" class="lj-btn lj-btn-green lj-btn-w">Register Company</a>
            <a href="{{ route('post-job') }}" class="lj-btn lj-btn-green lj-btn-w" style="background:var(--green-h);">Post
                a Job</a>
        </div>
    @else
        <div class="lj-drawer-btns">
            <a href="{{ route('home') }}" class="lj-btn lj-btn-blue lj-btn-w">My Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="lj-btn lj-btn-ghost lj-btn-w">Logout</button>
            </form>
        </div>
    @endguest
</nav>
