{{-- saved.blade.php --}}
@extends('frontend.jobseeker.layout')
@section('title', 'Saved Jobs')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')

<div class="lj-page-header">
  <div>
    <div class="lj-page-title">Saved Jobs</div>
    <div class="lj-page-subtitle">Jobs you've bookmarked. Apply before they expire!</div>
  </div>
  <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary">
    <i class="fa-solid fa-magnifying-glass"></i> Find More Jobs
  </a>
</div>

@php
  $savedJobs  = $savedjobs ?? null;
  $hasSaved   = $savedjobs && $savedjobs->count() > 0;
  $isFallback = !$savedjobs;
@endphp

@if($hasSaved || $isFallback)
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:16px;">
    @if($hasSaved)
      @foreach($savedjobs as $saved)
        <div class="lj-saved-job-card">
          <div style="display:flex;align-items:flex-start;gap:11px;margin-bottom:10px;">
            <div style="width:40px;height:40px;border-radius:9px;background:var(--n100);border:1px solid var(--n200);display:flex;align-items:center;justify-content:center;color:var(--n500);font-size:.82rem;flex-shrink:0;overflow:hidden;">
              @if($saved->job->company->logo ?? false)
                <img src="{{ asset('storage/'.$saved->job->company->logo) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
              @else
                <i class="fa-solid fa-building"></i>
              @endif
            </div>
            <div style="min-width:0;">
              <div class="lj-sjc-title">{{ $saved->job->title }}</div>
              <div class="lj-sjc-co"><i class="fa-solid fa-building" style="font-size:.62rem;"></i> {{ $saved->job->company_name ?? $saved->job->company_name }} · {{ $saved->job->district }}</div>
            </div>
          </div>
          <div class="lj-sjc-tags">
            @if($saved->job->salary_range) <span class="lj-rec-tag salary">{{ $saved->job->salary_range }}</span> @endif
            @if($saved->job->job_type)     <span class="lj-rec-tag type">{{ $saved->job->job_type }}</span>   @endif
            @if($saved->job->experience) <span class="lj-rec-tag">{{ $saved->job->experience }}</span> @endif
          </div>
          @if($saved->job->expiry_date && \Carbon\Carbon::parse($saved->job->expiry_date)->isPast())
            <div style="font-size:.72rem;color:var(--red);margin:7px 0;display:flex;align-items:center;gap:4px;">
              <i class="fa-solid fa-triangle-exclamation"></i> This job has expired
            </div>
          @elseif($saved->job->expiry_date)
            <div style="font-size:.72rem;color:var(--orange);margin:7px 0;display:flex;align-items:center;gap:4px;">
              <i class="fa-solid fa-clock"></i> Closes {{ \Carbon\Carbon::parse($saved->job->expiry_date)->diffForHumans() }}
            </div>
          @endif
          <div class="lj-divider" style="margin:9px 0;"></div>
          <div class="lj-sjc-footer">
            <span style="font-size:.71rem;color:var(--n400);">Saved {{ $saved->created_at->diffForHumans() }}</span>
            <div style="display:flex;gap:6px;">
              <button class="lj-btn lj-btn-danger lj-btn-sm btn-remove-saved" 
                    data-id="{{ $saved->id }}">
                <i class="fa-solid fa-trash"></i>
              </button>
              <a href="{{ route('jobs.apply', $saved->job_id) }}" class="lj-btn lj-btn-primary lj-btn-sm">
                <i class="fa-solid fa-paper-plane"></i> Apply
              </a>
            </div>
          </div>
        </div>
      @endforeach      
    @endif
  </div>

@else
  <div class="lj-card">
    <div class="lj-empty">
      <i class="fa-solid fa-bookmark"></i>
      <div class="lj-empty-title">No saved jobs yet</div>
      <div class="lj-empty-sub">Browse jobs and click the bookmark icon to save them for later.</div>
      <a href="{{ route('jobs.index') }}" class="lj-btn lj-btn-primary" style="margin-top:10px;">
        <i class="fa-solid fa-magnifying-glass"></i> Browse Jobs
      </a>
    </div>
  </div>
@endif

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.btn-remove-saved', function() {
        const btn = $(this);
        const savedId = btn.data('id');

        if (!confirm('Remove this job from saved?')) return;

        $.ajax({
            url: "{{ route('jobseeker.saved.destroy', ':id') }}".replace(':id', savedId),
            type: 'POST', // <-- POST method
            data: {
                _method: 'DELETE', // <-- spoof DELETE
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              if(response.success) {
                  // Optional: remove the card visually first
                  btn.closest('.lj-saved-job-card').fadeOut(300, function() {
                      $(this).remove();
                  });

                  // Show toast notification
                  toastr.success(response.message, 'Success', {
                      timeOut: 2000, // 2 seconds
                      closeButton: true,
                      progressBar: true
                  });

                  // Reload page after 2 seconds
                  setTimeout(function() {
                      location.reload();
                  }, 2000);

              } else {
                  toastr.error(response.message || 'Failed to remove saved job.', 'Error', {
                      timeOut: 2000,
                      closeButton: true,
                      progressBar: true
                  });
              }
          },
          error: function(xhr) {
              toastr.error('Something went wrong. Please try again.', 'Error', {
                  timeOut: 2000,
                  closeButton: true,
                  progressBar: true
              });
          }
        });
    });
});
</script>
@endpush