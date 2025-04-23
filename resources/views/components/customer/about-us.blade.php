
@php
    $about = \App\Models\AboutUsSection::first();
@endphp
<section id="aboutus" class="flex flex-col items-center justify-center text-center bg-white min-h-[50vh]">
    <div class="max-w-xl">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-6">{{$about->title ?? 'About Us'}}</h2>
        <p class="text-lg text-gray-700 leading-relaxed ">
            {{$about->description }}
            {{-- {{ optional($about)->description ?? 'Testingg' }} --}}
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

