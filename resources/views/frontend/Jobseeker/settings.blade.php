{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/settings.blade.php
     Settings – LinearJobs Job Seeker Dashboard
═══════════════════════════════════════════════════════ --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Settings')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Settings</div>
    <div class="lj-page-subtitle">Manage your account preferences, security, and privacy.</div>
  </div>
</div>

<div class="lj-grid-2">

  {{-- Change Password --}}
  <div class="lj-card lj-section-gap">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-lock"></i> Change Password</div>
    </div>
    <form method="POST" action="{{ route('jobseeker.dashboard.settings.password') }}" id="passwordForm">
      @csrf @method('PUT')
      <div class="lj-card-body">
        <div class="lj-fgroup" style="margin-bottom:16px;">
          <label class="lj-label">Current Password <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-lock lj-input-ico"></i>
            <input class="lj-input has-ico @error('current_password') border-red-400 @enderror"
              type="password" name="current_password"
              placeholder="Enter current password" required autocomplete="current-password"/>
          </div>
          @error('current_password')<div style="font-size:.73rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div class="lj-fgroup" style="margin-bottom:16px;">
          <label class="lj-label">New Password <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-key lj-input-ico"></i>
            <input class="lj-input has-ico" type="password" name="password" id="newPassword"
              placeholder="Enter new password" required minlength="8"
              autocomplete="new-password" oninput="checkPasswordStrength(this.value)"/>
          </div>
          {{-- Strength bar --}}
          <div class="lj-password-strength">
            <div class="lj-pwd-bar" id="pwdBar" style="width:0%;background:var(--n300);"></div>
          </div>
          <div style="font-size:.7rem;margin-top:4px;display:flex;align-items:center;justify-content:space-between;">
            <span style="color:var(--n400);">Min. 8 characters with letters and numbers</span>
            <span id="pwdStrengthLabel" style="font-weight:600;"></span>
          </div>
          @error('password')<div style="font-size:.73rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div class="lj-fgroup">
          <label class="lj-label">Confirm New Password <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-key lj-input-ico"></i>
            <input class="lj-input has-ico" type="password" name="password_confirmation"
              id="confirmPassword" placeholder="Confirm new password" required
              autocomplete="new-password" oninput="checkPasswordMatch()"/>
          </div>
          <div id="pwdMatchMsg" style="font-size:.73rem;margin-top:4px;display:none;"></div>
        </div>
      </div>
      <div class="lj-form-footer">
        <button type="reset" class="lj-btn lj-btn-outline" onclick="resetPasswordForm()">Clear</button>
        <button type="submit" class="lj-btn lj-btn-primary">
          <i class="fa-solid fa-check"></i> Update Password
        </button>
      </div>
    </form>
  </div>

  {{-- Notification Preferences --}}
  <div class="lj-card lj-section-gap">
    <div class="lj-card-head">
      <div class="lj-card-title"><i class="fa-solid fa-bell"></i> Notification Preferences</div>
    </div>
    <form method="POST" action="{{ route('jobseeker.dashboard.settings.notifications') }}">
      @csrf @method('PUT')
      <div style="padding:0 22px;">
        @php
          $prefs = auth()->user()->notification_prefs ?? [];
          $settings = [
            ['email_notifications',   'Email Notifications',    'Receive job alerts and application updates via email'],
            ['sms_alerts',            'SMS Alerts',             'Get SMS notifications for interviews and shortlisting'],
            ['job_recommendations',   'Job Recommendations',    'Weekly digest of jobs matching your profile'],
            ['application_reminders', 'Application Reminders',  'Reminders about saved jobs and pending applications'],
            ['profile_viewed',        'Profile View Alerts',    'Notify me when employers view my profile'],
          ];
        @endphp
        @foreach($settings as [$key, $label, $sub])
          <div class="lj-setting-row">
            <div>
              <div class="lj-setting-label">{{ $label }}</div>
              <div class="lj-setting-sub">{{ $sub }}</div>
            </div>
            <div class="lj-toggle {{ ($prefs[$key] ?? true) ? 'on' : '' }}"
              id="toggle-{{ $key }}"
              onclick="togglePref(this, '{{ $key }}')">
            </div>
            <input type="hidden" name="{{ $key }}" id="input-{{ $key }}"
              value="{{ ($prefs[$key] ?? true) ? '1' : '0' }}"/>
          </div>
        @endforeach
      </div>
      <div class="lj-form-footer">
        <button type="submit" class="lj-btn lj-btn-primary">
          <i class="fa-solid fa-check"></i> Save Preferences
        </button>
      </div>
    </form>
  </div>

</div>

{{-- Privacy Settings --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-shield-halved"></i> Privacy & Visibility</div>
  </div>
  <form method="POST" action="{{ route('jobseeker.dashboard.settings.privacy') }}">
    @csrf @method('PUT')
    <div style="padding:0 22px;">
      @php
        $privacy = auth()->user()->privacy_settings ?? [];
        $privacySettings = [
          ['profile_visible',  'Profile Visible to Employers', 'Allow employers to find and contact you directly via your profile'],
          ['resume_public',    'Resume Publicly Available',    'Allow employers to view and download your resume'],
          ['show_contact',     'Show Contact Info',            'Show your mobile number and email to verified employers'],
        ];
      @endphp
      @foreach($privacySettings as [$key, $label, $sub])
        <div class="lj-setting-row">
          <div>
            <div class="lj-setting-label">{{ $label }}</div>
            <div class="lj-setting-sub">{{ $sub }}</div>
          </div>
          <div class="lj-toggle {{ ($privacy[$key] ?? true) ? 'on' : '' }}"
            onclick="this.classList.toggle('on'); document.getElementById('priv-{{ $key }}').value = this.classList.contains('on') ? '1' : '0'">
          </div>
          <input type="hidden" name="{{ $key }}" id="priv-{{ $key }}"
            value="{{ ($privacy[$key] ?? true) ? '1' : '0' }}"/>
        </div>
      @endforeach
    </div>
    <div class="lj-form-footer">
      <button type="submit" class="lj-btn lj-btn-primary">
        <i class="fa-solid fa-check"></i> Save Privacy Settings
      </button>
    </div>
  </form>
</div>

{{-- Account Info --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-circle-info"></i> Account Information</div>
  </div>
  <div class="lj-card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:10px;padding:14px 16px;">
        <div style="font-size:.7rem;font-weight:700;color:var(--n400);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Account Created</div>
        <div style="font-weight:600;color:var(--n800);font-size:.875rem;">
          {{ auth()->user()->created_at->format('d M Y') }}
        </div>
      </div>
      <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:10px;padding:14px 16px;">
        <div style="font-size:.7rem;font-weight:700;color:var(--n400);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Last Login</div>
        <div style="font-weight:600;color:var(--n800);font-size:.875rem;">
          {{ auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() : 'Just now' }}
        </div>
      </div>
      <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:10px;padding:14px 16px;">
        <div style="font-size:.7rem;font-weight:700;color:var(--n400);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Email</div>
        <div style="font-weight:600;color:var(--n800);font-size:.875rem;">{{ auth()->user()->email }}</div>
      </div>
      <div style="background:var(--n50);border:1.5px solid var(--n100);border-radius:10px;padding:14px 16px;">
        <div style="font-size:.7rem;font-weight:700;color:var(--n400);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;">Account ID</div>
        <div style="font-weight:600;color:var(--n800);font-size:.875rem;">#{{ auth()->user()->id }}</div>
      </div>
    </div>
  </div>
</div>

{{-- Danger Zone --}}
<div class="lj-card">
  <div class="lj-card-head">
    <div class="lj-card-title" style="color:var(--red);">
      <i class="fa-solid fa-triangle-exclamation" style="color:var(--red);"></i> Danger Zone
    </div>
  </div>
  <div class="lj-card-body">
    <div class="lj-danger-zone">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:20px;flex-wrap:wrap;">
        <div>
          <div style="font-weight:700;color:var(--red);font-size:.9rem;margin-bottom:6px;">Delete My Account</div>
          <div style="font-size:.82rem;color:#b91c1c;line-height:1.6;max-width:480px;">
            Once you delete your account, all your data — including your profile, resume, applications, and saved jobs — will be permanently removed. <strong>This action cannot be undone.</strong>
          </div>
        </div>
        <button type="button" class="lj-btn lj-btn-danger" onclick="confirmDeleteAccount()" style="flex-shrink:0;">
          <i class="fa-solid fa-trash"></i> Delete My Account
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Delete Account Modal --}}
<div id="deleteAccountModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;display:none;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;padding:28px;max-width:420px;width:100%;box-shadow:var(--shadow-lg);">
    <div style="text-align:center;margin-bottom:20px;">
      <div style="width:56px;height:56px;border-radius:50%;background:var(--red-light);border:2px solid #fecaca;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.4rem;color:var(--red);">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div style="font-family:var(--f-display);font-size:1.1rem;font-weight:800;color:var(--n900);margin-bottom:6px;">Delete Account?</div>
      <div style="font-size:.84rem;color:var(--n600);line-height:1.6;">
        This will permanently delete all your data. Type your password to confirm.
      </div>
    </div>
    <form method="POST" action="{{ route('jobseeker.dashboard.settings.delete') }}">
      @csrf @method('DELETE')
      <div class="lj-fgroup" style="margin-bottom:16px;">
        <label class="lj-label">Enter your password to confirm</label>
        <div class="lj-input-wrap">
          <i class="fa-solid fa-lock lj-input-ico"></i>
          <input class="lj-input has-ico" type="password" name="confirm_password" placeholder="Your current password" required/>
        </div>
      </div>
      <div style="display:flex;gap:10px;">
        <button type="button" onclick="closeDeleteModal()" class="lj-btn lj-btn-outline" style="flex:1;justify-content:center;">
          Cancel
        </button>
        <button type="submit" class="lj-btn lj-btn-danger" style="flex:1;justify-content:center;">
          <i class="fa-solid fa-trash"></i> Yes, Delete
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
// Password strength checker
function checkPasswordStrength(val) {
  const bar   = document.getElementById('pwdBar');
  const label = document.getElementById('pwdStrengthLabel');
  let score = 0;
  if (val.length >= 8)  score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const map = [
    [0, '0%', 'var(--n200)', ''],
    [1, '25%', 'var(--red)', 'Weak'],
    [2, '50%', 'var(--orange)', 'Fair'],
    [3, '75%', 'var(--blue)', 'Good'],
    [4, '100%', 'var(--green)', 'Strong'],
  ];
  const [, width, color, text] = map[score];
  bar.style.width   = width;
  bar.style.background = color;
  label.textContent = text;
  label.style.color = color;
}

// Password match checker
function checkPasswordMatch() {
  const np = document.getElementById('newPassword').value;
  const cp = document.getElementById('confirmPassword').value;
  const msg = document.getElementById('pwdMatchMsg');
  if (!cp) { msg.style.display = 'none'; return; }
  msg.style.display = 'block';
  if (np === cp) {
    msg.textContent = '✓ Passwords match';
    msg.style.color = 'var(--green)';
  } else {
    msg.textContent = '✗ Passwords do not match';
    msg.style.color = 'var(--red)';
  }
}

function resetPasswordForm() {
  document.getElementById('pwdBar').style.width = '0%';
  document.getElementById('pwdStrengthLabel').textContent = '';
  document.getElementById('pwdMatchMsg').style.display = 'none';
}

// Toggle pref + update hidden input
function togglePref(el, key) {
  el.classList.toggle('on');
  document.getElementById('input-' + key).value = el.classList.contains('on') ? '1' : '0';
}

// Delete account modal
function confirmDeleteAccount() {
  document.getElementById('deleteAccountModal').style.display = 'flex';
}
function closeDeleteModal() {
  document.getElementById('deleteAccountModal').style.display = 'none';
}
// Close on outside click
document.getElementById('deleteAccountModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});
</script>
@endpush