<!DOCTYPE html>
<html lang="en">

<head>
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

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Sales Overview Chart -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Sales Overview</h2>
                                <select id="salesRangeSelect" onchange="filterChartSales(this.value)"
                                    class="px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="today" selected>Today</option>
                                    <option value="thisWeek">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="sixMonths">Last 6 Months</option>
                                    <option value="year">This Year</option>
                                    <option value="lastYear">Last Year</option>
                                </select>
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
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
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
                                                        3.2%
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

    {{-- CHART TOTAL SALES OVERVIEW EARNING JS DE TO GUMAGANA IF NASA IBANG FILES YAWA --}}
    <script>
        const totalRevenues = {
            today: {{ $todayRevenue ?? 0 }},
            month: {{ $monthRevenue ?? 0 }},
            thisWeek: {{ $thisWeekRevenue ?? 0 }},
            sixMonths: {{ $lastSixMonthsRevenue ?? 0 }},
            year: {{ $yearRevenue ?? 0 }},
            lastYear: {{ $lastYearRevenue ?? 0 }}
        };

        const chartDataSets = {
            today: @json($todayRevenueChart),
            month: @json($thisMonthRevenueChart),
            thisWeek: @json($thisWeekRevenueChart),
            sixMonths: @json($lastSixMonthsRevenueChart),
            year: @json($thisYearRevenueChart),
            lastYear: @json($lastYearRevenueChart)
        };

        const chartLabels = {
            today: @json($todayRevenueLabels),
            month: @json($thisMonthRevenueLabels),
            thisWeek: @json($thisWeekRevenueLabels),
            sixMonths: @json($lastSixMonthsRevenueLabels),
            year: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            lastYear: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        };

        const chartColors = {
            thisYear: "#3B82F6",
            lastYear: "#E5E7EB",
            gridY: "#F3F4F6",
            tickText: "#6B7280",
            tooltipBg: "#1F2937",
            tooltipBorder: "#374151",
            tooltipText: "#F9FAFB",
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

            window.salesOverviewChart.data.labels = chartLabels[range] || [];
            window.salesOverviewChart.data.datasets[0].data = newData;

            window.salesOverviewChart.data.datasets[0].label = {
                today: "Today",
                month: "This Month",
                thisWeek: "This Week",
                sixMonths: "Last 6 Months",
                year: "This Year",
                lastYear: "Last Year"
            } [range] || "Sales";

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
