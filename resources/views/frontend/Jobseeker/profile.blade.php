{{-- ═══════════════════════════════════════════════════════
     resources/views/frontend/jobseeker/profile.blade.php
     My Profile – LinearJobs Job Seeker Dashboard
═══════════════════════════════════════════════════════ --}}
@extends('frontend.jobseeker.layout')
@section('title', 'My Profile')

@section('content')

    <div class="lj-page-header">
        <div>
            <div class="lj-page-title">My Profile</div>
            <div class="lj-page-subtitle">Keep your profile updated to get better job matches.</div>
        </div>
    </div>

    {{-- ── PERSONAL INFORMATION ──────────────────────────── --}}
    <div class="lj-card lj-section-gap">
        <div class="lj-card-head">
            <div class="lj-card-title"><i class="fa-solid fa-user"></i> Personal Information</div>
        </div>
        <form method="POST" action="{{ route('jobseeker.dashboard.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="lj-card-body">

                {{-- Avatar Upload --}}
                <div class="lj-avatar-upload">
                    <div class="lj-avatar-preview" id="avatarPreview">
                        @if (auth()->user()?->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                alt="{{ auth()->user()->name }}" id="avatarImg" />
                        @else
                            @php $initials = strtoupper(substr(auth()->user()->name ?? 'U', 0, 1) . substr(strrchr(auth()->user()->name ?? '', ' '), 1, 1)); @endphp
                            <span id="avatarInitials">{{ $initials }}</span>
                        @endif
                        <label for="profilePhotoInput" class="lj-avatar-edit-btn" title="Change photo">
                            <i class="fa-solid fa-pen"></i>
                        </label>
                        <input type="file" id="profilePhotoInput" name="profile_photo" accept="image/*"
                            style="display:none;" onchange="previewAvatar(this)" />
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

                {{-- Name & Mobile --}}
                <div class="lj-form-grid">
                    <div class="lj-fgroup">
                        <label class="lj-label">Full Name <span class="req">*</span></label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-user lj-input-ico"></i>
                            <input class="lj-input has-ico @error('name') border-red-400 @enderror" type="text"
                                name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Your full name"
                                required />
                        </div>
                        @error('name')
                            <div style="font-size:.73rem;color:var(--red);margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Mobile Number <span class="req">*</span></label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-mobile-screen lj-input-ico"></i>
                            <input class="lj-input has-ico" type="tel" name="mobile"
                                value="{{ old('mobile', auth()->user()->mobile) }}" placeholder="+91 XXXXX XXXXX"
                                maxlength="15" required />
                        </div>
                        @error('mobile')
                            <div style="font-size:.73rem;color:var(--red);margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="lj-fgroup full">
                        <label class="lj-label">Email Address <span class="req">*</span></label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-envelope lj-input-ico"></i>
                            <input class="lj-input has-ico" type="email" name="email"
                                value="{{ old('email', auth()->user()->email) }}" placeholder="you@example.com" required />
                        </div>
                        @error('email')
                            <div style="font-size:.73rem;color:var(--red);margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Date of Birth</label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-calendar lj-input-ico"></i>
                            <input class="lj-input has-ico" type="date" name="dob"
                                value="{{ old('dob', auth()->user()->dob) }}" />
                        </div>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Gender</label>
                        <select class="lj-input" name="gender">
                            <option value="">Select gender</option>
                            <option value="male"
                                {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female"
                                {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"
                                {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Other / Prefer
                                not to say</option>
                        </select>
                    </div>
                    <div class="lj-fgroup full">
                        <label class="lj-label">About / Bio <span
                                style="font-size:.72rem;color:var(--n400);margin-left:6px;background:var(--n100);padding:1px 7px;border-radius:100px;">Optional</span></label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-align-left lj-input-ico ta"></i>
                            <textarea class="lj-input has-ico" name="bio" rows="3"
                                placeholder="Brief description of yourself and your career goals...">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div class="lj-form-divider"><i class="fa-solid fa-location-dot"></i> Location</div>
                <div class="lj-form-grid-3">
                    <div class="lj-fgroup">
                        <label class="lj-label">State <span class="req">*</span></label>
                        <select class="lj-input" name="state" required>
                            <option value="">Select state</option>
                            @php $states = ['Tamil Nadu','Karnataka','Kerala','Andhra Pradesh','Telangana','Maharashtra','Gujarat','Rajasthan','Uttar Pradesh','Delhi']; @endphp
                            @foreach ($states as $s)
                                <option value="{{ $s }}"
                                    {{ old('state', auth()->user()->state) == $s ? 'selected' : '' }}>{{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">District <span class="req">*</span></label>
                        <select class="lj-input" name="district" required>
                            <option value="">Select district</option>
                            @php $districts = ['Coimbatore','Chennai','Madurai','Tiruchirappalli','Salem','Tirunelveli','Erode','Vellore','Thanjavur','Dindigul','Kanchipuram','Tiruppur','Nagercoil','Cuddalore','Pollachi','Hosur','Ooty','Karur','Namakkal']; @endphp
                            @foreach ($districts as $d)
                                <option value="{{ $d }}"
                                    {{ old('district', auth()->user()->district) == $d ? 'selected' : '' }}>
                                    {{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">City / Town</label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-city lj-input-ico"></i>
                            <input class="lj-input has-ico" type="text" name="city"
                                value="{{ old('city', auth()->user()->city) }}" placeholder="e.g. Coimbatore" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="lj-form-footer">
                <button type="button" class="lj-btn lj-btn-outline" onclick="history.back()">Cancel</button>
                <button type="submit" class="lj-btn lj-btn-primary">
                    <i class="fa-solid fa-check"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- ── EDUCATION ──────────────────────────────────────── --}}
    <div class="lj-card lj-section-gap">
        <div class="lj-card-head">
            <div class="lj-card-title"><i class="fa-solid fa-graduation-cap"></i> Education</div>
        </div>
        <form method="POST" action="{{ route('jobseeker.dashboard.profile.education') }}">
            @csrf @method('PUT')
            <div class="lj-card-body">
                <div class="lj-form-grid">
                    <div class="lj-fgroup">
                        <label class="lj-label">Education Level <span class="req">*</span></label>
                        <select class="lj-input" name="education_level" required>
                            <option value="">Select level</option>
                            @php $levels = ['10th Pass (SSLC)'=>'10th','12th Pass (HSC)'=>'12th','Diploma'=>'diploma','Bachelor\'s Degree'=>'bachelor','Master\'s Degree'=>'master','Doctorate / PhD'=>'doctorate']; @endphp
                            @foreach ($levels as $label => $val)
                                <option value="{{ $val }}"
                                    {{ old('education_level', auth()->user()->education_level) == $val ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Institution Name <span class="req">*</span></label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-school lj-input-ico"></i>
                            <input class="lj-input has-ico" type="text" name="institution"
                                value="{{ old('institution', auth()->user()->institution) }}"
                                placeholder="College / School name" required />
                        </div>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Course / Degree</label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-book lj-input-ico"></i>
                            <input class="lj-input has-ico" type="text" name="course"
                                value="{{ old('course', auth()->user()->course) }}"
                                placeholder="e.g. B.E. Computer Science" />
                        </div>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Specialization</label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-flask lj-input-ico"></i>
                            <input class="lj-input has-ico" type="text" name="specialization"
                                value="{{ old('specialization', auth()->user()->specialization) }}"
                                placeholder="e.g. Software Engineering" />
                        </div>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Year of Passing <span class="req">*</span></label>
                        <select class="lj-input" name="passing_year" required>
                            <option value="">Select year</option>
                            @for ($y = date('Y'); $y >= 1990; $y--)
                                <option value="{{ $y }}"
                                    {{ old('passing_year', auth()->user()->passing_year) == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Percentage / CGPA</label>
                        <div class="lj-input-wrap">
                            <i class="fa-solid fa-percent lj-input-ico"></i>
                            <input class="lj-input has-ico" type="text" name="grade"
                                value="{{ old('grade', auth()->user()->grade) }}" placeholder="e.g. 78% or 8.5 CGPA" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="lj-form-footer">
                <button type="submit" class="lj-btn lj-btn-primary">
                    <i class="fa-solid fa-check"></i> Save Education
                </button>
            </div>
        </form>
    </div>

    {{-- ── WORK EXPERIENCE ────────────────────────────────── --}}
    <div class="lj-card lj-section-gap">
        <div class="lj-card-head">
            <div class="lj-card-title"><i class="fa-solid fa-briefcase"></i> Work Experience</div>
        </div>
        <form method="POST" action="{{ route('jobseeker.dashboard.profile.experience') }}">
            @csrf @method('PUT')
            <div class="lj-card-body">
                <div class="lj-form-grid">
                    <div class="lj-fgroup">
                        <label class="lj-label">Experience Level <span class="req">*</span></label>
                        <select class="lj-input" name="experience_level" required onchange="toggleExpFields(this.value)">
                            <option value="fresher"
                                {{ old('experience_level', auth()->user()->experience_level) == 'fresher' ? 'selected' : '' }}>
                                Fresher</option>
                            <option value="experienced"
                                {{ old('experience_level', auth()->user()->experience_level) == 'experienced' ? 'selected' : '' }}>
                                Experienced</option>
                        </select>
                    </div>
                    <div class="lj-fgroup">
                        <label class="lj-label">Total Years of Experience</label>
                        <select class="lj-input" name="years_experience">
                            <option value="">Select (if experienced)</option>
                            <option value="less_1"
                                {{ old('years_experience', auth()->user()->years_experience) == 'less_1' ? 'selected' : '' }}>
                                Less than 1 year</option>
                            @for ($y = 1; $y <= 15; $y++)
                                <option value="{{ $y }}"
                                    {{ old('years_experience', auth()->user()->years_experience) == $y ? 'selected' : '' }}>
                                    {{ $y }} {{ $y == 1 ? 'year' : 'years' }}
                                </option>
                            @endfor
                            <option value="15+"
                                {{ old('years_experience', auth()->user()->years_experience) == '15+' ? 'selected' : '' }}>
                                15+ years</option>
                        </select>
                    </div>
                </div>

                <div id="expExtraFields"
                    style="{{ old('experience_level', auth()->user()->experience_level ?? 'fresher') == 'experienced' ? '' : 'display:none;' }}">
                    <div class="lj-form-divider"><i class="fa-solid fa-briefcase"></i> Previous Employment</div>
                    <div class="lj-form-grid">
                        <div class="lj-fgroup">
                            <label class="lj-label">Previous Company</label>
                            <div class="lj-input-wrap">
                                <i class="fa-solid fa-building lj-input-ico"></i>
                                <input class="lj-input has-ico" type="text" name="previous_company"
                                    value="{{ old('previous_company', auth()->user()->previous_company) }}"
                                    placeholder="Company name" />
                            </div>
                        </div>
                        <div class="lj-fgroup">
                            <label class="lj-label">Previous Job Title</label>
                            <div class="lj-input-wrap">
                                <i class="fa-solid fa-id-badge lj-input-ico"></i>
                                <input class="lj-input has-ico" type="text" name="previous_designation"
                                    value="{{ old('previous_designation', auth()->user()->previous_designation) }}"
                                    placeholder="e.g. Junior PHP Developer" />
                            </div>
                        </div>
                        <div class="lj-fgroup">
                            <label class="lj-label">Current / Last Salary</label>
                            <div class="lj-input-wrap">
                                <i class="fa-solid fa-indian-rupee-sign lj-input-ico"></i>
                                <input class="lj-input has-ico" type="text" name="current_salary"
                                    value="{{ old('current_salary', auth()->user()->current_salary) }}"
                                    placeholder="e.g. ₹25,000/month" />
                            </div>
                        </div>
                        <div class="lj-fgroup">
                            <label class="lj-label">Notice Period</label>
                            <select class="lj-input" name="notice_period">
                                <option value="">Select notice period</option>
                                @php $notices = ['immediate'=>'Immediate / Available Now','1_week'=>'Within 1 Week','2_weeks'=>'Within 2 Weeks','1_month'=>'Within 1 Month','2_months'=>'Within 2 Months','3_months'=>'3+ Months']; @endphp
                                @foreach ($notices as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('notice_period', auth()->user()->notice_period) == $val ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lj-fgroup full">
                            <label class="lj-label">Job Description / Responsibilities</label>
                            <div class="lj-input-wrap">
                                <i class="fa-solid fa-align-left lj-input-ico ta"></i>
                                <textarea class="lj-input has-ico" name="experience_description" rows="3"
                                    placeholder="Briefly describe your role and key responsibilities...">{{ old('experience_description', auth()->user()->experience_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lj-form-footer">
                <button type="submit" class="lj-btn lj-btn-primary">
                    <i class="fa-solid fa-check"></i> Save Experience
                </button>
            </div>
        </form>
    </div>

    {{-- ── SKILLS ──────────────────────────────────────────── --}}
    <div class="lj-card lj-section-gap">
        <div class="lj-card-head">
            <div class="lj-card-title"><i class="fa-solid fa-screwdriver-wrench"></i> Skills</div>
        </div>
        <form method="POST" action="{{ route('jobseeker.dashboard.profile.skills') }}">
            @csrf @method('PUT')
            <div class="lj-card-body">
                <div class="lj-info-box">
                    <i class="fa-solid fa-circle-info"></i>
                    Click skills to select or deselect. These help employers find you and improve job recommendations.
                </div>

                <div style="font-size:.8rem;font-weight:600;color:var(--n600);margin-bottom:10px;">Your Current Skills
                </div>
                <div class="lj-skill-cloud" style="margin-bottom:20px;" id="selectedSkillsCloud">
                    @php $userSkills = auth()->user()->skills ?? ['PHP','Laravel','MySQL','JavaScript','HTML/CSS','Git']; @endphp
                    @foreach (is_array($userSkills) ? $userSkills : json_decode($userSkills, true) ?? [] as $skill)
                        <span class="lj-skill-tag selected">
                            {{ $skill }}
                            <input type="hidden" name="skills[]" value="{{ $skill }}" />
                            <span class="rm"><i class="fa-solid fa-xmark"></i></span>
                        </span>
                    @endforeach
                </div>

                <div style="font-size:.8rem;font-weight:600;color:var(--n600);margin-bottom:10px;">Add More Skills</div>
                <div class="chip-select" id="suggestedSkills">
                    @php
                        $allSkills = [
                            'React.js',
                            'Vue.js',
                            'Node.js',
                            'REST API',
                            'Docker',
                            'AWS',
                            'Redis',
                            'WordPress',
                            'Python',
                            'CodeIgniter',
                            'Angular',
                            'TypeScript',
                            'MongoDB',
                            'PostgreSQL',
                            'Linux',
                            'Nginx',
                            'jQuery',
                            'Bootstrap',
                            'Tailwind CSS',
                            'Figma',
                            'Photoshop',
                        ];
                    @endphp
                    @foreach ($allSkills as $s)
                        @if (!in_array($s, is_array($userSkills) ? $userSkills : json_decode($userSkills, true) ?? []))
                            <span class="chip"
                                onclick="addSkill('{{ $s }}', this)">{{ $s }}</span>
                        @endif
                    @endforeach
                </div>

                {{-- Custom skill input --}}
                <div style="display:flex;gap:10px;margin-top:14px;">
                    <div class="lj-input-wrap" style="flex:1;">
                        <i class="fa-solid fa-plus lj-input-ico"></i>
                        <input class="lj-input has-ico" type="text" id="customSkillInput"
                            placeholder="Add a custom skill and press Enter" />
                    </div>
                    <button type="button" class="lj-btn lj-btn-outline" onclick="addCustomSkill()">
                        <i class="fa-solid fa-plus"></i> Add
                    </button>
                </div>
            </div>
            <div class="lj-form-footer">
                <button type="submit" class="lj-btn lj-btn-primary">
                    <i class="fa-solid fa-check"></i> Save Skills
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        // Toggle experience fields
        function toggleExpFields(val) {
            document.getElementById('expExtraFields').style.display = val === 'experienced' ? 'block' : 'none';
        }

        // Add skill from suggestions
        function addSkill(skillName, chipEl) {
            chipEl.remove();
            const cloud = document.getElementById('selectedSkillsCloud');
            const tag = document.createElement('span');
            tag.className = 'lj-skill-tag selected';
            tag.innerHTML =
                `${skillName} <input type="hidden" name="skills[]" value="${skillName}"/> <span class="rm"><i class="fa-solid fa-xmark"></i></span>`;
            tag.querySelector('.rm').addEventListener('click', function(e) {
                e.stopPropagation();
                tag.remove();
                // Re-add chip to suggestions
                const sug = document.getElementById('suggestedSkills');
                const newChip = document.createElement('span');
                newChip.className = 'chip';
                newChip.textContent = skillName;
                newChip.onclick = () => addSkill(skillName, newChip);
                sug.appendChild(newChip);
            });
            cloud.appendChild(tag);
        }

        // Add custom skill
        function addCustomSkill() {
            const inp = document.getElementById('customSkillInput');
            const val = inp.value.trim();
            if (!val) return;
            addSkill(val, {
                remove: () => {}
            });
            inp.value = '';
        }
        document.getElementById('customSkillInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomSkill();
            }
        });

        // Avatar preview
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
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
    </script>
@endpush
