<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Order #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
</head>

<body class="bg-gray-100">
    <x-customer.navbar />
    <div class="flex h-screen">
      
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-600 mt-1">Order placed on {{ $order->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <nav class="hidden sm:block">
                        <ol class="flex items-center space-x-2 text-gray-600 text-sm">
                            <li>
                                <a href="{{ route('landing') }}" class="hover:underline hover:text-blue-600">Home</a>
                            </li>
                            <li>/</li>
                            <li>
                                <a href="{{ route('userdashboard') }}" class="hover:underline hover:text-blue-600">My
                                    Orders</a>
                            </li>
                            <li>/</li>
                            <li class="text-gray-800 font-medium">Order #{{ $order->id }}</li>
                        </ol>
                    </nav>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto p-8">
                <!-- Progress Bar -->
                <div class="max-w-4xl mx-auto mb-12">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Order Progress</h2>
                    <div class="relative">
                        <div class="flex justify-between">
                            @php
                                $steps = [
                                    'placed' => [
                                        'title' => 'Order Placed',
                                        'status' => in_array($order->status, [
                                            'placed', 'pending', 'partial', 'ongoing', 'paid', 'completed', 'cancelled'
                                        ]),
                                    ],
                                    'pending' => [
                                        'title' => 'Pending',
                                        'status' => in_array($order->status, ['pending', 'partial', 'ongoing', 'paid', 'completed']),
                                    ],
                                    'partial' => [
                                        'title' => 'Partial',
                                        'status' => in_array($order->status, ['partial', 'ongoing', 'paid', 'completed']),
                                    ],
                                    'ongoing' => [
                                        'title' => 'Ongoing',
                                        'status' => in_array($order->status, ['ongoing', 'paid', 'completed']),
                                    ],
                                    'paid' => [
                                        'title' => 'Paid',
                                        'status' => in_array($order->status, ['paid', 'completed']),
                                    ],
                                    'completed' => [
                                        'title' => 'Completed',
                                        'status' => $order->status === 'completed',
                                    ],
                                    'cancelled' => [
                                        'title' => 'Cancelled',
                                        'status' => $order->status === 'cancelled',
                                    ],
                                ];
                            @endphp
                
                            @foreach ($steps as $key => $step)
                                <div class="flex flex-col items-center w-1/7">
                                    <div class="relative mb-2">
                                        <!-- Progress line -->
                                        @if (!$loop->first)
                                            <div class="absolute h-[2px] w-full -left-1/2 top-1/2 transform -translate-y-1/2">
                                                <div class="h-full {{ $steps[array_keys($steps)[$loop->index - 1]]['status'] ? 'bg-green-500' : 'bg-gray-200' }}">
                                                </div>
                                            </div>
                                        @endif
                
                                        <!-- Step circle -->
                                        <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $step['status'] ? 'bg-green-500 border-2 border-green-600' : 'bg-white border-2 border-gray-300' }}">
                                            @if ($step['status'])
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-sm font-medium {{ $step['status'] ? 'text-gray-900' : 'text-gray-500' }}">
                                            {{ $step['title'] }}
                                        </span>
                                        @if ($key === 'pending' && $order->status === 'pending')
                                            <div class="mt-1 text-xs text-blue-600">Awaiting confirmation</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                

                <!-- Order Details -->
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4 text-left">Product</th>
                                    <th class="px-6 py-4 text-left">Type</th>
                                    <th class="px-6 py-4 text-center">Quantity</th>
                                    <th class="px-6 py-4 text-left">Variant</th>
                                    <th class="px-6 py-4 text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            @if ($item->item_type === 'menu_item')
                                                {{ $item->itemable->name ?? 'N/A' }}
                                            @elseif($item->item_type === 'package')
                                                {{ $item->itemable->name ?? 'N/A' }}
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            @if ($item->item_type === 'menu_item')
                                                Menu Item
                                            @elseif ($item->item_type === 'package')
                                                Package
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4">
                                            @if ($item->item_type === 'menu_item')
                                                @if (!empty($item->variant))
                                                    {{ $item->variant }} per pax
                                                @else
                                                    -
                                                @endif
                                            @elseif ($item->item_type === 'package')
                                                @if (!empty($item->variant))
                                                    {{ $item->variant }} guests
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">₱{{ number_format($item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t">
                        <div class="flex justify-end items-center">
                            <div class="text-lg font-semibold text-gray-800 mr-4">Total:</div>
                            <div class="text-2xl font-bold text-gray-900">₱{{ number_format($order->total, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <form action="{{ route('orderUser.cancel', ['order' => $order->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-4 py-2 text-white font-semibold rounded-lg 
                            {{ in_array($order->status, ['partial', 'ongoing', 'paid', 'completed']) ? 'bg-gray-400 cursor-not-allowed pointer-events-none' : 'bg-red-500 hover:bg-red-600' }}"
                            {{ in_array($order->status, ['partial', 'ongoing', 'paid', 'completed']) ? 'disabled' : '' }}>
                            Cancel Order
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script>
        function confirmCancel() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to cancel this order. This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelForm').submit();
                }
            });
        }
        </script>
</body>

</html>
