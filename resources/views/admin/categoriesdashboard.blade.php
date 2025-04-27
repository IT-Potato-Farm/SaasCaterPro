<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
</head>
<body>

    @if(session('success'))
    <script>
        showSuccessToast('{{ session('success') }}');
    </script>
    @endif
    
    @if(session('error'))
    <script>
        showErrorToast('{{ session('error') }}');
    </script>
    @endif
    
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <x-category.category-button />
                <x-dashboard.categories />

                
            </main>
        </div>

    </div>
</body>
</html>