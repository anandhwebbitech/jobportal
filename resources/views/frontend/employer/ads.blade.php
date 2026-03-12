{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/advertisements.blade.php
     LinearJobs – Advertisements Module
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Advertisements')
@section('breadcrumb','Advertisements')
@php $activeNav = 'ads'; @endphp

@push('styles')
<style>
.ad-position-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px;}
@media(max-width:640px){.ad-position-grid{grid-template-columns:1fr;}}
.ad-pos-card{
  border:2px solid var(--gray-200);border-radius:14px;padding:20px;cursor:pointer;
  text-align:center;transition:all .25s;background:#fff;
}
.ad-pos-card:hover,.ad-pos-card.selected{border-color:var(--blue);background:var(--blue-light);}
.ad-pos-card input[type="radio"]{display:none;}
.ad-pos-ico{width:48px;height:48px;border-radius:12px;background:var(--gray-100);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--gray-500);margin:0 auto 10px;transition:all .25s;}
.ad-pos-card.selected .ad-pos-ico{background:var(--blue);color:#fff;}
.ad-pos-name{font-size:.82rem;font-weight:800;color:var(--gray-700);}
.ad-pos-desc{font-size:.72rem;color:var(--gray-400);margin-top:3px;}

/* Banner preview */
.banner-preview{
  border:2px dashed var(--gray-200);border-radius:12px;
  min-height:140px;display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:8px;cursor:pointer;transition:all .2s;background:var(--gray-50);
  color:var(--gray-400);text-align:center;padding:20px;
}
.banner-preview:hover{border-color:var(--blue);background:var(--blue-light);color:var(--blue);}
.banner-preview i{font-size:2rem;}
.banner-preview p{font-size:.78rem;font-weight:600;}
.banner-preview small{font-size:.68rem;color:var(--gray-400);}
</style>
@endpush

@section('content')
<div class="page-hdr">
  <div class="page-hdr-left">
    <div class="page-title">Advertisements</div>
    <div class="page-sub">Promote your company and jobs with banner advertisements</div>
  </div>
  <div class="page-hdr-actions">
    <button class="btn-primary" onclick="document.getElementById('adForm').scrollIntoView({behavior:'smooth'})">
      <i class="fas fa-plus"></i> Create Ad
    </button>
  </div>
</div>

{{-- Active Ads --}}
@php $ads = [
  ['id'=>1,'banner'=>'Banner Ad 1','company'=>'TechBridge Solutions','url'=>'https://techbridge.in','start'=>'01 Mar 2025','end'=>'31 Mar 2025','status'=>'Active','amount'=>'₹2,000','pos'=>'Home Banner'],
]; @endphp

@if(count($ads))
<div class="emp-card" style="margin-bottom:24px;">
  <div class="emp-card-head">
    <div class="emp-card-head-ico"><i class="fas fa-rectangle-ad"></i></div>
    <div><div class="emp-card-head-title">Your Advertisements</div><div class="emp-card-head-sub">Manage active and past campaigns</div></div>
  </div>
  <div class="emp-table-wrap">
    <table class="emp-table">
      <thead><tr><th>Banner</th><th>Company</th><th>Position</th><th>Redirect URL</th><th>Start Date</th><th>End Date</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($ads as $ad)
        <tr>
          <td>
            <div style="width:80px;height:40px;background:var(--gradient);border-radius:6px;display:flex;align-items:center;justify-content:center;">
              <i class="fas fa-image" style="color:rgba(255,255,255,.6);"></i>
            </div>
          </td>
          <td><strong>{{ $ad['company'] }}</strong></td>
          <td><span class="badge badge-blue">{{ $ad['pos'] }}</span></td>
          <td><a href="{{ $ad['url'] }}" style="color:var(--blue);font-size:.78rem;" target="_blank">{{ $ad['url'] }}</a></td>
          <td style="font-size:.8rem;">{{ $ad['start'] }}</td>
          <td style="font-size:.8rem;">{{ $ad['end'] }}</td>
          <td><strong style="color:var(--green);">{{ $ad['amount'] }}</strong></td>
          <td><span class="badge badge-green"><i class="fas fa-circle"></i> {{ $ad['status'] }}</span></td>
          <td>
            <div class="td-actions">
              <button class="tbl-btn"><i class="fas fa-pen"></i></button>
              <button class="tbl-btn danger"><i class="fas fa-trash"></i></button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

{{-- Create Ad Form --}}
<div class="emp-card" id="adForm">
  <div class="emp-card-head">
    <div class="emp-card-head-ico"><i class="fas fa-plus-circle"></i></div>
    <div><div class="emp-card-head-title">Create New Advertisement</div><div class="emp-card-head-sub">Set up your banner campaign</div></div>
  </div>
  <div class="emp-card-body">
    <form method="POST" action="{{ route('employer.ads.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- Ad Position --}}
    <div style="margin-bottom:22px;">
      <div class="f-label" style="margin-bottom:12px;"><i class="fas fa-location-crosshairs"></i> Ad Position <span class="f-req">*</span></div>
      <div class="ad-position-grid">
        @php $positions=[
          ['val'=>'left_banner', 'ico'=>'fa-align-left',   'name'=>'Left Banner',  'desc'=>'Sidebar left position'],
          ['val'=>'right_banner','ico'=>'fa-align-right',  'name'=>'Right Banner', 'desc'=>'Sidebar right position'],
          ['val'=>'home_banner', 'ico'=>'fa-house',        'name'=>'Home Banner',  'desc'=>'Homepage hero banner'],
        ]; @endphp
        @foreach($positions as $pos)
        <div class="ad-pos-card {{ $pos['val']==='home_banner'?'selected':'' }}" id="adPos_{{ $pos['val'] }}" onclick="selectAdPos('{{ $pos['val'] }}')">
          <input type="radio" name="ad_position" value="{{ $pos['val'] }}" {{ $pos['val']==='home_banner'?'checked':'' }}/>
          <div class="ad-pos-ico"><i class="fas {{ $pos['ico'] }}"></i></div>
          <div class="ad-pos-name">{{ $pos['name'] }}</div>
          <div class="ad-pos-desc">{{ $pos['desc'] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Banner Upload --}}
    <div class="f-group">
      <label class="f-label"><i class="fas fa-image"></i> Banner Image <span class="f-req">*</span></label>
      <label for="bannerInput">
        <div class="banner-preview" id="bannerPreview">
          <i class="fas fa-cloud-arrow-up"></i>
          <p>Click to upload banner image</p>
          <small>Recommended: 728×90px (Leaderboard) or 300×250px (Rectangle)</small>
        </div>
      </label>
      <input type="file" id="bannerInput" name="banner_image" accept="image/*" style="display:none;" onchange="previewBanner(this)"/>
    </div>

    <div class="f-row">
      <div class="f-group">
        <label class="f-label" for="company_name_ad"><i class="fas fa-building"></i> Company Name <span class="f-req">*</span></label>
        <div class="f-iw">
          <i class="fas fa-building f-ico"></i>
          <input type="text" id="company_name_ad" name="company_name" class="f-input" value="{{ $employer->company_name ?? '' }}" placeholder="Your company name"/>
        </div>
      </div>
      <div class="f-group">
        <label class="f-label" for="redirect_url"><i class="fas fa-link"></i> Redirect URL <span class="f-req">*</span></label>
        <div class="f-iw">
          <i class="fas fa-link f-ico"></i>
          <input type="url" id="redirect_url" name="redirect_url" class="f-input" placeholder="https://yourwebsite.com/jobs"/>
        </div>
      </div>
    </div>

    <div class="f-row">
      <div class="f-group">
        <label class="f-label" for="ad_start"><i class="fas fa-calendar-check"></i> Ad Start Date <span class="f-req">*</span></label>
        <div class="f-iw">
          <i class="fas fa-calendar-check f-ico"></i>
          <input type="date" id="ad_start" name="ad_start_date" class="f-input" value="{{ date('Y-m-d') }}"/>
        </div>
      </div>
      <div class="f-group">
        <label class="f-label" for="ad_end"><i class="fas fa-calendar-xmark"></i> Ad End Date <span class="f-req">*</span></label>
        <div class="f-iw">
          <i class="fas fa-calendar-xmark f-ico"></i>
          <input type="date" id="ad_end" name="ad_end_date" class="f-input"/>
        </div>
      </div>
    </div>

    <div class="emp-notice info">
      <i class="fas fa-circle-info"></i>
      <span>Ad pricing is calculated by duration and position. Our team will contact you with the payment details after submission.</span>
    </div>

    <div style="display:flex;gap:10px;margin-top:18px;">
      <button type="submit" class="btn-primary"><i class="fas fa-rocket"></i> Submit Advertisement</button>
      <button type="reset" class="btn-outline"><i class="fas fa-rotate-right"></i> Reset</button>
    </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function selectAdPos(val) {
  document.querySelectorAll('.ad-pos-card').forEach(c => c.classList.remove('selected'));
  document.getElementById('adPos_' + val).classList.add('selected');
  document.querySelector('input[name="ad_position"][value="'+val+'"]').checked = true;
}
function previewBanner(input) {
  if(input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var p = document.getElementById('bannerPreview');
      p.style.backgroundImage = 'url('+e.target.result+')';
      p.style.backgroundSize = 'contain';
      p.style.backgroundRepeat = 'no-repeat';
      p.style.backgroundPosition = 'center';
      p.innerHTML = '';
      p.style.minHeight = '120px';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush