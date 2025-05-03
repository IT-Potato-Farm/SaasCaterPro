<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <style>
        body {
            background-color: #fff !important;
            /* White background */
        }

        main {
            background-color: #fff !important;
            /* White background for the main content */
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printArea,
            #printingHeader,
            #printArea * {
                visibility: visible;
            }

            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }

            /* Fix canvas charts */
            .chart-container,
            .apexcharts-canvas,
            canvas {
                max-width: 100% !important;
                width: 100% !important;
                height: auto !important;
                page-break-inside: avoid;
                break-inside: avoid;
                display: block;
                /* Important for canvas */
            }

            /* Avoid page breaks inside charts */
            .no-break-inside {
                page-break-inside: avoid;
                break-inside: avoid;
                display: block;
            }

            /* Make the chart div taller when printing if needed */
            .print-h-auto {
                height: auto !important;
                min-height: 350px !important;

            }
        }
    </style>

</head>

<body>
    <div class="flex h-screen bg-gray-50">
        <!-- SIDENAV -->
        <x-dashboard.side-nav />
        <!-- END SIDENAV -->


        <div id="printArea" class="flex-1 flex flex-col overflow-hidden">
            <div id="printingHeader" class="hidden print:block text-center ">
                <h1 class="text-2xl font-bold">SAAS Food & Catering Services</h1>
                <p class="text-sm text-gray-600">Generated on: <span id="generatedDate"></span></p>
                <h2 class="text-xl font-semibold mt-1">Analytics Report</h2>
            </div>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8 print:hidden">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Analytics Dashboard</h1>
                            <p class="text-gray-500">Welcome back! Here's an overview of your business performance</p>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="printDiv('printArea')"
                                class="cursor-pointer px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Print
                            </button>
                            {{-- <button onclick="downloadPDF()"
                                class="cursor-pointer px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                Export as PDF
                            </button> --}}
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Orders Card -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">


                            <!--WEEKLY Growth -->
                            <div class="flex justify-between items-center mb-4">
                                <span class="p-2 rounded-lg bg-blue-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </span>
                                <span
                                    class="text-xs font-medium {{ $weeklyGrowthFormatted === 'New' ? 'text-yellow-600 bg-yellow-50' : ($weeklyGrowthFormatted > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50') }} px-2 py-1 rounded-full">
                                    {{ $weeklyGrowthFormatted }}
                                </span>
                            </div>

                            <!-- Total Orders -->
                            <h2 class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</h2>
                            <p class="text-gray-500 text-sm mt-1">Total Orders</p>
                        </div>


                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <span class="p-2 rounded-lg bg-green-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                {{-- <span
                                    class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">+2.2%</span> --}}
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $completedOrders }}</h2>
                            <p class="text-gray-500 text-sm mt-1">Completed Orders</p>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <span class="p-2 rounded-lg bg-yellow-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                {{-- <span
                                    class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">+0.8%</span> --}}
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $pendingOrders }}</h2>
                            <p class="text-gray-500 text-sm mt-1">Pending Orders</p>
                        </div>

                        <!-- Revenue Card -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <span class="p-2 rounded-lg bg-purple-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                {{-- <span
                                    class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">+8.3%</span> --}}
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</h2>
                            <p class="text-gray-500 text-sm mt-1">Total Revenue</p>
                        </div>
                    </div>

                    {{-- upcoming events --}}
                    <!-- Upcoming Events Component -->
                    <div class="bg-white rounded-lg shadow-sm p-5 max-w-md print:hidden">
                        <h2 class="text-lg font-medium text-gray-800 mb-1">Upcoming events</h2>
                        <p class="text-sm text-gray-500 mb-4">Don't miss scheduled events</p>

                        <!-- Event List -->
                        @forelse($upcomingOrders as $order)
                            <div class="mb-4 bg-white rounded-lg border border-gray-100 hover:shadow transition-shadow cursor-pointer"
                                onclick="showOrderDetails({{ $order->id }})">
                                <div class="p-4">
                                    <!-- Time with Color Indicator -->
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-2 h-2 rounded-full 
                                            @if ($order->event_type == 'Wedding') bg-blue-500
                                            @elseif($order->event_type == 'Birthday') bg-pink-500 
                                            @elseif($order->event_type == 'Anniversary') bg-green-500
                                            @elseif($order->event_type == 'Corporate') bg-indigo-500
                                            @elseif($order->event_type == 'Simple Celebration') bg-yellow-500
                                            @else bg-gray-500 @endif mr-2">
                                        </div>
                                        <span
                                            class="text-sm text-gray-500">{{ date('g:i A', strtotime($order->event_start_time)) }}-{{ date('g:i A', strtotime($order->event_start_end)) }}</span>
                                        <div class="ml-auto">
                                            <!-- Status Badge -->
                                            <span
                                                class="px-2 py-1 text-xs rounded-full
                                                @if ($order->status == 'confirmed') bg-green-100 text-green-800
                                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Event Title (Modified based on the event type options) -->
                                    <h3 class="font-medium text-gray-800">
                                        @if ($order->event_type == 'Wedding')
                                            Wedding
                                        @elseif ($order->event_type == 'Birthday')
                                            Birthday Celebration
                                        @elseif ($order->event_type == 'Anniversary')
                                            Anniversary Celebration
                                        @elseif ($order->event_type == 'Corporate')
                                            Corporate Event
                                        @elseif ($order->event_type == 'Simple Celebration')
                                            Simple Celebration
                                        @else
                                            {{ $order->event_type }}
                                        @endif
                                    </h3>

                                    <!-- Event Description -->
                                    <p class="text-sm text-gray-500">{{ $order->user->first_name }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-4">
                                No upcoming events
                            </div>
                        @endforelse
                    </div>



                    <!-- Order Details Modal -->
                    <div id="orderDetailsModal"
                        class="fixed inset-0  bg-opacity-50 hidden z-50 flex items-center justify-center">

                        <!-- Modal Content -->
                        <div
                            class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-3">
                                    <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Order Details</h3>
                                    <button type="button" onclick="closeOrderModal()"
                                        class="text-gray-400 hover:text-gray-600">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Content -->
                                <div class="mt-4" id="orderDetailsContent">
                                    <div class="flex justify-center">
                                        <svg class="animate-spin h-8 w-8 text-blue-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4" />
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="mt-6 border-t pt-3 flex justify-end">
                                    <button type="button" onclick="closeOrderModal()"
                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>






                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Sales Overview Chart -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div
                                class="flex flex-col gap-4 lg:flex-row lg:justify-between lg:items-center mb-6 flex-wrap">

                                <h2 class="text-base sm:text-lg md:text-xl font-semibold text-gray-800">
                                    Sales Overview
                                </h2>

                                <!-- Filter Controls -->
                                <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center flex-wrap">
                                    <button id="customDateBtn" onclick="showCustomDateFilter()"
                                        class="bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-300">
                                        Use Custom Date Range
                                    </button>

                                    <button id="backToPresetBtn" onclick="backToPreset()"
                                        class="hidden bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-300">
                                        Back to Preset Dates
                                    </button>

                                    <select id="salesRangeSelect" onchange="filterChartSales(this.value)"
                                        class="px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="today" selected>Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="thisWeek">This Week</option>
                                        <option value="month">This Month</option>
                                        <option value="sixMonths">Last 6 Months</option>
                                        <option value="year">This Year</option>
                                        <option value="lastYear">Last Year</option>
                                    </select>


                                    <div id="customDateRange"
                                        class="hidden flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                        <input type="date" id="startDate"
                                            class="px-2 py-1 border rounded-md text-sm" />
                                        <input type="date" id="endDate"
                                            class="px-2 py-1 border rounded-md text-sm" />
                                        <button onclick="filterCustomDateRange()"
                                            class="bg-blue-500 text-white text-sm px-3 py-1 rounded-md">
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <div id="totalRevenueLabel" class="mb-4 text-sm font-medium text-gray-500">
                                Total Revenue: <span id="totalRevenueValue"
                                    class="text-gray-900 font-bold">₱{{ number_format($yearRevenue ?? 0, 0) }}</span>
                            </div>

                            <div class="h-64  ">
                                <canvas class="chart-container" id="salesOverviewChart"></canvas>
                            </div>
                        </div>

                        <!-- Revenue by Event Type -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Revenue by Event Type</h2>
                                <div class="bg-blue-50 text-blue-600 text-xs font-medium py-1 px-2 rounded-full">
                                    This Year
                                </div>
                            </div>

                            <div class="h-64 no-break-inside print-h-auto ">
                                @if (!empty($eventTypeRevenue))
                                    <canvas class="chart-container" id="eventTypeChart"></canvas>
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <p>No revenue data available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Sales Performance Chart -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Sales Performance</h2>
                                <div class="flex space-x-2">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                                        <span class="text-xs text-gray-500">This Year</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-gray-300 mr-1"></span>
                                        <span class="text-xs text-gray-500">Last Year</span>
                                    </div>
                                </div>
                            </div>

                            <div class="h-64 no-break-inside print-h-auto ">
                                <canvas class="chart-container" id="salesPerformanceChart"></canvas>
                            </div>
                        </div>

                        <!-- Top Packages Table -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Top Packages</h2>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-l-lg">
                                                Package
                                            </th>
                                            <th
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider rounded-r-lg">
                                                Orders
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse ($topPackages as $package)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $package['name'] }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-700">
                                                    <span class="font-medium">{{ $package['total'] }}</span>
                                                    <span class="ml-1 text-xs text-green-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                        </svg>

                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2"
                                                    class="px-4 py-6 text-center text-sm text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-10 w-10 mx-auto text-gray-300 mb-2" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p>No data available</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>





                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- EVENT TYPE REVENUE CHART --}}
    @if (!empty($eventTypeRevenue))
        <script>
            const eventTypeLabels = @json(array_keys($eventTypeRevenue));
            const eventTypeData = @json(array_values($eventTypeRevenue));
        </script>
        <script src="{{ asset('js/eventTypeRevenue-chart.js') }}"></script>
    @endif

    <script>
        function showOrderDetails(orderId) {
            const modal = document.getElementById('orderDetailsModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent background scroll

            document.getElementById('orderDetailsContent').innerHTML = `
        <div class="flex justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    `;

            // Fetch order details via AJAX
            fetch(`/api/orders/${orderId}/details`)
                .then(response => response.json())
                .then(data => {
                    populateOrderDetails(data);
                })
                .catch(error => {
                    document.getElementById('orderDetailsContent').innerHTML = `
                    <div class="text-red-500 text-center py-4">
                        Error loading order details. Please try again.
                    </div>
                `;
                    console.error('Error fetching order details:', error);
                });
        }

        function populateOrderDetails(order) {
            const eventStartDate = new Date(order.event_date_start).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const eventEndDate = new Date(order.event_date_end).toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            let statusClass = 'bg-gray-100 text-gray-800';
            if (order.status === 'confirmed') statusClass = 'bg-green-100 text-green-800';
            if (order.status === 'pending') statusClass = 'bg-yellow-100 text-yellow-800';
            if (order.status === 'paid') statusClass = 'bg-blue-100 text-blue-800';

            document.getElementById('modalTitle').textContent = `${order.event_type} Details`;

            let content = `
        <div class="space-y-4">
            <div class="flex justify-between">
                <div>
                    <span class="text-sm text-gray-500">Customer</span>
                    <div class="font-medium text-gray-800">${order.user.first_name} ${order.user.last_name}</div>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full ${statusClass} text-sm font-medium">
                        ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                    </span>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-800 mb-2">Event</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Type</span>
                        <div class="font-medium text-gray-800">${order.event_type}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Guests</span>
                        <div class="font-medium text-gray-800">${order.total_guests}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Start</span>
                        <div class="font-medium text-gray-800">${eventStartDate}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">End</span>
                        <div class="font-medium text-gray-800">${eventEndDate}</div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-gray-500">Location</span>
                    <div class="font-medium text-gray-800">${order.event_address}</div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-800 mb-2">Payment</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Total</span>
                        <div class="font-medium text-gray-800">₱${parseFloat(order.total).toLocaleString()}</div>
                    </div>
                    <div>
                        <span class="text-gray-500">Paid</span>
                        <div class="font-medium text-gray-800">₱${parseFloat(order.amount_paid).toLocaleString()}</div>
                    </div>
                </div>
            </div>
    `;
            content += `</div>`;
            document.getElementById('orderDetailsContent').innerHTML = content;
        }

        function closeOrderModal() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }

        function showCustomDateFilter() {
            const customRange = document.getElementById('customDateRange');
            const selectRange = document.getElementById('salesRangeSelect');
            const backBtn = document.getElementById('backToPresetBtn');
            const customBtn = document.getElementById('customDateBtn');

            customRange.classList.remove('hidden');
            selectRange.classList.add('hidden');
            backBtn.classList.remove('hidden');
            customBtn.classList.add('hidden');
        }

        function backToPreset() {
            const customRange = document.getElementById('customDateRange');
            const selectRange = document.getElementById('salesRangeSelect');
            const backBtn = document.getElementById('backToPresetBtn');
            const customBtn = document.getElementById('customDateBtn');

            customRange.classList.add('hidden');
            selectRange.classList.remove('hidden');
            backBtn.classList.add('hidden');
            customBtn.classList.remove('hidden');

            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('salesRangeSelect').value = 'today';
            
            filterChartSales('today');
        }
    </script>

    </script>

    {{-- CHART TOTAL SALES OVERVIEW EARNING JS DE TO GUMAGANA IF NASA IBANG FILES YAWA --}}
    <script>
        const totalRevenues = {
            today: {{ $todayRevenue ?? 0 }},
            yesterday: {{ $yesterdayRevenue ?? 0 }},
            month: {{ $monthRevenue ?? 0 }},
            thisWeek: {{ $thisWeekRevenue ?? 0 }},
            sixMonths: {{ $lastSixMonthsRevenue ?? 0 }},
            year: {{ $yearRevenue ?? 0 }},
            lastYear: {{ $lastYearRevenue ?? 0 }},
            custom: 0
        };

        const chartDataSets = {
            today: @json($todayRevenueChart),
            yesterday: @json($yesterdayRevenueChart),
            month: @json($thisMonthRevenueChart),
            thisWeek: @json($thisWeekRevenueChart),
            sixMonths: @json($lastSixMonthsRevenueChart),
            year: @json($thisYearRevenueChart),
            lastYear: @json($lastYearRevenueChart),
            custom: []
        };

        const chartLabels = {
            today: @json($todayRevenueLabels),
            yesterday: @json($yesterdayRevenueLabels),
            month: @json($thisMonthRevenueLabels),
            thisWeek: @json($thisWeekRevenueLabels),
            sixMonths: @json($lastSixMonthsRevenueLabels),
            year: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            lastYear: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            custom: []
        };

        const chartColors = {
            thisYear: "#3B82F6",
            lastYear: "#E5E7EB",
            gridY: "#F3F4F6",
            tickText: "#6B7280",
            tooltipBg: "#1F2937",
            tooltipBorder: "#374151",
            tooltipText: "#F9FAFB",
            custom: "#10B981",
        };
        // TODAY DEFAULT CHART
        let activeButton = 'today';

        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById('salesRangeSelect');
            const initialRange = select ? select.value : 'today';

            activeButton = initialRange;

            const ctxElement = document.getElementById("salesOverviewChart");
            if (!ctxElement) return;

            const ctx = ctxElement.getContext("2d");

            window.salesOverviewChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: chartLabels[initialRange] || [],
                    datasets: [{
                        label: {
                            today: "Today",
                            yesterday: "Yesterday",
                            month: "This Month",
                            thisWeek: "This Week",
                            sixMonths: "Last 6 Months",
                            year: "This Year",
                            lastYear: "Last Year"
                        } [initialRange] || "Sales",
                        data: chartDataSets[initialRange] || [],
                        borderColor: chartColors.thisYear,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: "rgba(59, 130, 246, 0.05)",
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: chartColors.thisYear,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 500,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: chartColors.gridY
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat("en-PH", {
                                        style: "currency",
                                        currency: "PHP",
                                        minimumFractionDigits: 0,
                                    }).format(value);
                                },
                                color: chartColors.tickText,
                            },
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: chartColors.tickText
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: chartColors.tooltipBg,
                            titleColor: chartColors.tooltipText,
                            bodyColor: chartColors.tooltipText,
                            borderColor: chartColors.tooltipBorder,
                            borderWidth: 1,
                            padding: 12,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw || 0;
                                    return (
                                        context.dataset.label +
                                        ": " +
                                        new Intl.NumberFormat("en-PH", {
                                            style: "currency",
                                            currency: "PHP",
                                            minimumFractionDigits: 0,
                                        }).format(value)
                                    );
                                },
                            },
                        },
                    },
                },
            });

            const total = totalRevenues[initialRange] || 0;
            const totalValueElement = document.getElementById('totalRevenueValue');
            if (totalValueElement) {
                totalValueElement.textContent = new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                    minimumFractionDigits: 0
                }).format(total);
            }
        });

        function filterChartSales(range) {
            if (!window.salesOverviewChart) {
                console.error("Chart is not initialized yet.");
                return;
            }

            const newData = chartDataSets[range];

            if (!newData) {
                alert("No data for this range.");
                return;
            }

            activeButton = range;

            const chart = window.salesOverviewChart;
            chart.data.labels = chartLabels[range] || [];

            Object.assign(chart.data.datasets[0], {
                label: {
                    today: "Today",
                    yesterday: "Yesterday",
                    month: "This Month",
                    thisWeek: "This Week",
                    sixMonths: "Last 6 Months",
                    year: "This Year",
                    lastYear: "Last Year",
                    custom: "Custom Range"
                } [range] || "Sales",
                data: newData,
                borderColor: range === 'custom' ? chartColors.custom : chartColors.thisYear,
                backgroundColor: range === 'custom' ? "rgba(16, 185, 129, 0.05)" : "rgba(59, 130, 246, 0.05)",
                pointBorderColor: range === 'custom' ? chartColors.custom : chartColors.thisYear
            });

            window.salesOverviewChart.update();

            const total = totalRevenues[range] || 0;
            const totalValueElement = document.getElementById('totalRevenueValue');
            if (totalValueElement) {
                totalValueElement.textContent = new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                    minimumFractionDigits: 0
                }).format(total);
            }
        }

        function filterCustomDateRange() {
            const startDate = document.getElementById("startDate").value;
            const endDate = document.getElementById("endDate").value;

            if (!startDate || !endDate) {
                alert("Please select both start and end dates.");
                return;
            }
            const totalValueElement = document.getElementById('totalRevenueValue');
            if (totalValueElement) {
                totalValueElement.textContent = "Loading...";
            }

            fetch(`/chart/custom-range?startDate=${startDate}&endDate=${endDate}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(({
                    labels,
                    data,
                    total
                }) => {
                    if (!window.salesOverviewChart) {
                        console.error("Chart is not initialized.");
                        return;
                    }

                    // console.log("Custom range data received:", {
                    //     labels,
                    //     data,
                    //     total
                    // });

                    // Store the data for future reference
                    chartDataSets['custom'] = data;
                    chartLabels['custom'] = labels;
                    totalRevenues['custom'] = total;

                    // Set active button
                    activeButton = 'custom';

                    // Update chart configuration
                    window.salesOverviewChart.data.labels = labels;
                    window.salesOverviewChart.data.datasets[0].data = data;
                    window.salesOverviewChart.data.datasets[0].label = "Custom Range";
                    window.salesOverviewChart.data.datasets[0].borderColor = chartColors.custom;
                    window.salesOverviewChart.data.datasets[0].backgroundColor = "rgba(16, 185, 129, 0.05)";
                    window.salesOverviewChart.data.datasets[0].pointBorderColor = chartColors.custom;

                    // Force chart update
                    window.salesOverviewChart.update();

                    // Update total value display
                    if (totalValueElement) {
                        totalValueElement.textContent = new Intl.NumberFormat("en-PH", {
                            style: "currency",
                            currency: "PHP",
                            minimumFractionDigits: 0
                        }).format(total);
                    }

                    console.log("Chart updated with custom data");
                })
                .catch(err => {
                    console.error("Failed to fetch chart data", err);
                    alert("Error loading chart data: " + err.message);
                });
        }
    </script>


    {{-- SALES PERFORMANCE CHART --}}
    <script>
        window.salesPerformanceData = @json($weeklySales);
    </script>
    <script src="{{ asset('js/salesPerformanceChart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('generatedDate').textContent = now.toLocaleString('en-US', options);
        });

        function printDiv(divId) {
            window.print();
        }

        function downloadPDF() {
            const element = document.querySelector('main'); // Capture the main dashboard area
            html2pdf()
                .from(element)
                .set({
                    margin: 0.5,
                    filename: 'dashboard-analytics.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 1.5, // Lower the scale to avoid stretching issues
                        useCORS: true, // Ensure proper handling of cross-origin images
                        logging: false, // Disable logging
                        letterRendering: true, // Improve text rendering
                        backgroundColor: "#ffffff" // Ensure background is white
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'portrait'
                    }
                })
                .save();
        }
    </script>
</body>

</html>
