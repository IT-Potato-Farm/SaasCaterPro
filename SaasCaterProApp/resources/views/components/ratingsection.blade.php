<div class="ratingcardholder flex p-4 mt-5 justify-center gap-8 min-h-[50vh] mx-10">
    @php
        $cards = [
            'Consistent Customer Satisfaction',
            'High Quality Ingredient',
            'Excellent Customer Service',
            'Over 100 Delighted Dishes',
            'Health And Safety Compliance'
        ];
    @endphp

    @foreach($cards as $title)
    <div class="block max-w-sm p-6 h-48 w-65 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-center mb-2">
            <img src="{{ asset('images/star.svg') }}" class="h-8" alt="Star Icon">
        </div>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
            {{ $title }}
        </h5>
    </div>
    @endforeach
</div>