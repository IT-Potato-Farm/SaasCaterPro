@php
    $hero = \App\Models\HeroSection::first();
@endphp

<section class="relative bg-cover bg-center bg-no-repeat" 
    style="background-image: url('{{ asset($hero->background_image ?? 'images/sectionhero.jpg') }}'); min-height: 50vh sm:min-h-[60vh] md:min-h-[70vh] lg:min-h-[100vh]">
    <div class="absolute bg-black bg-opacity-50 inset-0"></div> 
    <div class="relative z-10 px-4 mx-auto max-w-screen-xl text-center py-8 sm:py-12 md:py-16 lg:py-24">
        <h1 class="text-5xl font-normal tracking-tight text-white sm:text-7xl md:text-8xl lg:text-[14rem]">
            {{ $hero->title ?? 'SAAS' }}
        </h1>
        <p class="mb-3 text-base font-medium tracking-tight leading-snug text-white sm:text-xl sm:mb-4 md:text-2xl lg:text-3xl">
            {{ $hero->subtitle ?? 'CATERING AND FOOD SERVICES' }}
        </p>
        <p class="mb-3 text-base font-medium tracking-tight leading-snug text-white sm:text-xl sm:mb-4 md:text-2xl lg:text-3xl">
            {{ $hero->description ?? 'Offers an exquisite goodness taste of Halal Cuisine' }}
        </p>
    </div>
</section>