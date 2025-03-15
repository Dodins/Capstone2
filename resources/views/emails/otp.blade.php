<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
</head>
<body style="background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="max-width: 400px; width: 100%; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border: 1px solid #e5e7eb;">
        <div style="text-align: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px;">
            <h1 style="font-size: 22px; font-weight: bold; color: #16a34a;">Password Reset Request</h1>
        </div>
        <div style="margin-top: 15px; color: #374151;">
            <p style="font-size: 16px; font-weight: 500;">Hello,</p>
            <p style="margin-top: 10px;">We received a request to reset your password. Please use the following OTP to complete the process:</p>
            <div style="margin-top: 15px; background-color: #d1fae5; color: #065f46; font-size: 24px; font-weight: bold; text-align: center; padding: 12px; border-radius: 8px; border: 1px solid #10b981;">
                {{ $otp }}
            </div>
            <p style="margin-top: 15px; font-size: 14px; color: #6b7280;">This OTP is valid for <strong>15 minutes</strong>. If you didn't request a password reset, please ignore this email.</p>
        </div>
        <div style="text-align: center; margin-top: 20px; font-size: 13px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px;">
            <p>Thank you for using our service!</p>
        </div>
    </div>
</body>
</html>
