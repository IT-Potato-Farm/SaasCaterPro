<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        @media print {

            /* Hide elements that are not needed for printing */
            body * {
                visibility: hidden;
            }

            #print-header {
                visibility: visible;
                display: block;
            }

            #printContent,
            #print-header,
            #printContent * {
                visibility: visible;
            }

            #printContent {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Customize the table and grid layout for print */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                padding: 10px;
                border: 1px solid #ddd;
            }

            table th {
                background-color: #f4f4f4;
                text-align: left;
            }

            .grid {
                display: block;
            }

            .grid-cols-1,
            .grid-cols-2,
            .grid-cols-4 {
                display: block;
                width: 100%;
                margin-bottom: 20px;
            }

            .grid>div {
                margin-bottom: 15px;
                page-break-inside: avoid;
            }

            .bg-white {
                background-color: white;
            }

            .rounded-xl {
                border-radius: 0;
            }

            .shadow-md {
                box-shadow: none;
            }

            .text-gray-800,
            .text-sm,
            .text-xs {
                font-size: 12pt;
            }

            .text-blue-600,
            .text-green-600,
            .text-purple-600,
            .text-yellow-600 {
                color: black;
            }

            /* Adjust chart sizes for print */
            .h-64 {
                height: auto;
            }

            .font-semibold,
            .font-bold {
                font-weight: bold;
            }

            /* Make sure images are visible in print */
            img {
                max-width: 100%;
                height: auto;
            }

            /* Optional: Adjust page margins for better print layout */
            @page {
                margin: 10mm;
            }
        }
    </style>

</head>

