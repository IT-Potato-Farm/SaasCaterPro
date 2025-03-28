
<div class="ratingcardholder flex p-4 mt-5 justify-center gap-8 min-h-[50vh] mx-10">
    @if($reviews->isEmpty())
        <p class="text-gray-600 text-center">No reviews yet. Be the first to leave a review!</p>
    @else
        @foreach($reviews as $review)
        <div class="block max-w-sm p-6 h-auto w-65 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-center mb-2">
                <img src="{{ asset('images\star.svg') }}" class="h-8" alt="Star Icon">
            </div> 
            
            <p class="text-center text-gray-600">Rating: {{ $review->rating }} </p>

            @if($review->image)
                <div class="flex justify-center mb-2">
                    <img src="{{ asset('reviews/' . $review->image) }}" class="h-32 w-auto rounded-lg shadow-md" alt="Review Image">
                </div>
                
            @endif

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                {{ $review->review }}
            </h5>
           
        </div>
        @endforeach
    @endif
</div>