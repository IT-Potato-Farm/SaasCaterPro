<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f7fafc;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin: 20px auto;
            overflow: hidden;
        }
        .header {
            background-color: #2563eb;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 32px;
        }
        .button-container {
            margin: 24px 0;
            text-align: center;
        }
        .button {
            display: inline-block;
            background-color: #38b2ac;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(56, 178, 172, 0.2); 
        }
        .button:hover {
            background-color: #319795; 
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(56, 178, 172, 0.3); 
        }
        .footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }
        .highlight-box {
            background-color: #f0f5ff;
            border-left: 4px solid #2563eb;
            padding: 16px;
            margin: 20px 0;
            font-size: 14px;
            border-radius: 0 4px 4px 0;
        }
        .text-muted {
            color: #6b7280;
            font-size: 14px;
            word-break: break-all;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            
            <p>We received a request to reset the password for your account. Click the button below to proceed with resetting your password.</p>
            
            <div class="button-container">
                <a href="{{ $resetLink }}" class="button">Reset Password</a>
            </div>
            
            <div class="highlight-box">
                <p><strong>Important:</strong> This link will expire in 60 minutes for security reasons. If you didn't request this change, you can safely ignore this email.</p>
            </div>
            
            <p>If you're having trouble with the button above, copy and paste the following link into your browser:</p>
            
            <p class="text-muted">{{ $resetLink }}</p>
            
            <div class="footer">
                <p>If you didn't request this password reset, please secure your account as someone else may be trying to access it.</p>
                <p class="text-muted">Regards,<br>The <strong>Saas Cater</strong> Team</p>
            </div>
        </div>
    </div>
</body>
</html>