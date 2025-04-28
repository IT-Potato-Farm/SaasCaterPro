<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Section CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    <style>
        .review-card {
            transition: all 0.2s ease;
        }

        .review-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .review-card.selected {
            border: 2px solid #3B82F6;
            background-color: #EFF6FF;
        }

        .star-rating {
            color: #F59E0B;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
         function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure you want to delete this party tray?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
    </script>
</head>

<body class="bg-gray-50 flex h-screen">
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
    <x-dashboard.side-nav />

    <div class="flex-1 overflow-auto p-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Review Section Settings</h1>
                <div class="flex space-x-3">
                    <button onclick="selectAllCards()" type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Select All
                    </button>
                    <button onclick="deselectAllCards()" type="button"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Deselect All
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.review.update', $reviewSettings->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section Title -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                    <input type="text" name="title" id="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('title', $reviewSettings->title) }}" placeholder="What our customers say"
                        required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Options -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Display Options</h2>

                    <div class="mt-4">
                        <label for="max_display" class="block text-sm font-medium text-gray-700 mb-2">Maximum Reviews to
                            Display</label>
                        <select name="max_display" id="max_display"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" @selected(old('max_display', $reviewSettings->max_display ?? 6) == $i)>{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Featured Reviews Selection -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Select Featured Reviews</h2>
                    <p class="text-sm text-gray-500 mb-4">Click on review cards to select/deselect them. Selected
                        reviews will appear on your landing page.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($allReviews as $review)
                            <div class="review-card bg-white border border-gray-200 rounded-lg overflow-hidden cursor-pointer 
                                    {{ in_array($review->id, old('featured_reviews', $reviewSettings->featured_reviews ?? [])) ? 'selected' : '' }}"
                                onclick="toggleSelection(this, '{{ $review->id }}')">

                                
                                <input type="checkbox" name="featured_reviews[]" value="{{ $review->id }}"
                                    class="hidden" @checked(in_array($review->id, old('featured_reviews', $reviewSettings->featured_reviews ?? [])))>

                                <!-- Review Image -->
                                <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if ($review->image)
                                        <img src="{{ asset('storage/reviews/' . $review->image) }}" alt="Review Image"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Review Content -->
                                <div class="p-4">
                                    <div class="flex items-center mb-2">
                                        <div class="star-rating flex">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $review->rating)
                                                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 fill-current text-gray-300"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                                    </div>

                                    <p class="text-gray-700 mb-3 line-clamp-3">{{ Str::limit($review->review, 120) }}
                                    </p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span class="text-gray-600 font-medium">{{ $review->user->first_name }} {{ $review->user->last_name }}</span> 
                                    </div>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>{{ $review->created_at->format('M d, Y') }}</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs"
                                            id="selected-badge-{{ $review->id }}"
                                            style="display: {{ in_array($review->id, old('featured_reviews', $reviewSettings->featured_reviews ?? [])) ? 'block' : 'none' }}">
                                            Selected
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4 border-t border-gray-200 flex justify-end"> 
                                    <button type="button" onclick="deleteReview(event, '{{ $review->id }}')" 
                                        class="text-red-600 hover:text-red-800 flex items-center text-sm transition-colors"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"  
                                            viewBox="0 0 24 24" stroke="currentColor"> 
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /> 
                                        </svg> 
                                        Delete Review 
                                    </button> 
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('featured_reviews')
                        <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Save Settings
                    </button>
                </div>
            </form>
            <form id="delete-review-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    <script>
        function deleteReview(event, reviewId) {
            event.stopPropagation(); 
            event.preventDefault();  
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('reviews.destroy', ':review') }}'.replace(':review', reviewId);

        
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
        
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
        
                    // Append form to body and submit it
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        </script>
    <script>
        function toggleSelection(card, reviewId) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            const badge = document.getElementById(`selected-badge-${reviewId}`);

            if (checkbox.checked) {
                checkbox.checked = false;
                card.classList.remove('selected');
                badge.style.display = 'none';
            } else {
                checkbox.checked = true;
                card.classList.add('selected');
                badge.style.display = 'block';
            }
        }

        function selectAllCards() {
            document.querySelectorAll('.review-card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const reviewId = checkbox.value;
                const badge = document.getElementById(`selected-badge-${reviewId}`);

                checkbox.checked = true;
                card.classList.add('selected');
                badge.style.display = 'block';
            });
        }

        function deselectAllCards() {
            document.querySelectorAll('.review-card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const reviewId = checkbox.value;
                const badge = document.getElementById(`selected-badge-${reviewId}`);

                checkbox.checked = false;
                card.classList.remove('selected');
                badge.style.display = 'none';
            });
        }
    </script>
</body>

</html>
