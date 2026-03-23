<!-- ── Sidebar ── -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-logo mb-4">
        <img src="{{ asset('frontend/logo3.png')}}" alt="Logo" class="logo-img">
    </div>

      <nav>

        <!-- Dashboard -->
        <a href="{{ route('admin.admindashboard')}}"
           class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        <!-- Employer -->
        <a onclick="toggleSubmenu(this)"
           class="has-submenu {{ request()->is(['admin/employers*','admin/jobs*']) ? 'open' : '' }}">
            <i class="fa fa-building"></i> Employer
            <i class="fa fa-chevron-down submenu-arrow ms-auto"></i>
        </a>

        <div class="submenu {{ request()->is(['admin/employers*','admin/jobs*']) ? 'open' : '' }}"
             id="employer-submenu">

            <a href="{{ route('admin.employers.index')}}"
               class="{{ request()->is('admin/employers*') ? 'active' : '' }}">
                <i class="fa fa-list"></i> Employer List
            </a>

            <a href="#"
               class="{{ request()->is('admin/jobs*') ? 'active' : '' }}">
                <i class="fa fa-briefcase"></i> Job List
            </a>

        </div>


        <!-- Job Seeker -->
        <a onclick="toggleSubmenu(this)"
           class="has-submenu {{ request()->is('admin/jobseekers*') ? 'open' : '' }}">
            <i class="fa fa-user"></i> Job Seeker
            <i class="fa fa-chevron-down submenu-arrow ms-auto"></i>
        </a>

        <div class="submenu {{ request()->is('admin/jobseekers*') ? 'open' : '' }}"
             id="jobseeker-submenu">

            <a href="#"
               class="{{ request()->is('admin/jobseekers*') ? 'active' : '' }}">
                <i class="fa fa-list"></i> Seeker List
            </a>

        </div>


        <!-- Masters -->
        <a onclick="toggleSubmenu(this)"
           class="has-submenu {{ request()->is(['admin/skills*','admin/education*','admin/location*']) ? 'open' : '' }}">
            <i class="fa-solid fa-screwdriver-wrench"></i> Masters
            <i class="fa fa-chevron-down submenu-arrow ms-auto"></i>
        </a>

        <div class="submenu {{ request()->is(['admin/skills*','admin/education*','admin/location*']) ? 'open' : '' }}"
             id="masters-submenu">

            <a href="{{ route('admin.skills.index')}}"
               class="{{ request()->is('admin/skills*') ? 'active' : '' }}">
                <i class="fa fa-lightbulb"></i> Skill
            </a>

            <a href="{{ route('admin.educations.index')}}"
               class="{{ request()->is('admin/educations*') ? 'active' : '' }}">
                <i class="fa fa-graduation-cap"></i> Education
            </a>

            <a href="#"
               class="{{ request()->is('admin/location*') ? 'active' : '' }}">
                <i class="fa fa-location-dot"></i> Location
            </a>

        </div>


        <!-- Settings -->
        <a href="{{ route('admin.settings.index','general')}}" class="{{ request()->is('admin/settings/*') ? 'active' : '' }}">
            <i class="fa fa-gear"></i> Settings
        </a>

    </nav>

</aside>