<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Status Update</title>
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
                                Your registration status has been updated.
                            </p>

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

                            @if($status == 'Rejected')
                                <p style="font-size:14px; color:#555;">
                                    Unfortunately, your application was not approved at this time.  
                                    Please review your details and try again.
                                </p>
                            @endif

                            @if($status == 'Approved')
                                <p style="font-size:14px; color:#555;">
                                    Congratulations! Your account has been approved. You can now log in and start using our platform.
                                </p>
                            @endif

                            <p style="margin-top:30px; font-size:14px;">
                                If you have any questions, feel free to contact us.
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