<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saas Catering Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body class="">
    
    <x-customer.navbar />
    <x-customer.hero/>
    <x-customer.menu-section/>
    {{-- <x-menu-modal /> --}}
    <x-customer.sweet-alert-menu />
    <x-customer.why-choose-us />
    <x-customer.ratingsection  />
    <x-customer.about-us/>
    <x-customer.footer/>
</body>
</html>