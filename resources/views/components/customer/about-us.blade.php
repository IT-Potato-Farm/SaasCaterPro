@php
    $about = \App\Models\AboutUsSection::first();
@endphp
<section id="aboutus"
    class="w-full py-8 md:py-12 lg:py-16 px-4 sm:px-6 md:px-8 lg:px-24 bg-white min-h-[50vh] flex items-center justify-center">
    <div class="max-w-4xl mx-auto lg:text-center">
        <div class="flex justify-center mb-6">
            {{-- img --}}
            @if ($about->background_image)
                <img src="{{ asset('storage/' . $about->background_image) }}" alt="About Background"
                    class="max-w-full w-64 h-auto rounded-lg shadow-md object-cover">
            @else
                <div class="w-64 h-40 flex items-center justify-center bg-gray-100 text-gray-500 rounded-lg shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7l6 6-6 6M21 7l-6 6 6 6" />
                    </svg>
                    <span class="ml-2 text-sm">No image available</span>
                </div>
            @endif
        </div>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6 lg:text-center">
            {{ $about->title ?? 'About Us' }}
        </h2>
        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
            {{ $about->description ?? '' }}
        </p>

    </div>
</section>

{{-- <section id="aboutus" class="flex flex-col items-center justify-center text-center bg-white min-h-[50vh]">
    <div class="max-w-xl">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-6">{{$about->title ?? 'About Us'}}</h2>
        <p class="text-lg text-gray-700 leading-relaxed ">
            Welcome to <span class="font-semibold text-blue-600">SaasCaterPro</span>, your premier choice for exquisite food catering services.
            With a passion for flavors and a commitment to excellence, we specialize in crafting delicious, high-quality meals
            tailored to your events. Whether it's a wedding, corporate gathering, or private party, our team ensures an
            unforgettable dining experience. Let us bring the perfect taste to your special occasions!
        </p>
    </div>
</section> --}}
