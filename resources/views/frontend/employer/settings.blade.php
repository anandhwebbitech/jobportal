{{-- ══════════════════════════════════════════════════════════
     resources/views/employer/settings.blade.php
     LinearJobs – Employer Settings
══════════════════════════════════════════════════════════ --}}
@extends('frontend.employer.layouts.app')
@section('title','Settings')
@section('breadcrumb','Settings')
@php $activeNav = 'settings'; @endphp

@push('styles')
<style>
.settings-layout{display:grid;grid-template-columns:220px 1fr;gap:20px;}
@media(max-width:800px){.settings-layout{grid-template-columns:1fr;}}

/* Settings Nav */
.settings-nav{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:10px;box-shadow:var(--shadow-sm);height:fit-content;}
.settings-nav-item{
  display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;
  font-size:.82rem;font-weight:600;color:var(--gray-600);cursor:pointer;
  transition:all .2s;margin-bottom:2px;border:none;background:none;width:100%;text-align:left;
}
.settings-nav-item:hover{background:var(--gray-50);color:var(--gray-800);}
.settings-nav-item.active{background:var(--blue-light);color:var(--blue);font-weight:700;}
.settings-nav-item i{width:16px;text-align:center;font-size:.8rem;}

/* Password strength */
.pwd-strength{height:4px;border-radius:100px;background:var(--gray-200);margin-top:6px;overflow:hidden;}
.pwd-strength-bar{height:100%;border-radius:100px;transition:width .3s,background .3s;width:0;}
.pwd-hint{font-size:.72rem;margin-top:4px;}

