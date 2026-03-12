{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/manage-jobs.blade.php
     LinearJobs – Manage Jobs Module
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Manage Jobs')
@section('breadcrumb','Manage Jobs')
@php $activeNav = 'manage-jobs'; @endphp

@push('styles')
<style>
/* Filter bar */
.filter-bar{
  background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);
  padding:16px 20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;
  margin-bottom:20px;box-shadow:var(--shadow-sm);
}
.filter-input{
  border:1.5px solid var(--gray-200);border-radius:8px;
  padding:8px 12px 8px 34px;font-size:.82rem;color:var(--gray-800);
  outline:none;background:#fff;transition:border-color .2s;font-family:inherit;
}
.filter-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.09);}
.filter-iw{position:relative;}
.filter-iw i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:.75rem;}
.filter-select{
  border:1.5px solid var(--gray-200);border-radius:8px;
  padding:8px 30px 8px 12px;font-size:.82rem;color:var(--gray-700);
  outline:none;background:#fff;
  -webkit-appearance:none;appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 10px center;
  cursor:pointer;font-family:inherit;transition:border-color .2s;
}
.filter-select:focus{border-color:var(--blue);outline:none;}

/* Jobs stats mini */
.jobs-mini-stats{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;}
.mini-stat{
  background:#fff;border:1px solid var(--gray-200);border-radius:9px;
  padding:12px 18px;display:flex;align-items:center;gap:10px;
  font-size:.82rem;flex:1;min-width:120px;box-shadow:var(--shadow-sm);
}
.mini-stat-ico{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:.78rem;flex-shrink:0;}
.mini-stat-val{font-size:1.1rem;font-weight:900;color:var(--gray-900);line-height:1;}
.mini-stat-lbl{font-size:.68rem;color:var(--gray-400);font-weight:600;}

