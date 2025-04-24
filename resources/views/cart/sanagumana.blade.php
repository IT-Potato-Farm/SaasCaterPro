{{-- CART PAGE --}}
<script src="{{ asset('js/partyTrayCart.js') }}"></script>
<script>
    function debugAddToCart(itemId) {
        // Check if a variant dropdown exists for the menu item
        let variantSelect = document.getElementById('variant-' + itemId);
        let selectedVariant = variantSelect ? variantSelect.value : null;
        console.log("DEBUG: Selected variant for menu item", itemId, "is", selectedVariant);
        // Call the addToCart function (defaults to 'menu_item')
        addToCart(itemId, 'menu_item');
    }
</script>

@php
    // Determine if the cart is from a guest (array) or a logged-in user (object)
    $isGuest = !is_object($cart);

    // Build packagesMinPax array (if needed)
    $packagesMinPax = [];
    if (!$isGuest) {
        foreach ($cart->items as $item) {
            if ($item->package_id && $item->package) {
                $packagesMinPax[] = [
                    'name' => $item->package->name,
                    'min_pax' => $item->package->min_pax,
                ];
            }
        }
    } else {
        foreach ($cart['items'] as $item) {
            if (isset($item['package_id'])) {
                $package = \App\Models\Package::find($item['package_id']);
                if ($package) {
                    $packagesMinPax[] = [
                        'name' => $package->name,
                        'min_pax' => $package->min_pax,
                    ];
                }
            }
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body>

    <x-customer.navbar />

    <div class="container mx-auto py-8 px-4">
        @if (isset($pendingOrder))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div>
                        <span class="font-medium">Alert!</span> You already have a pending order (Order
                        #{{ $pendingOrder->id }}).
                        Please review or complete that order before placing a new one.
                    </div>
                </div>
            </div>
        @endif

        {{-- Check if the cart is empty --}}
        @if ($cartItems->isEmpty())
            <!-- Empty Cart Message -->
            <div class="flex flex-col items-center justify-center min-h-screen gap-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-500" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H5" />
                </svg>
                <h1 class="text-xl font-semibold text-gray-700">Your Cart is currently empty</h1>
                <a class="px-5 py-2 text-white bg-lime-500 rounded-md shadow hover:bg-lime-600 transition"
                    href="{{ route('all-menu') }}">Browse Menus</a>
            </div>
        @else
            <h1 class="text-3xl font-bold mb-6 text-center">Your Carttt</h1>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Cart Items Table -->
                <div class="md:w-3/4">
                    <div class="bg-white shadow-md rounded p-4">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2 text-left">Product</th>
                                    <th class="py-2 text-left">Name</th>
                                    <th class="py-2 text-left">Selected Options</th>
                                    <th class="py-2 text-center">Quantity</th>
                                    <th class="py-2 text-left">Price</th>
                                    <th class="py-2 text-left">Pax</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                @php $extendedTotal = 0; @endphp
                                @foreach ($cartItems as $cartItem)
                                    {{-- @dd($cartItem); --}}
                                    @php
                                        // Ensure proper handling for both guest and logged-in carts
                                        $menu_item_id = is_array($cartItem)
                                            ? $cartItem['menu_item_id'] ?? null
                                            : $cartItem->menu_item_id;
                                        $package_id = is_array($cartItem)
                                            ? $cartItem['package_id'] ?? null
                                            : $cartItem->package_id;
                                        $quantity = is_array($cartItem)
                                            ? $cartItem['quantity'] ?? 0
                                            : $cartItem->quantity;
                                        $variant = is_array($cartItem)
                                            ? $cartItem['variant'] ?? null
                                            : $cartItem->variant;
                                        $selectedOptionsString = '';

                                        if (
                                            (is_object($cartItem) &&
                                                isset(
                                                    $cartItem->package_id,
                                                    $cartItem->package,
                                                    $cartItem->selected_options,
                                                )) ||
                                            (is_array($cartItem) &&
                                                isset($cartItem['package_id'], $cartItem['selected_options']))
                                        ) {
                                            $itemNames = [];

                                            // Handle package items mapping for object and array structure
                                            if (is_object($cartItem) && !empty($cartItem->package->packageItems)) {
                                                foreach ($cartItem->package->packageItems as $packageItem) {
                                                    $itemNames[$packageItem->id] = $packageItem->name;
                                                }
                                            } elseif (is_array($cartItem) && isset($cartItem['package_id'])) {
                                                $package = \App\Models\Package::find($cartItem['package_id']);
                                                if ($package && !empty($package->packageItems)) {
                                                    foreach ($package->packageItems as $packageItem) {
                                                        $itemNames[$packageItem->id] = $packageItem->name;
                                                    }
                                                }
                                            }

                                            // Process selected options
                                            $selectedOptions = is_object($cartItem)
                                                ? $cartItem->selected_options
                                                : $cartItem['selected_options'];

                                            foreach ($selectedOptions as $itemId => $optionArray) {
                                                if (isset($itemNames[$itemId]) && is_array($optionArray)) {
                                                    $types = array_map(
                                                        fn($option) => $option['type'] ?? 'Unknown',
                                                        $optionArray,
                                                    );
                                                    $selectedOptionsString .=
                                                        "{$itemNames[$itemId]}: " . implode(', ', $types) . '<br>';
                                                }
                                            }
                                        }

                                        // If no options exist, show 'N/A'
                                        $selectedOptionsString = $selectedOptionsString ?: 'N/A';
                                        $itemImage = null;
                                        // Fetch name and price based on type (menu item or package)
                                        if ($menu_item_id) {
                                            $menuItem = $menuItems->firstWhere('id', $menu_item_id);
                                            $itemName = $menuItem ? $menuItem->name : 'Unknown Menu Item';
                                            $itemPrice = $menuItem ? $menuItem->price : 0;
                                            $itemImage = $menuItem ? $menuItem->image : null;
                                            $displayPrice = $itemPrice;
                                            $minPax = 'N/A';
                                        } elseif ($package_id) {
                                            $package = $packages->firstWhere('id', $package_id);
                                            $itemName = $package ? $package->name : 'Unknown Package';
                                            $itemPrice = $package ? $package->price_per_person : 0;
                                            $itemImage = $package ? $package->image : null;
                                            $displayPrice = $itemPrice;
                                            $minPax = $package ? $package->min_pax : 'N/A';
                                        } else {
                                            $itemName = 'Unknown';
                                            $itemPrice = 0;
                                            $displayPrice = 0;
                                            $minPax = 'N/A';
                                        }

                                        $lineTotal = $itemPrice * $quantity;
                                        $extendedTotal += $lineTotal;
                                        if (is_array($cartItem)) {
                                            $cartItemId =
                                                $cartItem['menu_item_id'] ?? ($cartItem['package_id'] ?? null);
                                        } else {
                                            $cartItemId = $cartItem->menu_item_id ?? ($cartItem->package_id ?? null);
                                        }
                                    @endphp

                                    <tr class="border-b">
                                        <td class="py-3">
                                            @if ($menu_item_id && $itemImage)
                                                <img src="{{ asset('ItemsStored/' . $itemImage) }}"
                                                    alt="{{ $itemName }}" class="w-16 h-16 object-cover rounded" />
                                            @elseif ($package_id && $itemImage)
                                                <img src="{{ asset('packagepics/' . $itemImage) }}"
                                                    alt="{{ $itemName }}" class="w-16 h-16 object-cover rounded" />
                                            @else
                                                <img src="https://via.placeholder.com/64" alt="No Image"
                                                    class="w-16 h-16 object-cover rounded" />
                                            @endif
                                        </td>

                                        <td class="py-3">{{ $itemName }}</td>
                                        <td class="py-3">{!! $selectedOptionsString !!}</td>
                                        <td class="py-3 text-center align-middle">
                                            <div class="flex flex-col items-center space-y-2">

                                                <form action="{{ route('cart.item.update', ['id' => $cartItemId]) }}"
                                                    method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrement"
                                                        class="px-2 border border-gray-300 rounded-l">-</button>
                                                    <input type="text" name="quantity"
                                                        value="{{ is_array($cartItem) ? $cartItem['quantity'] : $cartItem->quantity }}"
                                                        class="w-12 text-center border-t border-b border-gray-300"
                                                        readonly />
                                                    <button type="submit" name="action" value="increment"
                                                        class="px-2 border border-gray-300 rounded-r">+</button>
                                                </form>

                                                <form action="{{ route('cart.item.destroy', $cartItemId) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 underline">Remove</button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="py-3">₱{{ number_format($displayPrice, 2) }}</td>
                                        <td class="py-3">{{ $minPax }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary Section -->
                <aside class="md:w-1/4">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Order Summary</h2>
                        <div class="mb-4 p-3 bg-gray-50 rounded border-l-4 border-yellow-400">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">Total Price:</span>
                                <span id="order-summary-total"
                                    class="font-bold text-gray-900">₱{{ number_format($extendedTotal, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.show') }}"
                            class="w-full inline-block bg-green-600 hover:bg-green-700 text-white py-2 rounded-md text-center">
                            Proceed to Checkout
                        </a>
                    </div>
                </aside>
            </div>
        @endif
    </div>

    {{-- <x-allmenu.menusection /> --}}

    <script>
        // Periodically fetch cart updates (optional)
        function fetchCartUpdates() {
            $.ajax({

                url: "{{ route('cart.index2') }}",
                type: "GET",
                cache: false, // Prevent caching

                success: function(response) {
                    console.log("Cart updated:", response);
                    var updatedCartItems = $(response).find('#cart-items').html();
                    var updatedTotal = $(response).find('#order-summary-total').html();
                    if (updatedCartItems) {
                        $('#cart-items').html(updatedCartItems);
                    }
                    if (updatedTotal) {
                        $('#order-summary-total').html(updatedTotal);
                    }
                },
                error: function(xhr) {
                    console.error("Error updating cart:", xhr.responseText);
                }
            });
        }
        setInterval(fetchCartUpdates, 5000);
    </script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
</body>

</html>
