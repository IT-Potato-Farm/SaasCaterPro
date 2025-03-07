<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>
<body>
    <x-customer.navbar />
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Your Cart</h1>
    
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Left Section: Cart Items -->
            <div class="md:w-3/4">
                <div class="bg-white shadow-md rounded p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left w-12">
                                    <input type="checkbox" />
                                </th>
                                <th class="py-2 text-left">Product</th>
                                <th class="py-2 text-left">Name</th>
                                <th class="py-2 text-left">Quantity</th>
                                <th class="py-2 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
    
                            @foreach($cart->items as $cartItem)
                                @php
                                    // Determine if this cart item references a menu item or a package
                                    $itemName = '';
                                    $itemPrice = 0;
                                    $itemImage = null;
    
                                    if ($cartItem->menu_item_id && $cartItem->menuItem) {
                                        $itemName  = $cartItem->menuItem->name;
                                        $itemPrice = $cartItem->menuItem->price ?? 0;
                                        $itemImage = $cartItem->menuItem->image ?? null;
                                    } elseif ($cartItem->package_id && $cartItem->package) {
                                        $itemName  = $cartItem->package->name;
                                        $itemPrice = $cartItem->package->price_per_person ?? 0;
                                        $itemImage = $cartItem->package->image ?? null;
                                    }
    
                                    $lineTotal = $itemPrice * $cartItem->quantity;
                                    $totalPrice += $lineTotal;
                                @endphp
    
                                <tr class="border-b">
                                    <!-- Checkbox -->
                                    <td class="py-3">
                                        <input type="checkbox" name="selected_items[]" value="{{ $cartItem->id }}" />
                                    </td>
    
                                    <!-- Product Image (optional) -->
                                    <td class="py-3">
                                        @if($itemImage)
                                        <img src="{{ asset(isset($cartItem->menu_item_id) ? 'ItemsStored/' . $itemImage : 'packagePics/' . $itemImage) }}" 
                                                 alt="{{ $itemName }}" 
                                                 class="w-16 h-16 object-cover rounded" />
                                        @else
                                            <img src="https://via.placeholder.com/64" 
                                                 alt="No Image" 
                                                 class="w-16 h-16 object-cover rounded" />
                                        @endif
                                    </td>
    
                                    <!-- Item Name -->
                                    <td class="py-3">
                                        {{ $itemName }}
                                    </td>
    
                                    <!-- Quantity with +/- Buttons -->
                                    <td class="py-3">
                                        <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrement" class="px-2 border border-gray-300 rounded-l">
                                                -
                                            </button>
                                            <input type="text" 
                                                   name="quantity" 
                                                   value="{{ $cartItem->quantity }}" 
                                                   class="w-12 text-center border-t border-b border-gray-300" />
                                            <button type="submit" name="action" value="increment" class="px-2 border border-gray-300 rounded-r">
                                                +
                                            </button>
                                        </form>
                                    </td>
    
                                    <!--  Total -->
                                    <td class="py-3">
                                        ₱{{ number_format($lineTotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    
            <!-- Right Section: Order Summary -->
            <div class="md:w-1/4">
                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
    
                    <!-- For demonstration, this just shows the total of all items in the cart -->
                    <p class="mb-2">
                        <span class="font-semibold">Selected Items:</span> 
                        <!-- This could be dynamic if you track which checkboxes are selected. -->
                        <span id="selectedItemsCount">0</span>
                    </p>
    
                    <p class="mb-2">
                        <span class="font-semibold">Total Price:</span> 
                        ₱{{ number_format($totalPrice, 2) }}
                    </p>
    
                    <!-- Checkout button -->
                    <button class="mt-4 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>