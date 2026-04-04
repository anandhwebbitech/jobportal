{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/partials/sidebar.blade.php
     LinearJobs Employer Dashboard – Sidebar
══════════════════════════════════════════════════════════ --}}

@php
  $unread =  3;

  $empName  = auth()->check() ? auth()->user()->name : 'Karthik Selvan';
  $compName = auth()->check() ? (auth()->user()->employer->company_name ?? 'TechBridge Solutions') : 'TechBridge Solutions';

  $initials = collect(explode(' ', $empName))
                ->map(fn($w)=>strtoupper($w[0] ?? ''))
                ->take(2)
                ->implode('');

  $planName ='30 Day Plan';

  $planExpiry ='10 Apr 2025';

  $verified = true;

  $nav = [
      [
          'route' => 'employer.dashboard',
          'icon'  => 'fa-gauge-high',
          'label' => 'Dashboard'
      ],
      [
          'route' => 'employer.profile',
          'icon'  => 'fa-building',
          'label' => 'Company Profile'
      ],
      [
          'route' => 'employer.billing',
          'icon'  => 'fa-credit-card',
          'label' => 'Billing / Plans'
      ],
      [
          'route' => 'employer.jobs.create',
          'icon'  => 'fa-plus-circle',
          'label' => 'Post a Job'
      ],
      [
          'route' => 'employer.jobs.index',
          'icon'  => 'fa-briefcase',
          'label' => 'Manage Jobs'
      ],
      [
          'route' => 'employer.candidates',
          'icon'  => 'fa-users',
          'label' => 'Candidates'
      ],
      [
          'route' => 'employer.resume',
          'icon'  => 'fa-database',
          'label' => 'Resume Database'
      ],
      [
          'route' => 'employer.ads',
          'icon'  => 'fa-rectangle-ad',
          'label' => 'Advertisements'
      ],
      [
          'route' => 'employer.notifications',
          'icon'  => 'fa-bell',
          'label' => 'Notifications',
          'badge' => $unread
      ],
  ];
@endphp


<aside class="emp-sidebar" id="empSidebar">

  {{-- Brand --}}
  <div class="sb-brand">
    <a href="{{ route('employer.dashboard') }}" class="sb-logo">
        Linear<em>Jobs</em>
    </a>

    <button class="sb-close" id="sbClose">
        <i class="fas fa-times"></i>
    </button>
  </div>


  {{-- Employer Card --}}
  <div class="sb-emp">

      <div class="sb-emp-top">
          <div class="sb-avatar">{{ $initials }}</div>

          <div>
              <div class="sb-emp-name">{{ $empName }}</div>
              <div class="sb-emp-co">{{ $compName }}</div>
          </div>
      </div>

      @if($verified)
          <span class="sb-verified">
              <i class="fas fa-circle-check"></i> Verified
          </span>
      @endif

      <div class="sb-plan-bar" style="margin-top:10px;">
          <div style="display:flex;align-items:center;gap:6px;">
              <div class="sb-plan-dot"></div>
              <strong>{{ $planName }}</strong>
          </div>

          <span style="font-size:.65rem;opacity:.7;">
              Exp: {{ $planExpiry }}
          </span>
      </div>

  </div>


  {{-- Navigation --}}
  <nav class="sb-nav">

      <div class="sb-section-lbl">Main Menu</div>

      @foreach($nav as $item)

          @php
              $isActive = request()->routeIs($item['route'].'*');

              try {
                  $href = route($item['route']);
              } catch (\Exception $e) {
                  $href = '#';
              }
          @endphp

          <a href="{{ $href }}" class="sb-link {{ $isActive ? 'active' : '' }}">

              <i class="fas {{ $item['icon'] }}"></i>

              <span>{{ $item['label'] }}</span>

              @if(!empty($item['badge']) && $item['badge'] > 0)
                  <span class="sb-badge">{{ $item['badge'] }}</span>
              @endif

          </a>

      @endforeach


      <div class="sb-section-lbl" style="margin-top:8px;">Account</div>

      <a href="{{ route('employer.settings') }}"
         class="sb-link {{ request()->routeIs('employer.settings') ? 'active' : '' }}">

          <i class="fas fa-gear"></i>
          <span>Settings</span>

      </a>

  </nav>


  {{-- Footer / Logout --}}
  <div class="sb-footer">

      <form method="POST" action="{{ route('logout') }}">
          @csrf

          <button type="submit"
                  class="sb-link sb-logout"
                  style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">

              <i class="fas fa-right-from-bracket"></i>
              <span>Logout</span>

          </button>

      </form>

  </div>

</aside>
