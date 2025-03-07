<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-64 bg-gray-800 text-white p-6">
            <h2 class="text-xl font-semibold mb-6">User Dashboard</h2>
            <ul class="space-y-4">
                <li><a href="{{route('landing')}}" class="block hover:text-gray-400 transition-colors">Home</a></li>
                <li>
                    <a href="{{ route('userdashboard') }}" 
                       class="block transition-colors 
                              {{ request()->routeIs('userdashboard') ? 'text-blue-400 font-bold' : 'hover:text-gray-400' }}">
                       My Orders
                    </a>
                </li>
            </ul>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <nav class="bg-white p-4 shadow-md">
                <h2 class="text-lg font-semibold text-center">current logged in user Orders</h2>
            </nav>

            <div class="flex-1 overflow-auto p-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-4">My Orders</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-3 text-left text-sm font-semibold">Order ID</th>
                                        <th class="p-3 text-left text-sm font-semibold">Date</th>
                                        <th class="p-3 text-center text-sm font-semibold">Paid</th>
                                        <th class="p-3 text-center text-sm font-semibold">Delivery Time</th>
                                        <th class="p-3 text-center text-sm font-semibold">Status</th>
                                        <th class="p-3 text-right text-sm font-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="p-3 text-sm">
                                            <a href="{{route('orderdetails')}}" 
                                               class="hover:underline font-medium">
                                                #12345
                                            </a>
                                        </td>
                                        <td class="p-3 text-sm">March 6, 2025</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Yes</span>
                                        </td>
                                        <td class="p-3 text-center text-sm">12:30 PM</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Completed</span>
                                        </td>
                                        <td class="p-3 text-right text-sm font-medium">₱16,800.00</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="p-3 text-sm">#12346</td>
                                        <td class="p-3 text-sm">March 7, 2025</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">No</span>
                                        </td>
                                        <td class="p-3 text-center text-sm">01:00 PM</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                        </td>
                                        <td class="p-3 text-right text-sm font-medium">₱10,800.00</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="p-3 text-sm">#12347</td>
                                        <td class="p-3 text-sm">March 8, 2025</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Yes</span>
                                        </td>
                                        <td class="p-3 text-center text-sm">02:30 PM</td>
                                        <td class="p-3 text-center">
                                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Processing</span>
                                        </td>
                                        <td class="p-3 text-right text-sm font-medium">₱22,500.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex justify-between items-center px-4 py-3 border-t border-gray-200">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">32</span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 bg-gray-100 rounded-md text-sm hover:bg-gray-200">Previous</button>
                                <button class="px-3 py-1 bg-gray-100 rounded-md text-sm hover:bg-gray-200">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>