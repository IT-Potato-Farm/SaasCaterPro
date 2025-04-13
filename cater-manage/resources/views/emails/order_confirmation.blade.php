<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Order #{{ $order->id }}</title>
</head>

<body style="background-color: #f8fafc; margin: 0; padding: 20px 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <!-- Container -->
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); padding: 28px 24px; text-align: center;">
            <div style="display: inline-block; background-color: rgba(255,255,255,0.15); border-radius: 12px; padding: 12px; margin-bottom: 16px;">
                <svg style="width: 28px; height: 28px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 style="color: #ffffff; font-size: 26px; font-weight: 700; margin: 0 0 4px;">Order Confirmed!</h1>
            <p style="color: #e0e7ff; font-size: 16px; margin: 0;">#{{ $order->id }}</p>
        </div>

        <!-- Content -->
        <div style="padding: 32px;">
            <p style="color: #374151; font-size: 16px; margin-bottom: 24px;">Hi {{ $order->user->first_name ?? 'Customer' }},</p>
            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin-bottom: 24px;">Thank you for your order! We've received your request and it's now being processed. Here's what you've ordered:</p>

            <!-- Order Items -->
            <div style="margin-bottom: 32px;">
                <h3 style="color: #1e293b; font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;">Items Ordered</h3>
                <table style="width: 100%;">
                    @foreach ($order->orderItems as $cartItem)
                        @php
                            $isPackage = $cartItem->itemable instanceof \App\Models\Package;
                            $itemName = $cartItem->itemable->name ?? 'Unknown';

                            if ($isPackage) {
                                $itemPrice = $cartItem->itemable->price_per_person ?? 0;
                            } else {
                                $variant = $cartItem->variant ?? null;
                                $itemPrice =
                                    $variant && method_exists($cartItem->itemable, 'getPriceForVariant')
                                        ? $cartItem->itemable->getPriceForVariant($variant)
                                        : 0;
                            }

                            $computedPrice = $isPackage ? $itemPrice * ($order->total_guests ?? 1) : $itemPrice;
                        @endphp

                        <tr style="vertical-align: top;">
                            <td style="color: #1e293b; padding: 16px 0; border-bottom: 1px solid #f1f5f9;">
                                <div style="display: flex; gap: 16px;">
                                    @if ($isPackage && !empty($cartItem->itemable->image))
                                        <img src="{{ asset('storage/packagePics/' . $cartItem->itemable->image) }}"
                                            alt="{{ $itemName }}"
                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @elseif (!$isPackage && !empty($cartItem->itemable->image))
                                        <img src="{{ asset('storage/party_traypics/' . $cartItem->itemable->image) }}"
                                            alt="{{ $itemName }}"
                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    @endif
                                    <div>
                                        <div style="font-weight: 600; font-size: 16px; margin-bottom: 8px;">{{ $itemName }}</div>
                                        @if (!$isPackage)
                                            <div style="font-size: 14px; color: #64748b; margin-bottom: 4px;">
                                                {{ $cartItem->itemable->description ?? 'No description available.' }}
                                            </div>
                                            <div style="font-size: 14px; color: #64748b;">
                                                {{ $cartItem->variant ?? 'N/A' }} PAX
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="color: #1e293b; padding: 16px 0; text-align: right; font-weight: 600; border-bottom: 1px solid #f1f5f9; font-size: 16px; vertical-align: middle;">
                                ₱{{ number_format($computedPrice, 2) }}
                            </td>
                        </tr>
                        @if ($isPackage && method_exists($cartItem->itemable, 'packageItems'))
                            <tr>
                                <td colspan="2" style="padding: 0 0 16px 0; color: #6b7280; font-size: 14px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="margin-top: 12px;">
                                        <strong style="color: #4b5563; display: block; margin-bottom: 12px;">Included Items:</strong>
                                        <ul style="margin: 0; padding-left: 0; list-style: none;">
                                            @foreach ($cartItem->itemable->packageItems as $packageItem)
                                                <li style="margin-bottom: 20px;">
                                                    <div style="font-weight: 500; margin-bottom: 12px; color: #1e293b;">
                                                        {{ $packageItem->item->name ?? 'Unnamed Item' }}</div>

                                                    {{-- Show Selected Options for this Item --}}
                                                    @if (!empty($cartItem->selected_options) && is_array($cartItem->selected_options))
                                                        @php
                                                            $itemId = $packageItem->item->id ?? null;
                                                            $optionsForItem =
                                                                $itemId && isset($cartItem->selected_options[$itemId])
                                                                    ? $cartItem->selected_options[$itemId]
                                                                    : [];
                                                        @endphp

                                                        @if (!empty($optionsForItem))
                                                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                                                                @foreach ($optionsForItem as $option)
                                                                    @php
                                                                        $optionModel = \App\Models\ItemOption::find(
                                                                            $option['id'],
                                                                        );
                                                                    @endphp
                                                                    <div style="display: flex; align-items: center; background: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                                                        @if ($optionModel && $optionModel->image)
                                                                            <img src="{{ asset('storage/' . $optionModel->image) }}"
                                                                                alt="{{ $optionModel->type }}"
                                                                                style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px; margin-right: 12px; border: 1px solid #e5e7eb;">
                                                                        @else
                                                                            <div style="width: 48px; height: 48px; background-color: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-right: 12px; border: 1px solid #e5e7eb;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    style="width: 24px; height: 24px; color: #9ca3af;"
                                                                                    viewBox="0 0 24 24" fill="currentColor">
                                                                                    <circle cx="12" cy="12" r="10"
                                                                                        fill="none" stroke="currentColor"
                                                                                        stroke-width="2" />
                                                                                    <path d="M12 2v20M2 12h20" stroke="currentColor"
                                                                                        stroke-width="2" />
                                                                                </svg>
                                                                            </div>
                                                                        @endif
                                                                        <div style="font-weight: 500; color: #1e293b; font-size: 15px;">
                                                                            {{ $option['type'] ?? 'Unknown' }}</div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @if (!empty($cartItem->included_utilities))
                                        <div style="margin-top: 16px;">
                                            <strong style="color: #4b5563; display: block; margin-bottom: 8px;">Included Utilities:</strong>
                                            <ul style="margin: 0; padding-left: 20px; list-style-type: disc;">
                                                @foreach ($cartItem->included_utilities as $utility)
                                                    <li style="margin-bottom: 6px; color: #6b7280;">{{ $utility }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>

            <!-- Order Summary -->
            <div style="background-color: #f8fafc; border-radius: 10px; padding: 24px; margin-bottom: 32px; border: 1px solid #e5e7eb;">
                <h3 style="color: #1e293b; font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb;">Order Summary</h3>
                <table style="width: 100%;">
                    <tr>
                        <td style="color: #64748b; padding: 10px 0; width: 50%; font-size: 15px;">Order ID</td>
                        <td style="color: #1e293b; font-weight: 500; padding: 10px 0; text-align: right; font-size: 15px;">#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 10px 0; font-size: 15px;">Event Type</td>
                        <td style="color: #1e293b; padding: 10px 0; text-align: right; font-size: 15px;">{{ $order->event_type }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 10px 0; font-size: 15px;">Event Date</td>
                        <td style="color: #1e293b; padding: 10px 0; text-align: right; font-size: 15px;">
                            {{ \Carbon\Carbon::parse($order->event_date)->format('F d, Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 10px 0; font-size: 15px;">Total Amount</td>
                        <td style="color: #2563eb; font-weight: 600; padding: 10px 0; text-align: right; font-size: 15px;">
                            ₱{{ number_format($order->total, 2) }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Button -->
            <div style="text-align: center; margin: 32px 0 24px;">
                <a href="{{ url(route('order.show', $order->id)) }}" style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.2s; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.1);">
                    View  Order Status
                </a>
            </div>

            <!-- Footer -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 24px; text-align: center;">
                <p style="color: #6b7280; font-size: 15px; margin-bottom: 16px;">Need help? Contact our support team</p>
                <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 24px;">
                    <a href="#" style="color: #9ca3af; transition: color 0.2s;">
                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                </div>
                <p style="color: #9ca3af; font-size: 13px;">&copy; {{ date('Y') }} Saas Food and Catering Services. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>