<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-gray-50">
    <x-customer.navbar />
    <div class="min-h-screen">
        @if (session('success'))
            <script>
                showSuccessToast('{{ session('success') }}');
            </script>
        @endif

        @if (session('error'))
            <script>
                showErrorToast('{{ session('error') }}');
            </script>
        @endif

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <header class="bg-white shadow-sm rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Order History</h1>
                        <p class="text-sm text-gray-600">View and manage your orders</p>
                    </div>
                </div>
            </header>

            <!-- Orders Table -->
            <main class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Review</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('order.show', $order->id) }}"
                                                        class="hover:text-blue-600">#{{ $order->id }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($order->status == 'completed')
                                                <span class="text-green-600">
                                                    <svg class="h-5 w-5 inline" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </span>
                                            @else
                                                <span class="text-red-600">
                                                    <svg class="h-5 w-5 inline" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $statusClasses = [
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if ($order->status == 'completed')
                                                @if ($order->review)
                                                    <a href="#" class="text-blue-600 hover:text-blue-800">Show
                                                        Review</a>
                                                @else
                                                    {{-- <x-reviews.leave-review :order="$order" /> --}}
                                                    <button onclick="leaveReview({{ $order->id }})"
                                                        class="text-indigo-600 hover:text-indigo-800">
                                                        Leave a Review
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-gray-500">Not applicable</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            ₱{{ number_format($order->total, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div
                                                class="flex flex-col items-center justify-center space-y-4 text-gray-500">
                                                <svg class="h-16 w-16" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                                <p class="text-lg">No orders found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-700">
                            <div class="mb-4 sm:mb-0">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                                {{ $orders->total() }} results
                            </div>
                            <div class="flex space-x-2">
                                {{ $orders->onEachSide(1)->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function leaveReview(orderId) {
            Swal.fire({
                title: '<span class="text-2xl font-bold text-gray-800">Leave A Review</span>',
                html: `
                    <form id="leaveReviewForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                        <input type="hidden" id="swal-order-id" name="order_id" value="${orderId}">
    
                        <!-- Rating -->
                        <div>
                            <label for="swal-rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                            <select id="swal-rating" name="rating"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Terrible</option>
                            </select>
                            <div id="rating-error" class="error-message"></div>
                        </div>
    
                        <!-- Image -->
                        <div>
                            <label for="swal-image" class="block text-sm font-medium text-gray-700">Upload Image:</label>
                            <input type="file" id="swal-image" name="image" accept="image/*"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="image-error" class="error-message"></div>
                        </div>
    
                        <!-- Review -->
                        <div>
                            <label for="swal-review" class="block text-sm font-medium text-gray-700">Review:</label>
                            <textarea id="swal-review" name="review"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            <div id="review-error" class="error-message"></div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Leave Review',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                
                preConfirm: () => {
                    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
                    const form = document.getElementById('leaveReviewForm');
                    const formData = new FormData(form);
    
                    let hasErrors = false;
    
                    if (document.getElementById('swal-review').value.trim().length > 1000) {
                        document.getElementById('review-error').textContent = 'Review max words reached. Please leave a short review.';
                        hasErrors = true;
                    }
    
                    if (hasErrors) {
                        return false;
                    }
    
                    const imageInput = document.getElementById('swal-image');
                    if (imageInput.files.length > 0) {
                        formData.append('image', imageInput.files[0]);
                    }
    
                    return submitForm(formData);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: '<span class="text-xl font-bold text-gray-800">Success!</span>',
                        text: 'Review submitted successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    
        function submitForm(formData) {
            formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
            return fetch("{{ route('reviews.leaveReview') }}", {
                method: "POST",
                body: formData
            })
            .then(response => response.json().then(data => {
                if (!response.ok) {
                    throw new Error(data.message || 'Server Error. Please try again later.');
                }
                return data;
            }))
            .then(data => {
                if (!data.success) {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                            }
                        });
                        throw new Error('Error in validating. Please try again.');
                    } else {
                        throw new Error(data.message || 'Error. Please try again.');
                    }
                }
                return data;
            })
            .catch(error => {
                Swal.showValidationMessage(error.message);
                return false;
            });
        }
    </script>
    
</body>

</html>
