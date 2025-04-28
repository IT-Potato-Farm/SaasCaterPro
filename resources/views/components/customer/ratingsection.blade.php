@php
    $reviewSettings = \App\Models\ReviewSectionSetting::first();
@endphp

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.review-carousel', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 40
                }
            }
        });
    });
</script>
<section class="py-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6"> <!-- Increased container width for horizontal layout -->
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $reviewSettings->title ?? 'Customer Reviews' }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Reviews Slider -->
        <div class="relative">
            @if ($reviews->isEmpty())
                <p class="text-gray-600 dark:text-gray-400 text-center py-8">No reviews yet. Be the first to leave a
                    review!</p>
            @else
                @php
                    $maxDisplay = $reviewSettings->max_display ?? 10;
                    $featuredReviews = $reviewSettings->featured_reviews ?? [];
                    
                    // If featured reviews are set, use those, otherwise use all reviews
                    $filteredReviews = !empty($featuredReviews) 
                        ? $reviews->whereIn('id', $featuredReviews)->take($maxDisplay)
                        : $reviews->take($maxDisplay);
                @endphp

                <!-- Slider Container -->
                <div class="review-carousel swiper overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($filteredReviews as $review)
                            <div class="swiper-slide p-2">
                                <!-- Fixed height container -->
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md h-96">
                                    <!-- Responsive layout: Vertical on mobile, Horizontal on larger screens -->
                                    <div class="flex flex-col md:flex-row h-full">
                                        <!-- Review Image - Takes full width on mobile, left side (40%) on larger screens -->
                                        @if ($reviewSettings->show_images ?? true)
                                            <div class="w-full md:w-2/5 h-40 md:h-full">
                                                @if ($review->image)
                                                    <img src="{{ asset('storage/reviews/' . $review->image) }}"
                                                        class="w-full h-full object-cover object-center"
                                                        alt="Review Image" loading="lazy">
                                                @else
                                                    <div class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                
                                        {{-- REVIEW LAYOUT CONTAINER --}}
                                        <div class="p-4 w-full md:w-3/5 flex flex-col">
                                            
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center">
                                                    @if ($review->user->avatar)
                                                        <img src="{{ asset('storage/' . $review->user->avatar) }}"
                                                            alt="{{ $review->user->first_name }}"
                                                            class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover mr-3" 
                                                            loading="lazy">
                                                    @else
                                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 text-sm font-medium mr-3">
                                                            {{ substr($review->user->first_name, 0, 1) }}{{ substr($review->user->last_name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h4 class="text-base md:text-lg font-medium text-gray-900 dark:text-white">
                                                            {{ $review->user->first_name }} {{ $review->user->last_name }}
                                                        </h4>
                                                    </div>
                                                </div>
                                                
                                                <!-- Rating -->
                                                <div class="flex items-center">
                                                    <span class="text-2xl md:text-3xl font-medium text-gray-700 dark:text-gray-300 mr-2">
                                                        {{ $review->rating }}.0
                                                    </span>
                                                    <svg class="h-6 w-6 md:h-7 md:w-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        
                                            <!-- Review Text -->
                                            <div class="flex-grow mb-4 overflow-y-auto">
                                                <blockquote class="text-base md:text-lg lg:text-xl text-gray-600 dark:text-gray-300 italic leading-relaxed">
                                                    "{{ $review->review }}"
                                                </blockquote>
                                            </div>
                                        
                                            <!-- Date -->
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-auto">
                                                {{ $review->created_at->format('M j, Y') }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                

                    <!-- Slider Pagination -->
                    <div class="swiper-pagination mt-6"></div>
                </div>

                <!-- Navigation Arrows -->
                <div class="swiper-button-next after:text-blue-600 !right-0 lg:!right-4"></div>
                <div class="swiper-button-prev after:text-blue-600 !left-0 lg:!left-4"></div>
            @endif
        </div>

        <!-- View All Button -->
        <div class="text-center mt-8">
            <a href="{{route('all.reviews')}}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                View All Reviews
                <svg class="ml-1.5 -mr-0.5 w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

