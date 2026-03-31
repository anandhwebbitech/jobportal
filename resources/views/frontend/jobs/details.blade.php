{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/jobs/job-details.blade.php
     Job Details – LinearJobs
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', ($job->title ?? 'Job Details').' – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* ── PAGE ─────────────────────────────────────────── */
.lj-jd-page{background:var(--n50);min-height:calc(100vh - 64px);padding:32px 20px 60px;}
.lj-jd-wrap{max-width:1100px;margin:0 auto;}

/* ── BREADCRUMB ───────────────────────────────────── */
.lj-breadcrumb{display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--n500);margin-bottom:20px;flex-wrap:wrap;}
.lj-breadcrumb a{color:var(--blue);text-decoration:none;font-weight:500;}
.lj-breadcrumb a:hover{text-decoration:underline;}
.lj-breadcrumb i{font-size:.6rem;color:var(--n300);}

/* ── LAYOUT ───────────────────────────────────────── */
.lj-jd-layout{display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start;}

/* ── JOB HEADER CARD ──────────────────────────────── */
.lj-jd-header-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;overflow:hidden;margin-bottom:20px;}
.lj-jd-header-top{padding:26px 28px 20px;display:flex;align-items:flex-start;gap:18px;}
.lj-company-logo{width:68px;height:68px;border-radius:14px;background:var(--n100);display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:var(--n500);border:1.5px solid var(--n200);flex-shrink:0;overflow:hidden;}
.lj-company-logo img{width:100%;height:100%;object-fit:cover;}
.lj-jd-header-info{flex:1;}
.lj-jd-badge-row{display:flex;gap:7px;margin-bottom:8px;flex-wrap:wrap;}
.lj-jd-badge{font-size:.65rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:5px;}
.lj-jd-badge.urgent{background:#fef3c7;color:#b45309;}
.lj-jd-badge.new{background:#dcfce7;color:#166534;}
.lj-jd-badge.hiring{background:#ede9fe;color:#6d28d9;}
.lj-jd-title{font-size:1.5rem;font-weight:900;color:var(--n900);letter-spacing:-.4px;margin-bottom:6px;line-height:1.2;}
.lj-jd-company{font-size:.9375rem;font-weight:700;color:var(--n700);display:flex;align-items:center;gap:7px;margin-bottom:5px;}
.lj-jd-company .verified{display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;color:#1d4ed8;background:#eff6ff;border:1px solid #bfdbfe;border-radius:100px;padding:2px 8px;}
.lj-jd-location{font-size:.875rem;color:var(--n500);display:flex;align-items:center;gap:6px;}
.lj-jd-header-meta{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-top:1.5px solid var(--n100);}
.lj-jd-meta-item{padding:14px 20px;border-right:1px solid var(--n100);display:flex;flex-direction:column;gap:3px;}
.lj-jd-meta-item:last-child{border-right:none;}
.lj-jd-meta-label{font-size:.68rem;font-weight:700;color:var(--n400);text-transform:uppercase;letter-spacing:.06em;}
.lj-jd-meta-value{font-size:.9rem;font-weight:700;color:var(--n800);display:flex;align-items:center;gap:5px;}
.lj-jd-meta-value i{color:var(--blue);font-size:.8rem;}

/* ── MAIN CONTENT CARD ────────────────────────────── */
.lj-jd-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;padding:28px;margin-bottom:20px;}
.lj-section-title{font-size:.75rem;font-weight:800;color:var(--n400);text-transform:uppercase;letter-spacing:.09em;margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.lj-section-title::after{content:'';flex:1;height:1.5px;background:var(--n100);}
.lj-section-title i{color:var(--blue);font-size:.8rem;}
.lj-jd-desc{font-size:.9rem;color:var(--n700);line-height:1.8;}
.lj-resp-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;}
.lj-resp-list li{display:flex;align-items:flex-start;gap:10px;font-size:.9rem;color:var(--n700);line-height:1.6;}
.lj-resp-list li .bullet{width:7px;height:7px;border-radius:50%;background:var(--blue);flex-shrink:0;margin-top:7px;}
.lj-skill-tags{display:flex;flex-wrap:wrap;gap:8px;}
.lj-skill-tag{display:inline-flex;align-items:center;border:1.5px solid var(--n200);border-radius:100px;padding:5px 15px;font-size:.82rem;font-weight:600;color:var(--n700);background:#fff;transition:all .2s;}
.lj-skill-tag:hover{border-color:var(--blue);color:var(--blue);}
.lj-benefit-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.lj-benefit-item{display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:11px 14px;}
.lj-benefit-item i{width:32px;height:32px;border-radius:8px;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#16a34a;font-size:.82rem;flex-shrink:0;}
.lj-benefit-text{font-size:.84rem;font-weight:600;color:#166534;}

/* ── SIDEBAR CARDS ────────────────────────────────── */
.lj-jd-sidebar{position:sticky;top:90px;display:flex;flex-direction:column;gap:16px;}
.lj-apply-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;padding:22px;overflow:hidden;}
.lj-apply-card-title{font-size:.82rem;font-weight:700;color:var(--n700);margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.lj-apply-card-title i{color:var(--blue);}
.lj-apply-main-btn{width:100%;background:linear-gradient(135deg,#1a56db,#1e3a8a);color:#fff;border:none;border-radius:10px;font-family:var(--f);font-size:.9375rem;font-weight:700;padding:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:all .25s;text-decoration:none;margin-bottom:10px;}
.lj-apply-main-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(26,86,219,.3);}
.lj-save-main-btn{width:100%;background:#fff;color:var(--n700);border:1.5px solid var(--n200);border-radius:10px;font-family:var(--f);font-size:.9rem;font-weight:600;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s;margin-bottom:14px;}
.lj-save-main-btn:hover{border-color:var(--blue);color:var(--blue);}
.lj-deadline-note{font-size:.75rem;color:var(--n500);text-align:center;display:flex;align-items:center;justify-content:center;gap:5px;margin-top:2px;}
.lj-deadline-note i{color:#f59e0b;}
.lj-share-row{display:flex;gap:8px;margin-top:14px;}
.lj-share-btn{flex:1;background:var(--n50);border:1.5px solid var(--n100);border-radius:8px;padding:8px;font-size:.8rem;font-weight:600;color:var(--n600);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:all .2s;text-decoration:none;}
.lj-share-btn:hover{border-color:var(--n300);}
/* Company Info Card */
.lj-company-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;padding:22px;}
.lj-company-card-head{display:flex;align-items:center;gap:12px;margin-bottom:14px;}
.lj-co-logo-sm{width:44px;height:44px;border-radius:10px;background:var(--n100);display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--n500);border:1px solid var(--n200);}
.lj-co-name{font-size:.9rem;font-weight:700;color:var(--n800);}
.lj-co-location{font-size:.78rem;color:var(--n500);margin-top:2px;}
.lj-co-detail-row{display:flex;align-items:flex-start;gap:9px;font-size:.82rem;color:var(--n600);margin-bottom:8px;}
.lj-co-detail-row i{color:var(--blue);width:16px;text-align:center;margin-top:1px;flex-shrink:0;}
/* Jobs count card */
.lj-info-card{background:var(--blue);border-radius:14px;padding:18px 20px;color:#fff;}
.lj-info-card-title{font-size:.8rem;font-weight:700;color:rgba(255,255,255,.8);margin-bottom:6px;}
.lj-info-card-val{font-size:1.4rem;font-weight:900;letter-spacing:-.5px;}
.lj-info-card-sub{font-size:.75rem;color:rgba(255,255,255,.65);margin-top:3px;}

/* ── RELATED JOBS ─────────────────────────────────── */
.lj-related-card{background:#fff;border:1.5px solid var(--n200);border-radius:16px;padding:22px;}
.lj-related-job{display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:1px solid var(--n50);cursor:pointer;transition:background .15s;}
.lj-related-job:last-child{border-bottom:none;padding-bottom:0;}
.lj-related-job:hover .lj-related-title{color:var(--blue);}
.lj-related-logo{width:36px;height:36px;border-radius:8px;background:var(--n100);display:flex;align-items:center;justify-content:center;font-size:.8rem;color:var(--n500);border:1px solid var(--n200);flex-shrink:0;}
.lj-related-title{font-size:.84rem;font-weight:700;color:var(--n800);margin-bottom:2px;}
.lj-related-company{font-size:.75rem;color:var(--n500);}
.lj-related-tags{display:flex;gap:5px;margin-top:5px;flex-wrap:wrap;}
.lj-related-tag{font-size:.68rem;font-weight:600;color:var(--n600);background:var(--n50);border:1px solid var(--n100);border-radius:4px;padding:2px 7px;}

/* ── SCROLL-TO-TOP ────────────────────────────────── */
.lj-scroll-top{position:fixed;bottom:28px;right:28px;width:44px;height:44px;background:var(--blue);color:#fff;border:none;border-radius:50%;font-size:.9rem;cursor:pointer;display:none;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(26,86,219,.3);z-index:50;transition:all .25s;}
.lj-scroll-top.show{display:flex;}
.lj-scroll-top:hover{transform:translateY(-2px);}

@media(max-width:900px){
  .lj-jd-layout{grid-template-columns:1fr;}
  .lj-jd-sidebar{position:static;}
  .lj-jd-header-meta{grid-template-columns:1fr 1fr;}
  .lj-jd-meta-item:nth-child(2){border-right:none;}
  .lj-jd-meta-item:nth-child(3){border-top:1px solid var(--n100);}
  .lj-jd-meta-item:nth-child(4){border-top:1px solid var(--n100);border-right:none;}
}
@media(max-width:600px){
  .lj-jd-page{padding:16px 12px 40px;}
  .lj-jd-header-top{flex-direction:column;}
  .lj-jd-header-meta{grid-template-columns:1fr 1fr;}
  .lj-benefit-grid{grid-template-columns:1fr;}
  .lj-jd-title{font-size:1.2rem;}
}
.custom-toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--blue);
    color: #fff;
    padding: 10px 18px;
    border-radius: 6px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    z-index: 9999;
    font-size: 0.9rem;
    opacity: 0.95;
}
</style>
@endpush

@section('content')
<div class="lj-jd-page">
  <div class="lj-jd-wrap">

    {{-- Breadcrumb --}}
    <div class="lj-breadcrumb">
      <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('jobs.index') }}">Find Jobs</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>{{ $job->title }}</span>
    </div>

    {{-- Job Header Card --}}
    <div class="lj-jd-header-card">
      <div class="lj-jd-header-top">
        <div class="lj-company-logo">
          @if($job->company->logo ?? false)
            <img src="{{ asset('storage/'.$job->company->logo) }}" alt="{{ $job->company->name }}">
          @else
            <i class="fa-solid fa-building"></i>
          @endif
        </div>
        <div class="lj-jd-header-info">
          <div class="lj-jd-badge-row">
            @if($job->is_urgent ?? false)
              <span class="lj-jd-badge urgent">Urgently Hiring</span>
            @endif
            @if($job->created_at->diffInDays() <= 1)
              <span class="lj-jd-badge new">New Today</span>
            @endif
            @if(($job->openings ?? 1) > 1)
              <span class="lj-jd-badge hiring">{{ $job->openings }} Openings</span>
            @endif
          </div>
          <h1 class="lj-jd-title">{{ $job->title }}</h1>
          <div class="lj-jd-company">
            {{ $job->company->name ?? $job->company_name }}
            @if($job->company->is_verified ?? false)
              <span class="verified"><i class="fa-solid fa-circle-check"></i> Verified</span>
            @endif
          </div>
          <div class="lj-jd-location">
            <i class="fa-solid fa-location-dot" style="color:var(--blue);"></i>
            {{ $job->location ?? '—' }}, {{ $job->district ?? '—' }}, {{ $job->state ?? 'Tamil Nadu' }}
          </div>
        </div>
        <div style="text-align:right;flex-shrink:0;">
          <div style="font-size:.72rem;color:var(--n400);margin-bottom:4px;">Posted {{ $job->created_at->diffForHumans() }}</div>
          @if($job->views ?? false)
            <div style="font-size:.72rem;color:var(--n400);display:flex;align-items:center;gap:4px;justify-content:flex-end;">
              <i class="fa-solid fa-eye"></i> {{ number_format($job->views) }} views
            </div>
          @endif
        </div>
      </div>
      <div class="lj-jd-header-meta">
        <div class="lj-jd-meta-item">
          <div class="lj-jd-meta-label">Salary</div>
          <div class="lj-jd-meta-value">
            <i class="fa-solid fa-indian-rupee-sign"></i>
            {{ $job->salary_range ?? ($job->salary_min ? '₹'.number_format($job->salary_min/1000,0).'k – ₹'.number_format($job->salary_max/1000,0).'k/mo' : 'Not disclosed') }}
          </div>
        </div>
        <div class="lj-jd-meta-item">
          <div class="lj-jd-meta-label">Job Type</div>
          <div class="lj-jd-meta-value"><i class="fa-solid fa-clock"></i> {{ $job->job_type ?? '—' }}</div>
        </div>
        <div class="lj-jd-meta-item">
          <div class="lj-jd-meta-label">Experience</div>
          <div class="lj-jd-meta-value"><i class="fa-solid fa-briefcase"></i> {{ $job->experience?? '—' }}</div>
        </div>
        <div class="lj-jd-meta-item">
          <div class="lj-jd-meta-label">Education</div>
          <div class="lj-jd-meta-value"><i class="fa-solid fa-graduation-cap"></i> {{ $job->education ?? '—' }}</div>
        </div>
      </div>
    </div>

    {{-- 2-column layout --}}
    <div class="lj-jd-layout">

      {{-- ── LEFT: Main Content ── --}}
      <div>

        {{-- Job Description --}}
        <div class="lj-jd-card">
          <div class="lj-section-title"><i class="fa-solid fa-file-lines"></i> Job Description</div>
          <div class="lj-jd-desc">{!! nl2br(e($job->description)) !!}</div>
        </div>

        {{-- Responsibilities --}}
        @if($job->responsibilities && count($job->responsibilities) > 0)
          <div class="lj-jd-card">
            <div class="lj-section-title"><i class="fa-solid fa-list-check"></i> Responsibilities</div>
            <ul class="lj-resp-list">
              @foreach($job->responsibilities as $resp)
                <li><span class="bullet"></span>{{ $resp }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Required Skills --}}
                @if($job->skills && count($job->skills) > 0)
            <div class="lj-jd-card">
                <div class="lj-section-title"><i class="fa-solid fa-screwdriver-wrench"></i> Required Skills</div>
                <div class="lj-skill-tags">
                @foreach($job->skills as $skill)
                    <span class="lj-skill-tag">{{ $skill }}</span>
                @endforeach
                </div>
            </div>
            @endif
            
        {{-- Benefits --}}
        @if($job->benefits && count($job->benefits) > 0)
          <div class="lj-jd-card">
            <div class="lj-section-title"><i class="fa-solid fa-gift"></i> Benefits</div>
            @php
            $benefitIcons = [
              'Health Insurance' => 'fa-heart-pulse',
              'Performance Bonus' => 'fa-star',
              'Flexible Work Hours' => 'fa-clock',
              'Provident Fund' => 'fa-piggy-bank',
              'Paid Leave' => 'fa-calendar',
              'Travel Allowance' => 'fa-car',
              'Gratuity' => 'fa-hand-holding-dollar',
              'Training' => 'fa-graduation-cap',
            ];
            @endphp
            <div class="lj-benefit-grid">
              @foreach($job->benefits as $benefit)
                <div class="lj-benefit-item">
                  <i class="fa-solid {{ $benefitIcons[$benefit] ?? 'fa-check-circle' }}"></i>
                  <span class="lj-benefit-text">{{ $benefit }}</span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Mobile Apply Button --}}
        <div style="display:none;" class="lj-mobile-apply">
          @auth
            <a href="{{ route('jobs.apply', $job->id) }}" class="lj-apply-main-btn" style="text-decoration:none;">
              <i class="fa-solid fa-paper-plane"></i> Apply Now
            </a>
          @else
            <a href="{{ route('jobseeker.login') }}?redirect={{ url()->current() }}" class="lj-apply-main-btn" style="text-decoration:none;">
              <i class="fa-solid fa-right-to-bracket"></i> Login to Apply
            </a>
          @endauth
        </div>

      </div>

      {{-- ── RIGHT: Sidebar ── --}}
      <div class="lj-jd-sidebar">

        {{-- Apply Card --}}
        <div class="lj-apply-card">
          <div class="lj-apply-card-title"><i class="fa-solid fa-paper-plane"></i> Ready to Apply?</div>
          @auth
            <a href="{{ route('jobs.apply', $job->id) }}" class="lj-apply-main-btn">
              <i class="fa-solid fa-paper-plane"></i> Apply Now
            </a>
          @else
            <a href="{{ route('jobseeker.login') }}?redirect={{ url()->current() }}" class="lj-apply-main-btn">
              <i class="fa-solid fa-right-to-bracket"></i> Login to Apply
            </a>
          @endauth
          <button class="lj-save-main-btn" onclick="toggleSaveJob(this, {{ $job->id }})" data-jobid="{{ $job->id }}">
            <i class="fa-regular fa-bookmark"></i> Save Job
          </button>
          <div class="lj-deadline-note">
            <i class="fa-solid fa-clock"></i>
           @if($job->expiry_date)
    Closes {{ $job->expiry_date->diffForHumans() }}
            @else
              Apply as soon as possible
            @endif
          </div>
          <div class="lj-share-row">
            <a href="https://wa.me/?text={{ urlencode($job->title.' at '.$job->company_name.' – '.url()->current()) }}" target="_blank" class="lj-share-btn">
              <i class="fa-brands fa-whatsapp" style="color:#25d366;"></i> Share
            </a>
            <button onclick="copyLink()" class="lj-share-btn">
              <i class="fa-solid fa-link"></i> Copy Link
            </button>
          </div>
        </div>

        {{-- Company Info --}}
        <div class="lj-company-card">
          <div class="lj-section-title" style="margin-bottom:14px;font-size:.72rem;"><i class="fa-solid fa-building" style="color:var(--blue);font-size:.75rem;"></i> About the Company</div>
          <div class="lj-company-card-head">
            <div class="lj-co-logo-sm">
              @if($job->company->logo ?? false)
                <img src="{{ asset('storage/'.$job->company->logo) }}" alt="{{ $job->company->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:9px;">
              @else
                <i class="fa-solid fa-building"></i>
              @endif
            </div>
            <div>
              <div class="lj-co-name">{{ $job->company->name ?? $job->company_name }}</div>
              <div class="lj-co-location"><i class="fa-solid fa-location-dot" style="font-size:.65rem;color:var(--blue);"></i> {{ $job->district }}, Tamil Nadu</div>
            </div>
          </div>
          @if($job->company->industry ?? false)
            <div class="lj-co-detail-row"><i class="fa-solid fa-industry"></i> {{ $job->company->industry }}</div>
          @endif
          @if($job->company->size ?? false)
            <div class="lj-co-detail-row"><i class="fa-solid fa-users"></i> {{ $job->company->size }} employees</div>
          @endif
          @if($job->company->website ?? false)
            <div class="lj-co-detail-row"><i class="fa-solid fa-globe"></i> <a href="{{ $job->company->website }}" target="_blank" style="color:var(--blue);text-decoration:none;font-size:.82rem;">{{ $job->company->website }}</a></div>
          @endif
          @if($job->company->is_verified ?? false)
            <div style="display:flex;align-items:center;gap:6px;margin-top:10px;font-size:.75rem;font-weight:700;color:#1d4ed8;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:8px;padding:7px 12px;">
              <i class="fa-solid fa-shield-halved"></i> GST & PAN Verified Employer
            </div>
          @endif
        </div>

        {{-- Quick Stats --}}
        <div class="lj-info-card">
          <div class="lj-info-card-title">Open Positions at this Company</div>
          <div class="lj-info-card-val">{{ $company_jobs_count ?? '—' }}</div>
          <div class="lj-info-card-sub">Active job openings right now</div>
          <a href="{{ route('jobs.index', ['company' => $job->company_id ?? '']) }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:.78rem;font-weight:700;color:rgba(255,255,255,.85);text-decoration:none;">
            View all jobs <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>

      </div>
    </div>

    {{-- Related Jobs --}}
    @if(isset($relatedJobs) && count($relatedJobs) > 0)
      <div class="lj-jd-card" style="margin-top:0;">
        <div class="lj-section-title"><i class="fa-solid fa-briefcase"></i> Similar Jobs You Might Like</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          @foreach($relatedJobs as $rj)
            <a href="{{ route('jobs.show', $rj->id) }}" style="text-decoration:none;">
              <div class="lj-related-job" style="padding:12px;border:1.5px solid var(--n100);border-radius:10px;border-bottom:1.5px solid var(--n100);">
                <div class="lj-related-logo"><i class="fa-solid fa-building" style="font-size:.75rem;"></i></div>
                <div>
                  <div class="lj-related-title">{{ $rj->title }}</div>
                  <div class="lj-related-company">{{ $rj->company_name }} · {{ $rj->district }}</div>
                  <div class="lj-related-tags">
                    @if($rj->job_type)<span class="lj-related-tag">{{ $rj->job_type }}</span>@endif
                    @if($rj->salary_range)<span class="lj-related-tag">{{ $rj->salary_range }}</span>@endif
                  </div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</div>

{{-- Scroll to top --}}
<button class="lj-scroll-top" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="fa-solid fa-chevron-up"></i>
</button>

@endsection

@push('scripts')
<script>
   $(document).ready(function() {
    $.ajax({
        url: "{{ route('jobseeker.jobs.getSaved') }}", // Endpoint that returns saved jobs IDs
        type: "GET",
        success: function(response) {
            // response.savedJobs should be an array of saved job IDs
            response.savedJobs.forEach(jobId => {
                const btn = document.querySelector(`button[data-jobid='${jobId}']`);
                if(btn){
                    const ico = btn.querySelector('i');
                    ico.classList.replace('fa-regular', 'fa-solid');
                    btn.style.borderColor = 'var(--blue)';
                    btn.style.color = 'var(--blue)';
                    btn.innerHTML = '<i class="fa-solid fa-bookmark"></i> Saved';
                }
            });
        },
        error: function() {
            console.log('Failed to load saved jobs');
        }
    });
  });
function toggleSaveJob(btn, jobId) {
    const ico = btn.querySelector('i');
    
    $.ajax({
        url: "{{ route('jobseeker.jobs.toggleSave') }}", // Route to save/unsave job
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            job_id: jobId
        },
        success: function(response) {
            if(response.savestatus == 1){ // Job is now saved
                ico.classList.replace('fa-regular', 'fa-solid');
                btn.style.borderColor = 'var(--blue)';
                btn.style.color = 'var(--blue)';
                btn.innerHTML = '<i class="fa-solid fa-bookmark"></i> Saved';
            } else { // Job is now unsaved
                ico.classList.replace('fa-solid', 'fa-regular');
                btn.style.borderColor = '';
                btn.style.color = '';
                btn.innerHTML = '<i class="fa-regular fa-bookmark"></i> Save Job';
            }

            // Optional: show a toast message instead of alert
            if(response.message){
                showToast(response.message);
            }
        },
        error: function() {
            console.log('Something went wrong. Please try again.');
        }
    });
}
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
function copyLink() {
  navigator.clipboard.writeText(window.location.href);
  const btn = event.currentTarget;
  btn.innerHTML = '<i class="fa-solid fa-check" style="color:var(--green);"></i> Copied!';
  setTimeout(() => btn.innerHTML = '<i class="fa-solid fa-link"></i> Copy Link', 2000);
}

// Scroll to top button
window.addEventListener('scroll', function() {
  const btn = document.getElementById('scrollTopBtn');
  if (window.scrollY > 300) btn.classList.add('show');
  else btn.classList.remove('show');
});

// Mobile apply button show
if (window.innerWidth <= 900) {
  document.querySelector('.lj-mobile-apply').style.display = 'block';
}
</script>
@endpush