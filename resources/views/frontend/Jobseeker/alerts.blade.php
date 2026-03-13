{{-- alerts.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Job Alerts')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Job Alerts</div>
    <div class="lj-page-subtitle">Get notified instantly when matching jobs are posted.</div>
  </div>
</div>

<div class="lj-grid-2">

  {{-- Active Alerts --}}
  <div class="lj-card lj-section-gap">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-bell"></i> Active Alerts</div>
      <span style="font-size:.74rem;color:var(--n500);font-weight:500;">{{ ($alerts ?? collect())->count() }} alert(s)</span>
    </div>
    <div style="padding:0 20px;">
      @forelse($alerts ?? [] as $alert)
        <div class="lj-alert-item">
          <div class="lj-alert-icon" style="background:{{ $alert->is_active ? 'var(--blue-light)' : 'var(--n100)' }};color:{{ $alert->is_active ? 'var(--blue)' : 'var(--n400)' }};">
            <i class="fa-solid fa-code"></i>
          </div>
          <div style="flex:1;min-width:0;">
            <div class="lj-alert-name">{{ $alert->keyword }}</div>
            <div class="lj-alert-meta">
              {{ $alert->location ?: 'All Locations' }} · {{ ucfirst($alert->frequency ?? 'Daily') }}
              @if($alert->new_matches ?? 0 > 0)
                · <span style="color:var(--blue);font-weight:600;">{{ $alert->new_matches }} new</span>
              @endif
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
            <a href="{{ route('jobseeker.dashboard.alerts.edit', $alert->id) }}" class="lj-btn lj-btn-ghost lj-btn-sm">
              <i class="fa-solid fa-pen"></i>
            </a>
            <form method="POST" action="{{ route('jobseeker.dashboard.alerts.toggle', $alert->id) }}">
              @csrf @method('PUT')
              <button type="submit" class="lj-toggle {{ $alert->is_active ? 'on' : '' }}" title="{{ $alert->is_active ? 'Disable' : 'Enable' }}"></button>
            </form>
            <form method="POST" action="{{ route('jobseeker.dashboard.alerts.delete', $alert->id) }}" onsubmit="return confirm('Delete this alert?')">
              @csrf @method('DELETE')
              <button type="submit" class="lj-btn lj-btn-ghost lj-btn-sm" style="color:var(--red);">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      @empty
        @php
          $sampleAlerts = [
            ['PHP / Laravel Jobs','Coimbatore, Tamil Nadu','Daily','4 new matches',true,'fa-code'],
            ['Full Stack Developer','Tamil Nadu','Weekly','8 new matches',true,'fa-laptop-code'],
            ['Remote Developer Jobs','Remote','Daily','2 new matches',false,'fa-briefcase'],
          ];
        @endphp
        @foreach($sampleAlerts as $sa)
          <div class="lj-alert-item">
            <div class="lj-alert-icon" style="background:{{ $sa[4] ? 'var(--blue-light)' : 'var(--n100)' }};color:{{ $sa[4] ? 'var(--blue)' : 'var(--n400)' }};">
              <i class="fa-solid {{ $sa[5] }}"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div class="lj-alert-name">{{ $sa[0] }}</div>
              <div class="lj-alert-meta">{{ $sa[1] }} · {{ $sa[2] }} · <span style="color:var(--blue);font-weight:600;">{{ $sa[3] }}</span></div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
              <button class="lj-btn lj-btn-ghost lj-btn-sm"><i class="fa-solid fa-pen"></i></button>
              <div class="lj-toggle {{ $sa[4] ? 'on' : '' }}" onclick="this.classList.toggle('on')"></div>
              <button class="lj-btn lj-btn-ghost lj-btn-sm" style="color:var(--red);"><i class="fa-solid fa-trash"></i></button>
            </div>
          </div>
        @endforeach
      @endforelse
    </div>
  </div>

  {{-- Create New Alert --}}
  <div class="lj-card">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-plus-circle"></i> Create New Alert</div>
    </div>
    <form method="POST" action="{{ route('jobseeker.alerts.store') }}">
      @csrf
      <div class="lj-card-body">

        <div class="lj-fgroup" style="margin-bottom:14px;">
          <label class="lj-label">Job Title / Keywords <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-magnifying-glass lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="keyword"
              value="{{ old('keyword') }}" placeholder="e.g. PHP Developer, Laravel" required/>
          </div>
          @error('keyword')<div style="font-size:.72rem;color:var(--red);margin-top:3px;">{{ $message }}</div>@enderror
        </div>

        <div class="lj-fgroup" style="margin-bottom:14px;">
          <label class="lj-label">Location</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-location-dot lj-input-ico"></i>
            <select class="lj-input has-ico" name="location">
              <option value="">All Locations in Tamil Nadu</option>
              @php $districts = ['Coimbatore','Chennai','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Tiruppur','Dindigul','Hosur','Remote']; @endphp
              @foreach($districts as $d)
                <option value="{{ $d }}" {{ old('location') == $d ? 'selected' : '' }}>{{ $d }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="lj-form-grid" style="margin-bottom:14px;">
          <div class="lj-fgroup">
            <label class="lj-label">Job Type</label>
            <select class="lj-input" name="job_type">
              <option value="">Any Type</option>
              @foreach(['Full-time','Part-time','Remote','Contract','Internship'] as $t)
                <option value="{{ $t }}" {{ old('job_type') == $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
          <div class="lj-fgroup">
            <label class="lj-label">Experience Level</label>
            <select class="lj-input" name="experience">
              <option value="">Any Level</option>
              @foreach(['Fresher','1-2 Years','3-5 Years','5+ Years'] as $e)
                <option value="{{ $e }}" {{ old('experience') == $e ? 'selected' : '' }}>{{ $e }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="lj-fgroup" style="margin-bottom:14px;">
          <label class="lj-label">Salary Range</label>
          <select class="lj-input" name="salary">
            <option value="">Any Salary</option>
            <option value="0-15000"    {{ old('salary')=='0-15000'    ? 'selected':'' }}>Up to ₹15,000/mo</option>
            <option value="15000-25000"{{ old('salary')=='15000-25000'? 'selected':'' }}>₹15k – ₹25k/mo</option>
            <option value="25000-50000"{{ old('salary')=='25000-50000'? 'selected':'' }}>₹25k – ₹50k/mo</option>
            <option value="50000+"     {{ old('salary')=='50000+'     ? 'selected':'' }}>₹50,000+/mo</option>
          </select>
        </div>

        <div class="lj-fgroup">
          <label class="lj-label">Alert Frequency <span class="req">*</span></label>
          <div class="chip-select" id="freqChips">
            <span class="chip active" onclick="setFreq('daily',this)">Daily</span>
            <span class="chip" onclick="setFreq('weekly',this)">Weekly</span>
            <span class="chip" onclick="setFreq('instant',this)">Instant</span>
          </div>
          <input type="hidden" name="frequency" id="freqInput" value="{{ old('frequency','daily') }}"/>
        </div>

        <div style="margin-top:14px;padding:11px 13px;background:var(--blue-light);border:1.5px solid var(--blue-mid);border-radius:8px;font-size:.78rem;color:#1e40af;display:flex;align-items:center;gap:8px;line-height:1.45;">
          <i class="fa-solid fa-envelope" style="flex-shrink:0;"></i>
          Alerts will be sent to <strong style="margin-left:3px;">{{ auth()->user()?->email }}</strong>
        </div>
      </div>
      <div class="lj-form-footer">
        <button type="submit" class="lj-btn lj-btn-primary" style="width:100%;justify-content:center;">
          <i class="fa-solid fa-bell"></i> Create Alert
        </button>
      </div>
    </form>
  </div>
</div>

@if(($totalMatches ?? 0) > 0)
  <div style="background:var(--green-light);border:1.5px solid #86efac;border-radius:11px;padding:14px 18px;display:flex;align-items:center;gap:13px;">
    <div style="width:42px;height:42px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;font-size:.95rem;color:var(--green);flex-shrink:0;">
      <i class="fa-solid fa-circle-check"></i>
    </div>
    <div>
      <div style="font-weight:700;color:#065f46;font-size:.9rem;">{{ $totalMatches }} new jobs match your alerts!</div>
      <div style="font-size:.77rem;color:#16a34a;margin-top:2px;">
        <a href="{{ route('jobs.index') }}" style="color:var(--blue);text-decoration:underline;">Browse all matching jobs →</a>
      </div>
    </div>
  </div>
@endif

@endsection

@push('scripts')
<script>
function setFreq(val, el) {
  document.getElementById('freqChips').querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('freqInput').value = val;
}
</script>
@endpush