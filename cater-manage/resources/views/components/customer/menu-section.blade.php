<section id="menu" class="menu-section py-12 min-h-screen">
    <h2 class="text-center font-bold text-4xl md:text-5xl lg:text-6xl mt-2 px-4">MENU</h2>
    
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($packages as $package)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full">
                <a href="#">
                    <img class="w-full h-48 object-cover rounded-t-lg" src="{{ asset('ItemsStored/' . $package->image) }}" alt="{{ $package->name }}" />
                </a>
                <div class="p-4 flex-grow flex flex-col">
                    <p class="font-extrabold text-gray-700 dark:text-gray-400">
                        {{ $package->name }}
                    </p>
                    <p class="mt-2 text-gray-700 dark:text-gray-400 flex-grow">
                        {{ $package->description }}
                    </p>
                    <p class="mt-2 text-gray-700 dark:text-gray-400 font-medium">
                        Price: ₱{{ $package->price }}
                    </p>
                    <div class="mt-4 flex justify-center">
                        <button onclick="showMenuModal()" type="button" 
                                class="menu-detail-btn w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 transition-colors duration-200"
                                data-package="{{ $package->id }}">
                            Show Details
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-center mt-8">
        <a href="{{ url('/all-menus') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 inline-flex items-center transition-colors duration-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Show All Menus
        </a>
    </div>
</section>