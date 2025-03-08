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
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50">
    <x-customer.navbar />

    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-7xl">
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
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Event Information</h2>
                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!--  Type -->
                            <div class="space-y-2">
                                <label for="event_type" class="block text-sm font-medium text-gray-700">Event
                                    Type</label>
                                <input type="text" name="event_type" id="event_type"
                                    placeholder="Wedding, Birthday, etc."
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <!--  Date -->
                            <div class="space-y-2">
                                <label for="event_date" class="block text-sm font-medium text-gray-700">Event
                                    Date</label>
                                <input type="date" name="event_date" id="event_date"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>

                        <!-- address -->
                        <div class="space-y-2">
                            <label for="event_address" class="block text-sm font-medium text-gray-700">Event
                                Address</label>
                            <textarea name="event_address" id="event_address" rows="3" placeholder="Enter the event location"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required></textarea>
                        </div>

                        <!-- total guest -->
                        <div class="space-y-2">
                            <label for="total_guests" class="block text-sm font-medium text-gray-700">Number of
                                Guests</label>
                            <input type="number" name="total_guests" id="total_guests" min="1" placeholder="50"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <!-- minimum pax notification -->
                            <p id="minPaxNotification" class="text-xs text-blue-600 hidden"></p>
                        </div>

                        <!-- concerns and other shits -->
                        <div class="space-y-2">
                            <label for="concerns" class="block text-sm font-medium text-gray-700">Special
                                Requests</label>
                            <textarea name="concerns" id="concerns" rows="3" placeholder="Other requests or concerns"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit" @if (isset($pendingOrder)) disabled @endif
                            class="w-full bg-blue-600 text-white py-3.5 px-6 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            Confirm & Place Order
                        </button>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <script>
        // Convert  PHP packagesMinPax array to a JavaScript variable.
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
    </script>
</body>

</html>