/* Danger zone */
.danger-zone{
  border:2px solid #fecaca;border-radius:12px;padding:22px;
  background:linear-gradient(145deg,#fff5f5,#fff);
}
.dz-title{font-size:.9rem;font-weight:800;color:var(--red);margin-bottom:6px;display:flex;align-items:center;gap:7px;}
.dz-desc{font-size:.8rem;color:var(--gray-500);margin-bottom:16px;line-height:1.6;}

/* Delete confirm step */
.delete-confirm{display:none;background:var(--red-light);border:1.5px solid #fecaca;border-radius:9px;padding:14px;margin-top:14px;}
.delete-confirm.show{display:block;}

/* Section card */
.settings-section{display:none;}
.settings-section.active{display:block;animation:fadeInUp .25s ease;}
@keyframes fadeInUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
</style>
@endpush

@section('content')

<div class="page-hdr">
  <div class="page-hdr-left">
    <div class="page-title">Settings</div>
    <div class="page-sub">Manage your account preferences and security</div>
  </div>
</div>

<div class="settings-layout">

  {{-- Settings Nav --}}
  <div class="settings-nav">
    <button class="settings-nav-item active" onclick="switchSection('password',this)">
      <i class="fas fa-lock"></i> Change Password
    </button>
    <button class="settings-nav-item" onclick="switchSection('notifications',this)">
      <i class="fas fa-bell"></i> Notifications
    </button>
    <button class="settings-nav-item" onclick="switchSection('danger',this)" style="color:var(--red);">
      <i class="fas fa-triangle-exclamation"></i> Danger Zone
    </button>
  </div>

  {{-- Settings Content --}}
  <div>

    {{-- Change Password --}}
    <div class="settings-section active" id="section-password">
      <div class="emp-card">
        <div class="emp-card-head">
          <div class="emp-card-head-ico"><i class="fas fa-lock"></i></div>
          <div>
            <div class="emp-card-head-title">Change Password</div>
            <div class="emp-card-head-sub">Keep your account secure with a strong password</div>
          </div>
        </div>
        <div class="emp-card-body" style="max-width:460px;">
          <form method="POST" action="{{ route('employer.settings.password') }}" id="pwdForm" novalidate>
          @csrf @method('PUT')

          @if(session('password_updated'))
          <div class="emp-notice success" style="margin-bottom:16px;"><i class="fas fa-check-circle"></i> Password updated successfully!</div>
          @endif

          <div class="f-group">
            <label class="f-label" for="current_password"><i class="fas fa-key"></i> Current Password <span class="f-req">*</span></label>
            <div class="f-iw" style="position:relative;">
              <i class="fas fa-key f-ico"></i>
              <input type="password" id="current_password" name="current_password" class="f-input" placeholder="Enter current password"/>
              <button type="button" onclick="togglePwd('current_password',this)" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:.82rem;">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="f-group">
            <label class="f-label" for="new_password"><i class="fas fa-lock"></i> New Password <span class="f-req">*</span></label>
            <div class="f-iw" style="position:relative;">
              <i class="fas fa-lock f-ico"></i>
              <input type="password" id="new_password" name="new_password" class="f-input" placeholder="Min. 8 characters" oninput="checkPwdStrength(this.value)"/>
              <button type="button" onclick="togglePwd('new_password',this)" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:.82rem;">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="pwd-strength"><div class="pwd-strength-bar" id="pwdBar"></div></div>
            <div class="pwd-hint" id="pwdHint" style="color:var(--gray-400);">Enter a password to check strength</div>
          </div>

          <div class="f-group">
            <label class="f-label" for="new_password_confirmation"><i class="fas fa-check-double"></i> Confirm New Password <span class="f-req">*</span></label>
            <div class="f-iw" style="position:relative;">
              <i class="fas fa-check-double f-ico"></i>
              <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="f-input" placeholder="Repeat new password" oninput="checkPwdMatch()"/>
            </div>
            <div class="f-err" id="pwdMatchErr"><i class="fas fa-circle-exclamation"></i> Passwords do not match.</div>
          </div>

          <div style="margin-top:6px;">
            <div class="f-hint" style="margin-bottom:10px;"><i class="fas fa-shield-check"></i> Use a mix of letters, numbers and symbols for a strong password</div>
            <button type="submit" class="btn-primary"><i class="fas fa-lock"></i> Update Password</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Notifications Settings --}}
    <div class="settings-section" id="section-notifications">
      <div class="emp-card">
        <div class="emp-card-head">
          <div class="emp-card-head-ico"><i class="fas fa-bell"></i></div>
          <div>
            <div class="emp-card-head-title">Notification Preferences</div>
            <div class="emp-card-head-sub">Choose how and when you receive alerts</div>
          </div>
        </div>
        <div class="emp-card-body">
          <form method="POST" action="{{ route('employer.settings.notifications') }}">
          @csrf @method('PUT')

          <div class="emp-divider"><div class="emp-divider-line"></div><div class="emp-divider-lbl"><i class="fas fa-envelope"></i> Email Notifications</div><div class="emp-divider-line"></div></div>

          @php $emailNotifs = [
            ['name'=>'email_new_application',    'title'=>'New Application Received', 'desc'=>'Get an email whenever someone applies to your job'],
            ['name'=>'email_shortlist',          'title'=>'Candidate Shortlisted',   'desc'=>'Notify when a candidate is shortlisted'],
            ['name'=>'email_plan_expiry',        'title'=>'Plan Expiry Reminder',    'desc'=>'Receive reminders 7 days before plan expires'],
            ['name'=>'email_admin_message',      'title'=>'Admin Messages',          'desc'=>'Important messages from the LinearJobs team'],
          ]; @endphp

          @foreach($emailNotifs as $pref)
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">{{ $pref['title'] }}</div>
              <div class="toggle-desc">{{ $pref['desc'] }}</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" name="{{ $pref['name'] }}" value="1" checked/>
              <span class="toggle-slider"></span>
            </label>
          </div>
          @endforeach

          <div class="emp-divider"><div class="emp-divider-line"></div><div class="emp-divider-lbl"><i class="fas fa-mobile-alt"></i> SMS Notifications</div><div class="emp-divider-line"></div></div>

          @php $smsNotifs = [
            ['name'=>'sms_new_application', 'title'=>'New Application SMS',  'desc'=>'Receive SMS for each new job application'],
            ['name'=>'sms_plan_expiry',     'title'=>'Plan Expiry SMS',      'desc'=>'SMS reminder before your plan expires'],
          ]; @endphp

          @foreach($smsNotifs as $pref)
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">{{ $pref['title'] }}</div>
              <div class="toggle-desc">{{ $pref['desc'] }}</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" name="{{ $pref['name'] }}" value="1"/>
              <span class="toggle-slider"></span>
            </label>
          </div>
          @endforeach

          <div style="margin-top:20px;">
            <button type="submit" class="btn-primary"><i class="fas fa-floppy-disk"></i> Save Preferences</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Danger Zone --}}
    <div class="settings-section" id="section-danger">
      <div class="emp-card">
        <div class="emp-card-head" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
          <div class="emp-card-head-ico" style="background:rgba(255,255,255,.15);"><i class="fas fa-triangle-exclamation"></i></div>
          <div>
            <div class="emp-card-head-title">Danger Zone</div>
            <div class="emp-card-head-sub">Irreversible account actions</div>
          </div>
        </div>
        <div class="emp-card-body">
          <div class="danger-zone">
            <div class="dz-title"><i class="fas fa-user-slash"></i> Delete Account</div>
            <div class="dz-desc">
              Permanently delete your employer account and all associated data including job postings, candidate applications, billing history, and company profile. <strong>This action cannot be undone.</strong>
            </div>
            <div class="emp-notice danger" style="margin-bottom:16px;">
              <i class="fas fa-triangle-exclamation"></i>
              <span>All your active job listings will be immediately removed from the platform.</span>
            </div>
            <button class="btn-outline btn-sm" style="color:var(--red);border-color:#fca5a5;" onclick="showDeleteConfirm()">
              <i class="fas fa-user-slash"></i> Request Account Deletion
            </button>

            <div class="delete-confirm" id="deleteConfirm">
              <form method="POST" action="{{ route('employer.settings.delete') }}">
              @csrf @method('DELETE')
              <div style="font-size:.82rem;font-weight:700;color:var(--red);margin-bottom:10px;">
                <i class="fas fa-triangle-exclamation"></i> Type <strong>DELETE</strong> to confirm:
              </div>
              <div class="f-group" style="margin-bottom:12px;">
                <input type="text" name="confirm_text" class="f-input no-ico" placeholder="Type DELETE here" oninput="checkDeleteConfirm(this.value)"/>
              </div>
              <div class="f-group" style="margin-bottom:12px;">
                <label class="f-label" for="delete_password"><i class="fas fa-lock"></i> Enter Password</label>
                <div class="f-iw">
                  <i class="fas fa-lock f-ico"></i>
                  <input type="password" id="delete_password" name="password" class="f-input" placeholder="Your account password"/>
                </div>
              </div>
              <div style="display:flex;gap:8px;">
                <button type="button" class="btn-outline btn-sm" onclick="hideDeleteConfirm()">Cancel</button>
                <button type="submit" class="btn-primary btn-sm" id="deleteAccountBtn" disabled style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
                  <i class="fas fa-trash"></i> Permanently Delete
                </button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
