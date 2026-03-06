<!-- ── Header ── -->
<header class="header" id="header">
    <div class="d-flex align-items-center gap-3">
        <button class="toggle-btn" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="fa fa-bars"></i>
        </button>
        <div>
            <h6 class="fw-semibold mb-0" style="color:#064e3b;">Welcome back</h6>
            {{-- <small class="text-muted">Your business at a glance</small> --}}
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">

        <!-- Notification -->
        <button class="icon-btn position-relative" aria-label="Notifications">
            <i class="fa fa-bell"></i>
            <span class="notify-dot"></span>
        </button>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <button 
                class="profile-btn dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                
                <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff' }}" alt="Admin avatar">
                <span>Admin</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index','profile')}}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index','general') }}">
                        <i class="fa fa-gear me-2"></i> Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-right-from-bracket me-2"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>