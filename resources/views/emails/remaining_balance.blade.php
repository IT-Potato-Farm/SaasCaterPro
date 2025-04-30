<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remaining Balance Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 30px; border-radius: 8px;">
        <div style="text-align: center; margin-bottom: 25px;">
            <h1 style="color: #e67e22; margin: 0;">SAAS Food & Catering</h1>
        </div>
        
        <h2 style="color: #2c3e50; margin-top: 0;">Hello {{ $order->user->first_name }},</h2>
        
        <p style="margin-bottom: 20px;">Thank you for your partial payment for your order <strong style="color: #e67e22;">#{{ $order->id }}</strong>.</p>
        
        <div style="background-color: #fff4e6; padding: 15px; border-left: 4px solid #e67e22; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold;">Your remaining balance is:</p>
            <p style="font-size: 24px; color: #e74c3c; margin: 10px 0 0 0; font-weight: bold;">₱{{ number_format($remainingBalance, 2) }}</p>
        </div>
        
        <p style="margin-bottom: 20px;">Please complete your payment before the event date to ensure your reservation is confirmed.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin-bottom: 5px;">Thank you,</p>
            <p style="margin: 0; font-weight: bold; color: #e67e22;">SAAS Food & Catering Services</p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #7f8c8d;">
        <p>If you have any questions, please contact us at <a href="mailto:support@saascatering.com" style="color: #3498db;">support@saascatering.com</a></p>
    </div>
</body>
</html>