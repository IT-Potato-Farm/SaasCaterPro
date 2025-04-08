<div class="ratingcardholder grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 mt-5 gap-6 min-h-[50vh] mx-auto max-w-7xl">
    @if($reviews->isEmpty())
        <p class="text-lg text-gray-600 text-center col-span-full">No reviews yet. Be the first to leave a review!</p>
    @else
        @foreach($reviews as $review)
        <div class="relative p-6 w-full bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 dark:bg-gray-800 dark:border-gray-700">
            <!-- stars -->
            <div class="flex justify-center mb-4 gap-1.5">
                @for($i = 1; $i <= $review->rating; $i++)
                    <img src="{{ asset('images/' . $star ) }}" class="h-6 w-6 text-yellow-400" alt="Star">
                @endfor
            </div>

            <!-- review img -->
            <div class="flex justify-center mb-4">
                @if($review->image)
                    <img src="{{ asset('reviews/' . $review->image) }}" 
                         class="h-40 w-full object-cover rounded-lg shadow-sm hover:scale-105 transition-transform duration-200"
                         alt="Review Image">
                @else
                    <div class="h-40 w-full bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm flex items-center justify-center">
                        <svg class="w-12 h-12 stroke-gray-300 dark:stroke-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- txt-->
            <div class="text-center">
                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-4 italic">
                    "{{ $review->review }}"
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Rated {{ $review->rating }}/5
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>