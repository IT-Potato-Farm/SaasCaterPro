@php
    $choose = \App\Models\WhyChooseUsSection::first();
@endphp
<section class="w-full py-8 md:py-12 lg:py-16 px-4 sm:px-6 md:px-8 lg:px-24 bg-white">
    <div class="max-w-4xl mx-auto lg:text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6 lg:text-center">
            {{$choose->title ?? 'WHY CHOOSE US'}}
        </h2>
        <h3 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-normal text-gray-900 mb-4 sm:mb-6">
            {{$choose->subtitle ?? 'The all-in-one solution for effortless order tracking and customer engagement services in Zamboanga City'}}
        </h3>
        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
            {{$choose->description ?? 'We are more than just your typical catering company at Saas. We are committed to turning your visions into reality. Our goal is to help create an incomparable experience by going above and beyond through our food offerings, service, and styling that is tailored to your taste and budget without skimping on quality.'}}
        </p>
    </div>
</section>