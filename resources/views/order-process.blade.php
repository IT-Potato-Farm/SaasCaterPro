<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Order #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Heroicons -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pap0+X+J6XlKqmvdZJzH8g4OoJ1+xM2JpUpbO8hzF2Pz2BXl+AGoD54YkS++1MJaa4xSLSFI0pY2vLxA0f5s0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
        
    <script src="{{ asset('js/toprightalert.js') }}"></script>
</head>

<body class="bg-gray-100">
    @if(session('success'))
    <script>
        showSuccessToast('{{ session('success') }}');
    </script>
    @endif
    
    @if(session('error'))
    <script>
        showErrorToast('{{ session('error') }}');
    </script>
    @endif
    @php
        $steps = [
            'placed' => [
                'title' => 'Order Placed',
                'status' => in_array($order->status, [
                    'placed',
                    'pending',
                    'partial',
                    'ongoing',
                    'paid',
                    'completed',
                    'cancelled',
                ]),
            ],
            'pending' => [
                'title' => 'Pending',
                'status' => in_array($order->status, [
                    'pending',
                    'partial',
                    'ongoing',
                    'paid',
                    'completed',
                ]),
            ],
            'partial' => [
                'title' => 'Partial',
                'status' => in_array($order->status, [
                    'partial',
                    'ongoing',
                    'paid',
                    'completed',
                ]),
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
            <main class="flex-1  p-4 sm:p-8">
                <!-- Progress Bar - Mobile Version -->
                <div class="sm:hidden max-w-4xl mx-auto mb-8">
                    <h2 class="text-lg font-bold mb-4 text-gray-800">Order Progress</h2>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center 
                                {{ $steps['placed']['status'] ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                @if($steps['placed']['status'])
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                                @endif
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $steps['placed']['status'] ? 'text-gray-900' : 'text-gray-500' }}">
                                Order Placed
                            </span>
                        </div>
                        
                        <!-- Current status display -->
                        <div class="border-l-2 border-green-500 pl-4 ml-2 py-1">
                            <div class="text-sm font-semibold text-gray-800">
                                @if($order->status === 'pending') Awaiting confirmation @endif
                                @if($order->status === 'partial') Partially fulfilled @endif
                                @if($order->status === 'ongoing') Order ongoing @endif
                                @if($order->status === 'paid') Payment received @endif
                                @if($order->status === 'completed') Order completed @endif
                                @if($order->status === 'cancelled') Order cancelled @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                @if($order->status === 'pending') We'll confirm your order soon @endif
                                @if($order->status === 'partial') Some items have been prepared @endif
                                @if($order->status === 'ongoing') Your order is being prepared @endif
                                @if($order->status === 'paid') Thank you for your payment @endif
                                @if($order->status === 'completed') We hope you enjoyed your order @endif
                                @if($order->status === 'cancelled') This order has been cancelled @endif
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Progress Bar - Desktop Version -->
                <div class="hidden sm:block max-w-4xl mx-auto mb-12">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">Order Progress</h2>
                    <div class="relative">
                        <div class="flex justify-between">
                            

                            @foreach ($steps as $key => $step)
                                <div class="flex flex-col items-center w-1/7">
                                    <div class="relative mb-2">
                                        @if (!$loop->first)
                                            <div class="absolute h-[2px] w-full -left-1/2 top-1/2 transform -translate-y-1/2">
                                                <div class="h-full {{ $steps[array_keys($steps)[$loop->index - 1]]['status'] ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                                            </div>
                                        @endif
            
                                        <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $step['status'] ? 'bg-green-500 border-2 border-green-600' : 'bg-white border-2 border-gray-300' }}">
                                            @if ($step['status'])
                                                @if ($key === 'cancelled' && $order->status === 'cancelled')
                                                    <svg class="w-4 h-4 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
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
            
                {{-- ORDER DETAILS --}}
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
                    </div>
                    @php
                        $days = $order->event_days;
                    @endphp
                    <div class="overflow-x-auto">
                        <!-- Mobile View - Card Layout -->
                        <div class="sm:hidden divide-y divide-gray-200">
                            @foreach ($order->orderItems as $item)
                                @php
                                    $isPackage = $item->item_type === 'package';
                                    $guestCount = is_numeric($item->variant) ? (int) $item->variant : 1;
                                    
                                    $subtotal = $isPackage 
                                        ? $item->price * $guestCount * $item->quantity 
                                        : $item->price * $item->quantity;
                        
                                    $priceBreakdown = $isPackage
                                    ? '₱' . number_format($item->price, 2) . ' × ' . $guestCount . ' guests × ' . $days . ' day' . ($days > 1 ? 's' : '') . ($item->quantity > 1 ? ' × ' . $item->quantity . ' package(s)' : '')
                                    : '₱' . number_format($item->price, 2) . ' × ' . $item->quantity;
                                @endphp
                                
                                <div class="p-4">
                                    <div class="flex items-start">
                                        @php
                                            $imagePath = $isPackage 
                                                ? 'storage/packagepics/' . ($item->itemable->image ?? '') 
                                                : 'storage/party_traypics/' . ($item->itemable->image ?? '');
                                        @endphp
                        
                                        @if (!empty($item->itemable->image))
                                            <div class="flex-shrink-0 h-12 w-12 mr-3">
                                                <img src="{{ asset($imagePath) }}" 
                                                     alt="{{ $item->itemable->name }}" 
                                                     class="h-12 w-12 rounded-md object-cover border border-gray-200">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-md bg-gray-100 text-gray-400 border border-gray-200 mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->itemable->name ?? 'Unknown' }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <span class="px-1.5 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full 
                                                            {{ $isPackage ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                            {{ $isPackage ? 'Package' : 'Party Tray' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-900">₱{{ number_format($subtotal, 2) }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-2 text-xs text-gray-500">
                                                <div>Qty: {{ $item->quantity }}</div>
                                                <div>Variant: {{ $isPackage ? ($item->variant ? $item->variant . ' guests' : '-') : ($item->variant ? $item->variant . ' per pax' : '-') }}</div>
                                                <div class="text-gray-600 mt-1">{{ $priceBreakdown }} </div>
                                            </div>
                                            
                                            @if ($isPackage && method_exists($item->itemable, 'packageItems'))
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <details class="group">
                                                        <summary class="flex items-center justify-between text-sm font-medium text-gray-700 cursor-pointer">
                                                            <span>Package Details</span>
                                                            <svg class="w-4 h-4 text-gray-500 group-open:rotate-180 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </summary>
                                                        
                                                        <div class="mt-2 space-y-3 ">
                                                            <div class>
                                                                <h4 class="text-xs font-medium text-gray-700 mb-1">Included Foods:</h4>
                                                                <ul class="space-y-1 pl-2">
                                                                    @foreach ($item->itemable->packageItems as $packageItem)
                                                                        @php
                                                                            $itemName = $packageItem->item->name ?? 'Unnamed Item';
                                                                            $optionsToDisplay = [];
                                                                
                                                                            if (!empty($item->selected_options) && is_array($item->selected_options)) {
                                                                                $itemId = $packageItem->item->id ?? null;
                                                                                $optionsForItem = $itemId && isset($item->selected_options[$itemId])
                                                                                    ? $item->selected_options[$itemId]
                                                                                    : [];
                                                                
                                                                                foreach ($optionsForItem as $option) {
                                                                                    if (!empty($option['type'])) {
                                                                                        $parts = explode(':', $option['type']);
                                                                                        if ($parts[0] !== end($parts) || $parts[0] !== $itemName) {
                                                                                            $optionsToDisplay[] = $option['type'];
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        @endphp
                                                                
                                                                        <li class="text-xs text-gray-600">
                                                                            <div class="flex items-start">
                                                                                <span class="inline-block w-1 h-1 mt-1.5 mr-1.5 bg-gray-400 rounded-full"></span>
                                                                                <div>
                                                                                    <span class="font-medium">{{ $itemName }}</span>
                                                                                    @if (!empty($optionsToDisplay))
                                                                                        <span class="text-gray-500"> - {{ implode(', ', $optionsToDisplay) }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            
                                                            @if (!empty($item->included_utilities))
                                                                <div>
                                                                    <h4 class="text-xs font-medium text-gray-700 mb-1">Included Utilities:</h4>
                                                                    <ul class="space-y-1 pl-2">
                                                                        @foreach ($item->included_utilities as $utility)
                                                                            <li class="text-xs text-gray-600">
                                                                                <div class="flex items-start">
                                                                                    <span class="inline-block w-1 h-1 mt-1.5 mr-1.5 bg-gray-400 rounded-full"></span>
                                                                                    {{ $utility }}
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </details>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Desktop View - Table Layout -->
                        <table class="hidden sm:table min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variant</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->orderItems as $item)
                                    @php
                                        $isPackage = $item->item_type === 'package';
                                        $guestCount = is_numeric($item->variant) ? (int) $item->variant : 1;
                                        $subtotal = $isPackage 
                                            ? $item->price * $guestCount * $item->quantity 
                                            : $item->price * $item->quantity;
                            
                                        $priceBreakdown = $isPackage
                                        ? '₱' . number_format($item->price, 2) . ' × ' . $guestCount . ' guests × ' . $days . ' day' . ($days > 1 ? 's' : '') . ($item->quantity > 1 ? ' × ' . $item->quantity . ' package(s)' : '')
                                        : '₱' . number_format($item->price, 2) . ' × ' . $item->quantity;
                                    @endphp
                        
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @php
                                                    $imagePath = $isPackage 
                                                        ? 'storage/packagepics/' . ($item->itemable->image ?? '') 
                                                        : 'storage/party_traypics/' . ($item->itemable->image ?? '');
                                                @endphp
                                
                                                @if (!empty($item->itemable->image))
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <img src="{{ asset($imagePath) }}" 
                                                             alt="{{ $item->itemable->name }}" 
                                                             class="h-16 w-16 rounded-md object-cover border border-gray-200">
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center rounded-md bg-gray-100 text-gray-400 border border-gray-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->itemable->name ?? 'Unknown' }}</div>
                                                    @if(!$isPackage)
                                                        <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->itemable->description ?? 'No description' }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $isPackage ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $isPackage ? 'Package' : 'Party Tray' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $isPackage ? ($item->variant ? $item->variant . ' guests' : '-') : ($item->variant ? $item->variant . ' per pax' : '-') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="text-gray-900">₱{{ number_format($subtotal, 2) }}</div>
                                            <div class="text-xs text-gray-500">{{ $priceBreakdown }} </div>
                                        </td>
                                    </tr>
                        
                                    @if ($isPackage && method_exists($item->itemable, 'packageItems'))
                                        <tr class="bg-gray-50">
                                            <td colspan="5" class="px-6 py-4">
                                                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-xs">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div>
                                                            <h4 class="text-sm font-medium text-gray-700 mb-2 pb-1 border-b border-gray-100">Included Foods</h4>
                                                            <ul class="space-y-1 pl-2">
                                                                @foreach ($item->itemable->packageItems as $packageItem)
                                                                    @php
                                                                        $itemName = $packageItem->item->name ?? 'Unnamed Item';
                                                                        $optionsToDisplay = [];
                                                            
                                                                        // Process options if there are any selected for the item
                                                                        if (!empty($item->selected_options) && is_array($item->selected_options)) {
                                                                            $itemId = $packageItem->item->id ?? null;
                                                                            $optionsForItem = $itemId && isset($item->selected_options[$itemId])
                                                                                ? $item->selected_options[$itemId]
                                                                                : [];
                                                            
                                                                            foreach ($optionsForItem as $option) {
                                                                                if (!empty($option['type'])) {
                                                                                    // Skip options that are just repeating the item name (like "Rice: Rice")
                                                                                    $parts = explode(':', $option['type']);
                                                                                    if ($parts[0] !== end($parts) || $parts[0] !== $itemName) {
                                                                                        $optionsToDisplay[] = $option['type'];
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                            
                                                                    <li class="text-xs text-gray-600">
                                                                        <div class="flex items-start">
                                                                            <span class="inline-block w-1 h-1 mt-1.5 mr-1.5 bg-gray-400 rounded-full"></span>
                                                                            <div>
                                                                                <span class="font-medium">{{ $itemName }}</span>
                                                                                @if (!empty($optionsToDisplay))
                                                                                    <span class="text-gray-500"> - {{ implode(', ', $optionsToDisplay) }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                
                                                        @if (!empty($item->included_utilities))
                                                            <div>
                                                                <h4 class="text-sm font-medium text-gray-700 mb-2 pb-1 border-b border-gray-100">Included Utilities</h4>
                                                                <ul class="space-y-2">
                                                                    @foreach ($item->included_utilities as $utility)
                                                                        <li class="text-sm text-gray-600">
                                                                            <div class="flex items-start">
                                                                                <span class="inline-block w-1 h-1 mt-2 mr-2 bg-gray-400 rounded-full"></span>
                                                                                {{ $utility }}
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 sm:p-6 border-t">
                        <div class="flex justify-end items-center">
                            <div class="text-base sm:text-lg font-semibold text-gray-800 mr-4">Total:</div>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">₱{{ number_format($order->total, 2) }}</div>
                        </div>
                    </div>
                </div>
                
                @if (!in_array($order->status, ['partial', 'ongoing', 'paid', 'completed', 'cancelled']))
                    <div class="flex justify-center mt-6">
                        <form id="cancelForm" action="{{ route('orderUser.cancel', ['order' => $order->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="button" onclick="confirmCancel()"
                                class="px-4 py-2 text-white font-semibold rounded-lg bg-red-500 hover:bg-red-600 transition-colors">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
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
