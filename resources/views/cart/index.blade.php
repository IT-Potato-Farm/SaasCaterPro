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
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- CART PAGE --}}
    <script src="{{ asset('js/partyTrayCart.js') }}"></script>
    <style>
        @media (max-width: 768px) {
            /* Force table to not be like tables anymore */
            .responsive-table table, 
            .responsive-table thead, 
            .responsive-table tbody, 
            .responsive-table th, 
            .responsive-table td, 
            .responsive-table tr { 
                display: block; 
            }
            
            /* Hide table headers (but not display: none;, for accessibility) */
            .responsive-table thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            .responsive-table tr {
                border: 1px solid #e5e7eb;
                margin-bottom: 1rem;
            }
            
            .responsive-table td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                white-space: normal;
                text-align:left;
            }
            
            .responsive-table td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 0.75rem;
                left: 1rem;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }
            
            /* Label the data */
            .responsive-table td:nth-of-type(1):before { content: "Product"; }
            .responsive-table td:nth-of-type(2):before { content: "Name"; }
            .responsive-table td:nth-of-type(3):before { content: "Selected Options"; }
            .responsive-table td:nth-of-type(4):before { content: "Quantity"; }
            .responsive-table td:nth-of-type(5):before { content: "Price"; }
            .responsive-table td:nth-of-type(6):before { content: "Pax"; }
            
            .responsive-table td.py-3 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <x-customer.navbar />

    <div class="container mx-auto py-8 px-4 ">
        {{-- IF MERON PENDING ORDER EXISTING ETO LALABAS --}}
       
        @if (isset($pendingOrder))

            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-500" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            @php
                $cartHasPackage = $cart->items->contains(function ($cartItem) {
                    return !is_null($cartItem->package_id);
                });
            @endphp

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Section: Cart Items Table -->
                <div class="md:w-3/4">
                    <div class="bg-white shadow-md rounded p-4 overflow-x-auto">
                        <div class="responsive-table">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b bg-gray-50">
                                        <th class="py-2 px-3 text-left">Image</th>
                                        <th class="py-2 px-3 text-left">Item</th>
                                        <th class="py-2 px-3 text-left">Configuration</th>
                                        <th class="py-2 px-3 text-center">Quantity</th>
                                        <th class="py-2 px-3 text-right">Price</th>
                                        <th class="py-2 px-3 text-left">Serving Size</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    @php
                                        $extendedTotal = 0;
                                    @endphp
                            
                                    @foreach ($cart->items as $cartItem)
                                        @php
                                            //  menu item or package
                                            $isMenuItem = $cartItem->menu_item_id && $cartItem->menuItem;
                                            $isPackage = $cartItem->package_id && $cartItem->package;
                                            
                                            // Set common variables
                                            $itemName = 'Unknown Item';
                                            $itemImage = null;
                                            $displayPrice = 0;
                                            $lineTotal = 0;
                                            $servingInfo = '-';
                                            $configInfo = 'N/A';
                                            
                                            if ($isMenuItem) {
                                                // Menu Item Logic
                                                $itemName = $cartItem->menuItem->name;
                                                $itemImage = $cartItem->menuItem->image ?? null;
                                                $pricingTiers = $cartItem->menuItem->pricing;
                                                $selectedVariant = isset($cartItem->variant) ? trim($cartItem->variant) : null;
                            
                                                if (!empty($selectedVariant) && isset($pricingTiers[$selectedVariant])) {
                                                    $itemPrice = $pricingTiers[$selectedVariant];
                                                    $servingInfo = $selectedVariant . ' pax';
                                                } else {
                                                    if ($cartItem->quantity >= 10 && $cartItem->quantity <= 15) {
                                                        $itemPrice = $pricingTiers['10-15'] ?? 0;
                                                        $servingInfo = '10-15 pax';
                                                    } elseif ($cartItem->quantity > 15 && isset($pricingTiers['15-20'])) {
                                                        $itemPrice = $pricingTiers['15-20'];
                                                        $servingInfo = '15-20 pax';
                                                    } else {
                                                        $itemPrice = reset($pricingTiers);
                                                        $servingInfo = key($pricingTiers) . ' pax';
                                                    }
                                                }
                                                
                                                $displayPrice = $itemPrice;
                                                $lineTotal = $itemPrice * $cartItem->quantity;
                                                $configInfo = 'Standard Party Tray';
                                                
                                            } elseif ($isPackage) {
                                                // Package Logic
                                                $itemName = $cartItem->package->name;
                                                $itemImage = $cartItem->package->image ?? null;
                                                $itemPrice = $cartItem->package->price_per_person ?? 0;
                                                $displayPrice = $itemPrice;
                                                $minPax = $cartItem->package->min_pax ?? 1;
                                                $lineTotal = $itemPrice * $minPax * $cartItem->quantity;
                                                $servingInfo = $minPax . ' min. pax';
                            
                                                // Build package configuration info from selected options
                                                $packageItemNames = [];
                                                if ($cartItem->package && $cartItem->package->packageItems) {
                                                    foreach ($cartItem->package->packageItems as $packageItem) {
                                                        $packageItemNames[$packageItem->item->id] = $packageItem->item->name ?? 'Unnamed Item';
                                                    }
                                                }
                                                
                                                $selectedOptionsString = '';
                                                if ($cartItem->selected_options && is_array($cartItem->selected_options)) {
                                                    foreach ($cartItem->selected_options as $itemId => $optionArray) {
                                                        if (isset($packageItemNames[$itemId])) {
                                                            $packageItemName = $packageItemNames[$itemId];
                                                            
                                                            // Check if it's a food item without options (only one option that matches the food name)
                                                            if (count($optionArray) === 1 && ($optionArray[0]['type'] === $packageItemName)) {
                                                                // Just show the item name once
                                                                $selectedOptionsString .= "{$packageItemName}<br>";
                                                            } else {
                                                                // For items with options, show item name and option types
                                                                $types = array_map(function ($option) {
                                                                    return $option['type'] ?? 'Unknown';
                                                                }, $optionArray);
                                                                $selectedOptionsString .= "{$packageItemName}: " . implode(', ', $types) . '<br>';
                                                            }
                                                        }
                                                    }
                                                }
                                                $configInfo = $selectedOptionsString ?: 'Default Package Selections';
                                            }
                                            
                                            $extendedTotal += $lineTotal;
                                        @endphp
                            
                                        <tr class="border-b hover:bg-gray-50">
                                            <!-- Product Image -->
                                            <td class="py-3 px-3">
                                                @if ($itemImage)
                                                    <img src="{{ asset($isMenuItem ? 'storage/party_traypics/' . $itemImage : 'storage/packagepics/' . $itemImage) }}"
                                                        alt="{{ $itemName }}" class="w-16 h-16 object-cover rounded shadow-sm" />
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-400 text-xs">No Image</span>
                                                    </div>
                                                @endif
                                            </td>
                            
                                            <!-- Item Name -->
                                            <td class="py-3 px-3">
                                                <div class="font-medium">{{ $itemName }}</div>
                                                <div class="text-xs text-gray-500">{{ $isMenuItem ? 'Party Tray' : 'Package' }}</div>
                                            </td>
                            
                                            <!-- Configuration Info -->
                                            <td class="py-3 px-3">
                                                <div class="text-sm">
                                                    @if ($isPackage)
                                                        {!! $configInfo !!}
                                                    @else
                                                        <span class="text-gray-500 italic">{{ $configInfo }}</span>
                                                    @endif
                                                </div>
                                            </td>
                            
                                            <!-- Quantity Controls -->
                                            <td class="py-3 px-3 text-center align-middle">
                                                <div class="flex flex-col items-center space-y-2">
                                                    <form action="{{ route('cart.item.update', $cartItem->id) }}" method="POST" class="flex items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" name="action" value="decrement"
                                                            class="px-2 border border-gray-300 rounded-l hover:bg-gray-100">-</button>
                                                        <input type="text" name="quantity" value="{{ $cartItem->quantity }}"
                                                            class="w-12 text-center border-t border-b border-gray-300" readonly />
                                                        <button type="submit" name="action" value="increment"
                                                            class="px-2 border border-gray-300 rounded-r hover:bg-gray-100">+</button>
                                                    </form>
                            
                                                    <form action="{{ route('cart.item.destroy', $cartItem->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Remove</button>
                                                    </form>
                                                </div>
                                            </td>
                            
                                            <!-- Price -->
                                            <td class="py-3 px-3 text-right">
                                                <div class="font-medium">₱{{ number_format($displayPrice, 2) }}</div>
                                                @if ($isPackage)
                                                    <div class="text-xs text-gray-500">per person</div>
                                                @endif
                                            </td>
                            
                                            <!-- Serving Size -->
                                            <td class="py-3 px-3">
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                                                    {{ $servingInfo }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if (isset($pendingOrder))
                    <aside class="md:w-1/4">
                        <div
                            class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-6 rounded-xl shadow-sm border border-gray-200">
                            <h2 class="text-lg font-semibold mb-2">Notice</h2>
                            <p>You already have a pending order <strong>(Order
                                    #{{ $pendingOrder->id }})</strong>. Please complete or cancel it before making a
                                new
                                booking.</p>
                        </div>
                    </aside>
                @elseif (!$cartHasPackage)
                    <aside class="md:w-1/4">
                        <div
                            class="bg-amber-50 border-l-4 border-amber-400 text-amber-800 p-6 rounded-xl shadow-sm border border-gray-200">
                            <h2 class="text-lg font-semibold mb-2">Package Required</h2>
                            <p>You need to add at least one package to your cart to proceed with checkout. Menu items
                                alone cannot be checked out.</p>
                            <div class="mt-4">
                                <a href="{{ route('all-menu') }}"
                                    class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Browse Packages
                                </a>
                            </div>
                        </div>
                    </aside>
                @else
                    <aside class="md:w-1/4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-xl font-bold text-gray-800">Ready to Checkout?</h2>
                            </div>

                            <form id="checkoutForm" action="{{ route('checkout.show') }}" method="GET"
                                class="p-6">
                                <!-- total guest -->
                                <div class="mb-6">
                                    <!-- Event Date -->
                                    <div class="space-y-2">
                                        <label for="event_date"
                                            class="block text-sm font-semibold text-gray-700 mb-2">
                                            See the available dates here
                                        </label>
                                        <span id="eventDateError" class="text-sm text-red-600 hidden">Please select a
                                            date.</span>

                                        <!-- Note: input type changed to text for proper Flatpickr integration -->
                                        <input type="text" name="event_date" id="event_date"
                                            placeholder="Select a date or date range"
                                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            required>
                                    </div>

                                    {{-- IF PACKAGE UNG ITEM SAKA LNG TO MAGS-SHOW UP --}}
                                    @if (
                                        $cartItems->contains(function ($cartItem) {
                                            return !is_null($cartItem->package_id); // Check if the package_id is not null
                                        }))
                                        <label for="total_guests"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Total Guests
                                            <span class="text-xs font-normal text-gray-500 block mt-1">
                                                Including additional guests. Help us prepare the right quantity of food
                                                for your event.
                                            </span>
                                        </label>
                                        <input type="number" id="total_guests" name="total_guests" min="1"
                                            placeholder="50"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-all duration-150"
                                            required>

                                        <p id="minPaxNotification" class="mt-1 text-xs text-red-600 hidden"></p>
                                        <p id="errorminPaxNotification" class="mt-1 text-xs text-red-500 hidden">
                                            Please fill in the total guests field.
                                        </p>
                                    @endif
                                </div>

                                <!-- rules -->
                                <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-yellow-500 mt-0.5 mr-3 flex-shrink-0"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-800 mb-1">Important Rules &
                                                Penalties</h3>
                                            <ul class="text-xs text-gray-600 space-y-1">
                                                <li class="flex items-start">
                                                    <span class="inline-block mr-1.5">•</span>
                                                    You are responsible for any damages to rented equipment
                                                </li>
                                                <li class="flex items-start">
                                                    <span class="inline-block mr-1.5">•</span>
                                                    Additional charges apply for replacements or repairs
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- agreement chckbxc-->
                                <div class="mb-6">
                                    <div class="flex items-start">
                                        <input type="checkbox" id="agreeRules"
                                            class="mt-0.5 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <label for="agreeRules" class="ml-2 block text-sm text-gray-700">
                                            I acknowledge and agree to the terms above
                                        </label>
                                    </div>
                                </div>

                                <!-- Total Price -->
                                <div class="mb-6 p-4 md:p-3 lg:p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700">Total Price:</span>
                                        <span id="order-summary-total"
                                              class="font-bold text-gray-900 text-lg md:text-base lg:text-lg">
                                              ₱{{ number_format($extendedTotal, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Checkout Button -->
                                <button type="submit" id="checkoutButton"
                                    title="{{ isset($pendingOrder) ? 'You already have a pending order. Complete that order first.' : 'Proceed to Checkout' }}"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium inline-flex items-center justify-center transition-all duration-200
                            {{ isset($pendingOrder) || !$cartHasPackage ? 'opacity-70 cursor-not-allowed' : 'hover:shadow-md focus:ring-2 focus:ring-green-500 focus:ring-offset-2' }}"
                                    @if (isset($pendingOrder)) || !$cartHasPackage disabled @endif>
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </aside>
                @endif
            </div>
        @endif
    </div>

    {{-- COMPONENT NG LAHAT NG ITEMS SA BABA NG CART PART --}}
    <x-allmenu.menusection />

    {{-- CART INDEX JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all forms on the page
            const form = document.getElementById('checkoutForm');
            // Add submit event listener to each form
            if (form) {
                form.addEventListener('submit', function(event) {
                    const eventDate = document.getElementById('event_date').value.trim();

                    if (!eventDate) {
                        event.preventDefault(); // Prevent form submission
                        document.getElementById('eventDateError').classList.remove('hidden');
                        document.getElementById('event_date').scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        document.getElementById('event_date').focus();

                        //highlight the error
                        document.getElementById('event_date').classList.add('border-red-500');

                        return false;
                    } else {
                        document.getElementById('eventDateError').classList.add('hidden');
                        document.getElementById('event_date').classList.remove('border-red-500');
                    }
                });
            }

            // Fetch booked dates and initialize flatpickr
            fetch('/get-booked-dates')
                .then(response => response.json())
                .then(data => {
                    let disabledDates = data.map(range => range.start);

                    const picker = flatpickr("#event_date", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disable: disabledDates,
                        onChange: function(selectedDates, dateStr) {
                            // Clear error when a date is selected
                            if (dateStr) {
                                document.getElementById('eventDateError').classList.add('hidden');
                                document.getElementById('event_date').classList.remove(
                                    'border-red-500');
                            }
                        }
                    });

                    // Focus + open Flatpickr when label is clicked
                    document.querySelector('label[for="event_date"]').addEventListener('click', function() {
                        document.getElementById('event_date').focus();
                        picker.open();
                    });
                })
                .catch(error => console.error('Error fetching booked dates:', error));
        });

        // checkbox in order summary rules
        document.addEventListener('DOMContentLoaded', function() {
            const agreeCheckbox = document.getElementById('agreeRules');
            const checkoutButton = document.getElementById('checkoutButton');

            // button is disabled on load
            checkoutButton.disabled = true;
            checkoutButton.classList.add("opacity-50", "cursor-not-allowed");

            agreeCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    checkoutButton.disabled = false;
                    checkoutButton.classList.remove("opacity-50", "cursor-not-allowed");
                } else {
                    checkoutButton.disabled = true;
                    checkoutButton.classList.add("opacity-50", "cursor-not-allowed");
                }
            });
        });
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