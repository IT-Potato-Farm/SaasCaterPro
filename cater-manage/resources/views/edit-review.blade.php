<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Edit Review - Order #{{ $order->id }}</title>
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
               
                <!-- Edit Review -->
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Edit Review</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <div class="p-6 bg-white rounded-xl shadow-md">

                                <form action="{{ route('updateReview', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label for="rating" class="block text-sm font-medium text-gray-600">Rating</label>
                                        <input type="number" name="rating" value="{{ old('rating', $order->review->rating) }}" min="1" max="5" class="w-full p-2 border rounded" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="review" class="block text-sm font-medium text-gray-600">Review</label>
                                        <textarea name="review" class="w-full p-2 border rounded" required>{{ old('review', $order->review->review) }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="image" class="block text-sm font-medium text-gray-600">Image (optional)</label>
                                        <input type="file" name="image" accept="image/*" class="w-full p-2 border rounded">
                                    </div>
                                    
                                    
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                                    <a href="{{ route('showReview', $order->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                                </form>

                        </div>
                    </div>
                </div>         
            </main>

        </div>
        
    </div>  


</body>

</html>