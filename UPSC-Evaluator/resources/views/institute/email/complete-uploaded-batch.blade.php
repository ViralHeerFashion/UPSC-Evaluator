<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File processing report – Aspire Scan</title>
    <style>
        body, table, td, p, a, div, span {margin: 0;padding: 0;border: 0;font-size: 100%;font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;line-height: 1.5;box-sizing: border-box;}
        :root {--bg-color: #0E0C15;--card-color: #18191c;--primary-accent: #020202ff;--secondary-accent: #CD99FF;--text-primary: #F5F5F7;--text-secondary: #A1A1A6;--border-color: rgba(255, 255, 255, 0.1);--success-color: #30D158;--warning-color: #FF9F0A;--error-color: #FF453A;--highlight-color: rgba(128, 90, 245, 0.15);}
        body {background-color: #0E0C15;margin: 0;padding: 24px 16px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;}
        .email-wrapper {width: 100%;max-width: 620px;margin: 0 auto;background-color: #0E0C15;border-collapse: collapse;}
        .email-card {background-color: #18191c;border-radius: 24px;overflow: hidden;box-shadow: 0 20px 35px -8px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.05);}
        .card-padding {padding: 32px 28px 20px 28px;}
        .text-primary {color: #F5F5F7;font-weight: 400;font-size: 16px;letter-spacing: 0.01em;}
        .text-secondary {color: #A1A1A6;font-size: 14px;}
        .timestamp-highlight {color: #CD99FF;font-weight: 500;background: rgba(128, 90, 245, 0.15);padding: 2px 8px;border-radius: 30px;display: inline-block;font-size: 14px;border: 0.5px solid rgba(255,255,255,0.08);}
        .greeting p {margin-bottom: 12px;}
        .divider-light {height: 1px;background-color: rgba(255, 255, 255, 0.1);margin: 24px 0 22px 0;}
        .file-table {width: 100%;border-collapse: collapse;margin-top: 10px;border-radius: 16px;overflow: hidden;}
        .file-table th {text-align: left;padding: 14px 12px;background-color: rgba(10, 10, 15, 0.5);color: #CD99FF;font-weight: 500;font-size: 14px;letter-spacing: 0.03em;text-transform: uppercase;border-bottom: 1px solid rgba(255, 255, 255, 0.1);}
        .file-table td {padding: 16px 12px;border-bottom: 1px solid rgba(255, 255, 255, 0.05);color: #F5F5F7;font-size: 15px;}
        .file-table tbody tr:last-child td {border-bottom: none;}
        .status-badge {display: inline-block;padding: 6px 14px;border-radius: 50px;font-size: 13px;font-weight: 500;letter-spacing: 0.01em;background: rgba(0,0,0,0.3);backdrop-filter: blur(2px);border: 0.5px solid rgba(255,255,255,0.15);box-shadow: 0 2px 5px rgba(0,0,0,0.5);min-width: 80px;text-align: center;}
        .status-success {background: rgba(48, 209, 88, 0.15); /* success with transparency */color: #30D158;border-left: 3px solid #30D158;}
        .status-warning {background: rgba(255, 159, 10, 0.15);color: #FF9F0A;border-left: 3px solid #FF9F0A;}
        .status-error {background: rgba(255, 69, 58, 0.15);color: #FF453A;border-left: 3px solid #FF453A;}
        .index-col {color: #CD99FF;font-weight: 500;opacity: 0.9;}
        .file-name {font-weight: 500;color: #F5F5F7;word-break: break-word;}
        @media screen and (max-width: 520px) {
            .card-padding {padding: 24px 16px 10px 16px;}
            .file-table th, .file-table td {padding: 12px 8px;font-size: 14px;}
            .status-badge {padding: 4px 8px;min-width: 70px;font-size: 12px;}
            .timestamp-highlight {font-size: 13px;white-space: nowrap;}
        }
        .footer-note {margin-top: 26px;color: #A1A1A6;font-size: 13px;border-top: 1px solid rgba(255,255,255,0.1);padding-top: 18px;text-align: left;}
        .accent-link {color: #CD99FF;text-decoration: none;border-bottom: 1px dotted #CD99FF;}
        .spacer-8 { height: 8px; }
        .spacer-16 { height: 16px; }
        .block {display: block;}
        .ExternalClass, .ReadMsgBody { width: 100%; background-color: #0E0C15; }
    </style>
</head>
<body style="background-color: #0E0C15; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 0; padding: 20px 10px;">
    <!-- CENTERING TABLE (email standard) -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#0E0C15" style="background-color: #0E0C15; width: 100%;">
        
        <tr>
            <td align="center" style="padding: 0;">
                <!-- MAIN WRAPPER (max-width) -->
                <table class="email-wrapper" width="100%" max-width="620" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:620px; width:100%; background-color:#0E0C15; margin:0 auto;">
                    <tr>
                        <td align="center"
                            style="padding:35px 0;border-bottom:1px solid rgba(255,255,255,0.08);">
                            <img src="https://aspirescan.com/public/images/logo.png"
                                width="180"
                                alt="Aspire Scan">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">
                            <!-- CARD CONTAINER -->
                            <div class="email-card" style="background-color: #18191c; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 35px -8px #000000b3, 0 0 0 1px rgba(255,255,255,0.05);">
                                <!-- INNER CONTENT (without footer) -->
                                <div class="card-padding" style="padding: 32px 28px 10px 28px;">
                                    
                                    <!-- GREETING / PARAGRAPH with timestamp -->
                                    <div class="greeting" style="color: #F5F5F7;">
                                        <p style="margin: 0 0 12px 0; font-size: 16px; line-height: 1.6;">
                                            <span style="font-weight: 400;">Hi {{ $institute_upload_batch->institute->name }} Institute,</span>
                                        </p>
                                        <p style="margin: 0; font-size: 16px; line-height: 1.6;">
                                            Files uploaded by you at 
                                            <span class="timestamp-highlight" style="color: #CD99FF; background: rgba(128,90,245,0.15); padding: 2px 10px; border-radius: 30px; font-weight: 500; border: 0.5px solid rgba(255,255,255,0.08); display: inline-block; margin: 0 2px;">🗓️ {{ date("d M Y · h:i A", strtotime($institute_upload_batch->created_at)) }}</span>
                                            have been <span style="color: #30D158; font-weight: 500;">processed successfully</span>.
                                        </p>
                                        <p style="margin: 12px 0 0 0; color: #A1A1A6; font-size: 15px;">
                                            Here is the files with status:
                                        </p>
                                    </div>
                                    
                                    @php($is_view_more_button = false)

                                    <!-- DIVIDER with border color -->
                                    <div class="divider-light" style="height: 1px; background-color: rgba(255,255,255,0.1); margin: 24px 0 22px 0;"></div>

                                    <!-- TABLE : index, file name, status -->
                                    <table class="file-table" width="100%" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; border-radius:16px; overflow:hidden;">
                                        <thead>
                                            <tr style="background-color: #0a0a0f80;">
                                                <th style="padding: 14px 12px; text-align: left; color: #CD99FF; font-size: 14px; font-weight: 500; letter-spacing:0.03em; border-bottom:1px solid rgba(255,255,255,0.1);">#</th>
                                                <th style="padding: 14px 12px; text-align: left; color: #CD99FF; font-size: 14px; font-weight: 500; letter-spacing:0.03em; border-bottom:1px solid rgba(255,255,255,0.1);">File name</th>
                                                <th style="padding: 14px 12px; text-align: left; color: #CD99FF; font-size: 14px; font-weight: 500; letter-spacing:0.03em; border-bottom:1px solid rgba(255,255,255,0.1);">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($i = 0)
                                            @foreach($institute_upload_batch->files()->orderBy('id', 'asc')->limit(11)->get() as $file)
                                            @if($i == 10)
                                                @php($is_view_more_button = true)
                                                @break
                                            @endif
                                            <tr>
                                                <td class="index-col" style="padding: 16px 12px; border-bottom:1px solid rgba(255,255,255,0.05); color:#CD99FF; font-weight:500;">{{ ++$i }}</td>
                                                <td style="padding: 16px 12px; border-bottom:1px solid rgba(255,255,255,0.05); color:#F5F5F7;">
                                                    <span class="file-name" style="font-weight:500;">{{ $file->file_name }}</span>
                                                </td>
                                                <td style="padding: 16px 12px; border-bottom:1px solid rgba(255,255,255,0.05);">
                                                    @if($file->status == '1')
                                                    <span class="status-badge status-success" style="display:inline-block; padding:6px 14px; border-radius:50px; background:rgba(48,209,88,0.15); color:#30D158; border-left:3px solid #30D158; font-weight:500; font-size:13px; box-shadow:0 2px 5px #00000080; min-width:80px; text-align:center;">✅ Success</span>
                                                    @elseif($file->status == '2')
                                                    <span class="status-badge status-error" style="display:inline-block; padding:6px 14px; border-radius:50px; background:rgba(255,69,58,0.15); color:#FF453A; border-left:3px solid #FF453A; font-weight:500; font-size:13px; box-shadow:0 2px 5px #00000080; min-width:80px; text-align:center;">❌ Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    @if($is_view_more_button)
                                    <div class="button-container" style="text-align: center; margin: 28px 0 10px 0;">
                                        <a href="{{ route('institute.login') }}" class="btn-view-more" style="display: inline-block; background: linear-gradient(145deg, #2b2a33, #18191c); color: #CD99FF; font-weight: 600; font-size: 15px; padding: 14px 32px; border-radius: 60px; text-decoration: none; letter-spacing: 0.02em; border: 1px solid rgba(205, 153, 255, 0.3); box-shadow: 0 8px 20px rgba(0,0,0,0.6), 0 0 0 1px rgba(205,153,255,0.2) inset; margin: 8px 0 4px 0;">
                                            View more files <span class="btn-arrow" style="font-size: 18px; margin-left: 8px; display: inline-block; vertical-align: middle; color: #CD99FF;">→</span>
                                        </a>
                                    </div>
                                    @endif
                                    
                                    <!-- subtle spacer & extra info (eye catching) -->
                                    <div class="spacer-16" style="height: 16px; font-size: 0;"></div>
                                    
                                    <!-- micro summary with highlight color -->
                                    

                                    <!-- extra spacing before footer (handled by card-padding bottom) -->
                                </div> <!-- card-padding -->

                                <!-- ##### NEW FOOTER (exactly as requested) ##### -->
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td align="center" style="padding:30px 10px; color:#8E8E93; font-size:13px; border-top:1px solid rgba(255,255,255,0.08); background-color: #18191c;">
                                            <p style="margin:0; color:#8E8E93;">
                                                Warm regards,<br>
                                                <strong style="color:#F5F5F7;">Aspire Scan Team</strong><br>
                                                <span style="color:#A1A1A6;">Potenzials Education</span>
                                            </p>
                                            <p style="margin-top:14px; color:#8E8E93; font-size:12px;">
                                                © {{ date("Y") }} Aspire Scan. All rights reserved.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                <!-- ##### END FOOTER ##### -->

                            </div> <!-- email-card -->
                        </td>
                    </tr>
                </table> <!-- email-wrapper -->
            </td>
        </tr>
    </table>

    <!-- Outlook / mobile ghost table -->
    <div style="display:none;"> </div>
</body>
</html>