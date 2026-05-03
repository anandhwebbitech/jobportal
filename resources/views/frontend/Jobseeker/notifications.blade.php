{{-- notifications.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Notifications')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Notifications</div>
    <div class="lj-page-subtitle">Stay updated with your job activity and alerts.</div>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    @if(($notifications ?? collect())->where('read_at', null)->count() > 0)
      <form method="POST" action="{{ route('jobseeker.dashboard.notifications.readAll') }}">
        @csrf @method('PUT')
        <button type="submit" class="lj-btn lj-btn-outline lj-btn-sm">
          <i class="fa-solid fa-check-double"></i> Mark all read
        </button>
      </form>
    @endif
    <form method="POST" action="{{ route('notifications.clearAll') }}"
      onsubmit="return confirm('Clear all notifications?')">
      @csrf @method('DELETE')
      <button type="submit" class="lj-btn lj-btn-ghost lj-btn-sm">
        <i class="fa-solid fa-trash"></i> Clear all
      </button>
    </form>
  </div>
</div>

{{-- Filter chips --}}
<div style="display:flex;gap:7px;margin-bottom:18px;flex-wrap:wrap;">
  <span class="chip {{ !request('filter') ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.notifications.index') }}'">All</span>
  <span class="chip {{ request('filter')=='unread' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.notifications.index') }}?filter=unread'">Unread</span>
  <span class="chip {{ request('filter')=='interview' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.notifications.index') }}?filter=interview'">Interviews</span>
  <span class="chip {{ request('filter')=='application' ? 'active' : '' }}"
    onclick="window.location='{{ route('jobseeker.notifications.index') }}?filter=application'">Applications</span>
</div>

<div class="lj-card" id="notificationList">
   
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  // alert(8);
  $(document).ready(function () {
    loadNotifications(); // ✅ call on load
});
function timeAgo(datetime) {
    let now = new Date();
    let past = new Date(datetime);
    let diff = Math.floor((now - past) / 1000); // seconds

    let units = [
        { name: "year", seconds: 31536000 },
        { name: "month", seconds: 2592000 },
        { name: "day", seconds: 86400 },
        { name: "hour", seconds: 3600 },
        { name: "minute", seconds: 60 },
        { name: "second", seconds: 1 }
    ];

    for (let u of units) {
        let val = Math.floor(diff / u.seconds);
        if (val >= 1) {
            return val + " " + u.name + (val > 1 ? "s" : "") + " ago";
        }
    }

    return "just now";
}
function loadNotifications() {

    let filter = new URLSearchParams(window.location.search).get('filter');

    $.ajax({

        url: "{{ route('jobseeker.notifications.ajax') }}",

        type: "GET",

        data: {
            filter: filter
        },

        success: function (res) {

            if (res.status) {

                renderNotifications(res.data);
            }
        },

        error: function () {

            $('#notificationList').html(
                '<p style="padding:20px;">Failed to load notifications</p>'
            );
        }
    });
}

function renderNotifications(notifs) {
    let container = document.getElementById('notificationList');
    let html = '';

    if (!notifs || notifs.length === 0) {
        container.innerHTML = `<p style="padding:20px;">No notifications found</p>`;
        return;
    }

    let iconMap = {
        interview: ['orange','fa-calendar-check'],
        shortlisted: ['green','fa-circle-check'],
        rejected: ['red','fa-circle-xmark'],
        hired: ['green','fa-trophy'],
        alert: ['blue','fa-wand-magic-sparkles'],
        message: ['purple','fa-envelope'],
        profile: ['blue','fa-user-check'],
        resume: ['green','fa-file-check'],
        system: ['blue','fa-bell'],
    };

    notifs.forEach(notif => {

        let type = notif.type ?? 'system';
        let iconData = iconMap[type] ?? ['blue','fa-bell'];
        let isUnread = !notif.read_at;
        
        
        let detailUrl = '';

        if (notif.job_id) {

            detailUrl =
                "{{ url('/jobs/:id') }}"
                .replace(':id', notif.job_id);
        }

        let clickAttr = notif.job_id
            ? `onclick="window.location.href='${detailUrl}'"`
            : '';
        html += `
        <div class="lj-notif-item"
         ${clickAttr}
         style="
            cursor:${notif.job_id ? 'pointer' : 'default'};
            ${isUnread ? 'background:rgba(37,99,235,.025);' : ''}
         ">
            
            <div class="lj-notif-ico ${iconData[0]}">
                <i class="fa-solid ${iconData[1]}"></i>
            </div>

            <div style="flex:1;min-width:0;">
                <div class="lj-notif-text">${notif.msg}</div>
                <div class="lj-notif-time">${timeAgo(notif.created_at)}</div>
            </div>

            <div style="display:flex;align-items:center;gap:8px;">
                ${isUnread ? `
                    <div class="lj-notif-unread-dot"></div>
                    <button onclick="nfMarkRead(${notif.id})" 
                        class="lj-btn lj-btn-ghost lj-btn-sm"
                        style="font-size:.7rem;padding:4px 8px;">
                        <i class="fa-solid fa-check"></i>
                    </button>
                ` : ''}
            </div>

        </div>`;
    });

    container.innerHTML = html;
}
const markReadUrl = "{{ route('notifications.markRead', ':id') }}";
function nfMarkRead(notificationId) {
    let url = markReadUrl.replace(':id', notificationId);
    $.ajax({
        url: url, // Laravel route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}" // include CSRF token
        },
        success: function(res) {
            loadNotifications();  
        },
        error: function(err) {
            console.error(err);
            alert('Error marking notification as read');
        }
    });
}
</script>