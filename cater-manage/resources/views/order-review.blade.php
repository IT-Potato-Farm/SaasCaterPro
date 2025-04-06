<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Review - Order #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pap0+X+J6XlKqmvdZJzH8g4OoJ1+xM2JpUpbO8hzF2Pz2BXl+AGoD54YkS++1MJaa4xSLSFI0pY2vLxA0f5s0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100">
    <x-customer.navbar />
    <div class="flex h-screen">

        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
                        <p class="text-sm text-gray-600 mt-1">Order placed on {{ $order->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <nav class="hidden sm:block">
                        <ol class="flex items-center space-x-2 text-gray-600 text-sm">
                            <li>
                                <a href="{{ route('landing') }}" class="hover:underline hover:text-blue-600">Home</a>
                            </li>
                            <li>/</li>
                            <li>
                                <a href="{{ route('userdashboard') }}" class="hover:underline hover:text-blue-600">My
                                    Orders</a>
                            </li>
                            <li>/</li>
                            <li class="text-gray-800 font-medium">Order #{{ $order->id }}</li>
                        </ol>
                    </nav>
                </div>
            </header>

            <main class="flex-1 overflow-auto p-8">
               
                <!-- Order Review -->
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Order Review</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="p-6 bg-white rounded-xl shadow-md">
                            
                            <!-- Order Rating -->
                            <div class="flex justify-center mb-4 gap-1.5">
                                @for($i = 1; $i <= $order->review->rating; $i++)
                                    <img src="{{ asset('images/star.svg') }}" class="h-6 w-6 text-yellow-400" alt="Star">
                                @endfor
                            </div>

                            <!-- Order Image -->
                            @if($order->review->image)
                                <div class="flex justify-center">
                                    <img src="{{ asset('reviews/' . $order->review->image) }}" class="h-60 w-full object-contain rounded-lg shadow-sm" alt="Review Image">
                                </div>
                            @else
                                <p class="text-center text-gray-500">No image provided.</p>
                            @endif

                            <!-- Order Review -->
                            <p class="text-lg italic mb-4">{{ $order->review->review }}</p>

                            <div class="mt-6 flex justify-end">

                                @php
                                    $timeLimit = now()->subMinutes(15);
                                    $canEdit = $review->created_at > $timeLimit;
                                @endphp
                               
                                @if ($canEdit)
                                    <button class="bg-yellow-500 text-white px-4 py-2 rounded" 
                                            onclick="window.location.href='{{ route('editReview', $order->id) }}'">
                                        Edit Review
                                    </button>
                                @else
                                    <button class="px-4 py-2 bg-gray-300 text-gray-600 rounded cursor-not-allowed" disabled> Edit time expired </button>
                                @endif

                                <button 
                                    class="bg-red-500 text-white px-4 py-2 rounded" 
                                    onclick="confirmDelete('{{ route('deleteReview', ['order' => $order->id, 'review' => $order->review->id]) }}')"
                                >
                                    Delete
                                </button>
                                
                            </div>
                        </div>
                    </div>
                </div>         
            </main>

        </div>
        
    </div>  

    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won’t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white',
                cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>


</body>

</html>