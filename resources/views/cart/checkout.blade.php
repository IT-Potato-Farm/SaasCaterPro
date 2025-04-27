<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
    #event_time_slots input[type="radio"]+label {
        padding: 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        width: 100%;
        cursor: pointer;
    }

    #event_time_slots input[type="radio"]:checked+label {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    #time_slot_wrapper,
    #custom_time_wrapper {
        display: grid;
    }

    #time-slot-error:not(.hidden),
    #time-error:not(.hidden) {
        display: block;
    }

    /* Responsive adjustments */
    .container {
        width: 100%;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (min-width: 640px) {
        .container {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        
        .lg\:flex-row {
            flex-direction: row;
        }
        
        .lg\:w-3\/5 {
            width: 60%;
        }
        
        .lg\:w-2\/5 {
            width: 40%;
        }
    }

    @media (min-width: 1280px) {
        .xl\:w-2\/3 {
            width: 66.666667%;
        }
        
        .xl\:w-1\/3 {
            width: 33.333333%;
        }
        
        .xl\:gap-12 {
            gap: 3rem;
        }
    }

    /* Form input responsiveness */
    input, select, textarea {
        width: 100%;
    }

    /* Time slots grid adjustment */
    @media (max-width: 767px) {
        #event_time_slots {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 768px) {
        #event_time_slots {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
    }

    /* Order summary scrollable area */
    .max-h-96 {
        max-height: 24rem;
    }

    /* Button responsiveness */
    #checkout_form button[type="submit"] {
        padding: 1rem 1.5rem;
    }

    /* Breadcrumb adjustments */
    nav.breadcrumb ol {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    /* Map container */
    .h-64 {
        height: 16rem;
    }

    /* Select2 responsive */
    .select2-container {
        width: 100% !important;
    }

    /* Event information card padding */
    @media (max-width: 639px) {
        .bg-white.rounded-xl.shadow-lg {
            padding: 1.5rem;
        }
    }

    /* Grid adjustments for smaller screens */
    @media (max-width: 767px) {
        .grid-cols-1.md\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .gap-6 {
            gap: 1rem;
        }
    }

    /* Text size adjustments */
    @media (max-width: 639px) {
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        
        .text-lg {
            font-size: 1rem;
            line-height: 1.5rem;
        }
    }
</style>
</head>

<body class="bg-gray-50">
    <x-customer.navbar />

    <div class="container mx-auto px-4 py-8  lg:py-12 max-w-7xl">
        <!-- breadcrumbs -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 hover:underline">
                        Cart
                    </a>
                </li>
                <li>
                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </li>
                <li aria-current="page">
                    <span class="text-gray-700 font-medium">Checkout</span>
                </li>
            </ol>
        </nav>
        {{-- NOTIFICATION  --}}
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

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
            <!-- booking form  -->
            <div class="lg:w-3/5 xl:w-2/3">
                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">Event Information</h2>
                    <form id="checkout_form" action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <!-- Event Details Section -->
                        <div class="space-y-8">
                            <div class="grid grid-cols-1  gap-6">
                                <!-- Event Type -->
                                <div class="space-y-2">
                                    <label for="event_type_select"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Event Type
                                    </label>
                                    <select name="event_type" id="event_type_select"
                                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                        <option value="" disabled selected>Select an event type</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Corporate">Corporate</option>
                                        <option value="Simple Celebration">Simple Celebration</option>
                                        <option value="Other">Others: (Specify)</option>
                                    </select>
                                </div>


                            </div>

                            <!--  OTHER EVENT TYPE  -->
                            <div class="space-y-2" id="custom_event_type_container" style="display: none;">
                                <label for="custom_event_type" class="block text-sm font-medium text-gray-700">Custom
                                    Event Type</label>
                                <input type="text" name="custom_event_type" id="custom_event_type"
                                    placeholder="Enter custom event type"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            {{-- TIME SELECTION --}}
                            <!-- TIME START AND END -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <!-- Default Time Slot View -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Available Time Slots
                                        </label>
                                        <div id="event_time_slots" class="space-y-2">
                                            @if (empty($timeSlots) || !is_array($timeSlots))
                                                <p class="text-gray-500">No available time slots.</p>
                                            @else
                                                @foreach ($timeSlots as $index => $slot)
                                                    @if (!isset($slot['occupied']) || !$slot['occupied'])
                                                        <div class="flex items-center">
                                                            <input type="radio" name="event_time_slot"
                                                                id="event_time_slot_{{ $index }}"
                                                                value="{{ $slot['start'] }} - {{ $slot['end'] }}"
                                                                class="mr-2 focus:ring-blue-500"
                                                                {{ old('event_time_slot') === $slot['start'] . ' - ' . $slot['end'] ? 'checked' : '' }}>
                                                            <label for="event_time_slot_{{ $index }}"
                                                                class="text-gray-700">
                                                                {{ \Carbon\Carbon::createFromFormat('H:i', $slot['start'])->format('g:iA') }}-{{ \Carbon\Carbon::createFromFormat('H:i', $slot['end'])->format('g:iA') }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <p id="time-slot-error" class="text-red-500 hidden"></p>
                                    </div>

                                    <!-- Request Custom Time Button -->
                                    {{-- <div class="mt-4">
                                        <button type="button" id="request_custom_time"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Request Custom Time
                                        </button>
                                    </div> --}}

                                    <!-- Hidden input to keep track of time mode -->
                                    <input type="hidden" name="time_mode" value="slot" id="time_mode_input">
                                </div>

                                <!-- Custom Time Slots (Initially Hidden) -->
                                {{-- <div class="grid grid-cols-1 gap-6" id="custom_time_wrapper" style="display: none;">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Select Custom Time Slot
                                        </label>
                                        <div id="custom_time_slots" class="space-y-2">
                                            <!-- Time slots will be dynamically inserted here -->
                                        </div>
                                        <p id="time-error" class="text-red-500 hidden"></p>
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" id="back_to_default_slots"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                            </svg>
                                            Back to Default Time Slots
                                        </button>
                                    </div>
                                </div> --}}

                                <p class="text-sm text-gray-500 col-span-1 md:col-span-2">
                                    Service Hours:
                                    {{ \Carbon\Carbon::parse($booking_settings->service_start_time)->format('g:iA') }}-{{ \Carbon\Carbon::parse($booking_settings->service_end_time)->format('g:iA') }}
                                </p>



                                <!-- Custom Time Inputs USING Flatpickr-->
                                {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="custom_time_wrapper"
                                    style="display: none;">
                                    <div class="space-y-2">
                                        <label for="custom_start_time"
                                            class="block text-sm font-semibold text-gray-700 mb-2">
                                            Custom Start Time
                                        </label>
                                        <input type="text" name="custom_start_time" id="custom_start_time"
                                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="custom_end_time"
                                            class="block text-sm font-semibold text-gray-700 mb-2">
                                            Custom End Time
                                        </label>
                                        <input type="text" name="custom_end_time" id="custom_end_time"
                                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>

                                    <p id="time-error" class="text-red-500 hidden"></p>

                                    <p class="text-sm text-gray-500">
                                        Service Hours:
                                        {{ \Carbon\Carbon::parse($booking_settings->service_start_time)->format('g:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($booking_settings->service_end_time)->format('g:i A') }}
                                    </p>
                                </div> --}}



                            </div>
                        </div>

                        <!-- Locatio Section -->
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <label for="barangay" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Barangay
                                </label>
                                <select id="barangay" name="barangay" class="w-full select2" required>
                                    <option value="" disabled selected>Loading barangays...</option>
                                </select>
                            </div>

                            <!-- Area Details Input -->
                            <div class="space-y-2">
                                <label for="area_details" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Area Details
                                </label>
                                <input type="text" id="area_details" name="area_details"
                                    placeholder="e.g., Purok 2, Zone 1"
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    required />
                            </div>


                            {{-- HIDDEN EVENT ADDRESS --}}
                            <input type="hidden" id="event_address" name="event_address" />

                            <!-- concerns and other shits -->
                            <div class="space-y-2">
                                <label for="concerns" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Special Requests
                                </label>
                                <textarea name="concerns" id="concerns" rows="3" placeholder="Any special requirements or notes"
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
                            </div>
                        </div>
                        {{-- naka hide na total guests sana gumana huhu --}}
                        <input type="hidden" name="total_guests" value="{{ $totalGuests }}">
                        <input type="hidden" name="event_date" value="{{ $eventDate }}">

                        <button type="submit" @if (isset($pendingOrder)) disabled @endif
                            class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                            Confirm & Place Order
                        </button>
                    </form>
                </div>
                <div class="mt-4 text-sm text-gray-700">
                    @if (strpos($eventDate, 'to') !== false)
                        <!-- If eventDate is a range -->
                        <?php
                        // Split the range into two dates
                        // list($startDate, $endDate) = explode(' to ', $eventDate);
                        [$startDate, $endDate] = explode(' to ', $eventDate);
                        $startDateFormatted = \Carbon\Carbon::parse($startDate)->format('l, F j, Y');
                        $endDateFormatted = \Carbon\Carbon::parse($endDate)->format('l, F j, Y');
                        ?>
                        <p class="font-semibold text-lg">
                            Reminder: You've booked the date from
                            <strong>{{ $startDateFormatted }} to {{ $endDateFormatted }}</strong>.
                        </p>
                    @else
                        <!-- If eventDate is a single date -->
                        <p class="font-semibold text-lg">
                            Reminder: You've booked an event for
                            <strong>{{ \Carbon\Carbon::parse($eventDate)->format('l, F j, Y') }}</strong>.
                        </p>
                    @endif
                    <div class="text-center">
                        <p class="text-sm">We’re excited to help you prepare for this special day!</p>
                    </div>
                </div>
            </div>


            {{-- RIGHT SIDE --}}
            <aside class="lg:w-2/5 xl:w-1/3 space-y-5">

                <!-- Scrollable Cart Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800">Order Summary</h2>
                    </div>

                    <div class="max-h-96 overflow-y-auto p-5">
                        @if ($cart->items->count() > 0)
                            <ul class="space-y-6">
                                @foreach ($cart->items as $cartItem)
                                    @php
                                        $isPackage = $cartItem->package ? true : false;

                                        $itemName = $cartItem->menu_item_id
                                            ? $cartItem->menuItem->name
                                            : ($cartItem->package
                                                ? $cartItem->package->name
                                                : 'Unknown');

                                        $itemPrice = $cartItem->menu_item_id
                                            ? $cartItem->menuItem->getPriceForVariant($cartItem->variant)
                                            : ($cartItem->package
                                                ? $cartItem->package->price_per_person
                                                : 0);

                                        $computedPrice = $isPackage ? $itemPrice * $totalGuests : $itemPrice;

                                        // For package items
                                        if ($isPackage && $cartItem->package->packageItems) {
                                            $itemNames = [];
                                            foreach ($cartItem->package->packageItems as $packageItem) {
                                                $itemNames[$packageItem->item->id] =
                                                    $packageItem->item->name ?? 'Unnamed Item';
                                            }
                                        }
                                    @endphp

                                    <li class="pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-800">
                                                    {{ $itemName }}
                                                    @if ($isPackage)
                                                        <span class="text-sm font-normal text-gray-500 block mt-1">
                                                            ₱{{ number_format($itemPrice, 2) }} × {{ $totalGuests }}
                                                            guests
                                                            <span class="text-sm text-gray-500 ml-1">×
                                                                {{ $days }}
                                                                {{ Str::plural('day', $days) }}</span>
                                                        </span>
                                                    @else
                                                        <span class="text-sm font-normal text-gray-500 block mt-1">
                                                            {{ $cartItem->menuItem->description ?? 'No description available.' }}<br>
                                                            {{ $cartItem->variant }}pax
                                                        </span>
                                                    @endif
                                                </h3>

                                                <!-- Selected Options -->
                                                @if ($cartItem->selected_options && is_array($cartItem->selected_options))
                                                <div class="mt-3 space-y-1">
                                                    @foreach ($cartItem->selected_options as $itemId => $optionArray)
                                                        @php
                                                            $optionItemName = $itemNames[$itemId] ?? 'Option';
                                                            $types = array_map(fn($opt) => $opt['type'] ?? null, $optionArray);
                                                            $types = array_filter($types);
                                            
                                                            $showTypes = true;
                                                            if (count($types) === 1 && $types[0] === $optionItemName) {
                                                                $showTypes = false;
                                                            }
                                                        @endphp
                                            
                                                        <div class="flex">
                                                            <span class="text-gray-400 mr-2">•</span>
                                                            <div>
                                                                @if ($showTypes)
                                                                    <span class="text-sm font-medium text-gray-600">{{ $optionItemName }}:</span>
                                                                    <span class="text-sm text-gray-500 ml-1">{{ implode(', ', $types) }}</span>
                                                                @else
                                                                    <span class="text-sm font-medium text-gray-600">{{ $optionItemName }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                                <!-- Utilities -->
                                                @if ($isPackage && $cartItem->package->utilities->count() > 0)
                                                    <div class="mt-3">
                                                        <p
                                                            class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                                                            Includes:</p>
                                                        <ul class="space-y-1">
                                                            @foreach ($cartItem->package->utilities as $utility)
                                                                <li class="text-sm text-gray-600 flex items-center">
                                                                    <svg class="w-3 h-3 text-gray-400 mr-2"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    {{ $utility->quantity }}x {{ $utility->name }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <span
                                                class="font-medium text-gray-900 ml-4 whitespace-nowrap">₱{{ number_format($computedPrice, 2) }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <p class="mt-2 text-gray-500">Your cart is empty</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Totals Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Order Total</h2>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal ({{ $cart->items->count() }} items)</span>

                                <span class="font-medium">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>

                            {{-- <div class="flex justify-between">
                                <span class="text-gray-600">Guests</span>
                                <span class="font-medium">{{ $totalGuests }}</span>
                            </div> --}}

                            <div class="border-t border-gray-200 my-3"></div>

                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Totals</span>
                                <span>₱{{ number_format($totalPrice, 2) }} </span>

                            </div>
                        </div>
                    </div>
                </div>




                <!-- Google Map displaying store location -->
                <div class="bg-white shadow-md rounded p-4 mt-5">
                    <h2 class="text-xl font-bold mb-4">Store Location</h2>
                    <div class="w-full h-64">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d296.22852944864854!2d122.08477937836653!3d6.903982223841712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x325069b1a08a5bf7%3A0x7bc71a2079abe9f6!2sAyer%20Village!5e1!3m2!1sen!2sph!4v1741625083210!5m2!1sen!2sph"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </aside>

        </div>

        

</body>

</html>
