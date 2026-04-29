@if(isset($jobs) && $jobs->count())
    @foreach($jobs as $job)
        <div class="lj-job-card" onclick="loadPreview({{ $job->id }}, this)" id="job-card-{{ $job->id }}">
            <div class="lj-job-card-title">{{ $job->title }}</div>
            <div class="lj-job-card-company">
                {{ $job->company->name ?? $job->company_name }}
            </div>
        </div>
    @endforeach
@else
    <p>No jobs found</p>
@endif