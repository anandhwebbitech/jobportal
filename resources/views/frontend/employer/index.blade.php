{{-- resources/views/employer/jobs/index.blade.php --}}
@extends('frontend.employer.layouts.app')
@section('title', 'Manage Jobs')
@section('page-title', 'Manage Jobs')

@section('content')
<div class="emp-page-hero">
  <div class="emp-page-hero-inner">
    <div class="emp-page-badge"><i class="fa-solid fa-briefcase"></i> Jobs</div>
    <div class="emp-page-hero-title">Manage Jobs</div>
    <div class="emp-page-hero-sub">View, edit and manage all your job postings from one place.</div>
  </div>
</div>

<div class="emp-body">

  {{-- FILTER BAR --}}
  <div class="emp-card" style="margin-bottom:16px;">
    <div class="emp-card-body" style="padding:16px 20px;">
      <form method="GET" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
        <div style="position:relative;flex:1;min-width:200px;">
          <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.82rem;"></i>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search job title..." style="width:100%;border:1.5px solid #d1d5db;border-radius:9px;padding:9px 14px 9px 36px;font-size:.875rem;outline:none;font-family:inherit;" onfocus="this.style.borderColor='#1a56db'" onblur="this.style.borderColor='#d1d5db'">
        </div>
        <select name="status" style="border:1.5px solid #d1d5db;border-radius:9px;padding:9px 32px 9px 14px;font-size:.875rem;outline:none;font-family:inherit;cursor:pointer;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7'%3E%3Cpath d='M0 0l5.5 7 5.5-7z' fill='%239ca3af'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 10px center;-webkit-appearance:none;appearance:none;">
          <option value="">All Status</option>
          <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
          <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
          <option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option>
        </select>
        <select name="category" style="border:1.5px solid #d1d5db;border-radius:9px;padding:9px 32px 9px 14px;font-size:.875rem;outline:none;font-family:inherit;cursor:pointer;background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7'%3E%3Cpath d='M0 0l5.5 7 5.5-7z' fill='%239ca3af'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 10px center;-webkit-appearance:none;appearance:none;">
          <option value="">All Categories</option>
          @foreach(['IT & Software','Technical & Trade','Sales & Marketing','Office & Admin','Driver & Logistics','Manufacturing','Healthcare','Education','Hospitality','Other'] as $cat)
            <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn-primary btn-sm"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="{{ route('employer.jobs.index') }}" class="btn-secondary btn-sm">Clear</a>
        <a href="{{ route('employer.jobs.create') }}" class="btn-primary btn-sm" style="margin-left:auto;">
          <i class="fa-solid fa-plus"></i> Post New Job
        </a>
      </form>
    </div>
  </div>

  {{-- JOBS TABLE --}}
  <div class="emp-card">
    <div class="emp-card-head">
      <div class="emp-card-head-ico"><i class="fa-solid fa-list"></i></div>
      <div>
        <div class="emp-card-head-title">All Job Postings</div>
        <div class="emp-card-head-sub">{{ $jobs->total() ?? 0 }} jobs found</div>
      </div>
    </div>
    <div class="emp-table-wrap">
      <table class="emp-table">
        <thead>
          <tr>
            <th>Job Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Vacancies</th>
            <th>Posted Date</th>
            <th>Expiry</th>
            <th>Applications</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($jobs ?? [] as $job)
          <tr>
            <td>
              <div style="font-weight:700;color:#111827;font-size:.875rem;">{{ $job->job_title }}</div>
              <div style="font-size:.72rem;color:#9ca3af;margin-top:2px;">{{ $job->job_type }} &middot; {{ $job->experience_required }}</div>
            </td>
            <td>
              <span class="badge badge-blue">{{ $job->job_category }}</span>
            </td>
            <td>
              <div style="font-size:.83rem;">{{ $job->city }}, {{ $job->district }}</div>
              <div style="font-size:.72rem;color:#9ca3af;">{{ $job->state }}</div>
            </td>
            <td style="text-align:center;font-weight:700;">{{ $job->vacancies }}</td>
            <td style="font-size:.82rem;color:#6b7280;">{{ $job->created_at->format('d M Y') }}</td>
            <td>
              @php $daysLeft = now()->diffInDays($job->expires_at, false); @endphp
              <div style="font-size:.82rem;{{ $daysLeft < 5 ? 'color:#dc2626;font-weight:700;' : 'color:#6b7280;' }}">
                {{ $job->expires_at->format('d M Y') }}
              </div>
              @if($daysLeft >= 0)
                <div style="font-size:.68rem;color:{{ $daysLeft < 5 ? '#dc2626' : '#9ca3af' }};">{{ $daysLeft }} days left</div>
              @else
                <div style="font-size:.68rem;color:#dc2626;">Expired</div>
              @endif
            </td>
            <td style="text-align:center;">
              <a href="{{ route('employer.candidates', ['job_id' => $job->id]) }}" style="display:inline-flex;align-items:center;gap:5px;font-weight:700;color:#1a56db;font-size:.855rem;">
                <i class="fa-solid fa-users" style="font-size:.75rem;"></i> {{ $job->applications_count ?? 0 }}
              </a>
            </td>
            <td>
              <span class="badge {{ $job->status === 'active' ? 'badge-green' : ($job->status === 'expired' ? 'badge-red' : 'badge-gray') }}">
                <span class="badge-dot"></span> {{ ucfirst($job->status) }}
              </span>
            </td>
            <td>
              <div class="emp-table-actions">
                <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn-secondary btn-xs" title="View">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn-secondary btn-xs" title="Edit">
                  <i class="fa-solid fa-pen"></i>
                </a>
                <a href="{{ route('employer.candidates', ['job_id' => $job->id]) }}" class="btn-secondary btn-xs btn-purple" title="Applicants">
                  <i class="fa-solid fa-users"></i>
                </a>
                <form method="POST" action="{{ route('employer.jobs.toggle', $job->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn-secondary btn-xs {{ $job->status === 'active' ? 'btn-yellow' : 'btn-green' }}" title="{{ $job->status === 'active' ? 'Deactivate' : 'Activate' }}">
                    <i class="fa-solid {{ $job->status === 'active' ? 'fa-pause' : 'fa-play' }}"></i>
                  </button>
                </form>
                <form method="POST" action="{{ route('employer.jobs.destroy', $job->id) }}" style="display:inline;" onsubmit="return confirm('Delete this job? This cannot be undone.')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-danger btn-xs" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" style="text-align:center;padding:48px;">
              <i class="fa-solid fa-briefcase" style="font-size:2.2rem;color:#e5e7eb;display:block;margin-bottom:12px;"></i>
              <div style="font-size:.9rem;font-weight:700;color:#374151;margin-bottom:6px;">No jobs posted yet</div>
              <div style="font-size:.82rem;color:#9ca3af;margin-bottom:16px;">Start by posting your first job to attract candidates.</div>
              <a href="{{ route('employer.jobs.create') }}" class="btn-primary btn-sm">
                <i class="fa-solid fa-plus"></i> Post Your First Job
              </a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(isset($jobs) && $jobs->hasPages())
    <div class="emp-pagination">
      <span>Showing {{ $jobs->firstItem() }}–{{ $jobs->lastItem() }} of {{ $jobs->total() }}</span>
      <div class="emp-page-btns">
        @if($jobs->onFirstPage())
          <button class="emp-page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
        @else
          <a href="{{ $jobs->previousPageUrl() }}" class="emp-page-btn"><i class="fa-solid fa-chevron-left"></i></a>
        @endif
        @foreach($jobs->getUrlRange(max(1,$jobs->currentPage()-2), min($jobs->lastPage(),$jobs->currentPage()+2)) as $page => $url)
          <a href="{{ $url }}" class="emp-page-btn {{ $page == $jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($jobs->hasMorePages())
          <a href="{{ $jobs->nextPageUrl() }}" class="emp-page-btn"><i class="fa-solid fa-chevron-right"></i></a>
        @else
          <button class="emp-page-btn" disabled><i class="fa-solid fa-chevron-right"></i></button>
        @endif
      </div>
    </div>
    @endif
  </div>
</div>
@endsection