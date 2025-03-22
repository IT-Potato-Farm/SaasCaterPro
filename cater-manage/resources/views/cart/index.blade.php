{{-- CART PAGE --}}
<script src="{{ asset('js/cart.js') }}"></script>
<script>
    function debugAddToCart(itemId) {
        // Check if a variant dropdown exists for the menu item
        let variantSelect = document.getElementById('variant-' + itemId);
        let selectedVariant = variantSelect ? variantSelect.value : null;

        // Debug log to console
        console.log("DEBUG: Selected variant for menu item", itemId, "is", selectedVariant);

        // Call the existing addToCart function
        // If you need to pass the type, it defaults to 'menu_item'
        addToCart(itemId, 'menu_item');
    }
</script>

@php
    // array of packages from the cart with their names and min_pax.
    $packagesMinPax = [];
    foreach ($cart->items as $item) {
        if ($item->package_id && $item->package) {
            $packagesMinPax[] = [
                'name' => $item->package->name,
                'min_pax' => $item->package->min_pax,
            ];
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
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Alert!</span> You already have a pending order (Order
                        #{{ $pendingOrder->id }}). Please review or complete that order before placing a new one.
                    </div>
                </div>
            </div>
        @endif
        @if ($cart->items->isEmpty())
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
            <h1 class="text-3xl font-bold mb-6 text-center">Your Cart</h1>
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Section: Cart Items Table -->
                <div class="md:w-3/4">
                    <div class="bg-white shadow-md rounded p-4">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b">
                                    {{-- checkbox --}}
                                    {{-- <th class="py-2 text-left w-12">
                                        <input type="checkbox" />
                                    </th> --}}
                                    <th class="py-2 text-left">Product</th>
                                    <th class="py-2 text-left">Name</th>
                                    <th class="py-2 text-left">Selected Options</th>
                                    <th class="py-2 text-center">Quantity</th>
                                    <th class="py-2 text-left">Price</th>
                                    <th class="py-2 text-left"> Pax</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                @php
                                    $extendedTotal = 0; // Extended estimation for order summary
                                @endphp

                                @foreach ($cart->items as $cartItem)
                                    @php
                                        if ($cartItem->menu_item_id && $cartItem->menuItem) {
                                            $itemName = $cartItem->menuItem->name;
                                            $itemImage = $cartItem->menuItem->image ?? null;
                                            // For menu items, use the JSON pricing (should be cast as array)
                                            $pricingTiers = $cartItem->menuItem->pricing;

                                            // Clean up the variant (if any)
                                            $selectedVariant = isset($cartItem->variant)
                                                ? trim($cartItem->variant)
                                                : null;

                                            if (!empty($selectedVariant) && isset($pricingTiers[$selectedVariant])) {
                                                // Use the price from the selected variant
                                                $itemPrice = $pricingTiers[$selectedVariant];
                                            } else {
                                                // Fallback: determine the price based on quantity if no valid variant is stored
                                                if ($cartItem->quantity >= 10 && $cartItem->quantity <= 15) {
                                                    $itemPrice = $pricingTiers['10-15'] ?? 0;
                                                } elseif ($cartItem->quantity > 15 && isset($pricingTiers['15-20'])) {
                                                    $itemPrice = $pricingTiers['15-20'];
                                                } else {
                                                    // Fallback: use the first available tier
                                                    $itemPrice = reset($pricingTiers);
                                                }
                                            }
                                            $displayPrice = $itemPrice;
                                            $lineTotal = $itemPrice * $cartItem->quantity;
                                            $minPax = '-'; // Not applicable for menu items
                                        } elseif ($cartItem->package_id && $cartItem->package) {
                                            $itemName = $cartItem->package->name;
                                            $itemImage = $cartItem->package->image ?? null;
                                            $itemPrice = $cartItem->package->price_per_person ?? 0;
                                            $displayPrice = $itemPrice;
                                            // sa packages calculate based on price per person, minimum pax and quantity
                                            $minPax = $cartItem->package->min_pax ?? 1;
                                            $lineTotal = $itemPrice * $minPax * $cartItem->quantity;

                                            $itemNames = [];
                                            if ($cartItem->package && $cartItem->package->packageItems) {
                                                foreach ($cartItem->package->packageItems as $packageItem) {
                                                    $itemNames[$packageItem->id] = $packageItem->name;
                                                }
                                            }
                                            $selectedOptionsString = '';
                                            // Only process if this cart item is a package and has selected_options.
                                            if (
                                                $cartItem->package_id &&
                                                $cartItem->package &&
                                                $cartItem->selected_options &&
                                                is_array($cartItem->selected_options)
                                            ) {
                                                //  mapping of package item IDs to their names.
                                                $itemNames = [];
                                                if ($cartItem->package->packageItems) {
                                                    foreach ($cartItem->package->packageItems as $packageItem) {
                                                        $itemNames[$packageItem->id] = $packageItem->name;
                                                    }
                                                }
                                                // Loop through the selected options for this package.
                                                foreach ($cartItem->selected_options as $itemId => $optionArray) {
                                                    if (isset($itemNames[$itemId])) {
                                                        $types = array_map(function ($option) {
                                                            return $option['type'] ?? 'Unknown';
                                                        }, $optionArray);
                                                        $selectedOptionsString .=
                                                            "{$itemNames[$itemId]}: " . implode(', ', $types) . '<br>';
                                                    }
                                                }
                                            }
                                        } else {
                                            $itemName = 'Unknown';
                                            $itemPrice = 0;
                                            $itemImage = null;
                                            $displayPrice = 0;
                                            $lineTotal = 0;
                                            $minPax = '-';
                                        }
                                        $extendedTotal += $lineTotal;
                                    @endphp

                                    <tr class="border-b">
                                        <!-- Checkbox -->
                                        {{-- <td class="py-3">
                                            <input type="checkbox" name="selected_items[]"
                                                value="{{ $cartItem->id }}" />
                                        </td> --}}

                                        <!-- Product Image -->
                                        <td class="py-3">
                                            @if ($itemImage)
                                                <img src="{{ asset(isset($cartItem->menu_item_id) ? 'ItemsStored/' . $itemImage : 'packagePics/' . $itemImage) }}"
                                                    alt="{{ $itemName }}" class="w-16 h-16 object-cover rounded" />
                                            @else
                                                <img src="https://via.placeholder.com/64" alt="No Image"
                                                    class="w-16 h-16 object-cover rounded" />
                                            @endif
                                        </td>

                                        <!-- Item Name -->
                                        <td class="py-3">
                                            {{ $itemName }}
                                        </td>

                                        <!-- Selected Options Column -->
                                        @if ($cartItem->package_id)
                                            <td class="py-3">
                                                {!! $selectedOptionsString ?: 'N/A' !!}
                                            </td>
                                        @else
                                            <td class="py-3"> NOT APPLICABLE</td>
                                        @endif

                                        <!-- Edit Quantity -->
                                        <td class="py-3 text-center align-middle">
                                            <div class="flex flex-col items-center space-y-2">
                                                <form action="{{ route('cart.item.update', $cartItem->id) }}"
                                                    method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" name="action" value="decrement"
                                                        class="px-2 border border-gray-300 rounded-l">-</button>
                                                    <input type="text" name="quantity"
                                                        value="{{ $cartItem->quantity }}"
                                                        class="w-12 text-center border-t border-b border-gray-300"
                                                        readonly />
                                                    <button type="submit" name="action" value="increment"
                                                        class="px-2 border border-gray-300 rounded-r">+</button>
                                                </form>
                                                <form action="{{ route('cart.item.destroy', $cartItem->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 underline">Remove</button>
                                                </form>
                                            </div>
                                        </td>

                                        <!-- Price -->
                                        <td class="py-3">
                                            @if ($cartItem->package_id)
                                                ₱{{ number_format($displayPrice, 2) }} <small>(per pax)</small>
                                            @else
                                                ₱{{ number_format($displayPrice, 2) }}
                                                {{-- @if (!empty($selectedVariant))
                                                    <small>({{ $selectedVariant }})</small>
                                                @endif --}}
                                            @endif
                                        </td>

                                        <!-- Min pax (Only for packages) -->
                                        <td class="py-3">
                                            @if ($cartItem->menu_item_id)
                                                {{ !empty($selectedVariant) ? $selectedVariant : 'N/A' }} pax
                                            @else
                                                {{ $minPax }} minimum pax
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Order Summary -->
                <div class="md:w-1/4">
                    <div class="bg-white shadow-md rounded p-4">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        <form action="{{ route('checkout.show') }}" method="GET">
                            <div class="mb-4">
                                <label for="total_guests" class="block text-sm font-medium text-gray-700 mb-1">
                                    Total Guests
                                    <span class="text-xs text-gray-500 block mt-1">
                                        Including additional guests. Help us prepare the right quantity of food for your
                                        event.
                                    </span>
                                </label>
                                <input type="number" id="total_guests" name="total_guests" min="1"
                                    placeholder="50"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-lime-500 focus:border-lime-500  "
                                    required>

                                <!-- Minimum pax notification -->
                                <p id="minPaxNotification" class="text-xs text-blue-600 hidden"></p>
                                <p id="errorminPaxNotification" class="text-xs text-red-500 hidden">Please fill in the
                                    total guests field.</p>
                            </div>
                            {{-- <p class="mb-2">
                                <span class="font-semibold">Selected Items:</span>
                                <span id="selectedItemsCount">0</span>
                            </p> --}}
                            <p class="mb-2">
                                <span class="font-semibold">Total Price:</span>
                                <span id="order-summary-total"> ₱{{ number_format($extendedTotal, 2) }}</span>
                            </p>
                            <!-- Checkout Button -->
                            <button type="submit"
                                title="{{ isset($pendingOrder) ? 'You already have a pending order. Complete that order first.' : 'Proceed to Checkout' }}"
                                class="mt-4 w-full bg-green-600 text-white py-2 rounded transition text-center inline-block
                                       {{ isset($pendingOrder) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-700 hover:cursor-pointer' }}"
                                @if (isset($pendingOrder)) disabled @endif>
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endif
    </div>

    {{-- ITEMS HERE --}}
    {{-- <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Add More Items</h2>

        <!-- Menu Items -->
        @if ($menuItems->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Menu Items</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($menuItems as $menuItem)
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                            @if ($menuItem->image)
                                <img src="{{ asset('ItemsStored/' . $menuItem->image) }}"
                                    alt="{{ $menuItem->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                            @endif
                            <h4 class="font-medium text-lg">{{ $menuItem->name }}</h4>
                            <p class="text-gray-600 text-sm mb-2">{{ $menuItem->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lime-600 font-medium">
                                    ₱{{ number_format($menuItem->pricing[array_key_first($menuItem->pricing)], 2) }}
                                </span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">
                                    <button type="submit"
                                        class="bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-lime-600 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Packages -->
        @if ($packages->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Packages</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($packages as $package)
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                            @if ($package->image)
                                <img src="{{ asset('packagePics/' . $package->image) }}" alt="{{ $package->name }}"
                                    class="w-full h-48 object-cover rounded-lg mb-4">
                            @endif
                            <h4 class="font-medium text-lg">{{ $package->name }}</h4>
                            <p class="text-gray-600 text-sm mb-2">{{ $package->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lime-600 font-medium">
                                    ₱{{ number_format($package->price_per_person, 2) }}/person
                                </span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <button type="submit"
                                        class="bg-lime-500 text-white px-4 py-2 rounded-md hover:bg-lime-600 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div> --}}
    {{-- COMPONENT NG LAHAT NG ITEMS SA BABA NG CART PART --}}
    <x-allmenu.menusection />
    <script>
        // Convert PHP packagesMinPax array to a JavaScript variable.
        let packagesMinPax = @json($packagesMinPax);
        const totalGuestsInput = document.getElementById('total_guests');
        const minPaxNotification = document.getElementById('minPaxNotification');

        totalGuestsInput.addEventListener('blur', function() {
            let guestCount = parseInt(totalGuestsInput.value);
            let messages = [];

            packagesMinPax.forEach(pkg => {
                if (guestCount < pkg.min_pax) {
                    messages.push(
                        `For ${pkg.name}, the minimum guest count is ${pkg.min_pax}. Pricing will be based on ${pkg.min_pax} guests.`
                    );
                }
            });

            if (messages.length > 0) {
                minPaxNotification.innerHTML = messages.join('<br>');
                minPaxNotification.classList.remove('hidden');

                Swal.fire({
                    icon: 'info',
                    title: 'Minimum Guest Requirements',
                    html: messages.join('<br>'),
                    timer: 5000,
                    showConfirmButton: false
                });
            } else {
                minPaxNotification.classList.add('hidden');
            }

        });

        function fetchCartUpdates() {
            $.ajax({
                url: "{{ route('cart.index') }}",
                type: "GET",
                success: function(response) {
                    // Extract updated cart items and order total from the returned HTML
                    var updatedCartItems = $(response).find('#cart-items').html();
                    var updatedTotal = $(response).find('#order-summary-total').html();
                    // Update the current page only if the new content is found
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

        // Call the function every 1 seconds (1000 ms)
        setInterval(fetchCartUpdates, 1000);
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


</body>

</html>
