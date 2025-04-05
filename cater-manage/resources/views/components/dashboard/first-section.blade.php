<section class="p-6 bg-gray-50 ">
    <div class="container mx-auto px-4 ">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="bg-white p-6 rounded-lg border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-gray-500 text-sm mb-2">Completed Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $completedOrdersCount }}</p>
            </div>

            <div
                class="bg-white p-6 rounded-lg border-l-4 border-green-500 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-gray-500 text-sm mb-2">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800">₱1.5M</p>
            </div>

            <div
                class="bg-white p-6 rounded-lg border-l-4 border-yellow-500 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-gray-500 text-sm mb-2">Pending Orders</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-3xl font-bold text-gray-800">{{ $pendingOrdersCount }}</p>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-lg border-l-4 border-purple-500 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-gray-500 text-sm mb-2">Total Users</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm mt-5">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2 md:mb-0">Total Earnings</h3>
                <div class="flex gap-4">
                    <span class="flex items-center text-sm text-gray-500">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                        This Year
                    </span>
                    <span class="flex items-center text-sm text-gray-500">
                        <span class="w-3 h-3 bg-gray-200 rounded-full mr-2"></span>
                        Last Year
                    </span>
                </div>
            </div>
            <div class="h-80">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        
    </div>
</section>

<script>
    // Earnings Chart Configuration
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'This Year',
                    data: [6500, 5900, 8000, 8100, 5600, 5500, 4000, 6300, 7200, 7800, 8200, 9000],
                    borderColor: '#3B82F6',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3B82F6',
                },
                {
                    label: 'Last Year',
                    data: [5200, 6100, 7500, 7200, 4800, 6200, 5800, 6500, 6800, 7000, 7500, 8000],
                    borderColor: '#E5E7EB',
                    borderWidth: 2,
                    tension: 0.4,
                    borderDash: [5, 5],
                    pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        },
                        color: '#6B7280'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#F9FAFB',
                    bodyColor: '#F9FAFB',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                }
            }
        }
    });
</script>
