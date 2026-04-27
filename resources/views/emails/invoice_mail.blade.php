<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#4f46e5; color:#fff; padding:20px;">
                            <h2 style="margin:0;">Your Company Name</h2>
                            <p style="margin:5px 0 0;">Invoice Receipt</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:20px;">

                            <p>Hi {{ $user->name }},</p>

                            <p>Thank you for your purchase! Here are your invoice details:</p>

                            <!-- Invoice Details -->
                            <table width="100%" cellpadding="8" cellspacing="0" style="border:1px solid #eee; margin-top:15px;">
                                <tr>
                                    <td><strong>Invoice No:</strong></td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Invoice Plan :</strong></td>
                                    <td>{{ $plan_type }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Plan:</strong></td>
                                    <td>{{ $plan->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Quantity:</strong></td>
                                    <td>{{ $qty }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Amount:</strong></td>
                                    <td>₹{{ number_format($invoice->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td style="color:green;">Paid</td>
                                </tr>
                            </table>

                            <p style="margin-top:20px;">
                                If you have any questions, feel free to reply to this email.
                            </p>

                            <p>Thanks,<br>Your Company Team</p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f1f1; text-align:center; padding:15px; font-size:12px; color:#666;">
                            © {{ date('Y') }} Your Company Name. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>