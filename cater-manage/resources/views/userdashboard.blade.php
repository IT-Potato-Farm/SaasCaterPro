<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white p-6 fixed h-full">
            <div class="flex items-center gap-2 mb-8">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-xl font-bold">Dashboard</h2>
            </div>
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('landing') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('userdashboard') }}"
                            class="flex items-center gap-3 p-3 rounded-lg bg-gray-900 text-blue-400 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            My Orders
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Order History</h1>
                        <p class="text-sm text-gray-600">View and manage your orders</p>
                    </div>
                   
                </div>
            </header>

            <!-- Orders Table -->
            <main class="flex-1 overflow-auto p-8 bg-gray-50">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="px-6 py-4">Order ID</th>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4 text-center">Payment</th>
                                        <th class="px-6 py-4 text-center">Delivery Time</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                <a href="{{ route('order.show', $order->id) }}" 
                                                   class="hover:text-blue-600 transition-colors">
                                                    #{{ $order->id }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if ($order->paid)
                                                    <div class="inline-flex items-center gap-1 text-green-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center gap-1 text-red-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-center">
                                                {{ $order->delivery_time ? \Carbon\Carbon::parse($order->delivery_time)->format('h:i A') : '--' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $statusStyles = [
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'processing' => 'bg-blue-100 text-blue-800',
                                                        'cancelled' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right font-medium">
                                                ₱{{ number_format($order->total, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center">
                                                <div class="flex flex-col items-center justify-center gap-4 text-gray-500">
                                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                        </path>
                                                    </svg>
                                                    <p class="text-lg">No orders found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 px-6 py-4 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-700">
                                <div class="mb-4 sm:mb-0">
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                                </div>
                                <div class="flex space-x-2">
                                    {{ $orders->onEachSide(1)->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>