/* Table action btn */
.tbl-btn{
  display:inline-flex;align-items:center;gap:4px;
  padding:5px 9px;border-radius:6px;font-size:.7rem;font-weight:700;
  border:1.5px solid var(--gray-200);background:#fff;color:var(--gray-600);
  cursor:pointer;transition:all .2s;white-space:nowrap;
}
.tbl-btn:hover{border-color:var(--blue);color:var(--blue);background:var(--blue-light);}
.tbl-btn.danger:hover{border-color:#fca5a5;color:var(--red);background:var(--red-light);}
.tbl-btn.success:hover{border-color:#86efac;color:var(--green);background:var(--green-light);}

/* Applicant count chip */
.app-count{
  display:inline-flex;align-items:center;gap:4px;
  background:var(--blue-light);color:var(--blue);
  border-radius:100px;padding:2px 9px;
  font-size:.72rem;font-weight:700;
}

/* Modal */
.emp-modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:500;backdrop-filter:blur(4px);align-items:center;justify-content:center;}
.emp-modal-overlay.open{display:flex;}
.emp-modal{background:#fff;border-radius:16px;max-width:440px;width:90%;padding:28px;position:relative;box-shadow:var(--shadow-lg);animation:modalIn .25s ease;}
@keyframes modalIn{from{opacity:0;transform:scale(.94) translateY(12px)}to{opacity:1;transform:scale(1) translateY(0)}}
.modal-close{position:absolute;top:14px;right:14px;background:var(--gray-100);border:none;width:30px;height:30px;border-radius:7px;cursor:pointer;color:var(--gray-600);font-size:.82rem;display:flex;align-items:center;justify-content:center;}
.modal-close:hover{background:var(--gray-200);}
</style>
@endpush

@section('content')

<div class="page-hdr">
  <div class="page-hdr-left">
    <div class="page-title">Manage Jobs</div>
    <div class="page-sub">View, edit and manage all your job listings</div>
  </div>
  <div class="page-hdr-actions">
    <a href="{{ route('employer.jobs.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Post New Job</a>
  </div>
</div>

{{-- Mini Stats --}}
<div class="jobs-mini-stats">
  @php $mstats=[
    ['lbl'=>'Total Jobs','val'=>12,'ico'=>'fa-briefcase','col'=>'var(--blue)',   'bg'=>'var(--blue-light)'],
    ['lbl'=>'Active',    'val'=>7, 'ico'=>'fa-circle-check','col'=>'var(--green)', 'bg'=>'var(--green-light)'],
    ['lbl'=>'Expired',   'val'=>3, 'ico'=>'fa-clock',    'col'=>'var(--red)',   'bg'=>'var(--red-light)'],
    ['lbl'=>'Inactive',  'val'=>2, 'ico'=>'fa-pause',    'col'=>'var(--amber)', 'bg'=>'var(--amber-light)'],
    ['lbl'=>'Applications','val'=>148,'ico'=>'fa-users', 'col'=>'#7c3aed',      'bg'=>'rgba(124,58,237,.08)'],
  ]; @endphp
  @foreach($mstats as $ms)
  <div class="mini-stat">
    <div class="mini-stat-ico" style="background:{{ $ms['bg'] }};color:{{ $ms['col'] }};"><i class="fas {{ $ms['ico'] }}"></i></div>
    <div><div class="mini-stat-val">{{ $ms['val'] }}</div><div class="mini-stat-lbl">{{ $ms['lbl'] }}</div></div>
  </div>
  @endforeach
</div>

{{-- Filter Bar --}}
<div class="filter-bar">
  <div class="filter-iw" style="flex:1;min-width:180px;">
    <i class="fas fa-search"></i>
    <input type="text" class="filter-input" style="width:100%;" placeholder="Search job title..." oninput="filterJobs(this.value)"/>
  </div>
  <select class="filter-select" onchange="filterByStatus(this.value)">
    <option value="">All Status</option>
    <option value="Active">Active</option>
    <option value="Expired">Expired</option>
    <option value="Inactive">Inactive</option>
  </select>
  <select class="filter-select" onchange="filterByCategory(this.value)">
    <option value="">All Categories</option>
    <option>IT / Software</option><option>Sales & Marketing</option>
    <option>Operations</option><option>Design</option><option>HR</option>
  </select>
  <button class="btn-outline btn-sm"><i class="fas fa-rotate-right"></i> Reset</button>
</div>

{{-- Jobs Table --}}
<div class="emp-card">
  <div class="emp-table-wrap">
    <table class="emp-table" id="jobsTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Job Title</th>
          <th>Category</th>
          <th>Location</th>
          <th>Vacancies</th>
          <th>Posted Date</th>
          <th>Expiry Date</th>
          <th>Applications</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="jobsBody">
        @php
        $jobs = [
          [1,'Senior React Developer','IT / Software','Chennai, TN',3,'01 Mar 2025','01 Apr 2025',32,'Active'],
          [2,'Operations Manager','Operations','Coimbatore, TN',1,'05 Mar 2025','05 Apr 2025',18,'Active'],
          [3,'UI/UX Designer','Design','Madurai, TN',2,'20 Feb 2025','20 Mar 2025',45,'Expired'],
          [4,'Sales Executive','Sales & Marketing','Trichy, TN',5,'10 Mar 2025','10 Apr 2025',27,'Active'],
          [5,'HR Executive','Human Resources','Chennai, TN',1,'08 Mar 2025','08 Apr 2025',14,'Active'],
          [6,'Mechanical Engineer','Engineering','Salem, TN',2,'15 Feb 2025','15 Mar 2025',9,'Expired'],
          [7,'Digital Marketing Exec','Marketing','Coimbatore, TN',1,'12 Mar 2025','12 Apr 2025',3,'Active'],
        ];
        @endphp
        @foreach($jobs as $j)
        <tr data-title="{{ strtolower($j[1]) }}" data-status="{{ $j[8] }}" data-category="{{ $j[2] }}">
          <td style="color:var(--gray-400);font-size:.78rem;">{{ $j[0] }}</td>
          <td>
            <div style="font-weight:700;color:var(--gray-800);">{{ $j[1] }}</div>
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:2px;"><i class="fas fa-building"></i> TechBridge Solutions</div>
          </td>
          <td><span class="badge badge-blue">{{ $j[2] }}</span></td>
          <td style="font-size:.8rem;"><i class="fas fa-location-dot" style="color:var(--gray-400);margin-right:4px;"></i>{{ $j[3] }}</td>
          <td style="text-align:center;font-weight:700;">{{ $j[4] }}</td>
          <td style="font-size:.8rem;">{{ $j[5] }}</td>
          <td style="font-size:.8rem;color:{{ $j[8]==='Expired'?'var(--red)':'var(--gray-600)' }};">{{ $j[6] }}</td>
          <td><span class="app-count"><i class="fas fa-users"></i> {{ $j[7] }}</span></td>
          <td>
            @if($j[8]==='Active')
              <span class="badge badge-green"><i class="fas fa-circle"></i> Active</span>
            @elseif($j[8]==='Expired')
              <span class="badge badge-red"><i class="fas fa-clock"></i> Expired</span>
            @else
              <span class="badge badge-gray">Inactive</span>
            @endif
          </td>
          <td>
            <div class="td-actions">
              <a href="#" class="tbl-btn" title="View"><i class="fas fa-eye"></i></a>
              <a href="{{ route('employer.jobs.edit', $j[0]) }}" class="tbl-btn" title="Edit"><i class="fas fa-pen"></i></a>
              <a href="{{ route('employer.candidates') }}?job={{ $j[0] }}" class="tbl-btn success" title="Applicants"><i class="fas fa-users"></i></a>
              <button class="tbl-btn" title="{{ $j[8]==='Active'?'Deactivate':'Activate' }}" onclick="toggleJob({{ $j[0] }},'{{ $j[8] }}')">
                <i class="fas {{ $j[8]==='Active'?'fa-pause':'fa-play' }}"></i>
              </button>
              <button class="tbl-btn danger" title="Delete" onclick="confirmDelete({{ $j[0] }},'{{ $j[1] }}')">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- Pagination --}}
  <div style="padding:16px 20px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--gray-100);flex-wrap:wrap;gap:10px;">
    <div style="font-size:.78rem;color:var(--gray-400);">Showing <strong>7</strong> of <strong>12</strong> jobs</div>
    <div style="display:flex;gap:6px;">
      <button class="btn-outline btn-sm"><i class="fas fa-chevron-left"></i></button>
      <button class="btn-primary btn-sm">1</button>
      <button class="btn-outline btn-sm">2</button>
      <button class="btn-outline btn-sm"><i class="fas fa-chevron-right"></i></button>
    </div>
  </div>
