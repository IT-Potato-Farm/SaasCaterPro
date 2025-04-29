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
                                                @if (!$order->review)
                                                    <button onclick="leaveReview({{ $order->id }})"
                                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm hover:shadow-md">
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                            <span>Leave a Review</span>
                                                        </div>
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

    <!-- Review Modal -->
    <div id="leaveReviewModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Leave A Review</h2>
            <form id="leaveReviewForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="order-id" name="order_id" value="">

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                    <select id="rating" name="rating"
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
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload Image:</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div id="image-error" class="error-message"></div>
                </div>

                <!-- Review -->
                <div>
                    <label for="review" class="block text-sm font-medium text-gray-700">Review:</label>
                    <textarea id="review" name="review"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <div id="review-error" class="error-message text-red-600 text-sm mt-2"></div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-300 text-gray-800 py-2 px-4 rounded-md">Cancel</button>
                    <button type="submit" onclick="leaveReview(orderId)"
                        class="bg-indigo-600 text-white py-2 px-4 rounded-md">Leave Review</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function leaveReview(orderId) {
            console.log('Opening review modal for order:', orderId);
            document.getElementById('order-id').value = orderId;
            document.getElementById('leaveReviewModal').classList.remove('hidden');

            // Reset form values and errors
            document.getElementById('leaveReviewForm').reset();
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        }

        // Close modal
        function closeModal() {
            document.getElementById('leaveReviewModal').classList.add('hidden');
        }

        document.getElementById('leaveReviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            // Validate review length
            const reviewText = document.getElementById('review').value.trim();
            if (reviewText.length > 1000) {
                document.getElementById('review-error').textContent =
                    'Review is too long. Maximum 1000 characters allowed.';
                return;
            }

            if (reviewText.length === 0) {
                document.getElementById('review-error').textContent =
                    'Please enter your review.';
                return;
            }

            submitForm(formData);
        });

        // Submit the form to the backend
        function submitForm(formData) {
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Get URL from Laravel route helper, fallback to relative path
            let url = "{{ route('reviews.leaveReview') }}";

            if (window.location.hostname === 'saascater.site') {
                url = 'https://saascater.site/reviews/submit';
            } else {
                url = "{{ route('reviews.leaveReview') }}";
            }

            // Ensure no trailing slash
            url = url.replace(/\/$/, '');

            console.log("Submitting review to:", url, "with data:", {
                orderId: formData.get('order_id'),
                rating: formData.get('rating'),
                hasImage: formData.get('image') ? true : false,
                reviewLength: formData.get('review')?.length || 0
            });
            // console.log("Final URL being called:", url);
            // console.log("CSRF Token:", token);

            fetch(url, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin',
                    cache: 'no-cache',
                    redirect: 'follow'
                })
                .then(async response => {
                    // console.log("Response status:", response.status);
                    // console.log("Response headers:", Object.fromEntries([...response.headers]));
                    const contentType = response.headers.get('content-type');
                    const isJson = contentType && contentType.includes('application/json');

                    try {
                        const data = isJson ? await response.json() : null;
                        console.log("Response data:", data);

                        if (!response.ok) {
                            const error = (data && data.message) || response.statusText;
                            throw new Error(error || 'Request failed');
                        }

                        return data;
                    } catch (err) {
                        console.error("Error parsing response:", err);
                        throw new Error('Failed to parse server response');
                    }
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message || 'Review submitted successfully!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });

                        closeModal();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        if (data.errors) {
                            Object.entries(data.errors).forEach(([field, messages]) => {
                                const errorElement = document.getElementById(`${field}-error`);
                                if (errorElement) {
                                    errorElement.textContent = Array.isArray(messages) ? messages.join(', ') :
                                        messages;
                                }
                            });
                        } else {
                            throw new Error(data.message || 'Submission failed');
                        }
                    }
                })
                .catch(error => {
                    console.error('Submission error details:', {
                        message: error.message,
                        stack: error.stack,
                        name: error.name
                    });
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: error.message || 'Failed to submit review',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#dc3545',
                        color: '#fff',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                });
        }
    </script>

</body>

</html>
