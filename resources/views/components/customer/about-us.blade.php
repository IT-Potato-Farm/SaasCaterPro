@php
    $about = \App\Models\AboutUsSection::first();
@endphp
<section id="aboutus" class="w-full py-12 md:py-20 lg:py-28 px-5 sm:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16 xl:gap-20">
            <!-- Image Column -->
            <div class="w-full lg:w-1/2 flex justify-center lg:justify-end">
                @if ($about->background_image)
                    <div class="relative w-full max-w-lg">
                        <img src="{{ asset( $about->background_image) }}" alt="About Background"
                            class="w-full h-auto rounded-2xl shadow-xl object-cover transition-all duration-500 hover:shadow-2xl"
                            loading="lazy">
                        <div class="absolute -inset-4 -z-10 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl opacity-70"></div>
                    </div>
                @else
                    <div class="w-full max-w-lg h-64 md:h-80 flex flex-col items-center justify-center bg-gray-50 rounded-2xl shadow-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-500 text-lg">No image available</span>
                    </div>
                @endif
            </div>
            
            <!-- Content Column -->
            <div class="w-full lg:w-1/2">
                <div class="max-w-lg mx-auto lg:mx-0">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $about->title ?? 'About Us' }}
                    </h2>
                    <div class="prose prose-lg text-gray-600 max-w-none">
                        <p class="leading-relaxed mb-6">
                            {{ $about->description ?? '' }}
                        </p>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
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