</div>

{{-- Delete Confirm Modal --}}
<div class="emp-modal-overlay" id="deleteModal">
  <div class="emp-modal">
    <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    <div style="text-align:center;margin-bottom:20px;">
      <div style="width:56px;height:56px;border-radius:14px;background:var(--red-light);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--red);margin:0 auto 12px;">
        <i class="fas fa-trash"></i>
      </div>
      <div style="font-size:1.05rem;font-weight:800;color:var(--gray-900);">Delete Job?</div>
      <div style="font-size:.82rem;color:var(--gray-400);margin-top:6px;" id="deleteJobName">This job listing will be permanently deleted.</div>
    </div>
    <div class="emp-notice danger"><i class="fas fa-triangle-exclamation"></i> All applications for this job will also be removed.</div>
    <div style="display:flex;gap:10px;">
      <button class="btn-outline" style="flex:1;" onclick="closeModal()">Cancel</button>
      <button class="btn-primary" style="flex:1;background:linear-gradient(135deg,#dc2626,#b91c1c);" onclick="doDelete()"><i class="fas fa-trash"></i> Delete Job</button>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function filterJobs(q) {
  document.querySelectorAll('#jobsBody tr').forEach(function(tr) {
    var title = tr.getAttribute('data-title') || '';
    tr.style.display = title.includes(q.toLowerCase()) ? '' : 'none';
  });
}
function filterByStatus(s) {
  document.querySelectorAll('#jobsBody tr').forEach(function(tr) {
    var st = tr.getAttribute('data-status') || '';
    tr.style.display = (!s || st === s) ? '' : 'none';
  });
}
function filterByCategory(c) {
  document.querySelectorAll('#jobsBody tr').forEach(function(tr) {
    var cat = tr.getAttribute('data-category') || '';
    tr.style.display = (!c || cat === c) ? '' : 'none';
  });
}
var deleteId = null;
function confirmDelete(id, name) {
  deleteId = id;
  document.getElementById('deleteJobName').textContent = 'Delete job "' + name + '"? This cannot be undone.';
  document.getElementById('deleteModal').classList.add('open');
}
function closeModal() {
  document.getElementById('deleteModal').classList.remove('open');
}
function doDelete() {
  // Send DELETE request
  closeModal();
  alert('Job deleted. (Wire to DELETE route in production)');
}
function toggleJob(id, status) {
  var action = status === 'Active' ? 'deactivate' : 'activate';
  if(confirm('Are you sure you want to ' + action + ' this job?')) {
    alert('Job ' + action + 'd. (Wire to PATCH route)');
  }
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
  if(e.target === this) closeModal();
});
</script>
@endpush