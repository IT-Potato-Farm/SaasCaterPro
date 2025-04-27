<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Menus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    

</head>
<body>
    <x-customer.navbar />
    {{-- <x-allmenu.mini-nav /> --}}
    <x-allmenu.menusection />
    
    <script src="{{ asset('js/addPackageToCart.js') }}?v={{ filemtime(public_path('js/addPackageToCart.js')) }}"></script>

    {{-- <script src="{{ asset('js/addPackageToCart.js') }}"></script> --}}
    <script src="{{ asset('js/partyTrayCart.js') }}"></script>
</body>
</html>