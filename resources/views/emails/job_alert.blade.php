<!-- resources/views/emails/job_alert.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job Alerts</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:20px 0;">
<tr>
<td align="center">

    <!-- Container -->
    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.05);">

        <!-- Header -->
        <tr>
            <td style="background:#2563eb;color:#ffffff;padding:20px;text-align:center;">
                <h2 style="margin:0;font-size:20px;">🔔 Job Alerts</h2>
                <p style="margin:5px 0 0;font-size:13px;">Latest jobs for "{{ $alert->keyword }}"</p>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:20px;">

                @foreach($jobs as $job)
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:15px;border:1px solid #e5e7eb;border-radius:8px;">
                    <tr>
                        <td style="padding:15px;">

                            <!-- Job Title -->
                            <h3 style="margin:0 0 6px;font-size:16px;color:#111827;">
                                {{ $job->title }}
                            </h3>

                            <!-- Job Meta -->
                            <p style="margin:0 0 10px;font-size:13px;color:#6b7280;">
                                📍 {{ $job->location ?? 'Not specified' }} &nbsp; | &nbsp;
                                💼 {{ $job->job_type ?? 'N/A' }}
                            </p>

                            <!-- Button -->
                            <a href="{{ route('jobs.show', $job->id) }}"
                               style="display:inline-block;padding:8px 14px;background:#2563eb;color:#ffffff;text-decoration:none;border-radius:6px;font-size:13px;">
                                View Job
                            </a>

                        </td>
                    </tr>
                </table>
                @endforeach

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding:15px;text-align:center;font-size:12px;color:#9ca3af;background:#f9fafb;">
                You are receiving this email because you created a job alert.<br>
                © {{ date('Y') }} Your Job Portal. All rights reserved.
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>