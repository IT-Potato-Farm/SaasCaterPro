@php
    $hero = \App\Models\HeroSection::first();
@endphp

<section class="relative bg-cover bg-center bg-no-repeat" 
    style="background-image: url('{{ asset($hero->background_image ?? 'images/sectionhero.jpg') }}'); min-height: 100vh;">
    <div class="absolute bg-black bg-opacity-50 inset-0"></div> 
    <div class="relative z-10 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
        <h1 class="text-8xl font-normal tracking-tight text-white md:text-[16rem] lg:text-[14rem]">
            {{ $hero->title ?? 'SAAS' }}
        </h1>
        <p class="mb-4 text-lg font-medium tracking-tight leading-snug text-white md:text-2xl lg:text-3xl">
            {{ $hero->subtitle ?? 'CATERING AND FOOD SERVICES' }}
        </p>
        <p class="mb-4 text-lg font-medium tracking-tight leading-snug text-white md:text-2xl lg:text-3xl">
            {{ $hero->description ?? 'Offers an exquisite goodness taste of Halal Cuisine' }}
        </p>
    </div>
</section>