function switchSection(id, btn) {
  document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
  document.getElementById('section-' + id).classList.add('active');
  btn.classList.add('active');
}
function togglePwd(id, btn) {
  var inp = document.getElementById(id);
  var ico = btn.querySelector('i');
  if(inp.type === 'password') { inp.type = 'text'; ico.className = 'fas fa-eye-slash'; }
  else { inp.type = 'password'; ico.className = 'fas fa-eye'; }
}
function checkPwdStrength(pwd) {
  var bar = document.getElementById('pwdBar');
  var hint = document.getElementById('pwdHint');
  var score = 0;
  if(pwd.length >= 8) score++;
  if(/[A-Z]/.test(pwd)) score++;
  if(/[0-9]/.test(pwd)) score++;
  if(/[^A-Za-z0-9]/.test(pwd)) score++;
  var w = score * 25;
  var colors = ['','#ef4444','#f59e0b','#1a56db','#16a34a'];
  var labels = ['','Weak','Fair','Good','Strong'];
  bar.style.width = w + '%';
  bar.style.background = colors[score] || '#e5e7eb';
  hint.textContent = score > 0 ? 'Password strength: ' + (labels[score] || '') : 'Enter a password to check strength';
  hint.style.color = colors[score] || 'var(--gray-400)';
}
function checkPwdMatch() {
  var p1 = document.getElementById('new_password').value;
  var p2 = document.getElementById('new_password_confirmation').value;
  var err = document.getElementById('pwdMatchErr');
  err.classList.toggle('show', p2.length > 0 && p1 !== p2);
}
function showDeleteConfirm() { document.getElementById('deleteConfirm').classList.add('show'); }
function hideDeleteConfirm() { document.getElementById('deleteConfirm').classList.remove('show'); }
function checkDeleteConfirm(val) {
  document.getElementById('deleteAccountBtn').disabled = val !== 'DELETE';
}
</script>
@endpush