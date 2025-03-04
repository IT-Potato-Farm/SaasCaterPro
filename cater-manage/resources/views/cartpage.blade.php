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

    <div class="flex flex-col items-center justify-center min-h-screen gap-4 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> 
            <circle cx="9" cy="21" r="1" />
            <circle cx="20" cy="21" r="1" />
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H5" />
        </svg>
        <h1 class="text-xl font-semibold text-gray-700">Your Cart is currently empty</h1>
        <a class="px-5 py-2 text-white bg-lime-500 rounded-md shadow hover:bg-lime-600 transition" href="{{ route('all-menu') }}">Browse Menus</a>
        <a class="px-5 py-2 bg-cyan-200 rounded-md" href="{{route('checkoutpage')}}">Checkout</a>
    </div>
</body>

</html>
