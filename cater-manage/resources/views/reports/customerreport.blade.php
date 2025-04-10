<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <div class="container mx-auto p-6">
                    <h1 class="text-3xl font-semibold mb-6">Customer Report</h1>
                
                    
                    <div class="mb-6">
                        <form action="{{ route('admin.reports.customer') }}" method="GET" class="flex space-x-4">
                            <div class="flex items-center">
                                <label for="date_range" class="mr-2">Date Range:</label>
                                <input type="text" id="date_range" name="date_range" class="px-4 py-2 rounded-md border border-gray-300" placeholder="Select Date Range" />
                            </div>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                        </form>
                    </div>
                
                    <!-- Customer Report Table -->
                    <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-4">
                        <table class="min-w-full table-auto border-collapse">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Customer Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Contact Information</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Total Amount Spent</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Number of Bookings</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Most Popular Packages</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Frequency of Bookings</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-600">
                                @foreach($reportData as $data)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $data['customer_name'] }}</td>
                                    <td class="px-6 py-4">{{ $data['contact_information'] }}</td>
                                    <td class="px-6 py-4">{{ number_format($data['total_amount_spent'], 2) }}</td>
                                    <td class="px-6 py-4">{{ $data['number_of_bookings'] }}</td>
                                    <td class="px-6 py-4">
                                        @foreach($data['most_popular_packages'] as $packageId)
                                            Package: {{ $packageId }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $data['frequency_of_bookings'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

    </div>
</body>
</html>
