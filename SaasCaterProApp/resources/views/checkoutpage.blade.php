<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body class="bg-gray-50">
    <x-customer.navbar />
    <div class="container mx-auto px-4 py-8">

        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <!--  two-column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left column: Shipping  -->
            <div class="space-y-8">

                <!-- SHIPPING DETAILS -->
                <div class="bg-white p-6 rounded shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Shipping Details</h2>
                    <div class="space-y-2">
                        <p class="font-medium">John Emman</p>
                        <p>
                            Baliwasan<br>
                            Philippines<br>
                            Earth
                        </p>
                        <p class="text-gray-600">emman@gmail.com</p>
                    </div>
                </div>

                <!-- PAYMENT DETAILS -->
                <div class="bg-white p-6 rounded shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Venue Details</h2>
                    <form action="#" method="POST">
                        @csrf
                        @method('POST')
                        <!-- event type-->
                        <div class="mb-4">
                            <label for="eventType" class="block text-sm font-medium text-gray-700">Event type</label>
                            <input type="text" id="eventType" name="eventType"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="" />
                        </div>
                        <!-- Event date -->
                        <div class="mb-4">
                            <label for="eventDate" class="block text-sm font-medium text-gray-700">Event date</label>
                            <input type="date" id="eventDate" name="eventDate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="" />
                        </div>
                        <!-- eventr place -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Event Address</label>
                            <input type="text" id="address" name="address"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="" />
                        </div>
                        <!--  -->
                            <div class="mb-4 w-full">
                                <label for="expiry" class="block text-sm font-medium text-gray-700">Estimation of total guests</label>
                                <input type="text" id="totalGuest" name="totalGuest"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="" />
                            </div>
                            <div class="mb-4 w-full">
                                <label for="cvc" class="block text-sm font-medium text-gray-700">Any other concerns?</label>
                                <input type="concern" id="concern" name="concern"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="achuchu" />
                            </div>
                            
                        <!-- Purchase Button -->
                        <button type="submit"
                            class="mt-2 w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>

            <!--Order Summary -->
            <div>
                <div class="bg-white p-6 rounded shadow-sm">
                    <h2 class="text-xl font-semibold mb-4">Your Order</h2>

                    <!-- Item 1 -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-medium">Chicken - (fried)</p>
                            <p class="text-sm text-gray-500">2 pieces</p>
                        </div>
                        <p class="font-medium">₱10</p>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="font-medium">SET A - (Pagkain, food, snack, breakfast, and dinner)</p>
                            <p class="text-sm text-gray-500">3 orders</p>
                        </div>
                        <p class="font-medium">₱10</p>
                    </div>


                    <!-- Subtotal & Shipping -->
                    <hr class="my-2">
                    <div class="flex justify-between">
                        <p>Subtotal</p>
                        <p class="font-medium">₱40</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Shipping</p>
                        <p class="font-medium">₱100</p>
                    </div>
                    <hr class="my-2">
                    <!-- Total -->
                    <div class="flex justify-between text-lg font-semibold">
                        <p>Total</p>
                        <p>₱140</p>
                    </div>

                    <!-- Gift Code -->
                    <button class="mt-4 text-blue-600 hover:underline">
                        Add Gift Code
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your app.js if needed -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>