<body class="bg-gray-50">

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">

                <div class="container mx-auto px-4 py-6">
                    <!-- Page Header with Export Button -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Customer Analytics</h1>
                            <p class="text-gray-600 mt-1">Insights into customer behavior and spending patterns</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('admin.reports.customer') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Refresh
                            </a>
                            <button id="printBtn" onclick="window.print()"
                                class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-file-export mr-2"></i> Print Report
                            </button>

                        </div>
                    </div>


                    <!-- Filters Card -->
                    {{-- <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Options</h2>
                        <form action="{{ request()->url() }}" method="GET"
                            class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Date
                                    Range</label>
                                <input type="text" id="date_range" name="date_range"
                                    value="{{ request('date_range') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Select Date Range" />
                            </div>

                            <div>
                                <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-1">Customer
                                    Type</label>
                                <select id="customer_type" name="customer_type"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Customers</option>
                                    <option value="new" {{ request('customer_type') == 'new' ? 'selected' : '' }}>New
                                        Customers</option>
                                    <option value="returning"
                                        {{ request('customer_type') == 'returning' ? 'selected' : '' }}>Returning
                                        Customers</option>
                                </select>
                            </div>

                            <div>
                                <label for="min_spend" class="block text-sm font-medium text-gray-700 mb-1">Min. Spend
                                    (₱)</label>
                                <input type="number" id="min_spend" name="min_spend" value="{{ request('min_spend') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Minimum Spend">
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center">
                                    <i class="fas fa-filter mr-2"></i> Apply Filters
                                </button>
                            </div>
                        </form>
                    </div> --}}

                    <!-- Summary Cards -->
                    <div id="printContent">
                        <div id="print-header" class="print-header hidden   text-center p-4  ">
                            <h1 class="text-xl font-bold uppercase">SAAS Food & Catering Services</h1>
                            <p class="mt-1 text-xs">Customer Report
                            </p>
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
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Customers</p>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($reportData) }}</h3>
                                    </div>
                                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                        <i class="fas fa-users text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                            ₱{{ number_format($reportData->pluck('total_amount_spent')->sum(), 2) }}
                                        </h3>
                                    </div>
                                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                                        <i class="fas fa-money-bill-wave text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Avg. Bookings</p>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                            {{ round($reportData->pluck('number_of_bookings')->sum() / $reportData->count(), 1) }}
                                        </h3>
                                    </div>
                                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                        <i class="fas fa-calendar-check text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Top Customer</p>
                                        <h3 class="text-xl font-bold text-gray-800 mt-1 truncate">
                                            @php
                                                $topCustomer = collect($reportData)
                                                    ->sortByDesc('total_amount_spent')
                                                    ->first();
                                            @endphp
                                            {{ $topCustomer['customer_name'] ?? 'N/A' }}
                                        </h3>
                                    </div>
                                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                        <i class="fas fa-crown text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Spending Distribution</h3>
                                <div class="h-64">
                                    <canvas id="spendingChart"></canvas>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Frequency</h3>
                                <div class="h-64">
                                    <canvas id="frequencyChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Report Table -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">Customer Details</h3>
                                <div class="relative print:hidden">
                                    <div class="relative">
                                        <input type="text" id="customerSearch" placeholder="Search customers..."
                                            class="border rounded pl-10 pr-3 py-2 w-full">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                                data-column="customer_name">
                                                Customer <i class="fas fa-sort ml-1"></i>
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Contact
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                                data-column="total_amount_spent">
                                                Total Spent <i class="fas fa-sort ml-1"></i>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                                data-column="number_of_bookings">
                                                Bookings <i class="fas fa-sort ml-1"></i>
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Top Packages
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                                data-column="frequency_of_bookings">
                                                Frequency <i class="fas fa-sort ml-1"></i>
                                            </th>
                                            {{-- <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="customerTableBody" class="bg-white divide-y divide-gray-200">
                                        @foreach ($reportData as $customer)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $customer['customer_name'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    {{ $customer['mobile'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    {{-- Show the latest booking date (or "-" if none) --}}

                                                    {{ $customer['latest_event_date'] ? \Carbon\Carbon::parse($customer['latest_event_date'])->format('M d, Y') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    ₱{{ number_format($customer['total_amount_spent'], 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $customer['number_of_bookings'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    @foreach ($customer['most_popular_packages'] as $package)
                                                        <span
                                                            class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">
                                                            {{ $package }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $customer['frequency_of_bookings'] }}
                                                </td>
                                                {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900"
                                                        onclick="openModal('{{ $customer['customer_name'] }}')">
                                                        View Profile
                                                    </button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>

        <!-- Modal -->
        <div id="profileModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Customer Profile</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                </div>
                <div id="modalContent" class="text-gray-700">

                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize search functionality
        document.getElementById('customerSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#customerTableBody tr');

            rows.forEach(row => {
                const customerName = row.cells[0].textContent.toLowerCase();
                const contactInfo = row.cells[1].textContent.toLowerCase();
                const date = row.cells[2]?.textContent.toLowerCase() || '';
                const packages = row.cells[5]?.textContent.toLowerCase() || '';
                if (customerName.includes(searchTerm) ||
                    contactInfo.includes(searchTerm) ||
                    date.includes(searchTerm) ||
                    packages.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });


        // Initialize sorting functionality
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.column;
                const table = document.getElementById('customerTableBody');
                const rows = Array.from(table.rows);
                let columnIndex;

                switch (column) {
                    case 'customer_name':
                        columnIndex = 0;
                        break;
                    case 'total_amount_spent':
                        columnIndex = 3;
                        break;
                    case 'number_of_bookings':
                        columnIndex = 4;
                        break;
                    case 'frequency_of_bookings':
                        columnIndex = 6;
                        break;
                    default:
                        columnIndex = 0;
                }

                // Get current sort direction from icon
                const headerIcon = this.querySelector('i');
                const currentDir = headerIcon.classList.contains('fa-sort-up') ? 'desc' : 'asc';

                // Update sorting icons
                document.querySelectorAll('.sortable i').forEach(icon => {
                    icon.className = 'fas fa-sort ml-1';
                });

                headerIcon.className = currentDir === 'asc' ? 'fas fa-sort-down ml-1' :
                    'fas fa-sort-up ml-1';

                // Sort rows
                rows.sort((a, b) => {
                    let valueA = a.cells[columnIndex]?.textContent.trim() || '';
                    let valueB = b.cells[columnIndex]?.textContent.trim() || '';

                    // Handle numeric values
                    if (column === 'total_amount_spent') {
                        valueA = parseFloat(valueA.replace('₱', '').replace(/,/g,
                            '')) || 0;
                        valueB = parseFloat(valueB.replace('₱', '').replace(/,/g,
                            '')) || 0;
                    } else if (column === 'number_of_bookings' || column ===
                        'frequency_of_bookings') {
                        valueA = parseInt(valueA) || 0;
                        valueB = parseInt(valueB) || 0;
                    }

                    if (currentDir === 'asc') {
                        return valueA > valueB ? 1 : -1;
                    } else {
                        return valueA < valueB ? 1 : -1;
                    }
                });

                // Reorder table
                rows.forEach(row => table.appendChild(row));
            });
        });

        function openModal(name) {
            document.getElementById('modalContent').innerHTML = `<p><strong>Name:</strong> ${name}</p>`;
            document.getElementById('profileModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }
        // Initialize date range picker
        if (typeof flatpickr !== 'undefined') {
            flatpickr("#date_range", {
                mode: "range",
                dateFormat: "Y-m-d",
                maxDate: "today"
            });
        }
    </script>
    <script>
        // Chart initialization code for the Customer Analytics Dashboard with dynamic data from controller
        document.addEventListener('DOMContentLoaded', function() {
            // Get the data from PHP to JavaScript
            // This assumes the backend data is available in a variable called reportData
            const reportData = @json($reportData);

            // Process data for the spending distribution chart
            const processSpendingData = () => {
                // Define spending ranges
                const spendingRanges = [{
                        label: '₱0-₱5,000',
                        min: 0,
                        max: 5000
                    },
                    {
                        label: '₱5,001-₱10,000',
                        min: 5001,
                        max: 10000
                    },
                    {
                        label: '₱10,001-₱20,000',
                        min: 10001,
                        max: 20000
                    },
                    {
                        label: '₱20,001-₱50,000',
                        min: 20001,
                        max: 50000
                    },
                    {
                        label: '₱50,001+',
                        min: 50001,
                        max: Infinity
                    }
                ];

                // Initialize counts for each range
                const spendingCounts = Array(spendingRanges.length).fill(0);

                // Count customers in each spending range
                reportData.forEach(customer => {
                    const spent = customer.total_amount_spent;
                    for (let i = 0; i < spendingRanges.length; i++) {
                        if (spent >= spendingRanges[i].min && spent <= spendingRanges[i].max) {
                            spendingCounts[i]++;
                            break;
                        }
                    }
                });

                return {
                    labels: spendingRanges.map(range => range.label),
                    counts: spendingCounts
                };
            };

            // Process data for booking frequency chart
            const processBookingData = () => {
                // Define booking frequency ranges
                const bookingRanges = [{
                        label: '1-2 times',
                        min: 1,
                        max: 2
                    },
                    {
                        label: '3-5 times',
                        min: 3,
                        max: 5
                    },
                    {
                        label: '6-10 times',
                        min: 6,
                        max: 10
                    },
                    {
                        label: '11-20 times',
                        min: 11,
                        max: 20
                    },
                    {
                        label: '20+ times',
                        min: 21,
                        max: Infinity
                    }
                ];

                // Initialize counts for each range
                const bookingCounts = Array(bookingRanges.length).fill(0);

                // Count customers in each booking frequency range
                reportData.forEach(customer => {
                    const bookings = customer.number_of_bookings;
                    for (let i = 0; i < bookingRanges.length; i++) {
                        if (bookings >= bookingRanges[i].min && bookings <= bookingRanges[i].max) {
                            bookingCounts[i]++;
                            break;
                        }
                    }
                });

                return {
                    labels: bookingRanges.map(range => range.label),
                    counts: bookingCounts
                };
            };

            // Get processed data for charts
            const spendingData = processSpendingData();
            const bookingData = processBookingData();

            // Spending Distribution Chart
            const spendingCtx = document.getElementById('spendingChart').getContext('2d');
            const spendingChart = new Chart(spendingCtx, {
                type: 'bar',
                data: {
                    labels: spendingData.labels,
                    datasets: [{
                        label: 'Number of Customers',
                        data: spendingData.counts,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)', // Blue
                        borderColor: 'rgb(37, 99, 235)',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0
                            },
                            title: {
                                display: true,
                                text: 'Number of Customers',
                                color: '#6B7280',
                                font: {
                                    size: 12,
                                    weight: 'normal'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Spending Range',
                                color: '#6B7280',
                                font: {
                                    size: 12,
                                    weight: 'normal'
                                }
                            }
                        }
                    }
                }
            });

            // Booking Frequency Chart
            const frequencyCtx = document.getElementById('frequencyChart').getContext('2d');
            const frequencyChart = new Chart(frequencyCtx, {
                type: 'pie',
                data: {
                    labels: bookingData.labels,
                    datasets: [{
                        data: bookingData.counts,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)', // Blue
                            'rgba(16, 185, 129, 0.7)', // Green
                            'rgba(245, 158, 11, 0.7)', // Yellow
                            'rgba(139, 92, 246, 0.7)', // Purple
                            'rgba(239, 68, 68, 0.7)' // Red
                        ],
                        borderColor: [
                            'rgb(37, 99, 235)',
                            'rgb(5, 150, 105)',
                            'rgb(217, 119, 6)',
                            'rgb(109, 40, 217)',
                            'rgb(220, 38, 38)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    const percentage = Math.round((value / bookingData.counts.reduce((a,
                                        b) => a + b, 0)) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            },
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });











        });
    </script>

</body>

</html>
