<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-4xl font-bold mb-8">Reports</h1>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <!-- Orders Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-4xl font-bold text-center">{{ $totalOrders }}</h2>
                            <p class="text-gray-600 text-center">Total Orders</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-4xl font-bold text-center">{{ $completedOrders }}</h2>
                            <p class="text-gray-600 text-center">Completed Orders</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-4xl font-bold text-center">{{ $pendingOrders }}</h2>
                            <p class="text-gray-600 text-center">Pending Orders</p>
                        </div>

                        <!-- Revenue Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-4xl font-bold text-center">₱{{ number_format($totalRevenue, 2) }}</h2>
                            <p class="text-gray-600 text-center">Total Revenue</p>
                        </div>




                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Sales Overview Chart -->
                        <div class="bg-white rounded-lg shadow p-6">

                            <h2 class="text-xl font-semibold mb-4">Sales Overview </h2>

                            <div class="relative inline-block">
                                <select id="salesRangeSelect" onchange="filterChartSales(this.value)"
                                    class="px-3 py-1 rounded bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="today"selected>Today</option>
                                    <option value="thisWeek">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="sixMonths">Last 6 Months</option>
                                    <option value="year">This Year</option>
                                    <option value="lastYear">Last Year</option>
                                </select>
                            </div>
                            

                            <div class="h-64">
                                <div id="totalRevenueLabel" class="mt-2 text-lg font-semibold text-gray-700">
                                    Total Revenue: <span
                                        id="totalRevenueValue">{{ '₱' . number_format($yearRevenue ?? 0, 0) }}</span>
                                </div>
                                <canvas id="salesOverviewChart"></canvas>
                            </div>
                        </div>

                        <!-- Revenue by Event Type -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-4">Revenue by Event Type1</h2>
                            <div class="h-64">
                                @if (!empty($eventTypeRevenue))
                                    <canvas id="eventTypeChart"></canvas>
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <p>No revenue data available.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sales Performance Chart -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-semibold mb-4">Sales Performance</h2>

                            <div class="h-64">

                                <canvas id="salesPerformanceChart"></canvas>
                            </div>
                        </div>

                        <!-- Top Packages Table -->
                        <!-- Top Packages -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Top Packages</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Package
                                            </th>
                                            <th
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Orders
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse ($topPackages as $package)
                                            <tr>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $package['name'] }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-500">
                                                    {{ $package['total'] }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="px-4 py-3 text-center text-sm text-gray-500">
                                                    No data available.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- 2ND DUMMY REPORTS --}}
                <div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">
                    <!-- Dashboard Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-800">Reports Dashboard</h1>
                        <p class="text-gray-600 mt-2">Overview of your business performance</p>
                    </div>

                    <!-- Key Metrics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Orders Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Orders</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-blue-50">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">↗︎ 12% from last month</p>
                        </div>

                        <!-- Revenue Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Revenue</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">
                                        ₱{{ number_format($totalRevenue, 2) }}</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-green-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">↗︎ 8% from last month</p>
                        </div>

                        <!-- Conversion Rate Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Conversion Rate</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">18%</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-purple-50">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">↗︎ 3% from last month</p>
                        </div>

                        <!-- Avg. Order Value Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Avg. Order Value</p>
                                    <h3 class="text-3xl font-bold text-gray-800 mt-1">¥3,556</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-amber-50">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">↗︎ 5% from last month</p>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Sales Overview Chart -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 lg:col-span-2">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Sales Overview</h2>
                                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 bg-white">
                                    <option>Last 6 Months</option>
                                    <option>This Year</option>
                                    <option>Last Year</option>
                                </select>
                            </div>
                            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                <!-- Chart would go here -->
                                <p>Monthly sales chart visualization</p>
                            </div>
                            <div class="flex justify-between mt-4 text-xs text-gray-500">
                                <span>Jan</span>
                                <span>Feb</span>
                                <span>Mar</span>
                                <span>Apr</span>
                                <span>May</span>
                                <span>Jun</span>
                                <span>Jul</span>
                                <span>Dec</span>
                            </div>
                        </div>

                        <!-- Revenue by Event Type -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-6">Revenue by Event Type</h2>
                            <div
                                class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 mb-4">
                                <!-- Pie chart would go here -->

                                <p>Pie chart visualization</p>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                                        <span class="text-sm">Wedding</span>
                                    </div>
                                    <span class="text-sm font-medium">36%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                        <span class="text-sm">Birthday</span>
                                    </div>
                                    <span class="text-sm font-medium">28%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-purple-500 mr-2"></span>
                                        <span class="text-sm">Anniversary</span>
                                    </div>
                                    <span class="text-sm font-medium">15%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-amber-500 mr-2"></span>
                                        <span class="text-sm">Corporate</span>
                                    </div>
                                    <span class="text-sm font-medium">12%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 rounded-full bg-gray-400 mr-2"></span>
                                        <span class="text-sm">Other</span>
                                    </div>
                                    <span class="text-sm font-medium">9%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Sales Performance -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-6">Sales Performance</h2>
                            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
                                <!-- Line chart would go here -->

                                <p>Weekly performance chart</p>
                            </div>
                            <div class="flex justify-between mt-4 text-xs text-gray-500">
                                <span>4 weeks ago</span>
                                <span>3 weeks ago</span>
                                <span>1 week ago</span>
                                <span>This week</span>
                            </div>
                        </div>

                        <!-- Top Packages -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-semibold text-gray-800">Top Packages</h2>
                                <button class="text-sm text-blue-600 hover:text-blue-800">View All</button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Package</th>
                                            <th
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Orders</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Silver Package</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-500">34
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Gold Package</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-500">29
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Bronze Package</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-500">21
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Platinum Package</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-500">18
                                            </td>
                                        </tr>
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
</body>

</html>
