{{-- resume.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'My Resume')

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">My Resume</div>
    <div class="lj-page-subtitle">Upload and manage your resume. Employers will use this to evaluate you.</div>
  </div>
</div>

<div class="lj-grid-2">

  {{-- Left: Upload --}}
  <div>
    <div class="lj-card lj-section-gap">
      <div class="lj-card-head">
        <div class="lj-card-title"><i class="fa-solid fa-file-arrow-up"></i> Upload Resume</div>
      </div>
      <form method="POST" action="{{ route('jobseeker.resume.upload') }}" enctype="multipart/form-data" id="resumeUploadForm">
        @csrf
        <div class="lj-card-body">
          <div class="lj-info-box">
            <i class="fa-solid fa-circle-info"></i>
            Supported formats: PDF, DOC, DOCX — Maximum file size: 5 MB. Keep your resume updated for best results.
          </div>

          @if(auth()->user()->resume ?? false)
            <div class="lj-resume-uploaded">
              <div class="lj-ru-icon"><i class="fa-solid fa-file-pdf"></i></div>
              <div style="flex:1;min-width:0;">
                <div class="lj-ru-name">{{ basename(auth()->user()->resume) }}</div>
                <div class="lj-ru-meta">
                  Uploaded {{ auth()->user()->resume_updated_at ? \Carbon\Carbon::parse(auth()->user()->resume_updated_at)->diffForHumans() : 'recently' }}
                </div>
              </div>
              <div style="display:flex;gap:7px;flex-shrink:0;">
                <a href="{{ asset('storage/'.auth()->user()->resume) }}" download class="lj-btn lj-btn-green lj-btn-sm">
                  <i class="fa-solid fa-download"></i> Download
                </a>
                <form method="POST" action="{{ route('jobseeker.dashboard.resume.delete') }}" onsubmit="return confirm('Delete this resume?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="lj-btn lj-btn-danger lj-btn-sm"><i class="fa-solid fa-trash"></i></button>
                </form>
              </div>
            </div>
          @endif

          <div class="lj-resume-box" id="resumeDropZone">
            <input type="file" name="resume" id="resumeFileInput" accept=".pdf,.doc,.docx" onchange="handleResumeFile(this)"/>
            <div class="lj-resume-icon" id="resumeIcon">
              <i class="fa-solid fa-cloud-arrow-up"></i>
            </div>
            <div class="lj-resume-title" id="resumeLabel">
              {{ auth()->user()?->resume ? 'Replace with new resume' : 'Click or drag to upload resume' }}
            </div>
            <div class="lj-resume-sub" id="resumeSub">PDF, DOC, DOCX — Max 5 MB</div>
          </div>
          <div class="lj-input-hint" style="margin-top:6px;font-size:.72rem;color:var(--red);display:none;" id="resumeSizeErr">
            <i class="fa-solid fa-triangle-exclamation"></i> File too large. Maximum 5 MB allowed.
          </div>

          <div class="lj-fgroup" style="margin-top:16px;">
            <label class="lj-label">Resume Title</label>
            <div class="lj-input-wrap">
              <i class="fa-solid fa-tag lj-input-ico"></i>
              <input class="lj-input has-ico" type="text" name="resume_title"
                value="{{ old('resume_title', auth()->user()->resume_title ?? '') }}"
                placeholder="e.g. Arjun Kumar – PHP Developer Resume"/>
            </div>
            <div class="lj-input-hint"><i class="fa-solid fa-circle-info"></i> This title is shown to employers when they view your application.</div>
          </div>

          @error('resume')
            <div style="background:var(--red-light);border:1.5px solid #fecaca;border-radius:8px;padding:10px 13px;margin-top:12px;font-size:.81rem;color:var(--red);">
              <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
            </div>
          @enderror
        </div>
        <div class="lj-form-footer">
          <div style="font-size:.76rem;color:var(--n400);display:flex;align-items:center;gap:5px;">
            <i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Securely stored
          </div>
          <button type="submit" class="lj-btn lj-btn-primary" id="resumeUploadBtn">
            <i class="fa-solid fa-cloud-arrow-up"></i> Save Resume
          </button>
        </div>
      </form>
    </div>

    @if(auth()->user()->resume ?? false)
      <div class="lj-card">
        <div class="lj-card-head">
          <div class="lj-card-title"><i class="fa-solid fa-eye"></i> Visibility</div>
        </div>
        <div class="lj-card-body">
          <div class="lj-setting-row" style="border:none;padding:0;">
            <div>
              <div class="lj-setting-label">Resume Visible to Employers</div>
              <div class="lj-setting-sub">Allow employers to view and download your resume directly</div>
            </div>
            <form method="POST" action="{{ route('jobseeker.dashboard.resume.visibility') }}">
              @csrf @method('PUT')
              <div class="lj-toggle {{ (auth()->user()->resume_public ?? true) ? 'on' : '' }}"
                onclick="this.classList.toggle('on'); this.nextElementSibling.click()"></div>
              <button type="submit" style="display:none;"></button>
            </form>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- Right: Tips + Stats --}}
  <div>
    <div class="lj-card lj-section-gap">
      <div class="lj-card-head">
        <div class="lj-card-title"><i class="fa-solid fa-lightbulb"></i> Resume Tips</div>
      </div>
      <div class="lj-card-body">
        <div class="lj-timeline">
          @php
            $tips = [
              [true,  'Keep it to 1–2 pages', 'Employers spend less than 30 seconds scanning a resume. Be concise and relevant.'],
              [true,  'Match skills to job descriptions', 'Use keywords from job postings you\'re targeting. ATS systems scan for keyword matches.'],
              [false, 'Use a clean, professional format', 'Clear fonts (Calibri, Georgia), consistent spacing, and clear section headers. Save as PDF.'],
              [false, 'Quantify your achievements', '"Improved page load time by 40%" beats "improved performance". Numbers stand out.'],
              [false, 'Update it regularly', 'Update your resume every 3–6 months or whenever you gain new skills or experience.'],
            ];
          @endphp
          @foreach($tips as $i => [$done, $title, $sub])
            <div class="lj-tl-item">
              <div class="lj-tl-left">
                <div class="lj-tl-dot {{ $done ? 'done' : 'outline' }}">
                  <i class="fa-solid {{ $done ? 'fa-check' : 'fa-circle' }}"></i>
                </div>
                @if(!$loop->last) <div class="lj-tl-line"></div> @endif
              </div>
              <div class="lj-tl-content">
                <div class="lj-tl-title">{{ $title }}</div>
                <div class="lj-tl-sub">{{ $sub }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="lj-card">
      <div class="lj-card-head">
        <div class="lj-card-title"><i class="fa-solid fa-chart-line"></i> Resume Performance</div>
      </div>
      <div class="lj-card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div style="text-align:center;background:var(--blue-light);border:1.5px solid var(--blue-mid);border-radius:9px;padding:16px;">
            @if($resume)
            <a href="{{ asset('public/' . $resume->file_path) }}" target="_blank" class="btn btn-primary">
              <div style="font-family:var(--f-display);font-size:1.6rem;font-weight:800;color:var(--blue);">{{ $resume->title ?? '$resume->file_name' }}</div>
              <div style="font-size:.74rem;color:var(--n600);margin-top:3px;">Resume Views</div>
            </a>
            @else

                <p>No resume found</p>

            @endif
          </div>
          <div style="text-align:center;background:var(--green-light);border:1.5px solid #86efac;border-radius:9px;padding:16px;">
            <div style="font-family:var(--f-display);font-size:1.6rem;font-weight:800;color:var(--green);">{{ $resumeDownloads ?? '—' }}</div>
            <div style="font-size:.74rem;color:var(--n600);margin-top:3px;">Downloads</div>
          </div>
        </div>
        <div style="margin-top:12px;font-size:.76rem;color:var(--n400);text-align:center;">Stats are updated every 24 hours</div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
const dropZone = document.getElementById('resumeDropZone');
if (dropZone) {
  dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor='var(--blue)'; dropZone.style.background='var(--blue-light)'; });
  dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor=''; dropZone.style.background=''; });
  dropZone.addEventListener('drop', e => {
    e.preventDefault(); dropZone.style.borderColor=''; dropZone.style.background='';
    const file = e.dataTransfer.files[0];
    if (file) { document.getElementById('resumeFileInput').files = e.dataTransfer.files; handleResumeFile({files:[file]}); }
  });
}
function handleResumeFile(input) {
  const file = input.files[0]; if (!file) return;
  const errEl = document.getElementById('resumeSizeErr');
  if (file.size > 5*1024*1024) { errEl.style.display='flex'; document.getElementById('resumeFileInput').value=''; return; }
  errEl.style.display='none';
  document.getElementById('resumeLabel').textContent = file.name;
  document.getElementById('resumeSub').textContent   = (file.size/1024/1024).toFixed(2)+' MB';
  document.getElementById('resumeIcon').innerHTML    = '<i class="fa-solid fa-file-check" style="color:var(--green);"></i>';
}

$(document).ready(function () {

    $('#resumeUploadForm').on('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        let btn = $('#resumeUploadBtn');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading...');

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                toastr.success(res.message);

                // ✅ Optional: reload to show new resume
                setTimeout(() => location.reload(), 1500);
            },

            error: function(err) {
                if (err.status === 422) {
                    let errors = err.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Upload failed!');
                }
            },

            complete: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-cloud-arrow-up"></i> Save Resume');
            }
        });
    });

});
</script>
@endpush