{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/notifications.blade.php
     Notifications – LinearJobs Job Seeker Dashboard
═══════════════════════════════════════════════════════ --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Notifications')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Notifications</div>
    <div class="lj-page-subtitle">Stay updated with your job activity and alerts.</div>
  </div>
  <div style="display:flex;gap:10px;">
    @if(($notifications ?? collect())->where('read_at', null)->count() > 0)
      <form method="POST" action="{{ route('jobseeker.dashboard.notifications.readAll') }}">
        @csrf @method('PUT')
        <button type="submit" class="lj-btn lj-btn-outline lj-btn-sm">
          <i class="fa-solid fa-check-double"></i> Mark all read
        </button>
      </form>
    @endif
    <form method="POST" action="{{ route('jobseeker.dashboard.notifications.clearAll') }}"
      onsubmit="return confirm('Clear all notifications?')">
      @csrf @method('DELETE')
      <button type="submit" class="lj-btn lj-btn-ghost lj-btn-sm">
        <i class="fa-solid fa-trash"></i> Clear all
      </button>
    </form>
  </div>
</div>

{{-- Filter chips --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
  <span class="chip {{ !request('filter') ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.dashboard.notifications') }}'">All</span>
  <span class="chip {{ request('filter')=='unread' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.dashboard.notifications') }}?filter=unread'">Unread</span>
  <span class="chip {{ request('filter')=='interview' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.dashboard.notifications') }}?filter=interview'">Interviews</span>
  <span class="chip {{ request('filter')=='application' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.dashboard.notifications') }}?filter=application'">Applications</span>
</div>

<div class="lj-card">
  <div style="padding:0 22px;">
    @forelse($notifications ?? [] as $notif)
      @php
        $iconMap = [
          'interview'   => ['orange','fa-calendar-check'],
          'shortlisted' => ['green','fa-circle-check'],
          'rejected'    => ['red','fa-circle-xmark'],
          'hired'       => ['green','fa-trophy'],
          'alert'       => ['blue','fa-wand-magic-sparkles'],
          'message'     => ['purple','fa-envelope'],
          'profile'     => ['blue','fa-user-check'],
          'resume'      => ['green','fa-file-check'],
          'system'      => ['blue','fa-bell'],
        ];
        $type = $notif->type ?? 'system';
        [$color, $icon] = $iconMap[$type] ?? ['blue','fa-bell'];
        $isUnread = !$notif->read_at;
      @endphp
      <div class="lj-notif-item" style="{{ $isUnread ? 'background:rgba(26,86,219,.02);' : '' }}">
        <div class="lj-notif-ico {{ $color }}">
          <i class="fa-solid {{ $icon }}"></i>
        </div>
        <div style="flex:1;">
          <div class="lj-notif-text">{!! $notif->message !!}</div>
          <div class="lj-notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
          @if($isUnread)
            <div class="lj-notif-unread-dot"></div>
            <form method="POST" action="{{ route('jobseeker.dashboard.notifications.read', $notif->id) }}">
              @csrf @method('PUT')
              <button type="submit" class="lj-btn lj-btn-ghost lj-btn-sm" title="Mark as read" style="font-size:.7rem;padding:4px 8px;">
                <i class="fa-solid fa-check"></i>
              </button>
            </form>
          @endif
        </div>
      </div>
    @empty
      {{-- Fallback sample notifications --}}
      @php
        $samples = [
          ['orange','fa-calendar-check','<strong>Interview Scheduled!</strong> TechSoft Solutions has invited you for an interview for the <strong>PHP Developer</strong> position. Check your email for details.','2 hours ago',true],
          ['green','fa-circle-check','Your application for <strong>Web Developer</strong> at Digital Hive has been <strong style="color:var(--orange);">shortlisted</strong>.','1 day ago',true],
          ['blue','fa-wand-magic-sparkles','We found <strong>12 new jobs</strong> matching your Job Alert for "PHP Laravel Developer" in Coimbatore.','2 days ago',true],
          ['purple','fa-envelope','<strong>New message</strong> from Nexus Digital regarding your application for <strong>React.js Developer</strong>.','3 days ago',true],
          ['blue','fa-user-check','Your profile was viewed by <strong>5 employers</strong> this week. Complete your profile to get more visibility.','5 days ago',false],
          ['green','fa-file-check','Your resume <strong>Resume.pdf</strong> was uploaded successfully.','6 days ago',false],
          ['red','fa-circle-xmark','Your application for <strong>Software Engineer</strong> at Radiant IT was not shortlisted this time.','1 week ago',false],
        ];
      @endphp
      @foreach($samples as $s)
        <div class="lj-notif-item" style="{{ $s[4] ? 'background:rgba(26,86,219,.02);' : '' }}">
          <div class="lj-notif-ico {{ $s[0] }}"><i class="fa-solid {{ $s[1] }}"></i></div>
          <div style="flex:1;">
            <div class="lj-notif-text">{!! $s[2] !!}</div>
            <div class="lj-notif-time">{{ $s[3] }}</div>
          </div>
          @if($s[4])
            <div class="lj-notif-unread-dot"></div>
          @endif
        </div>
      @endforeach
    @endforelse
  </div>

  {{-- Pagination --}}
  @if(isset($notifications) && method_exists($notifications, 'hasPages') && $notifications->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--n100);display:flex;justify-content:center;gap:6px;">
      @if(!$notifications->onFirstPage())
        <a href="{{ $notifications->previousPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
          <i class="fa-solid fa-chevron-left"></i> Prev
        </a>
      @endif
      <span style="align-self:center;font-size:.82rem;color:var(--n500);">
        Page {{ $notifications->currentPage() }} of {{ $notifications->lastPage() }}
      </span>
      @if($notifications->hasMorePages())
        <a href="{{ $notifications->nextPageUrl() }}" class="lj-btn lj-btn-outline lj-btn-sm">
          Next <i class="fa-solid fa-chevron-right"></i>
        </a>
      @endif
    </div>
  @endif
</div>

@endsection