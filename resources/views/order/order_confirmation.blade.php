<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-gray-50">
    <x-customer.navbar />
    {{-- ERROR MESSAGE --}}
    @if (session('error'))
        <div class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <div class="ms-3 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-error" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif


    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-4xl">
        <!-- Confirmation Header -->
        <div class="text-center mb-8">
            <div class="mx-auto bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Order Placed!</h1>
            <p class="text-gray-600">Thank you for your order, {{ $order->user->first_name }}! We are currently
                processing your request and will send you a confirmation email soon.</p>
            <p class="text-gray-600">A confirmation email has been sent to {{ $order->user->email }}</p>
            <p class="text-gray-600">An invoice for your order has also been generated and included in the email.</p>

        </div>

        <!-- ORDER DETAILS  -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-medium">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-medium text-green-600">₱{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Event  -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Event Details</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600">
                            <span class="font-medium">Event Date:</span>
                            @if(\Carbon\Carbon::parse($order->event_date_start)->isSameDay(\Carbon\Carbon::parse($order->event_date_end)))
                                {{ \Carbon\Carbon::parse($order->event_date_start)->format('F j, Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($order->event_date_start)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($order->event_date_end)->format('F j, Y') }}
                            @endif
                        </p>
                        <p class="text-gray-600"><span class="font-medium">Location:</span> {{ $order->event_address }}
                        </p>
                        @if ($order->total_guests > 0)
                            <p class="text-gray-600"><span class="font-medium">Guests:</span> {{ $order->total_guests }}
                            </p>
                        @endif
                        <p class="text-gray-600"><span class="font-medium">Type:</span> {{ $order->event_type }}</p>
                        @if ($order->event_start_time && $order->event_start_end)
                            <p class="text-gray-600">
                                <span class="font-medium">Event Time:</span>
                                {{ \Carbon\Carbon::parse($order->event_start_time)->format('g:i A') }} -
                                {{ \Carbon\Carbon::parse($order->event_start_end)->format('g:i A') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->


        <div class="text-center">
            <p class="text-gray-600 mb-4">We'll send you a confirmation email with the status of your order.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('landing') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Return Home
                </a>
                {{-- <a href="#"
                    class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    Print Receipt
                </a> --}}
            </div>
            <p class="mt-6 text-gray-600">Need help? <a href="#" class="text-blue-600 hover:underline">Contact
                    us</a></p>
        </div>
    </div>
</body>

</html>
