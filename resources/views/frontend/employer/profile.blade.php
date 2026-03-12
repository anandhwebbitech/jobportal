{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/company-profile.blade.php
     LinearJobs – Company Profile  ·  Premium Design
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Company Profile')
@section('breadcrumb','Company Profile')
@php $activeNav = 'profile'; @endphp

@push('styles')
<style>
/* ══════════════════════════════════════════════════════
   PAGE WRAPPER
══════════════════════════════════════════════════════ */
.cp-page{display:flex;flex-direction:column;gap:22px;padding:0 0 48px;}

/* ══════════════════════════════════════════════════════
   PAGE HEADER
══════════════════════════════════════════════════════ */
.cp-page-hdr{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:16px;
  background:linear-gradient(135deg,#0f2d8a 0%,#1a56db 50%,#3b82f6 100%);
  border-radius:18px;padding:28px 32px;
  position:relative;overflow:hidden;
  box-shadow:0 8px 32px rgba(26,86,219,.35);
}
.cp-page-hdr::before{
  content:'';position:absolute;inset:0;pointer-events:none;
  background-image:radial-gradient(circle,rgba(255,255,255,.07) 1px,transparent 1px);
  background-size:22px 22px;
}
.cp-page-hdr::after{
  content:'';position:absolute;top:-60px;right:-60px;
  width:240px;height:240px;border-radius:50%;
  background:rgba(255,255,255,.06);pointer-events:none;
}
.cp-hdr-text{position:relative;z-index:1;}
.cp-hdr-eyebrow{
  display:inline-flex;align-items:center;gap:6px;
  font-size:.7rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;
  color:rgba(255,255,255,.75);
  background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.2);
  border-radius:100px;padding:4px 12px;margin-bottom:8px;
}
.cp-hdr-title{font-size:1.45rem;font-weight:900;color:#fff;letter-spacing:-.4px;line-height:1.15;margin-bottom:4px;}
.cp-hdr-sub  {font-size:.83rem;color:rgba(255,255,255,.7);}
.cp-hdr-actions{display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:1;}
.cp-hdr-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:11px 22px;border-radius:10px;
  font-size:.84rem;font-weight:700;cursor:pointer;
  border:none;transition:all .22s;text-decoration:none;
}
.cp-hdr-btn-white{background:#fff;color:#1a56db;box-shadow:0 3px 12px rgba(0,0,0,.18);}
.cp-hdr-btn-white:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.22);}
.cp-hdr-btn-ghost{background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.3);}
.cp-hdr-btn-ghost:hover{background:rgba(255,255,255,.24);}

