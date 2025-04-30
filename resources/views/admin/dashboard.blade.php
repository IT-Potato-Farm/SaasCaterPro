<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let packageItemsMapping = @json($packageItemsGroupedByPackage);
        console.log(packageItemsMapping); 
    </script>
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slide-out {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(150%);
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }

        .animate-slide-out {
            animation: slide-out 0.3s ease-in;
        }
    </style>
</head>

<body class="bg-gray-500 p-5">
    <h1>ADMIN DASHBOARD</h1>

    @auth
        @if (Auth::user()->role === 'admin')
            <h2>Welcome, {{ Auth::user()->first_name }}</h2>
            <h2>Role: {{ Auth::user()->role }}</h2>
            <form action="/logout" method="post">
                @csrf
                <button class="hover:cursor-pointer px-4 bg-red-500 rounded">Logout</button>
            </form>
            <x-category.category-button />
            {{-- <x-items.item-button /> --}}
            <a href="/" class="px-4 py-1 bg-green-300 rounded">Home</a>
            <a href="/landing" class="px-4 py-1 bg-green-300 rounded">main home</a>


            {{-- category formm --}}
            {{-- <x-category-form /> --}}

         

            <header class="flex items-center justify-center">
                <div>
                    <h1 class="text-5xl font-bold text-center">Package Items</h1>
                    <x-packages.add-package-item-btn />
                    <x-packages.add-package-option-btn />
                    <x-packages.add-package-utility />
                </div>
            </header>

            <main class="mt-5 flex items-center justify-center gap-5">
                @foreach ($packages as $package)
                    <div class="border p-4 rounded-lg shadow-lg max-w-xs">
                        <!--  IMG -->
                        <img src="{{ asset('packagePics/' . $package->image) }}" alt="{{ $package->name }}"
                            class="w-full h-48 object-cover rounded-lg mb-3">
                        <!-- Package Name -->
                        <h3 class="text-lg font-bold">{{ $package->name }}</h3>

                        <!-- Package Items -->
                        <ul class="list-disc pl-4">
                            {{-- FOR INCLUSIONS FOODS --}}
                            <h4 class="text-md font-semibold mt-3">Included Foods:</h4>
                            @foreach ($package->packageItems as $packageItem)
                                <li>
                                    {{ $packageItem->item->name }}
                                    
                                    {{-- Choices like sa chicken, may fried ganon --}}
                                    @if ($packageItem->options->isNotEmpty())
                                        <ul class="list-circle pl-6 text-sm text-gray-700">
                                            @foreach ($packageItem->options as $option)
                                                <li>{{ $option->itemOption->type }} </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <!-- Package Utilities -->
                        <h4 class="text-md font-semibold mt-3">Utilities Provided:</h4>
                        <ul class="list-disc pl-4 text-sm text-gray-700">
                            @foreach ($package->utilities as $utility)
                                <li>{{ $utility->name }} (Qty: {{ $utility->quantity }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                    

            </main>
           
        @else
            <script>
                window.location.href = "/";
            </script>
        @endif
    @else
        <script>
            window.location.href = "/";
        </script>
    @endauth

    <main class="mt-5">


    </main>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f0fdfa',
                iconColor: '#06b6d4',
                color: '#164e63',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
        </script>
    @endif
</body>

</html>
