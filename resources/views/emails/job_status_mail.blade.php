<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job Status Update</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f9;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:20px;">
<tr>
<td align="center">

<!-- Main Container -->
<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

    <!-- Header -->
    <tr>
        <td style="background:#0d6efd; color:#ffffff; padding:20px; text-align:center;">
            <h2 style="margin:0;">Linner Job Portal</h2>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:30px; color:#333;">

            <h3 style="margin-top:0;">Hello {{ $name }},</h3>

            <p style="font-size:15px; line-height:1.6;">
                Your job posting status has been updated by the admin.
            </p>

            <!-- Job Title -->
            <div style="margin:15px 0; font-size:16px;">
                <strong>Job Title:</strong> {{ $job_title }}
            </div>

            <!-- Status Box -->
            <div style="margin:20px 0; padding:15px; border-radius:6px;
                @if($status == 'Approved')
                    background:#e6f4ea; color:#2e7d32;
                @elseif($status == 'Rejected')
                    background:#fdecea; color:#c62828;
                @else
                    background:#fff8e1; color:#f9a825;
                @endif
            ">
                <strong>Status: {{ $status }}</strong>
            </div>

            <!-- Approved Message -->
            @if($status == 'Approved')
                <p style="font-size:14px; color:#555;">
                    🎉 Congratulations! Your job has been approved and is now live on the portal.
                    Candidates can start applying.
                </p>
            @endif

            <!-- Rejected Message -->
            @if($status == 'Rejected')
                <p style="font-size:14px; color:#555;">
                    Unfortunately, your job posting was not approved.
                </p>

                @if(!empty($reject_message))
                <div style="background:#fff3f3; border-left:4px solid #c62828; padding:10px; margin-top:10px;">
                    <strong>Reason:</strong> {{ $reject_message }}
                </div>
                @endif
            @endif

            <!-- Pending Message -->
            @if($status == 'Pending')
                <p style="font-size:14px; color:#555;">
                    Your job is currently under review. We will notify you once it is approved.
                </p>
            @endif

            <p style="margin-top:30px; font-size:14px;">
                If you have any questions, feel free to contact our support team.
            </p>

            <p style="font-size:14px;">
                Regards,<br>
                <strong>Linner Job Portal Team</strong>
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f1f1f1; text-align:center; padding:15px; font-size:12px; color:#777;">
            © {{ date('Y') }} Linner Job Portal. All rights reserved.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>