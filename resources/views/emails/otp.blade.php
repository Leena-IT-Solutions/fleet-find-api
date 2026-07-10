<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FleetFind Password Reset</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" max-width="600" style="background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <!-- Header -->
        <tr>
            <td align="center" style="background-color: #4f46e5; padding: 30px 20px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">FleetFind</h1>
            </td>
        </tr>
        <!-- Content -->
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="color: #1e293b; margin: 0 0 16px 0; font-size: 18px; font-weight: 700;">Password Reset Request</h2>
                <p style="color: #64748b; font-size: 14px; line-height: 24px; margin: 0 0 30px 0;">
                    We received a request to reset your password. Use the verification code below to complete the reset process in the application. This code is valid for 60 minutes.
                </p>
                <!-- OTP Box -->
                <div align="center" style="margin-bottom: 30px;">
                    <div style="background-color: #f1f5f9; border-radius: 12px; display: inline-block; padding: 16px 40px; border: 1px solid #e2e8f0;">
                        <span style="color: #4f46e5; font-size: 32px; font-weight: 800; letter-spacing: 6px; font-family: monospace;">{{ $otp }}</span>
                    </div>
                </div>
                <p style="color: #64748b; font-size: 14px; line-height: 24px; margin: 0 0 16px 0;">
                    If you did not request a password reset, please ignore this email or contact support if you have concerns.
                </p>
            </td>
        </tr>
        <!-- Footer -->
        <tr>
            <td align="center" style="background-color: #f8fafc; padding: 20px; border-top: 1px solid #e2e8f0;">
                <p style="color: #94a3b8; font-size: 11px; margin: 0;">&copy; {{ date('Y') }} FleetFind. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
