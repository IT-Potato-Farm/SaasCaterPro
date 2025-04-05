<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let packageItemsMapping = @json($packageItemsGroupedByPackage);
        console.log(packageItemsMapping); 
    </script>
</head>

<body>
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                
                <x-packages.addbtn />
                <x-packages.add-package-item-btn />
                <x-packages.add-package-option-btn />
                <x-packages.add-package-utility />
                <x-dashboard.packages />
            </main>
        </div>

    </div>
</body>

</html>
