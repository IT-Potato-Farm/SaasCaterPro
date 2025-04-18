<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
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

                            <!-- TIME START AND END -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        How would you like to select time?
                                    </label>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="time_mode" value="slot"
                                                {{ old('time_mode', 'slot') === 'slot' ? 'checked' : '' }}
                                                class="focus:ring-blue-500">
                                            <span>Choose from available slots</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="time_mode" value="custom"
                                                {{ old('time_mode') === 'custom' ? 'checked' : '' }}
                                                class="focus:ring-blue-500">
                                            <span>Enter custom time</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Time Slot Radio Buttons -->
                                <div class="grid grid-cols-1 gap-6" id="time_slot_wrapper"
                                    style="display: {{ old('time_mode', 'slot') === 'slot' ? 'grid' : 'none' }};">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Choose Time Slot
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
                                    <p class="text-sm text-gray-500">
                                        Service Hours:
                                        {{ \Carbon\Carbon::parse($booking_settings->service_start_time)->format('g:iA') }}-{{ \Carbon\Carbon::parse($booking_settings->service_end_time)->format('g:iA') }}
                                    </p>
                                </div>

                                <!-- Custom Time Radio Buttons -->
                                <div class="grid grid-cols-1 gap-6" id="custom_time_wrapper"
                                    style="display: {{ old('time_mode') === 'custom' ? 'grid' : 'none' }};">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Select Custom Time Slot
                                        </label>
                                        <div id="custom_time_slots" class="space-y-2">
                                            <!-- Time slots will be dynamically inserted here -->
                                        </div>
                                        <p id="time-error" class="text-red-500 hidden"></p>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        Service Hours:
                                        {{ \Carbon\Carbon::parse($booking_settings->service_start_time)->format('g:iA') }}-{{ \Carbon\Carbon::parse($booking_settings->service_end_time)->format('g:iA') }}
                                    </p>
                                </div>
                            

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
                        <label for="event_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Event Address
                        </label>
                        <textarea name="event_address" id="event_address" rows="3" placeholder="Enter full event address"
                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            required></textarea>
                    </div>
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
                                                <div class="mt-3 space-y-2">
                                                    @foreach ($cartItem->selected_options as $itemId => $optionArray)
                                                        @php
                                                            $optionItemName = $itemNames[$itemId] ?? 'Option';
                                                            $types = array_map(
                                                                fn($opt) => $opt['type'] ?? 'Unknown',
                                                                $optionArray,
                                                            );
                                                        @endphp

                                                        <div class="flex">
                                                            <span class="text-gray-400 mr-2">•</span>
                                                            <div>
                                                                <span
                                                                    class="text-sm font-medium text-gray-600">{{ $optionItemName }}:</span>
                                                                <span
                                                                    class="text-sm text-gray-500 ml-1">{{ implode(', ', $types) }}</span>
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
                                                                <svg class="w-3 h-3 text-gray-400 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration
            const serviceStartDisplay =
                "{{ \Carbon\Carbon::parse($booking_settings->service_start_time)->format('g:iA') }}";
            const serviceEndDisplay =
                "{{ \Carbon\Carbon::parse($booking_settings->service_end_time)->format('g:iA') }}";
            let eventDate = document.querySelector('input[name="event_date"]')?.value || "{{ $eventDate }}";
            const totalGuests = document.querySelector('input[name="total_guests"]')?.value;

            // Log for debugging
            console.log('Service Start Display:', serviceStartDisplay, 'Service End Display:', serviceEndDisplay);
            console.log('Event Date:', eventDate, 'Total Guests:', totalGuests);

            // Fetch available time slots for custom_time_wrapper
            let availableSlots = [];
            async function fetchAvailableSlots() {
                try {
                    const response = await fetch(
                        `/bookings/available-slots?event_date=${encodeURIComponent(eventDate)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                    if (!response.ok) throw new Error('Failed to fetch available slots');
                    availableSlots = await response.json();
                    console.log('Available Slots:', availableSlots);
                    renderTimeSlots();
                } catch (error) {
                    console.error('Error fetching available slots:', error);
                    const timeError = document.getElementById('time-error');
                    if (timeError) {
                        timeError.textContent = 'Unable to load time slots. Please try again.';
                        timeError.classList.remove('hidden');
                    }
                }
            }

            // Render time slots as radio buttons for custom_time_wrapper
            function renderTimeSlots() {
                const slotsContainer = document.getElementById('custom_time_slots');
                if (!slotsContainer) {
                    console.warn('Custom time slots container not found');
                    return;
                }
                slotsContainer.innerHTML = '';

                if (availableSlots.length === 0) {
                    slotsContainer.innerHTML = '<p class="text-gray-500">No available time slots.</p>';
                    const timeError = document.getElementById('time-error');
                    if (timeError) {
                        timeError.textContent = 'All time slots are booked for this date.';
                        timeError.classList.remove('hidden');
                    }
                    return;
                }

                availableSlots.forEach((slot, index) => {
                    const startDisplay = formatTime(slot.start, 'h:iA');
                    const endDisplay = formatTime(slot.end, 'h:iA');
                    const slotId = `custom_time_slot_${index}`;
                    const slotHtml = `
                            <div class="flex items-center">
                                <input type="radio" name="custom_time_slot" id="${slotId}" value="${slot.start}|${slot.end}"
                                       class="mr-2 focus:ring-blue-500">
                                <label for="${slotId}" class="text-gray-700">${startDisplay}-${endDisplay}</label>
                            </div>
                        `;
                    slotsContainer.insertAdjacentHTML('beforeend', slotHtml);
                });

                // Bind validation to custom_time_slot radio buttons
                document.querySelectorAll('input[name="custom_time_slot"]').forEach(radio => {
                    radio.addEventListener('change', validateCustomTime);
                });
            }

            // Format time to h:iA (e.g., 1:00PM)
            function formatTime(time, format) {
                const [hours, minutes] = time.split(':').map(Number);
                const date = new Date(1970, 0, 1, hours, minutes);
                let h = date.getHours();
                const m = date.getMinutes();
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                const mStr = m < 10 ? `0${m}` : m;
                if (format === 'h:iA') {
                    return `${h}:${mStr}${ampm}`;
                }
                return time;
            }

            // Validate event_time_slot (time_slot_wrapper)
            function validateEventTimeSlot() {
                const selectedSlot = document.querySelector('input[name="event_time_slot"]:checked');
                const errorMessage = document.getElementById('time-slot-error');
                const form = document.querySelector('form');
                const submitButton = form?.querySelector('button[type="submit"]');

                console.log('Validating event_time_slot, Selected:', !!selectedSlot);

                if (!selectedSlot && document.querySelector('input[name="time_mode"]:checked')?.value === 'slot') {
                    if (errorMessage) {
                        errorMessage.textContent = 'Please select a time slot.';
                        errorMessage.classList.remove('hidden');
                    }
                    if (submitButton) submitButton.disabled = true;
                    return;
                }

                if (errorMessage) {
                    errorMessage.textContent = '';
                    errorMessage.classList.add('hidden');
                }
                if (submitButton) submitButton.disabled = false;
            }

            // Validate custom_time_slot (custom_time_wrapper)
            function validateCustomTime() {
                const selectedSlot = document.querySelector('input[name="custom_time_slot"]:checked');
                const errorMessage = document.getElementById('time-error');
                const form = document.querySelector('form');
                const submitButton = form?.querySelector('button[type="submit"]');

                console.log('Validating custom_time_slot, Selected:', !!selectedSlot);

                if (!selectedSlot && document.querySelector('input[name="time_mode"]:checked')?.value ===
                    'custom') {
                    if (errorMessage) {
                        errorMessage.textContent = 'Please select a time slot.';
                        errorMessage.classList.remove('hidden');
                    }
                    if (submitButton) submitButton.disabled = true;
                    return;
                }

                if (errorMessage) {
                    errorMessage.textContent = '';
                    errorMessage.classList.add('hidden');
                }
                if (submitButton) submitButton.disabled = false;
            }

            // Toggle time mode and manage required attributes
            function toggleTimeMode() {
                const timeMode = document.querySelector('input[name="time_mode"]:checked')?.value || 'slot';
                console.log('Toggling time mode:', timeMode);

                // Show/hide wrappers
                document.getElementById('time_slot_wrapper').style.display = timeMode === 'slot' ? 'grid' : 'none';
                document.getElementById('custom_time_wrapper').style.display = timeMode === 'custom' ? 'grid' :
                    'none';

                // Manage required attributes
                document.querySelectorAll('input[name="event_time_slot"]').forEach(radio => {
                    if (timeMode === 'slot') {
                        radio.setAttribute('required', 'required');
                    } else {
                        radio.removeAttribute('required');
                    }
                });

                document.querySelectorAll('input[name="custom_time_slot"]').forEach(radio => {
                    if (timeMode === 'custom') {
                        radio.setAttribute('required', 'required');
                    } else {
                        radio.removeAttribute('required');
                    }
                });

                validateEventTimeSlot();
                validateCustomTime();
            }

            // Bind time mode toggle
            document.querySelectorAll('input[name="time_mode"]').forEach(radio => {
                radio.addEventListener('change', toggleTimeMode);
            });

            // Bind validation for event_time_slot
            const eventTimeRadios = document.querySelectorAll('input[name="event_time_slot"]');
            console.log('Found event_time_slot radios:', eventTimeRadios.length);
            if (eventTimeRadios.length > 0) {
                eventTimeRadios.forEach(radio => {
                    radio.addEventListener('change', validateEventTimeSlot);
                });
            } else {
                console.warn('No event_time_slot radio buttons found on page load');
            }

            // Event type handling
            const eventTypeSelect = document.getElementById('event_type_select');
            const customEventContainer = document.getElementById('custom_event_type_container');
            if (eventTypeSelect && customEventContainer) {
                eventTypeSelect.addEventListener('change', function() {
                    const isOther = this.value === 'Other';
                    customEventContainer.style.display = isOther ? 'block' : 'none';
                    const customEventInput = document.getElementById('custom_event_type');
                    if (customEventInput) {
                        customEventInput.value = isOther ? customEventInput.value : '';
                        customEventInput.required = isOther;
                    }
                });
            }

            // Re-fetch custom slots if event date changes
            const eventDateInput = document.querySelector('input[name="event_date"]');
            if (eventDateInput) {
                eventDateInput.addEventListener('change', function() {
                    console.log('Event date changed:', this.value);
                    eventDate = this.value;
                    fetchAvailableSlots();
                    validateCustomTime();
                    validateEventTimeSlot();
                });
            }

            // Initialize
            toggleTimeMode();
            fetchAvailableSlots();
            validateEventTimeSlot();
        });
    </script>
</body>

</html>