/* ══════════════════════════════════════════════════════
   VERIFICATION NOTICE
══════════════════════════════════════════════════════ */
.cp-notice{
  display:flex;align-items:flex-start;gap:13px;
  padding:14px 18px;border-radius:13px;
  font-size:.83rem;line-height:1.55;
}
.cp-notice.success{
  background:linear-gradient(135deg,#ecfdf5,#d1fae5);
  border:1.5px solid #a7f3d0;color:#065f46;
}
.cp-notice.info{
  background:linear-gradient(135deg,#eff6ff,#dbeafe);
  border:1.5px solid #bfdbfe;color:#1e3a8a;
}
.cp-notice-ico{
  width:34px;height:34px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:.85rem;
}
.cp-notice.success .cp-notice-ico{background:linear-gradient(135deg,#059669,#10b981);color:#fff;box-shadow:0 2px 8px rgba(5,150,105,.3);}
.cp-notice.info    .cp-notice-ico{background:linear-gradient(135deg,#1a56db,#3b82f6);color:#fff;box-shadow:0 2px 8px rgba(26,86,219,.3);}

/* ══════════════════════════════════════════════════════
   PREMIUM TABS
══════════════════════════════════════════════════════ */
.cp-tabs-wrap{
  background:#fff;
  border:1.5px solid #e4e9f2;
  border-radius:16px;
  padding:6px;
  display:flex;gap:4px;
  overflow-x:auto;
  box-shadow:0 2px 10px rgba(0,0,0,.06);
  scrollbar-width:none;
}
.cp-tabs-wrap::-webkit-scrollbar{display:none;}

.cp-tab{
  display:inline-flex;align-items:center;gap:8px;
  padding:10px 20px;border-radius:11px;
  font-size:.82rem;font-weight:700;
  color:#64748b;cursor:pointer;
  transition:all .22s;white-space:nowrap;
  border:1.5px solid transparent;background:none;
  position:relative;
}
.cp-tab i{font-size:.78rem;transition:all .22s;}
.cp-tab:hover:not(.active){color:#334155;background:#f8fafc;}

/* Active tab — each has own gradient */
.cp-tab.active{
  background:#fff;color:#1a56db;
  border-color:#bfdbfe;
  box-shadow:0 2px 12px rgba(26,86,219,.14);
}
.cp-tab.active i{color:#1a56db;}

/* Colored active per tab */
.cp-tab-info.active   {background:linear-gradient(135deg,#eff6ff,#e0f0ff);color:#1a56db;border-color:#bfdbfe;}
.cp-tab-addr.active   {background:linear-gradient(135deg,#ecfdf5,#d9fbe9);color:#059669;border-color:#a7f3d0;}
.cp-tab-addr.active i {color:#059669;}
.cp-tab-contact.active{background:linear-gradient(135deg,#f5f3ff,#ede9fe);color:#7c3aed;border-color:#ddd6fe;}
.cp-tab-contact.active i{color:#7c3aed;}
.cp-tab-verify.active {background:linear-gradient(135deg,#fff7ed,#fef3c7);color:#d97706;border-color:#fde68a;}
.cp-tab-verify.active i{color:#d97706;}

/* Tab indicator dot */
.cp-tab-dot{
  width:6px;height:6px;border-radius:50%;
  background:currentColor;opacity:.5;margin-left:2px;
}
.cp-tab.active .cp-tab-dot{opacity:1;}

/* Panel animation */
.tab-panel{display:none;}
.tab-panel.active{display:block;animation:cp-fadein .28s ease;}
@keyframes cp-fadein{
  from{opacity:0;transform:translateY(6px);}
  to  {opacity:1;transform:translateY(0);}
}

/* ══════════════════════════════════════════════════════
   SECTION CARD
══════════════════════════════════════════════════════ */
.cp-card{
  background:#fff;border:1.5px solid #e4e9f2;
  border-radius:18px;overflow:hidden;
  box-shadow:0 2px 10px rgba(0,0,0,.06);
  transition:box-shadow .22s;
}
.cp-card:hover{box-shadow:0 6px 24px rgba(0,0,0,.09);}

.cp-card-hdr{
  display:flex;align-items:center;gap:14px;
  padding:20px 26px 18px;
  border-bottom:1.5px solid #f1f5f9;
  position:relative;overflow:hidden;
}
.cp-card-hdr-blue  {background:linear-gradient(135deg,#f0f7ff,#e8f0fe);}
.cp-card-hdr-green {background:linear-gradient(135deg,#f0fdf7,#e6faf1);}
.cp-card-hdr-purple{background:linear-gradient(135deg,#f5f3ff,#ede9fe);}
.cp-card-hdr-amber {background:linear-gradient(135deg,#fffdf0,#fef9e7);}

.cp-card-hdr-ico{
  width:44px;height:44px;border-radius:13px;
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;flex-shrink:0;
  box-shadow:0 3px 10px rgba(0,0,0,.14);
}
.ico-blue  {background:linear-gradient(135deg,#1a56db,#3b82f6);color:#fff;}
.ico-green {background:linear-gradient(135deg,#059669,#10b981);color:#fff;}
.ico-purple{background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:#fff;}
.ico-amber {background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;}

.cp-card-hdr-title{font-size:.95rem;font-weight:800;color:#0f172a;letter-spacing:-.1px;}
.cp-card-hdr-sub  {font-size:.73rem;color:#94a3b8;margin-top:2px;}

.cp-card-body{padding:26px;}

/* ══════════════════════════════════════════════════════
   PREMIUM FORM ELEMENTS
══════════════════════════════════════════════════════ */

/* Label */
.f-label{
  display:flex;align-items:center;gap:7px;
  font-size:.78rem;font-weight:700;
  color:#334155;margin-bottom:8px;letter-spacing:.01em;
}
.f-label i{
  font-size:.72rem;
  width:18px;height:18px;border-radius:5px;
  display:inline-flex;align-items:center;justify-content:center;
  background:linear-gradient(135deg,#eff6ff,#dbeafe);
  color:#1a56db;flex-shrink:0;
}
/* Green labels for address tab */
.f-label-green i{background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:#059669;}
/* Purple labels for contact tab */
.f-label-purple i{background:linear-gradient(135deg,#f5f3ff,#ede9fe);color:#7c3aed;}

.f-req{
  font-size:.65rem;font-weight:700;
  background:linear-gradient(135deg,#fee2e2,#fecaca);
  color:#b91c1c;border-radius:100px;padding:2px 7px;margin-left:2px;
}
.f-opt{
  font-size:.65rem;font-weight:600;
  background:#f1f5f9;color:#94a3b8;border-radius:100px;padding:2px 8px;margin-left:2px;
}

/* Input wrapper */
.f-iw{position:relative;display:flex;}
.f-ico{
  position:absolute;left:13px;top:50%;transform:translateY(-50%);
  font-size:.78rem;color:#94a3b8;pointer-events:none;z-index:2;
  transition:color .22s;
}
.f-ico.ta{top:15px;transform:none;}

/* Input / select / textarea */
.f-input{
  width:100%;
  padding:13px 14px 13px 38px;
  font-size:.87rem;font-weight:500;color:#1e293b;
  background:#fff;
  border:1.5px solid #e2e8f0;
  border-radius:11px;
  outline:none;
  transition:border-color .22s,box-shadow .22s,background .22s;
  font-family:inherit;
  appearance:none;-webkit-appearance:none;
}
.f-input::placeholder{color:#b0bec5;font-weight:400;}
.f-input:hover{border-color:#94a3b8;}
.f-input:focus{
  border-color:#1a56db;
  box-shadow:0 0 0 3.5px rgba(26,86,219,.12);
  background:#fff;
}
.f-input:focus ~ .f-ico,
.f-iw:focus-within .f-ico{color:#1a56db;}

/* Select arrow */
.f-input[type=text]+*,
select.f-input{
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%2394a3b8' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;
  background-position:right 13px center;
  padding-right:34px;cursor:pointer;
}
select.f-input:focus{
  border-color:#1a56db;
  box-shadow:0 0 0 3.5px rgba(26,86,219,.12);
}

/* Textarea */
textarea.f-input{min-height:110px;resize:vertical;line-height:1.6;}

/* Readonly */
.f-input[readonly]{
  background:linear-gradient(135deg,#f8fafc,#f1f5f9);
  color:#475569;cursor:not-allowed;border-color:#e2e8f0;
}
.f-input[readonly]:hover{border-color:#e2e8f0;}
.f-input[readonly]:focus{box-shadow:none;border-color:#e2e8f0;}

/* No icon variant */
.f-input.no-ico{padding-left:14px;}

/* Hint text */
.f-hint{
  display:flex;align-items:center;gap:5px;
  font-size:.7rem;color:#94a3b8;margin-top:6px;font-style:italic;
}
.f-hint i{font-size:.65rem;color:#bfdbfe;}

/* Validation states */
.f-input.is-valid{border-color:#059669;background:linear-gradient(135deg,#fff,#f0fdf9);}
.f-input.is-valid:focus{box-shadow:0 0 0 3.5px rgba(5,150,105,.12);}
.f-input.is-error{border-color:#dc2626;background:linear-gradient(135deg,#fff,#fff5f5);}
.f-input.is-error:focus{box-shadow:0 0 0 3.5px rgba(220,38,38,.12);}

/* Rows */
.f-row {display:grid;grid-template-columns:1fr 1fr;gap:18px;}
.f-row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:18px;}
.f-group{display:flex;flex-direction:column;margin-bottom:20px;}
.f-group:last-child{margin-bottom:0;}

@media(max-width:680px){
  .f-row {grid-template-columns:1fr;}
  .f-row3{grid-template-columns:1fr;}
}

/* ══════════════════════════════════════════════════════
   LOGO UPLOAD
══════════════════════════════════════════════════════ */
.logo-upload-wrap{
  display:flex;flex-direction:column;align-items:center;gap:10px;
  width:110px;flex-shrink:0;
}
.logo-upload{
  width:110px;height:110px;border-radius:18px;
  border:2px dashed #cbd5e1;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  cursor:pointer;transition:all .22s;gap:7px;
  background:linear-gradient(135deg,#f8fafc,#f1f5f9);
  color:#94a3b8;position:relative;overflow:hidden;
}
.logo-upload-inner{
  display:flex;flex-direction:column;align-items:center;gap:7px;
  position:relative;z-index:1;pointer-events:none;
}
.logo-upload:hover{border-color:#1a56db;background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#1a56db;}
.logo-upload i{font-size:1.5rem;transition:transform .22s;}
.logo-upload:hover i{transform:translateY(-2px);}
.logo-upload span{font-size:.68rem;font-weight:700;text-align:center;letter-spacing:.02em;}
.logo-upload input{display:none;}
.logo-upload-lbl{font-size:.7rem;color:#94a3b8;text-align:center;font-weight:600;}

/* ══════════════════════════════════════════════════════
   SECTION DIVIDER
══════════════════════════════════════════════════════ */
.cp-divider{
  display:flex;align-items:center;gap:12px;
  margin:24px 0 20px;
}
.cp-divider-line{flex:1;height:1px;background:linear-gradient(90deg,transparent,#e2e8f0,transparent);}
.cp-divider-lbl{
  display:flex;align-items:center;gap:7px;
  font-size:.72rem;font-weight:800;letter-spacing:.07em;text-transform:uppercase;
  white-space:nowrap;padding:5px 14px;border-radius:100px;
  border:1.5px solid;
}
.cp-divider-lbl-blue  {background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#1d4ed8;border-color:#bfdbfe;}
.cp-divider-lbl-purple{background:linear-gradient(135deg,#f5f3ff,#ede9fe);color:#6d28d9;border-color:#ddd6fe;}

/* ══════════════════════════════════════════════════════
   VERIFICATION BADGES
══════════════════════════════════════════════════════ */
.verify-status{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 18px;border-radius:100px;
  font-size:.82rem;font-weight:700;
}
.verify-status.approved{
  background:linear-gradient(135deg,#ecfdf5,#d1fae5);
  border:1.5px solid #a7f3d0;color:#065f46;
  box-shadow:0 2px 10px rgba(5,150,105,.15);
}
.verify-status.pending{
  background:linear-gradient(135deg,#fffbeb,#fef3c7);
  border:1.5px solid #fde68a;color:#92400e;
}
.verify-status i{font-size:.8rem;}

/* ══════════════════════════════════════════════════════
   DOCUMENT ROWS
══════════════════════════════════════════════════════ */
.doc-row{
  display:flex;align-items:center;gap:14px;
  background:linear-gradient(135deg,#f8fafc,#f1f5f9);
  border:1.5px solid #e2e8f0;
  border-radius:13px;padding:14px 18px;
  transition:all .22s;
}
.doc-row:hover{border-color:#bfdbfe;background:linear-gradient(135deg,#eff6ff,#e8f0fe);box-shadow:0 2px 10px rgba(26,86,219,.08);}
.doc-ico{
  width:44px;height:44px;border-radius:11px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.05rem;flex-shrink:0;
  box-shadow:0 2px 8px rgba(0,0,0,.1);
}
.doc-ico-red   {background:linear-gradient(135deg,#fee2e2,#fecaca);color:#dc2626;}
.doc-ico-blue  {background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#1d4ed8;}
.doc-ico-green {background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;}
.doc-info{flex:1;min-width:0;}
.doc-name{font-size:.84rem;font-weight:700;color:#1e293b;}
.doc-meta{font-size:.71rem;color:#94a3b8;margin-top:2px;}
.doc-ok{
  display:inline-flex;align-items:center;gap:5px;
  font-size:.72rem;font-weight:700;
  background:linear-gradient(135deg,#dcfce7,#bbf7d0);
  color:#15803d;border-radius:100px;padding:4px 11px;
  border:1px solid #a7f3d0;flex-shrink:0;
}
.doc-view-btn{
  display:inline-flex;align-items:center;gap:5px;
  font-size:.75rem;font-weight:700;
  background:#fff;border:1.5px solid #e2e8f0;
  color:#334155;border-radius:8px;padding:6px 12px;
  text-decoration:none;transition:all .22s;flex-shrink:0;
  box-shadow:0 1px 4px rgba(0,0,0,.06);
}
.doc-view-btn:hover{border-color:#bfdbfe;color:#1a56db;box-shadow:0 2px 8px rgba(26,86,219,.14);}

/* ══════════════════════════════════════════════════════
   SAVE FOOTER BAR
══════════════════════════════════════════════════════ */
.cp-save-bar{
  display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;
  background:linear-gradient(135deg,#f8fafc,#fff);
  border:1.5px solid #e4e9f2;
  border-radius:14px;padding:16px 22px;
  box-shadow:0 2px 10px rgba(0,0,0,.05);
}
.cp-btn-reset{
  display:inline-flex;align-items:center;gap:7px;
  padding:11px 22px;border-radius:10px;
  font-size:.84rem;font-weight:700;cursor:pointer;
  background:#fff;border:1.5px solid #e2e8f0;
  color:#475569;transition:all .22s;
}
.cp-btn-reset:hover{border-color:#94a3b8;color:#1e293b;background:#f8fafc;}
.cp-btn-save{
  display:inline-flex;align-items:center;gap:8px;
  padding:11px 26px;border-radius:10px;
  font-size:.84rem;font-weight:700;cursor:pointer;
  background:linear-gradient(135deg,#1a56db,#3b82f6);
  color:#fff;border:none;
  box-shadow:0 4px 14px rgba(26,86,219,.35);
  transition:all .22s;
}
.cp-btn-save:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(26,86,219,.42);}
.cp-btn-save:disabled{opacity:.65;transform:none;cursor:wait;}

/* ══════════════════════════════════════════════════════
   VERIFIED DATE CHIP
══════════════════════════════════════════════════════ */
.cp-verified-chip{
  display:inline-flex;align-items:center;gap:6px;
  font-size:.72rem;font-weight:600;
  background:linear-gradient(135deg,#f1f5f9,#e2e8f0);
  color:#475569;border-radius:100px;padding:5px 13px;
  border:1px solid #e2e8f0;
}
.cp-verified-chip i{font-size:.64rem;color:#94a3b8;}
</style>
@endpush

@section('content')
<div class="cp-page">

{{-- ══ PAGE HEADER ══════════════════════════════════════ --}}
<div class="cp-page-hdr">
  <div class="cp-hdr-text">
    <div class="cp-hdr-eyebrow"><i class="fas fa-building"></i> Employer Portal</div>
    <div class="cp-hdr-title">Company Profile</div>
    <div class="cp-hdr-sub">Manage your company information, verification documents and contact details</div>
  </div>
  <div class="cp-hdr-actions">
    <button class="cp-hdr-btn cp-hdr-btn-white" onclick="saveProfile(this)">
      <i class="fas fa-floppy-disk"></i> Save Changes
    </button>
    <a href="#" class="cp-hdr-btn cp-hdr-btn-ghost">
      <i class="fas fa-eye"></i> Preview
    </a>
  </div>
</div>

{{-- ══ VERIFICATION NOTICE ══════════════════════════════ --}}
<div class="cp-notice success">
  <div class="cp-notice-ico"><i class="fas fa-circle-check"></i></div>
  <div>
    <strong>Verification Approved!</strong> Your company has been verified by the LinearJobs team on <strong>10 Mar 2025</strong>.
    Verification details are now read-only. Contact support if you need to update documents.
  </div>
</div>

{{-- ══ TABS ═════════════════════════════════════════════ --}}
<div class="cp-tabs-wrap">
  <button class="cp-tab cp-tab-info active" onclick="switchTab('info',this)">
    <i class="fas fa-building"></i> Company Info
    <span class="cp-tab-dot"></span>
  </button>
  <button class="cp-tab cp-tab-addr" onclick="switchTab('address',this)">
    <i class="fas fa-location-dot"></i> Address
    <span class="cp-tab-dot"></span>
  </button>
  <button class="cp-tab cp-tab-contact" onclick="switchTab('contact',this)">
    <i class="fas fa-phone"></i> Contact
    <span class="cp-tab-dot"></span>
  </button>
  <button class="cp-tab cp-tab-verify" onclick="switchTab('verification',this)">
    <i class="fas fa-shield-halved"></i> Verification
    <span class="cp-tab-dot"></span>
  </button>
</div>

<form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data" id="profileForm">
@csrf @method('PUT')

{{-- ══════════════════════════════════════════════
     TAB 1 · COMPANY INFO
══════════════════════════════════════════════ --}}
<div class="tab-panel active" id="tab-info">
  <div class="cp-card">
    <div class="cp-card-hdr cp-card-hdr-blue">
      <div class="cp-card-hdr-ico ico-blue"><i class="fas fa-building"></i></div>
      <div>
        <div class="cp-card-hdr-title">Company Information</div>
        <div class="cp-card-hdr-sub">Basic details about your organisation</div>
      </div>
    </div>
    <div class="cp-card-body">

      {{-- Logo + Name --}}
      <div style="display:flex;align-items:flex-start;gap:22px;margin-bottom:24px;flex-wrap:wrap;">
        <div class="logo-upload-wrap">
          <label class="logo-upload" for="logoInput" title="Upload company logo">
            <div class="logo-upload-inner">
              <i class="fas fa-cloud-arrow-up"></i>
              <span>Upload<br>Logo</span>
            </div>
            <input type="file" id="logoInput" name="company_logo" accept="image/*" onchange="previewLogo(this)"/>
          </label>
          <div class="logo-upload-lbl">PNG, JPG · Max 2MB</div>
        </div>
        <div style="flex:1;min-width:200px;">
          <div class="f-group">
            <label class="f-label" for="company_name">
              <i class="fas fa-building"></i> Company Name
              <span class="f-req">Required</span>
            </label>
            <div class="f-iw">
              <i class="fas fa-building f-ico"></i>
              <input type="text" id="company_name" name="company_name" class="f-input"
                value="{{ old('company_name', $employer->company_name ?? 'TechBridge Solutions Pvt. Ltd.') }}"
                placeholder="Legal company name"/>
            </div>
            <div class="f-hint"><i class="fas fa-circle-info"></i> Use the full legal name exactly as registered with MCA / GST</div>
          </div>
        </div>
      </div>

      {{-- Description --}}
      <div class="f-group">
        <label class="f-label" for="description">
          <i class="fas fa-align-left"></i> Company Description
          <span class="f-req">Required</span>
        </label>
        <div class="f-iw">
          <i class="fas fa-align-left f-ico ta"></i>
          <textarea id="description" name="company_description" class="f-input"
            style="padding-left:38px;min-height:120px;"
            placeholder="Tell candidates about your company, culture, mission and work environment...">{{ old('company_description', $employer->company_description ?? 'We are a leading IT and MSME solutions provider based in Tamil Nadu, specializing in digital transformation and software development services for SMEs across South India.') }}</textarea>
        </div>
        <div class="f-hint"><i class="fas fa-circle-info"></i> A good description helps candidates understand your company culture</div>
      </div>

      <div class="f-row">
        {{-- Industry --}}
        <div class="f-group">
          <label class="f-label" for="industry_type">
            <i class="fas fa-industry"></i> Industry Type
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-industry f-ico"></i>
            <select id="industry_type" name="industry_type" class="f-input">
              @php $industries = ['IT / Software','Manufacturing','Healthcare','Education','Finance','Retail','Logistics','Hospitality','Construction','Textile','Automobile','Other']; @endphp
              @foreach($industries as $ind)
              <option value="{{ $ind }}" {{ ($employer->industry_type??'IT / Software')===$ind?'selected':'' }}>{{ $ind }}</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- Website --}}
        <div class="f-group">
          <label class="f-label" for="website">
            <i class="fas fa-globe"></i> Company Website
            <span class="f-opt">Optional</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-globe f-ico"></i>
            <input type="url" id="website" name="company_website" class="f-input"
              value="{{ old('company_website', $employer->company_website ?? 'https://techbridge.in') }}"
              placeholder="https://yourcompany.com"/>
          </div>
        </div>
      </div>

      <div class="f-row">
        {{-- Company Size --}}
        <div class="f-group">
          <label class="f-label" for="company_size">
            <i class="fas fa-users"></i> Company Size
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-users f-ico"></i>
            <select id="company_size" name="company_size" class="f-input">
              @foreach(['1-10','11-50','51-200','201-500','501-1000','1000+'] as $s)
              <option value="{{ $s }}" {{ ($employer->company_size??'51-200')===$s?'selected':'' }}>{{ $s }} Employees</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- Founded Year --}}
        <div class="f-group">
          <label class="f-label" for="founded_year">
            <i class="fas fa-calendar"></i> Founded Year
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-calendar f-ico"></i>
            <select id="founded_year" name="founded_year" class="f-input">
              @for($y=date('Y'); $y>=1950; $y--)
              <option value="{{ $y }}" {{ ($employer->founded_year??2019)===$y?'selected':'' }}>{{ $y }}</option>
              @endfor
            </select>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     TAB 2 · ADDRESS
══════════════════════════════════════════════ --}}
<div class="tab-panel" id="tab-address">
  <div class="cp-card">
    <div class="cp-card-hdr cp-card-hdr-green">
      <div class="cp-card-hdr-ico ico-green"><i class="fas fa-location-dot"></i></div>
      <div>
        <div class="cp-card-hdr-title">Company Address</div>
        <div class="cp-card-hdr-sub">Office and registered address details</div>
      </div>
    </div>
    <div class="cp-card-body">

      <div class="f-group">
        <label class="f-label" for="address">
          <i class="fas fa-map-pin"></i> Street Address
          <span class="f-req">Required</span>
        </label>
        <div class="f-iw">
          <i class="fas fa-map-pin f-ico ta"></i>
          <textarea id="address" name="company_address" class="f-input"
            style="padding-left:38px;min-height:80px;"
            placeholder="Street address, building name, landmark...">{{ old('company_address', $employer->company_address ?? '15, Anna Nagar, 2nd Street') }}</textarea>
        </div>
      </div>

      <div class="f-row3">
        <div class="f-group">
          <label class="f-label" for="state">
            <i class="fas fa-map"></i> State
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-map f-ico"></i>
            <select id="state" name="state" class="f-input">
              @foreach(['Tamil Nadu','Kerala','Karnataka','Andhra Pradesh','Telangana'] as $st)
              <option value="{{ $st }}" {{ ($employer->state??'Tamil Nadu')===$st?'selected':'' }}>{{ $st }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label" for="district">
            <i class="fas fa-location-dot"></i> District
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-location-dot f-ico"></i>
            <select id="district" name="district" class="f-input">
              @php $dists=['Chennai','Coimbatore','Madurai','Trichy','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Namakkal']; @endphp
              @foreach($dists as $d)
              <option value="{{ $d }}" {{ ($employer->district??'Chennai')===$d?'selected':'' }}>{{ $d }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label" for="city">
            <i class="fas fa-city"></i> City / Town
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-city f-ico"></i>
            <input type="text" id="city" name="city" class="f-input"
              value="{{ old('city', $employer->city ?? 'Chennai') }}" placeholder="City or town"/>
          </div>
        </div>
      </div>

      <div class="f-group" style="max-width:220px;">
        <label class="f-label" for="pincode">
          <i class="fas fa-hashtag"></i> Pincode
          <span class="f-req">Required</span>
        </label>
        <div class="f-iw">
          <i class="fas fa-hashtag f-ico"></i>
          <input type="text" id="pincode" name="pincode" class="f-input"
            value="{{ old('pincode', $employer->pincode ?? '600040') }}"
            maxlength="6" placeholder="6-digit pincode"/>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     TAB 3 · CONTACT
══════════════════════════════════════════════ --}}
<div class="tab-panel" id="tab-contact">
  <div class="cp-card">
    <div class="cp-card-hdr cp-card-hdr-purple">
      <div class="cp-card-hdr-ico ico-purple"><i class="fas fa-phone"></i></div>
      <div>
        <div class="cp-card-hdr-title">Contact Information</div>
        <div class="cp-card-hdr-sub">Owner and HR contact details</div>
      </div>
    </div>
    <div class="cp-card-body">

      {{-- Owner --}}
      <div class="cp-divider">
        <div class="cp-divider-line"></div>
        <div class="cp-divider-lbl cp-divider-lbl-blue">
          <i class="fas fa-user-tie"></i> Owner Details
        </div>
        <div class="cp-divider-line"></div>
      </div>

      <div class="f-row">
        <div class="f-group">
          <label class="f-label" for="owner_name">
            <i class="fas fa-user"></i> Owner Name
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-user f-ico"></i>
            <input type="text" id="owner_name" name="owner_name" class="f-input"
              value="{{ old('owner_name', $employer->owner_name ?? 'Karthik Selvan') }}" placeholder="Full name"/>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label" for="owner_mobile">
            <i class="fas fa-mobile-screen"></i> Owner Mobile
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-mobile-screen f-ico"></i>
            <input type="tel" id="owner_mobile" name="owner_mobile" class="f-input"
              value="{{ old('owner_mobile', $employer->owner_mobile ?? '+91 98765 43210') }}"
              placeholder="+91 XXXXX XXXXX"/>
          </div>
        </div>
      </div>

      {{-- HR --}}
      <div class="cp-divider">
        <div class="cp-divider-line"></div>
        <div class="cp-divider-lbl cp-divider-lbl-purple">
          <i class="fas fa-id-badge"></i> HR Details
        </div>
        <div class="cp-divider-line"></div>
      </div>

      <div class="f-row">
        <div class="f-group">
          <label class="f-label" for="hr_name">
            <i class="fas fa-user"></i> HR Name
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-user f-ico"></i>
            <input type="text" id="hr_name" name="hr_name" class="f-input"
              value="{{ old('hr_name', $employer->hr_name ?? 'Preethi Raj') }}" placeholder="HR contact name"/>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label" for="hr_mobile">
            <i class="fas fa-mobile-screen"></i> HR Mobile
            <span class="f-req">Required</span>
          </label>
          <div class="f-iw">
            <i class="fas fa-mobile-screen f-ico"></i>
            <input type="tel" id="hr_mobile" name="hr_mobile" class="f-input"
              value="{{ old('hr_mobile', $employer->hr_mobile ?? '+91 98765 11111') }}"
              placeholder="+91 XXXXX XXXXX"/>
          </div>
        </div>
      </div>

      <div class="f-group">
        <label class="f-label" for="official_email">
          <i class="fas fa-envelope"></i> Official Email
          <span class="f-req">Required</span>
        </label>
        <div class="f-iw">
          <i class="fas fa-envelope f-ico"></i>
          <input type="email" id="official_email" name="official_email" class="f-input"
            value="{{ old('official_email', $employer->official_email ?? 'hr@techbridge.in') }}"
            placeholder="company@domain.com"/>
        </div>
        <div class="f-hint"><i class="fas fa-circle-info"></i> Candidates may use this email to contact you</div>
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     TAB 4 · VERIFICATION
══════════════════════════════════════════════ --}}
<div class="tab-panel" id="tab-verification">

  <div class="cp-notice info" style="margin-bottom:18px;">
    <div class="cp-notice-ico"><i class="fas fa-lock"></i></div>
    <div>Verification details are <strong>read-only</strong> after admin approval. Contact <strong>support@linearjobs.in</strong> to update documents.</div>
  </div>

  <div class="cp-card">
    <div class="cp-card-hdr cp-card-hdr-amber">
      <div class="cp-card-hdr-ico ico-amber"><i class="fas fa-shield-halved"></i></div>
      <div>
        <div class="cp-card-hdr-title">Verification Details</div>
        <div class="cp-card-hdr-sub">Government-issued business credentials</div>
      </div>
    </div>
    <div class="cp-card-body">

      {{-- Status row --}}
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
        <div>
          <div class="f-label" style="margin-bottom:8px;"><i class="fas fa-circle-check"></i> Verification Status</div>
          <span class="verify-status approved">
            <i class="fas fa-circle-check"></i> Approved by Admin
          </span>
        </div>
        <div class="cp-verified-chip">
          <i class="fas fa-calendar-check"></i> Verified on 10 Mar 2025
        </div>
      </div>

      {{-- GST / PAN / MSME --}}
      <div class="f-row3">
        <div class="f-group">
          <label class="f-label"><i class="fas fa-file-invoice"></i> GST Number</label>
          <div class="f-iw">
            <input type="text" class="f-input no-ico is-valid"
              value="{{ $employer->gst_number ?? '33AABCT1234A1Z5' }}" readonly/>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label"><i class="fas fa-id-card"></i> PAN Number</label>
          <div class="f-iw">
            <input type="text" class="f-input no-ico is-valid"
              value="{{ $employer->pan_number ?? 'AABCT1234A' }}" readonly/>
          </div>
        </div>
        <div class="f-group">
          <label class="f-label"><i class="fas fa-certificate"></i> MSME Number</label>
          <div class="f-iw">
            <input type="text" class="f-input no-ico is-valid"
              value="{{ $employer->msme_number ?? 'TN/03/0012345' }}" readonly/>
          </div>
        </div>
      </div>

      {{-- Documents --}}
      <div class="cp-divider">
        <div class="cp-divider-line"></div>
        <div class="cp-divider-lbl cp-divider-lbl-blue">
          <i class="fas fa-file-pdf"></i> Uploaded Documents
        </div>
        <div class="cp-divider-line"></div>
      </div>

      <div style="display:flex;flex-direction:column;gap:10px;">
        @php
        $docs = [
          ['name'=>'GST Certificate',   'ico'=>'fa-file-pdf',   'cls'=>'doc-ico-red',  'meta'=>'PDF · Uploaded 8 Mar 2025'],
          ['name'=>'PAN Card',          'ico'=>'fa-id-card',    'cls'=>'doc-ico-blue', 'meta'=>'PDF · Uploaded 8 Mar 2025'],
          ['name'=>'MSME Certificate',  'ico'=>'fa-certificate','cls'=>'doc-ico-green','meta'=>'PDF · Uploaded 8 Mar 2025'],
        ];
        @endphp
        @foreach($docs as $doc)
        <div class="doc-row">
          <div class="doc-ico {{ $doc['cls'] }}"><i class="fas {{ $doc['ico'] }}"></i></div>
          <div class="doc-info">
            <div class="doc-name">{{ $doc['name'] }}</div>
            <div class="doc-meta">{{ $doc['meta'] }}</div>
          </div>
          <div class="doc-ok"><i class="fas fa-circle-check"></i> Approved</div>
          <a href="#" class="doc-view-btn"><i class="fas fa-eye"></i> View</a>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</div>

</form>

{{-- ══ SAVE FOOTER BAR ══════════════════════════════════ --}}
<div class="cp-save-bar">
  <button class="cp-btn-reset" type="button" onclick="resetForm()">
    <i class="fas fa-rotate-left"></i> Reset
  </button>
  <button class="cp-btn-save" onclick="saveProfile(this)">
    <i class="fas fa-floppy-disk"></i> Save Changes
  </button>
</div>

</div>{{-- cp-page --}}
@endsection

@push('scripts')
<script>
function switchTab(tabId, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.cp-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + tabId).classList.add('active');
  btn.classList.add('active');
}

function previewLogo(input) {
  if (!input.files || !input.files[0]) return;
  var reader = new FileReader();
  reader.onload = function(e) {
    var lbl = input.closest('label');
    lbl.style.backgroundImage = 'url(' + e.target.result + ')';
    lbl.style.backgroundSize = 'cover';
    lbl.style.backgroundPosition = 'center';
    lbl.style.border = '2px solid #1a56db';
    lbl.querySelector('.logo-upload-inner').style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}

function saveProfile(btn) {
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
  btn.disabled = true;
  setTimeout(() => {
    btn.innerHTML = '<i class="fas fa-check"></i> Saved!';
    btn.style.background = 'linear-gradient(135deg,#059669,#10b981)';
    btn.style.boxShadow = '0 4px 14px rgba(5,150,105,.4)';
    setTimeout(() => {
      btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Changes';
      btn.style.background = '';
      btn.style.boxShadow = '';
      btn.disabled = false;
    }, 2200);
  }, 950);
}

function resetForm() {
  if (confirm('Reset all unsaved changes?')) {
    document.getElementById('profileForm').reset();
  }
}

/* Focus enhancement — color the icon when field is focused */
document.querySelectorAll('.f-input').forEach(input => {
  input.addEventListener('focus', function() {
    var ico = this.closest('.f-iw')?.querySelector('.f-ico');
    if (ico) ico.style.color = '#1a56db';
  });
  input.addEventListener('blur', function() {
    var ico = this.closest('.f-iw')?.querySelector('.f-ico');
    if (ico) ico.style.color = '';
  });
});
</script>
@endpush