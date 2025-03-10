<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Invoice</title>
    <style>
        body {
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4F46E5;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content h2 {
            font-size: 20px;
            margin-top: 0;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .payment-table th,
        .payment-table td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: center;
        }
        .payment-table th {
            background-color: #f3f4f6;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Your Invoice</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear {{ $order->user->first_name }},</p>
            <p>Thank you for choosing our catering services. Please review your order details and payment information below.</p>
            
            <h2>Order Details</h2>
            <div class="details">
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Event Type:</strong> {{ $order->event_type }}</p>
                <p><strong>Event Date:</strong> {{ \Carbon\Carbon::parse($order->event_date)->format('M d, Y') }}</p>
                <p><strong>Event Address:</strong> {{ $order->event_address }}</p>
            </div>
            
            <h2>Payment Details</h2>
            @php
                $total = $order->total;
                $partialPayment = $total / 2;
                $remaining = $total - $partialPayment;
            @endphp
            <table class="payment-table">
                <tr>
                    <th>Total Amount</th>
                    <th>Partial Payment (50%)</th>
                    <th>Remaining Balance</th>
                </tr>
                <tr>
                    <td>₱{{ number_format($total, 2) }}</td>
                    <td>₱{{ number_format($partialPayment, 2) }}</td>
                    <td>₱{{ number_format($remaining, 2) }}</td>
                </tr>
            </table>
            
            <p>Please make the partial payment of <strong>₱{{ number_format($partialPayment, 2) }}</strong> to secure your booking. The remaining balance of <strong>₱{{ number_format($remaining, 2) }}</strong> is due before your event.</p>
            
            <p>If you have any questions or need further assistance, feel free to contact us.</p>
            
            <p>Best regards,</p>
            <p>SAAS FOOD AND CATER</p>
        </div>

       
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Catering Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
