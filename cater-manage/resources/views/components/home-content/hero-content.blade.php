<section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/' . $bacimg) }}'); min-height: 100vh;">
    <div class="absolute bg-black bg-opacity-50 inset-0"></div> 
    <div class="relative z-10 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
        <h1 class="text-8xl font-normal tracking-tight md:text-[16rem] lg:text-[14rem]"
        style = "color: {{ $tecc }}">
            {{ $title }}
        </h1>
        <p class="mb-4 text-lg font-medium tracking-tight leading-snug md:text-2xl lg:text-3xl"
        style = "color: {{ $tecc }}">
            {{ $heading }}
        </p>
        <p class="mb-4 text-lg font-medium tracking-tight leading-snug md:text-2xl lg:text-3xl"
        style = "color: {{ $tecc }}">
            {{ $description }}
        </p>
    </div>
</section>