<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Successful Referral - Aspire Scan</title>
</head>

<body style="margin:0;padding:0;background-color:#0E0C15;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#0E0C15">
<tr>
<td align="center">

<!-- Container -->
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;margin:25px auto;">

    <!-- Header -->
    <tr>
        <td align="center"
            style="padding:35px 0;border-bottom:1px solid rgba(255,255,255,0.08);">
            <img src="https://aspirescan.com/public/images/logo.png"
                 width="180"
                 alt="Aspire Scan">
        </td>
    </tr>

    <!-- Card -->
    <tr>
        <td style="background-color:#18191c;
                   border-radius:16px;
                   padding:35px;
                   border:1px solid rgba(255,255,255,0.08);
                   color:#F5F5F7;">

            <!-- Badge -->
            <table cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                <tr>
                    <td style="background-color:rgba(128,90,245,0.18);
                               color:#CD99FF;
                               padding:8px 18px;
                               border-radius:40px;
                               font-size:13px;
                               font-weight:bold;">
                        ✔ NEW SUCCESSFUL REFERRAL
                    </td>
                </tr>
            </table>

            <!-- Greeting -->
            <p style="font-size:18px;color:#CD99FF;margin:0 0 8px 0;">
                Hi {{ $affiliater_name }},
            </p>

            <h1 style="font-size:24px;font-weight:600;margin:0 0 10px 0;">
                Great news! 🎉
            </h1>

            <p style="color:#A1A1A6;font-size:15px;margin-bottom:28px;">
                A new student has successfully registered using your referral link.
            </p>

            <!-- Student Info -->
            <table width="100%" cellpadding="14" cellspacing="0"
                   style="background-color:#121318;
                          border-radius:12px;
                          margin-bottom:25px;">

                <tr>
                    <td colspan="2"
                        style="color:#CD99FF;
                               font-size:16px;
                               padding-bottom:10px;
                               border-bottom:1px solid rgba(255,255,255,0.08);">
                        Student Information
                    </td>
                </tr>

                <tr>
                    <td style="color:#A1A1A6;width:35%;">Student Name</td>
                    <td style="color:#F5F5F7;">{{ $user->name }}</td>
                </tr>

                @if(!empty($user->email))
                <tr>
                    <td style="color:#A1A1A6;">Email</td>
                    <td style="color:#F5F5F7;">{{ $user->email }}</td>
                </tr>
                @endif

                <tr>
                    <td style="color:#A1A1A6;">Registration Date</td>
                    <td style="color:#F5F5F7;">
                        {{ date('d-m-Y h:i A', strtotime($user->created_at)) }}
                    </td>
                </tr>
            </table>

            <!-- Confirmation -->
            <table width="100%" cellpadding="16" cellspacing="0"
                   style="background-color:rgba(48,209,88,0.12);
                          border-left:4px solid #30D158;
                          border-radius:8px;
                          margin-bottom:25px;">
                <tr>
                    <td style="color:#E7FBEA;font-size:14px;">
                        ✔ This referral has been successfully tracked and credited to your affiliate account.
                    </td>
                </tr>
            </table>

            <p style="color:#A1A1A6;font-size:14px;margin-bottom:18px;">
                Thank you for helping UPSC aspirants improve their answer writing with Aspire Scan.
            </p>

            <p style="color:#A1A1A6;font-size:14px;">
                Any questions?
                <a href="mailto:admin@potenzials.com"
                   style="color:#CD99FF;text-decoration:none;font-weight:bold;">
                    Contact Admin
                </a>
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td align="center"
            style="padding:30px 10px;
                   color:#8E8E93;
                   font-size:13px;
                   border-top:1px solid rgba(255,255,255,0.08);">
            <p style="margin:0;">
                Best regards,<br>
                <strong style="color:#F5F5F7;">The Aspire Scan Team</strong><br>
                Potenzials Education
            </p>

            <p style="margin-top:14px;">
                © {{ date('Y') }} Aspire Scan. All rights reserved.
            </p>
        </td>
    </tr>

</table>
</td>
</tr>
</table>

</body>
</html>
