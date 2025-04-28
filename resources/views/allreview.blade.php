<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-800">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-900 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Customer Reviews</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">What our customers say about us</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="flex items-center">
                            <div class="mr-2 text-primary-600 dark:text-primary-400">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($averageRating, 1) }}/5</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Based on {{ $reviews->count() }}
                                    reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div
                class="mb-8 bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                <div class="flex flex-col items-center sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search reviews</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <input type="text" name="search" id="search"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 pr-12 py-2 border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-800 dark:text-white"
                                placeholder="Search reviews...">
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div>
                            <label for="sort" class="sr-only">Sort by</label>
                            <select id="sort" name="sort"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-md dark:bg-gray-800 dark:text-white">
                                <option>Newest First</option>
                                <option>Oldest First</option>
                                <option>Highest Rated</option>
                                <option>Lowest Rated</option>
                            </select>
                        </div>
                        <div>
                            <label for="rating-filter" class="sr-only">Filter by rating</label>
                            <select id="rating-filter" name="rating-filter"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-md dark:bg-gray-800 dark:text-white">
                                <option value="">All Ratings</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                    </div>
                    <button id="refresh-filters"
                        class="items-center bg-blue-500 dark:bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none">
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- Reviews Grid -->
            <div id="reviews-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($reviews as $review)
                    <div class="review-card bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600 overflow-hidden hover:shadow-md transition-shadow duration-300"
                        data-rating="{{ $review->rating }}" data-date="{{ $review->created_at }}">

                        <!-- Review Header -->
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    @if ($review->user->profile_photo)
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ asset('storage/' . $review->user->profile_photo) }}"
                                            alt="{{ $review->user->name }}">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span
                                                class="text-primary-600 font-medium">{{ substr($review->user->first_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <p class="user-name text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $review->user->first_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star text-yellow-400"></i>
                                        @else
                                            <i class="far fa-star text-yellow-400"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <!-- Review Content -->
                        <div class="px-6 pb-4">
                            <p class="review-text text-gray-700 dark:text-gray-300 mb-4">{{ $review->review }}</p>

                            @if ($review->image)
                                <div class="mt-3">
                                    <img src="{{ $review->image ? asset('storage/reviews/' . $review->image) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Unlink_icon.svg/1024px-Unlink_icon.svg.png' }}"
                                        alt="Review image"
                                        class="rounded-lg w-full h-48 object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                        onclick="openImageModal('{{ $review->image ? asset('storage/reviews/' . $review->image) : 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Unlink_icon.svg/1024px-Unlink_icon.svg.png' }}')">
                                </div>
                            @endif
                        </div>

                        <!-- Review Footer -->
                        <div
                            class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-600">
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>Order #{{ $review->order_id }}</span>
                                <button
                                    class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-500 flex items-center">
                                    <i class="far fa-flag mr-1"></i> Report
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($reviews->hasPages())
                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @endif

            <!-- Empty State -->
            @if ($reviews->isEmpty())
                <div class="text-center py-12">
                    <div
                        class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-600 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-comment-slash text-gray-400 dark:text-gray-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No reviews yet</h3>
                    <p class="text-gray-500 dark:text-gray-300">Be the first to leave a review after your purchase!</p>
                </div>
            @endif
        </main>
        <div class="text-center mt-8">
            <a href="{{ route('landing') }}"
                class="inline-block px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-lg transition duration-300 ease-in-out">
                Go to Landing Page
            </a>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Review Image
                                </h3>
                                <button type="button" onclick="closeImageModal()"
                                    class="text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <img id="modal-image" src="" alt="Full size review image" class="w-full h-auto max-h-[70vh] object-contain">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const sortSelect = document.getElementById('sort');
            const ratingFilter = document.getElementById('rating-filter');
            const reviewCards = document.querySelectorAll('.review-card');

            function filterReviews() {
                const searchTerm = searchInput.value.toLowerCase();
                const sortValue = sortSelect.value;
                const ratingValue = ratingFilter.value;

                let reviews = Array.from(reviewCards);

                // Filter by search
                reviews.forEach(card => {
                    const reviewText = card.querySelector('.review-text').innerText.toLowerCase();
                    const userName = card.querySelector('.user-name').innerText.toLowerCase();
                    const matchesSearch = reviewText.includes(searchTerm) || userName.includes(searchTerm);

                    const rating = card.getAttribute('data-rating');
                    const matchesRating = ratingValue === "" || rating === ratingValue;

                    if (matchesSearch && matchesRating) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Sort
                reviews = reviews.filter(card => card.style.display === 'block');
                if (sortValue === "Newest First") {
                    reviews.sort((a, b) => new Date(b.dataset.date) - new Date(a.dataset.date));
                } else if (sortValue === "Oldest First") {
                    reviews.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
                } else if (sortValue === "Highest Rated") {
                    reviews.sort((a, b) => b.dataset.rating - a.dataset.rating);
                } else if (sortValue === "Lowest Rated") {
                    reviews.sort((a, b) => a.dataset.rating - b.dataset.rating);
                }

                const grid = document.getElementById('reviews-grid');
                reviews.forEach(card => {
                    grid.appendChild(card);
                });
            }

            searchInput.addEventListener('input', filterReviews);
            sortSelect.addEventListener('change', filterReviews);
            ratingFilter.addEventListener('change', filterReviews);

            // Refresh Filters
            document.getElementById('refresh-filters').addEventListener('click', function() {
                searchInput.value = '';
                sortSelect.value = 'Newest First';
                ratingFilter.value = '';
                filterReviews();
            });
        });

        function openImageModal(imageUrl) {
            const modal = document.getElementById('image-modal');
            const modalImage = document.getElementById('modal-image');
            const placeholder = 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
            const img = new Image();

            img.onload = function() {
                modalImage.src = imageUrl;
            };
            img.onerror = function() {
                modalImage.src = placeholder;
            };

            img.src = imageUrl;
            modal.classList.remove('hidden');
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            modal.classList.add('hidden');
        }
    </script>


</body>

</html>
