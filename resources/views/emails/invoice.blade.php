<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 30px; border-radius: 8px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 25px;">
            <h1 style="color: #e67e22; margin: 0 0 10px 0;">SAAS Food & Catering</h1>
            <div style="background-color: #e67e22; height: 4px; width: 80px; margin: 0 auto;"></div>
        </div>

        <!-- Content -->
        <h2 style="color: #2c3e50; margin-top: 0;">Dear {{ $order->user->first_name }},</h2>
        
        <p style="margin-bottom: 20px;">Thank you for choosing our catering services. Please review your order details and payment information below.</p>
        
        <div style="background-color: #ffffff; border-radius: 6px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="color: #e67e22; margin-top: 0; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">Order Details</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 10px; margin-bottom: 15px;">
                <div style="font-weight: bold;">Order ID:</div>
                <div>#{{ $order->id }}</div>
                
                <div style="font-weight: bold;">Event Type:</div>
                <div>{{ $order->event_type }}</div>
                
                <div style="font-weight: bold;">Event Date:</div>
                <div>{{ \Carbon\Carbon::parse($order->event_date)->format('M d, Y') }}</div>
                
                <div style="font-weight: bold;">Event Address:</div>
                <div>{{ $order->event_address }}</div>
            </div>
        </div>

        <div style="background-color: #ffffff; border-radius: 6px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="color: #e67e22; margin-top: 0; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">Payment Details</h3>
            
            @php
                $total = $order->total;
                $partialPayment = $total / 2;
                $remaining = $total - $partialPayment;
            @endphp
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; margin: 15px 0;">
                    <thead>
                        <tr style="background-color: #f3f4f6;">
                            <th style="padding: 12px; text-align: center; border: 1px solid #e5e7eb;">Total Amount</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #e5e7eb;">Partial Payment (50%)</th>
                            <th style="padding: 12px; text-align: center; border: 1px solid #e5e7eb;">Remaining Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 12px; text-align: center; border: 1px solid #e5e7eb;">₱{{ number_format($total, 2) }}</td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #e5e7eb;">₱{{ number_format($partialPayment, 2) }}</td>
                            <td style="padding: 12px; text-align: center; border: 1px solid #e5e7eb; color: #e74c3c; font-weight: bold;">₱{{ number_format($remaining, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div style="background-color: #fff4e6; padding: 15px; border-left: 4px solid #e67e22; margin: 20px 0 0 0;">
                <p style="margin: 0 0 10px 0; font-weight: bold;">Payment Instructions:</p>
                <p style="margin: 0;">Please make the partial payment of <strong>₱{{ number_format($partialPayment, 2) }}</strong> to secure your booking. The remaining balance of <strong>₱{{ number_format($remaining, 2) }}</strong> is due before your event.</p>
            </div>
        </div>
        
        <p style="margin-bottom: 20px;">If you have any questions or need further assistance, feel free to contact us.</p>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <p style="margin-bottom: 5px;">Best regards,</p>
            <p style="margin: 0; font-weight: bold; color: #e67e22;">SAAS Food & Catering</p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #7f8c8d;">
        <p>&copy; {{ date('Y') }} SAAS Catering Services. All rights reserved.</p>
        <p>Contact us at <a href="mailto:support@saascatering.com" style="color: #3498db;">support@saascatering.com</a></p>
    </div>
</body>
</html>