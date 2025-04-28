<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Orders Report - {{ now()->format('F d, Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4 portrait;
            margin: 1cm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 11pt;
                color: #000;
                background: #fff;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            .print-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                padding-bottom: 10px;
                border-bottom: 2px solid #000;
                background: #fff;
            }

            .print-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                padding-top: 10px;
                border-top: 1px solid #ddd;
                font-size: 9pt;
                background: #fff;
            }

            .content {
                margin-top: 100px;
                margin-bottom: 50px;
            }
        }
    </style>
</head>

<body class="p-0 text-gray-800 ">
        
        
        <!-- Header that repeats on each printed page -->
        <div class="print-header text-center p-4  ">
            <h1 class="text-xl font-bold uppercase">SAAS Food & Catering Services</h1>
            <p class="mt-1 text-xs">Orders Report -
                {{ request('status') != 'all' ? ucfirst(request('status')) : 'All Statuses' }}</p>
            <p class="mt-1 text-xs">
                @if (request('start_date') && request('end_date'))
                    {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }} to
                    {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                @else
                    All Dates
                @endif
            </p>
            <p class="mt-1 text-xs">Generated: {{ now()->format('M d, Y h:i A') }}</p>
        </div>
        {{-- filter --}}
        <div class="no-print p-4 flex justify-center">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="status" class="block text-xs font-semibold mb-1">Order Status</label>
                    <select name="status" id="status" class="border px-2 py-1 rounded">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>
                <div>
                    <label for="start_date" class="block text-xs font-semibold mb-1">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="border px-2 py-1 rounded">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold mb-1">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="border px-2 py-1 rounded">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Filter</button>
                <a href="{{ route('reports.orders.print') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">RESET</a>
            </form>
        </div>

        <!-- Main content area -->
        <div class="content p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-black">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-black px-2 py-1 text-left">#</th>
                            <th class="border border-black px-2 py-1 text-left">Customer</th>
                            <th class="border border-black px-2 py-1 text-left">Event Type</th>
                            <th class="border border-black px-2 py-1 text-center">Guests</th>
                            <th class="border border-black px-2 py-1 text-center">Event Dates</th>
                            <th class="border border-black px-2 py-1 text-center">Status</th>
                            <th class="border border-black px-2 py-1 text-right">Total (₱)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr>
                                <td class="border border-black px-2 py-1">{{ $index + 1 }}</td>
                                <td class="border border-black px-2 py-1">{{ $order->user->first_name }}
                                    {{ $order->user->last_name }}</td>
                                <td class="border border-black px-2 py-1">{{ $order->event_type }}</td>
                                <td class="border border-black px-2 py-1 text-center">{{ $order->total_guests }}</td>
                                <td class="border border-black px-2 py-1 text-center">
                                    {{ \Carbon\Carbon::parse($order->event_date_start)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($order->event_date_end)->format('M d, Y') }}
                                </td>
                                <td class="border border-black px-2 py-1 text-center capitalize">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs 
                                @if ($order->status == 'completed') bg-green-100 text-green-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="border border-black px-2 py-1 text-right font-medium">
                                    {{ number_format($order->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border border-black px-3 py-2 text-center text-gray-500">No
                                    orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="6" class="border border-black px-3 py-2 text-right font-semibold">Totals:
                            </td>
                           
                            <td class="border border-black px-3 py-2 text-right font-semibold">
                                {{ number_format($orders->sum('total'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 flex justify-between text-xs">
                <div class="text-left">
                    <p><strong>Total Orders:</strong> {{ count($orders) }}</p>
                    <p><strong>Total Sales:</strong> ₱{{ number_format($orders->sum('total'), 2) }}</p>
                </div>
                <div class="text-right">
                    <p><strong>Average Order Value:</strong>
                        ₱{{ count($orders) > 0 ? number_format($orders->sum('total') / count($orders), 2) : '0.00' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer that repeats on each printed page -->
        <div class="print-footer text-center p-2">
            <p class="text-xs">Generated by: {{ Auth::user()->name }} | SAAS Food & Catering Services | Page <span
                    class="page-number"></span></p>
        </div>


        <!-- Print controls (hidden when printing) -->
        <div class="no-print flex justify-center gap-5   bg-white p-4 rounded shadow-lg">
            <button onclick="window.history.back()"
                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Go Back
            </button>
            <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Report
            </button>
        </div>

    
    <script>
        // Add page numbers to footer
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.search.includes('print')) {
                window.print();
            }

            // Update page numbers
            const updatePageNumbers = () => {
                const pageNumbers = document.querySelectorAll('.page-number');
                for (let i = 0; i < pageNumbers.length; i++) {
                    pageNumbers[i].textContent = (i + 1);
                }
            };

            // Run once now
            updatePageNumbers();

            // Run again after printing starts (for multi-page documents)
            window.onbeforeprint = updatePageNumbers;
        });
    </script>

</body>

</html>
