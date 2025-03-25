<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Event Date -->
                                <div class="space-y-2">
                                    <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Event Date
                                    </label>
                                    <!-- Note: input type changed to text for proper Flatpickr integration -->
                                    <input type="text" name="event_date" id="event_date"
                                        placeholder="Select a date or date range"
                                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                </div>

                            </div>

                            <!--  OTHER EVENT TYPE  -->
                            <div class="space-y-2 hidden" id="custom_event_type_container">
                                <label for="custom_event_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Custom Event Type
                                </label>
                                <input type="text" name="custom_event_type" id="custom_event_type"
                                    placeholder="Enter custom event type"
                                    class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>

                            <!-- TIME START AND END -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Event Start Time -->
                                <div class="space-y-2">
                                    <label for="event_start_time"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Start Time
                                    </label>
                                    <input type="time" name="event_start_time" id="event_start_time"
                                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                </div>
                                {{-- event end --}}
                                <div class="space-y-2">
                                    <label for="event_start_end" class="block text-sm font-semibold text-gray-700 mb-2">
                                        End Time
                                    </label>
                                    <input type="time" name="event_start_end" id="event_start_end"
                                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        required>
                                </div>
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

                        <button type="submit" @if (isset($pendingOrder)) disabled @endif
                            class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                            Confirm & Place Order
                        </button>
                    </form>
                </div>
            </div>




            <aside class="lg:w-2/5 xl:w-1/3">
                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-bold mb-4">Order Total</h2>
                    <p class="mb-2">
                        <span class="font-semibold">Total Guests:</span> {{ $totalGuests }}
                    </p>
                    <p class="mb-2">
                        <span class="font-semibold">Selected Items:</span> {{ $cart->items->count() }}
                    </p>
                    <p class="mb-2">
                        <span class="font-semibold">Total Price:</span> ₱{{ number_format($totalPrice, 2) }}
                    </p>
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
            flatpickr("#event_date", {
                mode: "range", // Allow selecting a range of dates
                dateFormat: "Y-m-d", // Format the date as YYYY-MM-DD
                minDate: "today" // Only allow today and future dates
            });
            document.addEventListener('DOMContentLoaded', function() {
                const eventTypeSelect = document.getElementById('event_type_select');
                const customEventContainer = document.getElementById('custom_event_type_container');

                eventTypeSelect.addEventListener('change', function() {
                    if (this.value === 'Other') {
                        customEventContainer.style.display = 'block';
                        document.getElementById('custom_event_type').required = true;
                    } else {
                        customEventContainer.style.display = 'none';
                        document.getElementById('custom_event_type').value = '';
                        document.getElementById('custom_event_type').required = false;
                    }
                });
            });
        </script>
</body>

</html>
