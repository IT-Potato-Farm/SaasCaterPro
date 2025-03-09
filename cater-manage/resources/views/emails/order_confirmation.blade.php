<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation - Order #{{ $order->id }}</title>
</head>
<body style="background-color: #f3f4f6; margin: 0; padding: 20px 0;">
    <!-- Container -->
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); padding: 24px; border-radius: 8px 8px 0 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="color: #ffffff; font-size: 24px; font-weight: bold; margin: 0;">Booking Confirmation</h1>
                    <p style="color: #e0e7ff; font-size: 14px; margin-top: 8px;">#{{ $order->id }}</p>
                </div>
                <div style="width: 48px; height: 48px; background-color: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div style="padding: 24px;">
            <p style="color: #374151; margin-bottom: 16px;">Hi {{ $order->user->name ?? 'Customer' }},</p>
            <p style="color: #4b5563; line-height: 1.5;">Thank you for your booking! We've received your order and it's now being processed.</p>

            <!-- Details Card -->
            <div style="background-color: #f8fafc; border-radius: 8px; padding: 16px; margin: 24px 0;">
                <h3 style="color: #1e293b; font-size: 18px; font-weight: bold; margin-bottom: 16px;">Booking Summary</h3>
                <table style="width: 100%;">
                    <tr>
                        <td style="color: #64748b; padding: 8px 0; width: 40%;">Order ID</td>
                        <td style="color: #1e293b; font-weight: 500; padding: 8px 0;">#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 8px 0;">Event Type</td>
                        <td style="color: #1e293b; padding: 8px 0;">{{ $order->event_type }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 8px 0;">Event Date</td>
                        <td style="color: #1e293b; padding: 8px 0;">
                            {{ \Carbon\Carbon::parse($order->event_date)->format('F d, Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 8px 0;">Total Amount</td>
                        <td style="color: #2563eb; font-weight: bold; padding: 8px 0;">
                            ₱{{ number_format($order->total, 2) }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Button -->
            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ url(route('order.show', $order->id)) }}" 
                   style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background-color 0.2s;">
                    View Order Details
                </a>
            </div>

            <!-- Footer -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 24px; text-align: center;">
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">Need help? Contact our support team</p>
                <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 24px;">
                    <a href="#" style="color: #9ca3af;">
                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                </div>
                <p style="color: #9ca3af; font-size: 12px;">&copy; {{ date('Y') }} Saas Food and Catering Services. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>