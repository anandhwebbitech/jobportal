{{-- profile.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'My Profile')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<style>
  .chip-select{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.skill-chip{
    padding:8px 16px;
    border:1px solid #d8dfea;
    border-radius:30px;
    background:#fff;
    color:#4b5563;
    font-size:14px;
    cursor:pointer;
    transition:all .2s ease;
    user-select:none;
}

.skill-chip:hover{
    border-color:#2563eb;
    color:#2563eb;
}

.skill-chip.active{
    background:#2563eb;
    border-color:#2563eb;
    color:#fff;
}
</style>
@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">My Profile</div>
    <div class="lj-page-subtitle">Keep your profile updated to get better job matches.</div>
  </div>
</div>

{{-- ── PERSONAL INFORMATION ── --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-user"></i> Personal Information</div>
  </div>
  <form id="profileForm" method="POST" action="{{ route('jobseeker.profile.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="lj-card-body">

      {{-- Avatar --}}
      <div class="lj-avatar-upload">
        <div class="lj-avatar-preview" id="avatarPreview">
          {{-- @dd($user->details->profile_photo); --}}
          @if($user->details->profile_photo ?? false)
            <img src="{{ asset('public/uploads/photos/'.$user->details->profile_photo) }}" alt="{{ auth()->user()->name }}" id="avatarImg"/>
          @else
            @php $initials = strtoupper(substr(auth()->user()->name ?? 'U', 0, 1).substr(strrchr(auth()->user()->name ?? '', ' '), 1, 1)); @endphp
            <span id="avatarInitials">{{ $initials }}</span>
          @endif
          <label for="profilePhotoInput" class="lj-avatar-edit-btn" title="Change photo">
            <i class="fa-solid fa-pen"></i>
          </label>
          <input type="file" id="profilePhotoInput" name="profile_photo" accept="image/*" style="display:none;" onchange="previewAvatar(this)"/>
        </div>
        <div class="lj-avatar-info">
          <strong>Profile Photo</strong>
          Upload a clear, professional photo. JPG or PNG, max 2 MB.<br>
          A photo makes your profile 5× more likely to be noticed.
          <div style="margin-top:8px;">
            <label for="profilePhotoInput" class="lj-btn lj-btn-outline lj-btn-sm" style="cursor:pointer;">
              <i class="fa-solid fa-upload"></i> Upload Photo
            </label>
          </div>
        </div>
      </div>

      <div class="lj-form-grid">
        <div class="lj-fgroup">
          <label class="lj-label">Full Name <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-user lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="name"
              value="{{ old('name', $user->name ?? '') }}"
              placeholder="Your full name" required/>
          </div>
          @error('name')<div style="font-size:.72rem;color:var(--red);margin-top:3px;">{{ $message }}</div>@enderror
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Mobile Number <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-mobile-screen lj-input-ico"></i>
            <input class="lj-input has-ico" type="tel" name="mobile"
              value="{{ old('mobile', $user->details->mobile ?? '') }}"
              placeholder="+91 XXXXX XXXXX" maxlength="15" required/>
          </div>
          @error('mobile')<div style="font-size:.72rem;color:var(--red);margin-top:3px;">{{ $message }}</div>@enderror
        </div>
        <div class="lj-fgroup full">
          <label class="lj-label">Email Address <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-envelope lj-input-ico"></i>
            <input class="lj-input has-ico" type="email" name="email"
              value="{{ old('email',  $user->email?? '') }}"
              placeholder="you@example.com" required/>
          </div>
          @error('email')<div style="font-size:.72rem;color:var(--red);margin-top:3px;">{{ $message }}</div>@enderror
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Date of Birth</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-calendar lj-input-ico"></i>
            <input class="lj-input has-ico" type="date" name="dob"
              value="{{ old('dob', $user->details->dob ?? '') }}"/>
          </div>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Gender</label>
          <select class="lj-input" name="gender">
            <option value="">Select gender</option>
            @foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $val => $label)
              <option value="{{ $val }}" 
                {{ old('gender', optional($user->details)->gender) == $val ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="lj-fgroup full">
          <label class="lj-label">About / Bio <span style="font-size:.7rem;color:var(--n400);margin-left:5px;background:var(--n100);padding:1px 6px;border-radius:100px;">Optional</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-align-left lj-input-ico ta"></i>
            <textarea class="lj-input has-ico" name="bio" rows="3"
              placeholder="Brief description of yourself and your career goals...">{{ old('bio', $user->details->bio ?? '') }}</textarea>
          </div>
        </div>
      </div>

      <div class="lj-form-divider"><i class="fa-solid fa-location-dot"></i> Location</div>
      <div class="lj-form-grid-3">
        <div class="lj-fgroup">
          <label class="lj-label">State <span class="req">*</span></label>
          <select class="lj-input" id="profileStateSel" name="state" required>
            <option value="">Select state</option>

            <option value="Andhra Pradesh" {{ old('state', $user->details->state ?? '') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>

            <option value="Arunachal Pradesh" {{ old('state', $user->details->state ?? '') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>

            <option value="Assam" {{ old('state', $user->details->state ?? '') == 'Assam' ? 'selected' : '' }}>Assam</option>

            <option value="Bihar" {{ old('state', $user->details->state ?? '') == 'Bihar' ? 'selected' : '' }}>Bihar</option>

            <option value="Chhattisgarh" {{ old('state', $user->details->state ?? '') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>

            <option value="Goa" {{ old('state', $user->details->state ?? '') == 'Goa' ? 'selected' : '' }}>Goa</option>

            <option value="Gujarat" {{ old('state', $user->details->state ?? '') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>

            <option value="Haryana" {{ old('state', $user->details->state ?? '') == 'Haryana' ? 'selected' : '' }}>Haryana</option>

            <option value="Himachal Pradesh" {{ old('state', $user->details->state ?? '') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>

            <option value="Jharkhand" {{ old('state', $user->details->state ?? '') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>

            <option value="Karnataka" {{ old('state', $user->details->state ?? '') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>

            <option value="Kerala" {{ old('state', $user->details->state ?? '') == 'Kerala' ? 'selected' : '' }}>Kerala</option>

            <option value="Madhya Pradesh" {{ old('state', $user->details->state ?? '') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>

            <option value="Maharashtra" {{ old('state', $user->details->state ?? '') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>

            <option value="Manipur" {{ old('state', $user->details->state ?? '') == 'Manipur' ? 'selected' : '' }}>Manipur</option>

            <option value="Meghalaya" {{ old('state', $user->details->state ?? '') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>

            <option value="Mizoram" {{ old('state', $user->details->state ?? '') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>

            <option value="Nagaland" {{ old('state', $user->details->state ?? '') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>

            <option value="Odisha" {{ old('state', $user->details->state ?? '') == 'Odisha' ? 'selected' : '' }}>Odisha</option>

            <option value="Punjab" {{ old('state', $user->details->state ?? '') == 'Punjab' ? 'selected' : '' }}>Punjab</option>

            <option value="Rajasthan" {{ old('state', $user->details->state ?? '') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>

            <option value="Sikkim" {{ old('state', $user->details->state ?? '') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>

            <option value="Tamil Nadu" {{ old('state', $user->details->state ?? '') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>

            <option value="Telangana" {{ old('state', $user->details->state ?? '') == 'Telangana' ? 'selected' : '' }}>Telangana</option>

            <option value="Tripura" {{ old('state', $user->details->state ?? '') == 'Tripura' ? 'selected' : '' }}>Tripura</option>

            <option value="Uttar Pradesh" {{ old('state', $user->details->state ?? '') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>

            <option value="Uttarakhand" {{ old('state', $user->details->state ?? '') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>

            <option value="West Bengal" {{ old('state', $user->details->state ?? '') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>

          </select>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">District <span class="req">*</span></label>
          <select class="lj-input"  id="profileDistrictSel" name="district" required>
            <option value="">Select district</option>
           
          </select>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">City / Town</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-city lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="city"
              value="{{ old('city', $user->details->city ?? '') }}" placeholder="e.g. Coimbatore"/>
          </div>
        </div>
      </div>
    </div>
    <div class="lj-form-footer">
      <button type="button" class="lj-btn lj-btn-outline" onclick="history.back()">Cancel</button>
      <button type="submit" class="lj-btn lj-btn-primary"><i class="fa-solid fa-check"></i> Save Changes</button>
    </div>
  </form>
</div>

{{-- ── EDUCATION ── --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-graduation-cap"></i> Education</div>
  </div>
  <form id="educationForm" method="POST" action="{{ route('jobseeker.profile.education') }}">
    @csrf @method('PUT')
    <div class="lj-card-body">
      <div class="lj-form-grid">
        <div class="lj-fgroup">
            <label class="lj-label">Education Level <span class="req">*</span></label>
            <select class="lj-input" name="education_level" required>
              <option value="">Select level</option>

              @foreach($qualifications as $qualification)
                  <option value="{{ $qualification->id }}"
                      {{ old('education_level', $user->details->qualification ?? '') == $qualification->id ? 'selected' : '' }}>
                      
                      {{ $qualification->qualification }}
                  </option>
              @endforeach
            </select>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Institution Name <span class="req">*</span></label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-school lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="institution"
              value="{{ old('institution_name', $user->details->institution_name ?? '') }}"
              placeholder="College / School name" required/>
          </div>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Course / Degree</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-book lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="course"
              value="{{ old('course_degree', $user->details->course_degree ?? '') }}" placeholder="e.g. B.E. Computer Science"/>
          </div>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Specialization</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-flask lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="specialization"
              value="{{ old('specialization', $user->details->specialization ?? '') }}" placeholder="e.g. Software Engineering"/>
          </div>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Year of Passing <span class="req">*</span></label>
          <select class="lj-input" name="passing_year" required>
            <option value="">Select year</option>
            @for($y = date('Y'); $y >= 1990; $y--)
              <option value="{{ $y }}" {{ old('year_of_passing', $user->details->year_of_passing ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Percentage / CGPA</label>
          <div class="lj-input-wrap">
            <i class="fa-solid fa-percent lj-input-ico"></i>
            <input class="lj-input has-ico" type="text" name="grade"
              value="{{ old('percentage', $user->details->percentage ?? '') }}" placeholder="e.g. 78% or 8.5 CGPA"/>
          </div>
        </div>  
      </div>
    </div>
    <div class="lj-form-footer">
      <button type="submit" class="lj-btn lj-btn-primary"><i class="fa-solid fa-check"></i> Save Education</button>
    </div>
  </form>
</div>

{{-- ── WORK EXPERIENCE ── --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-briefcase"></i> Work Experience</div>
  </div>
  <form id="experienceForm" method="POST" action="{{ route('jobseeker.profile.experience') }}">
    @csrf @method('PUT')
    <div class="lj-card-body">
      <div class="lj-form-grid">
        <div class="lj-fgroup">
          <label class="lj-label">Experience Level <span class="req">*</span></label>
          <select class="lj-input" name="experience_level" required onchange="toggleExpFields(this.value)">
            <option value="fresher"     {{ old('exp', $user->details->exp) == 'fresher'     ? 'selected' : '' }}>Fresher</option>
            <option value="experienced" {{ old('exp', $user->details->exp) == 'experienced' ? 'selected' : '' }}>Experienced</option>
          </select>
        </div>
        <div class="lj-fgroup">
          <label class="lj-label">Total Years of Experience</label>
          <select class="lj-input" name="years_experience">
            <option value="">Select (if experienced)</option>
            <option value="less_1" {{ old('ex_years',$user->details->ex_years) == 'less_1' ? 'selected' : '' }}>Less than 1 year</option>
            @for($y = 1; $y <= 15; $y++)
              <option value="{{ $y }}" {{ old('ex_years', $user->details->ex_years) == $y ? 'selected' : '' }}>{{ $y }} {{ $y == 1 ? 'year' : 'years' }}</option>
            @endfor
            <option value="15+" {{ old('ex_years',$user->details->ex_years) == '15+' ? 'selected' : '' }}>15+ years</option>
          </select>
        </div>
      </div>

      <div id="expExtraFields" style="{{ old('ex_years', $user->details->ex_years ?? 'fresher') == 'experienced' ? '' : 'display:none;' }}">
        <div class="lj-form-divider"><i class="fa-solid fa-briefcase"></i> Previous Employment</div>
        <div class="lj-form-grid">
          <div class="lj-fgroup">
            <label class="lj-label">Previous Company</label>
            <div class="lj-input-wrap">
              <i class="fa-solid fa-building lj-input-ico"></i>
              <input class="lj-input has-ico" type="text" name="previous_company"
                value="{{ old('previous_company',$user->details->previous_company) }}" placeholder="Company name"/>
            </div>
          </div>
          <div class="lj-fgroup">
            <label class="lj-label">Previous Job Title</label>
            <div class="lj-input-wrap">
              <i class="fa-solid fa-id-badge lj-input-ico"></i>
              <input class="lj-input has-ico" type="text" name="previous_designation"
                value="{{ old('previous_designation', $user->details->previous_designation) }}" placeholder="e.g. Junior PHP Developer"/>
            </div>
          </div>
          <div class="lj-fgroup">
            <label class="lj-label">Current / Last Salary</label>
            <div class="lj-input-wrap">
              <i class="fa-solid fa-indian-rupee-sign lj-input-ico"></i>
              <input class="lj-input has-ico" type="text" name="current_salary"
                value="{{ old('last_salary', $user->details->last_salary ?? '') }}" placeholder="e.g. ₹25,000/month"/>
            </div>
          </div>
          <div class="lj-fgroup">
            <label class="lj-label">Notice Period</label>
            <select class="lj-input" name="notice_period">
              <option value="">Select notice period</option>
              @php $notices = ['immediate'=>'Immediate / Available Now','1_week'=>'Within 1 Week','2_weeks'=>'Within 2 Weeks','1_month'=>'Within 1 Month','2_months'=>'Within 2 Months','3_months'=>'3+ Months']; @endphp
              @foreach($notices as $val => $label)
                <option value="{{ $val }}" {{ old('notice_period', auth()->user()?->notice_period) == $val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>
          <div class="lj-fgroup full">
            <label class="lj-label">Job Description / Responsibilities</label>
            <div class="lj-input-wrap">
              <i class="fa-solid fa-align-left lj-input-ico ta"></i>
              <textarea class="lj-input has-ico" name="experience_description" rows="3"
                placeholder="Briefly describe your role and key responsibilities...">{{ old('experience_description', auth()->user()?->experience_description) }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="lj-form-footer">
      <button type="submit" class="lj-btn lj-btn-primary"><i class="fa-solid fa-check"></i> Save Experience</button>
    </div>
  </form>
</div>

{{-- ── SKILLS ── --}}
<div class="lj-card lj-section-gap">
  <div class="lj-card-head">
    <div class="lj-card-title"><i class="fa-solid fa-screwdriver-wrench"></i> Skills</div>
  </div>
  <form id="skillsForm" method="POST" action="{{ route('jobseeker.profile.skills') }}">
    @csrf @method('PUT')
    <div class="lj-card-body">
      <div class="lj-info-box">
        <i class="fa-solid fa-circle-info"></i>
        Click skills to select or deselect. These help employers find you and improve job recommendations.
      </div>

      <div style="font-size:.78rem;font-weight:600;color:var(--n600);margin-bottom:9px;">Your Current Skills</div>
      <div class="lj-skill-cloud" style="margin-bottom:18px;" id="selectedSkillsCloud">
        @php
          $userSkills = !empty($user->details->skills)
              ? explode(',', $user->details->skills)
              : [];
        @endphp
        @foreach($userSkills as $skill)
          <span class="lj-skill-tag selected">
              {{ trim($skill) }}
              <input type="hidden" name="skills[]" value="{{ trim($skill) }}">
              <span class="rm"><i class="fa-solid fa-xmark"></i></span>
          </span>
        @endforeach
      </div>

      <div style="font-size:.78rem;font-weight:600;color:var(--n600);margin-bottom:9px;">Add More Skills</div>
        <div class="chip-select" id="suggestedSkills">

            @php
                $selectedSkills = array_map('trim', $userSkills);
            @endphp

            @foreach($skills as $skill)

                @php
                    $isSelected = in_array($skill->skill_name, $selectedSkills);
                @endphp

                <span class="skill-chip {{ $isSelected ? 'active' : '' }}"
                      data-skill="{{ $skill->skill_name }}">

                    {{ $skill->skill_name }}

                </span>

            @endforeach

        </div>

      <div style="display:flex;gap:8px;margin-top:13px;">
        <div class="lj-input-wrap" style="flex:1;">
          <i class="fa-solid fa-plus lj-input-ico"></i>
          <input class="lj-input has-ico" type="text" id="customSkillInput" placeholder="Add a custom skill and press Enter"/>
        </div>
        <button type="button" class="lj-btn lj-btn-outline" onclick="addCustomSkill()">
          <i class="fa-solid fa-plus"></i> Add
        </button>
      </div>
    </div>
    <div class="lj-form-footer">
      <button type="submit" class="lj-btn lj-btn-primary"><i class="fa-solid fa-check"></i> Save Skills</button>
    </div>
  </form>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>
<script>
function toggleExpFields(val) {
  document.getElementById('expExtraFields').style.display = val === 'experienced' ? 'block' : 'none';
}
function addSkill(skillName, chipEl) {
  if (chipEl && chipEl.remove) chipEl.remove();
  const cloud = document.getElementById('selectedSkillsCloud');
  const tag = document.createElement('span');
  tag.className = 'lj-skill-tag selected';
  tag.innerHTML = `${skillName}<input type="hidden" name="skills[]" value="${skillName}"/><span class="rm"><i class="fa-solid fa-xmark"></i></span>`;
  tag.querySelector('.rm').addEventListener('click', function(e) {
    e.stopPropagation(); tag.remove();
    const sug = document.getElementById('suggestedSkills');
    const newChip = document.createElement('span');
    newChip.className = 'chip'; newChip.textContent = skillName;
    newChip.onclick = () => addSkill(skillName, newChip);
    sug.appendChild(newChip);
  });
  cloud.appendChild(tag);
}
function addCustomSkill() {
  const inp = document.getElementById('customSkillInput');
  const val = inp.value.trim(); if (!val) return;
  addSkill(val, null); inp.value = '';
}
document.getElementById('customSkillInput').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') { e.preventDefault(); addCustomSkill(); }
});
function previewAvatar(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview  = document.getElementById('avatarPreview');
      const initials = document.getElementById('avatarInitials');
      if (initials) initials.style.display = 'none';
      let img = preview.querySelector('img#avatarImg');
      if (!img) {
        img = document.createElement('img');
        img.id = 'avatarImg';
        img.style = 'width:100%;height:100%;object-fit:cover;border-radius:50%;';
        preview.insertBefore(img, preview.querySelector('.lj-avatar-edit-btn'));
      }
      img.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$('#profileForm').on('submit', function(e) {
    e.preventDefault(); // 🔥 VERY IMPORTANT

    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            toastr.success(res.message); // ✅ success toast
        },

        error: function(err) {
            if (err.status === 422) {
                let errors = err.responseJSON.errors;

                // loop validation errors
                $.each(errors, function(key, value) {
                    toastr.error(value[0]); // ❌ show each error
                });
            } else {
                toastr.error('Something went wrong!');
            }
        }
    });
});
$(document).ready(function () {

    // ✅ EDUCATION AJAX
    $('#educationForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(res) {
                toastr.success(res.message);
            },

            error: function(err) {
                handleErrors(err);
            }
        });
    });


    // ✅ EXPERIENCE AJAX
    $('#experienceForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(res) {
                toastr.success(res.message);
            },

            error: function(err) {
                handleErrors(err);
            }
        });
    });


    // ✅ COMMON ERROR HANDLER
    function handleErrors(err) {
        if (err.status === 422) {
            let errors = err.responseJSON.errors;

            $.each(errors, function(key, value) {
                toastr.error(value[0]);
            });
        } else {
            toastr.error('Something went wrong!');
        }
    }

});
$(document).ready(function () {

    $('#skillsForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);

        // ✅ collect skills dynamically
        let skills = [];
        $('#selectedSkillsCloud .lj-skill-tag').each(function () {
            skills.push($(this).text().trim());
        });

        let formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');

        // append skills array
        skills.forEach(skill => {
            formData.append('skills[]', skill);
        });

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                toastr.success(res.message);
            },

            error: function(err) {
                if (err.status === 422) {
                    let errors = err.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });

});
// ADD skill
$(document).on('click', '.skill-chip', function () {

    let skill = $(this).data('skill');

    // already selected
    if ($('#selectedSkillsCloud input[value="' + skill + '"]').length) {
        return;
    }

    // active style
    $(this).addClass('active');

    $('#selectedSkillsCloud').append(`
        <span class="lj-skill-tag selected" data-skill="${skill}">
            ${skill}
            <input type="hidden" name="skills[]" value="${skill}">
            <span class="rm">
                <i class="fa-solid fa-xmark"></i>
            </span>
        </span>
    `);

});


// REMOVE skill
$(document).on('click', '.lj-skill-tag .rm', function () {

    let parent = $(this).closest('.lj-skill-tag');

    let skill = parent.data('skill');

    // remove active class from chip
    $('.skill-chip[data-skill="' + skill + '"]').removeClass('active');

    // remove selected tag
    parent.remove();

});

document.addEventListener('DOMContentLoaded', function () {

    const stateSel = document.getElementById('profileStateSel');
    const districtSel = document.getElementById('profileDistrictSel');

    const selectedDistrict = "{{ old('district', $user->details->district ?? '') }}";

    async function loadDistricts(state, selected = '') {

        districtSel.innerHTML =
            '<option value="">Loading...</option>';

        try {

            let response = await fetch(
                'https://countriesnow.space/api/v0.1/countries/state/cities',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        country: 'India',
                        state: state
                    })
                }
            );

            let result = await response.json();

            districtSel.innerHTML =
                '<option value="">Select District</option>';

            if (result.data && result.data.length > 0) {

                result.data.forEach(function (district) {

                    let opt = document.createElement('option');

                    opt.value = district;
                    opt.textContent = district;

                    if (district === selected) {
                        opt.selected = true;
                    }

                    districtSel.appendChild(opt);

                });

            } else {

                districtSel.innerHTML =
                    '<option value="">No District Found</option>';
            }

        } catch (error) {

            console.error(error);

            districtSel.innerHTML =
                '<option value="">Error loading districts</option>';
        }
    }

    stateSel.addEventListener('change', function () {

        let state = this.value;

        if (!state) {

            districtSel.innerHTML =
                '<option value="">Select District</option>';

            return;
        }

        loadDistricts(state);
    });

    // Edit mode existing district load
    if (stateSel.value) {
        loadDistricts(stateSel.value, selectedDistrict);
    }

});

        
</script>
@endpush