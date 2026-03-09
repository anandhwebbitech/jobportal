{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/pricing.blade.php
     Pricing Page – LinearJobs
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Pricing – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* ── PAGE ─────────────────────────────────────────── */
.lj-pricing-page{background:var(--n50);min-height:calc(100vh - 64px);padding:60px 20px 80px;}
.lj-pricing-wrap{max-width:1000px;margin:0 auto;}

/* ── HERO ─────────────────────────────────────────── */
.lj-pricing-hero{text-align:center;margin-bottom:56px;}
.lj-pricing-badge{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,rgba(26,86,219,.08),rgba(30,58,138,.12));border:1.5px solid rgba(26,86,219,.18);border-radius:100px;padding:6px 16px;font-size:.78rem;font-weight:700;color:var(--blue);letter-spacing:.04em;text-transform:uppercase;margin-bottom:18px;}
.lj-pricing-badge i{font-size:.75rem;}
.lj-pricing-title{font-size:2.2rem;font-weight:900;color:var(--n900);letter-spacing:-.7px;margin-bottom:14px;line-height:1.15;}
.lj-pricing-title span{background:linear-gradient(135deg,#1a56db,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.lj-pricing-sub{font-size:.95rem;color:var(--n500);line-height:1.7;max-width:520px;margin:0 auto 28px;}
.lj-gst-note{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1.5px solid var(--n200);border-radius:var(--r);padding:8px 16px;font-size:.8rem;color:var(--n600);font-weight:500;}
.lj-gst-note i{color:var(--n400);}

/* ── PLAN GRID ────────────────────────────────────── */
.lj-plan-grid{display:grid;grid-template-columns:1fr 1fr;gap:28px;margin-bottom:52px;}

/* ── PLAN CARD ────────────────────────────────────── */
.lj-plan-card{background:#fff;border:2px solid var(--n200);border-radius:20px;overflow:hidden;position:relative;transition:transform .25s,box-shadow .25s;}
.lj-plan-card:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(0,0,0,.09);}
.lj-plan-card.featured{border-color:var(--blue);box-shadow:0 8px 32px rgba(26,86,219,.15);}
.lj-plan-popular{position:absolute;top:20px;right:20px;background:linear-gradient(135deg,#1a56db,#7c3aed);color:#fff;font-size:.68rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;padding:4px 12px;border-radius:100px;}
.lj-plan-header{padding:32px 32px 0;}
.lj-plan-ico{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:16px;}
.lj-plan-ico.basic{background:linear-gradient(135deg,#e0f2fe,#bfdbfe);color:#1d4ed8;}
.lj-plan-ico.standard{background:linear-gradient(135deg,#ede9fe,#ddd6fe);color:#7c3aed;}
.lj-plan-name{font-size:.8rem;font-weight:800;color:var(--n400);letter-spacing:.08em;text-transform:uppercase;margin-bottom:6px;}
.lj-plan-price{display:flex;align-items:flex-end;gap:4px;margin-bottom:4px;}
.lj-plan-currency{font-size:1.4rem;font-weight:800;color:var(--n700);line-height:1.1;margin-bottom:4px;}
.lj-plan-amount{font-size:3rem;font-weight:900;color:var(--n900);line-height:1;letter-spacing:-2px;}
.lj-plan-card.featured .lj-plan-amount{color:var(--blue);}
.lj-plan-gst{font-size:.78rem;color:var(--n400);margin-bottom:2px;line-height:1;align-self:flex-end;padding-bottom:8px;}
.lj-plan-validity{display:inline-flex;align-items:center;gap:6px;background:var(--n50);border:1.5px solid var(--n100);border-radius:100px;padding:4px 12px;font-size:.75rem;font-weight:700;color:var(--n600);margin-bottom:24px;}
.lj-plan-card.featured .lj-plan-validity{background:rgba(26,86,219,.06);border-color:rgba(26,86,219,.2);color:var(--blue);}
.lj-plan-validity i{color:var(--green);}

/* ── FEATURES ─────────────────────────────────────── */
.lj-plan-divider{height:1px;background:var(--n100);margin:0 32px;}
.lj-plan-features{padding:24px 32px 32px;}
.lj-plan-features-title{font-size:.72rem;font-weight:800;color:var(--n400);letter-spacing:.07em;text-transform:uppercase;margin-bottom:14px;}
.lj-plan-feat-list{list-style:none;padding:0;margin:0 0 28px;}
.lj-plan-feat-list li{display:flex;align-items:flex-start;gap:10px;font-size:.875rem;color:var(--n700);padding:7px 0;border-bottom:1px solid var(--n50);}
.lj-plan-feat-list li:last-child{border-bottom:none;}
.lj-plan-feat-list li i{width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.6rem;flex-shrink:0;margin-top:1px;}
.lj-plan-feat-list li .ico-yes{background:#dcfce7;color:#16a34a;}
.lj-plan-feat-list li .ico-no{background:var(--n100);color:var(--n400);}
.lj-plan-feat-list li.disabled{color:var(--n400);}
.lj-plan-feat-detail{font-size:.75rem;color:var(--n400);display:block;margin-top:1px;}

/* ── BUY BUTTON ───────────────────────────────────── */
.lj-plan-btn{width:100%;border:none;border-radius:12px;font-family:var(--f);font-size:.9375rem;font-weight:700;padding:14px 20px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:all .25s;text-decoration:none;}
.lj-plan-btn.outline{background:#fff;border:2px solid var(--blue);color:var(--blue);}
.lj-plan-btn.outline:hover{background:rgba(26,86,219,.05);transform:translateY(-1px);}
.lj-plan-btn.solid{background:linear-gradient(135deg,#1a56db,#1e3a8a);color:#fff;}
.lj-plan-btn.solid:hover{background:linear-gradient(135deg,#1d4ed8,#1e40af);transform:translateY(-2px);box-shadow:0 6px 20px rgba(26,86,219,.32);}

/* ── COMPARE TABLE ────────────────────────────────── */
.lj-compare-section{margin-bottom:52px;}
.lj-compare-head{text-align:center;margin-bottom:28px;}
.lj-compare-head h2{font-size:1.5rem;font-weight:800;color:var(--n900);letter-spacing:-.4px;margin-bottom:6px;}
.lj-compare-head p{font-size:.88rem;color:var(--n500);}
.lj-compare-table{width:100%;border-collapse:collapse;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.06);}
.lj-compare-table th{padding:16px 20px;text-align:left;font-size:.78rem;font-weight:800;color:var(--n500);letter-spacing:.06em;text-transform:uppercase;background:var(--n50);border-bottom:1.5px solid var(--n100);}
.lj-compare-table th:not(:first-child){text-align:center;}
.lj-compare-table td{padding:14px 20px;font-size:.875rem;color:var(--n700);border-bottom:1px solid var(--n50);}
.lj-compare-table td:not(:first-child){text-align:center;font-weight:600;}
.lj-compare-table tr:last-child td{border-bottom:none;}
.lj-compare-table tr:hover td{background:rgba(26,86,219,.02);}
.lj-compare-table td .check{color:#16a34a;font-size:.9rem;}
.lj-compare-table td .cross{color:var(--n300);font-size:.9rem;}
.lj-tbl-highlight{background:rgba(26,86,219,.04) !important;}

/* ── FAQ ──────────────────────────────────────────── */
.lj-faq-section{margin-bottom:52px;}
.lj-faq-head{text-align:center;margin-bottom:28px;}
.lj-faq-head h2{font-size:1.5rem;font-weight:800;color:var(--n900);letter-spacing:-.4px;margin-bottom:6px;}
.lj-faq-head p{font-size:.88rem;color:var(--n500);}
.lj-faq-list{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.lj-faq-item{background:#fff;border:1.5px solid var(--n200);border-radius:var(--r-lg);overflow:hidden;}
.lj-faq-q{padding:16px 20px;font-size:.875rem;font-weight:700;color:var(--n800);cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:background .2s;}
.lj-faq-q:hover{background:var(--n50);}
.lj-faq-q i{color:var(--n400);font-size:.8rem;transition:transform .25s;flex-shrink:0;}
.lj-faq-item.open .lj-faq-q i{transform:rotate(180deg);color:var(--blue);}
.lj-faq-item.open .lj-faq-q{color:var(--blue);}
.lj-faq-a{max-height:0;overflow:hidden;transition:max-height .3s ease;}
.lj-faq-item.open .lj-faq-a{max-height:200px;}
.lj-faq-a-inner{padding:0 20px 16px;font-size:.84rem;color:var(--n600);line-height:1.65;border-top:1px solid var(--n100);}

/* ── CTA BANNER ───────────────────────────────────── */
.lj-cta-banner{background:linear-gradient(135deg,#1a56db 0%,#1e3a8a 100%);border-radius:20px;padding:48px 40px;text-align:center;position:relative;overflow:hidden;}
.lj-cta-banner::before{content:'';position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05);}
.lj-cta-banner::after{content:'';position:absolute;bottom:-60px;left:-30px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,.04);}
.lj-cta-title{font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:10px;letter-spacing:-.4px;position:relative;z-index:1;}
.lj-cta-sub{font-size:.9rem;color:rgba(255,255,255,.75);margin-bottom:28px;position:relative;z-index:1;}
.lj-cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1;}
.lj-cta-btn-primary{background:#fff;color:var(--blue);border:none;border-radius:10px;font-family:var(--f);font-size:.9rem;font-weight:700;padding:12px 26px;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .25s;text-decoration:none;}
.lj-cta-btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.2);}
.lj-cta-btn-outline{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.4);border-radius:10px;font-family:var(--f);font-size:.9rem;font-weight:700;padding:12px 26px;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all .25s;text-decoration:none;}
.lj-cta-btn-outline:hover{border-color:rgba(255,255,255,.8);background:rgba(255,255,255,.08);}

@media(max-width:720px){
  .lj-plan-grid{grid-template-columns:1fr;}
  .lj-faq-list{grid-template-columns:1fr;}
  .lj-pricing-title{font-size:1.6rem;}
  .lj-cta-banner{padding:32px 20px;}
  .lj-plan-header,.lj-plan-features{padding-left:20px;padding-right:20px;}
  .lj-plan-divider{margin:0 20px;}
  .lj-compare-table{font-size:.8rem;}
  .lj-compare-table th,.lj-compare-table td{padding:12px 10px;}
}
</style>
@endpush

@section('content')
<div class="lj-pricing-page">
  <div class="lj-pricing-wrap">

    {{-- Hero --}}
    <div class="lj-pricing-hero">
      <div class="lj-pricing-badge"><i class="fa-solid fa-tag"></i> Simple, Transparent Pricing</div>
      <h1 class="lj-pricing-title">Hire Talent at <span>Affordable Prices</span></h1>
      <p class="lj-pricing-sub">No hidden charges. No subscriptions. Pay only for the plan you need and start hiring immediately.</p>
      <div class="lj-gst-note"><i class="fa-solid fa-circle-info"></i> All prices are exclusive of GST (18%)</div>
    </div>

    {{-- Plan Cards --}}
    <div class="lj-plan-grid">

      {{-- Plan 1: 15 Day --}}
      <div class="lj-plan-card">
        <div class="lj-plan-header">
          <div class="lj-plan-ico basic"><i class="fa-solid fa-bolt"></i></div>
          <div class="lj-plan-name">15 Day Plan</div>
          <div class="lj-plan-price">
            <div class="lj-plan-currency">₹</div>
            <div class="lj-plan-amount">600</div>
            <div class="lj-plan-gst">+ GST</div>
          </div>
          <div class="lj-plan-validity">
            <i class="fa-solid fa-calendar-check"></i> Valid for 15 Days
          </div>
        </div>
        <div class="lj-plan-divider"></div>
        <div class="lj-plan-features">
          <div class="lj-plan-features-title">What's included</div>
          <ul class="lj-plan-feat-list">
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Post 1 Job Opening
                <span class="lj-plan-feat-detail">Single active job listing</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Valid for 15 Days
                <span class="lj-plan-feat-detail">Job visible to seekers for 15 days</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Applicant Management
                <span class="lj-plan-feat-detail">View and manage applications</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Email Notifications
                <span class="lj-plan-feat-detail">Alerts on new applications</span>
              </div>
            </li>
            <li class="disabled">
              <i class="fa-solid fa-xmark ico-no"></i>
              <div>Featured Listing</div>
            </li>
            <li class="disabled">
              <i class="fa-solid fa-xmark ico-no"></i>
              <div>Priority Support</div>
            </li>
          </ul>
          <a href="{{ route('employer.login') }}" class="lj-plan-btn outline">
            <i class="fa-solid fa-bolt"></i> Buy 15 Day Plan
          </a>
        </div>
      </div>

      {{-- Plan 2: 30 Day --}}
      <div class="lj-plan-card featured">
        <div class="lj-plan-popular">Most Popular</div>
        <div class="lj-plan-header">
          <div class="lj-plan-ico standard"><i class="fa-solid fa-crown"></i></div>
          <div class="lj-plan-name">30 Day Plan</div>
          <div class="lj-plan-price">
            <div class="lj-plan-currency">₹</div>
            <div class="lj-plan-amount">1000</div>
            <div class="lj-plan-gst">+ GST</div>
          </div>
          <div class="lj-plan-validity">
            <i class="fa-solid fa-calendar-check"></i> Valid for 30 Days
          </div>
        </div>
        <div class="lj-plan-divider"></div>
        <div class="lj-plan-features">
          <div class="lj-plan-features-title">What's included</div>
          <ul class="lj-plan-feat-list">
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Post 1 Job Opening
                <span class="lj-plan-feat-detail">Single active job listing</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Valid for 30 Days
                <span class="lj-plan-feat-detail">Job visible to seekers for 30 days</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Applicant Management
                <span class="lj-plan-feat-detail">View and manage applications</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Email Notifications
                <span class="lj-plan-feat-detail">Alerts on new applications</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Featured Listing
                <span class="lj-plan-feat-detail">Highlighted on Find Jobs page</span>
              </div>
            </li>
            <li>
              <i class="fa-solid fa-check ico-yes"></i>
              <div>
                Priority Support
                <span class="lj-plan-feat-detail">Dedicated support via email & phone</span>
              </div>
            </li>
          </ul>
          <a href="{{ route('employer.login') }}" class="lj-plan-btn solid">
            <i class="fa-solid fa-crown"></i> Buy 30 Day Plan
          </a>
        </div>
      </div>

    </div>

    {{-- Compare Table --}}
    <div class="lj-compare-section">
      <div class="lj-compare-head">
        <h2>Plan Comparison</h2>
        <p>See exactly what you get with each plan</p>
      </div>
      <table class="lj-compare-table">
        <thead>
          <tr>
            <th style="width:50%;">Feature</th>
            <th>15 Day Plan<br><span style="font-size:.7rem;font-weight:600;color:var(--n500);">₹600 + GST</span></th>
            <th class="lj-tbl-highlight">30 Day Plan<br><span style="font-size:.7rem;font-weight:600;color:var(--blue);">₹1000 + GST</span></th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Job Postings</td><td>1</td><td class="lj-tbl-highlight">1</td></tr>
          <tr><td>Listing Duration</td><td>15 Days</td><td class="lj-tbl-highlight">30 Days</td></tr>
          <tr><td>Applicant Management</td><td><i class="fa-solid fa-check check"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
          <tr><td>Email Notifications</td><td><i class="fa-solid fa-check check"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
          <tr><td>Employer Dashboard</td><td><i class="fa-solid fa-check check"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
          <tr><td>Featured Listing</td><td><i class="fa-solid fa-xmark cross"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
          <tr><td>Priority Support</td><td><i class="fa-solid fa-xmark cross"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
          <tr><td>Tamil Nadu Focused Reach</td><td><i class="fa-solid fa-check check"></i></td><td class="lj-tbl-highlight"><i class="fa-solid fa-check check"></i></td></tr>
        </tbody>
      </table>
    </div>

    {{-- FAQ --}}
    <div class="lj-faq-section">
      <div class="lj-faq-head">
        <h2>Frequently Asked Questions</h2>
        <p>Everything you need to know about our pricing</p>
      </div>
      <div class="lj-faq-list">
        @php
        $faqs = [
          ['q'=>'What happens after my plan expires?','a'=>'Your job listing will be automatically taken down once the plan validity period ends. You can renew by purchasing a new plan from your employer dashboard.'],
          ['q'=>'Is GST applicable on the plan price?','a'=>'Yes, GST at 18% is applicable on all plan purchases. The prices shown (₹600 and ₹1000) are exclusive of GST. The final amount will be shown at checkout.'],
          ['q'=>'Can I post multiple jobs in one plan?','a'=>'Currently each plan supports 1 active job posting. If you need to post multiple jobs, you can purchase multiple plans — one for each job opening.'],
          ['q'=>'How do I pay for a plan?','a'=>'We accept UPI, Net Banking, Debit/Credit Cards, and other popular payment methods. Payments are processed securely.'],
          ['q'=>'Do job seekers pay to apply?','a'=>'Absolutely not. LinearJobs is 100% free for job seekers. There are no charges for browsing jobs or applying.'],
          ['q'=>'Can I get a refund if I change my mind?','a'=>'Refunds are not available once a plan is activated. Please review the plan details carefully before purchasing.'],
        ];
        @endphp
        @foreach($faqs as $i => $faq)
          <div class="lj-faq-item" id="faq-{{ $i }}">
            <div class="lj-faq-q" onclick="toggleFaq({{ $i }})">
              {{ $faq['q'] }}
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="lj-faq-a">
              <div class="lj-faq-a-inner">{{ $faq['a'] }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- CTA Banner --}}
    <div class="lj-cta-banner">
      <div class="lj-cta-title">Ready to Hire Top Talent in Tamil Nadu?</div>
      <div class="lj-cta-sub">Register your company today and post your first job within minutes.</div>
      <div class="lj-cta-btns">
        <a href="{{ route('employer.register') }}" class="lj-cta-btn-primary">
          <i class="fa-solid fa-building-flag"></i> Register Company
        </a>
        <a href="{{ route('contact') }}" class="lj-cta-btn-outline">
          <i class="fa-solid fa-phone"></i> Talk to Us
        </a>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFaq(i) {
  const item = document.getElementById('faq-' + i);
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.lj-faq-item.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
</script>
@endpush