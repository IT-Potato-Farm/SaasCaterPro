@php
    $hero = \App\Models\HeroSection::first();
    $backgroundImage = $hero->background_image ?? 'images/sectionhero.jpg';
@endphp

<section 
    class="relative bg-cover bg-center bg-no-repeat flex items-center"
    style="background-image: url('{{ asset($backgroundImage) }}');"
    aria-label="Hero section">
    
    {{-- Dark overlay --}}
    <div class="absolute bg-black bg-opacity-50 inset-0"></div>
    
    {{-- Content container --}}
    <div class="relative z-10 w-full px-4 mx-auto max-w-screen-xl text-center py-12 sm:py-16 md:py-20 lg:py-28">
        <h1 class="mb-2 text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl lg:text-8xl xl:text-9xl animate-fade-in">
            {{ $hero->title ?? 'SAAS' }}
        </h1>
        
        <p class="mb-4 text-lg font-medium text-white sm:text-xl md:text-2xl lg:text-3xl animate-fade-in-delayed">
            {{ $hero->subtitle ?? 'CATERING AND FOOD SERVICES' }}
        </p>
        
        <p class="mb-6 text-base font-normal text-white/90 max-w-3xl mx-auto sm:text-lg md:text-xl lg:text-2xl animate-fade-in-delayed-more">
            {{ $hero->description ?? 'Offers an exquisite goodness taste of Halal Cuisine' }}
        </p>
        
        {{-- @if(isset($hero->cta_text))
        <div class="mt-8 animate-fade-in-delayed-most">
            <a href="{{ $hero->cta_link ?? '#' }}" 
               class="px-6 py-3 text-base font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 transition-colors duration-300 inline-flex items-center gap-2">
                {{ $hero->cta_text }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
        @endif --}}
    </div>
</section>

<style>
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-fade-in-delayed {
        animation: fadeIn 0.8s ease-out 0.3s both;
    }
    
    .animate-fade-in-delayed-more {
        animation: fadeIn 0.8s ease-out 0.6s both;
    }
    
    .animate-fade-in-delayed-most {
        animation: fadeIn 0.8s ease-out 0.9s both;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>