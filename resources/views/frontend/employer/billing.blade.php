{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/billing.blade.php
     LinearJobs – Billing / Plans Module
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Billing / Plans')
@section('breadcrumb','Billing / Plans')
@php $activeNav = 'billing'; @endphp

@push('styles')
<style>
/* Plan cards */
.plan-cards{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;}
@media(max-width:640px){.plan-cards{grid-template-columns:1fr;}}

.plan-card{
  border:2px solid var(--gray-200);border-radius:16px;padding:24px;
  position:relative;overflow:hidden;cursor:pointer;transition:all .25s;background:#fff;
}
.plan-card:hover{border-color:var(--blue);transform:translateY(-3px);box-shadow:0 8px 30px rgba(26,86,219,.15);}
.plan-card.selected{border-color:var(--blue);background:linear-gradient(145deg,#f0f7ff,#fff);}
.plan-card input[type="radio"]{display:none;}
.plan-popular{
  position:absolute;top:0;left:0;
  background:var(--gradient);
  color:#fff;font-size:.6rem;font-weight:800;letter-spacing:.06em;
  text-transform:uppercase;padding:4px 14px;border-radius:0 0 9px 0;
}
.plan-check{
  position:absolute;top:14px;right:14px;
  width:24px;height:24px;border-radius:50%;
  background:var(--gradient);color:#fff;
  display:flex;align-items:center;justify-content:center;
  font-size:.6rem;opacity:0;transform:scale(.5);
  transition:all .25s;
}
.plan-card.selected .plan-check{opacity:1;transform:scale(1);}
.plan-ico{
  width:52px;height:52px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;font-size:1.3rem;
  margin-bottom:14px;
}
.plan-ico.basic{background:var(--blue-light);color:var(--blue);}
.plan-ico.pro{background:rgba(124,58,237,.1);color:#7c3aed;}
.plan-badge{font-size:.68rem;font-weight:800;color:var(--gray-400);letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px;}
.plan-price{font-size:2rem;font-weight:900;color:var(--gray-900);letter-spacing:-1px;line-height:1;}
.plan-price sup{font-size:1rem;vertical-align:super;}
.plan-price span{font-size:.8rem;font-weight:500;color:var(--gray-400);}
.plan-validity{
  display:inline-flex;align-items:center;gap:5px;
  background:var(--gray-100);border-radius:100px;
  padding:4px 12px;font-size:.73rem;font-weight:700;color:var(--gray-700);
  margin:10px 0;
}
.plan-card.selected .plan-validity{background:var(--blue-light);color:var(--blue);}
.plan-features{list-style:none;margin:0;padding:0;}
.plan-features li{display:flex;align-items:center;gap:7px;font-size:.78rem;color:var(--gray-600);padding:4px 0;}
.plan-features li i{color:var(--green);font-size:.7rem;flex-shrink:0;}

/* Current plan info card */
.current-plan-card{
  background:var(--gradient);border-radius:16px;padding:26px;
  display:grid;grid-template-columns:1fr auto;gap:20px;align-items:center;
  margin-bottom:24px;position:relative;overflow:hidden;
}
.current-plan-card::before{
  content:'';position:absolute;top:-40px;right:-40px;
  width:180px;height:180px;border-radius:50%;
  background:rgba(255,255,255,.07);pointer-events:none;
}
.cpc-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
  border-radius:100px;padding:4px 12px;
  font-size:.68rem;font-weight:700;color:rgba(255,255,255,.9);
  letter-spacing:.04em;text-transform:uppercase;margin-bottom:8px;
}
.cpc-title{font-size:1.3rem;font-weight:900;color:#fff;letter-spacing:-.3px;}
.cpc-meta{font-size:.8rem;color:rgba(255,255,255,.75);margin-top:4px;}
.cpc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:16px;}
@media(max-width:600px){.cpc-grid{grid-template-columns:1fr 1fr;}}
.cpc-stat{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);border-radius:10px;padding:12px 14px;}
.cpc-stat-val{font-size:1.1rem;font-weight:900;color:#fff;letter-spacing:-.3px;}
.cpc-stat-lbl{font-size:.67rem;color:rgba(255,255,255,.65);margin-top:3px;}
.cpc-actions{display:flex;flex-direction:column;gap:8px;align-items:flex-end;position:relative;z-index:1;}
.btn-white{background:#fff;color:var(--blue);border:none;border-radius:9px;padding:10px 20px;font-size:.84rem;font-weight:700;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:7px;}
.btn-white:hover{background:rgba(255,255,255,.92);transform:translateY(-1px);}
.btn-white-ghost{background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.3);border-radius:9px;padding:9px 18px;font-size:.82rem;font-weight:700;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:7px;}
.btn-white-ghost:hover{background:rgba(255,255,255,.22);}

/* Invoice table */
.invoice-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:100px;font-size:.68rem;font-weight:700;}

/* GST note */
.gst-row{
  display:flex;align-items:center;gap:8px;
  background:#fefce8;border:1.5px solid #fde68a;
  border-radius:9px;padding:10px 14px;
  font-size:.8rem;color:#92400e;margin-top:14px;
}
</style>
@endpush

@section('content')

<div class="page-hdr">
  <div class="page-hdr-left">
    <div class="page-title">Billing / Plans</div>
    <div class="page-sub">Manage your subscription plan, payments and invoices</div>
  </div>
</div>

{{-- Current Plan Hero --}}
<div class="current-plan-card">
  <div style="position:relative;z-index:1;">
    <div class="cpc-badge"><i class="fas fa-bolt"></i> Active Plan</div>
    <div class="cpc-title">30 Days Plan – Premium</div>
    <div class="cpc-meta">Payment ID: pay_OsK89AbCdEfGh12 &nbsp;·&nbsp; Invoice: #INV-2025-031</div>
    <div class="cpc-grid">
      <div class="cpc-stat"><div class="cpc-stat-val">₹1,180</div><div class="cpc-stat-lbl">Total Paid (incl. GST)</div></div>
      <div class="cpc-stat"><div class="cpc-stat-val">11 Mar</div><div class="cpc-stat-lbl">Plan Start Date</div></div>
      <div class="cpc-stat"><div class="cpc-stat-val">10 Apr</div><div class="cpc-stat-lbl">Plan Expiry Date</div></div>
    </div>
  </div>
  <div class="cpc-actions">
    <button class="btn-white"><i class="fas fa-rotate-right"></i> Renew Plan</button>
    <button class="btn-white-ghost"><i class="fas fa-file-invoice"></i> Download Invoice</button>
  </div>
</div>

{{-- Plan Details Grid --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
  @php $details=[
    ['lbl'=>'Plan Name',   'val'=>'30 Days Plan',     'ico'=>'fa-tag',            'col'=>'var(--blue)'],
    ['lbl'=>'Plan Price',  'val'=>'₹1,000',           'ico'=>'fa-indian-rupee-sign','col'=>'var(--gray-600)'],
    ['lbl'=>'GST (18%)',   'val'=>'₹180',             'ico'=>'fa-receipt',        'col'=>'var(--amber)'],
    ['lbl'=>'Total Paid',  'val'=>'₹1,180',           'ico'=>'fa-wallet',         'col'=>'var(--green)'],
    ['lbl'=>'Start Date',  'val'=>'11 Mar 2025',      'ico'=>'fa-calendar-check', 'col'=>'var(--green)'],
    ['lbl'=>'Expiry Date', 'val'=>'10 Apr 2025',      'ico'=>'fa-calendar-xmark', 'col'=>'var(--red)'],
    ['lbl'=>'Status',      'val'=>'Active',           'ico'=>'fa-circle-check',   'col'=>'var(--green)'],
    ['lbl'=>'Plan Type',   'val'=>'Premium',          'ico'=>'fa-crown',          'col'=>'#7c3aed'],
  ]; @endphp
  @foreach($details as $d)
  <div class="emp-card" style="padding:16px;display:flex;align-items:center;gap:12px;">
    <div style="width:36px;height:36px;border-radius:9px;background:var(--gray-100);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:{{ $d['col'] }};flex-shrink:0;">
      <i class="fas {{ $d['ico'] }}"></i>
    </div>
    <div>
      <div style="font-size:.65rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;">{{ $d['lbl'] }}</div>
      <div style="font-size:.9rem;font-weight:800;color:var(--gray-900);margin-top:2px;">{{ $d['val'] }}</div>
    </div>
  </div>
  @endforeach
</div>

{{-- Purchase / Renew Section --}}
<div class="emp-card" style="margin-bottom:24px;">
  <div class="emp-card-head">
    <div class="emp-card-head-ico"><i class="fas fa-tag"></i></div>
    <div>
      <div class="emp-card-head-title">Purchase / Renew Plan</div>
      <div class="emp-card-head-sub">Choose a plan to post jobs and access features</div>
    </div>
  </div>
  <div class="emp-card-body">
    <div class="plan-cards">

      <div class="plan-card" id="plan15Card" onclick="selectPlan('15_day')">
        <input type="radio" name="plan_id" id="plan15" value="15_day"/>
        <div class="plan-check"><i class="fas fa-check" style="font-size:.5rem;"></i></div>
        <div class="plan-ico basic"><i class="fas fa-bolt"></i></div>
        <div class="plan-badge">15 Day Plan</div>
        <div class="plan-price"><sup>₹</sup>600 <span>+ GST</span></div>
        <div class="plan-validity"><i class="fas fa-calendar-check" style="color:var(--green);"></i> Valid for 15 Days</div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> Post 1 Job Opening</li>
          <li><i class="fas fa-check"></i> Applicant Management</li>
          <li><i class="fas fa-check"></i> Email Notifications</li>
          <li><i class="fas fa-check"></i> Tamil Nadu Reach</li>
          <li><i class="fas fa-check"></i> 10 Resume Downloads</li>
        </ul>
      </div>

      <div class="plan-card selected" id="plan30Card" onclick="selectPlan('30_day')">
        <div class="plan-popular">Most Popular</div>
        <input type="radio" name="plan_id" id="plan30" value="30_day" checked/>
        <div class="plan-check"><i class="fas fa-check" style="font-size:.5rem;"></i></div>
        <div class="plan-ico pro"><i class="fas fa-crown"></i></div>
        <div class="plan-badge">30 Day Plan</div>
        <div class="plan-price"><sup>₹</sup>1,000 <span>+ GST</span></div>
        <div class="plan-validity"><i class="fas fa-calendar-check" style="color:var(--green);"></i> Valid for 30 Days</div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> Post 1 Job Opening</li>
          <li><i class="fas fa-check"></i> Applicant Management</li>
          <li><i class="fas fa-check"></i> Email Notifications</li>
          <li><i class="fas fa-check"></i> Featured Listing</li>
          <li><i class="fas fa-check"></i> 30 Resume Downloads</li>
          <li><i class="fas fa-check"></i> Priority Support</li>
        </ul>
      </div>

    </div>

    <div class="gst-row"><i class="fas fa-circle-info" style="color:#92400e;"></i> All prices are exclusive of GST (18%). Final amount: ₹600 → ₹708 | ₹1,000 → ₹1,180</div>

    <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap;">
      <button class="btn-primary" onclick="buyPlan()"><i class="fas fa-bolt"></i> Buy Plan</button>
      <button class="btn-outline" onclick="renewPlan()"><i class="fas fa-rotate-right"></i> Renew Plan</button>
    </div>
  </div>
</div>

{{-- Invoice History --}}
<div class="emp-card">
  <div class="emp-card-head">
    <div class="emp-card-head-ico"><i class="fas fa-file-invoice"></i></div>
    <div>
      <div class="emp-card-head-title">Invoice History</div>
      <div class="emp-card-head-sub">All past transactions and invoices</div>
    </div>
  </div>
  <div class="emp-card-body" style="padding:0;">
    <div class="emp-table-wrap">
      <table class="emp-table">
        <thead>
          <tr>
            <th>Invoice</th><th>Plan</th><th>Amount</th><th>GST</th><th>Total</th><th>Payment ID</th><th>Date</th><th>Status</th><th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $invoices=[
            ['inv'=>'#INV-2025-031','plan'=>'30 Days Plan','amt'=>'₹1,000','gst'=>'₹180','total'=>'₹1,180','pid'=>'pay_OsK89AbCdEf','date'=>'11 Mar 2025','status'=>'Paid'],
            ['inv'=>'#INV-2025-002','plan'=>'15 Days Plan','amt'=>'₹600',  'gst'=>'₹108','total'=>'₹708',  'pid'=>'pay_NpJ72XyZwVu','date'=>'10 Feb 2025','status'=>'Paid'],
            ['inv'=>'#INV-2024-089','plan'=>'30 Days Plan','amt'=>'₹1,000','gst'=>'₹180','total'=>'₹1,180','pid'=>'pay_MkL58AbCfGh','date'=>'15 Jan 2025','status'=>'Paid'],
          ]; @endphp
          @foreach($invoices as $inv)
          <tr>
            <td><strong>{{ $inv['inv'] }}</strong></td>
            <td>{{ $inv['plan'] }}</td>
            <td>{{ $inv['amt'] }}</td>
            <td style="color:var(--amber);">{{ $inv['gst'] }}</td>
            <td><strong style="color:var(--green);">{{ $inv['total'] }}</strong></td>
            <td style="font-family:monospace;font-size:.75rem;">{{ $inv['pid'] }}</td>
            <td>{{ $inv['date'] }}</td>
            <td><span class="badge badge-green"><i class="fas fa-check"></i> {{ $inv['status'] }}</span></td>
            <td>
              <a href="#" class="btn-outline btn-sm"><i class="fas fa-download"></i> Invoice</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function selectPlan(plan) {
  document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
  if(plan === '15_day') { document.getElementById('plan15Card').classList.add('selected'); document.getElementById('plan15').checked = true; }
  else { document.getElementById('plan30Card').classList.add('selected'); document.getElementById('plan30').checked = true; }
}
function buyPlan() {
  var selected = document.querySelector('input[name="plan_id"]:checked');
  if(!selected) return alert('Please select a plan');
  var name = selected.value === '15_day' ? '15 Days Plan – ₹708 (incl. GST)' : '30 Days Plan – ₹1,180 (incl. GST)';
  if(confirm('Proceed to payment for ' + name + '?')) { window.location.href = '{{ route("employer.billing.purchase") }}?plan=' + selected.value; }
}
function renewPlan() {
  if(confirm('Renew your current plan?')) { window.location.href = '{{ route("employer.billing.purchase") }}?plan=30_day&renew=1'; }
}
</script>
@endpush